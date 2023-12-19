<?php
var_dump($_POST);
if (isset($_POST["validado"])) {
    include("conexion.php");

}else{
    header('Location: '.'../index.php');  
    exit();
}

$user = trim(strtolower(mysqli_real_escape_string($conn, $_POST['user'])));
$nombre = trim(mysqli_real_escape_string($conn, $_POST['nombre']));
$apellido = trim(mysqli_real_escape_string($conn, $_POST['apellido']));
$pwd = password_hash(mysqli_real_escape_string($conn, $_POST['pwd']), PASSWORD_BCRYPT);
$nombreFinal = $nombre." ".$apellido;

try {
    $sqlChk="SELECT user_username FROM usuarios WHERE user_username = ?";
    $stmt1 = mysqli_prepare($conn, $sqlChk);
    mysqli_stmt_bind_param($stmt1, "s", $user);
    mysqli_stmt_execute($stmt1);
    $res = mysqli_stmt_get_result($stmt1);
    echo mysqli_num_rows($res);
    if(mysqli_num_rows($res)>=1){
        echo"El usuario existe";
        header('Location: '.'../index.php?userExist=true');
        exit();
    }else{
        $stmt2= mysqli_stmt_init($conn);
        $sqlInsert=  "INSERT INTO usuarios (id_user, user_username, user_nom, user_pwd) VALUES (NULL, ?,?,?);";
        mysqli_stmt_prepare($stmt2,$sqlInsert);
        mysqli_stmt_bind_param($stmt2,"sss",$user,$nombreFinal,$pwd);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt1);
        mysqli_stmt_close($stmt2);
        echo "Usuario creadado correctamente";
        header('Location: '.'../index.php');

    }

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Ha ocurrido un error con el registro: ".$e->getMessage();
    die();
}