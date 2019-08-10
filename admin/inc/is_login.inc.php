<?php
    function is_login($link) {
        if (isset($_SESSION['manage']['name']) && isset($_SESSION['manage']['pass'])) {
            $query = "select * from bbs_manage where name='{$_SESSION['manage']['name']}' and pass='{$_SESSION['manage']['pass']}'";
            $result = query_sql($link, $query);
            if (mysqli_num_rows($result)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    if(basename($_SERVER['SCRIPT_NAME'])=='manage_delete.php' || basename($_SERVER['SCRIPT_NAME'])=='manage_add.php' || basename($_SERVER['SCRIPT_NAME'])=='user_add.php' || basename($_SERVER['SCRIPT_NAME'])=='user_update.php' || basename($_SERVER['SCRIPT_NAME'])=='user_delete.php'){
        if($_SESSION['manage']['level']!='0'){
            if(!isset($_SERVER['HTTP_REFERER'])){
                $_SERVER['HTTP_REFERER']='index.php';
            }
            skip('对不起您权限不足！', 'error',$_SERVER['HTTP_REFERER']);
        }
    }
?>