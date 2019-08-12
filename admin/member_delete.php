<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();
    include_once "./inc/tools.inc.php";

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        skip('id参数错误！','error','member.php');
    }

    // 获取会员信息
    $query = "select * from bbs_member where id={$_GET['id']}";
    $result = query_sql($link, $query);
    $data = mysqli_fetch_assoc($result);
    if (!$data['id']) {
        skip('会员信息不存在！','error','member.php');
    }

    // 删除会员
    $query = "delete from bbs_member where id={$_GET['id']}";
    $result = query_sql($link, $query);
    if (mysqli_affected_rows($link) == 1) {
        skip('恭喜您，删除会员成功！','ok','member.php');
    } else {
        skip('删除会员失败，请重试！','error','member.php');
    }
?>