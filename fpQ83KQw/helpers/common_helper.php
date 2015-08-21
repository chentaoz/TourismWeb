<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 获取图片缩略图URL
 * @param $img 图片相对路径
 * @param $size 图片宽高 格式: 150x100
 * @return string 缩略图地址
 * @$type 1.上传文件临时目录 2.场地或运动的主页面的banner图片的存放目录3.攻略的l图片存放目录4.攻略的l图片存放目录5.分类字典存放目录
 * 6.运动的图标 7.广告的图片目录 8.用户照片9.用户头像10新闻信息
 */
function get_img_url($img,$size,$type=0)
{
    $CI =& get_instance();
    switch ($type){
        case 1:
             $path=$CI->config->item('upload_temp'). '/';
    break;
        case 2 :
            $path=$CI->config->item('upload_place_sport'). '/';
    break;
       case 3:
           $path=$CI->config->item('upload_guide_image'). '/';
    break;
        case 4 :
            $path=$CI->config->item('upload_guide_pdf'). '/';
    break;
        case 5:
            $path=$CI->config->item('upload_taxonomy'). '/';
     break;
        case 6 :
            $path=$CI->config->item('upload_sports_icon'). '/';
     break;
        case 7 :
            $path=$CI->config->item('upload_ad'). '/';
      break;
        case 8:
            $path=$CI->config->item('upload_photo'). '/';
      break;
        case 9 :
            $path=$CI->config->item('upload_avatar'). '/';
       break;
       case 10 :
            $path=$CI->config->item('upload_news'). '/';
            break;
        default :
            $path='';
       break;
    }

    $img=$path.$img;
    $filename = FCPATH.$img;
    if(!is_file($filename)){
        if($size=='828x315'){
            return IMG_domian.'images/nobanner.jpg';
        }else{
            return IMG_domian.'images/no.png';
        }
    }
    $img_new=str_ireplace('upload', 'thumb',$img);
    $filename_new = FCPATH . $img_new;
    $path_info = pathinfo($filename_new);
    $filename_new=$path_info['dirname'].'/'.$path_info['filename'].$size.'.'.$path_info['extension'];//重新定义生成的图片
    $img_new=substr($img_new,0,strrpos($img_new,'.')).$size.'.'.$path_info['extension'];//重新定义返回的图片地址
    if (!is_dir($path_info['dirname'])) {
        mkdir($path_info['dirname'], 0777, true);
    }
    // 最大宽高
    list($width,$height)=explode('x',$size);
    $imgsize = getimagesize($filename);
    $owidth = $imgsize[0];
    $oheight = $imgsize[1];
    if (!is_file($filename_new)) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $filename;
        $config['new_image'] = $filename_new;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;

        if($oheight % ($owidth % $width) > $height){
            $config['master_dim'] = 'width';
        }else{
            $config['master_dim'] = 'height';
        }
        $config['quality'] = 75;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['thumb_marker'] = '';
        $CI->load->library('image_lib');
        $CI->image_lib->initialize($config);  //调用
        $CI->image_lib->resize();//生成缩略图
        $CI->image_lib->clear();
    }
    return IMG_domian.$img_new;
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
 * @param $value string | array
 * @param $expire 单位 秒
 */
