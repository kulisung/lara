<?php 
define('DBHOST', '60.250.217.237');
define('DBNAME', 'ATV0002');
define('DBUSER', 'sa');
define('DBPWD', 'dsc@16725493');
try{
    //$db = new PDO("sqlsrv:Server=192.168.11.103;Database=ATV0002", "sa", "dsc@16725493");
    $db = new PDO('sqlsrv:Server='.DBHOST.';Database='.DBNAME, DBUSER, DBPWD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException  $e){
    echo $e->getMessage();
    exit;
}
?>