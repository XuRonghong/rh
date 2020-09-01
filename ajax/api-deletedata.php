<?php
    require('./../config.php');
    @session_start();
    header("Content-Type:text/html;charset=utf-8");
    authUser($_SESSION[ADMIN_SESSION.'_id'],$_SESSION[ADMIN_SESSION.'_level']);

    // request
    $tablename=$_POST['tablename']??'';
    $sel_no=$_POST['sel_no']??[];
    $total=$_POST['total']??'';
    $page=$_POST['page']??'';
    $backurl=urldecode($_POST['backurl']??'');

    //若不是陣列型態，改裝成array型態
    $sel_no = !is_array($sel_no) ? array($sel_no) : $sel_no;

    // delete
    if(count($sel_no)>0){
        $data["isdeleted"]='2';
        $msg=dataUpdate($tablename,$data,' WHERE '.getSqlWhereIn($sel_no,'no'),$sel_no);
        $msg=1;
        $action="刪除";
        //修正頁碼,避免刪除時在最末頁產生錯誤
        if($total!=''&&$page!=''){
            parse_str(parse_url($backurl,PHP_URL_QUERY),$query);
            $total=$total-$msg;
            $totalpage=ceil($total/$PAGE_SIZE);
            if($page>$totalpage&&$page!=1){
                $query['page']=$page-1;
                $backurl=parse_url($backurl,PHP_URL_PATH).'?'.http_build_query($query);
            }
        }else{
            $backarr=explode('/',parse_url($backurl,PHP_URL_PATH));
            if($backarr[count($backarr)-1]=='list'){
                $backurl='list.php';
            }else{
                $backurl=$backurl;
            }
        }
    }

    $xhr['msg']=($msg>0)?"成功".$action.$msg."筆資料":"沒有".$action."資料";
    $xhr['url']=(strpos($backurl,'?')===false)?$backurl.'?':$backurl;  
    logInsert(ADMIN_LOG,$_SESSION[ADMIN_SESSION.'_id'],$xhr['msg']);//記錄操作狀態
    echo json_encode($xhr,JSON_UNESCAPED_UNICODE);
?>

