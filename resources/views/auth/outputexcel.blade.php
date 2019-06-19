<?php
$serverName = "60.250.217.237";
$connectionInfo = array( "Database"=>"TENSALL", "UID"=>"sa", "PWD"=>"dsc@16725493");
$conn = sqlsrv_connect( $serverName, $connectionInfo );
if( $conn === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$sql = 'SELECT MB001,MB002,MB003,MB017,MB047 FROM INVMB WHERE MB001 = "Z-AD0009" order by MB001 ;';
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
else{
    while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) {
      echo $row['MB001'].", ".$row['MB002'].", ".$row['MB003'].", ".$row['MB017'].", ".$row['MB047']."<br />";  //echo資料欄ID 與 SAA列
    }
}
// Close the connection.
sqlsrv_free_stmt( $stmt);
?>