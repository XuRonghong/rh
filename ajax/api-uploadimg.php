<?php
	require('./../config.php');
	@session_start();
	header("Content-Type:text/html;charset=utf-8");
	authUser($_SESSION[ADMIN_SESSION.'_id'],$_SESSION[ADMIN_SESSION.'_level'],2);
	ini_set('upload_max_filesize', '15M');
	
	// init
	$upfiles=$_FILES[$_POST['uploadid']];
	$dir=$_POST['uploadfilepath'];
	$bigsize=empty($_POST['bigsize'])?[1920,1920]:explode(',',$_POST['bigsize']);
	$type=$_POST['type']??'limit'; // equal, limit, cut
	$filesize=10*1024;

	// conversion file location
	$scripturl=isset($_SERVER['HTTPS'])?'https://':'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
	$posturl=$_SERVER['HTTP_REFERER']??$scripturl;
  	$modi=dirname(getRelativePath($posturl,$scripturl)).'/';
	$dir=preg_replace('/'.str_replace('/','\/',$modi).'/i', '',$dir,1);

	// upload img file
	$img=imgUpload($upfiles,$dir,$bigsize,'',$type,$filesize);
	echo json_encode($img,JSON_UNESCAPED_UNICODE);
?>