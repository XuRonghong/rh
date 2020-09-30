<?php
include_once dirname(__DIR__) . '/config.php';
/*
* api設計，對表動作Create、Read、Update、Delete
*/
$gets = filterVar($_GET);
$posts = filterVar($_POST);
$request = filterVar($_REQUEST);


try {
    array_except($request, '_token');

    $tablename = $request['table'];


    if ($request['router'] == 'get') {

        $sort_arr = [];
        $search_arr = [];
        $search_word =    $request['search'] ?? '';
        $iDisplayLength = $request['length'] ?? $request['iDisplayLength'] ?? 0;
        $iDisplayStart =  $request['start'] ?? $request['iDisplayStart'] ?? 0;
        $sEcho =          $request['sEcho'] ?? '';
        $column_arr =     $request['columns'] ?? '';
        $order_arr =     $request['order'] ?? '';
        // $column_arr = explode( ',', $column_arr );
        foreach ($column_arr as $key => $item) {
            if ($item['data'] == "") {
                unset($column_arr[$key]);
                continue;
            }
            if ($item['searchable'] == "true") {
                $search_arr[$key] = $item['data'];
            }
            if ($item['orderable'] == "true") {
                $sort_arr[$key] = $item['data'];
            }
        }
        $sort_name = $sort_arr[$order_arr[0]['column']] ?? 'id';
        $sort_dir = $order_arr[0]['dir'] ?? 'ASC';


        $map = array();
        $params = array();
        //$map['status'] = 1;     //未被刪除
        $queryStr = implodeSQL($map, $params);
        $queryStr = $queryStr != '' ? $queryStr : ' 1 ';
        $queryStr .= ' AND status > 0 ';

        if ($search_word['value'] && $search_arr) {
            $queryStr .= ' AND ( 0';
            foreach ($search_arr as $item) {
                $queryStr .= ' OR ' . $item . ' LIKE ' . '"%' . $search_word['value'] . '%"';
            }
            $queryStr .= ' ) ';
        }


        $sql = "SELECT COUNT(*) " .
            "FROM {$tablename} " .
            "WHERE {$queryStr} ";
        $total_count = getSingleValue($sql, $params);

        $sql = "SELECT * " .
            "FROM {$tablename} " .
            "WHERE {$queryStr} " .
            "ORDER BY {$sort_name} {$sort_dir} " .
            "LIMIT {$iDisplayStart}, {$iDisplayLength} ";
        $rows = getMultiRow($sql, $params);
        // dd($sql);

        if ($rows) {
            foreach ($rows as $key => $var) {
            }
            $rtn = array(
                'status' => 1,
                'message' => 'db query success',
                'sEcho' => $sEcho,
                'iTotalDisplayRecords' => $total_count,
                'iTotalRecords' => $total_count,
                'data' => $rows
            );
        } else {
            $rtn = array(
                'status' => 0,
                'message' => 'Oops! 沒有使用者資訊!',
                'sEcho' => '',
                'iTotalDisplayRecords' => 0,
                'iTotalRecords' => 0,
                'data' => $rows
            );
        }
    }

    echo json_encode($rtn, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    $err = array('status' => 0, 'message' => $e->getMessage(), 'code' => $e->getCode());
    echo json_encode($err, JSON_UNESCAPED_UNICODE);
}
