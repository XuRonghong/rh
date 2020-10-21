<?php
include_once dirname(__FILE__) . '/../config.php';

/*
* 專案資料(有圖片、文件)，另特別處理
*/
// $goto_url = $_SERVER['HTTP_REFERER'];

try {

    $posts = filterVar($_POST);

    $tablename = $posts['table'];
    $params = array($posts['key'] => $posts['value']);
    $datas = $posts;
    array_except($datas, ['_token', 'router', 'table', 'key', 'value', 'id', 'Pdf1-3', 'Photo1-5']);  //不寫入資料庫欄位

    if ($posts['router'] == 'create') {
        $datas['created_at'] = date('Y-m-d H:i:s');
        $datas['status'] = 1;
        $rs = dataInsert($tablename, $datas);
        logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功新增1筆id." . $rs . "資料");
        $message = '✔ 新增成功<br>';
    } 
    else if ($posts['router'] == 'update') {
        $datas['updated_at'] = date('Y-m-d H:i:s');
        $rs = dataUpdate($tablename, $datas, " WHERE `id`=:id ", $params);
        logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功更新" . ($rs > 0 ? 1 : 0) . "筆資料");
        $message = '✔ 變更成功<br>';
    }


    $doThumb = false;   //是否縮圖
    $thumb_max = 90;     //假設縮圖要長寬不超過90
    $thumb_dir = "../thumb/";

    if (isset($_FILES['file']) && !empty($_FILES['file']["name"])) {
        if ($_FILES['file']['error'] > 0) {
            rtn(array('status' => 0, 'message' => '❌錯誤01，' . $_FILES['file']['error'] . '！', 'code' => 200));
        } else {
            // echo "檔案名稱: " . $_FILES["file"]["name"] . "<br/>";
            // echo "檔案類型: " . $_FILES["file"]["type"] . "<br/>";
            // echo "檔案大小: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
            // echo "暫存名稱: " . $_FILES["file"]["tmp_name"];

            //開始獲取上傳檔案的資訊
            $file = $_FILES['file'];
            //var_dump($file);列印檔案裡的全部資訊
            //name:上傳檔名
            //type:上傳檔案的型別
            //tmp_name:上傳成功後的臨時檔案
            //size:上傳檔案的大小
            //error:上傳檔案的錯誤資訊
            $uploaddir = "../storage/" . $tablename . "/img/"; //選擇要上傳的檔案存放目錄
            //$uploadfile=$uploaddir.basename($file['name']);//獲得上傳檔案的名稱

            //解析檔案的名字
            $fileinfo = pathinfo($file['name']);
            //   echo $fileinfo['extension']; 獲取檔案的型別
            do {
                $newfile = date("YmdHis") . rand(1000, 9999) . "." . $fileinfo['extension']; //更改檔案的名字，獲取一個新的名字
            } while (file_exists($uploaddir . $newfile));

            //上傳檔案的型別限制
            if (!(($file['type'] == "image/png") || ($file['type'] == "image/gif") || ($file['type'] == "image/jpeg") || ($file['type'] == "image/pjpeg"))) {
                rtn(array('status' => 0, 'message' => '❌錯誤02，上傳檔案(圖片)型別錯誤！', 'code' => 200));
            }
            //上傳檔案的大小限制
            if ($file['size'] > 4 * 1024 * 1024) {
                rtn(array('status' => 0, 'message' => '❌錯誤03，上傳檔案file超過2MB！', 'code' => 200));
            }

            if (!file_exists($uploaddir)) {
                mkdir($uploaddir, 0755);
            }

            //開始上傳檔案
            if (is_uploaded_file($file['tmp_name'])) {
                if ($doThumb) {
                    // 取得上傳圖片
                    $src = imagecreatefromjpeg($file['tmp_name']);
                    // 取得來源圖片長寬
                    $src_w = imagesx($src);
                    $src_h = imagesy($src);
                    // 假設要長寬不超過$thumb_max
                    if ($src_w > $src_h) {
                        $thumb_w = $thumb_max;
                        $thumb_h = intval($src_h / $src_w * $thumb_max);
                    } else {
                        $thumb_h = $thumb_max;
                        $thumb_w = intval($src_w / $src_h * $thumb_max);
                    }
                    // 建立縮圖
                    $thumb = imagecreatetruecolor($thumb_w, $thumb_h);
                    // 開始縮圖
                    imagecopyresampled($thumb, $src, 0, 0, 0, 0, $thumb_w, $thumb_h, $src_w, $src_h);
                    // 儲存縮圖到指定 thumb 目錄
                    imagejpeg($thumb, $thumb_dir . $_FILES['file']['name']);
                    // 複製上傳圖片到指定 images 目錄
                    copy($_FILES['file']['tmp_name'], $uploaddir . $_FILES['file']['name']);
                } else {
                    if (file_exists($uploaddir . $newfile)) {
                        rtn(array('status' => 0, 'message' => '⚠檔案file已經存在，請勿重覆上傳相同檔案', 'code' => 200));
                    }
                    if (move_uploaded_file($file['tmp_name'], $uploaddir . $newfile)) {
                        $datas = ['Photo1_5' => $newfile];
                        $rs = dataUpdate($tablename, $datas, " WHERE `id`=:id ", $params);
                        logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功上傳" . ($rs > 0 ? 1 : 0) . "筆圖片");
                        $message .= ' ✔ 圖片上傳成功<br>';
                    } else {
                        rtn(array('status' => 0, 'message' => '⚠上傳file失敗，請稍等或重試。', 'code' => 200));
                    }
                }
            }
        }
    }

    if (isset($_FILES['file2']) && !empty($_FILES['file2']["name"])) {
        if ($_FILES['file2']['error'] > 0) {
            rtn(array('status' => 0, 'message' => '❌錯誤01：' . $_FILES['file2']['error'] . '！', 'code' => 200));
        } else {
            // echo "檔案名稱: " . $_FILES["file2"]["name"] . "<br/>";
            // echo "檔案類型: " . $_FILES["file2"]["type"] . "<br/>";
            // echo "檔案大小: " . ($_FILES["file2"]["size"] / 1024) . " Kb<br />";
            // echo "暫存名稱: " . $_FILES["file2"]["tmp_name"];

            //開始獲取上傳檔案的資訊
            $file = $_FILES['file2'];
            //var_dump($file);列印檔案裡的全部資訊
            //name:上傳檔名
            //type:上傳檔案的型別
            //tmp_name:上傳成功後的臨時檔案
            //size:上傳檔案的大小
            //error:上傳檔案的錯誤資訊
            $uploaddir = "../storage/" . $tablename . "/file/"; //選擇要上傳的檔案存放目錄
            //$uploadfile=$uploaddir.basename($file['name']);//獲得上傳檔案的名稱

            //解析檔案的名字
            $fileinfo = pathinfo($file['name']);

            // do {
            //     $newfile = date("YmdHis") . rand(1000, 9999) . "." . $fileinfo['extension']; //更改檔案的名字，獲取一個新的名字
            // } while (file_exists($uploaddir . $newfile));
            $newfile = explode('.',$_FILES["file2"]["name"])[0] . "_" . date("YmdHis") . "." . $fileinfo['extension'];

            //上傳檔案的型別限制
            // if (!(($file['type'] == "image/png") || ($file['type'] == "image/gif") || ($file['type'] == "image/jpeg") || ($file['type'] == "image/pjpeg"))) {
            // $rtn = array('status' => 0, 'message' => "❌錯誤02，上傳檔案(圖片)型別錯誤！", 'code' => 200);
            // }
            //上傳檔案的大小限制
            if ($file['size'] > 10 * 1024 * 1024) {
                $rtn = array('status' => 0, 'message' => '❌錯誤03，上傳檔案file2超過10MB！', 'code' => 200);
            }

            if (!file_exists($uploaddir)) {
                mkdir($uploaddir, 0755);
            }

            //開始上傳檔案
            if (is_uploaded_file($file['tmp_name'])) {
                // if (file_exists($uploaddir . $newfile)) {
                //     rtn(array('status' => 0, 'message' => "⚠檔案file2已經存在，請勿重覆上傳相同檔案。", 'code' => 200));
                // }
                if (move_uploaded_file($file['tmp_name'], $uploaddir . $newfile)) {
                    $datas = ['Pdf1_3' => $newfile];
                    $rs = dataUpdate($tablename, $datas, " WHERE `id`=:id ", $params);
                    logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功上傳" . ($rs > 0 ? 1 : 0) . "個檔案");
                    $message .= ' ✔ 文件上傳成功<br>';
                } else {
                    rtn(array('status' => 0, 'message' => '⚠上傳file2失敗，請稍等或重試。', 'code' => 200));
                }
            }
        }
    }
    rtn(array('status' => $rs, 'message' => $message, 'code' => 200));
} catch (Exception $e) {
    rtn(array('status' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode()));
}

function rtn($rtn)
{
    //echo '<meta http-equiv="refresh" content="3;url=' . $goto_url . '">'; //自動跳轉回index檔案
    echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
    exit();
}
