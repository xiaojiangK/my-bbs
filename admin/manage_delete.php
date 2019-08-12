<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();
    include_once "./inc/tools.inc.php";

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        skip('id参数错误！','error','manage.php');
    }

    // 获取管理员信息
    $query = "select * from bbs_manage where id={$_GET['id']}";
    $result = query_sql($link, $query);
    $data = mysqli_fetch_assoc($result);
    if (!$data['id']) {
        skip('管理员不存在！','error','manage.php');
    }
    
    // 删除管理员
    $query = "delete from bbs_manage where id={$_GET['id']}";
    $result = query_sql($link, $query);
    if (mysqli_affected_rows($link)==1) {
        skip('恭喜您，删除管理员成功！','ok','manage.php');
    } else {
        skip('删除管理员失败，请重试！','error','manage.php');
    }
?>