<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sport extends MY_Controller
{
    private $sport_cate;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model', 'common');
        $this->load->model('sport_model', 'sport');
        $this->load->model('place_model', 'place');
        $this->load->model('bag_model', 'bag');
        $this->load->model('user_model','user_model');
        $this->load->model('home_model','home');
        $this->load->model('question_model', 'question_model');
    }

    /**部落主页*/
    public function index()
    {
        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('兴趣部落'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('picscroll.css')));
        $this->load->vars('js', $this->js(array('sport.js')));
        //banner背景图
        $data['back']=$this->get_one_data('ads','img',array('classid'=>255));

        //热门户外运动
        //  $data['sport_top']=$this->sport->get_top(4);
        $data['sport_focus']=$this->sport->get_focus(4,12);
        //身边的野孩子
        // $data['interview_top']=$this->sport->get_top(5);
        $data['interview_focus']=$this->sport->get_focus(5,12);
        //技术小贴士
        //   $data['tips_top']=$this->sport->get_top(6);
        $data['tips_focus']=$this->sport->get_focus(6,12);
        //james 新增原来首页的内容添加过来
        //获取运动分类
        $data['sport_cate']=$sports=$this->sport->get_data('sport',$filed='spid,name,img',array('del'=>0,'sta'=>0),11);
        //大家都在玩
        $data['every_play']=$this->sport->sport_played();
        //户外活动个数

        //目的地个数
        $forum_num['total_des']=$this->sport->count_data('place',array());

        //获取广告banner 首页广告id 246
        $data['banner']=$this->sport->connect_table('ads.img,ads.weblink',$where=array('is_del'=>2,'flag'=>1,'ads_sclass.id'=>258),'sort_number','ads','ads_sclass','ads_sclass.id=ads.classid');
        $list_travel=$this->uc->dz_get_forum_threads(2,1,3,Category_travel); //最新游记
        $this->load->vars('list_travel',$list_travel);
        $cnt_post=$this->uc->dz_get_thread_num(Category_post); //帖子 数量
        $cnt_travel=$this->uc->dz_get_thread_num(Category_travel); //游记 数量
        $cnt_guide=$this->uc->dz_get_thread_num(Category_guide); //攻略 数量
        $forum_num['post_num']=$cnt_post;
        $forum_num['travel_num']=$cnt_travel;
        $forum_num['guide_num']=$cnt_guide;
        $forum_num['sport']=$this->home->sports_total();
        $forum_num['bag']=$this->home->bags_total();

        $this->set_vars('forum_num',$forum_num);

