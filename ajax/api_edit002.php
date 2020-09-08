<?php
include_once dirname(__DIR__) . '/config.php';


try {

    $posts = filterVar($_POST);

    array_except($posts, '_token');

    if($posts['router']=='get') {

    }
    else if($posts['router']=='create') {
    
        $rs = dataInsert('class', $posts);
    
        $rtn = array('statue' => $rs, 'message' => 'db insert success', 'code' => 200);
    }
    else if($posts['router']=='update') {
    
        $id = $posts['id'];
        $rs = dataUpdate('material', $posts, ' WHERE id=:id', ['id'=> $id]);
    
        $rtn = array('statue' => $rs, 'message' => 'db update success', 'code' => 200);
    }
    else if($posts['router']=='delete') {
    
        $id = $posts['id'];
        $rs = dataDelete('material', $posts, ' WHERE id=:id', ['id'=> $id]);
    
        $rtn = array('statue' => $rs, 'message' => 'db delete success', 'code' => 200);
    }

    echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    $err = array('statue' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode());

    echo json_encode($err, JSON_UNESCAPED_UNICODE);
}
