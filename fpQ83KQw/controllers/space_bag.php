<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'core/MY_UserController.php';
class Space_bag extends MY_UserController {
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
   * 空间背包首页
   * */
public function index(){
    $members=$this->check_space_user();//检测是否存在用户
    $this->load->vars('title', $this->title($members['username'].'的背包'));
    $this->load->vars('keywords', $this->keywords);
    $this->load->vars('description', $this->description);
//    $this->load->vars('css',$this->css(array('base.css','member.css')));
//    $this->load->vars('js',$this->js(array('layer-v1.8.5/layer/layer.min.js','layer-v1.8.5/layer/extend/layer.ext.js')));
    $data['space']='space';//标志是空间的
    /***************上面通用数据*****************/
    //背包列表
    $total=$this->total_data('bag',array('del'=>0,'sta'=>0,'uid'=>$members['uid']));
    $pagesize =8;
    $page = $this->get_uri_segment(3);
    $offset=($page-1)*$pagesize;
    $bag_array= $this->sport->get_pagedata('bag','id,title,remark,created',array('del'=>0,'sta'=>0,'uid'=>$members['uid']),$offset,$pagesize,'created','desc');

    //遍历查询详细装备
    foreach($bag_array as $k=>$b){
        $bag_array[$k]['suit']=$this->sport->connect_table('name,img',array('bagid'=>$b['id']),'ttid','bag_list','taxonomy_term','term_list_id=ttid');

    }
    //收藏的装备 连表查询
    //连表系统装备
    $system_bag=$this->sport->connect_table('name,img,bagid,bag_favorites.typeid',array('uid'=>$members['uid'],'bag_favorites.typeid'=>0,'del'=>0,'sta'=>0,'tid'=>2),'bag_favorites.created','bag_favorites','taxonomy_term','bag_favorites.bagid=taxonomy_term.ttid');
    //连表收藏用户的装备
    $user_bag=$this->sport->connect_table('title as name,bagid,bag_favorites.typeid',array('bag_favorites.uid'=>$members['uid'],'bag_favorites.typeid'=>1,'del' => 0),'bag_favorites.created','bag_favorites','bag','bag_favorites.bagid=bag.id');
    $data['f_bag']=array_merge($system_bag, $user_bag);//合并数组
    $data['pagelink']=$this->get_pagination('space_bag/'.$members['uid'], 3, 2, $total, $pagesize);
    $data['bag_array']=$bag_array;
    $data['header_info']=$this->member;
    $this->load->view('user/bag',$data);

}
}