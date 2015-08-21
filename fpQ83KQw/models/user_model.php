<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	/**
	 * 用来保存用户的留言
	 *
	 * @param unknown_type $comments：数组类型,必须含有uid，body两个键名,
	 * @return unknown：成功则返回插入后的主键id，失败返回false
	 */
	public function comments_add($comments){
		if (!is_array($comments)) {
			return false;
		}
		if (!array_key_exists('uid',$comments)||!array_key_exists('body',$comments)) {
			return false;
		}
		$comments['created']=array_key_exists('created',$comments)?$comments['created']:time();
		$r=$this->db->insert('comments',$comments);
		if ($this->db->affected_rows()>0) {
			return $this->db->insert_id();
		}
		return false;
	}

	/**
	 * 获取用户列表
	 * @param $uid
	 * @return mixed
	 */
	public function get_members($uid){
		$query=$this->db->query("select * from ".$this->db->dbprefix."members where uid in(".$uid.");");
		$rs=$query->result_array();
		return $rs;
	}
	
}