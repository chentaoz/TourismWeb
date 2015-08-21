<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Place extends MY_Controller
{
    private $place_cate;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model', 'common');
        $this->load->model('place_model', 'place');
        $this->load->model('sport_model', 'sport');
        $this->load->model('user_model', 'user_model');
        $this->load->model('article_model', 'article');
    }

    /**目的地主页*/
    public function index()
    {
        $params = $this->uri->uri_to_assoc(3);
        $this->load->vars('meta', $this->meta);
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
//        $this->load->vars('css', $this->css(array('index.css', 'other.css', 'jyytemp.css')));
        $this->load->vars('js', $this->js('place.js'));

        if (!array_key_exists('pid', $params)) {
            $this->load->vars('title', $this->title('目的地'));
            $data = $this->index_content();
            $this->load->view('place/index', $data);
        }else{
            $pid = $params['pid'];
            $place= $this->get_one_data('place', '*', array('pid' => $pid, 'del' => 0, 'sta' => 0));
            if(!$place){message('参数错误', 'place');}
            $this->load->vars('title', $this->title('目的地 | ', $place['name'] . ' | '));

            //判断是否有子级
            $childs = $this->place->place_tree($pid);
            if ($place['deep'] == 1) {
                $data=array_merge($this->list_content($pid),$this->left($pid));
                $this->load->view('place/country_index',$data);
            }elseif(count($childs)>0 && $place['deep']>1){
                $data=array_merge($this->list_content($pid),$this->left($pid));
                $this->load->view('place/city_index',$data);
            }elseif(count($childs)==0 && $place['deep']>1){
                $data=array_merge($this->left($pid),$this->detail($pid));
                $this->load->view('place/detail',$data);
            }
        }
    }

    /**目的地搜索下拉框**/
    public function auto_search()
    {
        $key = trim($_GET['key']);
        if (!$key) return;
        $s = $this->place->get_placebykey($key);
        // var_dump($this->db->last_query());
        if (!$s) {
            $s = array();
        }
        echo json_encode($s);
    }

    //首页内容
    private function index_content(){
        //banner背景图
        $data['back']=$this->get_one_data('ads','img',array('classid'=>257));
        //获取目的地全部信息
        $data['place_cate'] = $this->place->get_data('place', $filed = 'pid,name,name_en,hot,parent', array('del' => 0, 'sta' => 0));
        //获取广告位置名称
        $ad = $this->place->get_ad();
        foreach ($ad as $j => $i) {
            $ad[$j]['advis'] = $this->place->get_advis($i['id']);
        }
        //获取顶级父类信息
        $place_parent = $this->place->get_data('place', $filed = 'pid,name,name_en', array('del' => 0, 'sta' => 0, 'parent' => 0));
        foreach ($place_parent as $k => $v) {
            $place_parent[$k]['child'] = $this->place->get_data('place', $filed = 'pid,name,name_en,hot', array('del' => 0, 'sta' => 0, 'parent' => $v['pid'], 'deep' => 1));
        }
        $data['place_parent'] = $place_parent;
        $data['ad'] = $ad;
        return $data;
    }

    //不可不去，相关文章
    private function list_content($pid){
        $lp= $this->get_one_data('place', '*', array('pid' => $pid, 'del' => 0, 'sta' => 0));
        if($lp['deep']==1){
            //不可不去
            $data['place_must'] = $this->place->get_sceniclist($pid,0,6);
        }else{
            //不可不去
            $data['place_must'] = $this->place->get_citylist($pid,0,6);
        }
        foreach($data['place_must'] as $k =>$v){
            $img = $this->place->get_place_img($v['pid'], 1);
            $data['place_must'][$k]['img']=$img['img'];
        }
        //相关文章
        $data['rele_article'] = $this->article->get_article($pid,2,3);

        return $data;
    }

    //左边公共内容
    private function left($pid){
        //小编推荐
        $data['top_article'] = $this->article->get_article($pid,1,5);

        $top_parentid = $this->place->parentid($pid);
        $tid=array();
        foreach($top_parentid as $k=>$v){
            $tem = $this->get_one_data('place', 'pid,name', array('pid' => $v, 'del' => 0, 'sta' => 0,'virtual'=>0));
            if($tem){
                array_push($tid,$v);
            }
        }
        foreach($tid as $k=>$v){
            $tem = $this->get_one_data('place', 'pid,name', array('pid' => $v, 'del' => 0, 'sta' => 0,'virtual'=>0));
            $arr[]=$tem['name'];
        }
        $data['top_parent']=array_map(null,$tid,$arr);
        //当前目的地的详细信息
        $p= $this->get_one_data('place', '*', array('pid' => $pid, 'del' => 0, 'sta' => 0));
        $data['place']=$p;
        //热门贴子
        $list_travel = $this->uc->dz_get_forum_threads(2, 1, 3, '', $p['name'], 'views desc');
        $this->load->vars('list_travel', $list_travel);

        //判断此目的地此用户是否已有记录
        $childs = $this->place->place_tree($pid);
        if ($p['deep'] == 1) {
            $place = 'country';
        }elseif(count($childs)>0 && $p['deep']>1){
            $place = 'city';
        }elseif(count($childs)==0 && $p['deep']>1){
            $place = 'placeid';
        }
        $data['top']=$place;
        $visit = $this->get_one_data('place_visit', '*', array('uid' => $this->uid, 'placeid' => $pid));
        $data['visit'] = $visit;
        //banner图
        $data['banner'] = $this->place->get_place_img($pid);
        //攻略
        $gid = $this->get_one_data('guide', '*', array('place_id' => $pid, 'sport_id' => 0, 'del' => 0, 'sta' => 0));
        $data['place']['gid'] = $gid['gid'];
        //去过
        $data['visit_had'] = $this->place->get_place_beento($pid, 1, 2);
        //想去
        $data['visit_to'] = $this->place->get_place_planto($pid, 1, 2);

        //获取运动标签
        $tag = $this->place->get_data('taxonomy_term', $filed = 'ttid,name', $where = array('tid' => 4, 'del' => 0, 'sta' => 0, 'typeid' => 0));
        //运动属于标签下面  如果运动的标签中有此标签就属于这个标签下的运动
        foreach ($tag as $key => $t) {
            $tid = $t['ttid'];
            $tag[$key]['child'] = $this->sport->connect_table('spid,name,name_en,img', $where = array('del' => 0, 'sta' => 0, 'taxonomy_id' => 4, 'term_id' => $tid), 'weight', 'sport', 'sport_taxonomy', 'spid=sport_id');
        }

        $data['sport'] = $tag;
        $s = $this->place->get_all_sports($pid);
        foreach($s as $k=>$v){
            $arr []= $k;
        }
        $data['sports']=$arr;
        //统计
        $data['sports_total'] = $this->place->sports_total($pid);
        $data['been_total'] = $this->place->been__want_total($pid, 2);
        //echo $this->
        $data['comments_total'] = $this->place->comments_total($pid);

        $tree = $this->place->get_offspring_place($pid);
        $data['total_deep3'] = count($tree)-1;
        $data['this_pid']=$pid;
        return $data;
    }

    /**
     * 想去操作
     * */
    public function ajax_plan()
    {
        $pid = $_GET['pid'];
        $plan = $_GET['plan'];
        //父级id
        $parent = $this->place->parentid($pid);
        if(count($parent)==1){
            $country = $pid;
            $city=0;
        }elseif(count($parent)==2){
            $country = $parent[1];
            $city=$pid;
        }elseif(count($parent)>2){
            $country = $parent[1];
            $city=$parent[2];
        }else{
            die;
        }
        if ($this->uid || $this->uid > 0) {
            $where = array('uid' => $this->uid, 'country'=>$country,'city'=>$city,'placeid'=>$pid);
            //查询是否已有记录
            $q = $this->get_one_data('place_visit', 'uid', $where);

            if ($q) { //已有记录
                $res = $this->place->place_want_update($where, array('planto' => $plan, 'created' => time()));
                if ($res) {
                    $s = $this->get_one_data('place_visit', '*', $where);
                    echo json_encode($s['planto']);
                } else {
                    return false;
                }
            } else {
                $data = array('uid' => $this->uid, 'country'=>$country,'city'=>$city,'placeid'=>$pid, 'planto' => $plan, 'created' => time());
                $res = $this->place->place_want($data);
                if ($res) {
                    echo json_encode(1);
                } else {
                    return false;
                }
            }
        } else {
            echo json_encode(array("code" => -1, "msg" => "nologin", 'url' => PASSPORT_domian . 'oauth/login'));
        }
    }

    /**
     * 去过操作
     * */
    public function ajax_been()
    {
        $pid = $_GET['pid'];
        $been = $_GET['been'];
        //父级id
        $parent = $this->place->parentid($pid);
        if(count($parent)==1){
            $country = $pid;
            $city=0;
        }elseif(count($parent)==2){
            $country = $parent[1];
            $city=$pid;
        }elseif(count($parent)>2){
            $country = $parent[1];
            $city=$parent[2];
        }else{
            die;
        }

        if ($this->uid || $this->uid > 0) {
            $where = array('uid' => $this->uid, 'country'=>$country,'city'=>$city,'placeid'=>$pid);
            //查询是否已有记录
            $q = $this->get_one_data('place_visit', 'uid', $where);
            if ($q) { //已有记录
                $res = $this->place->place_want_update($where, array('beento' => $been, 'created' => time()));
                if ($res) {
                    $s = $this->get_one_data('place_visit', '*', $where);
                    echo json_encode($s['beento']);
                } else {
                    return false;
                }
            } else {
                $data = array('uid' => $this->uid, 'country'=>$country,'city'=>$city,'placeid'=>$pid, 'beento' => $been, 'created' => time());
                $res = $this->place->place_want($data);
                if ($res) {
                    echo json_encode(1);
                } else {
                    return false;
                }
            }
        } else {
            echo json_encode(array("code" => -1, "msg" => "nologin", 'url' => PASSPORT_domian . 'oauth/login'));
        }
    }

    //城市列表
    public function city()
    {
        $params = $this->uri->uri_to_assoc(3);
        $pid = $params['pid'];
        $pid = $pid ? $pid : message('参数错误', 'place');
        $place_info= $this->get_one_data('place', '*', array('pid' => $pid, 'del' => 0, 'sta' => 0));
        if(!$place_info){message('参数错误', 'place');}

        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('目的地 | ', $place_info['name'] . ' | 城市 | '));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
