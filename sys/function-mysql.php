<?php
	/*!
	 * Exlocus (with Agi)
	 * Copyright (c) 2015
	 * Version: 1.0.5 (2018-8-29)
	 * PHP 7.0
	 */


	//=========== 變數轉換成sql與get函數 =============//
	
	// 轉換陣列名稱	
	function replaceArrayKey($arr,$x,$y){
		if(count($arr)==0) return [];
		foreach($arr as $key => $value){
			$newkey=ereg_replace($x,$y,$key);
			$newarr[$newkey]=$value;
		}
		return $newarr;
	}

	// 取得where字串,指定名稱
	function getSqlWhereOnly($arr,$name,$operator='AND',$case='='){
		$str='';
		for ($i=0;$i<count($arr);$i++) {
			if($str){
				$str.=' '.$operator.' ';
			}
			if($case=='=')
				$str.="`$name`={$arr[$i]}";
			else if($case=='LIKE')
				$str.="`$name` LIKE '%{$arr[$i]}%'";
		}
		return $str;
	}

	// 取得where字串,指定名稱
	function getSqlWhereIn($arr,$name){
	    if(count($arr)==0) return false;
		$str='';
		for ($i=0,$imax=count($arr);$i<$imax;$i++) {
			if($str){
	        	$str.=",";
	        }
			$str.='?';
		}
		return "$name IN($str)";
	}

  	// 取得 pdo where字串,指定條件(變數陣列,條件陣列,運算子)
  	function getSqlWhere($arr,$case,$operator='AND'){
	    if(count($arr)==0) return false;
		$str='';
	    foreach($arr as $key => $value){
	      	if(strpos($value,' ')){
	        	if($str){
	          		$str.=" $operator ";
	        	}
	        	$jarr=explode(' ',$value);
	        	$substr='';
	        	for($j=0,$jmax=count($jarr);$j<$jmax;$j++){
		          	if($jarr[$j]!=""){
		            	if($substr!=""){
		              	$substr.=" OR ";
		            	}
		            	if(empty($case[$key])){
		              		$substr.="`$key` = :".$key.$j;
		            	}else{
		              		if($case[$key]=="LIKE"){
		                		$substr.="`$key` LIKE :".$key.$j;
		              		}else{
		                		$substr.="`$key` {$case[$key][$j]} :".$key.$j;
		              		}
		            	}
		          	}
	        	}
	        	$str.='('.$substr.')';
	      	}elseif($value!=''){
		        if($str!=''){
		          	$str.=" $operator ";
		        }
		        if(empty($case[$key])){
		          	$str.="`$key` = :$key";
		        }else{
		          	$str.="`$key` {$case[$key]} :$key";
		        }
	      	}
	    }
    	return $str;
  	}

  	// 取得 pdo params值,指定條件(變數陣列,條件陣列)
	function getSqlParams($arr,$case){
	    if(count($arr)==0) return false;
	    foreach($arr as $key => $value){
	      	if(strpos($value,' ')){
		        $value=explode(' ',$value);
		        for($i=0,$imax=count($value);$i<$imax;$i++){
		          	if($case[$key]=="LIKE"){
		            	$arr[$key.$i]='%'.$value[$i].'%';
		          	}else{
		            	$arr[$key.$i]=$value[$i];
		          	}
		        }
	        	unset($arr[$key]);
	      	}else{
		        if(isset($case[$key])&&$case[$key]=="LIKE"){
		        	$arr[$key]='%'.$value.'%';
		        }
	      	}
	    }
	    return $arr;
	}
?>
