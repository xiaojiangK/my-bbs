<?php
include_once '../inc/config.inc.php';
include_once '../inc/skip.inc.php';
$link=connect();
include_once './inc/tools.inc.php';//验证管理员是否登录

phpinfo();

close_db($link);
?>