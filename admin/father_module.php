<?php
	include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
	$link = connect();
	include_once "./inc/tools.inc.php";
	
	// 排序
	if (isset($_POST['submit'])) {
		foreach ($_POST['sort'] as $key => $val) {
			if (!is_numeric($val) || !is_numeric($key)) {
				skip('排序参数错误！', 'error', 'father_module.php');
			}
			$query[]="update bbs_father_module set sort={$val} where id={$key}";
		}
		if(query_multi($link, $query, $error)){
			skip('排序修改成功！', 'ok', 'father_module.php');
		}else{
			skip($error, 'error', 'father_module.php');
		}
	}

	$template['title']='父板块列表';
    $template['css']=array('style/public.css');
	include_once "./inc/header.inc.php";
?>
<div id="main">
	<div class="title">父板块列表</div>
	<form action="" method="post">
		<table class="list">
			<tr>
				<th>排序</th>
				<th>版块名称</th>
				<th>版主</th>
				<th>创建时间</th>
				<th>修改时间</th>
				<th>操作</th>
			</tr>
			<?php
				$query = "select father.id father_id, father.module_name, father.sort, father.manage_id, father.create_time, father.last_time, manage.id, manage.name from bbs_father_module father, bbs_manage manage where father.manage_id = manage.id order by sort ASC";
				$result = query_sql($link, $query);
				while($data = mysqli_fetch_assoc($result)) {
					$url=urlencode("father_module_delete.php?id={$data['father_id']}");
					$return_url=urlencode($_SERVER['REQUEST_URI']);
					$message="你真的要删除父版块 {$data['module_name']} 吗？";
					$delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
$html = <<<html
					<tr>
						<td><input class="sort" value="{$data['sort']}" type="text" name="sort[{$data['father_id']}]" /></td>
						<td>{$data['module_name']}[id:{$data['father_id']}]</td>
						<td>{$data['name']}</td>
						<td>{$data['create_time']}</td>
						<td>{$data['last_time']}</td>
						<td><a href="father_module_update.php?id={$data['father_id']}">[编辑]</a>&nbsp;&nbsp;<a href="{$delete_url}">[删除]</a></td>
					</tr>
html;
					echo $html;
				}
			?>
		</table>
		<input class="btn" type="submit" name="submit" value="排序" />
	</form>
</div>
<?php
    include_once "./inc/footer.inc.php";
?>