//        $top_threads_uid=$this->uc->dz_get_forum_threads_top_uid();
//        $top_threads_users=$this->user_model->get_members($top_threads_uid);
//        $this->load->vars('top_threads_users',$top_threads_users); //游记被回复最多
//
//        $top_posts_uid=$this->uc->dz_get_forum_posts_top_uid();
//        $top_posts_users=$this->user_model->get_members($top_posts_uid);
//        $this->load->vars('top_posts_users',$top_posts_users); //回帖最多

        //部落专家
        $answer_maxcount_uid=$this->question_model->answer_maxcount(5,0);
        if($answer_maxcount_uid) {
            $top_threads_users = $this->user_model->get_members($answer_maxcount_uid);
            $data['top_threads_users'] = $top_threads_users;
        }

        //最热门的部落
        $join_maxcount_spid=$this->sport->join_maxcount_spid(5);
        if($join_maxcount_spid){
            $every_play=$this->sport->get_sports_list($join_maxcount_spid);
            foreach($every_play as &$s){
                $spid2=$s['spid'];
                $joined_count2=$this->sport->sport_join_count($spid2);
                $question_count2=$this->question_model->get_questions_count(array('group_id'=>$spid2));
                $s['joined_count']=$joined_count2;
                $s['question_count']=$question_count2;
            }
            $data['every_play']=$every_play;
        }

        //最新加入部落的
        $recent_join_uid=$this->sport->get_sports_join_recent(0,16);
        if($recent_join_uid) {
            $recent_join_users = $this->user_model->get_members($recent_join_uid);
            $data['recent_join_users'] = $recent_join_users;
        }

        //小组最新问题
        $orderby='id desc';
        $where=array('deleted'=>0);

        $question_list=$this->question_model->get_questions_list(1,20,$where,$orderby); //列表
        $this->set_vars('question_list',$question_list);

        //热门运动
        $data['hot_sport']=$this->sport->hot_sport(5);
        $this->load->view('sport/index', $data);
    }

    public function cate () {
        $params = func_get_args();

        $articleList = $this->sport->sportGetArticles($params[0], 6, 0);

        $this->load->view('sport/cat', array(
            'articles' => $articleList,
            'spid' => $params[0]
        ));
    }

    public function cate_pull() {
        $params = func_get_args();

        if(3 <= count($params)) {
            list($_spid, $_offset, $_num) = $params;

            $_total = $this->sport->sportGetArticlesTotal($_spid);

            if($_total > $_offset) {
                $_article_list = $this->sport->sportGetArticles($_spid, $_offset, $_num);

                $this->load->view('sport/cat_pull', array(
                    'articles' => $_article_list,
                    'spid' => $_spid,
                    'offset' => $_offset,
                    'num' => $_num
                ));
            }
        }
    }

    public function c () {
        $params = func_get_args();

        $articleList = $this->sport->classGetArticles($params[0], 6, 0);

        $this->load->view('sport/c', array(
            'articles' => $articleList,
            'spid' => $params[0]
        ));
    }

    public function c_pull () {
        $params = func_get_args();

        if(3 <= count($params)) {
            list($_cid, $_offset, $_num) = $params;

            $_total = $this->sport->classGetArticlesTotal($_cid);

            if($_total > $_offset) {
                $_article_list = $this->sport->classGetArticles($_cid, $_offset, $_num);

                $this->load->view('sport/c_pull', array(
                    'articles' => $_article_list,
                    'spid' => $_cid,
                    'offset' => $_offset,
                    'num' => $_num
                ));
            }
        }
    }

    /**信息详情页*/
    public function news_show()
    {
        $params = $this->uri->uri_to_assoc(3);
        $id = $params['id'];
        $id = $id ? $id : message('参数错误', 'sport');
        $detail= $this->get_one_data('article', '*', array('id' => $id));
        if(!$detail){message('参数错误', 'sport');}
        if($detail){
            $this->upd_one_data('article',array('hit'=>$detail['hit']+1),array('id'=>$id));
        }else{
            message('参数错误', 'sport');
        }
        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title($detail['title']));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('index.css', 'other.css')));
        $this->load->vars('js', $this->js(array('sport.js')));
        //banner背景图
        $data['back']=$this->get_one_data('ads','img',array('classid'=>255));
        $data['detail']=$detail;
        //热门运动
        $data['hot_sport']=$this->sport->hot_sport(5);

        //最新文章5个
        $classic=$detail['classic'];//类型
        $data['latest_news']=$this->sport->latest_news(5,$classic);
        $this->load->view('sport/news_show', $data);
    }

    /*运动的搜索
     *
     * */
    public function auto_search()
    {
        $key = $_GET['key'];
        if (!$key) return;
        $s = $this->sport->get_placebykey($key);
        if (!$s) {
            $s = array();
        }
        echo json_encode($s);
    }

    /*
     * 新加运动搜索 返回json
     * */
    public function search()
    {

        //搜索运动数据

        $res = $this->sport->get_sport();
        echo json_encode($res);


    }
    /**
     * 想去操作
     * */
    public function ajax_plan(){
        $spid=$_GET['spid'];
        $plan=$_GET['plan'];
        if($this->uid){
            //查询是否已有记录
            $q= $this->get_one_data('sport_play','uid',array('uid'=>$this->uid,'sport_id'=>$spid));

            if($q){//已有记录
                $res= $this->sport->sport_want_update($this->uid,$spid,$plan);
                if($res){
                    $s= $this->get_one_data('sport_play','*',array('uid'=>$this->uid,'sport_id'=>$spid));
                    echo json_encode($s['planto']);
                }else{
                    return false;
                }
            }else{
                $res= $this->sport->sport_want($this->uid,$spid,$plan);
                if($res){
                    echo json_encode(1);
                }else{
                    return false;
                }
            }
        }else{
            echo json_encode(array("code"=>-1,"msg"=>"nologin", 'url'=>PASSPORT_domian.'oauth/login'));
        }
    }
    /**
     * 去过操作
     * */
    public function ajax_been(){
        $spid=$_GET['spid'];
        $been=$_GET['been'];
        if($this->uid){
            //查询是否已有记录
            $q= $this->get_one_data('sport_play','uid',array('uid'=>$this->uid,'sport_id'=>$spid));
            if($q){//已有记录
                $res= $this->sport->sport_been_update($this->uid,$spid,$been);
                if($res){
                    $s= $this->get_one_data('sport_play','*',array('uid'=>$this->uid,'sport_id'=>$spid));
                    echo json_encode($s['beento']);
                }else{
                    return false;
                }
            }else{
                $res= $this->sport->sport_been($this->uid,$spid,$been);
                if($res){
                    echo json_encode(1);
                }else{
                    return false;
                }
            }
        }else{
            echo json_encode(array("code"=>-1,"msg"=>"nologin", 'url'=>PASSPORT_domian.'oauth/login'));
        }
    }
    //运动详情页
    public function detail(){
        $params = $this->uri->uri_to_assoc(3);
        $spid = $params['spid'];
        $spid = $spid ? $spid : message('参数错误', 'sport');
        $this->set_vars('spid',$spid);
        $data['detail']=$detail= $this->get_one_data('sport', '*', array('spid' => $spid));
        if(!$detail){message('参数错误', 'sport');}
        $temp =$this->get_one_data('place_sport_images', '*', array('sport_id' => $spid));
        $data['detail']['banner'] = $temp['img'];
        $data['guide'] = $this->get_one_data('guide', '*', array('sport_id' => $spid));
        $joined=$this->sport->sport_joined($spid,$this->uid); //判断是否加入
        $this->set_vars('joined',$joined);

        //想玩玩过统计
        $data['plan_total'] = $this->sport->been__want_total($spid,1);
        $data['been_total'] = $this->sport->been__want_total($spid,2);

        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title($data['detail']['name']));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array( 'other.css')));
        $this->load->vars('js', $this->js(array('common.js')));

