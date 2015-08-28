<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 获取图片显示URL
 * @param $img 图片相对路径
 * @return mixed
 */
function get_img_url($img)
{
    $CI =& get_instance();
    $config = $CI->config->config;
    return $CI->config->site_url(UPLOAD_FOLDER . '/' . $img);
}

/**
 * URL重定向
 * @param $url
 */
function top_redirect($url)
{
    header("Content-Type: text/html; charset=utf-8");
    $str = '<script type="text/javascript">';
    $str .= 'top.location.href="' . $url . '"';
    $str .= '</script>';
    echo $str;
    exit;
}

/**
 * curl get url
 * @param string $url
 * @param array $data
 * @param int $timeout
 * @return bool|mixed
 */
function do_curl_get_request($url, $data, $timeout = 5)
{
    if ($url == '' || $timeout <= 0) {
        return false;
    }
    if ($data != null) {
        $url = $url . '?' . http_build_query($data);
    }
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($ch, CURLOPT_HEADER, false); //启用时会将头文件的信息作为数据流输出
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); //设置cURL允许执行的最长秒数
    $output = curl_exec($ch);
    if ($output === FALSE) {
        echo "cURL Error: " . curl_error($ch);
        return false;
    }
    return $output;
}

/**
 * curl post url
 * @param string $url
 * @param string $requestString
 * @param int $timeout
 * @return bool|mixed
 */
function do_curl_post_request($url, $requestString, $timeout = 5)
{
    if ($url == '' || $requestString == '' || $timeout <= 0) {
        return false;
    }
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_PORT, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestString);
    /*全部数据使用HTTP协议中的"POST"操作来发送。要发送文件，在文件名前面加上@前缀并使用完整路径。
    这个参数可以通过urlencoded后的字符串类似'para1=val1&para2=val2&...'或使用一个以字段名为键值，字段数据为值的数组。
    如果value是一个数组，Content-Type头将会被设置成multipart/form-data。
    */
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

    $output = curl_exec($ch);
    if ($output === FALSE) {
        echo "cURL Error: " . curl_error($ch);
        return false;
    }
    return $output;
}

/**
 * 设置cookie
 * @param $name
 * @param $value
 * @param $expire 单位 秒
 */
function ci_set_cookie($name,$value,$expire){
    $CI=&get_instance();
    $config = $CI->config->config;#var_dump($config);
    if(is_array($value)){
        $value = $CI->encrypt->encode(json_encode($value));
    }else {
        $value = $CI->encrypt->encode($value);#echo $value;
    }
    $cookie = array(
        'name'   => $name,
        'value'  => $value,
        'expire' => $expire,
        'domain' => $config['cookie_domain'],
        'path'   => $config['cookie_path'],
        'prefix' => $config['cookie_prefix'],
        'secure' => $config['cookie_secure']
    );
    $CI->input->set_cookie($cookie);
}

/**
 * 获取cookie值
 * @param $name
 * @return mixed
 */
function ci_get_cookie($name){
    $CI=&get_instance();
    $config = $CI->config->config;
    $value = $CI->input->cookie($config['cookie_prefix'].$name,TRUE);
    return $CI->encrypt->decode($value);
}

/**
 * session->userdata($item)
 * @param $item
 * @return mixed
 */
function get_session($item)
{
    $CI =& get_instance();
    return $CI->session->userdata($item);
}

/**
 * session->sess_destroy()
 */
function delete_session()
{
    $CI =& get_instance();
    $CI->session->sess_destroy();
}

/**
 * session->all_userdata()
 * @return mixed
 */
function get_all_session()
{
    $CI =& get_instance();
    return $CI->session->all_userdata();
}

/**
 * session->set_userdata($newdata,$newval)
 * @param array $newdata
 * @param string $newval
 */
function set_session($newdata = array(), $newval = '')
{
    $CI =& get_instance();
    $CI->session->set_userdata($newdata, $newval);
}

/**
 * session->unset_userdata($newdata)
 * @param array $newdata
 */
function unset_session($newdata = array())
{
    $CI =& get_instance();
    $CI->session->unset_userdata($newdata);
}

/**
 * 简单对称加密算法之加密
 * @param String $string 需要加密的字串
 * @param String $skey 加密EKY
 * @return String
 */
function encode($string = '', $skey = 'xcenter')
{
    $skey = str_split(base64_encode($skey));
    $strArr = str_split(base64_encode($string));
    $strCount = count($strArr);
    foreach ($skey as $key => $value) {
        $key < $strCount && $strArr[$key] .= $value;
    }
    return str_replace('=', 'O0O0O', join('', $strArr));
}

