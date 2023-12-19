<?php
session_start();
if(!isset($_SESSION["id"])){
    header('Location: '.'../index.php');
    exit();
}else{
    if(isset($_POST["id"])){
        include("conexion.php");
        $id = trim(mysqli_real_escape_string($conn, $_POST["id"]));
    }else{
        header('Location: '.'../index.php');
        exit();
    }
}

try {
    $msg = trim(mysqli_real_escape_string($conn,$_POST["msg"]));
    $stmt1= mysqli_stmt_init($conn);
    $sqlInsert=  "INSERT INTO chat (id_chat, user_origen, user_destino, chat_msg,fecha) VALUES (NULL,?,?,?,now());";
    mysqli_stmt_prepare($stmt1,$sqlInsert);
    mysqli_stmt_bind_param($stmt1,"iis",$_SESSION["id"],$id,$msg);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);
    header("Location: "."../chat.php?id=$id");
    exit();
} catch (Exception $e) {
    echo "Ha ocurrido un error con el registro: ".$e->getMessage();
    die();
}