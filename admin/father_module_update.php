<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();
    include_once "./inc/tools.inc.php";

    // 验证参数
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        skip('id参数错误！','error','father_module.php');
    }
    
    // 获取父板块
    $query = "select * from bbs_father_module where id={$_GET['id']}";
    $result = query_sql($link, $query);
    $data = mysqli_fetch_assoc($result);
    if (!$data['id']) {
        skip('父板块不存在！','error','manage.php');
    }

    if (isset($_POST['submit'])) {
        $sort = $_POST['sort'];
        $module_name = $_POST['name'];
        $url = basename($_SERVER['REQUEST_URI']);
        if (empty($module_name) || strlen($module_name) > 32) {
            skip('名称不得为空，不得超过32个字符', 'error', $url);
        }
        if (empty($sort) || strlen($sort) > 32) {
            skip('排序不得为空，不得超过32个字符', 'error', $url);
        }

        // 编辑入库
        $_POST = escape($link, $_POST);
        $query = "update bbs_father_module set module_name='{$_POST['name']}', sort={$_POST['sort']}, last_time=now() where id={$_GET['id']}";
        $result = query_sql($link, $query);
        if (mysqli_affected_rows($link)) {
            skip('恭喜你，编辑成功！','ok','father_module.php');
        } else {
            skip('对不起，编辑失败，请重试！','error',$url);
        }
    }

    $template['title']='编辑父板块';
    $template['css']=array('style/public.css');
    include_once "inc/header.inc.php";
?>
<div id="main">
    <div class="title">编辑父板块</div>
    <form action="" method="post">
        <table class="au">
            <tr>
                <td>版块名称</td>
                <td><input type="text" maxLength="32" value="<?php echo $data['module_name']?>" name="name" placeholder="请输入版块名称" /></td>
                <td>
                    名称不得为空，不得超过32个字符
                </td>
            </tr>
            <tr>
                <td>排序</td>
                <td><input type="text" maxLength="32" value="<?php echo $data['sort']?>" name="sort" /></td>
                <td>
                    排序不得为空，不得超过32个字符
                </td>
            </tr>
        </table>
        <input class="btn" type="submit" name="submit" value="确认" />
    </form>
</div>
<?php
    include_once "./inc/footer.inc.php";
?>