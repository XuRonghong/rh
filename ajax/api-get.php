<?php
    require('./../config.php');
    @session_start();
    header("Content-Type:text/html;charset=utf-8");
    authUser($_SESSION[ADMIN_SESSION.'_id'],$_SESSION[ADMIN_SESSION.'_level']);

    // request
    $tablename=$_GET["tablename"]??'';
    $field=($_GET["field"])??'*';
    $params=$_GET["params"]??'';
    $value=($_GET["value"])??'';

    // sql
    $sql="SELECT $field FROM $tablename WHERE isdeleted=1";

    if($params==''){
        $sql.=" AND no=?"; 
    }else{
        $sql.=" AND $params=?"; 
    }
    $params=[$value];

    $rs=$db->prepare($sql);
    $rs->execute($params);
    echo json_encode($rs->fetchAll(PDO::FETCH_ASSOC),JSON_UNESCAPED_UNICODE);
?>

