<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	/**
	 * 系统中户外活动的统计
	 *
	 * @return unknown
	 */
	public function sports_total(){
		$this->db->select('spid');
		$this->db->where('del',0);
		$this->db->where('sta',0);
		$this->db->from('sport');
		return $this->db->count_all_results();
	}
	public function bags_total(){
		$this->db->select('uid');
		$this->db->where('del',0);
		$this->db->where('sta',0);
		$this->db->from('bag');
		return $this->db->count_all_results();
	}
}