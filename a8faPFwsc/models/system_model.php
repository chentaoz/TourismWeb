<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function isLogin(){//检测用户是否登陆
		$this->load->library('session');
		$this->load->helper('message');
		$this->lang->load('user');
		if ($this->session->userdata('login_flag')!='ok') {
			message($this->lang->line('user_not_login'),'',1);
		}
	}
	public function log($uid){//记录登陆者的ip与时间信息
		$ip=$this->input->ip_address();
		$data=array('uid'=>$uid,'ip'=>$ip,'created'=>time());
		$this->db->insert('log',$data);
	}
	/**
	 * 验证用户是否具有操作权限
	 *
	 */
	public function verify($code){
		if ($this->session->userdata('classic')=='1') {//超级管理员拥有所有权限
			return true;
		}
		if (!in_array($code,$this->session->userdata('rights'))) {
			$this->lang->load('system');
			message($this->lang->line('no_right'),'welcome/home');
		}
		return true;
	}
	/**
	 * 检索所有模块
	 *
	 * @return unknown
	 */
	public function module(){
		$query=$this->db->get('mod');
		return $query->result_array();
	}
	/**
	 * 检索某个权限组下的所有权限
	 *
	 * @param unknown_type $mod
	 * @return unknown
	 */
	public function moduleRights($mod){
		$this->db->order_by('rights','asc');
		$query=$this->db->get_where('mod_rights',array('modid'=>$mod));
		if ($query->num_rows==0) {
			return array();
		}
		return $query->result_array();
	}
	/**
	 * 检索所有权限组及其权限，并以关联数组返回
	 *
	 * @return unknown
	 */
	public function moduleRightsList(){
		$mod=$this->module();
		foreach ($mod as $k=>$v){
			$mod[$k]['rights']=$this->moduleRights($v['id']);
		}
		return $mod;
	}
	/**
	 * 检索某个角色的权限
	 *
	 * @param unknown_type $role
	 * @return unknown：数组形式返回
	 */
	public function roleRights($role){
		$query=$this->db->get_where('role',array('id'=>$role));
		if ($query->num_rows()==0) {
			return false;
		}
		$result=$query->row();
		return explode(',',$result->rights);
	}
	/**
	 * 检索所有的菜单组
	 *
	 * @param bool $flag：true时则检索所有菜单，false时则检索可见菜单
	 * @return unknown
	 */
	public function menuGroup($flag=true){
		if (!$flag) {
			$this->db->where('flag',1);
		}
		$this->db->order_by('paixun','desc');
		$this->db->order_by('id','desc');
		$query=$this->db->get('menu');
		if ($query->num_rows()==0) {
			return false;
		}
		return $query->result_array();
	}
	/**
	 * 检索某菜单组下的所有菜单
	 *
	 * @param unknown_type $id
	 * @param bool $flag：true时则检索所有菜单，false时则检索可见菜单
	 * @return unknown
	 */
	public function menu($id,$flag=true){
		if (!$flag) {
			$this->db->where('flag',1);
		}
		$this->db->where('menu_id',$id);
		$this->db->order_by('paixun','desc');
		$this->db->order_by('id','desc');
		$query=$this->db->get('menu_rights');
		if ($query->num_rows()==0) {
			return false;
		}
		return $query->result_array();
	}
	/**
	 * 检索所有菜单
	 * 
	 * @param bool $flag：true时则检索所有菜单，false时则检索可见菜单
	 * @return unknown
	 */
	public function menuList($flag=true){
		$menu=$this->menuGroup($flag);
		foreach ($menu as $k=>$v){
			$menu[$k]['menu']=$this->menu($v['id'],$flag);
		}
		return $menu;
	}
	/**
	 * 检索某个角色的所有菜单
	 *
	 * @param unknown_type $role
	 * @return unknown
	 */
	public function roleMenus($role){
		$query=$this->db->get_where('role',array('id'=>$role));
		if ($query->num_rows()==0) {
			return false;
		}
		$result=$query->row();
		return $result->menu;
	}
	/**
	 * 检索某个角色的所有菜单组
	 *
	 * @param unknown_type $role
	 * @return unknown
	 */
	public function roleGroupMenus($role){
		$query=$this->db->get_where('role',array('id'=>$role));
		if ($query->num_rows()==0) {
			return false;
		}
		$result=$query->row();
		return explode(',',$result->menu_group);
	}
	/**
	 * 根据菜单id检索出其菜单组id
	 *
	 * @param unknown_type $menu
	 * @return unknown
	 */
	public function getMenuGroupById($menu){
		$query=$this->db->get_where('menu_rights',array('id'=>$menu));
		if ($query->num_rows()==0) {
			return false;
		}
		$query=$query->row();
		return $query->menu_id;
	}
	/**
	 * 通过菜单组id检索其名称
	 *
	 * @param unknown_type $gid
	 * @return unknown
	 */
	public function getGroupMenuNameById($gid){
		$query=$this->db->get_where('menu',array('id'=>$gid));
		if ($query->num_rows()==0) {
			return false;
		}
		$m=$query->row();
		return $m->name;
	}
	/**
	 * 根据角色id检索出角色名称
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function getRoleNameById($id){
		$query=$this->db->get_where('role',array('id'=>$id));
		if ($query->num_rows()==0) {
			return false;
		}
		$q=$query->row();
		return $q->name;
	}
	/**
	 * 检索所有角色
	 *
	 * @return unknown
	 */
	public function role(){
		$query=$this->db->get('role');
		if ($query->num_rows()==0) {
			return false;
		}
		return $query->result_array();
	}
	/**
	 * 检索用户的信息
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function getUser($id){
		$query=$this->db->get_where('admin',array('id'=>$id));
		if ($query->num_rows()==0) {
			return false;
		}
		return $query->row();
	}
	/**
	 * 检索某个角色的信息
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function getRole($id){
		$query=$this->db->get_where('role',array('id'=>$id));
		if ($query->num_rows()==0) {
			return false;
		}
		return $query->row();
	}
}