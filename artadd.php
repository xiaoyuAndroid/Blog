<?php
/**
 * Created by PhpStorm.
 * User: xiaoyu
 * Date: 2017/9/12
 * Time: 11:29
 */
require('./lib/init.php');
if (!acc()){
    header('Location:login.php');
}

$sql = "select * from cat";
$cats = mGetAll($sql);
//var_dump($cats);exit;

if(empty($_POST)) {
    include(ROOT. '/view/admin/artadd.html');
}else {
//    var_dump($_POST);
//    exit;
    //检测标题是否为空
    $art['title'] = trim($_POST['title']);
    if($art['title'] == '') {
        fail('标题不能为空');
    }

    //检测栏目是否合法
    $art['cat_id'] = $_POST['cat_id'];
    if(!is_numeric($art['cat_id'])) {
        fail('栏目不合法');
    }

    //检测内容是否为空
    $art['content'] = trim($_POST['content']);
    if($art['content'] == '') {
        fail('内容不能为空');
    }

    //判断是否有图片上传 且 error 是否为0
    if( !($_FILES['pic']['name'] == '' ) && $_FILES['pic']['error'] == 0) {
        $filename = createDir() . '/' . randStr() . getExt($_FILES['pic']['name']);
        if(move_uploaded_file($_FILES['pic']['tmp_name'], ROOT .  $filename)){
            $art['pic'] = $filename;
            $art['thumb'] = makeThumb($filename);
        }
    }

    //插入发布时间
    $art['pubtime'] = time();

    //插入arttag ，art表的冗余字段，省去了从 tag表查数据
    $art['arttag'] = trim($_POST['tag']);

    //插入内容到art表
    if(!mExec('art' , $art)) {
        fail('文章发布失败');
    } else {
        //判断是否有tag
        // tag 为空，文章可以添加成功，但是 art表的 arttag字段为空； tag表的 tag字段为空
        $art['tag'] = trim($_POST['tag']);
        if ($art['tag'] == '') {
            //将cat 的 num 字段 当前栏目下的文章数 +1
            $sql = "update cat set num=num+1 where cat_id=$art[cat_id]";
            mQuery($sql);
            success('文章添加成功');
        } else {
            //获取上次 insert 操作产生的主键id
            $art_id = getLastId();
            //插入tag 到tag表
            //liunx,mysql,php
            //insert into tag (art_id,tag) values (5 , 'linux') , (5 , 'mysql') , (5 , 'php')
            $tag = explode(',', $art['tag']);//索引数组
            $sql = "insert into tag (art_id,tag) values ";
            foreach ($tag as $v) {
                $sql .= "(" . $art_id . ",'" . $v . "') ,";
            }
            $sql = rtrim($sql, ",");
            if (mQuery($sql)) {
                //将cat 的 num 字段 当前栏目下的文章数 +1
                $sql = "update cat set num=num+1 where cat_id=$art[cat_id]";
                mQuery($sql);
                success('文章添加成功');
            } else {
                //tag 添加失败 删除原文章
                $sql = "delete from art where art_id=$art_id";
                if (mQuery($sql)) {
                //将cat 的 num 字段 当前栏目下的文章数 -1
                $sql = "update cat set num=num-1 where cat_id=$art[cat_id]";
                mQuery($sql);
                    fail('文章添加失败');
                }
            }
        }
    }
}