//        $this->load->vars('css', $this->css(array('other.css')));

        $data=array_merge($this->left($pid));
        //分页数据开始
        $total_data =count($this->place->get_citylist($pid));
        $pagesize = 9;
        $page = $this->get_uri_segment(5);
        $offset = ($page - 1) * $pagesize;
        $data['pagelink'] = $this->get_pagination('place/city/pid/' . $pid, 5, 2, $total_data, $pagesize);
        $data['place_city'] =  $this->place->get_citylist($pid, $offset, $pagesize);
        foreach($data['place_city'] as $k =>$v){
            $img = $this->place->get_place_img($v['pid'], 1);
            $data['place_city'][$k]['img']=$img['img'];
        }
        //分页数据结束

        $this->load->view('place/city', $data);
    }

    //目的地详情页
    public function detail($pid)
    {
        $pid = $pid ? $pid : message('参数错误', 'place');
        $data['place'] = $place_info=$this->get_one_data('place', '*', array('pid' => $pid, 'del' => 0, 'sta' => 0));
        if(!$data['place']){message('参数错误', 'place');}


        $gid = $this->get_one_data('guide', '*', array('place_id' => $pid, 'sport_id' => 0, 'del' => 0, 'sta' => 0));
        $data['place']['gid'] = $gid['gid'];
        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('目的地 | ', $data['place']['name'] . ' |'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('other.css')));
        $this->load->vars('js', $this->js(array('jquery.raty.min.js','jquery/jquery.validate.min.js')));

        //广告图
        $data['ad'] = $this->sport->connect_table('ads.img,ads.weblink', $where = array('is_del' => 2, 'flag' => 1, 'ads_sclass.id' => 248), 'sort_number', 'ads', 'ads_sclass', 'ads_sclass.id=ads.classid');


        //评论
        $where = array('del' => 0, 'sta' => 0, 'pid' => $pid);
        $total_data = $this->total_data('place_comments', $where);
        $pagesize = 6;
        $page = $this->get_uri_segment(5);
        $offset = ($page - 1) * $pagesize;
        $data['pagelink'] = $this->get_pagination('place/detail/pid/', 5, 2, $total_data, $pagesize);
        $data['comments'] = $this->place->get_comments($where = array('del' => 0, 'sta' => 0, 'pid' => $pid), '', $offset, $pagesize);
        foreach ($data['comments'] as $k => $v) {
            $user = $this->get_one_data('members', 'username,avatar', array('uid' => $data['comments'][$k]['uid']));
            $data['comments'][$k]['username'] = $user['username'];
            $data['comments'][$k]['avatar'] = $user['avatar'];
        }
        //发表评论
        $data['form'] = form_open('place/comment_save2', array('id' => 'form1'));
        //此运动的平均评分  james
        $avg=$this->sport->get_avg('place_comments','score',$where);
        $data['avg']= round($avg, 1);

        return $data;
    }

    //评论提交
    public function comment_save2()
    {
        echo '<meta http-equiv="content-type" content="text/html;charset=utf-8"/>';
        $pid = $this->post('pid');
        $pid = $pid ? $pid : message('参数错误', 'place');
        $comments = $this->post('comment');
        //james 获取评论分数
        $score=$this->post('score');
        if($score<=0){
            message('参数错误', 'place');
        }
        $comments = $comments ? $comments : message('参数错误', 'place');
        $data = array('score'=>$score,'pid' => $pid, 'description' => $comments, 'ip' => $this->input->ip_address(), 'uid' => $this->uid, 'created' => time());
        if ($this->uid || $this->uid > 0) {
            $s = $this->my_add('place_comments', $data);
            if ($s) {
                message('提交成功!', 'place/index/pid/'.$pid);
            } else {
                message('提交失败!', 'place/index/pid/'.$pid);
            }
        } else {
            message('请先登录!', PASSPORT_domian. 'oauth/login');
        }
    }

    //景点列表
    public function scenic()
    {
        $params = $this->uri->uri_to_assoc(3);
        $pid = $params['pid'];
        $pid = $pid ? $pid : message('参数错误', 'place');
        $place_info = $this->get_one_data('place', '*', array('pid' => $pid, 'del' => 0, 'sta' => 0));
        if(!$place_info){message('参数错误', 'place');}

        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('目的地 | ', $place_info['name'] . ' | 景点 | '));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
