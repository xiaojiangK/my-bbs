<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();
    include_once "./inc/tools.inc.php";

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        skip('id参数错误！','error','son_module.php');
    }

    // 获取子板块信息
    $query = "select * from bbs_son_module where id={$_GET['id']}";
    $result = query_sql($link, $query);
    $data = mysqli_fetch_assoc($result);
    if (!$data['id']) {
        skip('子板块不存在！','error','son_module.php');
    }

    // 删除子板块
    $query = "delete from bbs_son_module where id={$_GET['id']}";
    $result = query_sql($link, $query);
    if (mysqli_affected_rows($link) == 1) {
        skip('恭喜您，删除子板块成功！','ok','son_module.php');
    } else {
        skip('删除子板块失败，请重试！','error','son_module.php');
    }
?>