<?php
include_once dirname(__DIR__) . '/config.php';


try {

    $posts = filterVar($_POST);

    array_except($posts, '_token');

    $rs = dataInsert('class', $posts);

    $rtn = array('statue' => $rs, 'message' => 'db insert success', 'code' => 200);

    echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    $err = array('statue' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode());

    echo json_encode($err, JSON_UNESCAPED_UNICODE);
}
