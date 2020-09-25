<?php
include_once dirname(__DIR__) . '/config.php';
/*
* 登出功能
*/

$posts = filterVar($_POST);    
array_except($posts, '_token');

try {
        
    $tablename = $posts['router'];
    $goto_url = 'login.php';   
    
    if($posts['type']=='logout'){        

        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_code']);
        unset($_SESSION['admin_unit']);
        unset($_SESSION['admin_account']);
        unset($_SESSION['admin_name']);
        unset($_SESSION['admin_auth1']);
        unset($_SESSION['admin_auth2']);

        logInsert('log_login', data_get($_SESSION, 'unit_code'), "登出". $tablename. "系統");

        $rtn = array('status' => 1, 'message' => '成功登出', 'url' => $goto_url);
    } else {        
        $rtn = array('status' => 0, 'message' => 'type is null');
    }

    echo json_encode($rtn, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    $err = array('status' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode());
    echo json_encode($err, JSON_UNESCAPED_UNICODE);
}