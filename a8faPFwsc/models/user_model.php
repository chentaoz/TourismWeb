<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {
    protected $db_uc;

    public function __construct()
    {
        parent::__construct();

    }
    /*用户总数 james add*/
    public function count_user($key=''){
        if($key){
            $this->db->like('username',$key);
        }
        $this->db->from('members');
        return $this->db->count_all_results();
    }
    //用户分页数据
    public function user_list($keyword=null,$per_page,$offset){
        $this->db->from('members');
        if($keyword){
            $this->db->like('username',"$keyword");
        }
        $this->db->order_by('uid', 'asc');
        $q =$this->db-> limit($per_page,$offset,0)->get();
        return $q->result_array();
    }
    /*
     * 连表查询用户信息
     * */
    public function get_user_info($uid){
        $this->db->select('members.uid,username,email,status,address,gender,birthyear,birthmonth,birthday');
        $this->db->where(array('members.uid'=>$uid));
        $this->db->join('members_profile','members.uid=members_profile.uid','left');
        $r=$this->db->get('members');
        return  $res=  $r->row_array();


    }


	
}