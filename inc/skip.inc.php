<?php
    function skip($title, $status, $url) {
$html = <<<html
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <meta http-equiv="refresh" content="3; url={$url}">
            <link rel="stylesheet" type="text/css" href="../style/remind.css" />
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
?>