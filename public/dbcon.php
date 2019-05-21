<?php
//DB_Server, DB_Name, DB_Username, DB_Password	
try {
    $conn = new PDO("sqlsrv:Server=60.250.217.237;Database=TENSALL", "sa", "dsc@16725493");
    if($conn)
        echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>