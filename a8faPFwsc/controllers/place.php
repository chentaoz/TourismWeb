<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class place extends MY_Controller {
	private $rights=array(
		
	);
	public function __construct(){
		parent::__construct();
		$method=$this->uri->rsegment(2);//获取控制器中的方法
		if (array_key_exists($method,$this->rights)) {//进行权限控制
			$this->system->verify($this->rights[$method]);
		}
        $this->load->model('place_model','place');
        $this->load->model('sports_model','sports_model');
	}
	/**
	 * 目的地列表展示页面
	 *
	 */
	public function manage(){
        $this->load->helper('form');
        $data=$this->common->setConfig($this->common->configs,'place.css',array($this->common->js,'global.js'));
        $data['placeform']=form_open('place/save',array('id'=>'form1'));
        $parent=$this->place->place_tree();
        $data['parent']=$parent;
        #print_r( $data['parent']);
        $this->load->view('head',$data);
        $this->load->view('place/manage');
        $this->load->view('foot');
	}



    /**
	 * 新增目的地
	 *
	 */
	public function child_add(){
        $parame = $this->uri->uri_to_assoc(3);
        $id = $parame['id'];
        $this->load->helper('form');
        $data=$this->common->setConfig($this->common->configs,array('global.css','place.css'),$this->common->js);
        $data['placeform']=form_open('place/save',array('id'=>'form1'));
        $data['parent']=$id;
        $this->load->view('head',$data);
        $this->load->view('place/add');
        $this->load->view('foot');
	}
	/**
	 * 目的地的保存
	 *
	 */
	public function save(){
        $parent=$this->input->post('parent');
        $parent=$parent?$parent:0;
        $name=$this->input->post('name');
        $name=$name?$name:message('子类名称不能为空','place/child_add/id/'.$parent);
        $name_en=$this->input->post('name_en');
        $hot=$this->input->post('hot');
        $virtual=$this->input->post('virtual');
        $deep=$this->input->post('deep');
        $description=$this->input->post('content');
        $weight=$this->input->post('weight');
        $weight=$weight?$weight:255;
        $longitude='';
        $latitude='';
        //获取经纬度
        $log=rtrim(ltrim($this->input->post('log'),'('),')');
        if($log){
            $weidu=explode(',',$log);
            $longitude=trim($weidu[0]); //经度
            $latitude=trim($weidu[1]);//纬度
        }

        $data=array('latitude'=>$latitude,'longitude'=>$longitude,'parent'=>$parent,'name'=>$name,'name_en'=>$name_en,'hot'=>$hot,'virtual'=>$virtual,'deep'=>$deep,'description'=>$description,'weight'=>$weight);
        $q=$this->place->add($data);
        if ($q) {
            message($this->lang->line('success'),'place/manage');
        }
        else {
            message($this->lang->line('failure'),'place/child_add/id/'.$parent);
        }
	}
	/**
	 * 目的地的编辑
	 *
	 */
	public function edit(){
        $parame = $this->uri->uri_to_assoc(3);
        $id = $parame['id'];
        $this->load->helper('form');
        $data=$this->common->setConfig($this->common->configs,array('global.css','place.css'),$this->common->js);
        $data['placeform']=form_open('place/edit_save',array('id'=>'form1'));
        $data['place']=$this->place->get($id);
        $this->load->view('head',$data);
        $this->load->view('place/edit');
        $this->load->view('foot');
		
	}
	/**
	 * 目的地编辑之后的保存
	 *
	 */
	public function edit_save(){
        $pid=$this->input->post('pid');
		$disac=intval($this->input->post('userchange'))==0?1:0;
		$disaa=intval($this->input->post('useradd'))==0?1:0;
		//return var_dump($disac)."|".var_dump($disaa);
        $name=$this->input->post('name');
        $name=$name?$name:message('名称不能为空','place/edit/id/'.$pid);
        $name_en=$this->input->post('name_en');
        $hot=$this->input->post('hot');
        $virtual=$this->input->post('virtual');
        $deep=$this->input->post('deep');
        $description=$this->input->post('content');
        $weight=$this->input->post('weight');
        $weight=$weight?$weight:255;
        //获取经纬度
        $log=rtrim(ltrim($this->input->post('log'),'('),')');
        $weidu=explode(',',$log);
        $longitude=trim($weidu[0]); //经度
        $latitude=trim($weidu[1]);//纬度
       // 获得其父级城市
        $upcity=trim($this->input->post('upcity'));

        if($upcity!=null ||$upcity!=""){
            $parent=$this->place->findParentid($upcity);
//            print_r($parent);
//            exit;
            if($parent==false)
                $data=array('latitude'=>$latitude,'longitude'=>$longitude,'name'=>$name,'name_en'=>$name_en,'hot'=>$hot,'virtual'=>$virtual,'deep'=>$deep,'description'=>$description,'weight'=>$weight,"disablechange"=>$disac,"disableadd"=>$disaa);
            else
                $data=array('latitude'=>$latitude,'longitude'=>$longitude,'name'=>$name,'name_en'=>$name_en,'hot'=>$hot,'virtual'=>$virtual,'deep'=>$deep,'description'=>$description,'weight'=>$weight,"parent"=>$parent[0]["pid"],"disablechange"=>$disac,"disableadd"=>$disaa);
        }
        else
            $data=array('latitude'=>$latitude,'longitude'=>$longitude,'name'=>$name,'name_en'=>$name_en,'hot'=>$hot,'virtual'=>$virtual,'deep'=>$deep,'description'=>$description,'weight'=>$weight,"disablechange"=>$disac,"disableadd"=>$disaa);
        $q=$this->place->edit($data,$pid);
        if ($q==true) {
            message($this->lang->line('success'),'place/edit/id/'.$pid);
        }
        else {
            message($this->lang->line('failure'),'place/edit/id/'.$pid);
        }
	}

    /**
     * 目的地的删除
     *
     */
    public function del(){
        $parame = $this->uri->uri_to_assoc(3);
        $pid = $parame['id'];
        $pid=$pid?$pid:message('参数不正确','place/manage');
        $q=$this->place->del($pid);
        if ($q==true) {
            message($this->lang->line('success'),'place/manage');
        }
        else {
            message($this->lang->line('failure'),'place/manage');
        }
    }
    /**
     * 图片管理添加
     *
     */
    public function img_add(){
        $parame = $this->uri->uri_to_assoc(3);
        $pid = $parame['id'];
        $this->load->helper('form');
        $url='/place/img_add';
        $data=$this->common->setConfig($this->common->configs,array('global.css','place.css'),array($this->common->js,'global.js'));
        $data['imgform']=form_open_multipart('place/img_save',array('id'=>'form1'));
        $url.='/page/';
        $uri_segment=array_search('page',$this->uri->segment_array())+1;
        $url=base_url(index_page().$url);
        $img=$this->place->img_list($pid);
        $total = $this->place->img_total($pid);
        $this->load->library('pagination');
        $config=$this->common->pageConfig($url,$total,15,$uri_segment);
        $this->pagination->initialize($config);


        $data['img']=$img;
        $data['place_id']=$pid;
        $this->load->view('head',$data);
        $this->load->view('place/img_add');
        $this->load->view('foot');
    }
    /**
     * 图片管理添加保存
     *
     */
  public  function  img_save(){
      $sport_id=$this->input->post('sport_id');
      $sport_id=$sport_id?$sport_id:0;
      $place_id=$this->input->post('place_id');
      $place_id=$place_id?$place_id:message('参数不正确','place/manage');
      $weight=$this->input->post('weight');
      $weight=$weight?$weight:255;
      $data=array(
          'sport_id'=>$sport_id,
          'place_id'=>$place_id,
          'weight'=>$weight
      );
      //上传图片
      $config=array('upload_path'=>ROOTPATH.$this->config->item('upload').'/upload','allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>true);
      $this->load->library('upload',$config);
      $this->upload->set_upload_path(ROOTPATH.$this->config->item('upload_place_sport'));

      if ($this->upload->do_upload('banner1')) {
          $img=$this->upload->data();
          $data['img']=$img['file_name'];
      }
      $r=$this->place->img_add($data);
      if($r){
          message($this->lang->line('success'),'place/img_add/id/'.$place_id);
      }else{
          message($this->lang->line('failure'),'place/img_add/id/'.$place_id);
      }
  }
   /**
     * 图片编辑
     *
     */
    public function img_edit(){
        $parame = $this->uri->uri_to_assoc(3);
        $placeid= $parame['placeid'];
        $psiid = $parame['id'];
        $this->load->helper('form');
        $data=$this->common->setConfig($this->common->configs,array('global.css','place.css'),array($this->common->js,'global.js'));
        $data['imgform']=form_open_multipart('place/img_editsave',array('id'=>'form1'));
        $img=$this->place->get_img($psiid);
        $sport=$this->place->sport_list($placeid);
        $data['img']=$img;
        $data['sport']=$sport;
        $this->load->view('head',$data);
        $this->load->view('place/img_edit');
        $this->load->view('foot');
    }
    /**
     * 图片管理编辑保存
     *
     */
    public  function  img_editsave(){
        $psiid=$this->input->post('psiid');
        $psiid=$psiid?$psiid:message('参数不正确','place/manage');
        $sport_id=$this->input->post('sport_id');
        $sport_id=$sport_id?$sport_id:0;
        $place_id=$this->input->post('place_id');
        $place_id=$place_id?$place_id:message('参数不正确','place/manage');
        $weight=$this->input->post('weight');
        $weight=$weight?$weight:255;
        $data=array(
            'sport_id'=>$sport_id,
            'place_id'=>$place_id,
            'weight'=>$weight
        );
        //上传图片
        $config=array('upload_path'=>ROOTPATH.$this->config->item('upload').'/upload','allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>true);
        $this->load->library('upload',$config);
        $this->upload->set_upload_path(ROOTPATH.$this->config->item('upload_place_sport'));

        if ($this->upload->do_upload('banner1')) {
            $img=$this->upload->data();
            $data['img']=$img['file_name'];
        }
        $r=$this->place->img_edit($data,$psiid);
        if($r){
            message($this->lang->line('success'),'place/img_add/id/'.$place_id);
        }else{
            message($this->lang->line('failure'),'place/img_add/id/'.$place_id);
        }
    }
    /**
     *活动图片的删除
     *
     */
    public function img_del(){
        $parame = $this->uri->uri_to_assoc(3);
        $psiid = $parame['id'];
        $psiid=$psiid?$psiid:message('参数不正确','place/manage');
        $place_id = $parame['placeid'];
        $place_id=$place_id?$place_id:message('参数不正确','place/manage');
        $q=$this->place->img_del($psiid);
        if ($q==true) {
            message($this->lang->line('success'),'place/img_add/id/'.$place_id);
        }
        else {
            message($this->lang->line('failure'),'place/img_add/id/'.$place_id);
        }
    }
  /**
   * 场地下面活动的添加
   *
   */
  public function sport_add(){
  		$parame = $this->uri->uri_to_assoc(3);
        $pid = $parame['id'];
        $data=$this->common->setConfig($this->common->configs,array('global.css','place.css'),array($this->common->js,'global.js'));
        $data['sportform']=form_open('place/sport_save',array('id'=>'form1'));
        $sports=$this->place->sport_list($pid);
        $data['place_sport']=$sports;
        $data['place_id']=$pid;
        $data['sports']=$this->place->sports();//所有户外活动
        $this->load->view('head',$data);
        $this->load->view('place/sport_add');
        $this->load->view('foot');
  }
  /**
   * 场地活动的保存
   *
   */
  public function sport_save(){
  	$placeid=$this->input->post('place_id');
  	$placeid=$placeid?$placeid:message($this->lang->line('error'));
  	$name=$this->input->post('name');
  	$sta=$this->input->post('sta');
  	$weight=$this->input->post('weight');
  	$sport_index=$this->input->post('sport_index');
  	$sport_index_disabled=$this->input->post('sport_index_disabled');
  	if (!$name) {
  		message($this->lang->line('error'),'place/sport_add/id/'.$placeid);
  	}
  	if ($this->place->place_sport($placeid,$name)!==false) {
  		message('该项运动已添加','place/sport_add/id/'.$placeid);
  	}
  	$data=array('place_id'=>$placeid,'sport_id'=>$name,'sport_index'=>$sport_index,'sport_index_disabled'=>$sport_index_disabled,'weight'=>$weight,'sta'=>$sta);
  	$this->db->insert('place_sport',$data);
  	if ($this->db->affected_rows()>0) {
  		message($this->lang->line('success'),'place/sport_add/id/'.$placeid);
  	}
  	else {
  		message($this->lang->line('error'),'place/sport_add/id/'.$placeid);
  	}
  }
  /**
   * 场地运动的编辑
   *
   */
  public function sport_edit(){
  	$parame = $this->uri->uri_to_assoc(3);
    $pid = $parame['pid'];
    $sid = $parame['sid'];
    $data=$this->common->setConfig($this->common->configs,array('global.css','place.css'),$this->common->js);
    $data['sports']=$this->place->sports();//所有户外活动
    $data['sid']=$sid;
    $data['form']=form_open('place/place_sport_edit_save',array('id'=>'form1'));
    $data['place_id']=$pid;
    $data['sid']=$sid;
    $data['sport_attrs']=$this->sports_model->getAttrsForSport($sid);
    $data["sport_attrs_value"]=$this->sports_model->getAttrsValueForSport($pid,$sid);
    $place_sport=$this->place->place_sport($pid,$sid);
    $data['place_sport']=$place_sport;
    $this->load->view('head',$data);
    $this->load->view('place/sport_edit');
    $this->load->view('foot');
  }
  /**
   * 场地运动编辑之后的保存
   *
   */
  public function place_sport_edit_save(){
  	$sta=$this->input->post('sta');
  	$weight=$this->input->post('weight');
  	$pid=$this->input->post('place_id');
  	$sid=$this->input->post('sid');
  	$sport_index=$this->input->post('sport_index');
  	$sport_index_disabled=$this->input->post('sport_index_disabled');
  	$data=array('place_id'=>$pid,'sport_id'=>$sid,'sport_index'=>$sport_index,'sport_index_disabled'=>$sport_index_disabled,'weight'=>$weight,'sta'=>$sta);
  	$r=$this->place->sport_edit_save($pid,$sid,$data);
      //收运动属性值
    $i=1;
      $sport_attrs_arr=array();
      while(isset($_POST["att_".$i])){
          $attr_id=intval($this->input->post("attid_".$i));
          $sport_attrs_arr[ $attr_id]=$this->input->post("att_".$i);
          $i++;
      }
//      print_r($sport_attrs_arr);
//      return;
      $this->sports_model->sportAttrValueAdd($pid,$sport_attrs_arr);
  	if ($r==true) {
  		message($this->lang->line('success'),'place/sport_add/id/'.$pid);
  	}
  	else {
  		message($this->lang->line('failure'),'place/sport_add/id/'.$pid);
  	}
  }
   /**
   * 场地攻略
   *
   */
   public  function place_guide(){
       $parame = $this->uri->uri_to_assoc(3);
       $pid = $parame['id'];
       $guide=$this->place->get_guide($pid);
       $data=$this->common->setConfig($this->common->configs,'global.css',array($this->common->js,'global.js'));
       $this->load->helper('form');
       if($guide){
           $data['form']=form_open_multipart('place/guide_editsave',array('id'=>'form1'));
           $data['guide']=$guide;
           $this->load->view('head',$data);
           $this->load->view('place/guide_edit');
           $this->load->view('foot');
       }else{
           $data['form']=form_open_multipart('place/guide_save',array('id'=>'form1'));
           $data['place_id']=$pid;
           $this->load->view('head',$data);
           $this->load->view('place/guide_add');
           $this->load->view('foot');
       }

   }
    /**
     * 场地攻略的保存
     *
     */
    public function guide_save(){
        $title=$this->input->post('title');
        $version=$this->input->post('version');
        $pagenum=$this->input->post('pagenum');
        $description=$this->input->post('description');
        $pid=$this->input->post('place_id');
        $data=array('place_id'=>$pid,'title'=>$title,'version'=>$version,'pagenum'=>$pagenum,'description'=>$description,'created'=>time(),'updated'=>time());

        //上传图片
        $Foldername = date("Ym",time());
        $Uploadpathimg = ROOTPATH.$this->config->item('upload_guide_image').'/'.$Foldername;
        $Uploadpathpdf = ROOTPATH.$this->config->item('upload_guide_pdf').'/'.$Foldername;
        $config=array('upload_path'=>$Uploadpathimg,'allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>true);
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!file_exists($Uploadpathimg)){
            mkdir ($Uploadpathimg,777,true);
            }

        if ($this->upload->do_upload('banner1')) {
            $banner1=$this->upload->data();
            $data['img']=$Foldername.'/'.$banner1['file_name'];
        }

        if ($this->upload->do_upload('preview')) {
            $preview=$this->upload->data();
            $data['preview']=$Foldername.'/'.$preview['file_name'];
        }

        $config['upload_path'] = $Uploadpathpdf;
        $config['allowed_types'] ='pdf';
        $this->upload->initialize($config);
        if (!file_exists($Uploadpathpdf)){
            mkdir ($Uploadpathpdf,777,true);
        }
        if ($this->upload->do_upload('guide')) {
            $guide=$this->upload->data();
            $data['filetype']=$guide['file_ext'];
            $data['filepath']=$Foldername.'/'.$guide['file_name'];
            $data['filesize']=$guide['file_size'];
        }
        $r=$this->place->guide_save($data);
        if ($r==true) {
            message($this->lang->line('success'),'place/place_guide/id/'.$pid);
        }
        else {
            message($this->lang->line('failure'),'place/place_guide/id/'.$pid);
        }
    }

    /**
     * 场地攻略编辑
     *
     */
    public function guide_edit(){
        $parame = $this->uri->uri_to_assoc(3);
        $gid = $parame['id'];
        $this->load->helper('form');
        $data=$this->common->setConfig($this->common->configs,array('global.css','place.css'),array($this->common->js,'global.js'));
        $data['form']=form_open_multipart('place/guide_editsave',array('id'=>'form1'));
        $guide=$this->place->get_guide($gid);
        $data['guide']=$guide;
        $this->load->view('head',$data);
        $this->load->view('place/guide_edit');
        $this->load->view('foot');
    }
    /**
     * 场地攻略编辑保存
     *
     */
    public  function  guide_editsave(){
        $gid=$this->input->post('gid');
        $gid=$gid?$gid:message('参数不正确','place/manage');
        $title=$this->input->post('title');
        $version=$this->input->post('version');
        $pagenum=$this->input->post('pagenum');
        $description=$this->input->post('description');
        $pid=$this->input->post('place_id');
        $data=array('place_id'=>$pid,'title'=>$title,'version'=>$version,'pagenum'=>$pagenum,'description'=>$description,'updated'=>time());

        //上传图片
        $Foldername = date("Ym",time());
        $Uploadpathimg = ROOTPATH.$this->config->item('upload_guide_image').'/'.$Foldername;
        $Uploadpathpdf = ROOTPATH.$this->config->item('upload_guide_pdf').'/'.$Foldername;
        $config=array('upload_path'=>$Uploadpathimg,'allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>true);
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!file_exists($Uploadpathimg)){
            mkdir ($Uploadpathimg,777,true);
        }

        if ($this->upload->do_upload('banner1')) {
            $banner1=$this->upload->data();
            $data['img']=$Foldername.'/'.$banner1['file_name'];
        }

        if ($this->upload->do_upload('preview')) {
            $preview=$this->upload->data();
            $data['preview']=$Foldername.'/'.$preview['file_name'];
        }

        $config['upload_path'] = $Uploadpathpdf;
        $config['allowed_types'] ='pdf';
        $this->upload->initialize($config);
        if (!file_exists($Uploadpathpdf)){
            mkdir ($Uploadpathpdf,777,true);
        }
        if ($this->upload->do_upload('guide')) {
            $guide=$this->upload->data();
            $data['filetype']=$guide['file_ext'];
            $data['filepath']=$Foldername.'/'.$guide['file_name'];
            $data['filesize']=$guide['file_size'];
        }
        $r=$this->place->guide_edit($data,$gid);
        if($r){
            message($this->lang->line('success'),'place/place_guide/id/'.$pid);
        }else{
            message($this->lang->line('failure'),'place/place_guide/id/'.$pid);
        }
    }
    /**
     *场地攻略的删除
     *
     */
    public function guide_del(){
        $parame = $this->uri->uri_to_assoc(3);
        $gid = $parame['id'];
        $gid=$gid?$gid:message('参数不正确','place/manage');
        $place_id = $parame['placeid'];
        $place_id=$place_id?$place_id:message('参数不正确','place/manage');
        $q=$this->place->guide_del($gid);
        if ($q==true) {
            message($this->lang->line('success'),'place/place_guide/id/'.$place_id);
        }
        else {
            message($this->lang->line('failure'),'place/place_guide/id/'.$place_id);
        }
    }
	
	public function getAttributeback($pid,$sid){
		$arr =$this->place->get_att_back($pid,$sid);
		 header('Content-Type: application/json');
		 //$arr=array($pid,$sid);
		echo json_encode($arr);
	}
	
	public function usebackup($pid,$sid){
		if($this->place->use_back($pid,$sid))
			$this->load->helper('url');
			 redirect(base_url("index.php/place/sport_edit/pid/".$pid."/sid/".$sid.".html"));
		
		
	}
	
}