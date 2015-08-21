<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'core/MY_UserController.php';
class Space extends MY_UserController {
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
   * 空间首页
   * */
public function index(){
    $members=$this->check_space_user();//检测是否存在用户
    $this->load->vars('title', $this->title($members['username'].'的个人主页'));
    $this->load->vars('keywords', $this->keywords);
    $this->load->vars('description', $this->description);
    $this->load->vars('css',$this->css(array('index.css','member.css')));
    $this->load->vars('js',$this->js(array('layer-v1.8.5/layer/layer.min.js','layer-v1.8.5/layer/extend/layer.ext.js')));
     //收藏过的运动
      $save_sport= $this->sport->get_save_sport($members['uid']);
      foreach($save_sport as $key=>$r){
          //查询多少人玩过
          $save_sport[$key]['played']=$this->sport->count_data('sport_play',array('sport_id'=>$r['sport_id'],'beento'=>1));
         //这个运动下的清单数
          $save_sport[$key]['list']=$this->sport->c_table_count_data('sport_taxonomy','taxonomy_term_hierarchy','term_id=parent',array('sport_id'=>$r['sport_id'],'taxonomy_id'=>2));
         //相关场地
          $save_sport[$key]['space']=$this->sport->count_data('place_sport',array('sport_id'=>$r['sport_id']));
          //此运动的一张图片
          $save_sport[$key]['img']=$this->get_one_data('place_sport_images', 'img',array('sport_id' => $r['sport_id'],'place_id'=>0));

      }
        $data['save_sport']=$save_sport;
        $like_sport=array();
        $want=array();
        $gone=array();
    foreach ($save_sport as $key => $s) {//拼装想去和去过的数据
        if ($s['beento'] == 1) {//玩过
            array_push($gone, $save_sport[$key]);
        }
        if ($s['planto'] == 1) { //想玩
            array_push($want, $save_sport[$key]);
        }
    }
        $data['want']=$want;
        $data['gone']=$gone;
    //是否已关注过该用户
    $data['gz']=$this->uc->friend_exit($this->uid,$members['uid']);
    //关注数
    $data['friend_ls']=$this->uc->friend_ls($members['uid'], $page = 1, $pagesize =6, $totalnum = 6, $direction = 0);
    $data['fans_list']=$this->uc->attention_me($members['uid'], 0, 6);
    //获取去过多少个国家和城市
    $data['country']= $this->sport->get_statistics($members['uid'],1);
    $data['city']= $this->sport->get_statistics($members['uid'],2);
  //获取用户去过的场点给地图
//    $play_city= $this->sport->get_view_location();
//    $data['play_city']=json_encode($play_city);
    //去过的城市的信息坐标
    $play_city=$this->sport-> view_city_location($members['uid']);
    //获取用户去过的场点给地图
    // var_dump($play_city);
    $play_location= $this->sport->get_view_location($members['uid']);
    if($play_location){
        $all_view=array_merge($play_city,$play_location);
    }else{
        $all_view=$play_city;
    }
    $data['play_city'] = json_encode($all_view);

   //给我的留言数据
    $total_array=$this->all_data('comments','id',array('objectid'=>$members['uid']),'created',$type='asc');
    $total=count($total_array);
    $pagesize =8;
    $page = $this->get_uri_segment(3);
    $offset=($page-1)*$pagesize;
    $data['pagelink']=$this->get_pagination('user/index', 3, 2, $total, $pagesize);
    $comment= $this->sport->contact_get_pagedata('comments','members','username,parentid,id,comments.uid,body,created',array('objectid'=>$members['uid'],'del'=>0,'sta'=>0), $offset, $pagesize,'created', $style = 'asc','comments.uid=members.uid');   $data['comment']=$comment;
    //我的攻略
    $data['my_guid']=$this->uc->dz_get_forum_threads($attachment = -1,$currentpage=1,$pagesize=6,3,$wd='',$ordrby='',$members['uid']);
    $data['offset']=$offset;
    $data['total_array']=$total_array;
    $data['space']='space';//标志是空间的
    $data['s_uid']=$members['uid'];
    //统计总共的景点个数
    $data['view_num']= $this->sport->get_view_num($members['uid']);
    $data['s_username']=$members['username'];
    $data['header_info']=$this->member;
    $this->load->view('user/index',$data);

}
   /**************************新加部分****************************************/
  /*
   * 用户留言
   * */
   public function messages(){
    if($this->input->is_ajax_request()){
        $content=$this->post('c');
        $objectid=intval($this->post('s_uid'));
       if($this->uid=='' || $objectid==''){//没有登录
           echo 3;
           exit;
       }
     //添加数据
       $data=array('uid'=>$this->uid,'objectid'=>$objectid,'body'=>$content,'ip'=>$this->input->ip_address(),'created'=>time());
       $res=$this->my_add('comments', $data);
       if($res){
          echo 1;
       }else{
           echo 2;
       }

     }
   }
}