<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'config/ucenter.php';
require_once APPPATH . '../uc_client/client.php';
if(!class_exists('Encryptor')) {
    require_once APPPATH . '../lib/RNCryptor/autoload.php';
}

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
     * 用户名登录
     * @param $username
     * @param $password
     * @return array|mixed|string
     */
    public function user_login($username, $password)
    {
        return uc_user_login($username, $password);
    }

    /**
     * 获取同步登录js字符串
     * @param $uid
     * @return string 同步登录js字符串
     */
    public function user_synlogin($uid)
    {
        return uc_user_synlogin($uid);
    }

    /**
     * 获取同步退出js字符串
     * @param $uid
     * @return string 同步退出js字符串
     */
    public function user_synlogout()
    {
        return uc_user_synlogout();
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

    /**
     * 用户邮箱激活验证
     * @param $uid
     */
    public function user_activate($uid)
    {
        $this->db_uc->where('uid', $uid);
        $this->db_uc->update('common_member', array('emailstatus' => 1));
    }

    /**
     * 判断好友是否已存在
     * @param $uid
     * @param $friendid
     * @param string $comment
     * @return int  0:已经存在或者失败   >0:成功
     */
    public function friend_exit($uid, $friendid, $comment = '')
    {
        $this->db_uc->where('uid', $uid);
        $this->db_uc->where('friendid', $friendid);
        $this->db_uc->from('ucenter_friends');
        $cnt = $this->db_uc->count_all_results();
        if ($cnt == 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * 添加好友
     * @param $uid
     * @param $friendid
     * @param string $comment
     * @return int  0:已经存在或者失败   >0:成功
     */
    public function friend_add($uid, $friendid, $comment = '')
    {
        $this->db_uc->where('uid', $uid);
        $this->db_uc->where('friendid', $friendid);
        #$this->db_uc->where('direction',1);
        $this->db_uc->from('ucenter_friends');
        $cnt = $this->db_uc->count_all_results();
        if ($cnt == 0) {
           return uc_friend_add($uid, $friendid, $comment);
        } else {
            return 0;
        }
    }

    /**
     * 删除好友
     * @param $uid
     * @param $friendids
     * @return mixed
     */
    public function friend_delete($uid, $friendids)
    {
        return uc_friend_delete($uid, $friendids);
    }

    /**
     * 获取好友个数
     * @param $uid
     * @param int $direction 好友关系标示，1:A加B为好友 2:B加了A为好友 3:A和B彼此都加为了好友
     * @return mixed
     */
    public function friend_totalnum($uid, $direction = 0)
    {
        return uc_friend_totalnum($uid, $direction);
    }

    /**
     * 获取好友列表
     * @param $uid
     * @param int $page
     * @param int $pagesize
     * @param int $totalnum
     * @param int $direction
     * @return array|mixed|string
     */
    public function friend_ls($uid, $page = 1, $pagesize = 10, $totalnum = 10, $direction = 0)
    {
        return uc_friend_ls($uid, $page, $pagesize, $totalnum, $direction);
    }

    /**
     * 获取论坛主题和帖子数量
     * @param int $fid
     * @return int|mixed
     */
    public function dz_get_forum_num($fid = 0)
    {
        if ($fid > 0) {
            $this->db_uc->select('threads,posts');
            $this->db_uc->where('fid', $fid);
        } else {
            $this->db_uc->select('sum(threads) threads,sum(posts) posts');
        }
        $query = $this->db_uc->get('forum_forum');
        $row = $query->row_array();#echo $this->db_uc->last_query();
        if ($row) {
            return $row;
        } else {
            return array('threads' => 0, 'posts' => 0);
        }
    }

    /**
     * 获取分类主题数量
     * @param string $category 分类ID 1:帖子 2:游记 3:攻略
     * @return int
     */
    public function dz_get_thread_num($category = '')
    {
        if ($category != '') {
            $this->db_uc->select('count(tid) cnt');
            $this->db_uc->where('category', $category);
        } else {
            $this->db_uc->select('count(tid) cnt');
        }
        $query = $this->db_uc->get('forum_thread');
        $row = $query->row_array();#echo $this->db_uc->last_query();
        if ($row) {
            return $row['cnt'];
        } else {
            return 0;
        }
    }

    /**
     * 根据名称获取论坛主题分类ID集合
     * @param $name
     * @return int
     */
    public function  dz_get_forum_typeid_by_name($name)
    {
        $this->db_uc->select("group_concat(typeid) AS typeid", FALSE);
        $this->db_uc->where('name', $name);
        $row = $this->db_uc->get('forum_threadclass')->row();
        if ($row) {
            return $row->typeid;
        } else {
            return '';
        }
    }

    /**
     * 获取主题列表
     * @param int $attachment 附件,0无附件 1普通附件 2有图片附件
     * @param int $currentpage 当前页
     * @param int $pagesize 每页多少条
     * @param string $category 分类ID 1:帖子 2:游记 3:攻略
     * @param string $wd subject、message 关键词
     * @param int $uid 用户ID
     * @param string $tids 主题ID集合
     * @return mixed|array
     */
    public function dz_get_forum_threads($attachment = -1,$currentpage=1,$pagesize=10, $category = '',$wd='',$ordrby='',$uid=0,$tids='')
    {
       $sql = 'select a.tid,a.fid,a.typeid,a.authorid,a.author,a.subject,a.dateline,a.lastpost,a.lastposter,
				a.views,a.replies,a.recommend_add,a.recommend_sub,a.favtimes,a.sharetimes,a.category,a.attachment attachmenttype,
				b.attachment,b.remote,c.name,d.message
				from pre_forum_thread a
				left join ' . $this->db_uc->dbprefix . 'forum_threadimage b on a.tid=b.tid
				left join ' . $this->db_uc->dbprefix . 'forum_forum c on a.fid=c.fid
				left join ' . $this->db_uc->dbprefix . 'forum_post d on a.tid=d.tid
				where d.`first`=1';
        if ($attachment > -1) {
            $sql .= ' and a.attachment=' . $attachment;
        }
        if ($uid > 0) {
            $sql .= ' and a.authorid=' . $uid;
        }
        if ($category != '') {
            $sql .= ' and a.category in ('.$category.')';
        }
        if ($tids != '') {
            $sql .= ' and a.tid in(' . $tids.')';
        }
        if ($wd != '') {
            $sql .= ' and (a.subject like \'%' . $wd . '%\' or d.message like \'%'.$wd.'%\')';
        }
        if ($ordrby != '') {
            $sql .= ' order by ' . $ordrby;
        }else {
            $sql .= ' order by a.tid desc';
        }
        $sql .= ' limit ' . ($currentpage-1)*$pagesize.','.$pagesize;

        $query = $this->db_uc->query($sql);
        $rs = $query->result_array();
        return $rs;
    }


    /**
     * 获取主题列表数量
     * @param int $attachment  附件,0无附件 1普通附件 2有图片附件
     * @param string $category  分类ID 1:帖子 2:游记 3:攻略
     * @param string $wd subject、message 关键词
     * @param int $uid 用户ID
     * @return mixed
     */
    public function dz_get_forum_threads_num($attachment = -1,$category = '',$wd='',$uid=0,$tids='')
    {
        $sql = 'select count(a.tid) num from pre_forum_thread a
				left join ' . $this->db_uc->dbprefix . 'forum_threadimage b on a.tid=b.tid
				left join ' . $this->db_uc->dbprefix . 'forum_forum c on a.fid=c.fid
				left join ' . $this->db_uc->dbprefix . 'forum_post d on a.tid=d.tid
				where d.`first`=1';
        if ($attachment > -1) {
            $sql .= ' and a.attachment=' . $attachment;
        }
        if ($uid > 0) {
            $sql .= ' and a.authorid=' . $uid;
        }
        if ($category != '') {
            $sql .= ' and a.category in ('.$category.')' ;
        }
        if ($tids != '') {
            $sql .= ' and a.tid in(' . $tids.')';
        }
        if ($wd != '') {
            $sql .= ' and (a.subject like \'%' . $wd . '%\' or d.message like \'%'.$wd.'%\')';
        }
        $query = $this->db_uc->query($sql);
        $rs = $query->row();
        return $rs->num;
    }

    /**
     *关注我的总数
     */
    public function att_num($uid)
    {
        $sql = "select count(*)as num from " . $this->db_uc->dbprefix . "ucenter_friends a LEFT JOIN " . $this->db_uc->dbprefix . "common_member b on a.uid=b.uid where a.friendid=$uid";
        $query = $this->db_uc->query($sql);
        $rs = $query->result_array();
        return $rs[0]['num'];
    }

    /**
     * 获取谁关注了我
     * */
    public function attention_me($uid, $offset, $row)
    {
        $sql = "select b.uid,username,direction from " . $this->db_uc->dbprefix . "ucenter_friends a LEFT JOIN " . $this->db_uc->dbprefix . "common_member b on a.uid=b.uid where a.friendid=$uid limit $offset,$row";
        $query = $this->db_uc->query($sql);
        return $rs = $query->result_array();
    }

    /*
     * update 更改信息
     * */
    public function uc_update($table, $data = array(), $uid)
    {
        $this->db_uc->where('uid', $uid);
        return $this->db_uc->update($table, $data);
    }

    /**
     * 获取 最多发帖人 ID 集合
     * @param int $limit
     * @return string 如：1,3,8
     */
    public function dz_get_forum_threads_top_uid($limit = 5)
    {
        $sql = "select group_concat(distinct authorid) uid from (
select a.authorid from " . $this->db_uc->dbprefix . "forum_thread a
order by a.replies desc) t limit " . $limit;

        $query = $this->db_uc->query($sql);
        $row = $query->row();
        if ($row) {
            return $row->uid;
        } else {
            return '';
        }
    }

    /**
     * 获取 最多回帖人 ID 集合
     * @param int $limit
     * @return string 如：1,3,8
     */
    public function dz_get_forum_posts_top_uid($limit = 5)
    {
        $sql = "select group_concat(authorid) uid from (
select count(*) postnum,a.authorid from pre_forum_post a
where a.`first`=0
group by a.authorid order by postnum desc limit " . $limit . "
) t ";

        $query = $this->db_uc->query($sql);
        $row = $query->row();
        if ($row) {
            return $row->uid;
        } else {
            return '';
        }
    }

    /**
     * 获取 收藏 ID 集合
     * @param int $uid
     * @param string $idtype  tid: 主题  pid:帖子
     * @return string 如：1,3,8
     */
    public function dz_get_favorite_ids($uid,$idtype='tid')
    {
        $sql = "select group_concat(distinct id) ids from " . $this->db_uc->dbprefix . "home_favorite";
        $sql .= ' where uid=' . $uid;
        if ($idtype != '') {
            $sql .= " and idtype='" . $idtype."'";
        }
        $query = $this->db_uc->query($sql);
        $row = $query->row();
        if ($row) {
            return $row->ids;
        } else {
            return '0';
        }
    }


    /**
     * 远程调用Discuz API
     * @param $action 方法名称
     * @param array $post 参数
     */
    public function dz_api($action,$post=array()){
        #$cryptor = new RNCryptor\Encryptor();
        $data['action']=$action;
        $data['post']=$post;
        $data['time']=time();
        #$code=urlencode($cryptor->encrypt(json_encode($data),ENCRYPT_KEY));
        $code=encode(json_encode($data),ENCRYPT_KEY);
        $result=do_curl_get_request(BBS_domian.'api/dz.php',array('code'=>$code),30);
        return trim($result);
    }
}