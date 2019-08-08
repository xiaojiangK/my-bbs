<?php
    header('Content-type:text/html;charset=utf-8');
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASS', 'root');
    define('DATABASE', 'mybbs');
    define('PORT', 3306);

    function connect($host=HOST, $user=USER, $pass=PASS, $database=DATABASE, $port=PORT) {
        $link = @mysqli_connect($host, $user, $pass, $database, $port);
        if (mysqli_connect_errno($link)) {
            exit(mysqli_connect_error());
        }
        mysqli_set_charset($link, 'utf-8');
        return $link;
    }
?>