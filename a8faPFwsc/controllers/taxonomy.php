<?php
/**      数据字典分类管理
  * Created by PhpStorm.
 * User: james
 * Date: 14-12-22
 * Time: 上午11:08
 */
class Taxonomy extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $data=array();
        $this->load->model('sports_model','sports');
    }
    //一级分类列表
public function index(){
     $data=$this->common->setConfig($this->common->configs,array('global.css','place.css'),$this->common->js);
     //分类列表
    $data['category']= $this->sports->get_tree();
    $this->load->view('taxonomy/index',$data);
 }
/*
 * 添加子分类
 * */
 public function add_child(){
    if($_POST){//提交
       //获取数据
          $pid=intval($this->input->post('parent'));
          $lo=intval($this->input->post('lo'));
          $ppid=$lo?$lo:$pid;

       $name=trim($this->input->post('name'));
       $level=intval($this->input->post('level'));//分别不同的表
       $weight=intval($this->input->post('weight'));
        //-----------------james 获取类型
       $category=$this->input->post('category');
       $category=isset($category)? $category:0;
       $l_array=array(1,2);
       if(!in_array($level,$l_array)){
           message('添加失败','taxonomy');
       }

       $des=$this->input->post('description');
       if($name=='' ||$des==''|| $level==''){
           message('添加失败','taxonomy');
       }
        $term_data=array();//统一数据
        //上传图片
        if($_FILES['imgs']['name']){//如果有图片上传upload_taxonomy

        $config=array('upload_path'=>ROOTPATH.$this->config->item('upload_taxonomy'),'allowed_types'=>'png|jpg|jpeg','overwrite'=>false,'encrypt_name'=>false);
            $config['max_width']='50';
            $config['max_height']='50';
        $this->load->library('upload',$config);
            if ($this->upload->do_upload('imgs')) {
                $img=$this->upload->data();
                $term_data['img']=$img['file_name'];
            }else{
                 $wrong = $this->upload->display_errors();
                 message($wrong,'taxonomy/add_child/'.$pid.'/'.$level.'/'.$lo);
            }
        }
        $term_data['tid']=$ppid;
        $term_data['name']=$name;
        $term_data['description']=$des;
        $term_data['weight']=$weight;
        $term_data['category']=$category;
        $res=$this->sports->add_level($term_data,$level,$pid);
        $s_url=$f_url='taxonomy/add_child/'.$pid.'/'.$level.'/'.$lo;
        $this->my_messages($res,'','',$s_url,$f_url);

    }else{
        $pid=$this->uri->segment(3);
        $level=$this->uri->segment(4);//代表二级
        $level_one=$this->uri->segment(5);//代表一级父级
        $data=$this->common->setConfig($this->common->configs,array('global.css','sports.css'),$this->common->js);
        if($level){
            $data['level']=$level;
        }
        if($level==1){
            $table='taxonomy';
            $where=array('tid'=>$pid);
        }elseif($level==2){
            $table='taxonomy_term';
            $where=array('ttid'=>$pid);
        }
        $data['p_name']=$this->sports->get_one($table,$filed='name',$where);
        $data['pid']=$pid;
        $data['lo']=$level_one;
        $data['level']=$level; //用于判断装备的类型
        $this->load->view('taxonomy/child_add',$data);
    }
  }
 /*
  * 分类的编辑
  * */
 public function edit_child(){
     if($_POST){//获取数据
         $tid=intval($this->input->post('tid'));
         $name=trim($this->input->post('name'));
         $description=trim($this->input->post('description'));
         $weight=intval($this->input->post('weight'));
         if($tid=='' ||$name==''){
             message('操作有误','taxonomy');
         }


         //上传图片
         if($_FILES['imgs']['name']){//如果有图片上传upload_taxonomy
             $config=array('upload_path'=>ROOTPATH.$this->config->item('upload_taxonomy'),'allowed_types'=>'png|jpg|jpeg','overwrite'=>false);
             $this->load->library('upload',$config);
             if ($this->upload->do_upload('imgs')) {
                 $img=$this->upload->data();
                 $term_data['img']=$img['file_name'];
             }else{
                 $wrong = $this->upload->display_errors();
                 message($wrong,'taxonomy/edit_child/'.$tid);
             }
         }
         $term_data['name']=$name;
         $term_data['description']=$description;
         $term_data['weight']=intval($weight);
         $res= $this->sports->my_update('taxonomy_term','ttid',$tid,$term_data);
         $s_url=$f_url='taxonomy';
         $this->my_messages($res,'','',$s_url,$f_url);

     }else{
     $tid=intval($this->uri->segment(3));
     $data=$this->common->setConfig($this->common->configs,array('global.css','sports.css'),$this->common->js);
     $data['info']=$this->sports->get_one('taxonomy_term',$filed='*',array('ttid'=>$tid));
     $data['url']=$this->default_url();
     $this->load->view('taxonomy/child_edit',$data);
    }
 }
 /*二级以下分类删除
  * */
public function taxonomy_delete(){
  $tid= intval($this->input->post('tid'));//获取这个tid
 if($tid<=0){
   echo 0;
     exit;
 }
  $res1=$this->sports->true_delete('taxonomy_term',array('ttid'=>$tid));
  $res=$this->sports->true_delete('taxonomy_term_hierarchy',array('ttid'=>$tid));
 if($res && $res1){
     echo 1;
 }else{
     echo 0;
 }

}
  /*
   *获取数据库中是否存在此装备
   * */
    public function equip(){
    $name=$this->input->post('name');//获取装备名字
    $lo=$this->input->post('l');//获取大分类id
    $res=$this->sports->get_one('taxonomy_term','ttid',array('name'=>$name,'tid'=>$lo));
    echo json_encode($res);

    }
/*
 *直接添加清单关系
 * */
public function add_equip(){
    $ttid=intval($this->input->post('ttid'));//获取清单ID
    $p=intval($this->input->post('p'));//清单父ID

    if($ttid>0 && $p>0){
        //判断是否存在关系
        $res=$this->sports->get_one('taxonomy_term_hierarchy',$filed='*',$where=array('ttid'=>$ttid,'parent'=>$p));
        if($res){//存在
            echo 1;
        }else{//不存在添加
            $res=$this->my_add('taxonomy_term_hierarchy',array('ttid'=>$ttid,'parent'=>$p));
            if($res){
                echo 2;
            }

        }
    }else{

        echo '错误';
    }



 }
}