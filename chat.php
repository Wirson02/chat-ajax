    <?php
        session_start();
        if(!isset($_SESSION["id"])){
            header('Location: '.'../index.php');
            exit();
        }else{
            if(isset($_GET["id"])){
                include("./proc/conexion.php");
                $id = trim(mysqli_real_escape_string($conn, $_GET["id"]));
            }else{
                header('Location: '.'../index.php');
                exit();
            }
        }
        $sqlUsr="SELECT user_username FROM `usuarios` WHERE id_user=?";
        $stmt1 = mysqli_prepare($conn, $sqlUsr);
        mysqli_stmt_bind_param($stmt1, "i", $id);
        mysqli_stmt_execute($stmt1);
        $res = mysqli_stmt_get_result($stmt1);
        foreach ($res as $user) {
            $user = $user['user_username'];
        }
        // echo $id;
        // echo "</br>";
        // echo $_SESSION["id"];
        $sqlChat="SELECT c.chat_msg AS 'msg', c.fecha, u1.user_username AS 'origen',u2.user_username AS 'destino' FROM `chat` c INNER JOIN usuarios u1 ON c.user_origen = u1.id_user INNER JOIN usuarios u2 ON c.user_destino = u2.id_user WHERE (c.user_origen=? OR c.user_origen = ?) AND (c.user_destino=? or c.user_destino=?) ORDER BY fecha ASC; ";
        $stmt2 = mysqli_prepare($conn, $sqlChat);
        mysqli_stmt_bind_param($stmt2, "iiii", $id,$_SESSION["id"],$id,$_SESSION["id"]);
        mysqli_stmt_execute($stmt2);
        $resChat = mysqli_stmt_get_result($stmt2);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/home.css">
    <title>Chat con <?php echo $user;?></title>
</head>
<body>
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

<div class="card">
    <h1>Chat con <?php echo $user;?></h1> 
    <ul class="list-group list-group-flush">
    </ul>
  <div class="card-body">

    <!-- Cargamos el chat-->
    <?php
        foreach ($resChat as $msg) {
            // var_dump($msg);
            if($_SESSION['nom']==$msg['origen']){
                echo'<div class="cont-der">
                        <div class="card text-end cont-der">
                            <div class="card-body">
                                <p class="card-text">'.$msg['msg'].'</p>
                            </div>
                        </div>
                    </div>';
            }else{
                echo'
                <div class="card text-end cont-der">
                    <div class="card-body">
                        <p class="card-text">'.$msg['msg'].'</p>
                </div>
            </div>';
            }

        }
    ?>

    <!-- Enviar mensaje -->
    <div class="row">
    <div class="colum-2">
            <a class="btn btn-warning" href="home.php">Volver</a>
        </div>
        <div class="colum-2 cont-der">
        <form action="./proc/procChat.php" method="post">
            <div class="input-group mb-3">
                <input type="text"   name="msg" id="msg" class="form-control" placeholder="enviar mensaje">
                <input type="hidden" name="id" value="<?php echo $id?>">
                <button type="submit" class="btn btn btn-success" type="button" id="button-addon2">Enviar</button>
            </div>
            <!-- <form action="./proc/procChat.php" method="post">
                <input type="text" name="msg" id="msg">
                <input type="hidden" name="id" value="<?php echo $id?>">
                <button type="submit">Enviar</button>
            </form> -->
        </div>
    </div>
</div>
</body>
</html>