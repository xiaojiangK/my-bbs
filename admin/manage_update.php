<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();
    include_once "./inc/is_login.inc.php";

	if (!is_login($link)) {
        skip('你还没登录，请登录！', 'error', 'login.php');
    }

    // 验证参数
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	    skip('id参数错误！','error','manage.php');
    }

    // 获取管理员信息
    $query = "select * from bbs_manage where id={$_GET['id']}";
    $result = query_sql($link, $query);
    $data = mysqli_fetch_assoc($result);
    if (!$data['id']) {
        skip('管理员不存在！','error','manage.php');
    }

    $url = basename($_SERVER['REQUEST_URI']);
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $pass = $_POST['pass'];
        $level = $_POST['level'];
        if (empty($name) || strlen($name) > 32) {
            skip('名称不得为空，不得超过32个字符', 'error', $url);
        }
        if (strlen($pass) < 6 || strlen($pass) > 18) {
            skip('密码不能少于6位或大于18位', 'error', $url);
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
        // 编辑入库
        $_POST = escape($link, $_POST);
        $query = "update bbs_manage set name='{$_POST['name']}', pass=md5('{$_POST['pass']}'), level={$_POST['level']}, last_time=now() where id={$_GET['id']}";
        $result = query_sql($link, $query);
        if (mysqli_affected_rows($link)) {
            skip('恭喜你，编辑成功！','ok','manage.php');
        } else {
            skip('对不起，编辑失败，请重试！','error',$url);
        }
    }

    $template['title']='编辑管理员';
    $template['css']=array('style/public.css');
    include_once "inc/header.inc.php";
?>
<div id="main">
    <div class="title">编辑管理员</div>
    <form action="" method="post">
        <table class="au">
            <tr>
                <td>管理员名称</td>
                <td><input type="text" maxLength="32" value="<?php echo $data['name']?>" name="name" placeholder="请输入管理员名称" /></td>
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
                        <option value="1" <?php if($data['level'] == 1) echo selected ?>>普通会员</option>
                        <option value="0" <?php if($data['level'] == 0) echo selected ?>>超级会员</option>
                    </select>
                </td>
                <td>
                    默认为普通管理员（不具备，后台管理员管理权限）
                </td>
            </tr>
        </table>
        <input class="btn" type="submit" name="submit" value="确认" />
    </form>
</div>
<?php
    include_once "./inc/footer.inc.php";
?>