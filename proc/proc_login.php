<?php
    require 'conexion.php';
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);
    $user = mysqli_real_escape_string($conn,$_POST['user']);
//Consulta

    $sql_login = "SELECT id_user, user_username, user_pwd from usuarios where user_username = ?";
    $stm_consulta = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stm_consulta, $sql_login);
    mysqli_stmt_bind_param($stm_consulta, "s", $user);

    mysqli_stmt_execute($stm_consulta);
    $verif = mysqli_stmt_get_result($stm_consulta);
    
if (mysqli_num_rows($verif) == 1) {
    $verif = mysqli_fetch_assoc($verif);
    // echo "existe usuario";
    // echo "<br>";
    if (password_verify($pwd, $verif['user_pwd'])) {
        // echo 'Password is valid!';
        // echo "<br>";
        // echo "Acceso al chat";
        session_start();
        $_SESSION['id'] = $verif['id_user'];
        $_SESSION['nom'] = $verif['user_username'];
        header('Location: ../home.php');

        
    } else {
        header('Location: ../index.php?loginerror=true');
    }
} else {
    echo "no existe";
    header('Location: ../index.php?loginerror=true'); // Usuario no encontrado
}