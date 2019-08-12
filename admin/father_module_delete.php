<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();
    include_once "./inc/tools.inc.php";

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        skip('id参数错误！','error','father_module.php');
    }

    // 获取父板块信息
    $query = "select * from bbs_father_module where id={$_GET['id']}";
    $result = query_sql($link, $query);
    $data = mysqli_fetch_assoc($result);
    if (!$data['id']) {
        skip('父板块不存在！','error','father_module.php');
    }

    // 删除父板块
    $query = "delete from bbs_father_module where id={$_GET['id']}";
    $result = query_sql($link, $query);
    if (mysqli_affected_rows($link) == 1) {
        skip('恭喜您，删除父板块成功！','ok','father_module.php');
    } else {
        skip('删除父板块失败，请重试！','error','father_module.php');
    }
?>