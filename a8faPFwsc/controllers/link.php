<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class link extends CI_Controller {
	private $rights=array(
		
	);
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->lang->load('default');
		$this->lang->load('link');//加载语言包
		$this->load->model('common_model','common');
		$this->load->model('system_model','system');
		$this->system->isLogin();
		$method=$this->uri->rsegment(2);//获取控制器中的方法
		if (array_key_exists($method,$this->rights)) {//进行权限控制
			$this->system->verify($this->rights[$method]);
		}
	}
	public function add(){//新增链接
		$this->load->helper(array('form'));
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$data['form']=form_open_multipart('link/save',array('id'=>'form1'));
		$this->load->view('head',$data);
		$this->load->view('link_add');
		$this->load->view('foot');
	}
	public function save(){
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('name'),'link/add');
		$web=$this->input->post('web');
		$web=$web?$web:message($this->lang->line('web'),'/link/add');
		$data=array('name'=>$name,'web'=>$web,'flag'=>1);
		$img=$this->common->imgUpload();
		if ($img) {
			$data['img']=$img;
			$data['classic']=2;
		}
		$this->db->insert('link',$data);
		if ($this->db->affected_rows()>0) {
			message($this->lang->line('success'),'link/add');
		}
		else {
			message($this->lang->line('failure'),'link/add');
		}
	}
	public function manage(){//链接列表
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'global.js'));
		$total=$this->db->count_all('link');
		$url=base_url(index_page().'/link/manage/page/');
		$uri_segment=4;
		$config=$this->common->pageConfig($url,$total,15,$uri_segment);
		$this->load->library('pagination',$config);
		$this->db->order_by('id','desc');
		$this->db->limit($config['per_page'],$this->uri->segment($uri_segment,0));
		$links=$this->db->get('link');
		$data['links']=$links->result_array();
		$this->load->view('head',$data);
		$this->load->view('link_manage');
		$this->load->view('foot');
	}
	public function setStatus(){
		$id=$this->uri->segment(4,0);
		$id=$id?$id:message($this->lang->line('error'),'link/manage');
		$flag=$this->uri->segment(6,0);
		$flag=$flag?$flag:message($this->lang->line('error'),'link/manage');
		$url='link/setStatus/id/'.$id;
		if ($flag==1) {
			$url.='/flag/2';
		}
		else {
			$url.='/flag/1';
		}
		$this->db->where('id',$id);
		$this->db->update('link',array('flag'=>$flag));//设置是否显示
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
	//更新友情链接的排序
	public function updateSort(){
		$id=$this->uri->segment(4,0);
		$id=isset($id)?$id:message($this->lang->line('error','link/manage'));
		$name=trim($this->uri->segment(6,0));
		$name=isset($name)?urldecode($name):message($this->lang->line('error','link/manage'));
		$sname=trim($this->uri->segment(8,0));
		$sname=isset($sname)?urldecode($sname):message($this->lang->line('error','link/manage'));
		$this->db->where('id',$id);
		$this->db->update('link',array('paixun'=>$name));
		if ($this->db->affected_rows()>0) {
			echo $name;
		}
		else {
			echo $sname;
		}
	}
	public function del(){
		$urldata=$this->uri->uri_to_assoc(3);
		$id=$urldata['id'];
		$id=$id?$id:message($this->lang->line('error'),'link/manage');
		$this->db->where('id',$id);
		$link=$this->db->get('link');
		$link=$link->row_array();
		if (!count($link)) {
			message($this->lang->line('exists'),'link/manage');
		}
		$this->db->delete('link',array('id'=>$id));
		@unlink(ROOTPATH.$this->common->uploadpath.$link['img']);
		message($this->lang->line('success'),'link/manage');
	}
	public function edit(){//编辑链接
		$urldata=$this->uri->uri_to_assoc(3);
		$id=$urldata['id'];
		$id=$id?$id:message($this->lang->line('error'),'link/manage');
		$this->db->where('id',$id);
		$link=$this->db->get('link');
		$link=$link->row_array();
		if (!count($link)) {
			message($this->lang->line('exists'),'link/manage');
		}
		$this->load->helper(array('form'));
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$data['form']=form_open_multipart('link/editSave',array('id'=>'form1'));
		$data['link']=$link;
		$this->load->view('head',$data);
		$this->load->view('link_edit');
		$this->load->view('foot');
	}
	public function editSave(){
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->line('name'),'link/add');
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('name'),'link/add');
		$web=$this->input->post('web');
		$web=$web?$web:message($this->lang->line('web'),'/link/add');
		$data=array('name'=>$name,'web'=>$web);
		$img=$this->common->imgUpload();
		if ($img) {
			$data['img']=$img;
			$data['classic']=2;
		}
		$this->db->update('link',$data,array('id'=>$id));
		message($this->lang->line('success'),'link/manage');
	}
}