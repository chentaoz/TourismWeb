<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bag_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
  /*
   * 获取运动背包
   * */
  public function get_bag($spid=0){
          $s = "SELECT * FROM xcenter_taxonomy_term where exists ( SELECT * FROM ".$this->db->dbprefix."taxonomy_term_hierarchy WHERE ".$this->db->dbprefix."taxonomy_term_hierarchy.ttid = ".$this->db->dbprefix."taxonomy_term.ttid AND parent = ( SELECT term_id FROM ".$this->db->dbprefix."sport_taxonomy WHERE sport_id =  ".$spid." AND taxonomy_id = 2 )
)";
        $q = $this->db->query($s);
      if ($q->num_rows()==0) {
          return false;
      }
      return $q->result_array();
  }


}