<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System extends CI_Controller {
	private $rights=array(
		'administrator'=>4,
		'save'=>4,
		'moduleSave'=>5,
		'moduleEdit'=>6,
		'moduleEditSave'=>6,
		'moduleDel'=>7,
		'modRights'=>8,
		'modRightsSave'=>8,
		'modRightsEdit'=>9,
		'modRightsEditSave'=>9,
		'modRightsDel'=>10,
		'menuGroupSave'=>11,
		'menuGroupEdit'=>12,
		'menuGroupEditSave'=>12,
		'menuGroupDel'=>13,
		'menuSave'=>14,
		'menuEdit'=>15,
		'menuEditSave'=>15,
		'menuDel'=>16,
		'roleSave'=>17,
		'roleEdit'=>18,
		'roleEditSave'=>18,
		'roleDel'=>19,
		'assignMenu'=>20,
		'assignMenuSave'=>20,
		'assignRight'=>21,
		'assignRightSave'=>21,
		'masterSave'=>22,
		'masterEdit'=>23,
		'masterEditSave'=>23,
		'masterDel'=>24,
		'masterRole'=>25,
		'masterRoleSave'=>25,
		'config'=>26,
		'configSave'=>26,
		'log'=>27,
		'phpinfo'=>28,
		'emailConfig'=>29,
		'emailConfigSave'=>29,
		'pswEdit'=>30,
		'pswEditSave'=>30
	);
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->lang->load('system');//加载语言包
		$this->load->model('common_model','common');
		$this->load->model('system_model','system');
		$this->system->isLogin();
		$method=$this->uri->rsegment(2);//获取控制器中的方法
		if (array_key_exists($method,$this->rights)) {//进行权限控制
			$this->system->verify($this->rights[$method]);
		}
	}
	public function administrator(){
		$this->load->helper(array('form'));
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$data['form']=form_open('system/save',array('id'=>'form1'));
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('system_administrator');
		$this->load->view('foot');
	}
	public function save(){//超级管理员的信息修改
		$old_user=$this->input->post('old_user');
		$old_user=$old_user?$old_user:message($this->lang->line('old_user'),'system/administrator');
		$old_psw=$this->input->post('old_psw');
		$old_psw=$old_psw?$old_psw:message($this->lang->line('old_psw'),'system/administrator');
		$new_psw=$this->input->post('new_psw');
		$new_psw=$new_psw?$new_psw:message($this->lang->line('new_psw'),'system/administrator');
		$new_psw2=$this->input->post('new_psw2');
		$new_psw2=$new_psw2?$new_psw2:message($this->lang->line('new_psw'),'system/administrator');
		if ($new_psw!=$new_psw2) {
			message($this->lang->line('no_confirm'),'system/administrator');
		}
		$this->db->where('username',$old_user);
		$user=$this->db->get('admin');
		$user=$user->row_array();
		if (!count($user)) {
			message($this->lang->line('old_user'),'system/administrator');
		}
		if (md5(md5($old_psw).$user['salt'])!=$user['password']) {
			message($this->lang->line('old_psw'),'system/administrator');
		}
		$salt=substr(uniqid(mt_rand()),-6);
		$psw=md5(md5($new_psw).$salt);
		$data=array('password'=>$psw,'salt'=>$salt);
		if ($this->input->post('new_user')) {
			$data['username']=$this->input->post('new_user');
		}
		$this->db->update('admin',$data,array('username'=>$old_user));
		message($this->lang->line('success'),'system/administrator');
	}
	public function phpinfo(){
		phpinfo();
	}
	public function config(){
		$this->load->helper(array('form'));
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$data['form']=form_open('system/configSave',array('id'=>'form1'));
		$data['configs']=$this->common->config();
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('system_config');
		$this->load->view('foot');
	}
	public function configSave(){
		$title=$this->input->post('title');
		$keyword=$this->input->post('keyword');
		$description=$this->input->post('description');
		if ($title) {
			$this->db->update('config',array('datavalue'=>$title),array('var'=>'title'));
		}
		if ($keyword) {
			$this->db->update('config',array('datavalue'=>$keyword),array('var'=>'keyword'));
		}
		if ($description) {
			$this->db->update('config',array('datavalue'=>$description),array('var'=>'description'));
		}
		message($this->lang->line('success'),'system/config');
	}
	public function emailConfig(){
		$this->load->helper(array('form'));
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$data['form']=form_open('system/emailConfigSave',array('id'=>'form1'));
		$data['configs']=$this->common->config();
		$this->load->view('head',$data);
		$this->load->view('system_email_config');
		$this->load->view('foot');
	}
	public function emailConfigSave(){
		$smtp_host=$this->input->post('host');
		$smtp_port=$this->input->post('port');
		$smtp_mail=$this->input->post('mail');
		$smtp_user=$this->input->post('user');
		$smtp_psw=$this->input->post('psw');
		if ($smtp_host) {
			$this->db->update('config',array('datavalue'=>$smtp_host),array('var'=>'smtp_host'));
		}
		if ($smtp_port) {
			$this->db->update('config',array('datavalue'=>$smtp_port),array('var'=>'smtp_port'));
		}
		if ($smtp_mail) {
			$this->db->update('config',array('datavalue'=>$smtp_mail),array('var'=>'smtp_mail'));
		}
		if ($smtp_user) {
			$this->db->update('config',array('datavalue'=>$smtp_user),array('var'=>'smtp_user'));
		}
		if ($smtp_psw) {
			$this->db->update('config',array('datavalue'=>$smtp_psw),array('var'=>'smtp_psw'));
		}
		message($this->lang->line('success'),'system/emailConfig');
	}
	/**
	 * 可通过该函数来检测之前的邮件参数的设置是否正确
	 *
	 */
	public function emailTest(){
		$urldata=$this->uri->uri_to_assoc(3);
		$mail=$urldata['mail'];
		if (!isset($mail)) {
			echo $this->lang->line('mail_test');
			die;
		}
		$mail=urldecode($mail);
		$email=$this->common->sendMail(array('email'=>$mail,'user'=>'hello','title'=>'Test mail','content'=>'This is a test mail'),$this->common->email());
		if ($email) {
			echo $this->lang->line('mail_success');
		}
		else {
			echo $this->lang->line('mail_failure');
		}
	}
	/**
	 * 菜单组列表，包括新增
	 *
	 */
	public function menuGroup(){
		$this->load->helper(array('form'));
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js','global.js'));
		$data['form']=form_open('system/menuGroupSave',array('id'=>'form1'));
		$db=clone $this->db;
		$total=$this->db->count_all_results('menu');
		$url=base_url('system/menuGroup/page/');
		$currpage=array_search('page',$this->uri->segment_array())+1;
		$this->load->library('pagination');
		$config=$this->common->pageConfig($url,$total,14,$currpage);
		$this->pagination->initialize($config);
		$this->db=$db;
		$this->db->from('menu');
		$this->db->order_by('paixun','asc');
		$this->db->limit($config['per_page'],$this->uri->segment($config['uri_segment'],0));
		$menu=$this->db->get();
		$data['menu']=$menu->result_array();
		$this->load->view('head',$data);
		$this->load->view('system_menugroup');
		$this->load->view('foot');
	}
	public function menuGroupSave(){
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('exist'));
		$paixun=$this->input->post('paixun');
		$paixun=$paixun?$paixun:255;
		$data=array('name'=>$name,'paixun'=>$paixun);
		$this->db->insert('menu',$data);
		if ($this->db->affected_rows()>0) {
			message($this->lang->line('success'),'system/menuGroup');
		}
		else {
			message($this->lang->line('failure'),'system/menuGroup');
		}
	}
	public function menuGroupDel(){
		$id=trim($this->uri->segment(3));
		$id=$id!==false?$id:message($this->lang->line('error'));
		$this->db->where('menu_id',$id);
		$this->db->from('menu_rights');
		if ($this->db->count_all_results()>0) {
			message($this->lang->line('menu_no_blank'),'system/menuGroup');
		}
		$this->db->delete('menu',array('id'=>$id));
		message($this->lang->line('success'),'system/menuGroup');
	}
	public function updateMenuGroupSort(){//更新菜单组的排序
		$id=$this->uri->segment(4,0);
		$id=isset($id)?$id:message($this->lang->line('error','system/menuGroup'));
		$name=trim($this->uri->segment(6,0));
		$name=isset($name)?urldecode($name):message($this->lang->line('error','system/menuGroup'));
		$sname=trim($this->uri->segment(8,0));
		$sname=isset($sname)?urldecode($sname):message($this->lang->line('error','system/menuGroup'));
		$this->db->where('id',$id);
		$this->db->update('menu',array('paixun'=>$name));
		if ($this->db->affected_rows()>0) {
			echo $name;
		}
		else {
			echo $sname;
		}
	}
	public function updateMenuSort(){//更新菜单的排序
		$id=$this->uri->segment(4,0);
		$id=isset($id)?$id:message($this->lang->line('error','system/menuGroup'));
		$name=trim($this->uri->segment(6,0));
		$name=isset($name)?urldecode($name):message($this->lang->line('error','system/menuGroup'));
		$sname=trim($this->uri->segment(8,0));
		$sname=isset($sname)?urldecode($sname):message($this->lang->line('error','system/menuGroup'));
		$this->db->where('id',$id);
		$this->db->update('menu_rights',array('paixun'=>$name));
		if ($this->db->affected_rows()>0) {
			echo $name;
		}
		else {
			echo $sname;
		}
	}
	public function menuGroupEdit(){
		$id=$this->uri->segment(3);
		$id=$id!==false?$id:message($this->lang->line('error'),'system/menuGroup');
		$query=$this->db->get_where('menu',array('id'=>$id));
		if ($query->num_rows()<=0) {
			message($this->lang->line('exists'),'system/menuGroup');
		}
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js','global.js'));
		$this->load->helper('form');
		$data['form']=form_open('system/menuGroupEditSave',array('id'=>'form1'));
		$data['m']=$query->row_array();
		$this->load->view('head',$data);
		$this->load->view('system_menugroup_edit');
		$this->load->view('foot');
	}
	public function menuGroupEditSave(){
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('error'),'system/menuGroup');
		$paixun=$this->input->post('paixun');
		$paixun=$paixun?$paixun:255;
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->line('error'),'system/menuGroup');
		$data=array('name'=>$name,'paixun'=>$paixun);
		$this->db->update('menu',$data,array('id'=>$id));
		message($this->lang->line('success'),'system/menuGroup');
	}
	public function setMenuGroupStatus(){//更新菜单组的状态
		$id=$this->uri->segment(4,0);
		$id=$id?$id:message($this->lang->line('error'),'system/menuGroup');
		$flag=$this->uri->segment(6,0);
		$flag=$flag?$flag:message($this->lang->line('error'),'system/menuGroup');
		$url='system/setMenuGroupStatus/id/'.$id;
		if ($flag==1) {
			$url.='/flag/2';
		}
		else {
			$url.='/flag/1';
		}
		$this->db->where('id',$id);
		$this->db->update('menu',array('flag'=>$flag));//设置是否显示
		$url=site_url($url);
		if ($this->db->affected_rows()) {
			if ($flag==1) {
				echo '<img src="'.base_url('images/yes.gif').'" onclick=setType(this,"'.$url.'") title="可编辑" />';
			}
			else {
				echo '<img src="'.base_url('images/no_gray.gif').'" onclick=setType(this,"'.$url.'") title="可编辑" />';
			}
		}
	}
	public function setMenuStatus(){//更新菜单的状态
		$id=$this->uri->segment(4,0);
		$id=$id?$id:message($this->lang->line('error'),'system/menuGroup');
		$flag=$this->uri->segment(6,0);
		$flag=$flag?$flag:message($this->lang->line('error'),'system/menuGroup');
		$url='system/setMenuStatus/id/'.$id;
		if ($flag==1) {
			$url.='/flag/2';
		}
		else {
			$url.='/flag/1';
		}
		$this->db->where('id',$id);
		$this->db->update('menu_rights',array('flag'=>$flag));//设置是否显示
		$url=site_url($url);
		if ($this->db->affected_rows()) {
			if ($flag==1) {
				echo '<img src="'.base_url('images/yes.gif').'" onclick=setType(this,"'.$url.'") title="可编辑" />';
			}
			else {
				echo '<img src="'.base_url('images/no_gray.gif').'" onclick=setType(this,"'.$url.'") title="可编辑" />';
			}
		}
	}
	public function menu(){
		$id=$this->uri->segment(3);
		$id=$id!==false?$id:message($this->lang>line('error'),'system/menuGroup');
		$this->load->helper(array('form'));
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js','global.js'));
		$data['form']=form_open('system/menuSave',array('id'=>'form1'));
		$this->db->where('menu_id',$id);
		$db=clone $this->db;
		$query=$this->db->get('menu_rights');
		$total=$query->num_rows();
		$url=base_url(index_page().'/system/menu/'.$id.'/');
		$this->load->library('pagination');
		$config=$this->common->pageConfig($url,$total,14,4);
		$this->pagination->initialize($config);
		$this->db=$db;
		$this->db->from('menu_rights');
		$this->db->order_by('paixun','asc');
		$this->db->limit($config['per_page'],$this->uri->segment($config['uri_segment'],0));
		$menu=$this->db->get();
		$data['menu']=$menu->result_array();
		$data['id']=$id;
		$this->load->view('head',$data);
		$this->load->view('system_menu');
		$this->load->view('foot');
	}
	public function menuSave(){
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->line('error'),'system/menuGroup');
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('error'),'system/menu/'.$id);
		$url=$this->input->post('url');
		$url=$url?$url:message($this->lang->line('error'),'system/menu/'.$id);
		$paixun=$this->input->post('paixun');
		$paixun=$paixun?$paixun:255;
		$data=array('name'=>$name,'menu_id'=>$id,'paixun'=>$paixun,'sourceMod'=>$url);
		$this->db->insert('menu_rights',$data);
		if ($this->db->affected_rows()>0) {
			message($this->lang->line('success'),'system/menu/'.$id);
		}
		else {
			message($this->lang->line('failure'),'system/menu/'.$id);
		}
	}
	public function menuEdit(){
		$bid=$this->uri->segment(3);
		$bid=$bid!==false?$bid:message($this->lang->line('error'),'system/menuGroup');
		$id=$this->uri->segment(4);
		$id=$id!==false?$id:message($this->lang->line('error'),'system/menu/'.$bid);
		$query=$this->db->get_where('menu_rights',array('id'=>$id));
		if ($query->num_rows()<=0) {
			message($this->lang->line('exists'),'system/menuGroup');
		}
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js','global.js'));
		$this->load->helper('form');
		$data['form']=form_open('system/menuEditSave',array('id'=>'form1'));
		$data['m']=$query->row_array();
		$this->load->view('head',$data);
		$this->load->view('system_menu_edit');
		$this->load->view('foot');
	}
	public function menuEditSave(){
		$bid=$this->input->post('bid');
		$bid=$bid?$bid:message($this->lang->line('error'));
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('error'),'system/menu/'.$bid);
		$url=$this->input->post('url');
		$url=$url?$url:message($this->lang->line('error'),'system/menu/'.$id);
		$paixun=$this->input->post('paixun');
		$paixun=$paixun?$paixun:255;
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->line('error'),'system/menu/'.$bid);
		$data=array('name'=>$name,'paixun'=>$paixun,'sourceMod'=>$url);
		$this->db->update('menu_rights',$data,array('id'=>$id));
		message($this->lang->line('success'),'system/menu/'.$bid);
	}
	public function menuDel(){
		$bid=$this->uri->segment(3);
		$bid=$bid!==false?$bid:message($this->lang->line('error'),'system/menuGroup');
		$id=$this->uri->segment(4);
		$id=$id!==false?$id:message($this->lang->line('error'),'system/menu/'.$bid);
		$this->db->delete('menu_rights',array('id'=>$id));
		message($this->lang->line('success'),'system/menu/'.$bid);
	}
	public function pswEdit(){
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js','global.js'));
		$this->load->helper('form');
		$data['form']=form_open('system/pswEditSave',array('id'=>'form1'));
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('system_password_edit.php');
		$this->load->view('foot');
	}
	public function pswEditSave(){
		$oldpsw=$this->input->post('old_psw');
		$oldpsw=$oldpsw?$oldpsw:message($this->lang->line('item_blank'),'system/pswEdit');
		$newpsw=$this->input->post('new_psw');
		$newpsw=$newpsw?$newpsw:message($this->lang->line('item_blank'),'system/pswEdit');
		$newpsw2=$this->input->post('new_psw2');
		$newpsw2=$newpsw2?$newpsw2:message($this->lang->line('item_blank'),'system/pswEdit');
		if ($newpsw!=$newpsw2) {
			message($this->lang->line('no_confirm'),'system/pswEdit');
		}
		$user=$this->db->get_where('admin',array('username'=>$this->session->userdata('username')));
		if ($user->num_rows()<=0) {
			message($this->lang->line('user_exists'),'system/pswEdit');
		}
		$user=$user->row();
		if ($user->password!=md5(md5($oldpsw).$user->salt)) {
			message($this->lang->line('old_psw'),'system/pswEdit');
		}
		$salt=substr(uniqid(mt_rand()),-6);
		$password=md5(md5($newpsw).$salt);
		$query=$this->db->update('admin',array('password'=>$password,'salt'=>$salt),array('username'=>$user->username));
		if ($this->db->affected_rows()>0) {
			message($this->lang->line('success'),'system/pswEdit');
		}
		else {
			message($this->lang->line('failure'),'system/pswEdit');
		}
	}
	public function log(){
		$default=array('name','stime','etime','page');
		$uridata=$this->uri->uri_to_assoc(3,$default);
		$name=$this->input->post('name');
		$name=$name?$name:$uridata['name'];
		$stime=$this->input->post('stime');
		$etime=$this->input->post('etime');
		$stime=$stime?$stime:$uridata['stime'];
		$etime=$etime?$etime:$uridata['etime'];
		$stimeamp=$stime?$this->common->makeTime('-',$stime,1):false;
		$etimeamp=$etime?$this->common->makeTime('-',$etime,2):false;
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'global.js','My97DatePicker/WdatePicker.js'));
		$this->load->helper('form');
		$data['form']=form_open('system/log',array('id'=>'form1'));
		$url=index_page().'/system/log';
		$this->db->select('b.username,a.*');
		$this->db->from('log as a');
		$this->db->join('admin as b','b.id=a.uid');
		if ($name) {
			$url.='/name/'.$name;
			$this->db->where('b.username',$name);
		}
		if ($stime) {
			$url.='/stime/'.$stime;
			$this->db->where('a.created >=',$stimeamp);
		}
		if ($etime) {
			$url.='/etime/'.$etime;
			$this->db->where('a.created <=',$etimeamp);
		}
		$this->db->order_by('a.id','desc');
		$db=clone $this->db;
		$query=$this->db->get();
		$total=$query->num_rows();
		$url=base_url($url.'/page/');
		$segment=array_search('page',$this->uri->segment_array())+1;
		$this->load->library('pagination');
		$config=$this->common->pageConfig($url,$total,15,$segment);
		$this->pagination->initialize($config);
		$db->limit($config['per_page'],$this->uri->segment($config['uri_segment'],0));
		$result=$db->get();
		$data['log']=$result->result_array();
		$data['name']=$name?$name:'';
		$data['stime']=$stime?$stime:'';
		$data['etime']=$etime?$etime:'';
		$this->load->view('head',$data);
		$this->load->view('system_log');
		$this->load->view('foot');
	}
	public function module(){
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js','global.js'));
		$this->load->helper('form');
		$data['form']=form_open('system/moduleSave',array('id'=>'form1'));
		$data['module']=$this->system->module();
		$this->load->view('head',$data);
		$this->load->view('system_module');
		$this->load->view('foot');
	}
	public function moduleSave(){
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('error'),'system/module');
		$this->db->insert('mod',array('name'=>$name));
		if ($this->db->affected_rows()>0) {
			message($this->lang->line('success'),'system/module');
		}
		else {
			message($this->lang->line('failure'),'system/module');
		}
	}
	public function moduleEdit(){
		$id=$this->uri->segment(3);
		$id=$id!==false?$id:message($this->lang->line('error'),'system/module');
		$query=$this->db->get_where('mod',array('id'=>$id));
		if ($query->num_rows()<=0) {
			message($this->lang->line('exists'),'system/module');
		}
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$this->load->helper('form');
		$data['form']=form_open('system/moduleEditSave',array('id'=>'form1'));
		$data['m']=$query->row();
		$this->load->view('head',$data);
		$this->load->view('system_module_edit');
		$this->load->view('foot');
	}
	public function moduleEditSave(){
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('error'),'system/module');
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->line('error'),'system/module');
		$this->db->update('mod',array('name'=>$name),array('id'=>$id));
		message($this->lang->line('success'),'system/module');
	}
	public function moduleDel(){
		$id=$this->uri->segment(3);
		$id=$id?$id:message($this->lang->line('error'),'system/module');
		$query=$this->db->get_where('mod_rights',array('modid'=>$id));
		if ($query->num_rows()>0) {
			message($this->lang->line('module_no_blank'),'system/module');
		}
		$query=$this->db->delete('mod',array('id'=>$id));
		if ($query) {
			message($this->lang->line('success'),'system/module');
		}
		else {
			message($this->lang->line('failure'),'system/module');
		}
	}
	public function modRights(){
		$id=$this->uri->segment(3);
		$id=$id!==false?$id:message($this->lang->line('error'),'system/module');
		$rights=$this->system->moduleRights($id);
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js','global.js'));
		$this->load->helper('form');
		$data['form']=form_open('system/modRightsSave',array('id'=>'form1'));
		$data['rights']=$rights;
		$data['id']=$id;
		$this->db->select_max('rights','rights');
		$query=$this->db->get('mod_rights');
		$query=$query->row();
		$right=$query->rights+1;
		$data['right']=$right;
		$this->load->view('head',$data);
		$this->load->view('system_module_rights');
		$this->load->view('foot');
	}
	public function modRightsSave(){
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->line('error'),'system/module');
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('error'),'system/modRights/'.$id);
		$right=$this->input->post('rights');
		$right=$right?$right:message($this->lang->line('error'),'system/modRights/'.$id);
		$this->db->insert('mod_rights',array('modid'=>$id,'right_name'=>$name,'rights'=>$right));
		if ($this->db->affected_rows()>0) {
			message($this->lang->line('success'),'system/modRights/'.$id);
		}
		else {
			message($this->lang->line('failure'),'system/modRights/'.$id);
		}
	}
	public function modRightsEdit(){
		$id=$this->uri->segment('3');
		$id=$id!==false?$id:message($this->lang->line('error'),'system/module');
		$query=$this->db->get_where('mod_rights',array('id'=>$id));
		if ($query->num_rows()==0) {
			message($this->lang->line('exists'),'system/modRights/'.$id);
		}
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$this->load->helper('form');
		$data['form']=form_open('system/modRightsEditSave',array('id'=>'form1'));
		$data['rights']=$query->row();
		$this->load->view('head',$data);
		$this->load->view('system_module_rights_edit');
		$this->load->view('foot');
	}
	public function modRightsEditSave(){
		$mod=$this->input->post('modid');
		$mod=$mod?$mod:message($this->lang->line('error'),'system/module');
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->line('error'),'system/modRights/'.$mod);
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('error'),'system/modRights/'.$mod);
		$right=$this->input->post('rights');
		$right=$right?$right:message($this->lang->line('error'),'system/modRights/'.$mod);
		$data=array('right_name'=>$name,'rights'=>$right);
		$this->db->where('id !=',$id);
		$this->db->where('rights',$right);
		$query=$this->db->get('mod_rights');
		if ($query->num_rows()>0) {
			message($this->lang->line('mod_right_exists'),'system/modRights/'.$mod);
		}
		$this->db->update('mod_rights',$data,array('id'=>$id));
		message($this->lang->line('success'),'system/modRights/'.$mod);
	}
	public function modRightsDel(){
		$mod=$this->uri->segment(3);
		$mod=$mod!==false?$mod:message($this->lang->line('error'),'system/module');
		$id=$this->uri->segment(4);
		$id=$id!==false?$id:message($this->lang->line('error'),'system/modRights/'.$mod);
		$query=$this->db->delete('mod_rights',array('id'=>$id));
		if ($query) {
			message($this->lang->line('success'),'system/modRights/'.$mod);
		}
		else {
			message($this->lang->line('failure'),'system/modRights/'.$mod);
		}
	}
	public function role(){
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js','global.js'));
		$this->load->helper('form');
		$data['form']=form_open('system/roleSave',array('id'=>'form1'));
		$total=$this->db->count_all('role');
		$url=base_url(index_page().'/system/role');
		$config=$this->common->pageConfig($url,$total,15,3);
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$this->db->limit($config['per_page'],$this->uri->segment($config['uri_segment'],0));
		$query=$this->db->get('role');
		$data['role']=$query->result_array();
		$this->load->view('head',$data);
		$this->load->view('system_role');
		$this->load->view('foot');
	}
	public function roleSave(){
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('error'),'system/role');
		$this->db->insert('role',array('name'=>$name,'flag'=>'1','created'=>time()));
		if ($this->db->affected_rows()>0) {
			message($this->lang->line('success'),'system/role');
		}
		else {
			message($this->lang->line('failure'),'system/role');
		}
	}
	public function setRoleStatus(){//更新菜单的状态
		$id=$this->uri->segment(4,0);
		$id=$id?$id:message($this->lang->line('error'),'system/role');
		$flag=$this->uri->segment(6,0);
		$flag=$flag?$flag:message($this->lang->line('error'),'system/role');
		$url='system/setRoleStatus/id/'.$id;
		if ($flag==1) {
			$url.='/flag/2';
		}
		else {
			$url.='/flag/1';
		}
		$this->db->where('id',$id);
		$this->db->update('role',array('flag'=>$flag));//设置是否显示
		$url=site_url($url);
		if ($this->db->affected_rows()) {
			if ($flag==1) {
				echo '<img src="'.base_url('images/yes.gif').'" onclick=setType(this,"'.$url.'") title="可编辑" />';
			}
			else {
				echo '<img src="'.base_url('images/no_gray.gif').'" onclick=setType(this,"'.$url.'") title="可编辑" />';
			}
		}
	}
	public function roleEdit(){
		$id=$this->uri->segment(3);
		$id=$id!==false?$id:message($this->lang->Line('error'),'system/role');
		$query=$this->db->get_where('role',array('id'=>$id));
		if ($query->num_rows()==0) {
			message($this->lang->Line('exists'),'system/role');
		}
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$this->load->helper('form');
		$data['form']=form_open('system/roleEditSave',array('id'=>'form1'));
		$data['role']=$query->row();
		$this->load->view('head',$data);
		$this->load->view('system_role_edit');
		$this->load->view('foot');
	}
	public function roleEditSave(){
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->Line('error'),'system/role');
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->Line('error'),'system/role');
		$this->db->update('role',array('name'=>$name),array('id'=>$id));
		message($this->lang->Line('success'),'system/role');
	}
	public function roleDel(){
		$id=$this->uri->segment(3);
		$id=$id?$id:message($this->lang->line('error'),'system/role');
		$query=$this->db->get_where('role',array('id'=>$id));
		if ($query->num_rows()==0) {
			message($this->lang->line('exists'),'system/role');
		}
		$this->db->delete('role',array('id'=>$id));
		message($this->lang->line('success'),'system/role');
	}
	public function assignRight(){
		$id=$this->uri->segment(3);
		$id=$id!==false?$id:message($this->lang->Line('error'),'system/role');
		$mod=$this->system->moduleRightsList();
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js));
		$this->load->helper('form');
		$data['form']=form_open('system/assignRightSave',array('id'=>'form1'));
		$data['mod']=$mod;
		$data['rights']=$this->system->roleRights($id);
		$data['role']=$id;
		$this->load->view('head',$data);
		$this->load->view('system_right_assign');
		$this->load->view('foot');
	}
	public function assignRightSave(){
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->Line('error'),'system/role');
		$rights=array();
		foreach ($this->input->post() as $k=>$v){
			if (substr($k,0,5)=='right') {
				$rights[]=$v;
			}
		}
		if (count($rights)==0) {
			$this->db->update('role',array('rights'=>''),array('id'=>$id));
		}
		else {
			$this->db->update('role',array('rights'=>implode(',',$rights)),array('id'=>$id));
		}
		message($this->lang->Line('success'),'system/role');
	}
	public function assignMenu(){
		$id=$this->uri->segment(3);
		$id=$id!==false?$id:message($this->lang->Line('error'),'system/role');
		$menu=$this->system->menuList();
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js));
		$this->load->helper('form');
		$data['form']=form_open('system/assignMenuSave',array('id'=>'form1'));
		$data['menus']=$menu;
		$usermenus=$usermenu=array();
		$usermenus=unserialize($this->system->roleMenus($id));
		if ($usermenus) {
			foreach ($usermenus as $k=>$v){
				foreach ($v['menu'] as $j=>$k){
					$usermenu[]=$k['id'];
				}
			}
		}
		$data['menu']=$usermenu;
		$data['role']=$id;
		$this->load->view('head',$data);
		$this->load->view('system_menu_assign');
		$this->load->view('foot');
	}
	public function assignMenuSave(){
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->Line('error'),'system/role');
		$menu=$menus=array();
		foreach ($this->input->post() as $k=>$v){
			if (substr($k,0,4)=='menu') {
				$menu[]=$v;
			}
		}
		if (count($menu)==0) {
			$data=array('menu'=>'');
		}
		else {
			foreach ($menu as $k=>$v){//检索出该角色所有的菜单组
				$group=$this->system->getMenuGroupById($v);
				if (!in_array($group,$menus)) {
					$menus[]=$group;
				}
			}
			foreach ($menus as $k=>$v){//组装好该角色所有的菜单组及菜单，以便进行序列化保存在数据表中
				$menulist=$this->system->menu($v);//检索该菜单组所有的菜单
				$usermenu[$k]['name']=$this->system->getGroupMenuNameById($v);//菜单组名称
				foreach ($menulist as $i=>$j){
					if (in_array($j['id'],$menu)) {
						$usermenu[$k]['menu'][]=$j;
					}
				}
			}
			$data=array('menu'=>serialize($usermenu));
		}
		$this->db->update('role',$data,array('id'=>$id));
		message($this->lang->Line('success'),'system/role');
	}
	/**
	 * 管理员列表
	 *
	 */
	public function master(){
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js','global.js'));
		$this->load->helper('form');
		$data['form']=form_open('system/masterSave',array('id'=>'form1'));
		$this->db->order_by('classic','desc');
		$db=clone $this->db;
		$total=$this->db->count_all('admin');
		$url=base_url(index_page().'/system/master/');
		$config=$this->common->pageConfig($url,$total,15,3);
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$db->limit($config['per_page'],$this->uri->segment($config['uri_segment'],0));
		$result=$db->get('admin');
		$result=$result->result_array();
		foreach ($result as $k=>$v){
			if ($v['classic'] =='1'){
				$result[$k]['role']='超级管理员';
			}
			else {
				$result[$k]['role']=$v['role_id']?$this->system->getRoleNameById($v['role_id']):'--';
			}
		}
		$data['m']=$result;
		$this->load->view('head',$data);
		$this->load->view('system_master');
		$this->load->view('foot');
	}
	public function masterSave(){
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('error'),'system/master');
		$psw=$this->input->post('psw');
		$psw=$psw?$psw:message($this->lang->line('new_psw'),'system/master');
		$psw2=$this->input->post('psw2');
		$psw2=$psw?$psw2:message($this->lang->line('new_psw'),'system/master');
		if ($psw!=$psw2) {
			message($this->lang->line('no_confirm'),'system/master');
		}
		$salt=substr(uniqid(mt_rand()),-6);
		$psw=md5(md5($psw).$salt);
		$this->db->insert('admin',array('username'=>$name,'password'=>$psw,'created'=>time(),'classic'=>'2','salt'=>$salt));
		if ($this->db->affected_rows()>0) {
			message($this->lang->line('success'),'system/master');
		}
		else {
			message($this->lang->line('failure'),'system/master');
		}
	}
	public function masterEdit(){
		$id=$this->uri->segment(3,0);
		$id=$id?$id:message($this->lang->line('error'),'system/master');
		$query=$this->db->get_where('admin',array('id'=>$id));
		if ($query->num_rows()==0) {
			message($this->lang->line('exists'),'system/master');
		}
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$this->load->helper('form');
		$data['form']=form_open('system/masterEditSave',array('id'=>'form1'));
		$data['id']=$id;
		$this->load->view('head',$data);
		$this->load->view('system_master_edit');
		$this->load->view('foot');
	}
	public function masterEditSave(){
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->line('error'),'system/master');
		$psw=$this->input->post('psw');
		$psw=$psw?$psw:message($this->lang->line('error'),'system/masterEdit/'.$id);
		$psw2=$this->input->post('psw2');
		$psw2=$psw2?$psw2:message($this->lang->line('error'),'system/masterEdit/'.$id);
		if ($psw!=$psw2) {
			message($this->lang->line('no_confirm'),'system/masterEdit/'.$id);
		}
		$salt=substr(uniqid(mt_rand()),-6);
		$psw=md5(md5($psw).$salt);
		$data=array('password'=>$psw,'salt'=>$salt);
		$this->db->update('admin',$data,array('id'=>$id));
		message($this->lang->line('success'),'system/master');
	}
	public function masterDel(){
		$id=$this->uri->segment(3,0);
		$id=$id?$id:message($this->lang->line('error'),'system/master');
		$query=$this->db->get_where('admin',array('id'=>$id));
		if ($query->num_rows()==0) {
			message($this->lang->line('exists'),'system/master');
		}
		$this->db->delete('admin',array('id'=>$id));
		message($this->lang->line('success'),'system/master');
	}
	public function masterRole(){
		$id=$this->uri->segment(3,0);
		$id=$id?$id:message($this->lang->line('error'),'system/master');
		$query=$this->db->get_where('admin',array('id'=>$id));
		if ($query->num_rows()==0) {
			message($this->lang->line('exists'),'system/master');
		}
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$this->load->helper('form');
		$data['form']=form_open('system/masterRoleSave',array('id'=>'form1'));
		$data['id']=$id;
		$data['role']=$this->system->role();
		$this->load->view('head',$data);
		$this->load->view('system_master_role');
		$this->load->view('foot');
	}
	public function masterRoleSave(){
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->line('exists'),'system/master');
		$role=$this->input->post('role');
		$role=$role?$role:message($this->lang->line('error'),'system/masterRole/'.$id);
		$this->db->update('admin',array('role_id'=>$role),array('id'=>$id));
		message($this->lang->line('success'),'system/master');
	}
	public function setMasterStatus(){//更新菜单的状态
		$id=$this->uri->segment(4,0);
		$id=$id?$id:message($this->lang->line('error'),'system/master');
		$flag=$this->uri->segment(6,0);
		$flag=$flag?$flag:message($this->lang->line('error'),'system/master');
		$url='system/setMasterStatus/id/'.$id;
		if ($flag==1) {
			$url.='/flag/2';
		}
		else {
			$url.='/flag/1';
		}
		$this->db->where('id',$id);
		$this->db->update('admin',array('flag'=>$flag));//设置是否显示
		$url=site_url($url);
		if ($this->db->affected_rows()) {
			if ($flag==1) {
				echo '<img src="'.base_url('images/yes.gif').'" onclick=setType(this,"'.$url.'") title="可编辑" />';
			}
			else {
				echo '<img src="'.base_url('images/no_gray.gif').'" onclick=setType(this,"'.$url.'") title="可编辑" />';
			}
		}
	}
}