<?php
    $template['title']='添加管理员';
    $template['css']=array('style/public.css');
    include_once "./inc/header.inc.php";
?>
<div id="main">
    <div class="title">添加管理员</div>
    <table class="au">
        <tr>
            <td>版块名称</td>
            <td><input type="text" /></td>
            <td>
                支持HTML代码
            </td>
        </tr>
        <tr>
            <td>版块名称</td>
            <td><input type="text" /></td>
            <td>
                支持HTML代码
            </td>
        </tr>
        <tr>
            <td>版块名称</td>
            <td><input type="text" /></td>
            <td>
                支持HTML代码
            </td>
        </tr>
    </table>
    <input class="btn" type="submit" name="submit" value="添加" />
</div>
<?php
    include_once "./inc/footer.inc.php";
?>