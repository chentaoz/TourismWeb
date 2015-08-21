<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'core/MY_UserController.php';
class Profile extends MY_UserController {
    protected $constellation=array('1'=>'白羊座','2'=>'金牛座','3'=>'双子座','4'=>'巨蟹座','5'=>'狮子座','6'=>'处女座','7'=>'天秤座','8'=>'天蝎座','9'=>'射手座','10'=>'摩羯座','11'=>'水瓶座','12'=>'双鱼座');
    public function __construct(){
        parent::__construct();
        $this->load->model('sport_model','sport');
        $this->load->model('uc_model','uc');
        $s_uid=intval($this->uri->segment(2));//访问用户的ID
        $this->member = $this->get_member($s_uid);
    }
  /*
   * 他人主页的个人详情
   * */
    public function index()
    {
        $user=$this->member;
        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('TA的详情资料'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css', $this->css(array('base.css', 'user.css','member.css')));
        //个人资料本地数据 连表查询
        $data['constellation']=$this->constellation;
        $data['user_info'] = $this->sport->get_user_info($user['uid']);
        $data['header_info']=$user;
        $data['space']='space';//标志是空间的
        $this->load->view('user/person_info', $data);
    }
}