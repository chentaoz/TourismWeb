<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'core/MY_UserController.php';

class User extends MY_UserController
{
    protected $member;
    protected $constellation=array('1'=>'白羊座','2'=>'金牛座','3'=>'双子座','4'=>'巨蟹座','5'=>'狮子座','6'=>'处女座','7'=>'天秤座','8'=>'天蝎座','9'=>'射手座','10'=>'摩羯座','11'=>'水瓶座','12'=>'双鱼座');
    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model', 'common');
        $this->load->model('sport_model', 'sport');
        $this->load->model('place_model', 'place');
        $this->load->model('uc_model', 'uc');
        if (!$this->uid) {
           message('请先登录', PASSPORT_domian.'oauth/login');
        }
      $this->member = $this->get_member($this->uid);
	  // $this->member = $this->get_member(23);
    }

    /*
     * 用户中心首页
     * */
    public function index()
    {

        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('用户中心首页'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
//        $this->load->vars('css', $this->css(array('base.css', 'index.css', 'member.css')));
        //查询这个用户是否选择过想玩和玩过的数据
        $data['play'] = $play = $this->get_one_data('sport_play', 'sport_id', array('uid' => $this->uid));
            $data['rand_sport'] = $this->sport->rand_data('sport', 'spid,name,img', array('del' => 0, 'sta' => 0), 'RAND()', 12);
            $save_sport = $this->sport->get_save_sport($this->uid);
            foreach ($save_sport as $key => $r) {
                //查询多少人玩过
                $save_sport[$key]['played'] = $this->sport->count_data('sport_play', array('sport_id' => $r['sport_id'], 'beento' => 1));
                //这个运动下的清单数
                $save_sport[$key]['list'] = $this->sport->c_table_count_data('sport_taxonomy', 'taxonomy_term_hierarchy', 'term_id=parent', array('sport_id' => $r['sport_id'], 'taxonomy_id' => 2));
                //相关场地
                $save_sport[$key]['space'] = $this->sport->count_data('place_sport', array('sport_id' => $r['sport_id']));
                //此运动的一张图片
                $save_sport[$key]['img']=$this->get_one_data('place_sport_images', 'img',array('sport_id' => $r['sport_id'],'place_id'=>0));
            }
            $want = array();
            $gone = array();
            foreach ($save_sport as $key => $s) {//拼装想去和去过的数据
                if ($s['beento'] == 1) {//玩过
                    array_push($gone, $save_sport[$key]);
                }
                if ($s['planto'] == 1) { //想玩
                    array_push($want, $save_sport[$key]);
                }
            }
            $data['want'] = $want;
            $data['gone'] = $gone;
        //关注数
        $data['friend_ls'] = $this->uc->friend_ls($this->uid, $page = 1, $pagesize = 6, $totalnum = 6, $direction = 0);
        //粉丝列表
        $data['fans_list'] = $this->uc->attention_me($this->uid, 0, 6);
        //获取去过多少个国家和城市
        $data['country']= $this->sport->get_statistics($this->uid,1);
        $data['city']= $this->sport->get_statistics($this->uid,2);
         //去过的城市的信息坐标
        $play_city=$this->sport-> view_city_location($this->uid);
        //获取用户去过的场点给地图
       // var_dump($play_city);
        $play_location= $this->sport->get_view_location($this->uid);
        if($play_location){
            $all_view=array_merge($play_city,$play_location);
        }else{
            $all_view=$play_city;
        }
        $data['play_city'] = json_encode($all_view);
       // var_dump($paly_c);
        //给我的留言数据
        $total_array = $this->all_data('comments', 'id', array('objectid' => $this->uid), 'created', $type = 'asc');
        $total = count($total_array);
        $pagesize = 8;
        $page = $this->get_uri_segment(3);
        $offset = ($page - 1) * $pagesize;
        $data['pagelink'] = $this->get_pagination('user/index', 3, 2, $total, $pagesize);
        $comment = $this->sport->contact_get_pagedata('comments', 'members', 'username,parentid,id,comments.uid,body,created', array('objectid' => $this->uid, 'del' => 0, 'sta' => 0), $offset, $pagesize, 'created', $style = 'asc', 'comments.uid=members.uid');
        //我的攻略
        $data['my_guid'] = $this->uc->dz_get_forum_threads($attachment = -1, $currentpage = 1, $pagesize = 6, 3, $wd = '', $ordrby = '', $this->uid);
        //统计总共的景点个数
        $data['view_num']= $this->sport->get_view_num($this->uid,1);
        $data['comment'] = $comment;
        $data['offset'] = $offset;
        $data['total_array'] = $total_array;
        $data['header_info']=$this->member;
        $this->load->view('user/index', $data);

    }

    /*
     * 用户个人资料
     * */
    public function person_info()
    {
        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('用户中心首页'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('base.css', 'user.css','member.css')));
        //个人资料本地数据 连表查询

        $data['constellation']=$this->constellation;
        $data['user_info'] = $this->sport->get_user_info($this->uid);
        $data['header_info']=$this->member;
        $this->load->view('user/person_info', $data);
    }

    /*
     * 修改邮箱
     * */
    public function edit_email()
    {
        if ($this->input->is_ajax_request()) {//编辑邮箱
            $email = trim($this->post('em')); //邮箱
            $pwd = md5(trim($this->post('password')));//密码

            //验证密码
            $res = $this->get_one_data('members', 'uid', array('uid' => $this->uid, 'password' => $pwd));
            if (!$res) {
                echo 3;
                exit;
            }
            //验证邮箱
            $e_res = $this->get_one_data('members', 'uid', array('email' => $email));
            if ($e_res) {
                echo 4;
                exit;
            }
            $this->load->library('encrypt');
            $code = $this->encrypt->encode($this->uid);
            $verifyurl = PASSPORT_domian . "oauth/activate?code=" . urlencode($code);
            //发送邮件
            $body = '野孩子邮箱验证地址：<a href="' . $verifyurl . '">' . $verifyurl . '</a>';
            $res = send_email('609468798@qq.com', '野孩子修改邮箱', $body, $this->site_configs);
            //发送成功
            if ($res) {
                //更新数据库
                $l_res = $this->sport->my_update('members', array('email' => "$email", 'emailstatus' => 0), array('uid' => $this->uid));//本地
                //更新discuz
                $d_res = $this->uc->uc_update('common_member', array('email' => "$email", 'emailstatus' => 0), $this->uid);
                //更新uc
                $uc_res = $this->uc->uc_update('ucenter_members', array('email' => "$email"), $this->uid);
                echo $l_res;
            } else {
                echo 0;
            }
        } else {
            $this->load->vars('meta', $this->meta);
            $this->load->vars('title', $this->title('我的关注'));
            $this->load->vars('keywords', $this->keywords);
            $this->load->vars('description', $this->description);
            $this->load->vars('css', $this->css(array('base.css', 'user.css')));
            $data['header_info']=$this->member;
            $this->load->view('user/edit_email');
        }

    }

    /*
     * 我的关注
     * */
    public function my_attention()
    {   $uid=$this->uid;
        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('我的关注'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('base.css', 'user.css','member.css')));
        $this->load->vars('js', $this->js('layer-v1.8.5/layer/layer.min.js'));
        //我的好友个数
        $data['friends_num'] = $total = $this->uc->friend_totalnum($uid, $direction = 0);
        //我的好友列表
        $page = $this->get_uri_segment(4);
        $pagesize = 10;
        $data['friends'] = $this->uc->friend_ls($uid, $page, $pagesize, $total);
        $data['link'] = $this->get_pagination('user/my_attention', 4, 7, $total, $pagesize);
        $data['header_info']=$this->member = $this->get_member($uid);
        $this->load->view('user/my_attention', $data);
    }

    /*
     *我的粉丝
     * */
    public function my_fans()
    {    $uid=$this->uid;
        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('我的粉丝'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('base.css', 'user.css','member.css')));
        $this->load->vars('js', $this->js('layer-v1.8.5/layer/layer.min.js'));
        //谁关注我
        $pagesize = 10;
        //关注我的总数
        $data['fans_num'] = $fans_num = $this->uc->att_num($uid);
        //关注我分页数据
        $page = $this->get_uri_segment(4);
        $offset = ($page - 1) * $pagesize;
        $data['fans'] = $fans = $this->uc->attention_me($uid, $offset, $pagesize);
        $data['link'] = $this->get_pagination('user/my_fans/'.$uid, 4, 7, $fans_num, $pagesize);
        $data['header_info']=$this->member = $this->get_member($uid);
        $this->load->view('user/my_fans', $data);


    }

    /*头像修改
     * */
    public function edit_avatar()
    {
        if ($_POST) {
            $name = $this->post('ava_name');
            if ($name == '') {
                echo 0;
                exit;
            }
            $path_info = pathinfo($name);
            $file_extension = $path_info["extension"];
            $file = FCPATH . 'upload/tmp/' . $name; //旧目录
            $ava_name = '/' . $this->config->item('upload_avatar') . '/' . $this->uid . '.' . $file_extension; //新目录
            $file_new = FCPATH . $ava_name;
            copy($file, $file_new); //拷贝到新目录
            @unlink($file); //删除旧目录下的文件
            $res = $this->sport->my_update('members', array('avatar' => $ava_name, 'avatarstatus' => 1), array('uid' => $this->uid));//本地
            if ($res) {
                $cache_key_user_avatar_thumb = 'user_avatar_thumb_' . $this->uid;
                ci_delete_cache($cache_key_user_avatar_thumb);
                echo 1;
            } else {
                echo 0;
            }

        } else {
            $this->load->vars('meta', $this->meta);
            $this->load->vars('title', $this->title('修改头像'));
            $this->load->vars('keywords', $this->keywords);
            $this->load->vars('description', $this->description);
            $this->load->vars('css', $this->css(array('base.css', 'user.css','member.css')));
            $this->load->vars('js', $this->js(array('swfupload/handlers.js', 'swfupload/fileprogress.js', 'swfupload/swfupload.js', 'swfupload/swfupload.queue.js')));
            $avatar = $this->get_one_data('members', 'avatar', $where = array('uid' => $this->uid));
            $this->set_vars('avatar', $avatar);
            $data['header_info']=$this->member;
            $this->load->view('user/edit_avatar',$data);
        }

    }

    /*密码修改
     * */
    public function edit_pwd()
    {
        if ($_POST) {//提交
            $opwd = md5(trim($this->post('opwd')));//原来的密码
            $npwd = md5(trim($this->post('npwd')));//新密码
            //验证密码
            $res = $this->get_one_data('members', 'uid', array('uid' => $this->uid, 'password' => $opwd));
            if ($res) {//密码正确
                $l_res = $this->sport->my_update('members', array('password' => $npwd), array('uid' => $this->uid));//本地
                //更新discuz
                $d_res = $this->uc->uc_update('common_member', array('password' => $npwd), $this->uid);
                //更新uc
                $salt = rand(1000, 9999);
                $npwd = md5(trim($this->post('npwd')) . $salt);
                $uc_res = $this->uc->uc_update('ucenter_members', array('password' => $npwd, 'salt' => $salt), $this->uid);
                $content = '密码修改成功';
                message($content, 'user/person_info');

            } else {
                $content = '原始密码不正确';
                message($content, 'user/edit_pwd');
            }

        } else {
            $this->load->vars('meta', $this->meta);
            $this->load->vars('title', $this->title('修改密码'));
            $this->load->vars('keywords', $this->keywords);
            $this->load->vars('description', $this->description);
            $this->load->vars('css', $this->css(array('base.css', 'user.css', 'validate.css','member.css')));
            $this->load->vars('js', $this->js(array('jquery/jquery.validate.min.js')));
            $data['header_info']=$this->member;
            $this->load->view('user/edit_pwd',$data);
        }

    }

    /*
     * ajax 取消关注
     * */
    public function cancel_att()
    {
        $friendids = $this->post('fid');
        $res = $this->uc->friend_delete($this->uid, $friendids);
        echo $res;
    }

    /*ajax 添加关注
     *
     * **/
    public function add_att()
    {
        $friendids = $this->post('fid');
        if($friendids==$this->uid){//不允许添加自己
            echo 'noallow';

        }
        $res = $this->uc->friend_add($this->uid, $friendids);
        if($res){
           echo 's';
        }else{
            echo 'f';
        }

    }

    /*
     * 选择想玩
     * */
    public function play()
    {
        $val = intval($this->post('value'));//想玩还是玩过
        $t_array = array(0, 1);
        if (!in_array($val, $t_array)) {
            echo 0;
            exit;
        }
        $spid = intval($this->input->post('id'));//运动ID
        //查询是否已有记录
        $q = $this->get_one_data('sport_play', 'sport_id', array('sport_id' => $spid, 'uid' => $this->uid));
        if ($q) {//已有记录
            $res = $this->sport->my_update('sport_play', array('planto' => $val), array('sport_id' => $spid, 'uid' => $this->uid));
            $this->sport->my_delete('sport_play', array('planto' => 0, 'beento' => 0, 'sport_id' => $spid, 'uid' => $this->uid));
            if ($res) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $data = array('sport_id' => $spid, 'uid' => $this->uid, 'planto' => 1, 'created' => time());
            $res = $this->my_add('sport_play', $data);;
            if ($res) {
                echo 1;
            } else {
                echo 0;
            }
        }


    }

    /*
     * 选择玩过
     * */
    public function played()
    {
        $val = intval($this->post('value'));//想玩还是玩过
        $t_array = array(0, 1);
        if (!in_array($val, $t_array)) {
            echo 0;
            exit;
        }
        $spid = intval($this->input->post('id'));//运动ID
        //查询是否已有记录
        $q = $this->get_one_data('sport_play', 'sport_id', array('sport_id' => $spid, 'uid' => $this->uid));
        if ($q) {//已有记录
            $res = $this->sport->my_update('sport_play', array('beento' => $val), array('sport_id' => $spid, 'uid' => $this->uid));
            $this->sport->my_delete('sport_play', array('planto' => 0, 'beento' => 0, 'sport_id' => $spid, 'uid' => $this->uid));
            if ($res) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $data = array('sport_id' => $spid, 'uid' => $this->uid, 'beento' => 1, 'created' => time());
            $res = $this->my_add('sport_play', $data);;
            if ($res) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    /*
         * 我的照片
     * */
    public function photo()
    {
        $this->load->vars('title', $this->title('我的照片'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
//        $this->load->vars('css', $this->css(array('jquery.lightbox.css')));
//        $this->load->vars('js', $this->js(array('lightbox/jquery.lightbox.min.js')));
        //查询此用户照片年份数组
        $year = $this->sport->sql_query("SELECT from_unixtime(created,'%Y') as year from " . $this->db->dbprefix . "photo WHERE uid='{$this->uid}'GROUP BY  from_unixtime(created,'%Y') ORDER BY created DESC");
        /*转换为一位数组*/
        $new_y = array();
        foreach ($year as $y) {
            $new_y[] = $y['year'];
        }
        //此年下面的按月查找的单条代表数据
        foreach ($new_y as $key => $y) {
            $year[$key]['mounth'] = $this->sport->sql_query("SELECT  filename,from_unixtime(created,'%c') as m  ,count(*) as num from " . $this->db->dbprefix . "photo WHERE uid='{$this->uid}' AND from_unixtime(created,'%Y')={$y} GROUP BY  from_unixtime(created,'%Y%c') ORDER BY created DESC");

        }
        //赋值给模版
        $data['year'] = $year;
        $data['header_info']=$this->member;
        $this->load->view('user/photo', $data);
    }

    /**用户相册*/
    public function album()
    {
        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('我的相册'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('base.css', 'member.css')));
        $this->load->view('user/album');
    }

    /*
     * 上传照片模版
     * */
    public function up_photo()
    {
        if ($this->input->is_ajax_request()) { //ajax提交
            $p_arr = $this->input->post('photo_name');
            if (count($p_arr) <= 0) {
                echo 0;
                exit;
            }
            //组合数据添加数据库
            $photo_arr = array();
            foreach ($p_arr as $v) {
                $filefolder = FCPATH . $this->config->item('upload_photo') . '/' . date('Ymd');
                if (!is_dir($filefolder)) {
                    mkdir($filefolder, 0777, true);
                }
                $file_tmp = FCPATH . $this->config->item('upload_temp') . '/' . $v; //临时文件
                $file_new = $filefolder.'/' . $v; //新文件相对路径
                copy($file_tmp, $file_new); //拷贝到新目录
                @unlink($file_tmp); //删除旧目录下的文件
                $filename=date('Ymd').'/'.$v;
                $photo_arr[] = array('uid' => $this->uid, 'filename' => $filename, 'created' => time());
            }
            $res = $this->sport->batch('photo', $photo_arr);
            if ($res) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $this->load->vars('meta', $this->meta);
            $this->load->vars('title', $this->title('上传照片'));
            $this->load->vars('keywords', $this->keywords);
            $this->load->vars('description', $this->description);
            $this->load->vars('css', $this->css(array('base.css', 'member.css')));
            $this->load->vars('js', $this->js(array('indexban.js', 'swfupload/handlers.js', 'swfupload/fileprogress.js', 'swfupload/swfupload.js', 'swfupload/swfupload.queue.js','layer-v1.8.5/layer/layer.min.js')));
            $data['header_info']=$this->member;
            $this->load->view('user/up_photo',$data);
        }
    }

    /*
     * 照片详情
     * */
    public function photo_detail($year,$month,$uid)
    {
        $year = intval($this->uri->segment(3));//哪年
        $month = intval($this->uri->segment(4));//哪月
        if ($year <= 0 || $month <= 0) {
            echo "对不起发生错误！";
            exit;
        }
        //按照年月查询数据
        $uid=$uid?$uid:$this->uid;
        $photo = $this->sport->sql_query("SELECT filename from " . $this->db->dbprefix . "photo WHERE uid='{$uid}' AND from_unixtime(created,'%Y')={$year} AND from_unixtime(created,'%c')={$month}");
        $data['photo'] = $photo;
        $this->load->view('user/photo_detail', $data);


    }

    /**
     * 足迹
     *
     */
    public function spoor()
    {
        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('足迹'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('member.css')));
        $this->load->vars('js', $this->js('layer-v1.8.5/layer/layer.min.js'));
        //获取去过多少个国家和城市
        $data['country']= $this->sport->get_statistics($this->uid,1);
        $data['city']= $this->sport->get_statistics($this->uid,2);

        //连表获取去过的国家
        $countrys = $this->sport->sql_query("select pid,name,name_en from " . $this->db->dbprefix . "place_visit LEFT JOIN " . $this->db->dbprefix . "place on country=pid where uid={$this->uid} and beento=1 GROUP BY country");
        foreach ($countrys as $key => $c) {
            //查询这个国家下面的城市
            $countrys[$key]['city'] = $this->sport->sql_query("select parent,pid,name,name_en,img from " . $this->db->dbprefix . "place_visit LEFT JOIN " . $this->db->dbprefix . "place on city=pid LEFT JOIN " . $this->db->dbprefix . "place_sport_images on pid=place_id where uid={$this->uid} AND country={$c['pid']} AND city>0  and city>0 GROUP BY city,pid");
            //循环查此地点参加了几个运动
            foreach ($countrys[$key]['city'] as $k => $p) {
                $countrys[$key]['city'][$k]['view'] =$this->sport->total_view('place_visit', array('city !='=>'placeid','uid' => $this->uid, 'city' => $p['pid'], 'country' => $c['pid'], 'placeid !=' => 0,'beento'=>1,'city !='=>'placeid' ));
            }
        }
        $data['countrys'] = $countrys;
        $data['header_info']=$this->member;
        $this->load->view('user/spoor', $data);
    }

    /**
     * 足迹模块城市的添加
     *
     */
    public function spoor_city_add()
    {
        if ($this->input->is_ajax_request()) {
            $flag = intval($this->post('f'));//类型
            $country = intval($this->post('c'));//国家
            $city = intval($this->post('citys'));//城市
            $city_data = intval($this->post('dire_id'));//最终目的地
            if( !$country || !$city){
              echo 0;
             exit;
            }
            //添加数据
            //判断是否是虚拟城市
            if(!$city_data){//没有最终目的地的时候判断
                $v=$this->sport->virtual($city);
                if($v){
                    echo 4;
                    exit;
                }
            }

            //判断是否存在
            $exit=$this->sport->exit_spoor($this->uid,$city,$city_data,$flag);
            if ($exit) {//存在  1.在判断有没有添加过
                echo 3;
                exit;
            } else {//不存在
              $result= $this->sport->add_spoor($this->uid,$city,$city_data,$flag,$country);
               // echo json_encode($result)
                if ($result) {
                    echo 1;
                    exit;
                } else {
                    echo 2;
                    exit;
                }


            }
        } else {
            $this->load->vars('meta', $this->meta);
            $this->load->vars('title', $this->title('添加足迹'));
            $this->load->vars('keywords', $this->keywords);
            $this->load->vars('description', $this->description);
            $this->load->vars('css', $this->css(array('member.css')));
            $this->load->vars('js', $this->js('layer-v1.8.5/layer/layer.min.js'));
            //获取目的地全部信息
            $data['place_cate'] = $this->place->get_data('place', $filed = 'pid,name,name_en,hot,parent', array('del' => 0, 'sta' => 0));
            //获取顶级父类信息
            $place_parent = $this->place->get_data('place', $filed = 'pid,name,name_en', array('del' => 0, 'sta' => 0, 'parent' => 0));
            foreach ($place_parent as $k => $v) {
                $place_parent[$k]['child'] = $this->place->get_data('place', $filed = 'pid,name,name_en,hot', array('del' => 0, 'sta' => 0, 'parent' => $v['pid'], 'deep' => 1));
            }
            //获取去过多少个国家和城市
            $data['country']= $this->sport->get_statistics($this->uid,1);
            $data['city']= $this->sport->get_statistics($this->uid,2);
            $data['place_parent'] = $place_parent;
            $data['header_info']=$this->member;
            $this->load->view('user/spoor_city_add', $data);
        }
    }

    /*
     * 足迹 ajax 获取国家下的城市
     * */
    public function get_city()
    {
        $cid = intval($this->post('country'));//获取国家ID
        $flag=intval($this->post('fla'));
        //获取此国家的城市
        $city = $this->all_data('place', 'name,name_en,pid', array('del' => 0, 'sta' => 0, 'parent' => $cid), 'pid', 'asc');
        //循环每个城市是否有子节点 //判断是否添加过
        foreach($city as $key=>$c){

            $city[$key]['gone']=$this->sport->exit_city($this->uid,$c['pid'],$flag);

        }
        echo json_encode($city);
    }

    /**  he_liu
     * 足迹模块中的城市列表
     *
     */
    public function spoor_city()
    {

        $this->load->vars('meta', $this->meta);
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('member.css')));
        $this->load->vars('js', $this->js('layer-v1.8.5/layer/layer.min.js'));
        $city_id = intval($this->uri->segment(3));
        $uid = intval($this->uri->segment(4));
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
       $total=$this->sport->c_table_count_data('place','place_visit','place.pid=placeid',array('uid'=>$uid,'del' => 0, 'sta' => 0, 'city' => $city_id,'beento'=>1,'placeid !='=>$city_id));

        $pagesize = 10;
        $page = $this->get_uri_segment(5);
        $offset = ($page - 1) * $pagesize;
        $data['pagelink'] = $this->get_pagination('user/spoor_city/' . $city_id.'/'.$uid, 5, 2, $total, $pagesize);
        $place_city=$this->sport->contact_get_pagedata('place','place_visit', 'pid,parent,name,name_en,description',array('uid'=>$uid,'del' => 0, 'sta' => 0, 'city' => $city_id,'beento'=>1,'placeid !='=>$city_id), $offset, $pagesize, $order = 'weight', 'created','place.pid=placeid');
        //循环图片查询图片
        foreach ($place_city as $key => $c) {
           $img= $this->get_one_data('place_sport_images', 'img', array('sport_id' => 0, 'place_id' => $c['pid']));
            $place_city[$key]['img'] =$img['img'] ;
        }
        //原有的数组
       // var_dump($place_city);
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
       // var_dump($place_city);
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
     // var_dump($array_list);
        //获取父级的地点名字
        $data['c_name'] = $country = $this->get_one_data('place', 'name,parent', array('pid' => $city_id));
        $data['spaces'] = $array_list;
        $data['city_id'] = $city_id;//给js用
        $data['place_id'] = $country['parent'];
        $data['t_name']=$title;
        $this->load->view('user/spoor_city', $data);
    }

    /*
     *添加具体地点场景
     * */
    public function spoor_destination_add()
    {
        if ($this->input->is_ajax_request()) {//ajax提交处理
            $country = $this->post('country');//获取国家
            $city = $this->post('city');//获取国家
            $sport = $this->post('sport');//获取具体活动数组
            if (count($sport) == 0 || $city == '') {
                echo 0;
                exit;
            }
            //添加数据  1.组装数据
            $place_arr = array();
            foreach ($sport as $v) {
                $place_arr[] = array('uid' => $this->uid, 'country' => $country, 'city' => $city, 'beento' => 1, 'placeid' => $v, 'created' => time());
            }
            //添加数据 先删除在添加
            $this->sport->my_delete('place_visit', array('uid' => $this->uid, 'country' => $country, 'city' => $city, 'beento' => 1, 'placeid !=' => 0));
            $res = $this->sport->batch('place_visit', $place_arr);
            if ($res) {
                echo 1;
            } else {
                echo 0;
            }

        } else {
            $this->load->vars('title', $this->title('足迹添加'));
            $this->load->vars('keywords', $this->keywords);
            $this->load->vars('description', $this->description);
            $this->load->vars('css', $this->css(array('member.css')));
            $s_id = intval($this->uri->segment(3));//获取活动的地点id
            $city_id = intval($this->uri->segment(4));//获取国家的id
            if ($s_id <= 0) {
                message('参数错误', WWW_domian);
            }
            //获取所有景点数据
            $all_place = $this->all_data('place', 'pid,name', array('del' => 0, 'sta' => 0, 'parent' => $s_id, 'deep' => 3), 'weight', 'asc');
            //循环查询相关图片
            foreach ($all_place as $key => $c) {
                $all_place[$key]['img'] = $this->get_one_data('place_sport_images', 'img', array('sport_id' => 0, 'place_id' => $c['pid']));
            }
            //获取我已经选择的数据
            $party = $this->all_data('place_visit', 'placeid', array('city' => $s_id, 'uid' => $this->uid, 'placeid !=' => 0, 'country' => $city_id), 'created', 'asc');
            $party_arr = array();
            foreach ($party as $p) {
                $party_arr[] = $p['placeid'];

            }
            $data['party'] = $party_arr;
            $data['places'] = $all_place;
            $data['header_info']=$this->member;
            $this->load->view('user/spoor_destination_add', $data);
        }
    }

    /**
     * 背包主页面
     *
     */
    public function bag()
    {
        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('背包'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
//        $this->load->vars('css', $this->css(array('base.css', 'member.css')));
//        $this->load->vars('js', $this->js(array('layer-v1.8.5/layer/layer.min.js', 'layer-v1.8.5/layer/extend/layer.ext.js')));
        //背包列表
        $total = $this->total_data('bag', array('del' => 0, 'sta' => 0, 'uid' => $this->uid));
        $pagesize = 8;
        $page = $this->get_uri_segment(3);
        $offset = ($page - 1) * $pagesize;
        $bag_array = $this->sport->get_pagedata('bag', 'id,title,remark,created', array('del' => 0, 'sta' => 0, 'uid' => $this->uid), $offset, $pagesize, 'created', 'desc');

        //遍历查询详细装备
        foreach ($bag_array as $k => $b) {
            $bag_array[$k]['suit'] = $this->sport->connect_table('name,img', array('bagid' => $b['id']), 'ttid', 'bag_list', 'taxonomy_term', 'term_list_id=ttid');

        }
        //收藏的装备 连表查询
        //连表系统装备
        $system_bag = $this->sport->connect_table('name,img,bagid,bag_favorites.typeid', array('uid' => $this->uid, 'bag_favorites.typeid' => 0, 'del' => 0, 'sta' => 0, 'tid' => 2), 'bag_favorites.created', 'bag_favorites', 'taxonomy_term', 'bag_favorites.bagid=taxonomy_term.ttid');
        //连表收藏用户的装备
        $user_bag = $this->sport->connect_table('title as name,bagid,bag_favorites.typeid', array('bag_favorites.uid' => $this->uid, 'bag_favorites.typeid' => 1,'del' => 0), 'bag_favorites.created', 'bag_favorites', 'bag', 'bag_favorites.bagid=bag.id');
        $data['f_bag'] = array_merge($system_bag, $user_bag);//合并数组
        $data['pagelink'] = $this->get_pagination('user/bag', 3, 2, $total, $pagesize);
        $data['bag_array'] = $bag_array;
        $data['header_info']=$this->member;
        $this->load->view('user/bag', $data);
    }

    /**
     * 创建背包
     *
     */
    public function bag_add()
    {
        if ($_POST) {
            $did = $this->post('did');//目的地
            $title = trim($this->post('title'));//标题
            $content = trim($this->post('content'));//内容
            $sid = intval($this->post('sid'));//运动
            $outfit = explode("-", $this->post('equip-id'));//已选系统装备 数组
            $equip = $this->post('equip');//自定义的装备   数组
            if ($did == '' || $title == '' || $sid == '') {
                message('参数有误！', 'user/bag_add');
            }
            //添加装备数据
            $main_data = array('uid' => $this->uid, 'title' => $title, 'remark' => $content, 'created' => time());
            $res = $this->sport->create_bag($main_data, $this->uid, $did, $sid, $outfit, $equip);
            if ($res) {
                message('创建成功！', 'user/bag_add');
            } else {
                message('创建失败！', 'user/bag_add');
            }
        } else {
            $this->load->vars('meta', $this->meta);
            $this->load->vars('title', $this->title('创建背包'));
            $this->load->vars('keywords', $this->keywords);
            $this->load->vars('description', $this->description);
            $this->load->vars('css', $this->css(array('bag_search.css')));
            $this->load->vars('js', $this->js(array('user_place.js', 'jquery.bigautocomplete.js')));
            //获取json所有运动
            $res = $this->sport->get_sport();
            $data['sports'] = json_encode($res);
            $data['header_info']=$this->member;
            $this->load->view('user/bag_add', $data);
        }
    }

    /**
     * 添加背包装备
     *
     */
    public function bag_equipment_add($bid='')
    {
        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('添加背包装备'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('member.css')));
        $this->load->vars('js', $this->js('layer-v1.8.5/layer/layer.min.js'));
        //按照装备标签查询数据
        $sport_category = $this->all_data('taxonomy_term', 'ttid,name', array('del' => 0, 'sta' => 0, 'typeid' => 0, 'category' => 1), 'weight', $type = 'asc');
        foreach ($sport_category as $key => $c) {
            //连表查询装备名称
            $sport_category[$key]['sports'] = $this->sport->connect_table('taxonomy_term.ttid,name,img', array('parent' => $c['ttid']), $order = 'weight', 'taxonomy_term_hierarchy', 'taxonomy_term ', 'taxonomy_term_hierarchy.ttid=taxonomy_term.ttid');

        }
        //获取已经选择的装备
       if(isset($bid)){
         $bag= $this->sport->connect_table('ttid,name,img', array('bagid' =>$bid), 'ttid', 'bag_list', 'taxonomy_term', 'term_list_id=ttid');
       }
        $bid_arr=array();
        foreach($bag as $bid){ //一维数组所有已选ID
            $bid_arr[]=$bid['ttid'];
        }
        $data['my_bag']=$bag;
        $data['bid_arr']=$bid_arr;
        $data['sport'] = $sport_category;
        $data['header_info']=$this->member;
        $this->load->view('user/bag_equipment_add', $data);
    }

    /*
     * 删除背包
     * */
    public function del_bag()
    {
        $bid = intval($this->uri->segment(3));//获取要删除的背包的ID
        if ($bid <= 0) {
            message('参数有误！', 'user/bag');
        }
        $res = $this->sport->my_update('bag', array('del' => 1), array('id' => $bid, 'uid' => $this->uid));
        if ($res) {
            message('删除成功！', 'user/bag');

        } else {
            message('删除失败！', 'user/bag');
        }
    }

    /*
     * 编辑我的背包
     * */
    public function edit_bag()
    {
        if ($_POST) {
            $did = $this->post('did');//目的地
            $title = trim($this->post('title'));//标题
            $content = trim($this->post('content'));//内容
            $sid = intval($this->post('sid'));//运动
            $outfit = explode("-", $this->post('equip-id'));//已选系统装备 数组
            $equip = $this->post('equip');//自定义的新加的数组
            $my_equip = $this->post('my_equip');//原来的自定义的装备   数组
            $bag_id = intval($this->post('bag_id'));//背包ID
            //获取原来的装备id进行比较
            foreach($my_equip as $key=>$edit){
               $edit_suit[]=$key;//编辑后的自定义原有装备
            }
            $o_equip_id= $this->post('my_suit_id');
            $o_equip_id=explode('-',$o_equip_id);//分成数组原有的一维数组
            //判断两个数组是否相同
            $same=array_diff($o_equip_id,$edit_suit);
            if(empty($my_equip) && $o_equip_id ){//原来的装备都删了清除自定义的装备 1.全部删除关系 2.对比删除的某一个删除掉 关系 3.在更新剩下的 主表
                foreach($o_equip_id as $s){
                    $this->sport->my_delete('bag_list', $where = array('bagid'=>$bag_id,'term_list_id'=>$s));//全部删除关系
                }
            }elseif(empty($same)){//没有删除原来的自定义装备  1.直接更新原来的自定义装备
                foreach($my_equip as $key=>$s){
                 $this->sport->my_update('taxonomy_term',array('name'=>$s),array('ttid'=>$key,'typeid'=>1));
                }
            }elseif(!empty($same)){ //1.删除不同的已经删除的装备 2.在更新剩下的装备
                foreach($same as $s){
                    $this->sport->my_delete('bag_list', $where = array('bagid'=>$bag_id,'term_list_id'=>$s));//全部删除关系
                }//已经删除的
                foreach($my_equip as $key=>$s){
                    $this->sport->my_update('taxonomy_term',array('name'=>$s),array('ttid'=>$key,'typeid'=>1));
                }//更新剩下的
            }
            if ($did == '' || $title == '' || $sid == '' || $bag_id == '') {
                message('参数有误！', 'user/bag_add');
            }
            //删除跟装备有关的数据在添加
            $this->sport->my_delete('bag_place', array('bagid' => $bag_id));//删除目的地
            $this->sport->my_delete('bag_sport', array('bagid' => $bag_id));//删除运动
            //$this->sport->my_delete('bag_list', array('bagid' => $bag_id));//删除装备
            $main_data = array('id' => $bag_id, 'title' => $title, 'remark' => $content,);
            $res = $this->sport->create_bag($main_data, $this->uid, $did, $sid, $outfit, $equip, 'update');
            if ($res) {
                message('编辑成功！', 'user/bag');
            } else {
                message('编辑失败！', 'user/bag');
            }

        } else {

            $bid = intval($this->uri->segment(3));//获取要删除的背包的ID
            if ($bid <= 0) {
                message('参数有误！', 'user/bag');
            }
            //查询背包信息
            $bag_array = $this->get_one_data('bag', 'id,title,remark', array('uid' => $this->uid, 'del' => 0, 'sta' => 0,'id'=>$bid));
            if ($bag_array) {
                foreach ($bag_array as $b) {
                    $bag_array['place'] = $this->sport->connect_row('placeid,name,name_en', array('bagid' => $bid, 'uid' => $this->uid), 'bag_place', 'place', 'placeid=pid');//地点信息
                    $bag_array['sport'] = $this->sport->connect_row('spid,name,name_en', array('bagid' => $bid, 'uid' => $this->uid), 'bag_sport', 'sport', 'sportid=spid');//运动信息
                    $bag_array['suit'] = $this->sport->connect_table('ttid,name,img', array('bagid' => $bid,'typeid'=>0), 'ttid', 'bag_list', 'taxonomy_term', 'term_list_id=ttid'); //装备数组
                    //自定义装备
                    $bag_array['my_suit'] = $this->sport->connect_table('ttid,name,img', array('bagid' => $bid,'typeid'=>1), 'ttid', 'bag_list', 'taxonomy_term', 'term_list_id=ttid'); //自定义的
                }
                $this->load->vars('meta', $this->meta);
                $this->load->vars('title', $this->title('创建背包'));
                $this->load->vars('keywords', $this->keywords);
                $this->load->vars('description', $this->description);
                $this->load->vars('css', $this->css(array('member.css', 'bag_search.css')));
                $this->load->vars('js', $this->js(array('layer-v1.8.5/layer/layer.min.js', 'bag.js', 'jquery.bigautocomplete.js')));
                //获取json所有运动
                $res = $this->sport->get_sport();
                $data['sports'] = json_encode($res);
                //我的自定义的装备ID
       if(count($bag_array['my_suit']>1)){
           foreach($bag_array['my_suit'] as $k=>$s){
               if($k==0){
                   $id=$s['ttid'];
               }else{
                   $id.='-'.$s['ttid'];
               }
           }
       }else{
               $id=$bag_array['my_suit'][0]['ttid'];
       }
                $data['my_suit_id']= $id;
                $data['bag_array'] = $bag_array;
                $data['bag_id'] = $bid;
                $data['header_info']=$this->member;
                $this->load->view('user/bag_edit', $data);

            } else {
                message('参数有误！', 'user/bag');
            }

        }
    }

    /*
     * 添加评论
     * */
    public function add_comment()
    {
        if ($this->input->is_ajax_request()) {
            $pid = intval($this->post('id'));//获取被评论ID
            $body = trim($this->post('comment'));//评论内容
            //添加数据
            if ($pid == 0 || $body == '') {
                message('错误参数', 'user');
            }
            //获取父级评论的id
            $objectid = $this->get_one_data('comments', 'objectid', array('id' => $pid));
            $data = array('parentid' => $pid, 'uid' => $this->uid, 'objectid' => $objectid['objectid'], 'body' => $body, 'ip' => $this->input->ip_address(), 'created' => time());
            $res = $this->my_add('comments', $data);
            if ($res) {
                echo 1;
            } else {
                echo 2;
            }

        }


    }

    /*
     * 查看收藏背包详情
     * */
    public function get_bag_detail()
    {
        $type = $this->uri->segment(3);
        $bag_id = intval($this->uri->segment(4));
        $type_arr = array(1, 2);
        if (!in_array($type, $type_arr) || $bag_id == 0) {
            echo "参数发生错误！";
            exit;
        }
        if ($type == 1) {//系统装备  连表查询

            $suit_list = $this->sport->connect_table('name,img', array('del' => 0, 'sta' => 0, 'category' => 0, 'tid' => 2, 'parent' => $bag_id), 'weight', 'taxonomy_term_hierarchy', 'taxonomy_term', 'taxonomy_term_hierarchy.ttid=taxonomy_term.ttid');

        } elseif ($type == 2) {//收藏用户装备 连表查询

            $suit_list = $this->sport->connect_table('name,img,del', array('del' => 0, 'sta' => 0, 'category' => 0, 'tid' => 2, 'bagid' => $bag_id), 'weight', 'bag_list', 'taxonomy_term', 'bag_list.term_list_id=taxonomy_term.ttid');

        }

        //var_dump($suit_list);
        $data['suit_list'] = $suit_list;
        $this->load->view('user/favorite_bag', $data);
    }
    /*
     * 编辑用户资料
     * */
    public function edit_pro(){
        if($_POST){
           $name= trim($this->post('name'));
           $old_name=$this->post('old_name');
           if($name!=$old_name){//两个名字不同的时候检测用户名
               $check_res=$this->uc->check_user_exit($name);//检查用户名
               switch ($check_res){
                   case -1:
                       message('用户名非法！', 'user/edit_pro');
                       break;
                   case -2 :
                       message('用户名保留的！', 'user/edit_pro');
                       break;
                   case -3:
                       message('用户名存在！', 'user/edit_pro');
                       break;
               }
               $main_data=array('username'=>$name);
           }else{
               $main_data=array();

           }

           $sex=$this->post('sex');
           $year= $this->post('year');
           $month=$this->post('month');
           $day=$this->post('day');
           $address=trim($this->post('address'));
           $constellation= $this->post('constellation');
           //更新用户数据
           $up_res= $this->sport->update_user_info($this->uid,$main_data,array('gender'=>$sex,'birthyear'=>$year,'birthmonth'=>$month,'birthday'=>$day,'address'=>$address,'constellation'=>$constellation));
                  if($up_res){
                      message('更新成功！', 'user/person_info');
                  }else{

                      message('更新失败！', 'user/edit_pro');
                  }
        }else{
                $this->load->vars('title', $this->title('修改资料'));
                $this->load->vars('keywords', $this->keywords);
                $this->load->vars('description', $this->description);
                $this->load->vars('css', $this->css(array('base.css', 'user.css')));
                //个人资料本地数据 连表查询
                $data['constellation']=$this->constellation;
                $data['user'] = $this->sport->get_user_info($this->uid);
                $data['header_info']=$this->member;
                $this->load->view('user/edit_pro', $data);


       }
    }
 /*第四次修改*/
    /*
     * ajax添加足迹获取第三级的数据
     * */
public function get_child_city(){
    if($this->input->is_ajax_request()){
       $city_id=$this->post('city');//获取城市id
        $flag=$this->post('flag');//想去、去过
        $city = $this->all_data('place', 'name,name_en,pid,parent', array('del' => 0, 'sta' => 0, 'parent' => $city_id), 'pid', 'asc');

        foreach($city as $key=>$c){ //再次循环遍历数据判断是否去过等

            $city[$key]['gone']=$this->sport->exit_city($this->uid,$c['pid'],$flag);
        }
        if($city){
            echo json_encode($city);
        }else{
            echo json_encode(array());
        }

    }


  }

  /*删除足迹*/

public function del_spoor(){
  if($this->input->is_ajax_request()){
    $spoor_id=intval($this->post('spoor'));
      if($spoor_id==0){
          echo 0;exit;
      }
     //更新数据
     $res=$this->sport->my_update('place_visit',array('beento'=>0),array('placeid'=>$spoor_id,'city >'=>0,'uid'=>$this->uid));
    if($res){
    echo 1;
    }else{
        echo 0;
    }
  }


}


}