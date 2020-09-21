<?php
include_once dirname(__DIR__) . '/config.php';


try {
    $posts = filterVar($_POST);    
    array_except($posts, '_token');
        
    $tablename = 'units';
    
    if($posts['type']=='login'){        //密碼登入
        $params = array( hash('sha256', $posts['password']));
        $row = getSingleRow("SELECT * FROM {$tablename} WHERE `SYSWord`=? AND `id`=1 ", $params);

        if($row) {

            if($row['status']==1) {         
                $login_success_url = 'index06_1.htm';   
            } else {            
                $login_success_url = 'unit.php';
            }

            $rtn = array('status' => 1, 'message' => 'db query success', 'url' => $login_success_url);
        } else {
            // $rtn = array('status' => 0, 'message' => '帳號或密碼錯誤', 'url' => '');
            $rtn = array('status' => 0, 'message' => '密碼錯誤', 'url' => '');
        }

    } elseif($posts['type']=='update'){     //更新密碼

        $params = array( hash('sha256', $posts['password']));
        $row = getSingleRow("SELECT * FROM {$tablename} WHERE `SYSWord`=? AND `id`=1 ", $params);
        if( !$row) {
            $rtn = array('status' => 0, 'message' => '舊密碼錯誤', 'code'=> 1 );
            echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
            exit();
        }

        // if( strlen($posts['password1']) < 6 ) {
        //     $rtn = array('status' => 0, 'message' => '密碼太短(小於6個字)', 'code'=> 2 );
        //     echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
        //     exit();
        // }

        $datas = [
            'SYSWord' => hash('sha256', $posts['password1']),
            'status' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $rs = dataUpdate($tablename, $datas, " WHERE `id`=1");


        $login_success_url = 'index06_1.htm';

    
        $rtn = array('status' => $rs, 'message' => 'db insert success', 'code' => 200, 'url'=> $login_success_url );
        logInsert('log_data', data_get($_SESSION, 'unit_code'), "成功更新". ($rs>0? 1: 0). "筆資料");

    } else {        
        $rtn = array('status' => 0, 'message' => 'type is null');
    }

    echo json_encode($rtn, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    $err = array('status' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode());
    echo json_encode($err, JSON_UNESCAPED_UNICODE);
}