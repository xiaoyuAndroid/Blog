<?php
/**
 * Created by PhpStorm.
 * User: xiaoyu
 * Date: 2017/9/10
 * Time: 16:11
 */
require('./lib/init.php');
if (!acc()){
    header('Location:login.php');
}
if(empty($_POST)) {
    include(ROOT. '/view/admin/catadd.html');
} else {

    // 调用 lib/mysql.php 中的函数连接数据库
    $conn = mConn();

    // 检测栏目是否为空
    $cat['catname'] = trim($_POST['catname']);
    if (empty($cat['catname'])) {
//        exit('栏目名不能为空!');
        fail("栏目名称不能为空");
    }


//    // 检测栏目名是否已经存在
//    $sql = "select count(*) from cat where catname='$cat[catname]'";
//    $rs = mysql_query($sql, $conn);
////    var_dump( mysql_fetch_row($rs)[0] );
////    exit();
//    if ( mysql_fetch_row($rs)[0] != 0 ){
////        exit('栏目已经存在');
//        fail("栏目已经存在");
//    }
//
    // 检测栏目名是否已经存在
    // 用 lib/mysql.php 改写上面代码
    $sql = "select count(*) from cat where catname='$cat[catname]'";
    if ( mGetOne($sql) ){
        fail("栏目已经存在");
    }

    // 将栏目写入数据库cat表
    $sql = "insert into cat(catname) values ('$cat[catname]')";

    if ( !mysql_query($sql, $conn) ){
//        echo '添加失败，数据库error代码：'. mysql_errno();
        fail('添加失败');
    } else {
//        var_dump($cat['catname']);

//        echo "添加栏目成功";
        success("添加栏目成功");
    }
}

