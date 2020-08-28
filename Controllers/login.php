<?php


function index()
{
    global $db;
    $rs = $db->prepare("SELECT * FROM class where class=1");
    $rs->execute();
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

    include_once view('login');

    $db = null;
}

function signin()
{
    echo data_get($_POST, 'account');
    echo 'sign-in';

    header("Location: index.php?r=test2");
}

function logout()
{
    echo data_get($_POST, 'password');
    echo 'sign-out';

    header("Location: index.php?r=login");
}