<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * UC 通信配置
 */

define('UC_CONNECT', null); // 连接 UCenter 的方式: mysql/NULL, 默认为空时为 fscoketopen()
// mysql 是直接连接的数据库, 经实践，还是填写null好。mysql有时无法执行

//数据库相关 (mysql 连接时, 并且没有设置 UC_DBLINK 时, 需要配置以下变量)
define('UC_DBHOST', 'localhost');            // UCenter 数据库主机
define('UC_DBUSER', 'root');                // UCenter 数据库用户名
define('UC_DBPW', '8888789_qQ');                    // UCenter 数据库密码
define('UC_DBNAME', 'wildkidc_bbs');                // UCenter 数据库名称
define('UC_DBCHARSET', 'utf8');                // UCenter 数据库字符集
define('UC_DBTABLEPRE', '`wildkidc_bbs`.pre_ucenter_');            // UCenter 数据库表前缀
define('UC_DBCONNECT', 0);                    // 是否持久化链接
//通信相关
define('UC_KEY', 'yehaiz');                // 与 UCenter 的通信密钥, 要与注册应用时填写的保持一致
define('UC_API', 'http://bbs.gowildkid.com/uc_server');    // UCenter 的 URL 地址, 在调用头像时依赖此常量
define('UC_CHARSET', 'utf-8');                // UCenter 的字符集
define('UC_IP', '');                    // UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
define('UC_APPID', 2);                    // 当前应用的 ID

define('UC_PPP', 20);
