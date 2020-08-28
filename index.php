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

require_once 'sys/db.php';
require_once 'sys/function.php';

/* 代名詞 */
define('_DIR_', __DIR__);
define('Models', 'Models');
define('Views', 'Views');
define('Controllers', 'Controllers');


$Request = $_REQUEST;
include_once(__DIR__.'/'.Controllers.'/'. $Request['r']. '.php');

if( isset($Request['f']) && !is_null($Request['f']) && $Request['f']!='' ) {
    $Request['f']();
} else {
    index();
}

$Request = null;
$db = null;