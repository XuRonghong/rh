<?php


function cc()
{
    try{

		// FuncController::addActionLog('create', $author_id, $value, $model->id, $model->getTable() );

        // $log_login = new LogAction();
        // $log_login->user_id = $user_id;
        // $log_login->user_type = Admin::query()->find($user_id)->type;
        // $log_login->table_id = $table_id;
        // $log_login->table_name = $table_name;
        // $log_login->action = $action;
        // $log_login->value = $value;
        // $log_login->ip = Request::ip();
        // $log_login->save();
		
        die();

    } catch( Exception $e) {
        $mess = array('statue' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode() );
        write_file('logs/file.txt', json_encode($mess, JSON_UNESCAPED_UNICODE));
        return $mess;
    }
    return array('statue' => 1, 'message' => $e->getMessage(), 'code' => $e->getCode() );
}


//log紀錄(帳號,狀態,是否顯示)   ex: logInsert(ADMIN_LOG,$_SESSION[ADMIN_SESSION.'_id'],$msg);
function logInsert($tablename,$id,$edit,$trace=null){
	global $db;
	//記錄所有傳入參數值
	$_request = $_REQUEST;
	array_except($_request, ['_token']);
	//密碼加密處理
	if( isset($_request['password']) ){
		$_request['password'] = hash('sha256', $_request['password']);
	}
	$_request = json_encode($_request, JSON_UNESCAPED_UNICODE);

	$page=(isset($_SERVER['HTTPS'])?'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$sql = "INSERT INTO $tablename (`user`, `edit`, `page`, `value`, `ip1`, `ip2`,`created_at`)".
			"VALUES (?,?,?,?,'".$_SERVER['REMOTE_ADDR']."','". getClientIP()."',NOW())";  
	$params=array($id,$edit,$page, $_request);
	$rs=$db->prepare($sql);
	$rs->execute($params);
	if($trace) echo $sql;
	return $rs->rowCount();
}


function csrf_token()
{    
    if (empty($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
    $token = $_SESSION['token'];
    return $token;
}


function array_except(&$arr, $keys=[])
{
    if(is_array($keys)) {
        foreach($keys as $key) {
            if(array_key_exists($key, $arr)) {
                unset($arr[ $key]);
            }
        }
    } else {        
        if(array_key_exists($keys, $arr)) {
            unset($arr[ $keys]);
        } else {
            return false;
        }
    }
    return true;
}


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
			
            $target = $target[$segment] ? $target[$segment] : $default;
        } elseif (is_object($target) && isset($target->{$segment})) {
            // 如果 $target 是個 object 且有資料的話，就使用 object 方法取資料
            $target = $target->{$segment} ? $target->{$segment} : $default;
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
                $str .= "<tr><td style=\"background-color:#008B8B; color:#FFF;border:1px solid #000;\">" . $key . "</td><td style=\"border:1px solid #000;\">(".gettype($value).")" . d($value) ."</td></tr>";
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
    die();
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




	/*!
	 * Exlocus (with Agi)
	 * Copyright (c) 2015
	 * Version: 1.0.5 (2020-2-4)
	 * PHP 7.0
	 */
	
	//=========== 驗證資料函數 =============//
	
	// 驗證時間是否重疊
	function isTimeBetween($x,$y,$change=true){
	    if($change){
	      $x[0]=strtotime($x[0]);
	      $x[1]=strtotime($x[1]);
	      $y[0]=strtotime($y[0]);
	      $y[1]=strtotime($y[1]);
	    }
	    if(($x[0]<=$y[0]&&$x[1]>=$y[0])||($x[0]<=$y[1]&&$x[1]>=$y[1])||($y[0]<=$x[0]&&$y[1]>=$x[0])||($y[0]<=$x[1]&&$y[1]>=$x[1])){
	     	return true;
	    }else{
	    	return false;
	    }
	}

	// 驗證中國身分證號碼
	function isChinaID($idcard){ 
		if(strlen($idcard)==18){ 
	    	return isChinaID_checksum18($idcard); 
		}elseif((strlen($idcard)==15)){ 
			// 将15位身份证升级到18位 
			if(strlen($idcard)!=15){ 
					return false; 
			}else{ 
				// 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码 
				if(array_search(substr($idcard,12,3),array('996','997','998','999')) !== false){ 
					$idcard=substr($idcard,0,6).'18'.substr($idcard,6,9); 
				}else{ 
				  $idcard=substr($idcard,0,6).'19'.substr($idcard,6,9); 
				} 
			} 
			$idcard=$idcard.isChinaID_verify($idcard); 
			return isChinaID_checksum18($idcard); 
		}else{ 
	    	return false; 
		} 
	}

	// 计算身份证校验码，根据国家标准GB 11643-1999 
	function isChinaID_verify($idcard_base){ 
	 if(strlen($idcard_base)!=17){ 
	 return false; 
	 } 
	 //加权因子 
	 $factor=array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2); 
	 //校验码对应值 
	 $verify_number_list=array('1','0','X','9','8','7','6','5','4','3','2'); 
	 $checksum=0; 
	 for($i=0;$i<strlen($idcard_base);$i++){ 
	 $checksum += substr($idcard_base,$i,1) * $factor[$i]; 
	 } 
	 $mod=$checksum % 11; 
	 $verify_number=$verify_number_list[$mod]; 
	 return $verify_number; 
	} 
	
	// 18位身份证校验码有效性检查 
	function isChinaID_checksum18($idcard){ 
		if(strlen($idcard)!=18){ 
	 		return false; 
		} 
		$idcard_base=substr($idcard,0,17); 
		if(isChinaID_verify($idcard_base)!=strtoupper(substr($idcard,17,1))){ 
			return false; 
		}else{ 
			return true; 
		} 
	} 

    // 驗證台灣身分證號碼
	function isTaiwanID($cardid){
	    $err=false;
	    $alphabet =['A'=>'10','B'=>'11','C'=>'12','D'=>'13','E'=>'14','F'=>'15','G'=>'16','H'=>'17','I'=>'34',
	                'J'=>'18','K'=>'19','L'=>'20','M'=>'21','N'=>'22','O'=>'35','P'=>'23','Q'=>'24','R'=>'25',
	                'S'=>'26','T'=>'27','U'=>'28','V'=>'29','W'=>'32','X'=>'30','Y'=>'31','Z'=>'33'];

	    //檢查字元長度
	    if(strlen($cardid) !=10){
	        $err=true;
	    }

	    //驗證英文字母正確性
	    $alpha = substr($cardid,0,1);//英文字母
	    $alpha = strtoupper($alpha);//若輸入英文字母為小寫則轉大寫
	    if(!preg_match("/[A-Za-z]/",$alpha)){
	        $err=true;
	    }else{
	        //計算字母總和
	        $nx = $alphabet[$alpha];
	        $ns = $nx[0]+$nx[1]*9;
	    }

	    //驗證男女性別
	    $gender = substr($cardid,1,1);
	    if($gender !='1' && $gender !='2'){
	        $err=true;
	    }

	    if($err ==''){
	        $i = 8;
	        $j = 1;
	        $ms =0;
	        while($i >= 2){
	            $mx = substr($cardid,$j,1);
	            $my = $mx * $i;
	            $ms = $ms + $my;
	            $j+=1;
	            $i--;   
	        }
	        $ms = $ms + substr($cardid,8,1) + substr($cardid,9,1);
	        $total = $ns + $ms;
	        if( ($total%10) !=0){
	            $err=true;
	        }
	        return !$err;
	    }
	}

	// 複製資料夾中的所有檔案到指定目錄
	function dirCopy($form,$to,$echo=false){
	    if(!is_dir($form)){
	      mkdir($form,0777);
	    }
	    if(!is_dir($to)){
	      mkdir($to,0777);
	    }
	    $file=scandir($form);
	    foreach ($file as $value) {
	    	if($value!='.'&&$value!='..'){
		        if (is_dir($form.$value.'/')){
		          	$newfrom=$form.$value;
		          	if(substr($newfrom,-1)!='/'){
		            	$newfrom=$newfrom.'/';
		          	}
		          	$newto=$to.basename($newfrom);
		          	if(substr($newto,-1)!='/'){
		            	$newto=$newto.'/';
		          	}
		          	if(!is_dir($newto)){
		            	mkdir($newto,0777);
		          	}
		          	if($echo){
		            	echo '<strong>'.$newfrom.'</strong><br>';
		          	}
		          	dirCopy($newfrom,$newto);
		        }else{
		          	if($echo){
		            	echo $to.$value.'<br>';
		          	}
		          	copy($form.$value, $to.$value);
		        }
	      	}
	    }
	}

	/**
	 * 生成 Google 行事曆網址
	 * @param  array[title, content, start, end, location]
	 * @return string
	 */
	function getGoogleCalendar($data) {
	    $startdate = date("Ymd\THis\Z", strtotime(date('Y-m-d H:i:s',strtotime('-8 hour',strtotime($data['start'])))));
	    $enddate = date("Ymd\THis\Z", strtotime(date('Y-m-d H:i:s',strtotime('-8 hour',strtotime($data['end'])))));

	    $query = [
	        'action' => 'TEMPLATE',
	        'text' => $data['title'],
	        'dates' => "{$startdate}/{$enddate}",
	        'details' => $data['content'],
	        'location' => $data['location']
	    ];

	    $query = http_build_query($query);
	    return "https://www.google.com/calendar/render?$query";
	}

	//取得使用者ip
	function getClientIP(){
		foreach (array(
					'HTTP_CLIENT_IP',
					'HTTP_X_FORWARDED_FOR',
					'HTTP_X_FORWARDED',
					'HTTP_X_CLUSTER_CLIENT_IP',
					'HTTP_FORWARDED_FOR',
					'HTTP_FORWARDED',
					'REMOTE_ADDR') as $key) {
			if (array_key_exists($key, $_SERVER)) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					$ip = trim($ip);
					if ((bool) filter_var($ip, FILTER_VALIDATE_IP,
									FILTER_FLAG_IPV4 |
									FILTER_FLAG_NO_PRIV_RANGE |
									FILTER_FLAG_NO_RES_RANGE)) {
						return $ip;
					}
				}
			}
		}
		return null;
	}

	// 取得路徑關係
	function getRelativePath($from, $to) {
	    $from = is_dir($from) ? rtrim($from, '\/') . '/' : $from;
	    $to   = is_dir($to)   ? rtrim($to, '\/') . '/'   : $to;
	    $from = str_replace('\\', '/', $from);
	    $to   = str_replace('\\', '/', $to);

	    $from     = explode('/', $from);
	    $to       = explode('/', $to);
	    $relPath  = $to;

	    foreach($from as $depth => $dir) {
	        if($dir === $to[$depth]) {
	            array_shift($relPath);
	        } else {
	            $remaining = count($from) - $depth;
	            if($remaining > 1) {
	                $padLength = (count($relPath) + $remaining - 1) * -1;
	                $relPath = array_pad($relPath, $padLength, '..');
	                break;
	            } else {
	                $relPath[0] = './' . $relPath[0];
	            }
	        }
	    }
	    return implode('/', $relPath);
	}

	//getfile抓取資料
	function getFileContent($file){
		if($file=='') return '';
		$str='';
		if(file_exists($file)){
	      $str=preg_replace('/<.*(>|$)/Us', '',file_get_contents($file));
	    }
		return $str;
	}

	//Curl抓取網頁
	function getCurlContent($url,$query=[],$ssl=true,$cookie_file=null){
		$ch = curl_init($url);
		if($ssl){
			curl_setopt($ch,CURLOPT_HEADER, false);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			if(count($query)>0){
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query)); 
			}
		}else{
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使用上面的cookies
		}
		$curlrs = curl_exec($ch);
		curl_close($ch);
		return $curlrs;
	}

	//Curl抓取網頁
	function getCurlJSONP($url,$query){
		$query=json_encode($query);
		$ch = curl_init($url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
		    'Content-Type: application/json',
		    'Content-Length: '.strlen($query)
		]);
		$curlrs = curl_exec($ch);
		curl_close($ch);
		return $curlrs;
	}


	//=========== 字串處理函數 =============//

	//過濾變數
	function filterVar($arr){
		if(count($arr)==0) return [];
		foreach($arr as $key => $value){
			if(is_array($value)){
				$newarr[$key]=filterVar($value);		
			} else{
				$newarr[$key]=trim( filterXXS($value) );
			}
		}
		if(count($newarr)==0){
			$newarr[]=0;//避免空值運算錯誤
		}
		return $newarr;
	}

	//過濾XXS
	function filterXXS($str){
		if(!isset($str)||$str=='') return NULL;
	    return htmlentities( mb_convert_encoding($str, 'UTF-8', 'UTF-8'), ENT_QUOTES, 'UTF-8');
	}

	//判斷字串末端是否為指定字串,若無則自動加上
	function strEndAdd($str,$x){
		if(!strrpos($str,$x)==(strlen($str)-1))
			$str=$str.$x;
		return $str;
	}
	
	//判斷字串末端是否為指定字串,若有則自動移除
	function strEndRemove($str,$x){
		if(strrpos($str,$x)==(strlen($str)-1))
			$str=substr($str,0,strlen($str)-1);
		return $str;
	}

	//移除並自動加上反斜線
	function strInSql($str){		
		return $str=trim(addslashes(stripslashes($str)));
	}

	//限定字數,去除html標籤
	function strLimitChar($str,$len,$morechr="",$type="utf8"){
		$str = preg_replace ('/<[^>]*>/', ' ', $str); 
		$str = mb_strimwidth(strip_tags($str), 0, $len, $morechr, $type);
		return $str;
	}

	//將流水號的字串轉換為陣列
	function strToList($imax,$var,$str){
		for($i=1;$i<=$imax;$i++){
			if(stristr($str,"$i$var")){
				if(stristr($str,($i+1).$var)){
					$arr[$i]=trim(substr($str,0,stripos($str,($i+1).$var)));
					$str=str_replace($arr[$i],'',$str);
					$arr[$i]=str_replace("$i$var",'',$arr[$i]);
				}else{
					$arr[$i]=str_replace("$i$var",'',trim($str));
				}
			}
		}	
		return $arr;
    }
    
	// 全形轉半形
	function strFullToHalf($str) {
		$arr = array(
			'０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4', '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9', 'Ａ' => 'A', 'Ｂ' => 'B', 'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E', 'Ｆ' => 'F', 'Ｇ' => 'G', 'Ｈ' => 'H', 'Ｉ' => 'I', 'Ｊ' => 'J', 'Ｋ' => 'K', 'Ｌ' => 'L', 'Ｍ' => 'M', 'Ｎ' => 'N', 'Ｏ' => 'O', 'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R', 'Ｓ' => 'S', 'Ｔ' => 'T', 'Ｕ' => 'U', 'Ｖ' => 'V', 'Ｗ' => 'W', 'Ｘ' => 'X', 'Ｙ' => 'Y',	'Ｚ' => 'Z', 'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd',	'ｅ' => 'e', 'ｆ' => 'f', 'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i',	'ｊ' => 'j', 'ｋ' => 'k', 'ｌ' => 'l', 'ｍ' => 'm', 'ｎ' => 'n',	'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 'ｒ' => 'r', 'ｓ' => 's',	'ｔ' => 't', 'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 'ｘ' => 'x',	'ｙ' => 'y', 'ｚ' => 'z','（' => '(', '）' => ')', '〔' => '[', '〕' => ']', '【' => '[', '】' => ']','＠'=>'@');
		return strtr($str, $arr);
	}

	/**
	 * function MaskString(): Mask a string for security.
	 * @scope public
	 * @param string $s : input string, >2 characters long string
	 * @param interger $masknum : the number of characters in the middle of a string to be masked,
	          if masknum is negative, the returned string will leave abs(masknum) characters in 
	          both end untouched.
	 * @return a masked string
	 * ex. MaskString( "12345678",3)  : 123***78
	 * ex. MaskString( "12345678",-3)  : 12*****8
	 */
	 function strMask($s, $masknum=3){ 
	   $len= strlen($s);
	   if($masknum<0) $masknum = $len + $masknum;
	   if($len<3)return $s;
	   elseif( $len< $masknum+1)return substr( $s, 0,1). str_repeat('*',$len-2). substr( $s, -1);
	   $right=  ($len-$masknum)>>1;
	   $left= $len- $right- $masknum;
	   return substr( $s, 0,$left). str_repeat('*',$len-$right-$left). substr( $s, -$right);
	 }

	//清除class,style
	function clearClassStyleTag($str){
		$str=preg_replace('/style=\"(.*?)\"/i','',$str);
		$str=preg_replace('/class=\"(.*?)\"/i','',$str);
		return $str;
	}
	
	//清除换行符號,定位符號,轉換特殊字元,多餘空白
	function clearRNTCode($str){
		$str=str_replace("\r\n",'',$str);
		$str=str_replace("\n",'',$str);
		$str=str_replace("\t",'',$str);
		$str=str_replace("  ",'',$str);
		return trim($str);
	}

	//隨機數字
	function randNumStr($imax=20){
		$str='';
		for($i=0;$i<$imax;$i++){
			$str.=rand(0,9);
		}
		return $str;
	}
	//隨機英文小寫
	function randazStr($imax=20){
		$str='';
		for($i=0;$i<$imax;$i++){
			$str.=Chr(rand(97,112));
		}
		return $str;
	}
	//隨機數字+英文小寫
	function randStr($imax=20){
		$str='';
		for($i=0;$i<$imax;$i++){
			$str.=(rand(1,2)==1)?rand(0,9):Chr(rand(97,112));
		}
		return $str;
	}
	
	//時間+隨機數字
	function randTimeStr($imax=20){
		$str='';
		$imax-=11;
		for($i=0;$i<$imax;$i++){
			$str.=rand(0,9);
		}
		return time().$str;
	}
	
	//時間+隨機數字+英文大小寫
	function randMix($imax=20,$addtime=null,$type=3){
		$str='';
		for($i=0;$i<$imax;$i++){
			$gettype=rand(1,$type);
			if($gettype==1)
				$str.=rand(0,9);
			else if($gettype==2)
				$str.=Chr(rand(97,112));
			else if($gettype==3)
				$str.=Chr(rand(65,90));
		}
		if($addtime!=null)
			$str=time().$str;
		$str=str_split($str);
	    shuffle($str);
		return implode('',$str);
	}

	function hex2rgb($colour) {   
	    if ($colour [0] == '#') {   
	        $colour = substr ( $colour, 1 );   
	    }   
	    if (strlen ( $colour ) == 6) {   
	        list ( $r, $g, $b ) = array ($colour [0] . $colour [1], $colour [2] . $colour [3], $colour [4] . $colour [5] );   
	    } elseif (strlen ( $colour ) == 3) {   
	        list ( $r, $g, $b ) = array ($colour [0] . $colour [0], $colour [1] . $colour [1], $colour [2] . $colour [2] );   
	    } else {   
	        return false;   
	    }   
	    $r = hexdec ( $r );   
	    $g = hexdec ( $g );   
	    $b = hexdec ( $b );   
	    return array ('red'=>$r,'green'=>$g,'blue'=>$b);   
  	}

	// 將一維陣列轉成關聯陣列
	function arrayToAssoc($arr){
		$newarr=[];
		foreach ($arr as $key => $value) {
			$newarr[$value]=NULL;
		}
		return $newarr;
  	}

	// 以一個陣列當作索引值取出另一個陣列
	function arrayIndexKey($arrindex,$arrvalue){
		$arr=[];
		for($i=0,$imax=count($arrindex);$i<$imax;$i++){
			if(!empty($arrvalue[$arrindex[$i]])){
				$arr[$arrindex[$i]]=$arrvalue[$arrindex[$i]];
			}else{
				$arr[$arrindex[$i]]='';
			}
		}
		return $arr;
	}

	// 修正php傳輸時將 '.' 轉成 '_'
	function arrayModiKey($arr,$modi){
	    if (count($arr)==0) return [];
	    foreach ($modi as $key => $value) {
	      	if(!strpos($value,'.')===false){
	        	$str=str_replace('.','_',$value);
	    		if(isset($arr[$str])){
	          		$arr[$value]=$arr[$str];
	          		unset($arr[$str]);
	    		}
	    	}
	    }
	    return $arr;
	}

	//javascript訊息及連結
	function alertHref($msg,$href=null){
		$str='<script language="JavaScript" type="text/JavaScript">';
		if($msg!=""){
			$str.="alert(\"$msg\");";
		}
		if($href=="this"){
			echo 456;
			$str.="";
		}else if($href!=""){
			$str.="window.location.href=\"$href\";";
		}else{
			$str.='history.go(-1);';
		}
		$str.='</script>';
		echo $str;
	}

	//認證
	function authUser($id,$rightlevel,$limitlevel=1,$url='../../index.php'){
		if($id==''){			
			alertHref('',$url.'?msg=請先登入！');
		}else{
			if($rightlevel<$limitlevel){
				$msg='你沒有此權限！';
				if(stripos($_SERVER['HTTP_REFERER'],'?')===false)
					alertHref('',$_SERVER['HTTP_REFERER']."?msg=$msg");
				else
					alertHref('',str_replace("msg=$msg",'',str_replace("&msg=$msg",'',urldecode($_SERVER['HTTP_REFERER'])))."&msg=$msg");				
				exit();
			}
		}
    }
    
	//抓取縮圖名稱後面+s
	function getSmallImg($imgname){		
		$ext=strtolower(pathinfo($imgname, PATHINFO_EXTENSION));
		return str_ireplace(".$ext","s.$ext",$imgname);
	}