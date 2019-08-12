<?php
	include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();
	include_once "./inc/tools.inc.php";

    // 验证参数
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        skip('id参数错误！','error','son_module.php');
    }

    // 获取子版块
    $query = "select * from bbs_son_module where id={$_GET['id']}";
    $result = query_sql($link, $query);
    $data = mysqli_fetch_assoc($result);
    if (!$data['id']) {
        skip('子版块不存在！','error','son_module.php');
    }
    
    if (isset($_POST['submit'])) {
        $url = basename($_SERVER['REQUEST_URI']);
        $father_id = $_POST['father_id'];
        $member_id = $_POST['member_id'];
        $module_name = $_POST['name'];
        $info = $_POST['info'];
        $sort = $_POST['sort'];
        if (!is_numeric($father_id) || $father_id < 1) {
            skip('所属父版块不得为空！', 'error', $url);
        }
        if (empty($module_name) || strlen($module_name) > 32) {
            skip('版块名称不得为空，最大不得超过32个字符', 'error', $url);
        }
        if (empty($info) || strlen($info) > 32) {
            skip('简介不得多于255个字符', 'error', $url);
        }
        if (!is_numeric($member_id) || $member_id < 1) {
            skip('所属版主不得为空！', 'error', $url);
        }
        if (!is_numeric($sort)) {
            skip('排序只能是数字！', 'error', $url);
        }

        $query = "select * from bbs_father_module where id={$father_id}";
        $result = query_sql($link, $query);
        if (mysqli_num_rows($result) == 0) {
            skip('所属父版块不存在！', 'error', $url);
        }

        $query = "select * from bbs_member where id={$member_id}";
        $result = query_sql($link, $query);
        if (mysqli_num_rows($result) == 0) {
            skip('所属版主不存在！', 'error', $url);
        }

        // 编辑入库
        $_POST = escape($link, $_POST);
        $query = "update bbs_son_module set father_module_id={$_POST['father_id']}, module_name='{$_POST['name']}', info='{$_POST['info']}', member_id={$_POST['member_id']}, sort={$_POST['sort']}, last_time=now()";
        $result = query_sql($link, $query);
        if (mysqli_affected_rows($link)) {
            skip('恭喜你，编辑成功！', 'ok', 'son_module.php');
        } else {
            skip('对不起，编辑失败，请重试！', 'error', $url);
        }
    }

    $template['title']='编辑子板块';
    $template['css']=array('style/public.css');
    include_once "./inc/header.inc.php";
?>
<div id="main">
    <div class="title">编辑子板块</div>
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
                                if ($data_father['id'] == $data['father_module_id']) {
                                    echo "<option selected='selected' value='{$data_father['id']}'>{$data_father['module_name']}</option>";
                                } else {
                                    echo "<option value='{$data_father['id']}'>{$data_father['module_name']}</option>";
                                }
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
				<td><input name="name" value="<?php echo $data['module_name']?>" maxLength="32" type="text" /></td>
				<td>
					版块名称不得为空，最大不得超过32个字符
				</td>
			</tr>
			<tr>
				<td>版块简介</td>
				<td>
					<textarea name="info" maxLength="255"><?php echo $data['info']?></textarea>
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
                            while ($data_member = mysqli_fetch_assoc($result)){
                                if ($data_member['id'] == $data['member_id']) {
                                    echo "<option selected='selected' value='{$data_member['id']}'>{$data_member['name']}</option>";
                                } else {
                                    echo "<option value='{$data_member['id']}'>{$data_member['name']}</option>";
                                }
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
				<td><input name="sort" value="<?php echo $data['sort']?>" type="number" /></td>
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