<?php
// Esta función permite comprobar si el usuario que ha encontrado el buscador es amigo, se ha mandado petición de amistado o no ha interactuado
function getUserStatus($userLogin, $UserTarget){
    include("./proc/conexion.php");
    // Conseguimos el id del usuario al que mostraremos sus opciones
    $peticion="SELECT id_peticion FROM peticiones WHERE id_user =? AND id_user_amigo=?";
    $stmt1 = mysqli_prepare($conn, $peticion);
    mysqli_stmt_bind_param($stmt1, "ii", $userLogin,$UserTarget);
    mysqli_stmt_execute($stmt1);
    $res = mysqli_stmt_get_result($stmt1);
    // echo mysqli_num_rows($res);
    if(mysqli_num_rows($res)==0){
        return '<a class="btn btn-primary" href="./proc/addPeticion.php?id='.$UserTarget.'">Enviar solicitud</a>';
    }else{
        return '<a class="btn btn-secondary"> Enviado</a>';
    }
}