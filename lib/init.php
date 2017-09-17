<?php
/**
 * Created by PhpStorm.
 * User: xiaoyu
 * Date: 2017/9/10
 * Time: 21:01
 */

header('Content-type:text/html;charset=utf8');
// 定义 ROOT 常量，目录为 魔术变量 __DIT__ 的上一级目录
define('ROOT' , dirname(__DIR__));

//echo __DIR__,'<br>';
//echo dirname(__DIR__),'<br>';
//echo __FILE__ , '<br>';
//echo __LINE__;
/*
 * D:\phpStudy\WWW\blog\lib
 * D:\phpStudy\WWW\blog
 * D:\phpStudy\WWW\blog\lib\init.php
 * 16
 *
 */

require(ROOT . '/lib/mysql.php');
require(ROOT . '/lib/func.php');