//        $this->load->vars('css', $this->css(array('other.css')));

        $data=array_merge($this->left($pid));

        //分页数据开始
        if($place_info['deep']==1){
            $total_data =count($this->place->get_sceniclist($pid));
        }else{
            $total_data =count($this->place->get_citylist($pid));
        }
        $pagesize = 9;
        $page = $this->get_uri_segment(5);
        $offset = ($page - 1) * $pagesize;
        $data['pagelink'] = $this->get_pagination('place/scenic/pid/' . $pid, 5, 2, $total_data, $pagesize);
        if($place_info['deep']==1){
             $data['place_scenic'] =  $this->place->get_sceniclist($pid, $offset, $pagesize);
        }else{
            $data['place_scenic'] =  $this->place->get_citylist($pid, $offset, $pagesize);
        }
        foreach($data['place_scenic'] as $k =>$v){
            $img = $this->place->get_place_img($v['pid'], 1);
            $data['place_scenic'][$k]['img']=$img['img'];
        }
        //分页数据结束
        $this->load->view('place/scenic', $data);
    }

    //兴趣部落列表
    public function sports()
    {
        $params = $this->uri->uri_to_assoc(3);
        $pid = $params['pid'];
        $pid = $pid ? $pid : message('参数错误', 'place');
        $place_info = $this->get_one_data('place', '*', array('pid' => $pid, 'del' => 0, 'sta' => 0));
        if(!$place_info){message('参数错误', 'place');}

        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('目的地 | ', $place_info['name'] . ' | 兴趣部落 | '));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
