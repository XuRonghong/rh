<?php

function sql_get($db, $sql='', $exec, $fetchall=PDO::FETCH_ASSOC)
{    
    $rs = $db->prepare($sql);
    $rs->execute($exec);
    return $rs->fetchAll($fetchall);
}

function view($str)
{
    $str = str_replace('.', '/', $str);
    return _DIR_.'/'.Views.'/'.$str.'.php';
}



//=========== 檔案處理函數 =============//

//圖片縮放裁切
//type=resize 強迫尺寸:指定寬,高
//type=equal 等比例縮放:指定寬度 高度等比例,指定高度 寬度等比例
//type=limit 限制範圍:指定寬 超過
//type=cut 裁切自動調整縮放:指定寬,高
function imageResize($imgsrc,$imgdst=null,$new_w=400,$new_h=null,$type='equal',$img_quility=70){
    $ext=strtolower(pathinfo($imgsrc, PATHINFO_EXTENSION));
    $imgdst=($imgdst==null)?$imgsrc:$imgdst;
    switch($ext){
        case 'gif':
            $imgsrc=imagecreatefromgif($imgsrc);
            break;
        case 'jpg':
            $imgsrc=imagecreatefromjpeg($imgsrc);
            break;
        case 'jpeg':
            $imgsrc=imagecreatefromjpeg($imgsrc);
            break;
        case 'png':
            $imgsrc=imagecreatefrompng($imgsrc);
            break;
    }
    
    //取得原圖的寬度與高度
    $src_w = imagesx($imgsrc); 
    $src_h = imagesy($imgsrc); 

    // 設定圖片偏移初值
    $crop_x = 0;
    $crop_y = 0;
    
    //設定新圖的寬度與高度		
    if($type=='equal'){
        if($new_w!='')
            $new_h = round($src_h*$new_w/$src_w);
        else
            $new_w = round($src_w*$new_h/$src_h);
    }else if($type=='limit'){
        if($new_w!='' && $new_h==''){
            if($new_w>=$src_w){
                $new_w = $src_w;
                $new_h = $src_h;
            }else{
                $new_h = round($src_h*$new_w/$src_w);
            }
        }else if($new_h!='' && $new_w==''){
            if($new_h>=$src_h){
                $new_w = $src_w;
                $new_h = $src_h;
            }else{
                $new_w = round($src_w*$new_h/$src_h);
            }
        }else if($new_w!='' && $new_h!=''){
            $src_rate = $src_w/$src_h;
            $new_rate = $new_w/$new_h;
            if($new_rate>$src_rate){
                if($new_h>=$src_h){
                    $new_w = $src_w;
                    $new_h = $src_h;
                }else{
                    $new_w = round($src_w*$new_h/$src_h);
                }
            }else{
                if($new_w>=$src_w){
                    $new_w = $src_w;
                    $new_h = $src_h;
                }else{
                    $new_h = round($src_h*$new_w/$src_w);
                }
            }
        }
    }else if($type=='cut' && $new_w!='' && $new_h!=''){
        //將圖片裁切成指定大小
        //較長的部分保持不變,較短的部分,依指定圖片比例縮放
        $src_rate = $src_w/$src_h;
        $new_rate = $new_w/$new_h; 		
        $temp_w = $src_w;
        $temp_h = $src_h;
        if($new_rate>$src_rate)
            $src_h = round($new_h*$src_w/$new_w);
        else
            $src_w = round($new_w*$src_h/$new_h);	
        $crop_x = round(($temp_w-$src_w)/2);				
        $crop_y = round(($temp_h-$src_h)/2);
    }
    
    //建立圖片
    $newimg = imagecreatetruecolor($new_w, $new_h);
    if($ext=='gif' or $ext=='jpg' or $ext=='jpeg'){
        imagefill($newimg,0,0,imagecolorallocate($newimg, 255, 255, 255));
    }else{
        imagefill($newimg,0,0,imagecolorallocatealpha($newimg, 255, 255, 255, 255));
        imageAlphaBlending($newimg, false);
        imageSaveAlpha($newimg, true);
    }		
    imagecopyresampled($newimg,$imgsrc,0,0,$crop_x,$crop_y,$new_w,$new_h,$src_w,$src_h);
    switch($ext){
        case 'gif':
            imagegif($newimg,$imgdst); 
            break;
        case 'jpg':
            imagejpeg($newimg,$imgdst,$img_quility); 
            break;
        case 'jpeg':
            imagejpeg($newimg,$imgdst,$img_quility); 
            break;
        case 'png':
            imagepng($newimg,$imgdst);
            break;
    } 
    imagedestroy($newimg);
}

