<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	/**
	 * 一级分类
	 *
	 * @return unknown
	 */
	public function Bclass(){
		$r=$this->db->order_by('paixun','asc')->order_by('id','desc')->get('article_bclass');
		return $r->result_array();
	}
	/**
	 * 指定一级分类下的所有二级分类
	 *
	 * @param unknown_type $bid
	 * @return unknown
	 */
	public function Sclass($bid){
		$r=$this->db->where(array('bid'=>$bid))->order_by('paixun','asc')->order_by('id','desc')->get('article_sclass');
		return $r->result_array();
	}
	/**
	 * 所有一级分类与二级分类
	 *
	 * @return unknown
	 */
	public function classic(){
		$bclass=$this->Bclass();
		foreach ($bclass as $k=>$v){
			$bclass[$k]['sclass']=$this->Sclass($v['id']);
		}
		return $bclass;
	}
	/**
	 * 根据标示，id返回相应的分类信息
	 *
	 * @param unknown_type $id
	 * @param unknown_type $flag
	 * @return unknown
	 */
	public function getClass($id,$flag='big'){
		switch ($flag){
			case 'big':
				$table='article_bclass';
				break;
			case 'small':
				$table='article_sclass';
				break;
		}
		$r=$this->db->get_where($table,array('id'=>$id));
		return $r->num_rows()?$r->row_array():false;
	}
	/**
	 * 根据二级分类id检索其一级分类id
	 *
	 * @param unknown_type $sid
	 * @return unknown
	 */
	public function getBidBySid($sid){
		$r=$this->db->get_where('article_sclass',array('id'=>$sid));
		if ($r->num_rows()==0) {
			return false;
		}
		$r=$r->row_array();
		return $r['bid'];
	}
	/**
	 * 检索出某篇信息
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function getNews($id){
		$news=$this->db->get_where('article',array('id'=>$id));
		if ($news->num_rows()==0) {
			return false;
		}
		return $news->row_array();
	}
}