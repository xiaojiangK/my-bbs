<?php
    $template['title']='帖子列表';
    $template['css']=array('style/public.css');
    include_once "./inc/header.inc.php";
?>
<div id="main">
    <div class="title">帖子列表</div>
	<table class="list">
		<tr>
			<th>排序</th>	 	 	
			<th>版块名称</th>
			<th>版主</th>
			<th>操作</th>
		</tr>
		<tr>
			<td><input class="sort" type="text" name="sort" /></td>
			<td>测试板块[id:1]</td>
			<td>孙胜利</td>
			<td><a href="#">[访问]</a>&nbsp;&nbsp;<a href="#">[编辑]</a>&nbsp;&nbsp;<a href="#">[删除]</a></td>
		</tr>
		<tr>
			<td><input class="sort" type="text" name="sort" /></td>
			<td>测试板块[id:2]</td>
			<td>孙胜利</td>
			<td><a href="#">[访问]</a>&nbsp;&nbsp;<a href="#">[编辑]</a>&nbsp;&nbsp;<a href="#">[删除]</a></td>
		</tr>
		<tr>
			<td><input class="sort" type="text" name="sort" /></td>
			<td>测试板块[id:3]</td>
			<td>孙胜利</td>
			<td><a href="#">[访问]</a>&nbsp;&nbsp;<a href="#">[编辑]</a>&nbsp;&nbsp;<a href="#">[删除]</a></td>
		</tr>
	</table>
	<input class="btn" type="submit" name="submit" value="排序" />
</div>
<?php
    include_once "./inc/footer.inc.php";
?>