<?php
    if(!is_manage_login($link)){
        skip('你还没登录，请登录！', 'error', 'login.php');
        exit();
    }

    // 检查权限
    if(basename($_SERVER['SCRIPT_NAME'])=='manage_delete.php' || basename($_SERVER['SCRIPT_NAME'])=='manage_add.php' || basename($_SERVER['SCRIPT_NAME'])=='manage_update.php' || basename($_SERVER['SCRIPT_NAME'])=='user_add.php' || basename($_SERVER['SCRIPT_NAME'])=='user_update.php' || basename($_SERVER['SCRIPT_NAME'])=='user_delete.php'){
        if($_SESSION['manage']['level']!='0'){
            if(!isset($_SERVER['HTTP_REFERER'])){
                $_SERVER['HTTP_REFERER']='index.php';
            }
            skip('对不起您权限不足！', 'error',$_SERVER['HTTP_REFERER']);
        }
    }
?>