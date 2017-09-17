<meta charset="utf-8">
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

// 查出数据库cat表所有数据
$sql = "select * from cat";
$result = mysql_query($sql, $conn);
$cat = array();
while( $row = mysql_fetch_assoc($result) ) {
    $cat[] = $row;
}
//var_dump($cat);


require(ROOT . '/view/admin/catlist.html');