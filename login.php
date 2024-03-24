<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File manager - inicio sesion</title>
    <link rel="stylesheet" href="./css/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis&display=swap" rel="stylesheet">
</head>

<body>
    <div class="nav">
        <label for="">Inciar sesion</label>
        <img src="./img/account_avatar.svg" alt="">
    </div>
    <div id="contenedorSession">
        <form action="login.php" method="post">
            <h2>INICIO DE SESION</h2>
            <div class="requisito">
                <label for="usuario">Usuario:</label>
                <input type="text" name="username" id="username">
            </div>
            <div class="requisito">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="boton">
                <button type="submit" name="login">INICIAR SESION</button>
            </div>
        </form>
    </div>
</body>

<?php
//Invocar la autenticacion
require "login_helper.php";
$mensaje = "";

//Verificar si se envio el formulario
if (isset($_POST['login'])) {
    $usuario = $_POST['username'];
    $password = $_POST['password'];

    $resultado = autentificar($usuario, $password);

    if ($resultado) {
        //Se autentico
        $mensaje = "Usuario autenticado";
        //Iniciar la sesion
        session_start();
        $_SESSION["usuario"] = $resultado;
        header('Location: index.php');
        exit();
    }else{
        $mensaje = "Usuario no autenticado";
    }
}
?>

<footer class="mensaje">
<?php
$mensaje = (isset($mensaje)) ? $mensaje : '';
echo $mensaje;
?>
</footer>

</html>