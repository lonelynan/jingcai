<?php
/**
 * Created by PhpStorm.
 * User: 35614
 * Date: 2017/11/28
 * Time: 15:16
 */
// 检测PHP环境


if(version_compare(PHP_VERSION,'5.4.0','<'))  die('require PHP > 5.4.0 !');

define('PLUGIN_PATH', __DIR__ . '/plugins/');
define('UPLOAD_PATH','public/upload/'); // 编辑器图片上传路径
define('TPSHOP_CACHE_TIME',86400); // TPadmin 缓存时间  31104000
$http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http';
define('SITE_URL',$http.'://'.$_SERVER['HTTP_HOST']);
// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');

//define('BIND_MODULE','home');
// 开启调试模式
define('APP_DEBUG', true);
// 定义时间
define('NOW_TIME',$_SERVER['REQUEST_TIME']);
// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';