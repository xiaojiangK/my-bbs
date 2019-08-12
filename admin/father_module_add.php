<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
	$link = connect();
    include_once "./inc/tools.inc.php";

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $sort = $_POST['sort'];
        if (empty($name) || strlen($name) > 32) {
            skip('名称不得为空，不得超过32个字符', 'error', 'father_module_add.php');
        }
        if (empty($sort) || strlen($sort) > 32) {
            skip('排序不得为空，不得超过32个字符', 'error', 'father_module_add.php');
        }
        // 检测是否同名
        $_POST = escape($link, $_POST);
        $query = "select * from bbs_father_module where module_name='{$_POST['name']}'";
        if (query_num($link, $query)) {
            skip('这个父板块已经有了，请重新输入', 'error', 'father_module_add.php');
        }

        // 添加
        $query = "insert into bbs_father_module(module_name, manage_id, sort, create_time) values('{$_POST['name']}', {$_SESSION['manage']['id']}, {$_POST['sort']}, now())";
        $result = query_sql($link, $query);
        if (mysqli_affected_rows($link) == 1) {
            skip('恭喜您，添加成功！', 'ok', 'father_module.php');
        } else {
            skip('对不起，添加失败，请重试！', 'error', 'father_module_add.php');
        }
    }

	$template['title']='添加父板块';
    $template['css']=array('style/public.css');
	include_once "./inc/header.inc.php";
?>
<div id="main">
    <div class="title">添加父板块</div>
    <form action="" method="post">
        <table class="au">
            <tr>
                <td>版块名称</td>
                <td><input type="text" maxLenth="32" name="name" placeholder="请输入版块名称" /></td>
                <td>
                    名称不得为空，不得超过32个字符
                </td>
            </tr>
            <tr>
                <td>排序</td>
                <td><input type="number" maxLenth="32" name="sort" /></td>
                <td>
                    排序不得为空，不得超过32个字符
                </td>
            </tr>
        </table>
        <input class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>
<?php
    include_once "./inc/footer.inc.php";
?>