//        $top_threads_uid=$this->uc->dz_get_forum_threads_top_uid();
//        $top_threads_users=$this->user_model->get_members($top_threads_uid);
//        foreach($top_threads_users as $k=>$v){
//            $top_threads_users[$k]['gz']=$this->uc->friend_exit($this->uid,$v['uid']);
//        }
//        $this->load->vars('top_threads_users',$top_threads_users); //游记被回复最多

        //判断此运动用户是否已有想玩玩过记录
        $visit= $this->get_one_data('sport_play','*',array('uid'=>$this->uid,'sport_id'=>$spid));
        $data['visit']=$visit;

        //达人推荐
//        $top_threads_users=$this->sport->rand_data('sport_play','uid',array('sport_id'=>$spid,'beento'=>1),'RAND()',5);
//        foreach($top_threads_users as $k=>$v){
//            $temp=$this->get_one_data('members','username',array('uid'=>$v['uid']));
//            $top_threads_users[$k]['username']=$temp['username'];
//            $top_threads_users[$k]['gz']=$this->uc->friend_exit($this->uid,$v['uid']);
//        }
        //部落专家
        $answer_maxcount_uid=$this->question_model->answer_maxcount(5,$spid);
        if($answer_maxcount_uid) {
            $top_threads_users = $this->user_model->get_members($answer_maxcount_uid);
            $data['top_threads_users'] = $top_threads_users;
        }

        //最新加入部落的
        $recent_join_uid=$this->sport->get_sports_join_recent($spid,16);
        if($recent_join_uid) {
            $recent_join_users = $this->user_model->get_members($recent_join_uid);
            $data['recent_join_users'] = $recent_join_users;
        }

        //目的地推荐
        $data['place_rec']=$this->sport->place_recomm($spid,3);
        foreach($data['place_rec'] as $k=>$v){
            $temp = $this->place->get_place_img($v['place_id'],1);
            $data['place_rec'][$k]['img'] = $temp['img'];
        }

        //背包清单
        $data['bag']=$this->bag->get_bag($spid);
        $data['bag_termid']=$this->get_one_data('sport_taxonomy','term_id',array('sport_id'=>$spid,'taxonomy_id'=>2));

        //背包是否已被收藏
        $data['favorites_had']=$this->get_one_data('bag_favorites','uid',array('uid'=>$this->uid,'bagid'=>$data['bag_termid']['term_id'],'typeid'=>0));

        //感兴趣人群
        $data['plan_to']=$this->sport->get_sport_planto($spid,1,10);

        //热门运动
        //$data['hot_sport']=$this->sport->hot_sport(5);
        //评价中有多少个背包  $spid 运动ID
        $data['bag_count']=count( $this->sport->group_by_data('bagid','bag_sport',array('sportid'=>$spid),'bagid'))+1;
        //评价中攻略个数
        $data['guide_count']=  $this->uc->dz_get_forum_threads_num(-1,'2',$detail['name'],$uid=0)+1;

        //评价中帖子个数
        $data['topic_count']=$this->uc->dz_get_forum_threads_num(-1,'1',$detail['name'],$uid=0);
        //技术贴士 3个
        $data['guide_list']= $this->uc->dz_get_forum_threads(2,1,3,3,$detail['name'],'',0);
        //游记攻略 3个
        $data['travel_notes']= $this->uc->dz_get_forum_threads(2,1,3,2,$detail['name'],'',0);

        //新加替换右边James
        //大家都在玩
