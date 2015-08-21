<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {
	public $root='';// 网站根路径，以/结尾(请注意)
	public $admin_dir='';//网站后台管理的文件夹的名称，以/结尾(请注意)
	public $uploadpath='';//保存上传的文件的文件夹名称
	public $configs=array('title'=>'Xcenter');//后台默认标题
	public $js='jquery/jquery-1.7.2.min.js';//后台默认加载的js文件
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->root=base_url();
		$this->uploadpath=$this->config->item('upload').'/';
	}
	/**
	 * 检索网站全局配置
	 *
	 * @return unknown
	 */
	public function config(){
		$this->load->database();
		$r=$this->db->get('config');
		if ($r->num_rows()<=0) {
			return false;
		}
		foreach ($r->result_array() as $v) {
			$config[$v['var']]=$v['datavalue'];
		}
		return $config;
	}
	/**
	 * 组装好模板中的所有meta标签
	 * 其中第三个meta标签是用来兼容ie8，让其以ie7的模式运行
	 *
	 * @param unknown_type $config：网站全局配置，类型为数组
	 * @return unknown
	 */
	public function meta($config=array()){
		if (!is_array($config)) {
			return false;
		}
		$meta='
		<meta charset="'.$this->config->item('charset').'">
		<title>'.$config['title'].'</title>
		<meta name="keywords" content="'.$config['keyword'].'" />
		<meta name="description" content="'.$config['description'].'" />
		<meta name="X-UA-Compatible" content="IE=EmulateIE7" />
		';
		return $meta;
	}
	/**
	 * 用来配置模板文件的css样式，如无参数，则默认加载base.css文件，
	 * 如有参数，参数类型为字符串，则加载该参数的样式文件，
	 * 如参数类型为数组，则加载该数组当中的所有样式文件，
	 * 所有加载动作都会默认同时加载base.css文件
	 *
	 * @param unknown_type $cssfile：样式文件名，可为单个样式文件或样式文件数组
	 */
	public function css($cssfile=''){
		$csstr='';
		$default=array('base.css');//默认加载的样式文件
		if (is_array($cssfile)) {
			$default=array_merge($default,$cssfile);
		}
		else {
			if ($cssfile) {
				$default[]=$cssfile;
			}
		}
		foreach ($default as $k=>$v){
			if (substr($v,0,7)=='{other}') {//如果样式文件不在css文件夹下，则采用参数中的绝对路径，该种情况主要是用于解决某些插件同时带有js跟css文件的情况，标志则是在路径前面加上{other}
				$v=substr($v,7);
				$mktime=md5(filemtime(FCPATH.$v));
				$csstr.='<link rel="stylesheet" href="'.$this->root.$v.'?v='.$mktime.'" type="text/css" />';
			}
			else {
				$mktime=md5(filemtime(FCPATH.'css/'.$v));
				$csstr.='<link rel="stylesheet" href="'.$this->root.'css/'.$v.'?v='.$mktime.'" type="text/css" />';
			}
		}
		return $csstr;
	}
	/**
	 * 用来配置模板文件中的脚本文件，
	 * 如参数类型为字符串，则加载该脚本文件，
	 * 如参数类型为数组，则加载该数组中的所有脚本文件，
	 *
	 * @param unknown_type $script：需加载的脚本文件或脚本文件数组
	 */
	public function script($script=''){
		if (!$script) {
			return false;
		}
		if (!is_array($script)) {
			$script='<script type="text/javascript" src="'.$this->root.'js/'.$script.'"></script>';
			return $script;
		}
		$js='';
		foreach ($script as $k=>$v){
			$js.='<script type="text/javascript" src="'.$this->root.'js/'.$v.'"></script>';
		}
		return $js;
	}
	/**
	 * 配置页面中的meta标签，以及要加载的样式文件与脚本文件
	 *
	 * @param unknown_type $config
	 * @param unknown_type $css
	 * @param unknown_type $script
	 */
	public function setConfig($config=array(),$css='',$script=''){
		$configs=$this->config();
		if ($config){
			foreach ($config as $k=>$v) {
				$configs[$k]=$v;
			}
		}
		return array('meta'=>$this->meta($configs),'css'=>$this->css($css),'js'=>$this->script($script));
	}
	/**
	 * 对型如2009-03-02的时间进行处理，返回其对应的秒数
	 *
	 * @param unknown_type $split：中间的分隔符
	 * @param unknown_type $time：时间
	 * @param unknown_type $flag：起始时间还是结束时间,默认为起始时间
	 * @return unknown
	 */
	function makeTime($split,$time,$flag=1){
		$time=explode($split,$time);
		if ($flag==1) {
			$time=mktime(0,0,0,$time[1],$time[2],$time[0]);
		}
		else {
			$time=mktime(23,59,59,$time[1],$time[2],$time[0]);
		}
		return $time;
	}
	/**
	 * 统一封装分页类中的各种配置参数
	 *
	 * @param unknown_type $url：基础url
	 * @param unknown_type $num：记录总数
	 * @param unknown_type $per_page：每页显示的数目
	 * @param unknown_type $uri_segment：获取页数的url分段号
	 * @return unknown
	 */
	public function pageConfig($url,$num,$per_page,$uri_segment){
		$config['base_url']=$url;
		$config['total_rows']=$num;
		$config['per_page']=$per_page;
		$config['first_link']='首页';
		$config['last_link']='尾页';
		$config['next_link']='下一页';
		$config['prev_link']='上一页';
		$config['cur_tag_open']='<a class="ui-page-current">';
		$config['cur_tag_close'] = '</a>';
		$config['uri_segment']=$uri_segment;
		return $config;
	}
	/**
	 * 统一封装图片上传功能
	 *
	 * @param unknown_type $width
	 * @param unknown_type $height
	 * @param unknown_type $maxsize
	 * @return unknown：成功则返回上传后的图片名称，失败返回false
	 */
	public function imgUpload($width='',$height='',$maxsize='',$file='userfile'){
		$config=array('upload_path'=>ROOTPATH.$this->config->item('upload'),'allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>true,'max_size'=>$this->config->item('upload_size'));
		if ($width) {
			$config['max_width']=$width;
		}
		if ($height) {
			$config['max_height']=$height;
		}
		if ($maxsize) {
			$config['max_size']=$maxsize;
		}
		$this->load->library('upload',$config);
		if ($this->upload->do_upload($file)) {
			$imgdata=$this->upload->data();
			return $imgdata['file_name'];
		}
		else {
			return false;
		}
	}
	/**
	 * 按照指定的smtp参数进行邮件发送前的准备，返回一个smtp的邮件发送对象，用来为以后发送邮件
	 *
	 * @param unknown_type $config
	 * @return unknown
	 */
	public function email($config=array('host'=>'','port'=>25,'user'=>'','psw'=>'','email'=>'','fromname'=>'','charset'=>'utf-8')){
		if (!is_array($config)) {
			return false;
		}
		extract($config);
		$configs=$this->config();
		$host=$host?$host:$configs['smtp_host'];
		$port=$port?$port:$configs['smtp_port'];
		$user=$user?$user:$configs['smtp_user'];
		$psw=$psw?$psw:$configs['smtp_psw'];
		$email=$email?$email:$configs['smtp_mail'];
		$fromname=$fromname?$fromname:$configs['smtp_user'];
		error_reporting(E_STRICT);
		date_default_timezone_set(date_default_timezone_get());
		require(APPPATH.'third_party/phpMailer/class.phpmailer.php');
		$mail             = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host= $host; // SMTP server
		$mail->Port=$port;
		$mail->SMTPAuth = true; // 启用SMTP验证功能
		$mail->Username = $user; // 邮局用户名(请填写完整的email地址)
		$mail->Password = $psw; // 邮局密码

		$mail->From       = $email;
		$mail->FromName   = $fromname;

		$mail->CharSet = $charset;            // 这里指定字符集！
		$mail->Encoding = "base64";
		return $mail;
	}
	/**
	 * 按照指定好的参数进行邮件的发送
	 *
	 * @param unknown_type $config
	 * @param unknown_type $mail
	 * @return unknown
	 */
	public function sendMail($config=array('email'=>'','user'=>'','title'=>'','content'=>'','altbody'=>''),$mail){
		if (!is_object($mail)) {
			return false;
		}
		if (!is_array($config)) {
			return false;
		}
		extract($config);
		if (!$email||!$user||!$title||!$content) {
			return false;
		}
		$mail->Subject=$title;
		$mail->MsgHTML(eregi_replace("[\]",'',$content));
		$mail->AddAddress($email,$user);
		if (!$mail->Send()) {
			return false;
		}
		else {
			return true;
		}
	}
    /**
     * 按$tid获取分类数据
     *
     * @param unknown_type $tid:1.级别2.清单3.人员4.运动标签
     * @return unknown
     */
    public function get_taxonomy_term($tid){
        $this->db->where(array('tid'=>$tid,'del'=>0,'sta'=>0));
        $this->db->from('taxonomy_term');
        $this->db->order_by('weight','asc');
        $r=$this->db->get();
        if ($r->num_rows()==0) {
            return false;
        }
        return $r->result_array();
    }
}