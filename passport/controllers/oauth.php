<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oauth extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('uc_model','uc');
    }

    public function index(){
        redirect(WWW_domian.'user');
        exit();
    }

    public function login(){
        $reurl=$this->get('reurl');
        if ($this->user) {
            redirect(WWW_domian.'user');
            exit();
        }

        $this->load->vars('title', $this->title('登录'));
        $this->load->vars('keywords', $this->keywords('登录'));
        $this->load->vars('description', $this->description('登录'));

        if($this->post('username')){
            $username=$this->post('username');
            $password=strtolower($this->post('userpwd'));

            list($uid, $ucname, $pwd, $ucemail) = $this->uc->user_login($username, $password);
            $uid = intval($uid);
            //判断用户是否冻结
            $freeze=$this->uc->is_freeze($uid);
            if($freeze){
                message('对不起此用户已经冻结！','oauth/login',true,'',3);
            }
            if($uid>0){
                //登录成功
                $ip = $this->input->ip_address();
                $this->uc->user_update($uid,array('lastip'=>$ip,'lastdate'=>time()));
                $uc_str=$this->uc->user_synlogin($uid); //同步登录代码，各站点的api/uc.php => synlogin
                
                $content='登录成功';
                $this->user=array(
                    'uid' => $uid,
                    'username' => $ucname,
                    'email' => $ucemail
                );
                set_session('user',$this->user);
                ci_set_cookie('user',$this->user,60*60*24*30);
                $this->load->vars('user', $this->user);

                if($reurl){
                    $this->load->helper("url");
                    // redirect($reurl);

                    // exit(0);
                    message($content, urldecode($reurl), true, $uc_str, 3);

                }else {
                    //  $this->load->helper("url");
                    //  redirect(WWW_domian . 'user');
                    //$this->load->view("test");
                    if(!isset($_COOKIE["prepage"]))
                        message($content, WWW_domian . 'user', true, $uc_str, 3);
                    else{
                        $page=$_COOKIE["prepage"];
                        setcookie("prepage", "", time() - 3600);
                        $this->load->helper("url");
                        redirect($page);
                    }
                }
            }else{
                if($uid==-1){
                    $error='用户名不存在';
                }else if($uid==-2){
                    $error='密码不正确';
                }else if($uid==-3){
                    $error='邮箱未激活';
                } else{
                    $error='未知错误';
                }
                $this->load->vars('error',$error);
            }
        }
        //        $this->load->library('encrypt');
        //        $code=$this->encrypt->encode(11);
        //
        //        $this->load->vars('title', $this->title('注册成功'));
        //        $data['code']=$code;
        //        $data['email']='12321321';
        //        $this->load->view('oauth/register_success',$data);
        $this->load->view('oauth/login');
    }

    public function logout(){
        $this->load->vars('title', $this->title('注销'));
        $this->load->vars('keywords', $this->keywords('注销'));
        $this->load->vars('description', $this->description('注销'));

        $uc_str = $this->uc->user_synlogout(); //同步登出代码，各站点的api/uc.php => synlogout
        $content='退出成功';#echo $uc_str;exit;
        delete_session();
        $this->user=null;
        $this->load->vars('user', null);
        ci_set_cookie('user','',null);

        $reurl = $this->input->get('reurl');

        if($reurl) {
            message($content,$reurl,true,$uc_str,3);
        } else {
            message($content,'oauth/login',true,$uc_str,3);
        }
    }

    public function register(){
        $this->load->vars('title', $this->title('注册'));
        $this->load->vars('keywords', $this->keywords('注册'));
        $this->load->vars('description', $this->description('注册'));
        $this->load->view('oauth/register');
    }

    public function activate(){
        $this->load->vars('title', $this->title('帐号激活'));
        $this->load->vars('keywords', $this->keywords('帐号激活'));
        $this->load->vars('description', $this->description('帐号激活'));

        $code=$this->get('code');#echo decode($code,ENCRYPT_KEY);exit;
#require_once APPPATH.'../lib/RNCryptor/autoload.php';
#$cryptor=new RNCryptor\Decryptor();
#$uid=$cryptor->decrypt($code,ENCRYPT_KEY);
        $this->load->library('encrypt');
        $uid=$this->encrypt->decode($code);
        $this->uc->user_activate($uid);
        $content='帐号激活成功';
        message($content,'oauth/login');
    }
    /*
     * 找回密码
     * */
    public function findpwd(){
        if($_POST){
            $email= trim($this->post('email'));
            //查询邮箱是否存在可用存在
            $exit=$this->uc->check_email_exit($email);
            if($exit==1){//不存在
                message('此邮箱不存在！','oauth/findpwd');
            }else{
                $key= str_shuffle('ABCDEFGHIGKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890');
                $key=substr($key,0,4).'-'.time();
                $last_key =encode($key);//最后加密的key和当前时间连接符
                //发送邮件
                $url = site_url()."oauth/updatepwd?key=".$last_key;
                //发送邮件
                //$body='野孩子帐号激活地址：<a href="'.$verifyurl.'">'.$verifyurl.'</a>';
                $body='Hi~<br>
					<br>
					点击下面的链接进行更改密码！<br>
					<br>
					<a href="'.$url.'">'.$url.'</a><br>
					有效时间30分钟。<br>
					<br>
					野孩子<a href="'.WWW_domian.'"> '.WWW_domian.'</a>';
                //更新数据库
                $update=$this->uc->user_update_key($email,array('key_code'=>$key));
                if($update){//成功了发邮件
                    $res= send_email($email,'野孩子　找回密码',$body,$this->site_configs);
                    if($res){
                        message('邮件发送成功！请立即查收邮件。','oauth/login');
                    }else{
                        message('邮件发送失败！请稍后再试','oauth/findpwd');
                    }

                }else{
                    message('对不起操作失败！请稍后再试','oauth/findpwd');
                }


            }
        }else{
            $this->load->vars('title', $this->title('找回密码'));
            $this->load->vars('keywords', $this->keywords('找回密码'));
            $this->load->vars('description', $this->description('找回密码'));
            $this->load->view('oauth/findpwd');
        }
    }
    /*
     * 更新密码操作
     * */
    public function updatePwd(){
        if($_POST){//更新的提交操作
            $uid=intval($this->post('u'));
            $pwd=trim($this->post('userpwd'));
            $c_pwd=trim($this->post('userpwd2'));
            if(!$pwd || $pwd!=$c_pwd){//密码没有的情况下
                message('填写发生错误！','oauth/findpwd');
            }else{
                //更新数据
                $new_pwd=md5($pwd);//新密码
                $l_res = $this->uc->user_update($uid,array('password'=>$new_pwd));//本地
                //更新discuz
                $d_res = $this->uc->uc_update('common_member', array('password' => $new_pwd),$uid);
                //更新uc
                $salt = rand(1000, 9999);
                $npwd = md5(trim($this->post('userpwd')) . $salt);
                $uc_res = $this->uc->uc_update('ucenter_members', array('password' => $npwd, 'salt' => $salt),$uid);
                if($l_res && $d_res && $uc_res){
                    message('密码修改成功！','oauth/login');
                }else{
                    message('密码修改失败！','oauth/findpwd');

                }

            }
        }else{
            $this->load->vars('title', $this->title('重置密码'));
            $key=trim($this->get('key'));
            $get_key=decode($key);
            //判断时间是否超过30分钟
            $key_arr=explode("-",$get_key);
            $delay_time= (time()-$key_arr[1])/60;
            if($delay_time>30){
                message('此链接已经超时无效！','oauth/findpwd');
            }
            //查找数据库是否存在这个key
            $exit_key=$this->get_one_data('members','uid,username,email',array('key_code'=>$get_key));
            if($exit_key){//如果有记录的时候
                $data['name']=$exit_key['username'];
                $data['uid']=$exit_key['uid'];
                $this->load->view('oauth/updatePwd',$data);
            }else{
                message('此链接无效！','oauth/findpwd');
            }
        }
    }

    public function register_save(){
        if($_POST){
            $username=$this->post('username');
            $password=strtolower($this->post('userpwd'));
            $email=trim($this->post('email'));
            $uid= $this->uc->user_register($username,$password,$email);
            if($uid <= 0) {
                if($uid == -1) {
                    $error='用户名不合法';
                } elseif($uid == -2) {
                    $error='该用户名不可注册';
                } elseif($uid == -3) {
                    $error='该用户名已被注册';
                } elseif($uid == -4) {
                    $error='邮箱不合法';
                } elseif($uid == -5) {
                    $error='邮箱后缀不合法';
                } elseif($uid == -6) {
                    $error='邮箱已被注册';
                } else {
                    $error='操作错误';
                }
                message($error,'oauth/register',true,'',2);
            }else {
                $this->load->library('encrypt');
                $code=$this->encrypt->encode($uid);
                $send=$this->send_email_message($code,$email);
                if($send){
                    $this->load->vars('title', $this->title('注册成功'));
                    $data['code']=$code;
                    $data['email']=$email;
                    $this->load->view('oauth/register_success',$data);
                }else{
                    message('发邮件失败','oauth/register',true,'',3);
                }
            }
        }
    }


    /*发送邮件模版
     *
     *$code 加密的用户ID
     * $email 注册邮箱
     * */
    public function send_email_message($code,$email){
        $verifyurl = site_url()."oauth/activate?code=".urlencode($code);
        $body='Hi~<br>
			<br>
			感谢注册野孩子，准备好开始享受新的旅程吧！<br>
			<br>
			点击下方链接激活你的账户：<br>
			<a href="'.$verifyurl.'">'.$verifyurl.'</a><br>
			验证邮箱可保护账户安全并在忘记密码的时候帮助你找回密码。<br>
			<br>
			野孩子<a href="'.WWW_domian.'"> '.WWW_domian.'</a>';
        $send= send_email($email,'野孩子　注册激活',$body,$this->site_configs);
        if($send){
            return true;
        }else{

            return false;
        }

    }
    /*重新发送邮件*/
    public function resend_email(){
        if($this->input->is_ajax_request()){
            $code=$this->post('code');
            $email=$this->post('email');
            $sends= $this->send_email_message($code,$email);
            $result=0;
            if($sends){
                $result=1;
            }
            echo $result;
        }
    }
}
