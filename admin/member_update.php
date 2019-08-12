<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();
    include_once "./inc/tools.inc.php";

    // 验证参数
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        skip('id参数错误！','error','member.php');
    }
    
    // 获取会员信息
    $query = "select * from bbs_member where id={$_GET['id']}";
    $result = query_sql($link, $query);
    $data = mysqli_fetch_assoc($result);
    if (!$data['id']) {
        skip('会员信息不存在！','error','manage.php');
    }

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $pass = $_POST['pass'];
        $sort = $_POST['sort'];
        $url = basename($_SERVER['REQUEST_URI']);
        if (empty($name) || strlen($name) > 32) {
            skip('名称不得为空，不得超过32个字符', 'error', $url);
        }
        if (strlen($pass) < 6 || strlen($pass) > 18) {
            skip('密码不能少于6位或大于18位', 'error', $url);
        }
        if (empty($sort) || strlen($sort) > 32) {
            skip('排序不得为空，不得超过32个字符', 'error', $url);
        }
        // 编辑入库
        $_POST = escape($link, $_POST);
        $query = "update bbs_member set name='{$_POST['name']}', pass=md5('{$_POST['pass']}'), sort={$_POST['sort']}, last_time=now() where id={$_GET['id']}";
        $result = query_sql($link, $query);
        if (mysqli_affected_rows($link)) {
            skip('恭喜你，编辑成功！','ok','member.php');
        } else {
            skip('对不起，编辑失败，请重试！','error',$url);
        }
    }

    $template['title']='编辑会员信息';
    $template['css']=array('style/public.css');
    include_once "inc/header.inc.php";
?>
<div id="main">
    <div class="title">编辑会员信息</div>
    <form action="" method="post">
        <table class="au">
            <tr>
                <td>会员名称</td>
                <td><input type="text" maxLength="32" value="<?php echo $data['name']?>" name="name" placeholder="请输入会员名称" /></td>
                <td>
                    名称不得为空，不得超过32个字符
                </td>
            </tr>
            <tr>
                <td>密码</td>
                <td><input type="password" maxLength="32" name="pass" /></td>
                <td>
                    密码不得为空，不得超过32个字符
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