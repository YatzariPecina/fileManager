<?php
//Invocar la autenticacion
require "login_helper.php";
session_start();

//Verificar si se envio el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['username'];
    $password = $_POST['password'];

    $resultado = autentificar($usuario, $password);

    if ($resultado) {
        //Iniciar la sesion
        $_SESSION["usuario"] = $resultado;
        echo "200";
    } else {
        echo "401";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //Tiene inicio de sesion o no tiene

    if (isset($_SESSION["usuario"])) {
        
        //Tiene inicio
        $usuarioArray = array();

        $usuarioArray = $_SESSION["usuario"];
        $json_usuario = json_encode($usuarioArray);

        header('Content-Type: application/json');
        echo $json_usuario;
    }else{
        echo "401";
    }
}
