<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('ENCRYPT_KEY','fW8~H;6!');  //加密解密 密钥
define('UPLOAD_FOLDER','upload');  //文件上传目录

//论坛帖子分类
define('Category_post',1);  //帖子
define('Category_travel',2);  //游记
define('Category_guide',3);  //攻略
define('Category_together',4);  //结伴同游
//外链url地址
define('BBS_domian','http://bbs.gowildkid.com/');  //论坛地址
define('PASSPORT_domian','http://passport.gowildkid.com/');  //注册登录地址
define('IMG_domian','http://www.gowildkid.com/');  //图片地址
define('WWW_domian','http://www.gowildkid.com/');  //主站地址
/* End of file constants.php */
/* Location: ./application/config/constants.php */
