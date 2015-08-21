<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ad extends CI_Controller {
	private $rights=array(
		
	);
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->lang->load('default');
		$this->lang->load('ad');//加载语言包
		$this->load->model('common_model','common');
		$this->load->model('system_model','system');
		$this->system->isLogin();
		$method=$this->uri->rsegment(2);//获取控制器中的方法
		if (array_key_exists($method,$this->rights)) {//进行权限控制
			$this->system->verify($this->rights[$method]);
		}
	}
	public function channel(){
		$this->load->helper('form');
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'global.js','validateMyForm/jquery.validateMyForm.1.0.js'));
		$data['form']=form_open('ad/channelSave',array('id'=>'form1'));
		$db=clone $this->db;
		$r=$this->db->get('ads_bclass');
		$this->load->library('pagination');
		$url=base_url(index_page().'/ad/channel/page/');
		$config=$this->common->pageConfig($url,$r->num_rows(),15,4);
		$this->pagination->initialize($config);
		$this->db=$db;
		$this->db->limit($config['per_page'],$this->uri->segment($config['uri_segment'],0));
		$channel=$this->db->get('ads_bclass');
		$data['bclass']=$channel->result_array();
		$this->load->view('head',$data);
		$this->load->view('ad_channel');
		$this->load->view('foot');
	}
	public function channelSave(){
		$name=trim($this->input->post('name'));
		if (!$name) {
			message($this->lang->line('error'),'ad/channel');
		}
		$this->db->insert('ads_bclass',array('name'=>$name));
		if ($this->db->affected_rows()>0) {
			message($this->lang->line('success'),'ad/channel');
		}
		else {
			message($this->lang->line('failure'),'ad/channel');
		}
	}
	public function channelEdit(){
		$id=trim($this->uri->segment(3,0));
		$id=$id?$id:message($this->lang->line('error'),'ad/channel');
		$r=$this->db->get_where('ads_bclass',array('id'=>$id));
		if ($r->num_rows()==0) {
			message($this->lang->line('error'),'ad/channel');
		}
		$this->load->helper('form');
		$data=$this->common->setConfig($this->common->configs,array('global.css'),'');
		$data['form']=form_open('ad/channelEditSave');
		$data['channel']=$r->result_array();
		$this->load->view('head',$data);
		$this->load->view('ad_channel_edit');
		$this->load->view('foot');
	}
	public function channelEditSave(){
		$name=trim($this->input->post('name'));
		$id=trim($this->input->post('id'));
		if (!$name||!$id) {
			message($this->lang->line('error'),'ad/channel');
		}
		$this->db->where('id',$id);
		$this->db->update('ads_bclass',array('name'=>$name));
		message($this->lang->line('success'),'ad/channel');
	}
	public function channelDel(){
		$id=trim($this->uri->segment(3));
		$id=$id?$id:message($this->lang->line('error'),'ad/channel');
		$query=$this->db->get_where('ads_sclass',array('bid'=>$id));
		if ($query->num_rows()>0) {
			message($this->lang->line('ad_sclass_not_blank'),'ad/channel');
		}
		$this->db->delete('ads_bclass',array('id'=>$id));
		message($this->lang->line('success'),'ad/channel');
	}
	public function classic(){
		$this->load->helper('form');
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'global.js','validateMyForm/jquery.validateMyForm.1.0.js'));
		$data['form']=form_open('ad/classicSave',array('id'=>'form1'));
		$url='ad/classic';
		$default=array('bid','page');
		$uridata=$this->uri->uri_to_assoc(3,$default);
		$bid=$uridata['bid'];
		if ($bid) {
			$url.='/bid/'.$bid;
		}
		$this->db->select('a.*,b.name as channel');
		$this->db->from('ads_sclass as a');
		$this->db->join('ads_bclass as b','a.bid=b.id');
		if ($bid) {
			$this->db->where('a.bid',$bid);
		}
		$url.='/page/';
		$url=base_url(index_page().'/'.$url);
		$db=clone $this->db;
		$r=$this->db->get();
		$this->load->library('pagination');
		$segment=array_search('page',$this->uri->segment_array())+1;
		$config=$this->common->pageConfig($url,$r->num_rows(),12,$segment);
		$this->pagination->initialize($config);
		$this->db=$db;
		$this->db->order_by('a.id','desc');
		$this->db->limit($config['per_page'],$this->uri->segment($config['uri_segment'],0));
		$pos=$this->db->get();
		$data['position']=$pos->result_array();
		$this->load->model('ad_model');
		$bclass=$this->ad_model->Bclass();
		$data['bclass']=$bclass;
		$data['bid']=$bid?$bid:'all';
		$this->load->view('head',$data);
		$this->load->view('ad_classic');
		$this->load->view('foot');
	}
	public function classicSave(){
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('ad_name'),'ad/classic');
		$width=$this->input->post('width');
		$width=$width?$width:message($this->lang->line('ad_width'),'ad/classic');
		if (!is_numeric($width)) {
			message($this->lang->line('numeric'),'ad/classic');
		}
		$height=$this->input->post('height');
		$height=$height?$height:message($this->lang->line('ad_height'),'ad/classic');
		if (!is_numeric($height)) {
			message($this->lang->line('numeric'),'ad/classic');
		}
		$data=array('name'=>$name,'width'=>$width,'height'=>$height,'bid'=>$this->input->post('channel'));
		$this->db->insert('ads_sclass',$data);
		if ($this->db->affected_rows()>0) {
			message($this->lang->line('success'),'ad/classic');
		}
		else {
			message($this->lang->line('failure'),'ad/classic');
		}
	}
	public function classicEdit(){
		$id=$this->uri->segment(3);
		$id=$id?$id:message($this->lang->line('error'),'ad/classic');
		$this->load->helper('form');
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$data['form']=form_open('ad/classicEditSave',array('id'=>'form1'));
		$this->db->where('id',$id);
		$r=$this->db->get('ads_sclass');
		if ($r->num_rows()==0) {
			$this->lang->line('error');
		}
		$data['ad']=$r->row_array();
		$this->load->model('ad_model');
		$bclass=$this->ad_model->Bclass();
		$data['bclass']=$bclass;
		$this->load->view('head',$data);
		$this->load->view('ad_classic_edit');
		$this->load->view('foot');
	}
	public function classicEditSave(){
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->line('error'),'ad/classic');
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('ad_name'),'ad/classic');
		$width=$this->input->post('width');
		$width=$width?$width:message($this->lang->line('ad_width'),'ad/classic');
		$height=$this->input->post('height');
		$height=$height?$height:message($this->lang->line('ad_height'),'ad/classic');
		$data=array('name'=>$name,'width'=>$width,'height'=>$height,'bid'=>$this->input->post('channel'));
		$this->db->update('ads_sclass',$data,array('id'=>$id));
		message($this->lang->line('success'),'ad/classic');
	}
	public function classicDel(){
		$id=$this->uri->segment(3);
		$id=$id?$id:message($this->lang->line('error'),'ad/classic');
		$query=$this->db->get_where('ads',array('classid'=>$id));
		if ($query->num_rows()>0) {
			message($this->lang->line('ad_not_blank'),'ad/classic');
		}
		$this->db->where('id',$id);
		$this->db->delete('ads_sclass');
		message($this->lang->line('success'),'ad/classic');
	}
	public function add(){
		$this->load->helper('form');
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$this->load->model('ad_model');
		$data['classic']=$this->ad_model->classic();
		$data['form']=form_open_multipart('ad/save',array('id'=>'form1'));
		$this->load->view('head',$data);
		$this->load->view('ad_add');
		$this->load->view('foot');
	}
	public function save(){
		$sid=$this->input->post('sid');
		$sid=$sid?$sid:message($this->lang->line('ad_pos'),'ad/add');
		$this->load->model('ad_model');
		$img=$this->ad_model->imgUpload($sid);
		$img=$img?$img:message($this->lang->line('ad_img_error'),'ad/add');
		$title=$this->input->post('title');
		$title=$title?$title:'默认标题';
		$intro=$this->input->post('intro');
		$intro=$intro?$intro:'默认描述';
		$data=array('classid'=>$sid,'title'=>$title,'intro'=>$intro,'img'=>$img,'weblink'=>$this->input->post('link'),'flag'=>$this->input->post('flag'),'created'=>time());
		$this->db->insert('ads',$data);
		if ($this->db->affected_rows()>0) {
			message($this->lang->line('success'),'ad/add');
		}
		else {
			message($this->lang->line('failure'),'ad/add');
		}
	}
	public function manage(){
		$this->load->helper('form');
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'global.js'));
		$this->load->model('ad_model');
		$data['classic']=$this->ad_model->classic();
		$data['form']=form_open('ad/manage',array('id'=>'form1'));
		$urldata=$this->uri->uri_to_assoc(4);
		$url='/ad/manage';
		$key=$this->input->post('keyword');
		if ($key) {
			$url.='/keyword/'.$keyword;
		}
		else {
			if (array_key_exists('keyword',$urldata)) {
				$key=$urldata['keyword'];
				$url.='/keyword/'.$keyword;
			}
		}
		$sid=$this->input->post('sid');
		if ($sid) {
			$url.='/sid/'.$sid;
		}
		else {
			if (array_key_exists('sid',$urldata)) {
				$sid=$urldata['sid'];
				$url.='/sid/'.$sid;
			}
		}
		$this->db->select('a.*,b.name,b.width,b.height');
		$this->db->from('ads as a');
		$this->db->join('ads_sclass as b','a.classid=b.id');
		if ($key) {
			$this->db->like('a.title',$key);
		}
		if ($sid) {
			$this->db->where('a.classid',$sid);
		}
		$url.='/page/';
		$uri_segment=array_search('page',$this->uri->segment_array())+1;
		$url=base_url(index_page().$url);
		$this->db->order_by('a.id','desc');
		$db=clone $this->db;
		$r=$this->db->get();
		$total=$r->num_rows();
		$this->load->library('pagination');
		$config=$this->common->pageConfig($url,$total,15,$uri_segment);
		$this->pagination->initialize($config);
		$this->db=$db;
		$this->db->limit($config['per_page'],$this->uri->segment($config['uri_segment'],0));
		$ads=$this->db->get();
		$data['ads']=$ads->result_array();
		$this->load->view('head',$data);
		$this->load->view('ad_manage');
		$this->load->view('foot');
	}
	public function edit(){
		$urldata=$this->uri->uri_to_assoc(3);
		$id=$urldata['id'];
		$id=$id?$id:message($this->lang->line('error'),'ad/manage');
		$r=$this->db->get_where('ads',array('id'=>$id));
		$this->load->helper('form');
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'global.js','validateMyForm/jquery.validateMyForm.1.0.js'));
		$this->load->model('ad_model');
		$data['classic']=$this->ad_model->classic();
		$data['form']=form_open_multipart('ad/editSave',array('id'=>'form1'));
		$data['ads']=$r->row_array();
		$this->load->view('head',$data);
		$this->load->view('ad_edit');
		$this->load->view('foot');
	}
	public function editSave(){
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->line('error'),'ad/manage');
		$sid=$this->input->post('sid');
		$sid=$sid?$sid:message($this->lang->line('ad_pos'),'ad/edit');
		$this->load->model('ad_model');
		$title=$this->input->post('title');
		$title=$title?$title:'默认标题';
		$intro=$this->input->post('intro');
		$intro=$intro?$intro:'默认描述';

		$data=array('classid'=>$sid,'title'=>$title,'intro'=>$intro,'weblink'=>$this->input->post('link'),'flag'=>$this->input->post('flag'));
        if($_FILES['userfile']['name']){
            $img=$this->ad_model->imgUpload($sid);
            if ($img) {
                $data['img']=$img;
            }else{
                message('图片上传出错请查看此广告位的大小尺寸','ad/manage');
            }
        }
		$this->db->where('id',$id);
		$this->db->update('ads',$data);
		message($this->lang->line('success'),'ad/manage');
	}
	public function del(){
		$urldata=$this->uri->uri_to_assoc(3);
		$id=$urldata['id'];
		$id=$id?$id:message($this->lang->line('error'),'ad/manage');
		$this->db->where('id',$id);
		$r=$this->db->get('ads');
		$ads=$r->row_array();
		if (!count($ads)) {
			message($this->lang->line('exists'),'ad/manage');
		}
		$this->db->delete('ads',array('id'=>$id));
		@unlink(ROOTPATH.$this->common->uploadpath.$ads['img']);
		message($this->lang->line('success'),'ad/manage');
	}
	public function setStatus(){
		$id=$this->uri->segment(4,0);
		$id=$id?$id:message($this->lang->line('error'),'ad/manage');
		$flag=$this->uri->segment(6,0);
		$flag=$flag?$flag:message($this->lang->line('error'),'ad/manage');
		$url='ad/setStatus/id/'.$id;
		if ($flag==1) {
			$url.='/flag/2';
		}
		else {
			$url.='/flag/1';
		}
		$this->db->where('id',$id);
		$this->db->update('ads',array('flag'=>$flag));//设置是否显示
		$url=site_url($url);
		if ($this->db->affected_rows()) {
			if ($flag==1) {
				echo '<img src="'.base_url().'images/yes.gif" onclick=setType(this,"'.$url.'") title="可编辑" />';
			}
			else {
				echo '<img src="'.base_url().'images/no_gray.gif" onclick=setType(this,"'.$url.'") title="可编辑" />';
			}
		}
	}
	//更新广告标题
	public function updateTitle(){
		$id=$this->uri->segment(4,0);
		$id=$id?$id:message($this->lang->line('error','ad/manage'));
		$name=trim($this->uri->segment(6,0));
		$name=$name?urldecode($name):message($this->lang->line('error','ad/manage'));
		$sname=trim($this->uri->segment(8,0));
		$sname=$sname?urldecode($sname):message($this->lang->line('error','ad/manage'));
		$this->db->where('id',$id);
		$this->db->update('ads',array('title'=>$name));
		if ($this->db->affected_rows()>0) {
			echo $name;
		}
		else {
			echo $sname;
		}
	}
	//更新广告的排序
	public function updateSort(){
		$id=$this->uri->segment(4,0);
		$id=isset($id)?$id:message($this->lang->line('error','ad/manage'));
		$name=trim($this->uri->segment(6,0));
		$name=isset($name)?urldecode($name):message($this->lang->line('error','ad/manage'));
		$sname=trim($this->uri->segment(8,0));
		$sname=isset($sname)?urldecode($sname):message($this->lang->line('error','ad/manage'));
		$this->db->where('id',$id);
		$this->db->update('ads',array('sort_number'=>$name));
		if ($this->db->affected_rows()>0) {
			echo $name;
		}
		else {
			echo $sname;
		}
	}
}