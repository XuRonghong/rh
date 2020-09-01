<?php
    require('./../config.php');
    @session_start();
    header("Content-Type:text/html;charset=utf-8");
    authUser($_SESSION[ADMIN_SESSION.'_id'],$_SESSION[ADMIN_SESSION.'_level']);

    // request
    $tablename=$_GET["tablename"]??'';
    $label=($_GET["label"])??'';
    $value=($_GET["value"])??'';
    $term=$_GET["term"]??'';
    $input=$_GET["input"]??'';
    $condfield=$_GET["condfield"]??'';
    $condvalue=$_GET["condvalue"]??'';

    // sql
    $labelarr=explode(',',$label);
    $concat=[];
    for($i=0,$imax=count($labelarr);$i<$imax;$i++){
        $concat[]='COALESCE(`'.$labelarr[$i].'`,"")';
    }
    $str=(stripos($label,',')===false)?"`$label`":'CONCAT_WS(" ",'.implode(',',$concat).')';
    $sql="SELECT $str AS `label`, `$value` AS `value` FROM $tablename WHERE isdeleted=1";

    $params=[];
    if($term!=''){
        if(stripos($label,',')===false){
            $sql.=" AND `$label` LIKE ?"; 
            $params[]='%'.$term.'%';
        }else{
            $str='';
            for ($i=0,$imax=count($labelarr); $i<$imax; $i++) { 
                if($str!=''){
                    $str.=' OR ';
                }
                $str.="`{$labelarr[$i]}` LIKE ?"; 
                $params[]='%'.$term.'%';
            }    
            $sql.=" AND ($str)"; 
        }
    }
    if($condfield!=''&&$condvalue!=''){
        $sql.=" AND $condfield =?"; 
        $params[]=$condvalue;
    }
    if($input!=''){
        $sql.=" AND $value =?"; 
        $params[]=$input;
    }

    $rs=$db->prepare($sql.' LIMIT 0,20');
    $rs->execute($params);
    echo json_encode($rs->fetchAll(PDO::FETCH_ASSOC),JSON_UNESCAPED_UNICODE);
?>

