<?php

require('./lib/init.php');

//查询所有的栏目
$sql = "select cat_id,catname,num from cat";
$cats = mGetAll($sql);

//判断地址栏是否有cat_id
//有的话，赋值给 $where,后面拼接到 $sql 语句上
if(isset($_GET['cat_id'])) {
    $where = " and art.cat_id=$_GET[cat_id]";
} else {
    $where = '';
}

$sql = "select count(*) from art inner join cat on art.cat_id=cat.cat_id where 1" . $where;


//分页代码
$sql = "select count(*) from art where 1" . $where;//获取总的文章数
$num = mGetOne($sql);//总的文章数
$curr = isset($_GET['page']) ? $_GET['page'] : 1;//当前页码数
$cnt = 1;//每页显示条数
$page = getPage($num , $curr, $cnt);
//print_r($page);

//如果当前栏目下没有文章,跳转到首页去
if ( !mGetOne($sql) ){
    header('Location: index.php');
}else {
    //如果当前栏目下有文章
    //查询所有的文章
    $sql = "select art_id,title,content,pubtime,comm,catname,thumb from art inner join cat on art.cat_id=cat.cat_id where 1" . $where . ' order by art_id desc limit ' . ($curr-1)*$cnt . ',' . $cnt;
    $arts = mGetAll($sql);
    require(ROOT . '/view/front/index.html');
}


