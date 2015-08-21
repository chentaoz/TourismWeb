<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 获取图片显示URL
 * @param $img 图片相对路径
 * @return mixed
 */
function get_img_url($img){
    $CI =& get_instance();
    $config = $CI->config->config;
    return $CI->config->site_url(UPLOAD_FOLDER.'/'.$img);
}

/**
 * URL重定向
 * @param $url
 */
function top_redirect($url){
    header("Content-Type: text/html; charset=utf-8");
    $str = '<script type="text/javascript">';
    $str .= 'top.location.href="'.$url.'"';
    $str .= '</script>';
    echo $str;exit;
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
    if($data!=null) {
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
 * session->userdata($item)
 * @param $item
 * @return mixed
 */
function get_session($item)
{
    $CI=&get_instance();
    return $CI->session->userdata($item);
}

/**
 * session->sess_destroy()
 */
function delete_session()
{
    $CI=&get_instance();
    $CI->session->sess_destroy();
}

/**
 * session->all_userdata()
 * @return mixed
 */
function get_all_session()
{
    $CI=&get_instance();
    return $CI->session->all_userdata();
}

/**
 * session->set_userdata($newdata,$newval)
 * @param array $newdata
 * @param string $newval
 */
function set_session($newdata = array(), $newval = '')
{
    $CI=&get_instance();
    $CI->session->set_userdata($newdata,$newval);
}

/**
 * session->unset_userdata($newdata)
 * @param array $newdata
 */
function unset_session($newdata = array())
{
    $CI=&get_instance();
    $CI->session->unset_userdata($newdata);
}

/**
 * 简单对称加密算法之加密
 * @param String $string 需要加密的字串
 * @param String $skey 加密EKY
 * @return String
 */
function encode($string = '', $skey = 'xcenter') {
    $skey = str_split(base64_encode($skey));
    $strArr = str_split(base64_encode($string));
    $strCount = count($strArr);
    foreach ($skey as $key => $value) {
        $key < $strCount && $strArr[$key].=$value;
    }
    return str_replace('=', 'O0O0O', join('', $strArr));
}
/**
 * 简单对称加密算法之解密
 * @param String $string 需要解密的字串
 * @param String $skey 解密KEY
 * @return String
 */
function decode($string = '', $skey = 'xcenter') {
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
function is_email($email){
    $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    if(preg_match($pattern,$email)){
        return true;
    }else{
        return false;
    }
}

/**
 * 二维数组提取一维数组
 * @param $array_list
 * @param $key
 * @param $value
 * @return array|null
 */
function get_dict($array_list,$key,$value){
    if($array_list==null||count($array_list)==0){
        return null;
    }
    $arr=array();
    foreach ($array_list as $row)
    {
        $arr[$row[$key]]=$row[$value];
    }
    return $arr;
}

/**
 * 二维数组转一维数组
 * @param $array_list
 * @param $key
 * @return array
 */
function get_arr($array_list,$key){
    $arr=array();
    foreach ($array_list as $row)
    {
        array_push($arr,$row[$key]);
    }
    return $arr;
}

?>