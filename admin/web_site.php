<?php
    include_once "../inc/config.inc.php";
    include_once "../inc/skip.inc.php";
    $link = connect();

    
    $quert = "select * from web_site where id=1";
    $result = query_sql($link, $quert);
    $data = mysqli_fetch_assoc($result);
    if (isset($_POST['submit'])) {
        // 转义入库
        $_POST = escape($link, $_POST);
        $title = $_POST['title'];
        $keyword = $_POST['keyword'];
        $description = $_POST['description'];
        if (empty($title) || strlen($title) > 66) {
            skip('标题不能为空并且不能大于66位','error','web_site.php');
        }
        if (empty($keyword) || strlen($keyword) > 66) {
            skip('关键字不能为空并且不能大于66位','error','web_site.php');
        }
        if (empty($description) || strlen($description) > 99) {
            skip('描述不能为空并且不能大于99位','error','web_site.php');
        }
        $query = "update web_site set title='{$title}', keyword='{$keyword}', description='{$description}', create_time=now() where id=1";
        $result = query_sql($link, $query);
        if ($result) {
            skip('修改成功','ok','web_site.php');
        } else {
            skip('修改失败','error','web_site.php');
        }
    }
?>
<?php
    $template['title']='站点设置';
    $template['css']=array('style/public.css');
    include_once "./inc/header.inc.php";
?>
<div id="main">
    <div class="title">站点设置</div>
    <form action="" method="post">
        <table class="au">
            <tr>
                <td>网站标题</td>
                <td><input type="text" name="title" value="<?php echo $data['title'] ?>" /></td>
                <td>
                    前台页面的标题
                </td>
            </tr>
            <tr>
                <td>网站关键字</td>
                <td><input type="text" name="keyword" value="<?php echo $data['keyword'] ?>" /></td>
                <td>
                    关键字
                </td>
            </tr>
            <tr>
                <td>网站描述</td>
                <td><textarea name="description"><?php echo $data['description'] ?></textarea></td>
                <td>
                    网站描述
                </td>
            </tr>
        </table>
        <input class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>
<?php
    include_once "./inc/footer.inc.php";
?>