<?php
session_start();
if(isset($_SESSION["id"])){
    if(!empty($_GET["id"])){
        include("conexion.php");
    }else{
        header('Location: '.'../home.php');
        exit();
    }
}else{
    header('Location: '.'../index.php');
    exit();
}
$id = trim(mysqli_real_escape_string($conn, $_GET["id"]));

try {
    mysqli_autocommit($conn,false);
    mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);
    // Añadimos a amigos
    $stmt1= mysqli_stmt_init($conn);
    $sqlFriend=  "INSERT INTO amigos (id_amigo, id_user,id_user_amigo,fecha) VALUES (NULL, ?,?,curdate());";
    mysqli_stmt_prepare($stmt1,$sqlFriend);
    mysqli_stmt_bind_param($stmt1,"ii",$_SESSION["id"],$id);
    mysqli_stmt_execute($stmt1);
    // Borramos la peticion
    $stmt2= mysqli_stmt_init($conn);
    $sqlDelete=  "DELETE FROM peticiones WHERE id_user=? AND id_user_amigo=?";
    mysqli_stmt_prepare($stmt2,$sqlDelete);
    mysqli_stmt_bind_param($stmt2,"ii",$id,$_SESSION["id"]);
    mysqli_stmt_execute($stmt2);
    // Confirmamos las consultas
    mysqli_commit($conn);

    // Cerramos las conexiones
    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);

    echo "Amigo añadido";
} catch (Exception $e) {
    echo "Ha ocurrido un error con el registro: ".$e->getMessage();
    die();
}