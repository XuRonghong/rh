<?php
include_once dirname(__DIR__) . '/config.php';
/*
* api設計，對表動作Create、Read、Update、Delete
*/

try {

$posts = filterVar($_REQUEST);

array_except($posts, '_token');
    
$tablename = $posts['table'];

    if($posts['router']=='get') {

        $params = array($posts['key'] => $posts['value']);
        $rows = getMultiRow("SELECT * FROM {$tablename} where `{$posts['key']}`=:{$posts['key']} ", $params);

        $rtn = array('status' => 1, 'message' => 'db query success', 'data' => $rows);

        if( isset($posts['table2']) && isset($posts['key2']) && isset($posts['value2'])) {   
            $tablename2 = $posts['table2'];         
            $params = array($posts['key2'] => $posts['value2']);
            $rows2 = getMultiRow("SELECT * FROM {$tablename2} where `{$posts['key2']}`=:{$posts['key2']} ", $params);
    
            $rtn['data2'] = $rows2;
        }        

    }
    else if($posts['router']=='create') {
        
        $datas = $posts;
        $datas['created_at'] = date('Y-m-d H:i:s');
        $datas['status'] = 1;
        array_except($datas, ['router', 'table', 'key', 'value', 'id']);  //不寫入資料庫欄位
        $rs = dataInsert($tablename, $datas);
    
        $rtn = array('status' => 1, 'message' => 'db insert success', 'code' => 200);
        logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功新增1筆id.". $rs. "資料");

    }
    else if($posts['router']=='update') {
    
        $params = array($posts['key'] => $posts['value']);
        $datas = $posts;
        $datas['updated_at'] = date('Y-m-d H:i:s');
        array_except($datas, ['router', 'table', 'key', 'value']);  //不寫入資料庫欄位
        $rs = dataUpdate($tablename, $datas, " WHERE `{$posts['key']}`=:{$posts['key']}", $params);
    
        $rtn = array('status' => 1, 'message' => 'db update success', 'code' => 200);
        logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功更新". $rs. "筆資料");

    }
    else if($posts['router']=='delete') {
    
        $params = array($posts['key'] => $posts['value']);

        $datas = $posts;
        array_except($datas, ['router', 'table', 'key', 'value', 'id']);  //不寫入資料庫欄位
        $datas['updated_at'] = date('Y-m-d H:i:s');
        $rs = dataUpdate($tablename, $datas, " WHERE `{$posts['key']}`=:{$posts['key']}", $params);
        // $rs = dataDelete($tablename, $posts, " WHERE `{$posts['key']}`=:{$posts['key']}", $params);
    
        $rtn = array('status' => 1, 'message' => 'db delete success', 'code' => 200);
        logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功刪除". $rs. "筆資料");

    }
    
    echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
    

} catch (Exception $e) {
    $err = array('status' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode());

    echo json_encode($err, JSON_UNESCAPED_UNICODE);
}
