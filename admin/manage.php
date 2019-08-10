<?php
	include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
	$link = connect();
	include_once "./inc/is_login.inc.php";
	
	if (!is_login($link)) {
        skip('你还没登录，请登录！', 'error', 'login.php');
	}

    $template['title']='管理员列表';
    $template['css']=array('style/public.css');
	include_once "./inc/header.inc.php";
?>
<div id="main">
    <div class="title">管理员列表</div>
	<table class="list">
		<tr>	 	 	
			<th>名称</th>
			<th>等级</th>
			<th>创建日期</th>
			<th>操作</th>
		</tr>
		<?php
			$query="select * from bbs_manage";
			$result = query_sql($link, $query);
			while($data=mysqli_fetch_assoc($result)) {
				if ($data['level'] == 0) {
					$data['level'] = '超级会员';
				} else if ($data['level'] == 1) {
					$data['level'] = '普通会员';
				}
$html = <<<html
				<tr>
					<td>{$data['name']}[id:{$data['id']}]</td>
					<td>{$data['level']}</td>
					<td>{$data['create_time']}</td>
					<td><a href="manage_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href="#">[删除]</a></td>
				</tr>
html;
				echo $html;
			}
		?>
	</table>
</div>
<?php
    include_once "./inc/footer.inc.php";
?>