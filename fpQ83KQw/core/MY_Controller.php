<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    /**
     * 错误信息
     * @var
     */
    protected $error;
    protected $meta;
    protected $title;
    protected $keywords;
    protected $description;
    protected $css;
    protected $js;
    /**
     * 网站配置信息 $configs
     * @var
     */
    protected $site_configs = array('title' => '野孩子');//默认标题

    /**
     * 用户ID $uid
     * @var
     */
    protected $uid=0;
    protected $user;
    protected $s_user;
    protected $s_uid;
    /**
     * 当前是否属于自己的
     * @var bool
     */
    protected $isself=true;

    public $root = '';// 网站根路径，以/结尾(请注意)
    public $uploadpath = '';//保存上传的文件的文件夹名称
    public $jquery = 'jquery-1.9.1.min.js';//默认加载的js文件
    public $commonjs = 'common.js';//默认加载的js文件

    public function __construct()
    {
        parent::__construct();
        $this->load->model('uc_model', 'uc');
        $this->lang->load('default');
        $this->load->helper('url');
        $this->root = base_url();
        $this->uploadpath = $this->config->item('upload') . '/';

        $this->config();
        $this->meta = $this->meta();
        $this->title = $this->title();
        $this->keywords = $this->keywords();
        $this->description = $this->description();
        $this->css = $this->css();
        $this->js = $this->js();

        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title);
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css);
        $this->load->vars('js', $this->js);

        $this->get_user();
    }

    function get_user()
    {
        $cookie_user=ci_get_cookie('user');
        if($cookie_user){
            $this->user = json_decode($cookie_user,true);
            set_session('user',$this->user);
        }else {
            $this->user = get_session('user');
        }
        if ($this->user) {
            $this->uid = $this->user['uid'];
            $this->load->vars('user', $this->user);
        }
    }

    function get_uid($uid){
        if($uid==null||$uid==0){$uid=$this->uid;}
        if($uid==null||$uid==0){redirect(PASSPORT_domian.'oauth/login');}
        return $uid;
    }

    /**
     * 设置 是否属于自己的
     * @param $uid
     */
    function set_self($uid){
        if($uid==null||$uid==0){$uid==$this->uid;}
        $this->isself=($uid==$this->uid);
        $this->set_vars('isself', $this->isself);
        $this->set_vars('uid', $this->uid);
    }

    /**
     * 设置view变量
     * @param $key
     * @param $value
     */
    function set_vars($key,$value){
        $this->load->vars($key,$value);
    }

    function get_ip(){
        return $this->input->ip_address();
    }
    /**
     * 检索网站全局配置
     */
    private function config()
    {
        $r = $this->db->get('config')->result_array();
        foreach ($r as $v) {
            $config[$v['var']] = $v['datavalue'];
        }
        $this->site_configs = $config;
    }

    /**
     * meta标签
     * @return string
     */
    protected function meta()
    {
        $meta = '
		<meta charset="' . $this->config->item('charset') . '">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		';
        return $meta;
    }

    /**
     * 页面标题 title
     * @param $title 页面标题
     * @param string $spc 分隔符，默认: |
     * @return string
     */
    protected function title($title = '', $spc = ' | ')
    {
        if ($title == null || $title == '') {
            return '<title>' . $this->site_configs['title'] . '</title>';
        }
        return '<title>' . $title . $spc . $this->site_configs['title'] . '</title>';
    }

    /**
     * meta keywords
     * @param $keywords
     * @return string
     */
    protected function keywords($keywords = '')
    {
        if ($keywords == null || $keywords == '') {
            return '<meta name="keywords" content="' . $this->site_configs['keyword'] . '" />';
        }
        return '<meta name="keywords" content="' . $keywords . '" />';
    }

    /**
     * meta description
     * @param $description
     * @return string
     */
    protected function description($description = '')
    {
        if ($description == null || $description == '') {
            return '<meta name="description" content="' . $this->site_configs['description'] . '" />';
        }
        return '<meta name="description" content="' . $description . '" />';
    }

    /**
     * @param string|array $cssfile
     * @return string
     */
    protected function css($cssfile = '',$custom=false)
    {
        $csstr = '';
        $default = array('base.css');//默认加载的样式文件
        if($custom){
            $default=array();
        }
        if (is_array($cssfile)) {
            $default = array_merge($default, $cssfile);
        } else {
            if ($cssfile) {
                $default[] = $cssfile;
            }
        }
        foreach ($default as $k => $v) {
            $csstr .= '<link rel="stylesheet" href="' . $this->root . 'css/' . $v . '" type="text/css" />';
        }
        return $csstr;
    }

    /**
     * @param string|array $script
     * @return string
     */
    protected function js($script = '')
    {
        if ($script == null || $script == '' || count($script) == 0) {
            $script = '<script type="text/javascript" src="' . $this->root . 'js/' . $this->jquery . '"></script>';
            $script .= '<script type="text/javascript" src="' . $this->root . 'js/jquery-migrate.min.js"></script>';
            $script .= '<script type="text/javascript" src="' . $this->root . 'js/' . $this->commonjs . '"></script>';
            return $script;
        }
        $js = '
		<script type="text/javascript" src="' . $this->root . 'js/' . $this->jquery . '"></script>
		<script type="text/javascript" src="' . $this->root . 'js/jquery-migrate.min.js"></script>
        <script type="text/javascript" src="' . $this->root . 'js/' . $this->commonjs . '"></script>';
        if (is_array($script)){
            if ($script) {
                foreach ($script as $k => $v) {
                    $js .= '<script type="text/javascript" src="' . $this->root . 'js/' . $v . '"></script>';
                }
            }
        }else{
            $js .= '<script type="text/javascript" src="' . $this->root . 'js/' . $script . '"></script>';
        }

        return $js;
    }

    function get($key)
    {
        return $this->input->get($key, true);
    }

    function post($key)
    {
        return $this->input->post($key, true);
    }

    /**
     * 获取URL中URI分段
     * http://example.com/index.php/news/local/metro/crime_is_up
     * get_uri_segment(2) => local
     * @param $segment
     * @return int
     */
    function get_uri_segment($segment)
    {
        if ($this->uri->segment($segment)) {
            return (int)$this->uri->segment($segment);
        } else {
            return 1;
        }
    }

    /**
     * 获取Uri字符串转化的数组
     * @param $segment
     * @return int
     */
    function get_uri_to_assoc($segment)
    {
        $default = array('page');
        $arr_uri=$this->uri->uri_to_assoc($segment,$default);
        if(!$arr_uri['page']){
            $arr_uri['page']=1;
        }
        return $arr_uri;
    }

    /**
     * 获取分页链接
     * @param $base_url 相对url 如：article/list
     * @param $uri_segment  URI 的哪个段包含页数 如：article/list/page/3 的uri_segment=3
     * @param $num_links 放在你当前页码的前面和后面的“数字”链接的数量。比方说值为 2 就会在每一边放置 2 个数字链接，就像此页顶端的示例链接那样
     * @param $records 总记录数
     * @param $pagesize 每页显示多少条
     * @return mixed
     */
    function get_pagination($base_url, $uri_segment, $num_links, $records, $pagesize)
    {
        $n=array_search('page',$this->uri->segment_array());
        if($n){$currpage=$n+1;}else{$currpage=$uri_segment;}
        $this->load->library('pagination');
//        $config['page_query_string']=true;
//        $config['query_string_segment'] ='page';
        $config['base_url'] = site_url($base_url);
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $num_links;
        $config['total_rows'] = $records;
        $config['per_page'] = $pagesize;
        $config['uri_segment'] = $currpage;
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] = '<span aria-hidden="true">首页</span>';
        $config['last_link'] = '<span aria-hidden="true">尾页</span>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['next_link'] = '<span aria-hidden="true">下一页</span>';
        $config['prev_link'] = '<span aria-hidden="true">上一页</span>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    //定义url
    public function default_url()
    {
        $base_url = explode('/', base_url());
        array_pop($base_url);
        array_pop($base_url);
        $base_url = implode('/', $base_url);
        return $base_url;
    }

    //查询一个表的所有数据
    public function all_data($table, $file, $where,$order,$type='asc')
    {
        return $this->db->select("$file")->where($where)->order_by($order, $type)->get($table)->result_array();
    }

    //统计一个表符合条件的数据num
    public function  total_data($table, $where)
    {
        return $this->db->where($where,'false')->get($table)->num_rows();
    }

    //统一成功和失败提示信息操作
    public function my_messages($res, $s_mess = "操作成功", $f_message = "操作失败", $s_url, $f_url)
    {
        if ($s_mess == '') {
            $s_mess = "操作成功";
        }
        $f_message = $f_message == '' ? '操作失败' : $f_message;
        if ($res) {
            message($s_mess, $s_url);
        } else {
            message($f_message, $f_url);
        }
    }

    // 统一添加数据
    public function my_add($table, $data)
    {
        $res = $this->db->insert($table, $data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //获取一条数据
    public function get_one_data($table,$filed,$where=array()){
        $this->db->select($filed);
        $this->db->where($where);
        $q =$this->db->get($table);
        return $q->row_array();
    }

    // 更新一条数据
    public function upd_one_data($table, $data,$where=array())
    {
        $this->db->where($where);
        $res = $this->db->update($table, $data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //访问空间数据的验证用户是否存在
    public function check_space_user(){
        $s_uid=intval($this->uri->segment(2));//访问用户的ID
        $members=$this->get_one_data('members','uid,username',$where=array('uid'=>$s_uid,'status'=>0,'emailstatus'=>1));
        if(!$members){
            message('此用户不存在,或无效用户','home');
        }else{
            return $members;
        }
    }
}