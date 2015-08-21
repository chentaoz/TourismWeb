<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'core/MY_UserController.php';
class Space_att extends MY_UserController {
    public function __construct(){
        parent::__construct();
        $this->load->model('common_model','common');
        $this->load->model('sport_model','sport');
        $this->load->model('place_model','place');
        $this->load->model('uc_model','uc');
        $s_uid=intval($this->uri->segment(2));//访问用户的ID
        $this->member = $this->get_member($s_uid);
    }
  /*
   * 空间他的关注
   * */
public function index(){
    $user=$this->member;
    $this->load->vars('meta', $this->meta);
    $this->load->vars('title', $this->title($user['username'].'的关注'));
    $this->load->vars('keywords', $this->keywords);
    $this->load->vars('description', $this->description);
//    $this->load->vars('css', $this->css(array('base.css', 'user.css','member.css')));
//    $this->load->vars('js', $this->js('layer-v1.8.5/layer/layer.min.js'));
    //我的好友个数
    $data['friends_num'] = $total = $this->uc->friend_totalnum($user['uid'], $direction = 0);
    //我的好友列表
    $page = $this->get_uri_segment(3);
    $pagesize = 10;
    $data['friends'] = $this->uc->friend_ls($user['uid'], $page, $pagesize, $total);
    $data['link'] = $this->get_pagination('space_att/'.$user['uid'], 3, 7, $total, $pagesize);
    $data['header_info']=$user;
    $data['space']='space';//标志是空间的
    $this->load->view('user/my_attention', $data);


   }
}