<?php
	require('./../config.php');
	@session_start();
	header("Content-Type:text/html;charset=utf-8");
	authUser($_SESSION[ADMIN_SESSION.'_id'],$_SESSION[ADMIN_SESSION.'_level'],2);
	ini_set('upload_max_filesize', '15M');
	
	// init
	$upfiles=$_FILES[$_POST['uploadid']];
	$dir=$_POST['uploadfilepath'];
	$type=['pdf','doc','docx','xls','xlsx','odt','ods','odp','odb','odf','rar','zip','jpg','jpeg','png'];
	$filesize=15000;

	// conversion file location
	$scripturl=isset($_SERVER['HTTPS'])?'https://':'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
	$posturl=$_SERVER['HTTP_REFERER']??$scripturl;
  	$modi=dirname(getRelativePath($posturl,$scripturl)).'/';
	$dir=preg_replace('/'.str_replace('/','\/',$modi).'/i', '',$dir,1);

	// upload file
	$file=fileUpload($upfiles,$dir,$type,$filesize);
	echo json_encode($file,JSON_UNESCAPED_UNICODE); 
?>