//檔案上傳處理(檔案,檔案路徑,檔案類型,檔案限制大小)
//return 1=>成功, 2=>檔案太大,格式錯誤,上傳失敗
function fileUpload($upfiles,$dir,$type,$filesize=2048){
    if(!is_array($upfiles['error'])){
        $error=$upfiles['error'];
        if(($upfiles["size"]/1024)>=$filesize){
                $arr[]=array('state'=>2,'name'=>$upfiles["name"],'msg'=>'檔案太大');
            }else if($error==UPLOAD_ERR_OK){
                $ext=strtolower(pathinfo($upfiles["name"], PATHINFO_EXTENSION));
                if(in_array($ext,$type)||($type=='*')){
                    $upfilesname=randMix(9,1,2).".".$ext;
                    move_uploaded_file($upfiles["tmp_name"],$dir.$upfilesname);		
                    $arr[]=array('state'=>1,'name'=>$upfiles["name"],'path'=>$upfilesname,'msg'=>'上傳成功');		
                }else{
                    $arr[]=array('state'=>2,'name'=>$upfiles["name"],'msg'=>'格式錯誤');
                }
            }else{
                $arr[]=array('state'=>2,'name'=>$upfiles["name"],'msg'=>'上傳失敗');
            }
    }else{
        foreach($upfiles["error"] as $key=>$error){		
            if(($upfiles["size"][$key]/1024)>=$filesize){
                $err=true;
                $arr[]=array('state'=>2,'name'=>$upfiles["name"][$key],'msg'=>'檔案太大');
            }else if($error==UPLOAD_ERR_OK){
                $ext=strtolower(pathinfo($upfiles["name"][$key], PATHINFO_EXTENSION));
                if(in_array($ext,$type)||($type=='*')){
                    $upfilesname=randMix(9,1,2).".".$ext;
                    move_uploaded_file($upfiles["tmp_name"][$key],$dir.$upfilesname);		
                    $arr[]=array('state'=>1,'name'=>$upfiles["name"][$key],'path'=>$upfilesname);
                    //echo $upfiles["name"][$key]."上傳成功<br>";
                    //echo $upfiles["type"][$key]."<br>";
                    //echo $upfiles["size"][$key]."<br>";		
                }else{
                    $arr[]=array('state'=>2,'name'=>$upfiles["name"][$key],'msg'=>'格式錯誤');
                }
            }else{
                $arr[]=array('state'=>2,'name'=>$upfiles["name"][$key],'msg'=>'上傳失敗');
            }
        }
    }
    return $arr;
}

//檔案上傳處理(檔案欄位,目錄,大圖尺寸,小圖尺寸,裁切,限制檔案大小單位位元)
function imgUpload($upfiles,$dir,$bigsize=null,$smallsize=null,$type='equal',$filesize=2048){
    if(is_array($upfiles["error"])){			
        foreach($upfiles["error"] as $key=>$error){
            if(($upfiles["size"][$key]/1024)>=$filesize){
                $arr[]=array('state'=>2,'name'=>$upfiles["name"],'msg'=>'檔案太大');
            }else if($error==UPLOAD_ERR_OK){
                $ext=strtolower(pathinfo($upfiles["name"][$key], PATHINFO_EXTENSION));
                if($ext=='jpg' || $ext=='gif' || $ext=='png' || $ext=='jpeg'){
                    $upfilesname=randMix(9,1,2).".".$ext;
                    move_uploaded_file($upfiles["tmp_name"][$key],$dir.$upfilesname);	
                    $arr[]=array('state'=>1,'name'=>$upfiles["name"][$key],'path'=>$upfilesname,'msg'=>'上傳成功');
                    //echo $upfiles["name"][$key]."上傳成功<br>";
                    //echo $upfiles["type"][$key]."<br>";
                    //echo $upfiles["size"][$key]."<br>";						
                    //將圖片縮放為指定大小
                    if($bigsize!=null){
                        if(is_array($bigsize))					
                            imageResize($dir.$upfilesname,'',$bigsize[0],$bigsize[1],$type);
                        else
                            imageResize($dir.$upfilesname,'',$bigsize,'',$type);
                    }
                    //將圖片裁切為指定大小
                    if($smallsize!=null){
                        $smallname=str_ireplace(".$ext","",$upfilesname).'s.'.$ext;
                        imageResize($dir.$upfilesname,$dir.$smallname,$smallsize[0],$smallsize[1],1);	
                    }			
                }else{
                    $arr[]=array('state'=>2,'name'=>$upfiles["name"][$key],'msg'=>'格式錯誤');
                }
            }else{
                $arr[]=array('state'=>2,'name'=>$upfiles["name"][$key],'msg'=>'上傳失敗');
            }
        }
        return $arr;
    }
}

