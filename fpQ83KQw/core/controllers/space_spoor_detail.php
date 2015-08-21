<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'core/MY_UserController.php';
class Space_spoor_detail extends MY_UserController {
    public function __construct(){
        parent::__construct();
        $this->load->model('common_model','common');
        $this->load->model('sport_model','sport');
        $this->load->model('place_model','place');
        $this->load->model('uc_model','uc');
    }
  /*
   * 空间足迹详情
   * */
    public function index()
    {
//        $this->load->vars('css', $this->css(array('member.css')));
//        $this->load->vars('js', $this->js('layer-v1.8.5/layer/layer.min.js'));
        $city_id = intval($this->uri->segment(2));
        $uid = intval($this->uri->segment(3));
       $uid=$uid?$uid:$this->uid;
        $data['header_info']=$member_info=$this->get_member($uid);
        if($uid!=$this->uid){
            $data['space']='space';//标志是空间的
            $title=$member_info['username'];
        }else{
            $title='我';
        }
        $this->load->vars('title', $this->title($title.'足迹'));
        if ($city_id <= 0) {
            message('参数错误', WWW_domian);
        }
        //获取城市下面的活动场点个数
        //用户的自己足迹信息
        $total=$this->sport->c_table_count_data('place','place_visit','place.pid=placeid',array('uid'=>$uid,'del' => 0, 'sta' => 0, 'city' => $city_id,'beento'=>1));
        $pagesize = 10;
        $page = $this->get_uri_segment(4);
        $offset = ($page - 1) * $pagesize;
        $data['pagelink'] = $this->get_pagination('space_spoor_detail/' . $city_id.'/'.$uid, 4, 2, $total, $pagesize);
        $place_city=$this->sport->contact_get_pagedata('place','place_visit', 'pid,parent,name,name_en,description',array('uid'=>$uid,'del' => 0, 'sta' => 0, 'city' => $city_id,'beento'=>1), $offset, $pagesize, $order = 'weight', 'created','place.pid=placeid');
        //循环图片查询图片
        foreach ($place_city as $key => $c) {
            $img= $this->get_one_data('place_sport_images', 'img', array('sport_id' => 0, 'place_id' => $c['pid']));
            $place_city[$key]['img'] =$img['img'];
        }
        //判断这个目的地 城市的下一级 和是不是就是当前了，
        $new_array=array();
        foreach($place_city as $k=>$v){
            $pid_arr=$this->place-> parentid($v['pid']);
            if(count($pid_arr)>3){//当前不是自己
                //获取这个地点的城市下一级别显示
                $place_city[$k]=$this->get_one_data('place','pid,parent,name,name_en,description',array('pid'=>$pid_arr[3]));
                $place_city[$k]['p_cid']=$pid_arr[3];//城市下一级的地点id
                $place_city[$k]['child'][]=$v;
                $img= $this->get_one_data('place_sport_images', 'img', array('sport_id' => 0, 'place_id' =>$pid_arr[3]));
                $place_city[$k]['img']=$img['img'];
            }

        }
        $array_list=array();
        //合并数组
        foreach($place_city as $ky=>$c){
            if(array_key_exists($c['pid'],$array_list) ){
                if(!$array_list[$c['pid']]['child']){
                    unset($array_list[$c['pid']]);
                    $array_list[$c['pid']]=$c;
                }else{
                    array_push($array_list[$c['pid']]['child'],$c['child'][0]);
                }

            }
            else{
                $array_list[$c['pid']]=$c;
            }
        }
        //获取父级的地点名字
        $data['c_name'] = $country = $this->get_one_data('place', 'name,parent', array('pid' => $city_id));
        $data['spaces'] = $array_list;
        $data['city_id'] = $city_id;//给js用
        $data['place_id'] = $country['parent'];
        $data['t_name']=$title;
        $this->load->view('user/spoor_city', $data);
    }


}