function ci_set_cookie($name, $value, $expire)
{
    $CI =& get_instance();
    $config = $CI->config->config; #var_dump($config);
    if (is_array($value)) {
        $value = $CI->encrypt->encode(json_encode($value));
    } else {
        $value = $CI->encrypt->encode($value); #echo $value;
    }
    $cookie = array(
        'name' => $name,
        'value' => $value,
        'expire' => $expire,
        'domain' => $config['cookie_domain'],
        'path' => $config['cookie_path'],
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
function ci_get_cookie($name)
{
    $CI =& get_instance();
    $config = $CI->config->config;
    $value = $CI->input->cookie($config['cookie_prefix'] . $name, TRUE);
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

function get_url($uri)
{
    if (!is_array($uri)) {
        $site_url = (!preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
    } else {
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
function message($content, $target_url, $success = true, $script = '', $delay_time = 3)
{
    $_CI = & get_instance();
    $_CI->load->view('message', array(
        'content' => $content,
        'target_url' => $target_url,
        'success' => $success,
        'script' => $script,
        'delay_time' => $delay_time,
        'lang' => $_CI->lang->language
    ));
}

function send_email($email_to, $subject, $message, $config)
{
    if(!class_exists('PHPMailer')) {
        require_once APPPATH . '../lib/phpMailer/PHPMailerAutoload.php';
    }
    //Create a new PHPMailer instance
    $mail = new PHPMailer();
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    $mail->CharSet = 'utf-8';            // 这里指定字符集！
	$mail->Encoding = "base64";
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';
    //Set the hostname of the mail server
    $mail->Host = $config['smtp_host'];
    //Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = $config['smtp_port'];
    $mail->SMTPSecure = $config['smtp_secure']; //Secure conection
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Username to use for SMTP authentication
    $mail->Username = $config['smtp_user'];
    //Password to use for SMTP authentication
    $mail->Password = $config['smtp_psw'];
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

    //send the message, check for errors
    if (!$mail->send()) {
        #echo "Mailer Error: " . $mail->ErrorInfo;
        debug($mail->ErrorInfo);
        return false;
    } else {
        #echo "Message sent!";
        return true;
    }
}

function debug($msg)
{
    if (DEBUG) {
        $fp = fopen(APPPATH . "txt.txt", "a+");
        fwrite($fp, $msg);
        fclose($fp);
    }
}

function messagecutstr($str, $length = 0, $dot = ' ...')
{
    $str = messagesafeclear($str);
    $sppos = strpos($str, chr(0) . chr(0) . chr(0));
    if ($sppos !== false) {
        $str = substr($str, 0, $sppos);
    }
    #loadcache(array('bbcodes_display', 'bbcodes', 'smileycodes', 'smilies', 'smileytypes', 'domainwhitelist'));
    $bbcodes = 'b|i|u|p|color|size|font|align|list|indent|float';
    $bbcodesclear = 'email|code|free|table|tr|td|img|swf|flash|attach|media|audio|groupid|payto';
    $str = preg_replace("/\[i=?.*?\](.*?)\[\/i\]/is", '', $str);
    $str = strip_tags(preg_replace(array(
        "/\[hide=?\d*\](.*?)\[\/hide\]/is",
        "/\[quote](.*?)\[\/quote]/si",
        "/\[url=?.*?\](.+?)\[\/url\]/si",
        "/\[($bbcodesclear)=?.*?\](.*?)\[\/\\1\]/si",
        "/\[($bbcodes)=?.*?\]/i",
        "/\[\/($bbcodes)\]/i",
    ), array(
        '',
        '',
        '\\1',
        '',
        '',
        '',
    ), $str));

    if ($length) {
//        $str = cutstr($str, $length, $dot);
        $str=substr_utf8($str,0,$length);
    }
    #$str = preg_replace($_G['cache']['smilies']['searcharray'], '', $str);

    return trim($str);
}

function messagesafeclear($message)
{
    if (strpos($message, '[/password]') !== FALSE) {
        $message = '';
    }
    if (strpos($message, '[/postbg]') !== FALSE) {
        $message = preg_replace("/\s?\[postbg\]\s*([^\[\<\r\n;'\"\?\(\)]+?)\s*\[\/postbg\]\s?/is", '', $message);
    }
    if (strpos($message, '[/begin]') !== FALSE) {
        $message = preg_replace("/\[begin(=\s*([^\[\<\r\n]*?)\s*,(\d*),(\d*),(\d*),(\d*))?\]\s*([^\[\<\r\n]+?)\s*\[\/begin\]/is", '', $message);
    }
    if (strpos($message, '[page]') !== FALSE) {
        $message = preg_replace("/\s?\[page\]\s?/is", '', $message);
    }
    if (strpos($message, '[/index]') !== FALSE) {
        $message = preg_replace("/\s?\[index\](.+?)\[\/index\]\s?/is", '', $message);
    }
    if (strpos($message, '[/begin]') !== FALSE) {
        $message = preg_replace("/\[begin(=\s*([^\[\<\r\n]*?)\s*,(\d*),(\d*),(\d*),(\d*))?\]\s*([^\[\<\r\n]+?)\s*\[\/begin\]/is", '', $message);
    }
    if (strpos($message, '[/groupid]') !== FALSE) {
        $message = preg_replace("/\[groupid=\d+\].*\[\/groupid\]/i", '', $message);
    }
    return $message;
}

function substr_utf8($str,$start,$len){
    $strlen = $start + $len; // 用$strlen存储字符串的总长度，即从字符串的起始位置到字符串的总长度
    for($i = $start; $i < $strlen;) {
        if (ord ( substr ( $str, $i, 1 ) ) > 0xa0) { // 如果字符串中首个字节的ASCII序数值大于0xa0,则表示汉字
            $tmpstr .= substr ( $str, $i, 3 ); // 每次取出三位字符赋给变量$tmpstr，即等于一个汉字
            $i=$i+3; // 变量自加3
        } else{
            $tmpstr .= substr ( $str, $i, 1 ); // 如果不是汉字，则每次取出一位字符赋给变量$tmpstr
            $i++;
        }
    }
    return $tmpstr; // 返回字符串
}

//格式化文件大小
function setupSize($fileSize) {
    $size = sprintf("%u", $fileSize);
    if($size == 0) {
        return("0 KB");
    }
    $sizename = array(" KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    return round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizename[$i];
}

/**
 * 获取头像路径
 * @param $uid
 * @return string
 */
function get_avatar_src($uid,$size=''){
    return WWW_domian.'avatar/'.$uid;
}

/**
 * 设置缓存
 * @param $key 键
 * @param $value 值
 * @param int $seconds 单位 秒  默认为 1天
 */
function ci_set_cache($key,$value,$seconds=86400){
    $CI =& get_instance();
    $CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
    #if (!$CI->cache->get($key)){
        $CI->cache->save($key, $value, $seconds);
    #}
}

/**
 * 获取缓存
 * @param $key 键
 * @return mixed
 */
function ci_get_cache($key){
    $CI =& get_instance();
    $CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
    return $CI->cache->get($key);
}

/**
 * 删除缓存
 * @param string $key
 */
function ci_delete_cache($key=''){
    $CI =& get_instance();
    $CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
    if($key==''||$key==null){
        $CI->cache->clean(); //清除所有
    }else{
        $CI->cache->delete($key);
    }
}

/**
 * 是否支持APC缓存
 * @param $CI
 * @return mixed
 */
function ci_is_supported_apc($CI){
    return $CI->cache->apc->is_supported();
}
?>