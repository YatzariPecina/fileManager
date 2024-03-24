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
        <form action="login.php">
            <h2>INICIO DE SESION</h2>
            <div class="requisito">
                <label for="">Usuario:</label>
                <input type="text">
            </div>
            <div class="requisito">
                <label for="">Contraseña:</label>
                <input type="password">
            </div>
            <div class="boton">
                <button type="submit">INICIAR SESION</button>
            </div>
        </form>
    </div>
</body>

<?php

?>

</html>