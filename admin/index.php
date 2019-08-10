<?php
	include_once "../inc/config.inc.php";
	include_once "../inc/skip.inc.php";
	$link = connect();
	include_once "./inc/is_login.inc.php";

	if (!is_login($link)) {
        skip('你还没登录，请登录！', 'error', 'login.php');
	}

	// 查询管理员
	$query="select * from bbs_manage where id={$_SESSION['manage']['id']}";
	$result_manage=query_sql($link, $query);
	$data_manage=mysqli_fetch_assoc($result_manage);

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
			<li>|-
				 反馈留言(6)
				 评论(6)
				 会员(4)
				 管理员(2)
			</li>
		</ul>
	</div>
	<div class="explain">
		<ul>
			<li>|- 服务器操作系统：WINNT </li>
			<li>|- 服务器软件：Apache/2.4.18 </li>
			<li>|- MySQL 版本：5.5.5-10.1.9-MariaDB</li>
			<li>|- 最大上传文件：300M</li>
			<li>|- 内存限制：256M</li>
			<li>|- <a target="_blank" href="phpinfo.php">PHP 配置信息</a></li>
		</ul>
	</div>
	<div class="explain">
		<ul>
			<li>|- 程序安装位置(绝对路径)：D:\WorkingSoftware\UPUPW_AP7.0\htdocs\youyouwang</li>
			<li>|- 程序在web根目录下的位置(首页的url地址)：/youyouwang/</li>
			<li>|- 程序作者：伍江 :))</li>
			<li>|- 网站：<a target="_blank" href="../index.php">悠游网</a></li>
		</ul>
	</div>
</div>
<?php
    include_once "./inc/footer.inc.php";
?>