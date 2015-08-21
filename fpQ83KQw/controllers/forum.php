<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'core/MY_UserController.php';
class Forum extends MY_UserController
{  
    private $_th_member;
    public function __construct()
    {
        parent::__construct();
		//$this->load->model('uc_model','uc');
		//$this->load->model('common_model','common');
        $this->load->model('user_model', 'user_model');
		$s_uid=intval($this->uri->segment(3));
		$members = $this->user_model->get_members($s_uid);
		$this->_th_member=$members[0];
    }

    /**
     * 我的攻略
     * @param int $uid
     */
    public function guide($uid)
    {   //$this->$_th_member = $this->get_member($uid);
        $this->set_vars('meta', $this->meta);
        $this->set_vars('title', $this->title('攻略'));
        $this->set_vars('keywords', $this->keywords);
        $this->set_vars('description', $this->description);
//        $this->set_vars('css', $this->css(array('user.css')));
        $this->set_vars('js', $this->js(array('guide.js')));

        $this->pub($uid,'guide',Category_guide);
    }

    /**
     * 我的游记
     * @param int $uid
     */
    public function travel($uid)
    {
        $this->set_vars('meta', $this->meta);
        $this->set_vars('title', $this->title('游记'));
        $this->set_vars('keywords', $this->keywords);
        $this->set_vars('description', $this->description);
//        $this->set_vars('css', $this->css(array('user.css')));
        $this->set_vars('js', $this->js(array('guide.js')));

        $this->pub($uid,'travel',Category_travel);
    }

    /**
     * 我的帖子
     * @param int $uid
     */
    public function post($uid)
    {
        $this->set_vars('meta', $this->meta);
        $this->set_vars('title', $this->title('帖子'));
        $this->set_vars('keywords', $this->keywords);
        $this->set_vars('description', $this->description);
//        $this->set_vars('css', $this->css(array('user.css')));
        $this->set_vars('js', $this->js(array('guide.js')));

        $this->pub($uid,'post','1,4');
    }

    /**
     * 执行 显示 对应的 view
     * @param $uid
     * @param $viewname
     * @param $category
     */
    private function pub($uid,$viewname,$category){
		
        $uid=$this->get_uid($uid);
        $this->set_self($uid); //设置 当前页面是否属于自己的
        $member=$this->get_member($uid);
        $this->set_vars('member',$member); //用户详细资料

        $page = $this->get_uri_segment(4);
        $total=$this->uc->dz_get_forum_threads_num(-1,$category,'',$uid); //数量
        $pagesize =8;
        $pagelink=$this->get_pagination('forum/'.$viewname.'/'.$uid,4, 2, $total, $pagesize);
        $this->set_vars('pagelink',$pagelink);
        $list=$this->uc->dz_get_forum_threads(-1,$page,$pagesize,$category,'','',$uid); //列表
        $this->set_vars('list',$list);

        $list_hot=$this->uc->dz_get_forum_threads(-1,1,5,$category,'','a.views desc'); //热门
        $this->set_vars('list_hot',$list_hot);
        $this->set_vars("header_info",$this->_th_member);
        $this->load->view('forum/'.$viewname);
    }
   /*
    * 删除自己发的帖子 james
    * */
    public function del_thread(){
     if($this->input->is_ajax_request()){
         $tid= intval($this->input->post('tid',true));
            if($tid>0 && $this->uid){
                //echo $tid.'-'.$this->uid;
                $this->load->model('uc_model', 'uc');
                $res= $this->uc->dz_api('forum_delete_thread',array('tids'=>$tid));
                if($res){
                   echo 1;
                }else{
                    echo 0;
                }
            }

         }


    }

  /*
   * 获取收藏的帖子 1:帖子 2:游记 3:攻略
   * */
    /*收藏的攻略*/
 public function guide_favorite($uid){
     $this->set_vars('meta', $this->meta);
     $this->set_vars('title', $this->title('收藏的攻略'));
     $this->set_vars('keywords', $this->keywords);
     $this->set_vars('description', $this->description);
//     $this->set_vars('css', $this->css(array('index.css','member.css')));
     $this->set_vars('js', $this->js(array('guide.js')));

     $this->favorite_pub($uid,'guide_favorite',Category_guide);

 }
    /*收藏的游记*/
    public function travel_favorite($uid){
        $this->set_vars('meta', $this->meta);
        $this->set_vars('title', $this->title('收藏的游记'));
        $this->set_vars('keywords', $this->keywords);
        $this->set_vars('description', $this->description);
//        $this->set_vars('css', $this->css(array('index.css','member.css')));
        $this->set_vars('js', $this->js(array('guide.js')));

        $this->favorite_pub($uid,'travel_favorite',Category_travel);
    }

    /*收藏的帖子*/
    public function post_favorite($uid){
        $this->set_vars('meta', $this->meta);
        $this->set_vars('title', $this->title('收藏的帖子'));
        $this->set_vars('keywords', $this->keywords);
        $this->set_vars('description', $this->description);
//        $this->set_vars('css', $this->css(array('index.css','member.css')));
        $this->set_vars('js', $this->js(array( 'guide.js')));

        $this->favorite_pub($uid,'post_favorite','1,4');

    }

    private function favorite_pub($uid,$viewname,$category){
        $uid=$this->get_uid($uid);
        $this->set_self($uid); //设置 当前页面是否属于自己的
        $member=$this->get_member($uid);
        $this->set_vars('member',$member); //用户详细资料

        $tids=$this->uc->dz_get_favorite_ids($uid,'tid'); //获取收藏的主题ID集合

        if($tids){
            $page = $this->get_uri_segment(4);
            $total=$this->uc->dz_get_forum_threads_num(-1,$category,'',0,$tids); //数量

            $pagesize =8;
             $pagelink=$this->get_pagination('forum/'.$viewname.'/'.$uid,4, 2, $total, $pagesize);
            $this->set_vars('pagelink',$pagelink);
            $list=$this->uc->dz_get_forum_threads(-1,$page,$pagesize,$category,'','',0,$tids); //列表
            $this->set_vars('list',$list);

        }
        $list_hot=$this->uc->dz_get_forum_threads(-1,1,5,$category,'','a.views desc'); //热门
        $this->set_vars('list_hot',$list_hot);

        $this->load->view('forum/'.$viewname);
    }

}