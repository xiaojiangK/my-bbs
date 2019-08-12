<?php
    session_start();
    header('Content-type:text/html;charset=utf-8');
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASS', 'root');
    define('DATABASE', 'mybbs');
    define('PORT', 3306);
    // 我们的项目（程序），在服务器上的绝对路径
    define('ROOT_PATH', dirname(dirname(__FILE__)));
    //我们的项目在web根目录下面的位置（哪个目录里面）
    define('SUB_URL',str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\','/',ROOT_PATH)).'/');

    // 数据库连接
    function connect($host=HOST, $user=USER, $pass=PASS, $database=DATABASE, $port=PORT) {
        $link = @mysqli_connect($host, $user, $pass, $database, $port);
        if (mysqli_connect_errno($link)) {
            exit(mysqli_connect_error());
        }
        mysqli_set_charset($link, 'utf-8');
        return $link;
    }

    // 执行一条sql语句
    function query_sql($link, $query) {
        $result = mysqli_query($link, $query);
        if (mysqli_errno($link)) {
            exit(mysqli_error($link));
        }
        return $result;
    }

    // 执行一条sql语句，返回布尔值
    function query_bool($link, $query) {
        $bool = mysqli_real_query($link,$query);
        if (mysqli_errno($link)) {
            exit(mysqli_error($link));
        }
        return $bool;
    }

    //一次性执行多条SQL语句
    /*
     一次性执行多条SQL语句
    $link：连接
    $arr_sqls：数组形式的多条sql语句
    $error：传入一个变量，里面会存储语句执行的错误信息
    使用案例：
    $arr_sqls=array(
        'select * from sfk_father_module',
        'select * from sfk_father_module',
        'select * from sfk_father_module',
        'select * from sfk_father_module'
    );
    var_dump(query_multi($link, $arr_sqls, $error));
    echo $error;
    */
    function query_multi($link,$arr_sqls,&$error){
        $sqls=implode(';',$arr_sqls).';';
        if(mysqli_multi_query($link,$sqls)){
            $data=array();
            $i=0;//计数
            do {
                if($result=mysqli_store_result($link)){
                    $data[$i]=mysqli_fetch_all($result);
                    mysqli_free_result($result);
                }else{
                    $data[$i]=null;
                }
                $i++;
                if(!mysqli_more_results($link)) break;
            }while (mysqli_next_result($link));
            if($i==count($arr_sqls)){
                return $data;
            }else{
                $error="sql语句执行失败：<br />&nbsp;数组下标为{$i}的语句:{$arr_sqls[$i]}执行错误<br />&nbsp;错误原因：".mysqli_error($link);
                return false;
            }
        }else{
            $error='执行失败！请检查首条语句是否正确！<br />可能的错误原因：'.mysqli_error($link);
            return false;
        }
    }

    // 获取记录数
    function query_num($link, $query) {
        $result = query_sql($link, $query);
        $count = mysqli_fetch_row($result);
        return $count[0];
    }

    // 数据入库之前进行转义，确保，数据能够顺利的入库
    function escape($link, $data) {
        if (is_string($data)) {
            return mysqli_real_escape_string($link, $data);
        }
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $data[$key] = escape($link, $val);
            }
        }
        return $data;
    }

    // 关闭数据库
    function close_db($link) {
        mysqli_close($link);
    }
?>