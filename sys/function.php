<?php

function sql_get($db, $sql='', $exec, $fetchall=PDO::FETCH_ASSOC)
{    
    $rs = $db->prepare($sql);
    $rs->execute($exec);
    return $rs->fetchAll($fetchall);
}

function view($str)
{
    $str = str_replace('.', '/', $str);
    return _DIR_.'/'.Views.'/'.$str.'.php';
}

function read_file($filename = "test")
{
    $arr = array();
    //判斷是否有該檔案
    if(file_exists($filename)){
        $file = fopen($filename, "r");
        if($file != NULL){
            //當檔案未執行到最後一筆，迴圈繼續執行(fgets一次抓一行)
            while (!feof($file)) {
                $arr[] = fgets($file);
            }
            fclose($file);
        }
    }
    return $arr;
}

function write_file($filename = "test.xml", $str)
{
    $file = fopen($filename,"a+"); //開啟檔案
    fwrite($file, $str);
    fclose($file);
}

/**
 * Get an item from an array using "dot" notation.
 */
function array_get($array, $key, $default = null)
{
    $result = array_keys($array, $key);
    return (isset($result) && !is_null($result))? $result : $default;
}

/**
 * Get an item from an array or object using "dot" notation.
 */
function data_get($target, $key, $default = null)
{
    // key 是空的就直接回傳
    if (is_null($key)) {
        return $target;
    }

    // key 除了用 `.` 區隔外，也可以使用 array
    $key = is_array($key) ? $key : explode('.', $key);

    // 將 key 一個一個拿出來跑 
    while (! is_null($segment = array_shift($key))) {
        // 如果是 * 的話
        if ($segment === '*') {
            if (! is_array($target)) {
                // 如果不是 Collection，也不是 array 的話，代表取資料的 key 有問題，直接回預設值
                return $default;
            }

            // 依 key 取得裡面的 value，然後重組成 array
            $result = array_keys($target, $key);
            
            return $result;
        }

        if (is_array($target) && array_key_exists($segment, $target)) {
            // 如果 $target 是個 array 且有資料的話，就使用 array 方法取資料
            $target = $target[$segment];
        } elseif (is_object($target) && isset($target->{$segment})) {
            // 如果 $target 是個 object 且有資料的話，就使用 object 方法取資料
            $target = $target->{$segment};
        } else {
            // 都不是的話，key 是有問題的，只好回傳預設值
            return $default;
        }
    }
    
    // 回傳最後取到的 target
    return $target;
}

/**
 * Get an item from an object using "dot" notation.
 */
function object_get($object, $key, $default = null)
{
    // 如果 key 是空的，就把整個 object 回傳
    if (is_null($key) || trim($key) == '') {
        return $object;
    }
    
    // 依續把每個階層的 key，用來取得 object 的屬性
    foreach (explode('.', $key) as $segment) {
        // 如果不是 object 或屬性不存在的時候，就回傳預設值
        if (! is_object($object) || ! isset($object->{$segment})) {
            return $default;
        }
        
        // 重設 object 為下一個階層
        $object = $object->{$segment};
    }
    
    // 最後取得的 property 即結果
    return $object;
}

function cc()
{
    try{

        die();

    } catch( Exception $e) {
        $mess = array('statue' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode() );
        write_file('logs/file.txt', json_encode($mess, JSON_UNESCAPED_UNICODE));
        return $mess;
    }
    return array('statue' => 1, 'message' => $e->getMessage(), 'code' => $e->getCode() );
}


/*
 * How to write own DD() function same as laravel?
 */ 
function d($data){
    if(is_null($data)){
        $str = "<i>NULL</i>";
    }elseif($data == ""){
        $str = "<i>Empty</i>";
    }elseif(is_array($data)){
        if(count($data) == 0){
            $str = "<i>Empty array.</i>";
        }else{
            $str = "<table style=\"border-bottom:0px solid #000;\" cellpadding=\"0\" cellspacing=\"0\">";
            foreach ($data as $key => $value) {
                $str .= "<tr><td style=\"background-color:#008B8B; color:#FFF;border:1px solid #000;\">" . $key . "</td><td style=\"border:1px solid #000;\">" . d($value) . "</td></tr>";
            }
            $str .= "</table>";
        }
    // }elseif(is_resource($data)){
        // while($arr = mysql_fetch_array($data)){
        //     $data_array[] = $arr;
        // }
        // $str = d($data_array);
    }elseif(is_object($data)){
        $str = d(get_object_vars($data));
    }elseif(is_bool($data)){
        $str = "<i>" . ($data ? "True" : "False") . "</i>";
    }else{
        $str = $data;
        $str = preg_replace("/\n/", "<br>\n", $str);
    }
    return $str;
}

function dnl($data){
    echo d($data) . "<br>\n";
}

function dd($data){
    // array_map(function($x) { var_dump($x); }, func_get_args()); 
    // die;
    echo dnl($data);
    exit;
}

function ddt($message = ""){
    echo "[" . date("Y/m/d H:i:s") . "]" . $message . "<br>\n";
}