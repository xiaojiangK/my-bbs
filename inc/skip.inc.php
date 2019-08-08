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
            <title>正在跳转中...</title>
        </head>
        <body>
            <a hrer="{$url}">{$status} - {$title}</a>
        </body>
        </html>
html;
        echo $html;
        exit();
    }
?>