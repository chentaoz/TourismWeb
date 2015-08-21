<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends MY_Controller {
    private $place_cate;
    public function __construct(){
        parent::__construct();
        $this->load->model('common_model','common');
        $this->load->model('place_model','place');
    }
    /**用户中心主页*/
    public function index(){
        $this->load->vars('meta', $this->meta);
        $this->load->vars('title', $this->title('目的地'));
        $this->load->vars('keywords', $this->keywords);
        $this->load->vars('description', $this->description);
        $this->load->vars('css',$this->css(array('index.css','other.css','jyytemp.css')));
        $this->load->vars('js', $this->js('place.js'));

        $this->load->view('place/index');
    }
}