<?php
include_once dirname(__DIR__) . '/config.php';


try {

$posts = filterVar($_REQUEST);

array_except($posts, '_token');
    
$tablename = $posts['table'];

    if($posts['router']=='get') {

        $params = array($posts['key'] => $posts['value']);
        $row = getSingleRow("SELECT * FROM {$tablename} where `{$posts['key']}`=:{$posts['key']} ", $params);
        
        if($row && $row['parent_id'] > 0){
 
            $params = array($posts['key'] => $row['parent_id']);
            $row2 = getSingleRow("SELECT * FROM {$tablename} where `{$posts['key']}`=:{$posts['key']} ", $params);
    
            if($row2 && $row2['parent_id'] > 0){

                $params = array($posts['key'] => $row2['parent_id']);
                $row3 = getSingleRow("SELECT * FROM {$tablename} where `{$posts['key']}`=:{$posts['key']} ", $params);
        
                if($row3 && $row3['parent_id'] > 0){

                    $params = array($posts['key'] => $row3['parent_id']);
                    $row4 = getSingleRow("SELECT * FROM {$tablename} where `{$posts['key']}`=:{$posts['key']} ", $params);
                }
            }
        }

        $floor=1;
        $class_tree = '';
        if($row4 && !is_null($row4['title'])) {
            $class_tree .= $row4['title']. ' > ';
            $floor++;
        }
        if($row3 && !is_null($row3['title'])) {
            $class_tree .= $row3['title']. ' > ';
            $floor++;
        }
        if($row2 && !is_null($row2['title'])) {
            $class_tree .= $row2['title']. ' > ';
            $floor++;
        }
        if($row && !is_null($row['title'])) {
            $class_tree .= $row['title']. ' > ';
            $floor++;
        }

        $rtn = array('status' => 1, 'message' => 'db query success', 'data' => $class_tree, 'floor' => $floor);

    }
    
    echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    $err = array('status' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode());

    echo json_encode($err, JSON_UNESCAPED_UNICODE);
}
