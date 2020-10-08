<?php
include_once dirname(__DIR__) . '/config.php';
/*
* 註冊、加入使用者
*/

$posts = filterVar($_POST);    
array_except($posts, '_token');

$tablename = 'accounts';//$posts['table'];

try {

    $params = array( $posts['account']);
    $row = getSingleRow("SELECT * FROM {$tablename} WHERE `Account`=? AND `active`=1 ", $params);

    if($row) {
        $rtn = array('status'=> 0, 'message'=> "使用者已存在", 'code'=> 200, 'url'=> 'account.php');
    } else {
        $datas = $posts;
        $datas['PSWord'] = hash('sha256', $datas['PSWord']);
        $datas['status'] = 1;
        $datas['created_at'] = date('Y-m-d H:i:s');
        array_except($datas, ['router', 'table', 'key', 'value', 'id', 'password_2']);  //不寫入資料庫欄位
        $rs = dataInsert($tablename, $datas);
    
        logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功新增1筆id=". $rs. "資料");
    
        $rtn = array('status'=> 1, 'message'=> "成功新增1使用者", 'code'=> 200, 'url'=> 'account.php');
    }
        
    echo json_encode($rtn, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    $err = array('status'=> 0, 'message'=> $e->getMessage(), 'code'=> $e->getCode());
    echo json_encode($err, JSON_UNESCAPED_UNICODE);
}