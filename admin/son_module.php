<?php
	include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();
	include_once "./inc/tools.inc.php";

	// 排序
	if (isset($_POST['submit'])) {
		foreach ($_POST['sort'] as $key => $val) {
			if (!is_numeric($val) || !is_numeric($key)) {
				skip('排序参数错误！', 'error', 'son_module.php');
			}
			$query[]="update bbs_son_module set sort={$val} where id={$key}";
		}
		if(query_multi($link, $query, $error)){
			skip('排序修改成功！', 'ok', 'son_module.php');
		}else{
			skip($error, 'error', 'son_module.php');
		}
	}

    $template['title']='子板块列表';
    $template['css']=array('style/public.css');
    include_once "./inc/header.inc.php";
?>
<div id="main">
	<div class="title">子板块列表</div>
	<form action="" method="post">
		<table class="list">
			<tr>
				<th>排序</th>	 	 	
				<th>版块名称</th>
				<th>所属父版块</th>
				<th>版主</th>
				<th>创建时间</th>
				<th>修改时间</th>
				<th>操作</th>
			</tr>
			<?php
				$query = "select son.id son_id, son.father_module_id, son.module_name, son.member_id, son.sort, son.create_time, son.last_time, father.id, father.module_name father_name from bbs_son_module son, bbs_father_module father where son.father_module_id = father.id";
				$result = query_sql($link, $query);
				while($data = mysqli_fetch_assoc($result)) {
					$url=urlencode("son_module_delete.php?id={$data['son_id']}");
					$return_url=urlencode($_SERVER['REQUEST_URI']);
					$message="你真的要删除子版块 {$data['module_name']} 吗？";
					$delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
$html = <<<html
					<tr>
						<td><input class="sort" type="text" value="{$data['sort']}" name="sort[{$data['son_id']}]" /></td>
						<td>{$data['module_name']}[id:{$data['son_id']}]</td>
						<td>{$data['father_name']}</td>
						<td>{$data['member_id']}</td>
						<td>{$data['create_time']}</td>
						<td>{$data['last_time']}</td>
						<td><a href="son_module_update.php?id={$data['son_id']}">[编辑]</<a>&nbsp;&nbsp;<a href="{$delete_url}">[删除]</a></td>
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