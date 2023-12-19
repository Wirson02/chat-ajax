<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviado!</title>
</head>
<body>
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
?>
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

<?php
$id = trim(mysqli_real_escape_string($conn, $_GET["id"]));
try {
    $stmt1= mysqli_stmt_init($conn);
    $sqlInsert=  "INSERT INTO peticiones (id_peticion, id_user, id_user_amigo, fecha) VALUES (NULL, ?,?,curdate());";
    mysqli_stmt_prepare($stmt1,$sqlInsert);
    mysqli_stmt_bind_param($stmt1,"ii",$_SESSION["id"],$id);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);
    echo"Petición enviada correctamente";
    echo "<br>";
    echo '<a href="../home.php?enviado=true">Volver al Home</a>';
    header('Location: '.'./../home.php?enviado=true');

} catch (Exception $e) {
    echo "Ha ocurrido un error con el registro: ".$e->getMessage();
    die();
}
?>
</body>
</html>