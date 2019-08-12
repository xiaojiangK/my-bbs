<?php
	include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
	$link = connect();
	include_once "./inc/tools.inc.php";

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
			<th>修改日期</th>
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
				$url=urlencode("manage_delete.php?id={$data['id']}");
				$return_url=urlencode($_SERVER['REQUEST_URI']);
				$message="你真的要删除  {$data['name']} 吗？";
				$delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
$html = <<<html
				<tr>
					<td>{$data['name']}[id:{$data['id']}]</td>
					<td>{$data['level']}</td>
					<td>{$data['create_time']}</td>
					<td>{$data['last_time']}</td>
					<td><a href="manage_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href="{$delete_url}">[删除]</a></td>
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