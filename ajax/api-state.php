<?php
	require('./../config.php');
	@session_start();
	header("Content-Type:text/html;charset=utf-8");
	authUser($_SESSION[ADMIN_SESSION.'_id'],$_SESSION[ADMIN_SESSION.'_level'],2);

	date_default_timezone_set("Asia/Taipei");//設定時區	
	$tablename=$_POST['tablename'];//資料表名稱

	$no=$_POST['no'];
	$state=$_POST['state'];
	$field=$_POST['field'];
	$statetype=$_POST['type'];

 	//資料處理
	$state=($state>=count($$statetype))?1:$state+1;
	$data[$field]=$state;
	dataUpdate($tablename,$data,"WHERE `no`=?",array($no));

	echo $state;
?>
