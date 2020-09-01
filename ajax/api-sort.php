<?php
	require('./../config.php');
	@session_start();
	header("Content-Type:text/html;charset=utf-8");
	authUser($_SESSION[ADMIN_SESSION.'_id'],$_SESSION[ADMIN_SESSION.'_level'],2);
	
	$tablename=$_POST["tablename"]; // 資料表名稱
	$idsort=$_POST["sel_no"]; //id排序
	$sql="UPDATE $tablename SET `sortnum`=? WHERE `no`=?";
  	$rs=$db->prepare($sql);

  	$count=0;
	for($i=0,$imax=count($idsort);$i<$imax;$i++){
		$params=[$i+1,$idsort[$i]];
		$rs->execute($params);
		$count+=$rs->rowCount();
	}		
	$msg = "成功更新 $count 筆資料";
	echo $msg;
?>
 