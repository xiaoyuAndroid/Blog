<?php
/**
 * Created by PhpStorm.
 * User: xiaoyu
 * Date: 2017/9/10
 * Time: 17:28
 */
require('./lib/init.php');
if (!acc()){
    header('Location:login.php');
}
$cat_id = $_GET['cat_id'];
//echo $cat_id;

// 连接数据库
$conn = mysql_connect('localhost','root','root');
if ( !$conn ) {
    die("Could not connect: ".mysql_error());
}
mysql_select_db('blog', $conn);
mysql_query('set names utf-8');

// 检测 栏目id 是否为数字
if( !is_numeric($cat_id) ){
    fail('栏目不合法');
}

// 检测 栏目id 是否存在
$sql = "select count(*) from cat where cat_id=$cat_id";
$result = mysql_query($sql, $conn);
if ( mysql_fetch_row($result)[0] == 0 ){
    fail('栏目不存在');
}
// 检测 栏目id 下是否又文章
// 从 art 表查
$sql = "select count(*) from art where cat_id=$cat_id";
$result = mysql_query($sql, $conn);
if ( mysql_fetch_row($result)[0] != 0 ){
    fail('栏目下有文章，不能删除');
}

// 删除栏目
$sql = "delete from cat where cat_id=$cat_id";
if( !mysql_query($sql, $conn) ){
    fail('栏目删除失败');
    echo mysql_errno();
} else {
    success( '栏目删除成功');
}

