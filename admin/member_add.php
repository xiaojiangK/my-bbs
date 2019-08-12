<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();
    include_once "./inc/tools.inc.php";

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $pass = $_POST['pass'];
        $sort = $_POST['sort'];
        if (empty($name) || strlen($name) > 32) {
            skip('名称不得为空，不得超过32个字符', 'error', 'member_add.php');
        }
        if (empty($sort) || strlen($sort) > 32) {
            skip('排序不得为空，不得超过32个字符', 'error', 'member_add.php');
        }
        if (strlen($pass) < 6 || strlen($pass) > 18) {
            skip('密码不能少于6位或大于18位', 'error', 'member_add.php');
        }
        // 检测是否同名
        $_POST = escape($link, $_POST);
        $query = "select name from bbs_member where name='{$_POST['name']}'";
        if (query_num($link, $query)) {
            skip('这个名称已经有了，请重新输入', 'error', 'member_add.php');
        }

        // 添加入库
        $query = "insert into bbs_member(name, pass, sort, create_time) values('{$_POST['name']}', md5('{$_POST['pass']}'),  {$_POST['sort']}, now())";
        $result = query_sql($link, $query);
        if (mysqli_affected_rows($link)) {
            skip('恭喜你，添加成功！','ok','member.php');
        } else {
            skip('对不起，添加失败，请重试！','error','member_add.php');
        }
    }

    $template['title']='添加会员';
    $template['css']=array('style/public.css');
    include_once "inc/header.inc.php";
?>
<div id="main">
    <div class="title">添加会员</div>
    <form action="" method="post">
        <table class="au">
            <tr>
                <td>会员名称</td>
                <td><input type="text" maxLength="32" name="name" placeholder="请输入会员名称" /></td>
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
                <td>排序</td>
                <td><input type="text" maxLength="32" name="sort" /></td>
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