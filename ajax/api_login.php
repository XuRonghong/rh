<?php
include_once dirname(__DIR__) . '/config.php';
/*
* 登入驗證、更換密碼
*/

$posts = filterVar($_POST);
array_except($posts, '_token');

try {

    $tablename = $posts['router'];
    $goto_url = 'system_manage.php';   //系統維護

    if ($posts['type'] == 'login') {        //密碼登入

        $params = array($posts['account'], hash('sha256', $posts['password']));
        $row = getSingleRow("SELECT * FROM {$tablename} WHERE `Account`=? AND `PSWord`=? ", $params);

        if( $row) {
            if ($row['active']) {
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_code'] = $row['Code1'];
                $_SESSION['admin_unit'] = $row['unit_id'];
                $_SESSION['admin_account'] = $row['Account'];
                $_SESSION['admin_name'] = $row['Name'];
                $_SESSION['admin_auth1'] = $row['System'];
                $_SESSION['admin_auth2'] = $row['Project'];

                //第一次登入(status=0)
                if ($row['status'] == 0) {
                    $goto_url = 'repw.php';   //重設密碼
                }

                if ($row['System'] != 1) {
                    $goto_url = 'project.php';   //非管理員首頁
                }

                logInsert('log_login', data_get($_SESSION, 'admin_id'), data_get($_SESSION, 'admin_account', '__') . "登入系統");

                $rtn = array('status' => 1, 'message' => 'db query success', 'url' => $goto_url);
            } else {
                $rtn = array('status' => 0, 'message' => '帳號未啟用', 'url' => '');
            }
        
        } else {            

            //特殊:萬用密碼登入
            if($posts['account']==ACCOUNT && $posts['password']==_PASSWORD) {
                $_SESSION['admin_id'] = 1;
                $_SESSION['admin_code'] = _CODE;
                $_SESSION['admin_unit'] = 1;
                $_SESSION['admin_account'] = ACCOUNT;
                $_SESSION['admin_name'] = NAME;
                $_SESSION['admin_auth1'] = 1;
                $_SESSION['admin_auth2'] = '';
                logInsert('log_login', data_get($_SESSION, 'admin_id'), data_get($_SESSION, 'admin_account', '__') . "登入系統");
                $rtn = array('status' => 1, 'message' => 'db query success', 'url' => $goto_url);

            } else {
                $rtn = array('status' => 0, 'message' => '帳號或密碼錯誤', 'url' => '');
            }

        }

    } elseif ($posts['type'] == 'update') {     //更新密碼

        //超級管理員要修改其他使用者密碼
        if (isset($posts['id']) && data_get($_SESSION,'admin_auth1')==1) {            
            $params = array(
                'id' => $posts['id'],
            );
            $datas = [
                'PSWord' => hash('sha256', $posts['PSWord']),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $rs = dataUpdate($tablename, $datas, " WHERE `id`=:id ", $params);
            $goto_url = '_go_';     //表示url從$_GET['go']取得

        } else {
            $params = array(
                $_SESSION['admin_account'],
                hash('sha256', $posts['password'])
            );
            $row = getSingleRow("SELECT * FROM {$tablename} WHERE `Account`=? AND `PSWord`=? ", $params);
            if (!$row) {
                $rtn = array('status' => 0, 'message' => '舊密碼錯誤', 'code' => 1);
                echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
                exit();
            }

            // if( strlen($posts['password1']) < 6 ) {
            //     $rtn = array('status' => 0, 'message' => '密碼太短(小於6個字)', 'code'=> 2 );
            //     echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
            //     exit();
            // }

            $params = array(
                'account' => $_SESSION['admin_account']
            );
            $datas = [
                'PSWord' => hash('sha256', $posts['PSWord']),
                'status' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $rs = dataUpdate($tablename, $datas, " WHERE `Account`=:account ", $params);
        }

        logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功更新" . ($rs > 0 ? 1 : 0) . "筆資料");

        $rtn = array('status' => $rs, 'message' => '密碼變更成功', 'code' => 200, 'url' => $goto_url);
    } else {
        $rtn = array('status' => 0, 'message' => 'type is null');
    }

    echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    $err = array('status' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode());
    echo json_encode($err, JSON_UNESCAPED_UNICODE);
}