//        $data['every_play']=$this->sport->sport_played();
        $join_maxcount_spid=$this->sport->join_maxcount_spid(5);
        if($join_maxcount_spid){
            $every_play=$this->sport->get_sports_list($join_maxcount_spid);
            foreach($every_play as &$s){
                $spid2=$s['spid'];
                $joined_count2=$this->sport->sport_join_count($spid2);
                $question_count2=$this->question_model->get_questions_count(array('group_id'=>$spid2));
                $s['joined_count']=$joined_count2;
                $s['question_count']=$question_count2;
            }
            $data['every_play']=$every_play;
        }

        //跟这个运动相关的文章
        $data['sport_news']= $this->sport->sport_contact_news($spid,3);

        //小组最新问题
        $orderby='id desc';
        $where=array('group_id'=>$spid);

        $question_list=$this->question_model->get_questions_list(1,10,$where,$orderby); //列表
        $this->set_vars('question_list',$question_list);

        $this->load->view('sport/detail', $data);
    }
    //添加好友
    public  function friend_add(){
        $params = $this->uri->uri_to_assoc(3);
        $fid = $params['fid'];
        $spid = $params['spid'];
        $spid = $spid ? $spid : message('参数错误', 'sport');
        $fid = $fid ? $fid : message('参数错误', "sport/detail/spid/" . $spid);
        if($this->uid == $fid){
            message('不能关注本身哦!', 'sport/detail/spid/'.$spid);
        }
        if ($this->uid || $this->uid > 0) {
            $s=$this->uc->friend_add($this->uid,$fid);
            if ($s) {
                message('关注成功!', 'sport/detail/spid/'.$spid);
            }else if($s==0){
                message('您已关注过该用户!', 'sport/detail/spid/'.$spid);
            } else {
                message('关注失败!', 'sport/detail/spid/'.$spid);

            }
        }else {
            message('请先登录!', PASSPORT_domian. 'oauth/login');

        }
    }
    //收藏背包
    public function bag_favorites(){
        echo '<meta http-equiv="content-type" content="text/html;charset=utf-8"/>';
        $params = $this->uri->uri_to_assoc(3);
        $bagid = $params['bagid'];
        $spid = $params['spid'];
        $bagid = $bagid ? $bagid : message('参数错误', 'sport/detail/spid/'.$spid);
        $spid = $spid ? $spid : message('参数错误', 'sport');
        $data = array('uid' => $this->uid, 'bagid' => $bagid, 'typeid' => 0, 'created' => time());
        $r=$this->get_one_data('bag_favorites','*',array('uid'=>$this->uid,'bagid' => $bagid,'typeid'=>0));
        if ($this->uid || $this->uid > 0) {
            if($r){
                message('您已收藏过该背包!', 'sport/detail/spid/'.$spid);

            }else{
                $s = $this->my_add('bag_favorites', $data);
                if ($s) {
                    message('收藏成功!', 'sport/detail/spid/'.$spid);

                } else {
                    message('提交失败!', 'sport/detail/spid/'.$spid);
                }
            }
        } else {
            message('请先登录!', PASSPORT_domian. 'oauth/login');
        }
    }

    //加入小组
    public function join($id){
        if($this->uid==0){
            echo -1;
            exit;
        }
        $joined=$this->get('joined');
        if($joined==0){
            $this->sport->sport_join($id,$this->uid);
        }else{
            $this->sport->sport_unjoin($id,$this->uid);
        }
        echo 1;
    }


}