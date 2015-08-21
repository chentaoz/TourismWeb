<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: james
 * Date: 14-12-17
 * Time: 上午10:53 户外活动控制器
 */
class Sports extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('sports_model','sports');
    }
    //户外活动管理界面
    public function index(){
        $data=$this->common->setConfig($this->common->configs,array('global.css','sports.css'),$this->common->js);
        $l=$this->input->post('language');
        $key =$this->input->post('key_name');//查询的名字
        $url='sports/index';
        $default=array('page','keyword','l');
        $url_data=$this->uri->uri_to_assoc(3,$default);
        $keyword=$key?$key:urldecode($url_data['keyword']);
        $lan=$l?$l:urldecode($url_data['l']);
        $url=base_url(index_page().'/'.$url);//配置组装URL完成
        if($keyword){//判断是否是搜索
            $url.='/keyword/'.$keyword;
        }
        if($lan){//判断是否是搜索
            $url.='/l/'.$lan;
        }
        $url.='/page/';
        $this->load->library('pagination');//加载分页
        $rows =$this->sports->key_rows('sport',$keyword,$lan);//有搜索的时候总数据个数
        $segment=intval(array_search('page',$this->uri->segment_array())+1);//url的截取片段
        $config=$this->common->pageConfig($url,$rows,50,$segment);//分页配置
        $this->pagination->initialize($config);//分页可以输出
        $data['l']=$lan;
        $data['keyword']=$keyword;
        $data['sports_list']=$this->sports->sports_list($lan,$keyword,$config['per_page'],  $this->uri->segment($config['uri_segment']));//分页后的数据

        $this->load->view('sports/manager',$data);
    }
    //户外活动管理添加界面
    public function sports_add(){
        $data=$this->common->setConfig($this->common->configs,array('global.css','sports.css'),$this->common->js);

        $data['level']= $this->sports->connect_table('taxonomy_term.ttid,tid,name',array('tid'=>1,'parent'=>0),$order='weight','taxonomy_term','taxonomy_term_hierarchy','taxonomy_term.ttid=taxonomy_term_hierarchy.ttid');//1. 级别

        $data['list']= $this->sports->connect_table('taxonomy_term.ttid,tid,name',array('tid'=>2,'parent'=>0,'category !='=>1),$order='weight','taxonomy_term','taxonomy_term_hierarchy','taxonomy_term.ttid=taxonomy_term_hierarchy.ttid');//2. 清单

        $data['people']= $this->sports->connect_table('taxonomy_term.ttid,tid,name',array('tid'=>3,'parent'=>0),$order='weight','taxonomy_term','taxonomy_term_hierarchy','taxonomy_term.ttid=taxonomy_term_hierarchy.ttid');//3. 人员

        $data['tip']= $this->sports->connect_table('taxonomy_term.ttid,tid,name',array('tid'=>4,'parent'=>0),$order='weight','taxonomy_term','taxonomy_term_hierarchy','taxonomy_term.ttid=taxonomy_term_hierarchy.ttid');//4. 标签
        $this->load->view('sports/add',$data);
    }
   //户外活动保存数据
    public function sports_save(){

        $c_name=trim($this->input->post('c_name'));
        $e_name=trim($this->input->post('e_name'));
        $alias=trim($this->input->post('alias'));
        $tid=intval($this->input->post('level'));//级别的ID
        $lid=intval($this->input->post('list'));//清单的ID
        $pid=intval($this->input->post('people'));//人员的ID
        $tag=$this->input->post('tip');//标签数组
        $img=$_FILES['icon']['name'];
        $desc=$this->input->post('desc');
        $order=intval(trim($this->input->post('order')));
        $data=array();
        if($c_name=='' || $e_name=='' || $order==''||$img=='' ||$tid<=0){
            message($this->lang->line('failure'),'sports/sports_add');
        }
        //上传图片
        $config=array('upload_path'=>ROOTPATH.$this->config->item('upload_sports_icon'),'allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>false);
        $this->load->library('upload',$config);
        if ($this->upload->do_upload('icon')) {
            $img=$this->upload->data();
            $data['img']=$img['file_name'];
        }
        //收集数据添加数据库
        $data['name']=$c_name;
        $data['name_en']=$e_name;
        $data['alias']=$alias;
        $data['description']=$desc;
        $data['weight']=$order;
        $res=$this->sports->add('sport',$data,$tid,$pid,$lid,$tag);//添加数据
        if($res){
           message($this->lang->line('success'),'sports/sports_add');
        }else{
          message('失败请检查是否有重复的名字数据！','sports/sports_add');
        }
    }
   //活动的修改
   public function sports_edit(){

       if($_POST){//提交修改
           $id=intval($this->input->post('sp_id'));
           $c_name=trim($this->input->post('c_name'));
           $e_name=trim($this->input->post('e_name'));
           $alias=trim($this->input->post('alias'));
           $desc=$this->input->post('desc');
           $tid=intval($this->input->post('level'));//级别的ID
           $lid=intval($this->input->post('list'));//清单的ID
           $pid=intval($this->input->post('people'));//人员的ID
           $tag=$this->input->post('tip');//标签数组
           $order=intval(trim($this->input->post('order')));
           $data=array();
           if($c_name=='' || $e_name=='' || $order=='' || $tid<=0 || $lid<=0 || $pid<=0){
               message($this->lang->line('failure'),'sports/sports_add');
           }
           //上传图片
           $config=array('upload_path'=>ROOTPATH.$this->config->item('upload_sports_icon'),'allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>false);
           $this->load->library('upload',$config);
           if ($this->upload->do_upload('icon')) {
               $img=$this->upload->data();
               $data['img']=$img['file_name'];
           }
           //收集数据添加数据库
           $data['name']=$c_name;
           $data['name_en']=$e_name;
           $data['alias']=$alias;
           $data['description']=$desc;
           $data['weight']=$order;
           //收集属性数据
           $num=1;
           $attrs=array();
           $attrs_order=array();
           $attrs_id=array();
           while(isset($_POST['add_attr_'.$num])){
               $attrs[]=trim($this->input->post('add_attr_'.$num));
               $attrs_order[]=$this->input->post('add_attr_order'.$num);
               $attrs_id[]=-1;
               $num++;
           }
           $num=1;
           while($this->input->post('own_attr_'.$num)){
               $attrs[]=trim($this->input->post('own_attr_'.$num));
               $attrs_order[]=$this->input->post('own_attr_order'.$num);
               $attrs_id[]=$this->input->post('own_attr_id'.$num);
               $num++;
           }

           $res=$this->sports->up_sports($id,$data,$tid,$lid,$pid,$tag,$attrs,$attrs_order,$attrs_id);
           if($res){
               message($this->lang->line('success'),'sports');
           }else{
               message($this->lang->line('failure'),'sports');
           }

       }else{
      $id= intval($this->uri->segment(3));//获取id
      if($id<=0){
          message($this->lang->line('failure'),'sports');
      }
       //获取单个数据
       $data=$this->common->setConfig($this->common->configs,array('global.css','sports.css'),$this->common->js);
       $data['sports_one']= $this->sports->get_sports_info($id);
       $data['url']=$this->default_url();
//       $data['level']=$this->all_data('taxonomy_term','ttid,tid,name',array('tid'=>1));//1. 级别
//       $data['list']=$this->all_data('taxonomy_term','ttid,tid,name',array('tid'=>2));//2. 清单
//       $data['people']=$this->all_data('taxonomy_term','ttid,tid,name',array('tid'=>3));//3. 人员
//       $data['tip']=$this->all_data('taxonomy_term','ttid,tid,name',array('tid'=>4));//4. 标签

           $data['level']= $this->sports->connect_table('taxonomy_term.ttid,tid,name',array('tid'=>1,'parent'=>0),$order='weight','taxonomy_term','taxonomy_term_hierarchy','taxonomy_term.ttid=taxonomy_term_hierarchy.ttid');//1. 级别

           $data['list']= $this->sports->connect_table('taxonomy_term.ttid,tid,name',array('tid'=>2,'parent'=>0,'category !='=>1),$order='weight','taxonomy_term','taxonomy_term_hierarchy','taxonomy_term.ttid=taxonomy_term_hierarchy.ttid');//2. 清单

           $data['people']= $this->sports->connect_table('taxonomy_term.ttid,tid,name',array('tid'=>3,'parent'=>0),$order='weight','taxonomy_term','taxonomy_term_hierarchy','taxonomy_term.ttid=taxonomy_term_hierarchy.ttid');//3. 人员

           $data['tip']= $this->sports->connect_table('taxonomy_term.ttid,tid,name',array('tid'=>4,'parent'=>0),$order='weight','taxonomy_term','taxonomy_term_hierarchy','taxonomy_term.ttid=taxonomy_term_hierarchy.ttid');//4. 标签

           $data['attrs_super']=$this->sports->connect_table('sport_attributes.attribute,sport_attributes.id,sport_attributes.order',array("sport_id"=>$id),$order='none','sport_attributes',0,0);
//           print_r( $data['attrs']);
//           exit;

       $this->load->view('sports/sports_edit',$data);
       }
   }
   //ajax 更改运动状态

   public function change_statues(){
       $data=array();
       $id=intval($this->input->post('id'));
       $sta=intval($this->input->post('status'));//获取状态
       $statue=array(0,1);
      if($id<=0){
        echo 0;//失败
          exit;
      }
       if(!in_array($sta,$statue)){
           echo 0;//失败
           exit;
       }
       if($sta==1){
           $data['sta']=0;
       }
       if($sta==0){
           $data['sta']=1;
       }
       $res=$this->sports->my_update('sport','spid',$id,$data);
       if($res){
            echo 1;
       }else{
           echo 0;
       }
   }
 //ajax简单删除的操作 banner 图片数据
  public function delete(){
      $id=intval($this->input->post('id'));//id
      if($id<=0){
          echo 0;//成功
          exit;
      }
      $res= $this->sports->true_delete('place_sport_images',array('psiid'=>$id,'place_id'=>0));
      if($res){
        echo 1;//成功
      }
  }
 /*
  * ajax update 删除运动项目
  * */
 public function up_delete(){
     $id=intval($this->input->post('id'));//id
     if($id<=0){
         echo 0;//成功
         exit;
     }
     $res= $this->sports->up_delete('sport',array('del'=>1),$Condition=array('spid'=>$id));
     if($res){
         echo 1;//成功
     }

 }
   /*******************运动banner 添加*****************************/
  /* banner 的管理
   * */
  public function banner_add(){
      if($_POST){//提交数据
          $data=array();
          $pid=trim($this->input->post('pid'));
          $order=trim($this->input->post('order'));
          $img=trim($_FILES['img']['name']);
          //上传图片
        if($order=='' || $img=''){
            message($this->lang->line('failure'),'sports/banner_add');

        }
          $config=array('upload_path'=>ROOTPATH.$this->config->item('upload_place_sport'),'allowed_types'=>'jpg|png|gif','overwrite'=>false,'encrypt_name'=>false);
          $this->load->library('upload',$config);
          if ($this->upload->do_upload('img')) {
              $img=$this->upload->data();
              $data['img']=$img['file_name'];
          }else{
            echo  $wrong = $this->upload->display_errors();

          }
           $data['weight']=$order;
           $data['sport_id']=$pid;
           //添加数据
          $res=$this->sports->banner_add('place_sport_images',$data);
          if($res){
              message($this->lang->line('success'),'sports/banner_add/'.$pid);
          }else{
              message($this->lang->line('failure'),'sports/banner_add/'.$pid);
          }

      }else{

          $sp_id=intval($this->uri->segment(3));//获取运动项目的ID
          if($sp_id<=0){
              message($this->lang->line('failure'),'sports/banner_add');
          }
          $data=$this->common->setConfig($this->common->configs,array('global.css','sports.css'),$this->common->js);
          //所有活动列表
          $data['sp_id']=$sp_id;//项目id;
          $data['sports']=$this->sports->get_one('sport','',array('spid'=>$sp_id));
          //获取这个活动项目下的所有banner
          $data['sports_banner']=$this->all_data('place_sport_images','',array('sport_id'=>$sp_id,'place_id'=>0));
          $data['url']=$this->default_url();;
          $this->load->view('sports/banner_add',$data);
      }

  }
  public function banner_edit(){
      if($_POST){
       //获取提交数据
          $data=array();
          $config=array('upload_path'=>ROOTPATH.$this->config->item('upload_place_sport'),'allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>false);
          $this->load->library('upload',$config);
          if ($this->upload->do_upload('img')) {
              $img=$this->upload->data();
              $data['img']=$img['file_name'];
          }
          $id=$this->input->post('b_id');
          $sid=$this->input->post('s_id');
          $data['weight']=intval($this->input->post('order'));
          $res= $this->sports->up_delete('place_sport_images',$data,array('psiid'=>$id));
          $f_url=$s_url='sports/banner_add/'.$sid;
          $this->my_messages($res,"操作成功","操作失败",$s_url,$f_url);
      }else{
          $id= intval($this->uri->segment(3));
          $data=$this->common->setConfig($this->common->configs,array('global.css','sports.css'),$this->common->js);
          $data['img_info']=$this->sports->get_one('place_sport_images',$filed='psiid,sport_id,img,weight',array('psiid'=>$id,'place_id'=>0));
          $data['url']=$this->default_url();
          $this->load->view('sports/banner_edit',$data);

      }
  }
/*****************运动攻略添加***************/
  public function guide_add(){
      if($_POST){
          $this->load->model('place_model','place');
          $p_level=$this->input->post('p_level');
          $title=$this->input->post('title');
          $version=$this->input->post('version');
          $pagenum=intval($this->input->post('pagenum'));
          $description=trim($this->input->post('description'));
          $weight=intval($this->input->post('weight'));
          $weight=$weight?$weight:255;
          $pid=intval($this->input->post('sp_id'));//运动id
          $level_id=intval($this->input->post('level'));//等级ID

          if($title=='' || $version=='' || $pagenum=='' || $description==''|| $pid<=0){
              message('操作有误','sports');
          }
          //收集数据
          $data=array('place_id'=>0,'title'=>$title,'version'=>$version,'weight'=>$weight,'pagenum'=>$pagenum,
              'description'=>$description,'typeid'=>1,'sport_id'=>$pid,'term_level_id'=>$level_id,'created'=>time(),'updated'=>time());

          //上传图片
          $Foldername = date("Ym",time());
          $Uploadpathimg = ROOTPATH.$this->config->item('upload_guide_image').'/'.$Foldername;
          $Uploadpathpdf = ROOTPATH.$this->config->item('upload_guide_pdf').'/'.$Foldername;

          $config=array('upload_path'=>$Uploadpathimg,'allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>true);
          $this->load->library('upload',$config);

          if (!file_exists($Uploadpathimg)){
              mkdir ($Uploadpathimg,0755,true);
          }

          if ($this->upload->do_upload('banner1')) {//上传封面
              $banner1=$this->upload->data();
              $data['img']=$Foldername.'/'.$banner1['file_name'];
          }

          if ($this->upload->do_upload('preview')) {//上传预览图
              $preview=$this->upload->data();
              $data['preview']=$Foldername.'/'.$preview['file_name'];
          }
          $this->load->library('upload');
          $config1['upload_path'] = $Uploadpathpdf;
          $config1['allowed_types'] ='pdf';
          $this->upload->initialize($config1);
          if (!file_exists($Uploadpathpdf)){
              mkdir ($Uploadpathpdf,0755,true);
          }
          if ($this->upload->do_upload('guide')){//上传PDF文件

              $guide=$this->upload->data();
              $data['filetype']=$guide['file_ext'];
              $data['filepath']=$Foldername.'/'.$guide['file_name'];
              $data['filesize']=$guide['file_size'];
          }else{
             echo $wrong = $this->upload->display_errors();

          }

          $r=$this->place->guide_save($data);
          $f_url=$s_url='sports/guide_add/'.$pid.'/'.$p_level;
          $this->my_messages($r,"操作成功","操作失败",$s_url,$f_url);

      }else{
      $data=$this->common->setConfig($this->common->configs,'global.css',array($this->common->js,'global.js'));
      $data['form']=form_open_multipart('sports/guide_add',array('id'=>'form'));
      //获取等级详情
       $id=intval($this->uri->segment(3));//运动id
       $level=intval($this->uri->segment(4));//等级的id
      //获取等级下面的具体分类
     // $data['level']= $this->all_data('taxonomy_term','ttid,name',array('del'=>0,'sta'=>0,'tid'=>$level));
      $data['level']= $this->sports->connect_table('taxonomy_term_hierarchy.ttid,tid,taxonomy_term.name',array('tid'=>1,'taxonomy_term_hierarchy.parent'=>$level),'weight','taxonomy_term','taxonomy_term_hierarchy','taxonomy_term.ttid=taxonomy_term_hierarchy.parent');//1. 级别
       //获取这个运动下面的攻略
      $data['guide']=$this->all_data('guide','gid,sport_id,term_level_id,sta,title,version,img,preview,description,weight,pagenum',array('sport_id'=>$id,'del'=>0,'sta'=>0));
      $data['p_level']=$level;
      $data['sp_id']=$id;
      $this->load->view('sports/guide_add',$data);
     }
  }
  /*
   * 删除攻略
   * */
  public function guide_delete(){
    $id=$this->input->post('gid');
    $res=$this->sports->my_update('guide','gid',$id,array('del'=>1));
    if($res){
         echo 1;
    }
  }
  /*编辑运动攻略
   * */
   public function guide_edit(){
   if($_POST){
       $this->load->model('place_model','place');
       $g_id=$this->input->post('guide_id');//攻略id
       $title=$this->input->post('title');
       $version=$this->input->post('version');
       $pagenum=intval($this->input->post('pagenum'));
       $description=trim($this->input->post('description'));
       $weight=intval($this->input->post('weight'));
       $weight=$weight?$weight:255;
       $level_id=intval($this->input->post('level'));//等级ID
       $sport_id=intval($this->input->post('sport_id'));//运动ID
       $pl_id=intval($this->input->post('pl_id'));//父等级ID
       if($title=='' || $version=='' || $pagenum=='' || $description==''){
           message('操作有误','sports');
       }
       //收集数据
       $data=array('title'=>$title,'version'=>$version,'weight'=>$weight,'pagenum'=>$pagenum,
           'description'=>$description,'term_level_id'=>$level_id,'updated'=>time());

       //上传图片
       $Foldername = date("Ym",time());
       $Uploadpathimg = ROOTPATH.$this->config->item('upload_guide_image').'/'.$Foldername;
       $Uploadpathpdf = ROOTPATH.$this->config->item('upload_guide_pdf').'/'.$Foldername;
       $config=array('upload_path'=>$Uploadpathimg,'allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>true);
       $this->load->library('upload',$config);
       if (!file_exists($Uploadpathimg)){
           mkdir ($Uploadpathimg,777,true);
       }
       if ($this->upload->do_upload('banner1')) {//上传封面
           $banner1=$this->upload->data();
           $data['img']=$Foldername.'/'.$banner1['file_name'];
       }
       if ($this->upload->do_upload('preview')) {//上传预览图
           $preview=$this->upload->data();
           $data['preview']=$Foldername.'/'.$preview['file_name'];
       }
       $this->load->library('upload');
       $config1['upload_path'] = $Uploadpathpdf;
       $config1['allowed_types'] ='pdf';
       $this->upload->initialize($config1);
       if (!file_exists($Uploadpathpdf)){
           mkdir ($Uploadpathpdf,777,true);
       }
       if($_FILES['guide']['name']){
               if ($this->upload->do_upload('guide')){//上传PDF文件
                   $guide=$this->upload->data();
                   $data['filetype']=$guide['file_ext'];
                   $data['filepath']=$Foldername.'/'.$guide['file_name'];
                   $data['filesize']=$guide['file_size'];
               }else{
                   echo $wrong = $this->upload->display_errors();

               }
        }
       $r=$this->place->guide_edit($data,$g_id);;
       $f_url=$s_url='sports/guide_add/'.$sport_id.'/'.$pl_id;
       $this->my_messages($r,"修改操作成功","修改操作失败",$s_url,$f_url);
   }else{
       $data=$this->common->setConfig($this->common->configs,'global.css',array($this->common->js,'global.js'));
       $data['form']=form_open_multipart('sports/guide_edit',array('id'=>'form'));

       $g_id=intval($this->uri->segment(3));//攻略运动id
       $sp_id=intval($this->uri->segment(4));//运动的id
       $fl_id=intval($this->uri->segment(5));//父级等级的id
       //获取此运动下面的具体分类等级
      //$data['level']=$this->sports->get_category($sp_id);
       $data['level']= $this->sports->connect_table('taxonomy_term_hierarchy.ttid,tid,taxonomy_term.name',array('tid'=>1,'taxonomy_term_hierarchy.parent'=>$fl_id),$order='weight','taxonomy_term','taxonomy_term_hierarchy','taxonomy_term.ttid=taxonomy_term_hierarchy.parent');//1. 级别
       //获取此攻略下面的信息数据

      $data['guide']= $this->sports->get_one('guide',$filed='*',$where=array('gid'=>$g_id));
      // var_dump($data['guide']);
      $data['level_id']=$fl_id;
       $this->load->view('sports/guide_edit',$data);
   }



   }

/*****************人员清单添加***************/
public function details(){
    if($_POST){
        $sport_id=intval($this->input->post('sport_id'));//运动ID
        $pid=intval($this->input->post('pid'));//人员大分类ID
        $lid=intval($this->input->post('lid'));//人员大分类ID
        $detail=$this->input->post();
        unset($detail['sport_id']);
        unset($detail['pid']);
        unset($detail['lid']);

        if($sport_id<=0 ||$pid<=0 || $lid<=0){
            message('操作有误','sports');
        }
        foreach($detail as $key=>$arr){//二维数组
               $person_id=intval(str_replace('p','',$key));//每个大类下面的人员ID
             if(is_array($arr)){
                 foreach($arr as $v){ //遍历添加数据 taxonomy_a_id:人员  taxonomy_b_id:清单
                    $data[]= array('sport_id'=>$sport_id,'taxonomy_a_id'=>$pid,'taxonomy_b_id'=>$lid,'term_a_id'=>$person_id,'term_b_id'=>$v);//组装二维数据批量添加
                 }
             };
        }
        $res= $this->sports->insert_batch('sport_term',$data,$sport_id);
        $f_url=$s_url='sports';
        $this->my_messages($res,"添加操作成功","添加操作失败",$s_url,$f_url);

    }else{
     $sport_id=intval($this->uri->segment(3));//获取运动项目的ID
       //获取此运动下面已经选取的人员  、清单 的ID 2.清单 3.人员
     $category=$this->sports->get_sports_c($sport_id);
         $pid=$category[1]['term_id'];//人员分类的id
         $lid= $category[0]['term_id'];//清单分类的id

     //根据两个大分类的id 查询下面包含的具体人员和清单
    $data=$this->common->setConfig($this->common->configs,'global.css',array($this->common->js));
    $data['list']=$this->all_data('taxonomy_term','ttid,tid,name',array('tid'=>$lid));

        $data['people']= $this->sports->connect_table('taxonomy_term_hierarchy.ttid,tid,taxonomy_term.name',array('tid'=>3,'taxonomy_term_hierarchy.parent'=>$pid),$order='weight','taxonomy_term','taxonomy_term_hierarchy','taxonomy_term.ttid=taxonomy_term_hierarchy.parent');//3.此分类下人员

        $data['list']= $this->sports->connect_table('taxonomy_term_hierarchy.ttid,tid,taxonomy_term.name',array('category !='=>1,'tid'=>2,'taxonomy_term_hierarchy.parent'=>$lid),$order='weight','taxonomy_term','taxonomy_term_hierarchy','taxonomy_term.ttid=taxonomy_term_hierarchy.parent');//2.此分类下清单

    $data['form']=form_open_multipart('sports/details',array('id'=>'form'));
    $data['sport_id']=$sport_id;//运动ID
    $data['pid']=$pid;//人员大分类ID
    $data['lid']=$lid;//人员大分类ID
    //根据运动ID获取人员清单
    $data['detail']=$this->all_data('sport_term','term_a_id,term_b_id',array('sport_id'=>$sport_id));
    $this->load->view('sports/details',$data);
    }
  }

}
