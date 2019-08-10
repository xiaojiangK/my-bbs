<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();
    include_once "./inc/is_login.inc.php";
    if (!is_login($link)) {
        skip('你还没登录，请登录！', 'error', 'login.php');
    }
    
    session_unset();//Free all session variables
    session_destroy();//销毁一个会话中的全部数据
    setcookie(session_name(),'',time()-3600,'/');//销毁保存在客户端的卡号（session id）
    header('Location:login.php');
    close($link);
?>