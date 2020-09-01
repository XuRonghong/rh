<?php
date_default_timezone_set('Asia/Taipei');

/*
 * PHP 開啟及關閉錯誤訊息輸出
 */
//ini_set('display_errors','off');    # 關閉錯誤輸出
//ini_set('display_errors','on');     # 開啟錯誤輸出
error_reporting(E_ALL & ~E_NOTICE);  # 設定輸出錯誤類型 , 除了 Notice 外，全部錯誤輸出

session_cache_expire(20);//session逾時設定;
session_start();
ob_start();//可以解決header有先送出東西的問題
ob_end_clean();//先ob_start 再進行一次ob_end_clean

header("Cache-Control:no-cache,must-revalidate");//強迫更新
//header("P3P: CP=".$_SERVER["HTTP_HOST"]."");//解決在frame中session不能使用的問題，可填ip或是domain
header('Content-type: text/html; charset=utf-8');//指定utf8編碼 
//header('Vary: Accept-Language');


include_once __DIR__ . "/autoload.php";

include_once 'sys/db.php';
include_once 'sys/function.php';
include_once 'sys/function-pdo.php';
// include_once 'sys/function-mysql.php';

/* 代名詞 */
define('_DIR_', __DIR__);
define('Models', 'Models');
define('Views', 'Views');
define('Controllers', 'Controllers');


$str_no = [
    1 => ['壹','貳','參','肆','伍','陸','柒','捌','玖','拾','佰','仟', '零'],
    2 => ['一','二','三','四','五','六','七','八','九','十','百', '○'],
    3 => ['1','2','3','4','5','6','7','8','9', '0'],
    4 => ['01','02','03','04','05','06','07','08','09', '00'],
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
if( isset($Request['_token'])) {    
    if($_SESSION['token']!==$_POST['_token']) {
        $rtn = array('statue' => 0, 'message' => 'token no find or error!!', 'code' => 204);
        echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
        exit;
    }
}