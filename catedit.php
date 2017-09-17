<?php
/**
 * Created by PhpStorm.
 * User: xiaoyu
 * Date: 2017/9/10
 * Time: 17:07
 */
require('./lib/init.php');
if (!acc()){
    header('Location:login.php');
}
// 连接数据库
$conn = mysql_connect('localhost','root','root');
if ( !$conn ) {
    die("Could not connect: ".mysql_error());
}
mysql_select_db('blog', $conn);
mysql_query('set names utf-8');

$cat_id = $_GET['cat_id'];
//echo $cat_id;

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

if(empty($_POST)){
    $sql = "select catname from cat where cat_id=$cat_id";
    $result = mysql_query($sql,$conn);
    $cat = mysql_fetch_assoc($result);
    require('./view/admin/catedit.html');
} else {
    $sql = "update cat set catname='$_POST[catname]' where cat_id=$cat_id";
    if ( !mysql_query($sql, $conn) ) {
        fail('栏目修改失败');
        echo mysql_error();
    } else {
        success("栏目修改成功");
    }

}
