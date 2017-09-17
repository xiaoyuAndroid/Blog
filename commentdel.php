<?php
/**
 * Created by PhpStorm.
 * User: xiaoyu
 * Date: 2017/9/13
 * Time: 20:47
 */

require('./lib/init.php');
if (!acc()){
    header('Location:login.php');
}
$comment_id = $_GET['comment_id'];

// 获取当前评论的 art_id
$sql = 'select art_id from comment where comment_id = ' . $comment_id;
$art_id = mGetOne($sql);

// 删除评论表的这条评论
$sql = 'delete from comment where comment_id = ' . $comment_id;
$result = mQuery($sql);

// 更改art表的 comm字段
if ($art_id && $result) {
    $sql = 'update art set comm=comm-1 where art_id = ' . $art_id;
    mQuery($sql);
}

// 跳转到上一页 commentlist.php
$ref = $_SERVER['HTTP_REFERER'];
header("Location:$ref");
