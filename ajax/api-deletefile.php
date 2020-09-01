<?php
	require('./../config.php');
	@session_start();
	header("Content-Type:text/html;charset=utf-8");
	authUser($_SESSION[ADMIN_SESSION.'_id'],$_SESSION[ADMIN_SESSION.'_level'],2);
	
	$files=str_replace('./../../../','./../../',$_POST['files']);
	$err=false;

	if(stripos($files,'/upload/')===false){
		$err=true;
	}
	if(is_file($files)==false){
		$err=true;
	}
	if($err==false){
		echo 'success';
		@unlink($files);
	}else{
		echo 'error';
	}
?>