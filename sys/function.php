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


    
/*
* 以下可以用就用
*/

/* FILTER_VALIDATE_EMAIL：把值作為e-mail來驗證。 */
function _isValidEmail ( $email )
{
    return filter_var( $email, FILTER_VALIDATE_EMAIL ) !== false;
}

/* PHP正則表達式-使用preg_match()過濾字串 */
function _isValid ( $type = 'number' , $input_text = '' )
{
    switch ( $type ){
        //A. 檢查是不是數字
        case 'number':
            if (preg_match( "/^([0-9]+)$/", $input_text ) || strlen( $input_text ) > 99) {
                return true;
            }
            break;
        //B. 檢查是不是小寫英文
        case 'small_english':
            if (preg_match( "/^([a-z]+)$/", $input_text ) || strlen( $input_text ) > 99) {
                return true;
            }
            break;
        //C. 檢查是不是大寫英文
        case 'big_english':
            if (preg_match( "/^([A-Z]+)$/", $input_text ) || strlen( $input_text ) > 99) {
                return true;
            }
            break;
        //D. 檢查是不是全為英文字串
        case 'english':
            if (preg_match( "/^([A-Za-z]+)$/", $input_text ) || strlen( $input_text ) > 99) {
                return true;
            }
            break;
        //E. 檢查是不是英數混和字串
        case 'number+english':
            if (preg_match( "/^([0-9A-Za-z]+)$/", $input_text ) || strlen( $input_text ) > 99) {
                return true;
            }
            break;
        //F. 檢查是不是中文
        case 'chinese':
            if (preg_match( "/^([\x7f-\xff]+)$/", $input_text ) || strlen( $input_text ) > 99) {
                return true;
            }
            break;
    }
    return false;
}

function _isValidIDNum ( $id )
{
    //建立字母分數陣列
    $head = [ 'A' => 1, 'I' => 39, 'O' => 48, 'B' => 10, 'C' => 19, 'D' => 28,
        'E' => 37, 'F' => 46, 'G' => 55, 'H' => 64, 'J' => 73, 'K' => 82,
        'L' => 2, 'M' => 11, 'N' => 20, 'P' => 29, 'Q' => 38, 'R' => 47,
        'S' => 56, 'T' => 65, 'U' => 74, 'V' => 83, 'W' => 21, 'X' => 3,
        'Y' => 12, 'Z' => 30 ];
    //建立加權基數陣列
    $multiply = [ 8, 7, 6, 5, 4, 3, 2, 1 ];
    //檢查身份字格式是否正確
    if (preg_match( "/^[a-zA-Z][1-2][0-9]+$/", $id ) && strlen( $id ) == 10) {
        //切開字串
        $len = strlen( $id );
        for ($i = 0 ; $i < $len ; $i++) {
            $stringArray[$i] = substr( $id, $i, 1 );
        }
        //取得字母分數
        $total = $head[array_shift( $stringArray )];
        //取得比對碼
        $point = array_pop( $stringArray );
        //取得數字分數
        $len = count( $stringArray );
        for ($j = 0 ; $j < $len ; $j++) {
            $total += $stringArray[$j] * $multiply[$j];
        }
        //檢查比對碼
        if (( $total % 10 == 0 ) ? 0 : 10 - $total % 10 != $point) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function _get_https_url ()
{
    $https = !empty( $_SERVER ['HTTPS']) && strcasecmp( $_SERVER ['HTTPS'], 'on') === 0 || !empty ( $_SERVER ['HTTP_X_FORWARDED_PROTO'] ) && strcasecmp( $_SERVER ['HTTP_X_FORWARDED_PROTO'], 'https' ) === 0;

    return ( $https ? 'https://' : 'http://' );
}

function _get_full_url ()
{
    $https = !empty ( $_SERVER ['HTTPS'] ) && strcasecmp( $_SERVER ['HTTPS'], 'on' ) === 0 || !empty ( $_SERVER ['HTTP_X_FORWARDED_PROTO'] ) && strcasecmp( $_SERVER ['HTTP_X_FORWARDED_PROTO'], 'https' ) === 0;

    return ( $https ? 'https://' : 'http://' ) . ( !empty ( $_SERVER ['REMOTE_USER'] ) ? $_SERVER ['REMOTE_USER'] . '@' : '' ) . ( isset ( $_SERVER ['HTTP_HOST'] ) ? $_SERVER ['HTTP_HOST'] : ( $_SERVER ['SERVER_NAME'] . ( $https && $_SERVER ['SERVER_PORT'] === 443 || $_SERVER ['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER ['SERVER_PORT'] ) ) ) . substr( $_SERVER ['SCRIPT_NAME'], 0, strrpos( $_SERVER ['SCRIPT_NAME'], '/' ) );
}

/**
 * @param $url 请求网址
 * @param bool $params 请求参数
 * @param int $ispost 请求方式
 * @param int $https https协议
 * @return bool|mixed
 */
function curl ( $url, $https = 1, $ispost = 0, $params = false )
{
    $httpInfo = [];
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    if ($https) {
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false ); // 对认证证书来源的检查
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false ); // 从证书中检查SSL加密算法是否存在
    }
    if ($ispost) {
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );
        curl_setopt( $ch, CURLOPT_URL, $url );
    } else {
        if ($params) {
            if (is_array( $params )) {
                $params = http_build_query( $params );
            }
            curl_setopt( $ch, CURLOPT_URL, $url . '?' . $params );
        } else {
            curl_setopt( $ch, CURLOPT_URL, $url );
        }
    }

    $response = curl_exec( $ch );

    if ($response === false) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo, curl_getinfo( $ch ) );
    curl_close( $ch );

    return $response;
}


/** 
* @desc 根據兩點間的經緯度計算距離 
* @param float $lat 緯度值 
* @param float $lng 經度值 
*/ 
function getDistance($lat1, $lng1, $lat2, $lng2) 
{ 
    $earthRadius = 6367000; //approximate radius of earth in meters 
    /* 
    Convert these degrees to radians 
    to work with the formula 
    */ 
    $lat1 = ($lat1 * pi() ) / 180; 
    $lng1 = ($lng1 * pi() ) / 180; 
    $lat2 = ($lat2 * pi() ) / 180; 
    $lng2 = ($lng2 * pi() ) / 180; 
    /* 
    Using the 
    Haversine formula 
    http://en.wikipedia.org/wiki/Haversine_formula 
    calculate the distance 
    */ 
    $calcLongitude = $lng2 - $lng1; 
    $calcLatitude = $lat2 - $lat1; 
    $stepOne = pow(sin($calcLatitude / 2), 2) * cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2); 
    $stepTwo = 2 * asin(min(1, sqrt($stepOne))); 
    $calculatedDistance = $earthRadius * $stepTwo; 
    return round($calculatedDistance); 
} 