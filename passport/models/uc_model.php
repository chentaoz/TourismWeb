<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'config/ucenter.php';
require_once APPPATH.'../uc_client/client.php';
class Uc_model extends CI_Model {

	protected $db_uc;

	public function __construct(){
		parent::__construct();
		$this->db_uc = $this->load->database('ucenter', TRUE);
	}

	/**
	 * 检测用户名
	 * @param  $username 会员名
	 * @return int 1：不存在（可以注册） -1：用户名非法 -2：用户名保留的 -3：用户名存在
	 */
	public function check_user_exit($username) {
		return uc_user_checkname($username);
	}

	/**
	 * 检测电子邮件
	 * @param
	 * @return int
	 */
	public function check_email_exit($email) {
		return uc_user_checkemail($email);
	}

	/**
	 * 用户名登录
	 * @param $username
	 * @param $password
	 * @return array|mixed|string
	 */
	public function user_login($username, $password) {
		#return uc_user_login($username, $password);
		$this->db->select('*');
		$this->db->where('username',$username);
		$this->db->or_where('email',$username);
		$row=$this->db->get('members')->row();
		$uid=0;$ucname='';$pwd=$password;$ucemail='';
		if($row){
			$ucemail=$row->email;
			$ucname=$row->username;
			if(md5($password)==$row->password){
				if($row->emailstatus==0){
					$uid=-3;
				}else{
					$uid=$row->uid;
				}
			}else{
				$uid=-2;
			}
		}else{
			$uid=-1;
		}
		return array($uid,$ucname,$pwd,$ucemail);
	}

	/**
	 * 获取同步登录js字符串
	 * @param $uid
	 * @return string 同步登录js字符串
	 */
	public function user_synlogin($uid) {
		return uc_user_synlogin($uid);
	}

	/**
	 * 获取用户email激活状态
	 * @param $uid
	 * @return int 0:未激活  1:已激活
	 */
	public function user_emailstatus($uid) {

		$this->db->select('emailstatus');
		$this->db->where('uid',$uid);
		$row=$this->db->get('members')->row();
		return $row->emailstatus;
	}

	/**
	 * 获取同步退出js字符串
	 * @param $uid
	 * @return string 同步退出js字符串
	 */
	public function user_synlogout() {
		return uc_user_synlogout();
	}

	/**
	 * 会员注册
	 * @param  $username 会员名, $password 密码, $email 邮件
	 * @return bool
	 */
	public function user_register($username, $password, $email) {
		$uid = uc_user_register($username, $password, $email);
		if($uid >0) {
			$ip = $this->input->ip_address();
			$time = time();

			$userdata = array(
				'uid'=>$uid,
				'username'=>$username,
				'password'=>md5($password),
				'email'=>$email,
				'regip' => $ip,
				'lastip' => '',
				'regdate'=>$time,
				'lastdate'=>$time
			);
			$this->db->insert('members', $userdata); //插入本地库

			unset($userdata);
            $this->db->insert('members_profile', array('uid'=>$uid));//插入用户详细信息表ID
			$userdata = array(
				'uid'=>$uid,
				'username'=>$username,
				'password'=>md5($password),
				'email'=>$email,
				'adminid'=>0,
				'groupid'=>10,
				'regdate'=>$time,
				'credits'=>0,
				'timeoffset'=>9999
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

			$this->db_uc->where('skey','lastmember');
			$this->db_uc->update('common_setting', array('svalue'=>$username));
		}
		return $uid;
	}

	/**
	 * 用户邮箱激活验证
	 * @param $uid
	 */
	public function user_activate($uid) {
		$this->db_uc->where('uid',$uid);
		$this->db_uc->update('common_member', array('emailstatus'=>1));

        $this->db->where('uid',$uid);
        $this->db->update('members', array('emailstatus'=>1));
	}

	/**
	 * 更新用户信息
	 * @param $uid
	 * @param $arr
	 */
	public function user_update($uid,$arr) {
		$this->db->where('uid',$uid);
		return $this->db->update('members', $arr);
	}

    /**
     * 找回密码更新用户信息
     * @param $uid
     * @param $arr
     */
    public function user_update_key($where,$date) {
        $this->db->where('email',$where);
      return $this->db->update('members', $date);
    }

    /*
    * update 更改信息
    * */
    public function uc_update($table, $data = array(), $uid)
    {
        $this->db_uc->where('uid', $uid);
        return $this->db_uc->update($table, $data);
    }

   /*判断用户是否是冻结状态
    *
    * */
   public function is_freeze($uid){
     return   $this->db->get_where('members',array('status'=>1,'uid'=>$uid))->num_rows();;

   }

}