function read_file($filename = "test")
{
    $arr = array();
    //判斷是否有該檔案
    if(file_exists($filename)){
        $file = fopen($filename, "r");
        if($file != NULL){
            //當檔案未執行到最後一筆，迴圈繼續執行(fgets一次抓一行)
            while (!feof($file)) {
                $arr[] = fgets($file);
            }
            fclose($file);
        }
    }
    return $arr;
}

function write_file($filename = "test.xml", $str)
{
    $file = fopen($filename,"a+"); //開啟檔案
    fwrite($file, $str);
    fclose($file);
}

/**
 * Get an item from an array using "dot" notation.
 */
function array_get($array, $key, $default = null)
{
    $result = array_keys($array, $key);
    return (isset($result) && !is_null($result))? $result : $default;
}

/**
 * Get an item from an array or object using "dot" notation.
 */
function data_get($target, $key, $default = null)
{
    // key 是空的就直接回傳
    if (is_null($key)) {
        return $target;
    }

    // key 除了用 `.` 區隔外，也可以使用 array
    $key = is_array($key) ? $key : explode('.', $key);

    // 將 key 一個一個拿出來跑 
    while (! is_null($segment = array_shift($key))) {
        // 如果是 * 的話
        if ($segment === '*') {
            if (! is_array($target)) {
                // 如果不是 Collection，也不是 array 的話，代表取資料的 key 有問題，直接回預設值
                return $default;
            }

            // 依 key 取得裡面的 value，然後重組成 array
            $result = array_keys($target, $key);
            
            return $result;
        }

        if (is_array($target) && array_key_exists($segment, $target)) {
            // 如果 $target 是個 array 且有資料的話，就使用 array 方法取資料
            $target = $target[$segment];
        } elseif (is_object($target) && isset($target->{$segment})) {
            // 如果 $target 是個 object 且有資料的話，就使用 object 方法取資料
            $target = $target->{$segment};
        } else {
            // 都不是的話，key 是有問題的，只好回傳預設值
            return $default;
        }
    }
    
    // 回傳最後取到的 target
    return $target;
}

/**
 * Get an item from an object using "dot" notation.
 */
function object_get($object, $key, $default = null)
{
    // 如果 key 是空的，就把整個 object 回傳
    if (is_null($key) || trim($key) == '') {
        return $object;
    }
    
    // 依續把每個階層的 key，用來取得 object 的屬性
    foreach (explode('.', $key) as $segment) {
        // 如果不是 object 或屬性不存在的時候，就回傳預設值
        if (! is_object($object) || ! isset($object->{$segment})) {
            return $default;
        }
        
        // 重設 object 為下一個階層
        $object = $object->{$segment};
    }
    
    // 最後取得的 property 即結果
    return $object;
}

function cc()
{
    try{

        die();

    } catch( Exception $e) {
        $mess = array('statue' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode() );
        write_file('logs/file.txt', json_encode($mess, JSON_UNESCAPED_UNICODE));
        return $mess;
    }
    return array('statue' => 1, 'message' => $e->getMessage(), 'code' => $e->getCode() );
}


/*
 * How to write own DD() function same as laravel?
 */ 
