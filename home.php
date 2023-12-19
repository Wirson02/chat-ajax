<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/home.css">
    <!-- Comporbmos variables de sesión -->
    <?php
        include("./proc/conexion.php");
        session_start();
        // $_SESSION["id"] = "5";
        // $_SESSION["nom"] = "joalga";
        // echo $_SESSION["id"];

        if(!isset($_SESSION["id"])){
            header('Location: '.'../index.php');
            exit();
        }

    ?>
    <title>Home <?php echo " de ".$_SESSION["nom"]; ?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><h1>Bienvenido <?php echo  $_SESSION["nom"]?></h1></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <form class="d-flex" role="search">
    <button type="button" class="btn btn-danger"><a href="./proc/cerrarSesion.php">Cerrar sesión</a></button>
      </form>
    </div>
  </div>
</nav>
    <!-- <h1>Bienvenido <?php echo  $_SESSION["nom"]?></h1> -->
    <!-- Formulario de búsqueda de usuarios -->
    <div class="cont-center">
    <form action="./searchUser.php" method="post">
        <input type="text" name="search">
        <button type="submit">Buscar</button>
    </form>
    </div>
    <h1>Amigos</h1>
    <?php
    try {
        $sqlChk="SELECT id_peticion FROM `peticiones` WHERE id_user_amigo=?";
        $stmt1 = mysqli_prepare($conn, $sqlChk);
        mysqli_stmt_bind_param($stmt1, "s", $_SESSION["id"]);
        mysqli_stmt_execute($stmt1);
        $res = mysqli_stmt_get_result($stmt1);
        $rows = mysqli_num_rows($res);
        echo'<button type="button" class="btn btn-info"><a href="./solicitudes.php"? class="nav-link">Ver solicitudes('.$rows.')</a></button>';
    } catch (Exception $e) {
        echo "Ha ocurrido un error con el registro: ".$e->getMessage();
        die();
    }
    $sqlFriends = "SELECT a.id_user AS 'ID1',u.user_username AS 'nombre1',a.id_user_amigo AS 'ID2',u2.user_username AS 'nombre2' FROM `amigos` a INNER JOIN `usuarios` u on a.id_user = u.id_user INNER JOIN `usuarios` u2 ON u2.id_user =a.id_user_amigo WHERE a.id_user = ? OR a.id_user_amigo = ?"; 
    $stmt1 = mysqli_prepare($conn, $sqlFriends);
    mysqli_stmt_bind_param($stmt1, "ii", $_SESSION["id"],$_SESSION["id"]);
    mysqli_stmt_execute($stmt1);
    $res = mysqli_stmt_get_result($stmt1);
    $rows = mysqli_num_rows($res);
    echo '<br><div class="cont-center">';
    foreach ($res as $friend) {
        // var_dump($friend);
        if($friend["ID1"] == $_SESSION["id"]){
            echo'
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Chat '.$friend["nombre2"].'</h5>
                    <a class="btn btn-primary" href="chat.php?id='.$friend["ID2"].'">Ir al Chat</a>
                </div>
            </div>';
        }else{
            echo'<div class="card">
                <div class="card-body">
                    <h5 class="card-title">Chat '.$friend["nombre1"].'</h5>
                    <a class="btn btn-primary" href="chat.php?id='.$friend["ID1"].'">Ir al Chat</a>
                </div>
            </div>';
        }
    }
    
    echo "</div>"
    ?>
    
</body>
</html>