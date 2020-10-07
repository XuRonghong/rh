<?php
include_once dirname(__DIR__) . '/config.php';
/*
* api設計，account修改增減Project欄位
*/

try {
    $posts = filterVar($_REQUEST);        

    $tablename = 'accounts';//$posts['table'];

    $params = array('id' => $posts['id']);
    $datas = $posts;
    $datas['Project'] = implode(',', data_get($datas,'Project',[]));
    $datas['updated_at'] = date('Y-m-d H:i:s');
    array_except($datas, ['router', 'table', 'key', 'value']);  //不寫入資料庫欄位
    $rs = dataUpdate($tablename, $datas, " WHERE `id`=:id", $params);

    $rtn = array('status'=> 1, 'message'=> "成功更新".$rs."筆資料", 'code'=> 200);
    logInsert('log_data', data_get($_SESSION, 'admin_id'), "更新". $rs. "筆權限資料");


    echo json_encode($rtn, JSON_UNESCAPED_UNICODE);  

} catch (Exception $e) {
    $err = array('status'=> 0, 'message'=> $e->getMessage(), 'code'=> $e->getCode());
    echo json_encode($err, JSON_UNESCAPED_UNICODE);
}
