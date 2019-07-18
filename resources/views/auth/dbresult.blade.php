@extends('layouts.master')
@section('title','資料庫連結測試')
@section('content')
<?php
$serverName = "192.168.11.103"; //serverName\instanceName
$connectionInfo = array( "Database"=>"ATV0002", "UID"=>"sa", "PWD"=>"dsc@16725493", "CharacterSet" => "UTF-8");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Connection established.連線成功!!<br />";
}else{
     echo "Connection could not be established.連結失敗!?<br />";
     die( print_r( sqlsrv_errors(), true));
}
// Close the connection.
sqlsrv_close($conn);
?>
@endsection