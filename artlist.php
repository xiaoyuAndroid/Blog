<?php
/**
 * Created by PhpStorm.
 * User: xiaoyu
 * Date: 2017/9/12
 * Time: 12:05
 */
require('./lib/init.php');

if (!acc()){
 header('Location:login.php');
}

$sql = "select art_id,title,pubtime,comm,catname from art left join cat on art.cat_id=cat.cat_id";
$arts = mGetAll($sql);
//var_dump($arts);exit;

include(ROOT . '/view/admin/artlist.html');