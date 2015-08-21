<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: james
 * Date: 14-12-17
 * Time: 上午10:53 用户列表
 */
class User extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('user_model','user');
        $this->load->model('uc_model','uc');
    }
/*用户列表
 * */
    public function index(){
        $data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'global.js','validateMyForm/jquery.validateMyForm.1.0.js'));
        $key =$this->input->post('keyword');//查询的名字
        $url='user/index';
        $default=array('page','keyword');
        $url_data=$this->uri->uri_to_assoc(3,$default);
        $keyword=$key?$key:urldecode($url_data['keyword']);
        $url=base_url(index_page().'/'.$url);//配置组装URL完成
        if($keyword){//判断是否是搜索
            $url.='/keyword/'.$keyword;
        }
        $url.='/page/';
        $this->load->library('pagination');//加载分页
        $rows =$this->user->count_user($keyword);//有搜索的时候总数据个数
        $segment=intval(array_search('page',$this->uri->segment_array())+1);//url的截取片段
        $config=$this->common->pageConfig($url,$rows,15,$segment);//分页配置
        $this->pagination->initialize($config);//分页可以输出
        //分页数据
        $data['user_list']=$this->user->user_list($keyword,$config['per_page'],$this->uri->segment($config['uri_segment']));//分页后的数据

        $data['keyword']=$keyword;
        $this->load->view('user/index',$data);
    }
    /*用户编辑
     * */
public function edit($uid=''){
    if($_POST){
       $id= $this->input->post('id');
       $sex= $this->input->post('sex');
       $address= $this->input->post('address');
       $year= $this->input->post('year');
       $month= $this->input->post('month');
       $day= $this->input->post('day');
     //更新用户信息
       $data=array('gender'=>$sex,'birthyear'=>$year,'birthmonth'=>$month,'birthday'=>$day,'address'=>$address);
       $res=$this->uc->up_user($id,array(),$data);
       if($res){
           message('更新成功！','user');
       }else{
           message('更新失败！','user');
       }

    }else{
    $data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'global.js','validateMyForm/jquery.validateMyForm.1.0.js'));
    $uid=intval($uid);
    if($uid==0){
        message('参数错误！','user');
    }
    //获取用户信息 连表查询
    $data['user_info']=$this->user->get_user_info($uid);
   //var_dump($data['user_info']);
    $this->load->view('user/edit',$data);
    }
 }

/*冻结用户
 * */
public function freeze(){
  if($this->input->is_ajax_request()){
    $uid=$this->input->post('uid');
   $status=$this->input->post('status');
      if($status==='0'){
          $s='1';
      }elseif($status=='1'){
          $s='0';
      }
$data=array('status'=>$s);
$data2=array('freeze'=>$s);
    $res=$this->uc->change_sta($uid,$data,$data2);
   if($res){
       echo 1;
   }else{
       echo 0;
   }
  }

}
/*
 * 邮箱激活
 * */
function email_activate(){
    if($this->input->is_ajax_request()){
       $uid=intval($this->input->post('uid'));
       $res= $this->uc->email_statue($uid);
        if($res){
            echo 1;
        }else{
            echo 0;
        }

    }
 }

}
