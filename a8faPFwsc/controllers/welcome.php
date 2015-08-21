<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('common_model','common');
		$this->load->model('system_model','system');
		$this->lang->load('system');
	}
	public function index(){
		$this->load->helper('form');
		$data=$this->common->setConfig($this->common->configs,'',$this->common->js);
		$data['form']=form_open('welcome/chk');
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('index');
		$this->load->view('foot');
	}
	/**
	 * 后台登陆的验证
	 *
	 */
	public function chk(){
		$this->load->library(array('input','session'));
		$this->load->helper('message');
		$this->lang->load('user');
		$user=$this->input->post('username');
		$psw=$this->input->post('psw');
		if (!$user||!$psw) {
			message($this->lang->line('user_input'),'');
		}
		$r=$this->db->get_where('admin',array('username'=>$user));
		if ($r->num_rows()==0) {//登陆账号不存在
			message($this->lang->line('user_exists'),'');
		}
		$row=$r->row();
		if ($row->flag==2) {//状态被冻结
			message($this->lang->line('user_dongjie'),'');
		}
		if ($row->classic!='1') {
			$role=$this->system->getRole($row->role_id);
			if ($role->flag!='1') {
				message($this->lang->line('user_role_dongjie'),'');
			}
		}
		if (md5(md5($psw).$row->salt)!=$row->password) {//密码不正确
			message($this->lang->line('user_error_psw'),'');
		}
		$session=array(
		'username'=>$row->username,
		'uid'=>$row->id,
		'login_flag'=>'ok',
		'classic'=>$row->classic,
		'rights'=>$this->system->roleRights($row->role_id),
		'role'=>$row->role_id,
		);
		$this->session->set_userdata($session);
		$this->system->log($row->id);
		message($this->lang->line('user_login_success'),'welcome/system',1);
	}
	public function system(){
		$this->system->isLogin();
		$this->load->library('session');
		$data=$this->common->setConfig($this->common->configs,array('global.css'),$this->common->js);
		$data['title']=$this->common->configs['title'];
		$data['username']=$this->session->userdata('username');
		$data['date']=date('Y-m-d',time());
		if ($this->session->userdata('classic')=='1') {
			$data['menu']=$this->system->menuList(false);
		}
		else {
			$role=$this->system->getRole($this->session->userdata('role'));
			$data['menu']=unserialize($role->menu);
		}
		$data['logouturl']='welcome/logout';
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('default');
		$this->load->view('foot');
	}
	public function logout(){
		$this->system->isLogin();
		$this->load->library('session');
		$this->load->helper('message');
		$this->lang->load('user');
		$this->session->unset_userdata('login_flag');
		$this->session->sess_destroy();
		message($this->lang->line('user_logout'),'',1);
	}
	public function home(){
		$this->system->isLogin();
		$data=$this->common->setConfig($this->common->configs,array('global.css'),$this->common->js);
		$data['username']=$this->session->userdata('username');
		$data['ip']='';
		$data['created']='';
		$this->db->where('uid',$this->session->userdata('uid'));
		$this->db->order_by('created','desc');
		$this->db->limit(1,2);
		$query=$this->db->get('log');
		if ($query->num_rows()!=0) {
			$row=$query->row();
			$data['ip']=$row->ip;
			$data['created']=date('Y-m-d H:i:s',$row->created);
		}
		$upload=get_cfg_var('upload_max_filesize');
		$data['upload']=$upload?$upload:'';
		$post=get_cfg_var('post_max_size');
		$data['post']=$post?$post:'';
		$timeout=get_cfg_var('max_execution_time');
		$data['timeout']=$timeout?$timeout:'';
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('welcome_home');
		$this->load->view('foot');
	}
}