<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();
    include_once "./inc/tools.inc.php";

    if (isset($_POST['submit'])) {
        $father_id = $_POST['father_id'];
        $member_id = $_POST['member_id'];
        $module_name = $_POST['name'];
        $info = $_POST['info'];
        $sort = $_POST['sort'];
        if (!is_numeric($father_id) || $father_id < 1) {
            skip('所属父版块不得为空！', 'error', 'son_module_add.php');
        }
        if (empty($module_name) || strlen($module_name) > 32) {
            skip('版块名称不得为空，最大不得超过32个字符', 'error', 'son_module_add.php');
        }
        if (empty($info) || strlen($info) > 32) {
            skip('简介不得多于255个字符', 'error', 'son_module_add.php');
        }
        if (!is_numeric($member_id) || $member_id < 1) {
            skip('所属版主不得为空！', 'error', 'son_module_add.php');
        }
        if (!is_numeric($sort)) {
            skip('排序只能是数字！', 'error', 'son_module_add.php');
        }

        $query = "select * from bbs_father_module where id={$father_id}";
        $result = query_sql($link, $query);
        if (mysqli_num_rows($result) == 0) {
            skip('所属父版块不存在！', 'error', 'son_module_add.php');
        }

        $query = "select * from bbs_member where id={$member_id}";
        $result = query_sql($link, $query);
        if (mysqli_num_rows($result) == 0) {
            skip('所属版主不存在！', 'error', 'son_module_add.php');
        }

        // 添加
        $_POST = escape($link, $_POST);
        $query = "insert into bbs_son_module(father_module_id, module_name, info, member_id, sort, create_time) values({$_POST['father_id']}, '{$_POST['name']}', '{$_POST['info']}', {$_POST['member_id']}, {$_POST['sort']}, now())";
        $result = query_sql($link, $query);
        if (mysqli_affected_rows($link) == 1) {
            skip('恭喜你，添加成功！', 'ok', 'son_module.php');
        } else {
            skip('对不起，添加失败，请重试！','error','son_module.php');
        }
    }

    $template['title']='添加子板块';
    $template['css']=array('style/public.css');
    include_once "./inc/header.inc.php";
?>
<div id="main">
    <div class="title">添加子板块</div>
    <form action="" method="post">
        <table class="au">
			<tr>
				<td>所属父版块</td>
				<td>
					<select name="father_id">
						<option value="0">======请选择一个父版块======</option>
						<?php 
                            $query = "select * from bbs_father_module";
                            $result = query_sql($link,$query);
                            while ($data_father = mysqli_fetch_assoc($result)){
                                echo "<option value='{$data_father['id']}'>{$data_father['module_name']}</option>";
                            }
						?>
					</select>
				</td>
				<td>
					必须选择一个所属的父版块
				</td>
			</tr>
			<tr>
				<td>版块名称</td>
				<td><input name="name" maxLength="32" type="text" /></td>
				<td>
					版块名称不得为空，最大不得超过32个字符
				</td>
			</tr>
			<tr>
				<td>版块简介</td>
				<td>
					<textarea name="info" maxLength="255"></textarea>
				</td>
				<td>
					简介不得多于255个字符
				</td>
			</tr>
			<tr>
				<td>版主</td>
				<td>
					<select name="member_id">
                        <option value="0">======请选择一个会员作为版主======</option>
						<?php 
                            $query = "select * from bbs_member";
                            $result = query_sql($link,$query);
                            while ($data_mumber = mysqli_fetch_assoc($result)){
                                echo "<option value='{$data_mumber['id']}'>{$data_mumber['name']}</option>";
                            }
						?>
					</select>
				</td>
				<td>
					你可以在这边选一个会员作为版主
				</td>
			</tr>
			<tr>
				<td>排序</td>
				<td><input name="sort" value="0" type="number" /></td>
				<td>
					填写一个数字即可
				</td>
			</tr>
        </table>
        <input class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>
<?php
    include_once "./inc/footer.inc.php";
?>