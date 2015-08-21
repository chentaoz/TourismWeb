<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
    private $sport_cate;
	public function __construct(){
		parent::__construct();
        $this->load->model('sport_model','sport');
        $this->load->model('home_model','home');
        $this->load->model('user_model','user_model');
        $this->sport_cate=$this->sport->get_data('sport',$filed='spid,name,img',array('del'=>0,'sta'=>0));

	}

    /*
     * 未登录转向登录页面
     * */
    public function go_login(){
        redirect(PASSPORT_domian. 'oauth/login');
        exit();

    }
	public function index(){
//        $this->load->vars('css',$this->css(array('index2.css')));
//        $this->load->vars('js', $this->js(array('indexban.js')));
        //获取运动分类
        $data['sport_cate']=$sports=$this->sport_cate;
        //获取广告banner 首页广告id 246
        $data['banner']=$this->sport->connect_table('ads.img,ads.weblink,title,intro',$where=array('is_del'=>2,'flag'=>1,'ads_sclass.id'=>246),'sort_number','ads','ads_sclass','ads_sclass.id=ads.classid');
        //目的地统计
        $data['total_des']=$this->sport->count_data('place',array());
        //国家下城市随机数据
        $this->load->view('index',$data);
	}

    public function dz(){
        #$result=$this->uc->dz_api('test',array('id'=>168,'name'=>'测试字符串d~@@#￥%…&&【;】、/-=+'));
        #var_dump($result);
        #$result=$this->uc->dz_api('forum_delete_thread',array('tids'=>'44')); //删除主题
        #$result=$this->uc->dz_api('forum_delete_post',array('ids'=>'56','idtype'=>'pid')); //删除帖子
        $uid=11;
        $tids=$this->uc->dz_get_favorite_ids($uid,'tid'); //获取收藏的主题ID集合
        $num=$this->uc->dz_get_forum_threads_num(-1,Category_post,'',0,$tids); //获取主题数量
        $result=$this->uc->dz_get_forum_threads(-1,1,10, Category_post,'','',0,$tids); //获取主题列表
        var_dump($result);
    }
 public  function rant_city(){
     if($this->input->is_ajax_request()){
         echo json_encode($this->sport->rand_city($this->uid));
     }

   }
}