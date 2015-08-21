<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_UserController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user_model');
    }

    /**
     * 获取关注好友数量
     * @param int $uid
     * @return mixed
     */
    protected function get_friends_num($uid=0){
        $num=$this->uc->friend_totalnum($uid,0);
        return $num;
    }

    /**
     * 获取被关注好友数量
     * @param int $uid
     * @return mixed
     */
    protected function get_fans_num($uid=0){
        $num=$this->uc->att_num($uid);
        return $num;
    }

    /**
     * 获取用户详细资料
     * @param int $uid
     * @return mixed
     */
    protected function get_member($uid=0){
        $uid=$this->get_uid($uid);
        $this->load->model('sport_model', 'sport');
        $members=$this->sport->get_user_info($uid);
        $member=$members;
        $friend_num=$this->get_friends_num($uid);
        $fans_num=$this->get_fans_num($uid);
        $member['friends_num']=$friend_num;
        $member['fans_num']=$fans_num;
        $sports=$this->get_user_like_sport($uid);
        $member['like_sports']=$sports;
       // $member['forum_together']=;
        $member['forum_post']=$this->get_threads_num($uid,Category_post)+$this->get_threads_num($uid,Category_together);
        $member['forum_travel']=$this->get_threads_num($uid,Category_travel);
        $member['forum_guide']=$this->get_threads_num($uid,Category_guide);
        $member['check_attend']=$this->check_attend($uid);
        return $member;
    }

    /**
     * 获取主题数量
     * @param int $uid
     * @param string $category
     * @return mixed
     */
    protected function get_threads_num($uid=0,$category=''){
        $num=$this->uc->dz_get_forum_threads_num(-1,$category,'',$uid);
        return $num;
    }

    /**
     * 获取用户喜欢的运动
     * @param $uid
     * @return array
     */
    protected function get_user_like_sport($uid){
        $uid=$this->get_uid($uid);
        $this->load->model('sport_model','sport');
        $like_sport=$this->sport->get_save_sport($uid);

        return $like_sport;
    }
    /*判断是否关注过
     * */
   protected function check_attend($uid){
      return $this->uc->friend_exit($this->uid, $uid, $comment = '');
   }


}