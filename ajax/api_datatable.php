<?php
include_once dirname(__DIR__) . '/config.php';
/*
* api設計，對表動作Create、Read、Update、Delete
*/


try {

    $posts = filterVar($_REQUEST);

    array_except($posts, '_token');

    $tablename = $posts['table'];

    if ($posts['router'] == 'get') {

        // $params = array($posts['key'] => $posts['value']);
        // $rows = getMultiRow("SELECT * FROM {$tablename} where `{$posts['key']}`=:{$posts['key']} ", $params);

        $params = array($posts['key'] => $posts['value']);
        $rows = getMultiRow("SELECT * FROM {$tablename} where 1 ");

        $rtn = array(
            'status' => 1,
            // 'sEcho' => '',
            // 'iTotalDisplayRecords' => 1,
            // 'iTotalRecords' => 1,
            'message' => 'db query success',
            'data' => $rows
        );
    } else if ($posts['router'] == 'create') {

        $datas = $posts;
        $datas['created_at'] = date('Y-m-d H:i:s');
        array_except($datas, ['router', 'table', 'key', 'value']);  //不寫入資料庫欄位
        $rs = dataInsert($tablename, $datas);

        $rtn = array('status' => $rs, 'message' => 'db insert success', 'code' => 200);
        logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功新增" . $rs . "筆資料");
    } else if ($posts['router'] == 'update') {

        $params = array($posts['key'] => $posts['value']);
        $datas = $posts;
        $datas['updated_at'] = date('Y-m-d H:i:s');
        array_except($datas, ['router', 'table', 'key', 'value']);  //不寫入資料庫欄位
        $rs = dataUpdate($tablename, $datas, " WHERE `{$posts['key']}`=:{$posts['key']}", $params);

        $rtn = array('status' => $rs, 'message' => 'db update success', 'code' => 200);
        logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功更新" . $rs . "筆資料");
    } else if ($posts['router'] == 'delete') {

        $params = array($posts['key'] => $posts['value']);

        $datas = [];
        $datas['open'] = '0';
        $datas['updated_at'] = date('Y-m-d H:i:s');
        $rs = dataUpdate($tablename, $datas, " WHERE `{$posts['key']}`=:{$posts['key']}", $params);
        // $rs = dataDelete($tablename, $posts, " WHERE `{$posts['key']}`=:{$posts['key']}", $params);

        $rtn = array('status' => $rs, 'message' => 'db delete success', 'code' => 200);
        logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功刪除" . $rs . "筆資料");
    }

    echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    $err = array('status' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode());

    echo json_encode($err, JSON_UNESCAPED_UNICODE);
}