/**
 * 简单对称加密算法之解密
 * @param String $string 需要解密的字串
 * @param String $skey 解密KEY
 * @return String
 */
function decode($string = '', $skey = 'xcenter')
{
    $skey = str_split(base64_encode($skey));
    $strArr = str_split(str_replace('O0O0O', '=', $string), 2);
    $strCount = count($strArr);
    foreach ($skey as $key => $value) {
        $key < $strCount && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
    }
    return base64_decode(join('', $strArr));
}

/**
 * 验证是否正确的电子邮件
 * @param $email
 * @return bool
 */
function is_email($email)
{
    $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    if (preg_match($pattern, $email)) {
        return true;
    } else {
        return false;
    }
}

function get_referer()
{
    if (empty($_SERVER['HTTP_REFERER'])) {
        return "";
    }
    return $_SERVER['HTTP_REFERER'];
}

/**
 * 二维数组提取一维数组
 * @param $array_list
 * @param $key
 * @param $value
 * @return array|null
 */
function get_dict($array_list, $key, $value)
{
    if ($array_list == null || count($array_list) == 0) {
        return null;
    }
    $arr = array();
    foreach ($array_list as $row) {
        $arr[$row[$key]] = $row[$value];
    }
    return $arr;
}

/**
 * 二维数组转一维数组
 * @param $array_list
 * @param $key
 * @return array
 */
function get_arr($array_list, $key)
{
    $arr = array();
    foreach ($array_list as $row) {
        array_push($arr, $row[$key]);
    }
    return $arr;
}

function get_url($uri){
    if ( ! is_array($uri)) {
        $site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
    }
    else{
        $site_url = site_url($uri);
    }
    return $site_url;
}

/**
 * 弹出信息页面方法
 * @param $content
 * @param $target_url
 * @param bool $success
 * @param string $script
 * @param int $delay_time
 */
function message($content, $target_url,$success=true,$script='', $delay_time =1)
{
    $_CI = &get_instance();
    $_CI->load->view('message', array(
        'content' => $content,
        'target_url' => $target_url,
        'success'=>$success,
        'script' => $script,
        'delay_time' => $delay_time,
        'lang' => $_CI->lang->language
    ));
}

function send_email($email_to, $subject, $message, $config)
{
    require_once APPPATH.'../lib/phpMailer/PHPMailerAutoload.php';
    //Create a new PHPMailer instance
    $mail = new PHPMailer();
    //Tell PHPMailer to use SMTP
    // $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    // $mail->SMTPDebug = 1;
    //Ask for HTML-friendly debug output
    // $mail->Debugoutput = 'html';
    //Set the hostname of the mail server
    // $mail->Host = $config['smtp_host'];
    //Set the SMTP port number - likely to be 25, 465 or 587
    // $mail->Port = $config['smtp_port'];
    // $mail->SMTPSecure = $config['smtp_secure']; //Secure conection
    //Whether to use SMTP authentication
    // $mail->SMTPAuth = true;
    //Username to use for SMTP authentication
    // $mail->Username = $config['smtp_user'];
    //Password to use for SMTP authentication
    // $mail->Password = $config['smtp_psw'];
    //Set who the message is to be sent from
    $mail->setFrom($config['smtp_user'], $config['smtp_name']);
    //Set an alternative reply-to address
    $mail->addReplyTo($config['smtp_user'], $config['smtp_name']);
    //Set who the message is to be sent to
    $mail->addAddress($email_to);
    //Set the subject line
    $mail->Subject = $subject;
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($message);
    //Replace the plain text body with one created manually
    #$mail->AltBody = 'This is a plain-text message body';
    //Attach an image file
    #$mail->addAttachment('images/phpmailer_mini.png');
    $mail->CharSet = 'utf-8';            // 这里指定字符集！
	$mail->Encoding = "base64";
    //send the message, check for errors
    if (!$mail->send()) {
        #echo "Mailer Error: " . $mail->ErrorInfo;
        #debug($mail->ErrorInfo);
        return false;
    } else {
        #echo "Message sent!";
        return true;
    }
}

function debug($msg)
{
    if(DEBUG) {
        $fp = fopen(APPPATH . "txt.txt", "a+");
        fwrite($fp, $msg);
        fclose($fp);
    }
}

?>