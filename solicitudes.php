<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/home.css">
    <title>Solicitudes de amistad</title>
</head>
<body>
    <?php
    session_start();
    if(!isset($_SESSION["id"])){
        header('Location: '.'../index.php');
        exit();
    }
    ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="./home.php"><h1>Bienvenido <?php echo  $_SESSION["nom"]?></h1></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <form class="d-flex" role="search">
    <button type="button" class="btn btn-danger"><a href="./proc/cerrarSesion.php">Cerrar sesión</a></button>
      </form>
    </div>
  </div>
</nav>
<?php 
    include("./proc/conexion.php");
    try {
        $sqlChk="SELECT p.id_user AS 'id',u.user_username AS 'usuario' FROM peticiones `p` INNER JOIN usuarios `u` ON p.id_user = u.id_user WHERE p.id_user_amigo=?;";
        $stmt1 = mysqli_prepare($conn, $sqlChk);
        mysqli_stmt_bind_param($stmt1, "s", $_SESSION["id"]);
        mysqli_stmt_execute($stmt1);
        $res = mysqli_stmt_get_result($stmt1);
        $rows = mysqli_num_rows($res);
        if($rows == 0){
            echo "<br>";
            echo'<div class="cont-center">';
            echo "<h2>No hay solicitudes pendientes 😓</h2>";
            echo "</div>";
        }else{
            foreach ($res as $user) {
                echo'<div class="cont-center">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">'.$user["usuario"].'</h5>
                                <p class="card-text">Sergio te ha enviado una solicitud de amistad.</p>
                            </div>
                            <ul class="list-group list-group-flush">
                            </ul>
                            <div class="card-body">
                                <a class="btn btn-primary" href="./proc/addFriend.php?id='.$user["id"].'">Aceptar</a>
                                <a class="btn btn-dark" href="./proc/RechazarFriend.php?id='.$user["id"].'">Rechazar</a>
                            </div>
                        </div>';
                // echo $user["id"]." - ".$user["usuario"];
            }
            echo "</div>";
        }
    } catch (Exception $e) {
        echo "Ha ocurrido un error con el registro: ".$e->getMessage();
        die();
    }
    echo'<a class="btn btn-warning" href="home.php">Volver</a>';
?>
</body>
</html>