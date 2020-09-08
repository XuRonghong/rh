<?php
include_once dirname(__DIR__) . '/config.php';


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
    
        array_except($posts, ['router', 'table', 'key', 'value']);  //不寫入資料庫欄位
        $rs = dataInsert($tablename, $posts);
    
        $rtn = array('status' => $rs, 'message' => 'db insert success', 'code' => 200);
    }
    else if($posts['router']=='update') {
    
        $id = $posts['id'];
        $params = array($posts['key'] => $posts['value']);
        $rs = dataUpdate($tablename, $posts, " WHERE `{$posts['key']}`=:{$posts['key']}", $params);
    
        $rtn = array('status' => $rs, 'message' => 'db update success', 'code' => 200);
    }
    else if($posts['router']=='delete') {
    
        $params = array($posts['key'] => $posts['value']);
        $rs = dataDelete($tablename, $posts, " WHERE `{$posts['key']}`=:{$posts['key']}", $params);
    
        $rtn = array('status' => $rs, 'message' => 'db delete success', 'code' => 200);
    }
    
    echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    $err = array('status' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode());

    echo json_encode($err, JSON_UNESCAPED_UNICODE);
}