function d($data){
    if(is_null($data)){
        $str = "<i>NULL</i>";
    }elseif($data == ""){
        $str = "<i>Empty</i>";
    }elseif(is_array($data)){
        if(count($data) == 0){
            $str = "<i>Empty array.</i>";
        }else{
            $str = "<table style=\"border-bottom:0px solid #000;\" cellpadding=\"0\" cellspacing=\"0\">";
            foreach ($data as $key => $value) {
                $str .= "<tr><td style=\"background-color:#008B8B; color:#FFF;border:1px solid #000;\">" . $key . "</td><td style=\"border:1px solid #000;\">" . d($value) . "</td></tr>";
            }
            $str .= "</table>";
        }
    // }elseif(is_resource($data)){
        // while($arr = mysql_fetch_array($data)){
        //     $data_array[] = $arr;
        // }
        // $str = d($data_array);
    }elseif(is_object($data)){
        $str = d(get_object_vars($data));
    }elseif(is_bool($data)){
        $str = "<i>" . ($data ? "True" : "False") . "</i>";
    }else{
        $str = $data;
        $str = preg_replace("/\n/", "<br>\n", $str);
    }
    return $str;
}

function dnl($data){
    echo d($data) . "<br>\n";
}

function dd($data){
    // array_map(function($x) { var_dump($x); }, func_get_args()); 
    // die;
    echo dnl($data);
    exit;
}

function ddt($message = ""){
    echo "[" . date("Y/m/d H:i:s") . "]" . $message . "<br>\n";
}


    
/*
* 以下可以用就用
*/

/* FILTER_VALIDATE_EMAIL：把值作為e-mail來驗證。 */
function _isValidEmail ( $email )
{
    return filter_var( $email, FILTER_VALIDATE_EMAIL ) !== false;
}

/* PHP正則表達式-使用preg_match()過濾字串 */
function _isValid ( $type = 'number' , $input_text = '' )
{
    switch ( $type ){
        //A. 檢查是不是數字
        case 'number':
            if (preg_match( "/^([0-9]+)$/", $input_text ) || strlen( $input_text ) > 99) {
                return true;
            }
            break;
        //B. 檢查是不是小寫英文
        case 'small_english':
            if (preg_match( "/^([a-z]+)$/", $input_text ) || strlen( $input_text ) > 99) {
                return true;
            }
            break;
        //C. 檢查是不是大寫英文
        case 'big_english':
            if (preg_match( "/^([A-Z]+)$/", $input_text ) || strlen( $input_text ) > 99) {
                return true;
            }
            break;
        //D. 檢查是不是全為英文字串
        case 'english':
            if (preg_match( "/^([A-Za-z]+)$/", $input_text ) || strlen( $input_text ) > 99) {
                return true;
            }
            break;
        //E. 檢查是不是英數混和字串
        case 'number+english':
            if (preg_match( "/^([0-9A-Za-z]+)$/", $input_text ) || strlen( $input_text ) > 99) {
                return true;
            }
            break;
        //F. 檢查是不是中文
        case 'chinese':
            if (preg_match( "/^([\x7f-\xff]+)$/", $input_text ) || strlen( $input_text ) > 99) {
                return true;
            }
            break;
    }
    return false;
}

