<?php
//Invocar la autenticacion
require "login_helper.php";

//Verificar si se envio el formulario
$usuario = $_POST['username'];
$password = $_POST['password'];

$resultado = autentificar($usuario, $password);

if ($resultado) {
    //Se autentico
    $mensaje = "Usuario autenticado";
    //Iniciar la sesion
    session_start();
    $_SESSION["usuario"] = $resultado;
    echo "200";
} else {
    echo "401";
}
