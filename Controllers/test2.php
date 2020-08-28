<?php

function index()
{
    global $db, $config;

    $rs = $db->prepare("SELECT * FROM class where class=1");
    $rs->execute();
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

    include_once view('test2');
}
