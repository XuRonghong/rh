<?php
    require('./../config.php');
    @session_start();
    header("Content-Type:text/html;charset=utf-8");
    authUser($_SESSION[ADMIN_SESSION.'_id'],$_SESSION[ADMIN_SESSION.'_level']);

    // request
    $tablename=$_POST["tablename"]??'';
    $data=$_POST["postdata"]??[];

    // sql
    $json=[];
    for ($i=0,$imax=count($data); $i<$imax; $i++) { 
        if($data[$i]['length']==''){
            $sql="ALTER TABLE `$tablename` ADD `{$data[$i]['name']}` {$data[$i]['type']} NULL DEFAULT {$data[$i]['default']}";
        }else{
            $sql="ALTER TABLE `$tablename` ADD `{$data[$i]['name']}` {$data[$i]['type']}({$data[$i]['length']}) NULL DEFAULT {$data[$i]['default']}";
        }
        $json[]=$sql;
        $rs=$db->query($sql);
    }
    echo json_encode($json,JSON_UNESCAPED_UNICODE);
?>