//        $this->load->vars('css', $this->css(array('other.css')));

        $data=array_merge($this->left($pid));
        //分页数据开始
        $total_data = count($this->place->get_all_sports($pid));
        $pagesize = 9;
        $page = $this->get_uri_segment(5);
        $offset = ($page - 1) * $pagesize;
        $data['pagelink'] = $this->get_pagination('place/sports/pid/' . $pid, 5, 2, $total_data, $pagesize);
        $data['place_sports'] = $this->place->get_all_sports($pid, $offset, $pagesize);
        //分页数据结束
        $this->load->view('place/sports', $data);
    }

    //点评列表
    public function comment()
    {
        $params = $this->uri->uri_to_assoc(3);
        $pid = $params['pid'];
        $pid = $pid ? $pid : message('参数错误', 'place');
        $place_info = $this->get_one_data('place', '*', array('pid' => $pid, 'del' => 0, 'sta' => 0));
        if(!$place_info){message('参数错误', 'place');}

        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('目的地 | ', $place_info['name'] . ' | 点评 | '));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('other.css','validate.css')));
        $this->load->vars('js', $this->js(array('jquery.raty.min.js','jquery/jquery.validate.min.js')));

        $data=array_merge($this->left($pid));

        //评论
        $total_data = $this->total_data('place_comments', $where = array('del' => 0, 'sta' => 0, 'pid' => $pid));
        $pagesize = 6;
        $page = $this->get_uri_segment(5);
        $offset = ($page - 1) * $pagesize;
        $data['pagelink'] = $this->get_pagination('place/comment/pid/', 5, 2, $total_data, $pagesize);
        $data['comments'] = $this->place->get_comments($where = array('del' => 0, 'sta' => 0, 'pid' => $pid), '', $offset, $pagesize);
        foreach ($data['comments'] as $k => $v) {
            $user = $this->get_one_data('members', 'username,avatar', array('uid' => $data['comments'][$k]['uid']));
            $data['comments'][$k]['username'] = $user['username'];
            $data['comments'][$k]['avatar'] = $user['avatar'];
        }
        //发表评论
        $data['form'] = form_open('place/comment_save', array('id' => 'form1'));
        //此运动的平均评分  james
        $avg=$this->sport->get_avg('place_comments','score',$where);
        $data['avg']= round($avg, 1);
        //分页数据结束
        $this->load->view('place/comment', $data);
    }

    //评论提交
    public function comment_save()
    {
        echo '<meta http-equiv="content-type" content="text/html;charset=utf-8"/>';
        $pid = $this->post('pid');
        $pid = $pid ? $pid : message('参数错误', 'place');
        //james 获取评论分数
        $score=$this->post('score');
        if($score<=0){
            message('参数错误', 'place');
        }
        $comments = $this->post('comment');
        $comments = $comments ? $comments : message('参数错误', 'place');
        $data = array('score'=>$score,'pid' => $pid, 'description' => $comments, 'ip' => $this->input->ip_address(), 'uid' => $this->uid, 'created' => time());
        if ($this->uid || $this->uid > 0) {
            $s = $this->my_add('place_comments', $data);
            if ($s) {
                message('提交成功!', 'place/comment/pid/'.$pid);
            } else {
                message('提交失败!', 'place/comment/pid/'.$pid);
            }
        } else {
            message('请先登录!', PASSPORT_domian. 'oauth/login');
        }
    }

    //图片列表
    public function picture()
    {
        $params = $this->uri->uri_to_assoc(3);
        $pid = $params['pid'];
        $pid = $pid ? $pid : message('参数错误', 'place');
        $place_info = $this->get_one_data('place', '*', array('pid' => $pid, 'del' => 0, 'sta' => 0));
        if(!$place_info){message('参数错误', 'place');}

        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('目的地 | ',$place_info['name'] . ' | 图片 | '));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('other.css', 'lightbox/lightbox.css')));
        $this->load->vars('js', $this->js('lightbox2/lightbox.min.js'));

        $data=array_merge($this->left($pid));

        //分页数据开始
        $total_data = count($this->place->get_all_picture($pid));
        $pagesize = 12;
        $page = $this->get_uri_segment(5);
        $offset = ($page - 1) * $pagesize;
        $data['pagelink'] = $this->get_pagination('place/picture/pid/' . $pid, 5, 2, $total_data, $pagesize);

        $data['place_picture'] = $this->place->get_all_picture($pid, $offset, $pagesize);
        //分页数据结束
        $this->load->view('place/picture', $data);
    }

    //背包列表
    public function bag()
    {
        $params = $this->uri->uri_to_assoc(3);
        $pid = $params['pid'];
        $pid = $pid ? $pid : message('参数错误', 'place');
        $place_info = $this->get_one_data('place', '*', array('pid' => $pid, 'del' => 0, 'sta' => 0));
        if(!$place_info){message('参数错误', 'place');}

        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('目的地 | ', $place_info['name'] . ' | 背包 | '));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('other.css')));
        $this->load->vars('js', $this->js(array('layer-v1.8.5/layer/layer.min.js', 'layer-v1.8.5/layer/extend/layer.ext.js')));

        $data=array_merge($this->left($pid));

        //分页数据开始
        $total_data = count($this->place->get_all_bag($pid));
        $pagesize = 12;
        $page = $this->get_uri_segment(5);
        $offset = ($page - 1) * $pagesize;
        $data['pagelink'] = $this->get_pagination('place/bag/pid/' . $pid, 5, 2, $total_data, $pagesize);
        $data['place_bag'] = $this->place->get_all_bag($pid, $offset, $pagesize);
        foreach ($data['place_bag'] as $k => $v) {
            $favorites_num = $this->place->bag_favorites_num($v['id']);
            $data['place_bag'][$k]['favorites_num'] = $favorites_num;
            $s = $this->get_one_data('bag_favorites', '*', array('uid' => $this->uid, 'bagid' => $v['id']));
            if ($s) {
                $data['place_bag'][$k]['had'] = 1;
            } else {
                $data['place_bag'][$k]['had'] = 0;
            }
        }
        //分页数据结束
        $this->load->view('place/bag', $data);
    }

    //背包详情
    public function ajax_bag()
    {
        $bagid = intval($this->uri->segment(3)); //获取背包ID
        $bagid = $bagid ? $bagid : message('参数错误', 'place');
        $s = $this->place->get_bags_list($bagid);
        if (!$s) {
            $s = array();
        }
        $describe = $this->get_one_data('bag', 'remark,title', array('id' => $bagid));

        $data['bag_detail'] = $s;
        $data['describe'] = $describe;
        $this->load->view('place/bag_detail', $data);
    }

    //收藏背包
    public function bag_favorites()
    {
        $params = $this->uri->uri_to_assoc(3);
        $bagid = $params['bagid'];
        $pid = $params['pid'];
        $bagid = $bagid ? $bagid : message('参数错误', 'place/bag/pid/' . $pid);
        $pid = $pid ? $pid : message('参数错误', 'place');
        $data = array('uid' => $this->uid, 'bagid' => $bagid, 'typeid' => 1, 'created' => time());
        $r = $this->get_one_data('bag_favorites', '*', array('uid' => $this->uid, 'bagid' => $bagid, 'typeid' => 1));
        if ($this->uid || $this->uid>0) {
            if ($r) {
                message('您已收藏过该背包!', 'place/bag/pid/'.$pid);
            } else {
                $s = $this->my_add('bag_favorites', $data);
                if ($s) {
                    message('收藏成功!', 'place/bag/pid/'.$pid);
                } else {
                    message('提交失败!', 'place/bag/pid/'.$pid);
                }
            }
        } else {
            message('请先登录!', PASSPORT_domian. 'oauth/login');
        }
    }

    //相关文章列表
    public function article()
    {
        $params = $this->uri->uri_to_assoc(3);
        $pid = $params['pid'];
        $pid = $pid ? $pid : message('参数错误', 'place');
        $place_info = $this->get_one_data('place', '*', array('pid' => $pid, 'del' => 0, 'sta' => 0));
        if(!$place_info){message('参数错误', 'place');}

        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('目的地 | ', $place_info['name'] . ' | 相关文章 | '));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('other.css')));

        $data=array_merge($this->left($pid));
        //分页数据开始
        $total_data = $this->article->total_all_article($pid);
        $pagesize = 9;
        $page = $this->get_uri_segment(5);
        $offset = ($page - 1) * $pagesize;
        $data['pagelink'] = $this->get_pagination('place/article/pid/' . $pid, 5, 2, $total_data, $pagesize);
        $data['place_article'] = $this->article->get_all_article($pid, 1,$offset, $pagesize);
        //分页数据结束
        $this->load->view('place/article', $data);
    }
    /**信息详情页*/
    public function adetail()
    {
        $params = $this->uri->uri_to_assoc(3);
        $id = $params['id'];
        $id = $id ? $id : message('参数错误', 'place');
        $pid = $params['pid'];
        $pid = $pid ? $pid : message('参数错误', 'place');

//        $place_info = $this->get_one_data('place', '*', array('pid' => $pid, 'del' => 0, 'sta' => 0));
//        if(!$place_info){message('参数错误', 'place');}

        $detail= $this->get_one_data('article', '*', array('id' => $id));
        if(!$detail){message('参数错误', 'place');}
        if($detail){
            $this->upd_one_data('article',array('hit'=>$detail['hit']+1),array('id'=>$id));
        }else{
            message('参数错误', 'place');
        }
        $this->load->vars('meta', $this->meta);
//        $this->load->vars('title', $this->title('目的地 | ', $place_info['name'] . ' | 相关文章 | '));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('other.css')));
        $this->load->vars('title', $this->title($detail['title']));

//        $data=array_merge($this->left($pid));
        $data['detail']=$detail;

//        $this->load->view('place/adetail', $data);
        //最新文章5个
        $classic=$detail['classic'];//类型
        $data['latest_news']=$this->sport->latest_news(5,$classic);
        $this->load->view('sport/news_show', $data);
    }
}