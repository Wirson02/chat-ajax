<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$dbServer = "localhost";
$dbuserName = "root";
$dbPasswd = "Wilson152002";
$db="db_chatonline";

try{
    $conn = mysqli_connect($dbServer,$dbuserName,$dbPasswd,$db);
    // echo "Sa conectao fino";
}catch(mysqli_sql_exception $e){
    echo "Error en la conexión a la base de datos: ".$e->getMessage();
    die();
}