function _isValidIDNum ( $id )
{
    //建立字母分數陣列
    $head = [ 'A' => 1, 'I' => 39, 'O' => 48, 'B' => 10, 'C' => 19, 'D' => 28,
        'E' => 37, 'F' => 46, 'G' => 55, 'H' => 64, 'J' => 73, 'K' => 82,
        'L' => 2, 'M' => 11, 'N' => 20, 'P' => 29, 'Q' => 38, 'R' => 47,
        'S' => 56, 'T' => 65, 'U' => 74, 'V' => 83, 'W' => 21, 'X' => 3,
        'Y' => 12, 'Z' => 30 ];
    //建立加權基數陣列
    $multiply = [ 8, 7, 6, 5, 4, 3, 2, 1 ];
    //檢查身份字格式是否正確
    if (preg_match( "/^[a-zA-Z][1-2][0-9]+$/", $id ) && strlen( $id ) == 10) {
        //切開字串
        $len = strlen( $id );
        for ($i = 0 ; $i < $len ; $i++) {
            $stringArray[$i] = substr( $id, $i, 1 );
        }
        //取得字母分數
        $total = $head[array_shift( $stringArray )];
        //取得比對碼
        $point = array_pop( $stringArray );
        //取得數字分數
        $len = count( $stringArray );
        for ($j = 0 ; $j < $len ; $j++) {
            $total += $stringArray[$j] * $multiply[$j];
        }
        //檢查比對碼
        if (( $total % 10 == 0 ) ? 0 : 10 - $total % 10 != $point) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function _get_https_url ()
{
    $https = !empty( $_SERVER ['HTTPS']) && strcasecmp( $_SERVER ['HTTPS'], 'on') === 0 || !empty ( $_SERVER ['HTTP_X_FORWARDED_PROTO'] ) && strcasecmp( $_SERVER ['HTTP_X_FORWARDED_PROTO'], 'https' ) === 0;

    return ( $https ? 'https://' : 'http://' );
}

function _get_full_url ()
{
    $https = !empty ( $_SERVER ['HTTPS'] ) && strcasecmp( $_SERVER ['HTTPS'], 'on' ) === 0 || !empty ( $_SERVER ['HTTP_X_FORWARDED_PROTO'] ) && strcasecmp( $_SERVER ['HTTP_X_FORWARDED_PROTO'], 'https' ) === 0;

    return ( $https ? 'https://' : 'http://' ) . ( !empty ( $_SERVER ['REMOTE_USER'] ) ? $_SERVER ['REMOTE_USER'] . '@' : '' ) . ( isset ( $_SERVER ['HTTP_HOST'] ) ? $_SERVER ['HTTP_HOST'] : ( $_SERVER ['SERVER_NAME'] . ( $https && $_SERVER ['SERVER_PORT'] === 443 || $_SERVER ['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER ['SERVER_PORT'] ) ) ) . substr( $_SERVER ['SCRIPT_NAME'], 0, strrpos( $_SERVER ['SCRIPT_NAME'], '/' ) );
}

/**
 * @param $url 请求网址
 * @param bool $params 请求参数
 * @param int $ispost 请求方式
 * @param int $https https协议
 * @return bool|mixed
 */
function curl ( $url, $https = 1, $ispost = 0, $params = false )
{
    $httpInfo = [];
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    if ($https) {
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false ); // 对认证证书来源的检查
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false ); // 从证书中检查SSL加密算法是否存在
    }
    if ($ispost) {
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );
        curl_setopt( $ch, CURLOPT_URL, $url );
    } else {
        if ($params) {
            if (is_array( $params )) {
                $params = http_build_query( $params );
            }
            curl_setopt( $ch, CURLOPT_URL, $url . '?' . $params );
        } else {
            curl_setopt( $ch, CURLOPT_URL, $url );
        }
    }

    $response = curl_exec( $ch );

    if ($response === false) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo, curl_getinfo( $ch ) );
    curl_close( $ch );

    return $response;
}


/** 
* @desc 根據兩點間的經緯度計算距離 
* @param float $lat 緯度值 
* @param float $lng 經度值 
*/ 
function getDistance($lat1, $lng1, $lat2, $lng2) 
{ 
    $earthRadius = 6367000; //approximate radius of earth in meters 
    /* 
    Convert these degrees to radians 
    to work with the formula 
    */ 
    $lat1 = ($lat1 * pi() ) / 180; 
    $lng1 = ($lng1 * pi() ) / 180; 
    $lat2 = ($lat2 * pi() ) / 180; 
    $lng2 = ($lng2 * pi() ) / 180; 
    /* 
    Using the 
    Haversine formula 
    http://en.wikipedia.org/wiki/Haversine_formula 
    calculate the distance 
    */ 
    $calcLongitude = $lng2 - $lng1; 
    $calcLatitude = $lat2 - $lat1; 
    $stepOne = pow(sin($calcLatitude / 2), 2) * cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2); 
    $stepTwo = 2 * asin(min(1, sqrt($stepOne))); 
    $calculatedDistance = $earthRadius * $stepTwo; 
    return round($calculatedDistance); 
} 