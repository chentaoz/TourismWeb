<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bag extends MY_Controller {
    private $sport_cate;
    public function __construct(){
        parent::__construct();
        $this->load->model('common_model','common');
        $this->load->model('sport_model','sport');
        $this->load->model('bag_model','bag');
    }
    /**背包主页*/
    public function index(){
        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('背包'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css',$this->css(array()));
        $this->load->vars('js', $this->js(array('common.js','bag.js')));
        //banner背景图
        $data['back']=$this->get_one_data('ads','img',array('classid'=>256));
        //获取运动标签
        $tag=$this->sport->get_data('taxonomy_term',$filed='ttid,name',$where=array('tid'=>4,'del'=>0,'sta'=>0,'typeid'=>0));
        //运动属于标签下面  如果运动的标签中有此标签就属于这个标签下的运动
        foreach($tag as $key=>$t){
            $tid=$t['ttid'];
            $tag[$key]['child']=$this->sport->connect_table('spid,name,name_en,img',$where=array('del'=>0,'sta'=>0,'taxonomy_id'=>4,'term_id'=>$tid),'weight','sport','sport_taxonomy','spid=sport_id');
        }
        $data['sport']=$tag;
        //背包是否已被收藏
        $data['favorites_had']=$this->get_one_data('bag_favorites','uid',array('uid'=>$this->uid,'bagid'=>$data['bag_termid']['term_id'],'typeid'=>0));
//print_r($data['sport']);
        $this->load->view('bag/index',$data);
    }
    //背包清单
    public function ajax_bag() {
        $spid=$this->input->get('spid');
        $spid=$spid?$spid:0;
        $s = $this->bag->get_bag($spid);
        foreach($s as $k=>$v){
            $s[$k]['spid']=$spid;
            $tem = $this->get_one_data('sport_taxonomy','term_id',array('sport_id'=>$spid,'taxonomy_id'=>2));
            $s[$k]['bag_termid'] =$tem['term_id'];
        }
        // var_dump($this->db->last_query());
        if(!$s){
            $s=array();
        }

        echo json_encode($s);
    }
    //收藏背包
    public function bag_favorites(){
        echo '<meta http-equiv="content-type" content="text/html;charset=utf-8"/>';
        $params = $this->uri->uri_to_assoc(3);
        $bagid = $params['bagid'];
        $bagid = $bagid ? $bagid : message('参数错误', 'bag#sports');
        $data = array('uid' => $this->uid, 'bagid' => $bagid, 'typeid' => 0, 'created' => time());
        $r=$this->get_one_data('bag_favorites','*',array('uid'=>$this->uid,'bagid' => $bagid,'typeid'=>0));
        if ($this->uid || $this->uid > 0) {
            if($r){
                message('您已收藏过该背包!', 'bag#sports');
            }else{
                $s = $this->my_add('bag_favorites', $data);
                if ($s) {
                    message('收藏成功!', 'bag#sports');
                } else {
                    message('提交失败!', 'bag#sports');
                }
            }
        } else {
            message('请先登录!', PASSPORT_domian. 'oauth/login');
        }
    }
}