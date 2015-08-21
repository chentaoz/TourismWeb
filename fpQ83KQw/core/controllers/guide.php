<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Guide extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('common_model', 'common');
		$this->load->model('sport_model', 'sport');
		$this->load->model('guide_model', 'guide');
	}

	/**攻略主页*/
	public function index()
	{
		$this->load->vars('meta', $this->meta);
		$this->load->vars('title', $this->title('攻略'));
		$this->load->vars('keywords', $this->keywords);
		$this->load->vars('description', $this->description);
//        $this->load->vars('css', $this->css(array('guide.css'),true));
		$this->load->vars('js', $this->js(array('guide.js')));

		//获取广告banner 首页广告id 247
		$data['banner'] = $this->sport->connect_table('ads.img,ads.weblink,ads_sclass.width,ads_sclass.height', $where = array('is_del' => 2, 'flag' => 1, 'ads_sclass.id' => 247), 'sort_number', 'ads', 'ads_sclass', 'ads_sclass.id=ads.classid');

		//热门攻略
		$data['guide_hot'] = $this->guide->get_guides($where = array('del' => 0, 'sta' => 0), $sort = array('downs', 'desc'), 0, 3);
		//编辑推荐
		$data['guide_recommend'] = $this->guide->get_guides($where = array('del' => 0, 'sta' => 0, 'recommend' => 1), '', 0, 6);
		//刚刚下载的攻略
		$data['guide_user'] = $this->guide->get_user_guides();
		//全部攻略
		$total_data = $this->total_data('guide', $where = array('del' => 0, 'sta' => 0));
		$pagesize = 16;
		$page = $this->get_uri_segment(4);
		$offset = ($page - 1) * $pagesize;
		$data['pagelink'] = $this->get_pagination('place/guide/', 4, 2, $total_data, $pagesize);
		$data['guides'] = $this->guide->get_guides($where = array('del' => 0, 'sta' => 0), '', $offset, $pagesize);

		$this->load->view('guide/index', $data);
	}

	/**目的地搜索下拉框**/
	public function auto_search()
	{
		$key = $_GET['key'];
		if (!$key) return;
		$s = $this->guide->get_guidebykey($key);
		if (!$s) {
			$s = array();
		}
		echo json_encode($s);
	}

	//攻略下载
	public function down()
	{
		$params = $this->uri->uri_to_assoc(3);
		$gid = $params['gid'];
		$gid = $gid ? $gid : message('参数错误', 'guide');
		switch ($params['url']){
			case 1:
				$url='guide';
				break;
			case 2:
				$url='guide/detail/gid/'.$gid;
				break;
			default:
				$url='guide';
				break;
		}
		$this->load->helper('download');
        $this->load->helper('string');
        if ($this->uid || $this->uid>0) { //判断是否登录
			$s = $this->get_one_data('guide', 'title,filepath,downs', array('gid' => $gid)); //获取该攻略的文件路径
			$filepath = $_SERVER["DOCUMENT_ROOT"]."/".$this->config->item('upload_guide_pdf') . '/' . $s['filepath'];
			if ( $s && $filepath ) {
				$q = $this->upd_one_data('guide', $data = array('downs' => $s['downs'] + 1), $data = array('gid' => $gid)); //有该攻略则下载次数+1

                if ($q) {
					$r = $this->get_one_data('guide_download', 'uid', array('uid' => $this->uid,'gid' => $gid)); //判断是否有该用户下载该攻略的记录
					if ($r) {
						$this->upd_one_data('guide_download', array('created' => time()), array('gid' => $gid, 'uid' => $this->uid)); //有记录则更新下载时间
					} else {
						$this->my_add('guide_download', array('gid' => $gid, 'uid' => $this->uid, 'created' => time())); //没有则添加一条记录
					}
                    Header( "Content-type:   application/octet-stream ");
                    Header( "Accept-Ranges:   bytes ");
                    header("Content-Description: PHP3 Generated Data");
                    header("Content-Disposition:attachment;filename=".iconv("UTF-8","GB2312//TRANSLIT",$s['title'].'.pdf'));
                    readfile($filepath);
				} else {
					message('该攻略不存在或已删除，下载失败',$url);
				}
			} else {
				message('该攻略不存在或已删除，下载失败',$url);
			}
		} else {
			redirect(PASSPORT_domian. 'oauth/login');
		}
	}

	//攻略详情页
	public function detail()
	{
		$params = $this->uri->uri_to_assoc(3);
		$gid = $params['gid'];
		$gid = $gid ? $gid : message('参数错误', 'guide');
		$data['guide'] = $this->get_one_data('guide', '*', array('gid' => $gid));
        if(!$data['guide'] ){message('参数错误', 'guide');}
		if ($data['guide']['place_id'] > 0) {
			$s = $this->get_one_data('place', 'pid,name,name_en', array('pid' => $data['guide']['place_id']));
            $data['guide']['pid'] = $s['pid'];
			$data['guide']['name'] = $s['name'];
			$data['guide']['name_en'] = $s['name_en'];
		}
		if ($data['guide']['sport_id'] > 0) {
			$s = $this->get_one_data('sport', 'name,name_en', array('spid' => $data['guide']['sport_id']));
			$data['guide']['name'] = $s['name'];
			$data['guide']['name_en'] = $s['name_en'];
		}
		$data['guide']['size'] = setupSize($data['guide']['filesize']);

		$this->load->vars('meta', $this->meta);
		$this->load->vars('title', $this->title($data['guide']['title']));
		$this->load->vars('keywords', $this->keywords);
		$this->load->vars('description', $this->description);
//		$this->load->vars('css', $this->css(array('guide.css', 'place.css'),true));
		$this->load->vars('js', $this->js(array()));

		//评论
		$total_data = $this->total_data('guide_comments', $where = array('del' => 0, 'sta' => 0, 'gid' => $gid));
		$pagesize = 6;
		$page = $this->get_uri_segment(5);
		$offset = ($page - 1) * $pagesize;
		$data['pagelink'] = $this->get_pagination('guide/detail/gid/'.$gid, 5, 2, $total_data, $pagesize);
		$data['comments'] = $this->guide->get_comments($where = array('del' => 0, 'sta' => 0, 'gid' => $gid), '', $offset, $pagesize);
		foreach ($data['comments'] as $k => $v) {
			$user = $this->get_one_data('members', 'username,avatar', array('uid' => $data['comments'][$k]['uid']));
			$data['comments'][$k]['username'] = $user['username'];
			$data['comments'][$k]['avatar'] = $user['avatar'];
		}
		//发表评论
		$data['form'] = form_open('guide/comment_save', array('id' => 'form1'));

		$this->load->view('guide/detail', $data);
	}

	//评论提交
	public function comment_save()
	{
		echo '<meta http-equiv="content-type" content="text/html;charset=utf-8"/>';
		$gid = $this->post('gid');
		$gid = $gid ? $gid : message('参数错误', 'guide');
		$comments = $this->post('comment');
		$comments = $comments ? $comments : message('参数错误', 'guide');
		$data = array('gid' => $gid, 'description' => $comments, 'ip' => $this->input->ip_address(), 'uid' => $this->uid, 'created' => time());
		if($this->uid || $this->uid>0){
			$s = $this->my_add('guide_comments', $data);
			if ($s) {
				message('提交成功!', 'guide/detail/gid/'.$gid);
			} else {
				message('提交失败!', 'guide/detail/gid/'.$gid);
			}
		}else{
			message('请先登录!', PASSPORT_domian. 'oauth/login');
		}

	}
}