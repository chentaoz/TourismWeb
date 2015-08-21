<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Uc_model extends CI_Model
{

    protected $db_uc;

    public function __construct()
    {
        parent::__construct();
        $this->db_uc = $this->load->database('ucenter', TRUE);
    }

    /**
     * 检测用户名
     * @param  $username 会员名
     * @return int 1：不存在（可以注册） -1：用户名非法 -2：用户名保留的 -3：用户名存在
     */
    public function check_user_exit($username)
    {
        return uc_user_checkname($username);
    }

    /**
     * 检测电子邮件
     * @param
     * @return int
     */
    public function check_email_exit($email)
    {
        return uc_user_checkemail($email);
    }


    /**
     * 会员注册
     * @param  $username 会员名, $password 密码, $email 邮件
     * @return bool
     */
    public function user_register($username, $password, $email)
    {
        $uid = uc_user_register($username, $password, $email);
        if ($uid > 0) {
            $ip = $this->input->ip_address();
            $time = time();
            $userdata = array(
                'uid' => $uid,
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'adminid' => 0,
                'groupid' => 10,
                'regdate' => $time,
                'credits' => 0,
                'timeoffset' => 9999
            );
            $this->db_uc->insert('common_member', $userdata);

            $status_data = array(
                'uid' => $uid,
                'regip' => $ip,
                'lastip' => '',
                'lastvisit' => $time,
                'lastactivity' => $time,
                'lastpost' => 0,
                'lastsendmail' => 0
            );
            $this->db_uc->insert('common_member_status', $status_data);
            $this->db_uc->insert('common_member_profile', array('uid' => $uid));
            $this->db_uc->insert('common_member_field_forum', array('uid' => $uid));
            $this->db_uc->insert('common_member_field_home', array('uid' => $uid));
            $this->db_uc->insert('common_member_count', array('uid' => $uid));

            $this->db_uc->where('skey', 'lastmember');
            $this->db_uc->update('common_setting', array('svalue' => $username));

        }
        return $uid;
    }

    /*
    * 更新用户信息
    * */
    public function up_user($uid,$main_data=array(),$pro_data=array()){
        $where=array('uid'=>$uid);
        $this->db->trans_start();
        if(!empty($main_data)){
            $this->db->where($where);
            $this->db->update('members', $main_data);
        }
        //用户相信资料
        $this->db->where($where);
        $this->db->update('members_profile', $pro_data);
        //更新完本地数据库 更新UC
        if(!empty($main_data)){  //有用户名和邮箱信息修改的时候
        $this->db_uc->where($where);
        $this->db_uc->update('common_member', $main_data);
        $this->db_uc->update('ucenter_members', $main_data);

        }
        $this->db->trans_complete();
        if ($this->db->trans_status()===true) {
            $this->db->trans_commit();
            return true;

        }
        else {
            $this->db->trans_rollback();
            return false;
        }
    }
    /*
     * 冻结用户
     * $data 本地更新字段
     * $data2 discuz 更新字段
     * */
    public function change_sta($uid,$data,$data2){
        $where=array('uid'=>$uid);
        //更新本地表 状态字段
        $this->db->where($where);
        $this->db->update('members',$data);
        //更新完本地数据库 更新dis freeze
        $this->db_uc->where($where);
        $res= $this->db_uc->update('common_member',$data2);
       return $res;
    }
    /*邮箱激活
     *
     * **/

    public function email_statue($uid){
        $data=array('emailstatus'=>1);
        $where=array('uid'=>$uid);
        //更新本地表 状态字段
        $this->db->where($where);
        $this->db->update('members',$data);
        //更新完本地数据库 更新dis 邮箱状态
        $this->db_uc->where($where);
        $res= $this->db_uc->update('common_member',$data);
        return $res;


    }
}