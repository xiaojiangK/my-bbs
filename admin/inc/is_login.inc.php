<?php
    if (isset($_SESSION['manage']['name']) && isset($_SESSION['manage']['pass'])) {
        $query = "select * from bbs_manage where name='{$_SESSION['manage']['name']}' and pass=md5('{$_SESSION['manage']['pass']}')";
        $result = query_sql($link, $query);
        if (mysqli_num_rows($result)) {
            skip('你已经登录，请勿重复登录！', 'error', 'index.php');
        }
    }
?>