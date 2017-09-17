<?php
/**
 * Created by PhpStorm.
 * User: xiaoyu
 * Date: 2017/9/13
 * Time: 20:38
 */

require('./lib/init.php');
if (!acc()){
    header('Location:login.php');
}
$sql = "select * from comment";
$comms = mGetAll($sql);

//print_r($comms);

require(ROOT . '/view/admin/commentlist.html');