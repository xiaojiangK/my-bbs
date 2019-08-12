<?php
	include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
	$link = connect();
	include_once "./inc/tools.inc.php";

	// 排序
	if (isset($_POST['submit'])) {
		foreach ($_POST['sort'] as $key => $val) {
			if (!is_numeric($val) || !is_numeric($key)) {
				skip('排序参数错误！', 'error', 'member.php');
			}
			$query[]="update bbs_member set sort={$val} where id={$key}";
		}
		if(query_multi($link, $query, $error)){
			skip('排序修改成功！', 'ok', 'member.php');
		}else{
			skip($error, 'error', 'member.php');
		}
	}

	$template['title']='会员列表';
    $template['css']=array('style/public.css');
	include_once "./inc/header.inc.php";
?>
<div id="main">
	<div class="title">会员列表</div>
	<form action="" method="post">
		<table class="list">
			<tr>
				<th>排序</th>	 	 	
				<th>会员名称</th>
				<th>会员头像</th>
				<th>创建时间</th>
				<th>修改时间</th>
				<th>操作</th>
			</tr>
			<?php
				$query = "select * from bbs_member";
				$result = query_sql($link, $query);
				while($data=mysqli_fetch_assoc($result)) {
					$url=urlencode("member_delete.php?id={$data['id']}");
					$return_url=urlencode($_SERVER['REQUEST_URI']);
					$message="你真的要删除会员 {$data['name']} 吗？";
					$delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
					if ($data['photo']) {
						$data['photo'] = "<img src='{$data['photo']}' alt='会员头像' />";
					} else {
						$data['photo'] = "暂无头像";
					}
$html = <<<html
					<tr>
						<td><input class="sort" type="text" value="{$data['sort']}" name="sort[{$data['id']}]" /></td>
						<td>{$data['name']}[id:{$data['id']}]</td>
						<td>{$data['photo']}</td>
						<td>{$data['create_time']}</td>
						<td>{$data['last_time']}</td>
						<td><a href="member_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href="{$delete_url}">[删除]</a></td>
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