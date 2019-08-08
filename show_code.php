<?php
session_start();
include_once 'inc/vcode.inc.php';
$_SESSION['vcode']=vcode(100,35,30,4);
?>