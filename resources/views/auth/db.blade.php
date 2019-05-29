<?php //先來做資料連線的設定：
// define database parameter
$serverName = "60.250.217.237"; //serverName\instanceName
$connectionInfo = array( 
    "Database"=>"TENSALL",  //資料庫名稱
    "UID"=>"sa",  //資料庫連線帳號
    "PWD"=>"dsc@16725493",  //資料庫連線密碼
    "CharacterSet" => "UTF-8"  
);
// connection to the database
$conn = sqlsrv_connect( $serverName, $connectionInfo) or die("Couldn't connect to SQL Server on $dbHost");
?>
