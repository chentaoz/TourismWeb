<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('system_model', 'system');
        $this->load->model('common_model', 'common');
        $this->lang->load('system');
        $this->lang->load('default');
        $this->system->isLogin();
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
     * 获取分页链接
     * @param $base_url 相对url 如：
     * @param $uri_segment  URI 的哪个段包含页数
     * @param $num_links 放在你当前页码的前面和后面的“数字”链接的数量。比方说值为 2 就会在每一边放置 2 个数字链接，就像此页顶端的示例链接那样
     * @param $records 总记录数
     * @param $pagesize 每页显示多少条
     * @return mixed
     */
    function get_pagination($base_url, $uri_segment, $num_links, $records, $pagesize)
    {
        $this->load->library('pagination');
//        $config['page_query_string']=true;
//        $config['query_string_segment'] ='page';
        $config['base_url'] = site_url($base_url);
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $num_links;
        $config['total_rows'] = $records;
        $config['per_page'] = $pagesize;
        $config['uri_segment'] = $uri_segment;
        $config['first_link'] = '首页';
        $config['last_link'] = '尾页';
        $config['next_link'] = '下一页';
        $config['prev_link'] = '上一页';
        $config['cur_tag_open'] = '<span class="current">';
        $config['cur_tag_close'] = '</span>';
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
    //定义url
    public function default_url(){
        $base_url=explode('/',base_url());
        array_pop($base_url);
        array_pop($base_url);
        $base_url= implode('/',$base_url);
        return $base_url;
    }

    //查询一个表的所有数据
    public function all_data($table,$file,$where){

        return $this->db->select("$file")->where($where)->get($table)->result_array();

    }
    //统一成功和失败提示信息操作
 public   function my_messages($res,$s_mess="操作成功",$f_message="操作失败",$s_url,$f_url){
        if($s_mess==''){$s_mess="操作成功";}
        $f_message=$f_message==''?'操作失败':$f_message;
        if($res){
            message($s_mess,$s_url);
        }else{
            message($f_message,$f_url);
        }
    }
   // 统一添加数据
 public  function my_add($table,$data){
     $res= $this->db->insert($table, $data);
     if($res){
         return true;
     }else{
         return false;
     }
  }

}