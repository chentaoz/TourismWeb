<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ad_model extends CI_Model {
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
		$r=$this->db->order_by('id','asc')->get('ads_bclass');
		return $r->result_array();
	}
	/**
	 * 指定一级分类下的所有二级分类
	 *
	 * @param unknown_type $bid
	 * @return unknown
	 */
	public function Sclass($bid){
		$r=$this->db->where(array('bid'=>$bid))->order_by('id','desc')->get('ads_sclass');
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
	 * 检索某广告位置的所有信息
	 *
	 * @param unknown_type $sid
	 * @return unknown
	 */
	public function getAdPos($sid){
		$this->db->where('id',$sid);
		$r=$this->db->get('ads_sclass');
		if ($r->num_rows()==0) {
			return false;
		}
		return $r->row_array();
	}
	/**
	 * 根据指定的位置id上传相应的广告图片,并验证图片是否符合指定位置的信息
	 *
	 * @param unknown_type $sid
	 * @return unknown:成功则返回上传后的图片名称，失败则返回false
	 */
	public function imgUpload($sid){
		$info=$this->getAdPos($sid);
		$config=array('upload_path'=>ROOTPATH.$this->config->item('upload_ad'),'allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>true,'max_size'=>$this->config->item('upload_size'),'max_width'=>$info['width'],'max_height'=>$info['height']);
		$this->load->library('upload',$config);
		if ($this->upload->do_upload()) {
			$imgdata=$this->upload->data();
			return $imgdata['file_name'];
		}
		else {
			return false;
		}
	}
}