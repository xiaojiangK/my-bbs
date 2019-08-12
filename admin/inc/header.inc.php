<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title><?php echo $template['title']?></title>
<meta name="keywords" content="后台界面" />
<meta name="description" content="后台界面" />
<?php
foreach ($template['css'] as $key => $val) {
	echo "<link rel='stylesheet' type='text/css' href='{$val}' /> \n";
}
?>
</head>
<body>
	<div id="top">
		<div class="logo">
			管理中心
		</div>
		<ul class="nav">
			<li><a href="https://xiaojiangK.github.io/site-nav/" target="_blank">前端导航</a></li>
			<li><a href="https://github.com/xiaojiangK/" target="_blank">GitHub</a></li>
		</ul>
		<div class="login_info">
			<a href="#" style="color:#fff;">网站首页</a>&nbsp;|&nbsp;
			管理员： <?php echo $_SESSION['manage']['name']?> <a href="logout.php">[注销]</a>
		</div>
	</div>
	<div id="sidebar">
		<ul>
			<li>
				<div class="small_title">系统</div>
				<ul class="child">
					<li><a class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'index.php') echo 'current'?>" href="index.php">系统信息</a></li>
					<li><a class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'manage.php' || basename($_SERVER['SCRIPT_NAME']) == 'manage_update.php') echo 'current'?>" href="manage.php">管理员</a></li>
					<li><a class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'manage_add.php') echo 'current'?>" href="manage_add.php">添加管理员</a></li>
					<li><a class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'web_site.php') echo 'current'?>" href="web_site.php">站点设置</a></li>
				</ul>
			</li>
			<li><!--  class="current" -->
				<div class="small_title">内容管理</div>
				<ul class="child">
					<li><a class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'father_module.php' || basename($_SERVER['SCRIPT_NAME']) == 'father_module_update.php') echo 'current'?>" class="current" href="father_module.php">父板块列表</a></li>
					<li><a class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'father_module_add.php') echo 'current'?>" href="father_module_add.php">添加父板块</a></li>
					<li><a class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'son_module.php' || basename($_SERVER['SCRIPT_NAME']) == 'son_module_update.php') echo 'current'?>" href="son_module.php">子板块列表</a></li>
					<li><a class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'son_module_add.php') echo 'current'?>" href="son_module_add.php">添加子板块</a></li>
					<li><a class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'content.php') echo 'current'?>" href="content.php">帖子管理</a></li>
				</ul>
			</li>
			<li>
				<div class="small_title">用户管理</div>
				<ul class="child">
					<li><a class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'member.php' || basename($_SERVER['SCRIPT_NAME']) == 'member_update.php') echo 'current'?>" href="member.php">用户列表</a></li>
					<li><a class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'member_add.php') echo 'current'?>" href="member_add.php">添加用户</a></li>
				</ul>
			</li>
		</ul>
	</div>