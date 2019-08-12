<?php
	include_once "../inc/config.inc.php";
	include_once "../inc/skip.inc.php";
	$link = connect();
	include_once "./inc/tools.inc.php";

	// 查询管理员
	$query="select * from bbs_manage where id={$_SESSION['manage']['id']}";
	$result_manage=query_sql($link, $query);
	$data_manage=mysqli_fetch_assoc($result_manage);

	$query = "select count(*) from bbs_father_module";
	$father_num = query_num($link, $query);

	$query = "select count(*) from bbs_son_module";
	$son_num = query_num($link, $query);

	$query = "select count(*) from bbs_content";
	$content_num = query_num($link, $query);

	$query = "select count(*) from bbs_manage";
	$manage_num = query_num($link, $query);

	$query = "select count(*) from bbs_member";
	$member_num = query_num($link, $query);

	$query = "select count(*) from bbs_reply";
	$reply_num = query_num($link, $query);

	if ($data_manage['level'] == 1) {
		$data_manage['level'] = '普通管理员';
	} else if ($data_manage['level'] == 0) {
		$data_manage['level'] = '超级管理员';
	}

    $template['title']='首页';
    $template['css']=array('style/public.css');
	include_once "./inc/header.inc.php";
?>
<div id="main">
	<div class="title">系统信息</div>
	<div class="explain">
		<ul>
			<li>|- 您好，<?php echo $data_manage['name']?></li>
			<li>|- 所属角色：<?php echo $data_manage['level']?></li>
			<li>|- 创建时间：<?php echo $data_manage['create_time']?></li>
		</ul>
	</div>
	<div class="explain">
		<ul>
			<li>|-  父板块(<?php echo $father_num?>) 
					子版块(<?php echo $son_num?>) 
					发布帖子(<?php echo $content_num?>) 
					帖子回复(<?php echo $reply_num?>) 
					管理员(<?php echo $manage_num?>) 
					会员用户(<?php echo $member_num?>)
			</li>
		</ul>
	</div>
	<div class="explain">
		<ul>
			<li>|- 服务器操作系统：<?php echo PHP_OS?></li>
			<li>|- 服务器软件：<?php echo $_SERVER['SERVER_SOFTWARE']?></li>
			<li>|- MySQL 版本：<?php echo mysqli_get_server_info($link)?></li>
			<li>|- 最大上传文件：<?php echo ini_get('upload_max_filesize')?></li>
			<li>|- 内存限制：<?php echo ini_get('memory_limit')?></li>
			<li>|- <a target="_blank" href="phpinfo.php">PHP 配置信息</a></li>
		</ul>
	</div>
	<div class="explain">
		<ul>
			<li>|- 程序安装位置(绝对路径)：<?php echo ROOT_PATH?></li>
			<li>|- 程序在web根目录下的位置(首页的url地址)：<?php echo SUB_URL?></li>
			<li>|- 程序作者：伍江 :))</li>
			<li>|- 网站：<a target="_blank" href="../index.php">mybbs</a></li>
		</ul>
	</div>
</div>
<?php
    include_once "./inc/footer.inc.php";
?>