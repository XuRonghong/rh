<?php
include_once dirname(__FILE__) . '/../config.php';


$goto_url = $_SERVER['HTTP_REFERER'];

try {

    $posts = filterVar($_POST);

    $tablename = 'units';
    //array_except($posts, ['router', 'table', 'key', 'value']);  //不寫入資料庫欄位                
    $params = array(
        'id' => data_get($_SESSION, 'admin_unit')
    );
    $datas = [
        'Code1' => $posts['code'],
        'Name1' => $posts['name'],
        'Name2' => $posts['name2'],
        'Tel' => $posts['tel'],
        'Address1' => $posts['address'],
        'Logo' => $newfile,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    $rs = dataUpdate($tablename, $datas, " WHERE `id`=:id ", $params);
    logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功更新" . ($rs > 0 ? 1 : 0) . "筆資料");
    $rtn = array('status' => $rs, 'message' => '資料變更成功', 'code' => 200, 'url' => $goto_url);
    // echo json_encode($rtn, JSON_UNESCAPED_UNICODE); 
    echo '<br> ✔ ✔ 資料變更成功。。<br>';
} catch (Exception $e) {
    $err = array('status' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode());
    echo json_encode($err, JSON_UNESCAPED_UNICODE);
    echo '<meta http-equiv="refresh" content="2;url=index.php">'; //自動跳轉回index檔案
}

echo '<br><hr><br>';


$doThumb = false;   //是否縮圖
$thumb_max = 90;     //假設縮圖要長寬不超過90
$thumb_dir = "../thumb/";


if (isset($_FILES['file']) && !empty($_FILES['file']["name"])) {
    if ($_FILES['file']['error'] > 0) {
        echo $_FILES['file']['error'];
        echo "❌ <b>錯誤01，上傳檔案錯誤！";
        echo '<meta http-equiv="refresh" content="3;url=' . $goto_url . '">'; //自動跳轉回index檔案
    } else {


        echo "檔案名稱: " . $_FILES["file"]["name"] . "<br/>";
        echo "檔案類型: " . $_FILES["file"]["type"] . "<br/>";
        echo "檔案大小: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
        echo "暫存名稱: " . $_FILES["file"]["tmp_name"];



        //開始獲取上傳檔案的資訊
        $file = $_FILES['file'];
        //var_dump($file);列印檔案裡的全部資訊
        //name:上傳檔名
        //type:上傳檔案的型別
        //tmp_name:上傳成功後的臨時檔案
        //size:上傳檔案的大小
        //error:上傳檔案的錯誤資訊
        $uploaddir = "../storage/"; //選擇要上傳的檔案存放目錄
        //$uploadfile=$uploaddir.basename($file['name']);//獲得上傳檔案的名稱

        //解析檔案的名字
        $fileinfo = pathinfo($file['name']);
        //   echo $fileinfo['extension']; 獲取檔案的型別
        do {
            $newfile = date("YmdHis") . rand(1000, 9999) . "." . $fileinfo['extension']; //更改檔案的名字，獲取一個新的名字
        } while (file_exists($uploaddir . $newfile));

        //上傳檔案的型別限制
        if (!(($file['type'] == "image/png") || ($file['type'] == "image/gif") || ($file['type'] == "image/jpeg") || ($file['type'] == "image/pjpeg"))) {
            echo ("❌ <b>錯誤02，上傳檔案(圖片)型別錯誤！</b>");
            echo "<meta http-equiv=Refresh content=3;URL=" . $goto_url . ">";
        }

        //上傳檔案的大小限制
        if ($file['size'] > 2 * 1024 * 1024) {
            echo ("❌ <b>錯誤03，上傳檔案超過2MB！</b>");
            echo '<meta http-equiv="refresh" content="3;url=' . $goto_url . '">';
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
                    echo "檔案已經存在，請勿重覆上傳相同檔案";
                    echo '<meta http-equiv="refresh" content="3;url=' . $goto_url . '">'; //自動跳轉回index檔案
                    exit();
                }

                if (move_uploaded_file($file['tmp_name'], $uploaddir . $newfile)) {
                    echo "上傳成功！";


                    $params = array(
                        'id' => data_get($_SESSION, 'admin_unit')
                    );
                    $datas = [
                        'Logo' => $newfile
                    ];
                    $rs = dataUpdate($tablename, $datas, " WHERE `id`=:id ", $params);
                    logInsert('log_data', data_get($_SESSION, 'admin_id'), "成功上傳" . ($rs > 0 ? 1 : 0) . "筆圖片");


                    echo '<meta http-equiv="refresh" content="1;url=' . $goto_url . '">'; //自動跳轉回index檔案
                } else {
                    echo "上傳失敗，請稍等！";
                    echo '<meta http-equiv="refresh" content="3;url=' . $goto_url . '">'; //自動跳轉回index檔案
                }
            }
        }
    }
} else {
    echo '<meta http-equiv="refresh" content="1;url=' . $goto_url . '">'; //自動跳轉回index檔案
}
