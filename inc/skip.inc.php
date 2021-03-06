<?php
    /**
     * $title  提示
     * $status 状态
     * $url    成功跳转路径
     */
    function skip($title, $status, $url) {
        $title = htmlspecialchars($title);
$html = <<<html
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <meta http-equiv="refresh" content="3; url={$url}">
            <link rel="stylesheet" type="text/css" href="style/remind.css" />
            <title>正在跳转中...</title>
        </head>
        <body>
         <div class="notice"><span class="pic {$status}"></span> {$title} <a href="{$url}">3秒后自动跳转中!</a></div>
        </body>
        </html>
html;
        echo $html;
        exit();
    }
    
    // 验证后台管理员是否登录
    function is_manage_login($link) {
        if (isset($_SESSION['manage']['name']) && isset($_SESSION['manage']['pass'])) {
            $query = "select * from bbs_manage where name='{$_SESSION['manage']['name']}' and pass='{$_SESSION['manage']['pass']}'";
            $result = query_sql($link, $query);
            if (mysqli_num_rows($result)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
?>