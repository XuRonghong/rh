<?php

$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='rh';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName;charset=utf8";


try {
    $conn = new PDO($dsn, $user, $pass); //初始化一个PDO对象
    $conn->exec("SET CHARACTER SET utf8");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
    
    $input = array(
        ':title' => 'pdo connect mysql',
        ':message' => $e->getMessage(),
        ':created_at' => date('Y-m-d H:i:s'),
        ':updated_at' => date('Y-m-d H:i:s'),
    );
    $sql = "INSERT INTO `db_log` (title, content, created_at, updated_at) VALUES(:title,:message,:created_at,:updated_at)";
    $sth = $conn->prepare($sql);
    $rs = $sth->execute($input);
}
$conn = null;


//默认这个不是长连接，如果需要数据库长连接，需要最后加一个参数：array(PDO::ATTR_PERSISTENT => true) 变成这样：
$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
$db->exec("SET CHARACTER SET utf8");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>