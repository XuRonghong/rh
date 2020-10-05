<?php
date_default_timezone_set('Asia/Taipei');

/*
 * PHP 開啟及關閉錯誤訊息輸出
 */
//ini_set('display_errors','off');    # 關閉錯誤輸出
//ini_set('display_errors','on');     # 開啟錯誤輸出
error_reporting(E_ALL & ~E_NOTICE);  # 設定輸出錯誤類型 , 除了 Notice 外，全部錯誤輸出

session_cache_expire(20); //session逾時設定;
session_start();
ob_start(); //可以解決header有先送出東西的問題
ob_end_clean(); //先ob_start 再進行一次ob_end_clean

ini_set('upload_max_filesize', '15M');


header("Cache-Control:no-cache,must-revalidate"); //強迫更新
//header("P3P: CP=".$_SERVER["HTTP_HOST"]."");//解決在frame中session不能使用的問題，可填ip或是domain
header('Content-type: text/html; charset=utf-8'); //指定utf8編碼 
//header('Vary: Accept-Language');


include_once __DIR__ . "/autoload.php";

include_once 'sys/db.php';
include_once 'sys/function.php';
include_once 'sys/function-pdo.php';
// include_once 'sys/function-mysql.php';

/* 代名詞 */
define('APP_NAME', 'rh3');
define('_DIR_', __DIR__);
define('Models', 'Models');
define('Views', 'Views');
define('Controllers', 'Controllers');


$str_no = [
    1 => ['壹', '貳', '參', '肆', '伍', '陸', '柒', '捌', '玖', '拾', '佰', '仟', '零'],
    2 => ['一', '二', '三', '四', '五', '六', '七', '八', '九', '十', '百', '○'],
    3 => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'],
    4 => ['01', '02', '03', '04', '05', '06', '07', '08', '09', '00'],
];


$Request = $_REQUEST;
// if( isset($Request['r']) && !is_null($Request['r']) && $Request['r']!=',' ) {
//     include_once(__DIR__.'/'.Controllers.'/'. $Request['r']. '.php');

//     if( isset($Request['f']) && !is_null($Request['f']) && $Request['f']!=',' ) {
//         $Request['f']();
//     } else {
//         index();
//     }
// } 

// print_r(apache_request_headers()); // 印出所有 Header
if (isset(apache_request_headers()['X-CSRF-TOKEN'])) {
    $_token = apache_request_headers()['X-CSRF-TOKEN'];
    if ($_SESSION['token'] !== $_token) {
        $rtn = array('statue' => 0, 'message' => 'token no find or error!!', 'code' => 204);
        echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
        exit;
    }
}

if (isset($Request['_token'])) {
    if ($_SESSION['token'] !== $Request['_token']) {
        $rtn = array('statue' => 0, 'message' => 'token no find or error!!', 'code' => 204);
        echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
        exit;
    }
}


//record guest 
if(strpos($_SERVER['REQUEST_URI'], 'api' )) {
    //
    if( !strpos($_SERVER['REQUEST_URI'], 'crud') && !strpos($_SERVER['REQUEST_URI'], 'api_login') && !strpos($_SERVER['REQUEST_URI'], 'api_logout') ) {
        logInsert('log_action', data_get($_SESSION, 'admin_id', 0), "API");
    }
} else {
    logInsert('log_read', data_get($_SESSION, 'admin_id', 0), "Request!!");
}


//沒有登入驗證成功，導回登入
if ($_SERVER['REQUEST_URI'] != '/'.APP_NAME.'/login.php' && !strpos($_SERVER['REQUEST_URI'], '/ajax/' )) {
    if ( !isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == '') {
        header("location: login.php");
    }
}
//抵擋非正確來源的request
if ( strpos($_SERVER['REQUEST_URI'], '/ajax/api_upload.php') && !strpos($_SERVER['HTTP_REFERER'], 'unit_edit') ) {
    header("location: index.php");
}


/* select options */
//Building建物用途:
$building_conf = [
   '1' => '一般住宅',
   '2' => '高層住宅',
   '3' => '別墅透天',
   '4' => '工業廠房',
   '5' => '辦 公 室',
   '6' => '辦公廠房',
   '7' => '大 賣 場',
   '8' => '學    校',
   '9' => '體 育 館',
   '10' => '活動中心',
   '11' => '宗廟塔寺',
   '12' => '停 車 場',
   '13' => '庭園景觀',
   '14' => '土木工程',
   '15' => '其他'
];

// Structure1	建造模式	char	20	Y	(DATA)


// Structure2	結構型式	char	20	Y	(DATA)
$structure2_conf = [
   '1' => 'RC鋼筋混凝土',
   '2' => 'SRC全鋼骨鋼筋混凝土',
   '3' => 'SC鋼骨混凝土',
   '4' => 'SS鋼結構',
   '5' => 'SRC續接RC鋼骨鋼筋混凝土',
   '6' => 'PCa預鑄結構',
   '7' => '其他'
];

//Structure3	建造工法	char	20	Y	(DATA)',
$structure3_conf = [
   '1' => '順    打',
   '2' => '雙 順 打',
   '3' => '逆    打',
   '4' => '半 逆 打',
   '5' => '其他'
];

//Retaining patterns	擋土開挖	char	20	Y	(DATA)',
$rp_conf = [
   '1' => '連 續 壁',
   '2' => '擋土排樁',
   '3' => '鋼 軌 樁',
   '4' => '鋼 板 樁',
   '5' => '明挖工法',
   '6' => '島式工法',
   '7' => '其他型式'
];

//Facades	外牆型態	char	20	Y	(DATA)',
$facades_conf = [
   '1' => 'RC外牆',
   '2' => '玻璃帷幕',
   '3' => 'PC版預鑄',
   '4' => '其他'
];


//Regional	地理區域	char	10	N	10地理分區(DATA)
$regional_conf = [
    '台北市',
    '北部(新北, 桃園, 新竹, 苗栗)',
    '中部(台中, 彰化, 南投, 雲林, 嘉義)',
    '南部(台南, 高雄, 屏東)',
    '東北部(基隆, 宜蘭)',
    '東部(花蓮)東南部(台東)',
    '澎湖.金門.馬祖'
];

//工程縣市
$area_conf = [
    '台北',
    '新北',
    '桃園',
    '新竹',
    '苗栗',
    '台中',
    '彰化',
    '南投',
    '雲林',
    '嘉義',
    '台南',
    '高雄',
    '屏東基隆',
    '宜蘭',
    '花蓮',
    '台東',
    '澎湖',
    '金門',
    '馬祖'
];