<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
	$link = connect();
	include_once "inc/is_login.inc.php";

    if (is_login($link)) {
        skip('你已经登录，请勿重复登录！', 'error', 'index.php');
    }

    if (isset($_POST['submit'])) {
        // 转义入库
        $_POST = escape($link, $_POST);
        $vcode = $_POST['vcode'];
        $name = $_POST['name'];
        $pass = $_POST['pass'];
        if (empty($name) || strlen($name) > 32) {
            skip('用户名不能为空并且不能大于32位', 'error', 'login.php');
        }
        if (strlen($pass) < 6 || strlen($pass) > 32) {
            skip('密码不能小于6位并且不能大于32位', 'error', 'login.php');
        }
        if (strtolower($vcode) != strtolower($_SESSION['vcode'])) {
            skip('验证码错误', 'error', 'login.php');
        }
        $query = "select * from bbs_manage where name='{$name}' and pass=md5('{$pass}')";
        $result = query_sql($link, $query);
        if (mysqli_num_rows($result)) {
			$data = mysqli_fetch_assoc($result);
            $_SESSION['manage']['id'] = $data['id'];
            $_SESSION['manage']['name'] = $data['name'];
            $_SESSION['manage']['pass'] = $data['pass'];
            $_SESSION['manage']['level'] = $data['level'];
            skip('登录成功！', 'ok', 'index.php');
        } else {
            skip('用户名或者密码错误，请重试！', 'error', 'login.php');
        }
	}
	close_db($link);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>后台登录</title>
<link href="../img/index/logo.gif" rel="shortcut icon"/>
<meta name="keywords" content="后台登录" />
<meta name="description" content="后台登录" />
<style type="text/css">
body {
	background:#f7f7f7;
	font-size:14px;
}
#main {
	width:360px;
	height:320px;
	background:#fff;
	border:1px solid #ddd;
	position:absolute;
	top:50%;
	left:50%;
	margin-left:-180px;
	margin-top:-160px;
	border-radius:5px;
}
#main .title {
	height: 48px;
	line-height: 48px;
	color:#333;
	font-size:16px;
	font-weight:bold;
	text-indent:30px;
	border-bottom:1px dashed #eee;
}
#main form {
	width:300px;
	margin:20px 0 0 40px;
}
#main form label {
	margin:10px 0 0 0;
	display:block;
}
#main form label input.text {
	width:200px;height:30px;border:1px solid #ddd; border-radius:3px;
}
#main form label .vcode {
	display:block;
	margin:15px 0 0 56px;
}
#main form label input.submit {
	outline:none;
	border:none;
	border:1px solid #ccc;
	border-radius:5px;
	width:200px;
	display:block;
	height:35px;
	cursor:pointer;
	margin:20px 0 0 56px;
	color:#333;
	font-size:15px;
	font-weight:700;
	background:#ddd;
}
#main form label input.submit:hover{
	background:#ffc;
}
</style>
</head>
<body>
	<div id="main">
		<div class="title">管理登录</div>
		<form method="post">
			<label>用户名：<input class="text" type="text" name="name" /></label>
			<label>密　码：<input class="text" type="password" name="pass" /></label>
			<label>验证码：<input class="text" type="text" name="vcode" /></label>
			<label><img class="vcode" src="../show_code.php" /></label>
			<label><input class="submit" type="submit" name="submit" value="登录" /></label>
		</form>
	</div>
</body>
</html>