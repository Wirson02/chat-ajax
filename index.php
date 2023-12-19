<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/prueba.css">
    <title>Giatchat</title>
</head>
<body>
    <h2>Bienvenido to GyatChat!!</h2>
    <div class="container <?php if (isset($_GET['nombreVacio']) || isset($_GET['nombre'])) {echo" right-panel-active";}else{}?>" id="container">
        <div class="form-container sign-up-container">
            <form action="./proc/proc_val.php" method="post" id="registrarse">
                <h1>Crear Cuenta</h1>
                <?php  if (isset($_GET['signup'])) {echo "<span class='alert'>Porfavor revisa los datos del usuario a crear</span>";}?>
                <input type="text" name="user" id="user" placeholder="Usuario" value="<?php if(isset($_GET["user"])){echo $_GET["user"];} ?>">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php if(isset($_GET["nombre"])){echo $_GET["nombre"];} ?>">
                <input type="text" name="apellido" id="apellido" placeholder="Apellido" value="<?php if(isset($_GET["apellido"])){echo $_GET["apellido"];} ?>">
                <input type="password" name="pwd1" id="pwd1" placeholder="Contraseña">
                <input type="password" name="pwd2" id="pwd2" placeholder="Repetir Contraseña">
                <button type="submit" name="registrarse">Registrarse</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="./proc/proc_val.php" method="post">
                <h1>Iniciar Sesion</h1>
                <?php   if (isset($_GET['userExist'])) {echo "<span class='alert'>Porfavor revisa los datos al iniciar sesión</span>";}?>
                <input type="text" name="user" id="user" placeholder="Usuario" <?php if(isset($_GET['userlog'])){echo "value = ".$_GET['user'];}?>>
                <input type="password" name="pwd" id="pwd" placeholder="Contraseña">
                <button type="submit" value="login" name="login">Inicia Sesion</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Bienvenido de Nuevo</h1>
				    <p>Para seguir conectado con nostros por favor inicia sesion</p>
                    <button class="ghost" id="signIn">Iniciar Sesion</button>
			    </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hola, amigo!</h1>
				    <p>Registrate para poder mantenerte conectado y empezara a hablar con tus amigos</p>
				    <button class="ghost" id="signUp">Registrarse</button>
			    </div>
            </div>
        </div>
    </div>
    <script src="./js/prueba.js"></script>
</body>
</html>