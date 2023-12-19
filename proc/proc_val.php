<?php
require './conexion.php';

if (filter_has_var(INPUT_POST, 'login')) {
    require_once('./../func/campoVacio.php');
    
    $empty="";
    
    $user=$_POST['user'];
    $pwd=$_POST['pwd'];
    
    if (!validaCampoVacio($user)){
        $user=$_POST['user'];
    } else {
        if (!$empty){
            $empty .="?userlog=true";
        } else {
            $empty .="&userlog=true";        
        }
    }
    
    if (!validaCampoVacio($pwd)){
        $pwd=$_POST['pwd'];
    } else {
        if (!$empty){
           $empty .="?pwd=true";
        } else {
            $empty .="&pwd=true";        
        }
    }
    if ($empty!=""){
        echo "hay campos vacios";
        $variables = array('user' => $user);
        $error = http_build_query($variables);
        header("Location: ./../index.php".$empty."&".$error);
        exit();
    }else{
        echo"<form id='login' action='proc_login.php' method='POST'>";
        echo"<input type='hidden' id='user' name='user' value='".$user."'>";
        echo"<input type='hidden' id='pwd' name='pwd' value='".$pwd."'>";
        echo "<script>document.getElementById('login').submit();</script>";
    }

}else if (filter_has_var(INPUT_POST, 'registrarse')) {
    include("../func/campoVacio.php");
    var_dump($_POST);

    $errores = "";
    if(validaCampoVacio($_POST["user"])){
        if (!$errores){
            $errores .="?userVacio=true";
        } else {
            $errores .="&userVacio=true";        
        }
    }else{
        $user = $_POST["user"];
        if(strlen($user)>=15){
            if (!$errores){
                $errores .="?userMaxLength=true";
            } else {
                $errores .="&userMaxLength=true";        
            }
        }
    }

    if(validaCampoVacio($_POST["nombre"])){
        if (!$errores){
            $errores .="?nombreVacio=true";
        } else {
            $errores .="&nombreVacio=true";        
        }
    }else{
        $nombre = $_POST["nombre"];
    }

    if(validaCampoVacio($_POST["apellido"])){
        if (!$errores){
            $errores .="?apellidoVacio=true";
        } else {
            $errores .="&apellidoVacio=true";        
        }
    }else{
        $apellido = $_POST["apellido"];
    }

    if(validaCampoVacio($_POST["pwd1"])){
        if (!$errores){
            $errores .="?pwd1Vacio=true";
        } else {
            $errores .="&pwd1Vacio=true";        
        }
    }else{
        $pwd1 = $_POST["pwd1"];
    }

    if(validaCampoVacio($_POST["pwd2"])){
        if (!$errores){
            $errores .="?pwd2Vacio=true";
        } else {
            $errores .="&pwd2Vacio=true";        
        }
    }else{
        $pwd2 = $_POST["pwd2"];
    }

    if(isset($pwd1)&&isset($pwd2)){
        if($pwd1 === $pwd2){
            $pwdFinal = $pwd1;
        }else{
            if (!$errores){
                $errores .="?pwdUnmatch=true";
            } else {
                $errores .="&pwdUnmatch=true";        
            }
        }
    }
    if ($errores!=""){
        $datosRecibidos = array(
            'user' => $user,
            'nombre' => $nombre,
            'apellido' => $apellido,
        );
        $datosDevueltos=http_build_query($datosRecibidos);
        header("Location: ../index.php". $errores. "&signup=true&". $datosDevueltos);
        exit();
    }else{
        echo'<form action="./proc_registro.php" method="post" id="RegistroCheck">
            <input type="text" name="user" id="user" value="'.$user.'" hidden>
            <input type="text" name="nombre" id="nombre" value="'.$nombre.'"hidden>
            <input type="text" name="apellido" id="apellido" value="'.$apellido.'"hidden>
            <input type="password" name="pwd" id="pwd" value="'.$pwdFinal.'"hidden>
            <input type="text" name="validado" value="validado"hidden>
            <button type="submit" name="RegistroCheck" hidden>Enviar</button>
            </form>
            <script>
                console.log(document.getElementById("RegistroCheck"))
                document.getElementById("RegistroCheck").submit();
            </script>';
        }
    }else{
        header('Location: '.'./../index.php');
        exit();
    }