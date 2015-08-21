<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'core/MY_UserController.php';
class Space_photo extends MY_UserController {
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
   * 空间照片首页
   * */
public function index($uid){
    $members=$this->check_space_user();//检测是否存在用户
    $this->load->vars('meta', $this->meta);
    $this->load->vars('title', $this->title($members['username'].'的照片'));
    $this->load->vars('keywords', $this->keywords);
    $this->load->vars('description', $this->description);
//    $this->load->vars('css',$this->css(array('base.css','member.css','jquery.lightbox.css')));
//    $this->load->vars('js', $this->js(array('lightbox/jquery.lightbox.min.js')));
    $data['space']='space';//标志是空间的
    /***************上面通用数据*****************/
    //查询此用户照片年份数组
    $year=$this->sport->sql_query("SELECT from_unixtime(created,'%Y') as year from ".$this->db->dbprefix."photo WHERE uid='{$members['uid']}'GROUP BY  from_unixtime(created,'%Y') ORDER BY created DESC");
    /*转换为一位数组*/
    $new_y=array();
    foreach($year as $y){
        $new_y[]=$y['year'];
    }
    //此年下面的按月查找的单条代表数据
    foreach($new_y as $key=>$y){
        $year[$key]['mounth']=$this->sport->sql_query("SELECT  filename,from_unixtime(created,'%c') as m  ,count(*) as num from ".$this->db->dbprefix."photo WHERE uid='{$members['uid']}' AND from_unixtime(created,'%Y')={$y} GROUP BY  from_unixtime(created,'%Y%c') ORDER BY created DESC");

    }
    //赋值给模版
    $uid=$this->get_uid($uid);
    $this->set_self($uid); //设置 当前页面是否属于自己的
    $data['year']=$year;
    $data['header_info']=$this->member;
    $this->load->view('user/photo',$data);
}

}