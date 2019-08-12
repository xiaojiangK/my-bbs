<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();
    include_once "./inc/tools.inc.php";

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $pass = $_POST['pass'];
        $level = $_POST['level'];
        if (empty($name) || strlen($name) > 32) {
            skip('名称不得为空，不得超过32个字符', 'error', 'manage_add.php');
        }
        if (strlen($pass) < 6 || strlen($pass) > 18) {
            skip('密码不能少于6位或大于18位', 'error', 'manage_add.php');
        }
        if (!isset($level)) {
            $level = 1;
        } else if ($level == '1') {
            $level = 1;
        }  else if ($level == '0') {
            $level = 0;
        } else {
            $level = 1;
        }
        // 检测是否同名
        $_POST = escape($link, $_POST);
        $query = "select name from bbs_manage where name='{$_POST['name']}'";
        if (query_num($link, $query)) {
            skip('这个名称已经有了，请重新输入', 'error', 'manage_add.php');
        }

        // 添加入库
        $query = "insert into bbs_manage(name, pass, create_time, level) values('{$_POST['name']}', md5('{$_POST['pass']}'), now(), {$_POST['level']})";
        $result = query_sql($link, $query);
        if (mysqli_affected_rows($link)) {
            skip('恭喜你，添加成功！','ok','manage.php');
        } else {
            skip('对不起，添加失败，请重试！','error','manage_add.php');
        }
    }

    $template['title']='添加管理员';
    $template['css']=array('style/public.css');
    include_once "inc/header.inc.php";
?>
<div id="main">
    <div class="title">添加管理员</div>
    <form action="" method="post">
        <table class="au">
            <tr>
                <td>管理员名称</td>
                <td><input type="text" maxLength="32" name="name" placeholder="请输入管理员名称" /></td>
                <td>
                    名称不得为空，不得超过32个字符
                </td>
            </tr>
            <tr>
                <td>密码</td>
                <td><input type="text" maxLength="18" name="pass" /></td>
                <td>
                    密码不能少于6位或大于18位
                </td>
            </tr>
            <tr>
                <td>等级</td>
                <td>
                    <select name="level">
                        <option value="1">普通会员</option>
                        <option value="0">超级会员</option>
                    </select>
                </td>
                <td>
                    默认为普通管理员（不具备，后台管理员管理权限）
                </td>
            </tr>
        </table>
        <input class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>
<?php
    include_once "./inc/footer.inc.php";
?>