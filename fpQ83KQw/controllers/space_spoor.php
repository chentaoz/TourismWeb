<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'core/MY_UserController.php';
class Space_spoor extends MY_UserController {
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
   * 空间足迹首页
   * */
public function index(){
    $members=$this->check_space_user();//检测是否存在用户
    $this->load->vars('meta', $this->meta);
    $this->load->vars('title', $this->title($members['username'].'的足迹'));
    $this->load->vars('keywords', $this->keywords);
    $this->load->vars('description', $this->description);
//    $this->load->vars('css',$this->css(array('base.css','member.css','jquery.lightbox.css')));
//    $this->load->vars('js', $this->js(array('jquery.min.js','lightbox/jquery.lightbox.min.js')));
    //关注数
    $data['space']='space';//标志是空间的
    /***************上面通用数据*****************/
    //获取去过多少个国家和城市
    $data['country']= $this->sport->get_statistics($members['uid'],1);
    $data['city']= $this->sport->get_statistics($members['uid'],2);
    //连表获取去过的国家
    $countrys = $this->sport->sql_query("select pid,name,name_en from " . $this->db->dbprefix . "place_visit LEFT JOIN " . $this->db->dbprefix . "place on country=pid where uid={$members['uid']} and beento=1 GROUP BY country");
    foreach ($countrys as $key => $c) {
        //查询这个国家下面的城市
        $countrys[$key]['city'] = $this->sport->sql_query("select parent,pid,name,name_en,img from " . $this->db->dbprefix . "place_visit LEFT JOIN " . $this->db->dbprefix . "place on city=pid LEFT JOIN " . $this->db->dbprefix . "place_sport_images on pid=place_id where uid={$members['uid']} AND country={$c['pid']} AND city>0  and city>0 and beento=1 GROUP BY city,pid");
        //循环查此地点参加了几个运动
        foreach ($countrys[$key]['city'] as $k => $p) {
            $countrys[$key]['city'][$k]['view'] =$this->sport->total_view('place_visit', array('city !='=>'placeid','uid' =>$members['uid'], 'city' => $p['pid'], 'country' => $c['pid'], 'placeid !=' => 0,'beento'=>1,'city !='=>'placeid' ));
        }
    }
    $data['countrys']=$countrys;
    $data['header_info']=$this->member;
    $this->load->view('user/spoor',$data);
}


}