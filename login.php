<?php
/**
 * Created by PhpStorm.
 * User: xiaoyu
 * Date: 2017/9/16
 * Time: 15:29
 */
require('./lib/init.php');
if(empty($_POST)) {
    require(ROOT . '/view/front/login.html');
} else {
    $user['name'] = trim($_POST['name']);
    if(empty($user['name'])) {
        fail('用户名不能为空');
    }

    $user['password'] = trim($_POST['password']);
    if(empty($user['password'])) {
        fail('密码不能为空');
    }

    $sql = "select * from user where name='$user[name]' and password='$user[password]'";
//    $sql = "select * from user where name='$user[name]'";
    $row = mGetRow($sql);
    //print_r($row);exit();
    if(!$row) {
        fail('用户名错误');
    } else {
        setcookie('name',$row['name']);
        header('Location: artlist.php');
//        if(md5($user['password'].$row['salt']) === $row['password']){
//            setcookie('name' , $user['name']);
//            setcookie('ccode' , cCode($user['name']));
//            header('Location: artlist.php');
//        } else {
//            fail('密码错误');
//        }
    }
}