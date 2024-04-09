<?php
//Invocar la autenticacion
require "login_helper.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
    if (isset($_SESSION["usuario"])) {
        session_destroy();
        echo "200";
    } else {
        echo "No hay un inicio de sesion para cerrar";
    }
} else {
    //Verificar si se envio el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST['username'];
        $password = $_POST['password'];

        $resultado = autentificar($usuario, $password);

        if ($resultado) {
            //Iniciar la sesion
            $arrayDatos = array();
            foreach($resultado as $key => $value){
                if($value == null){
                    $_SESSION["usuario"][$key] = "";
                }else{
                    $_SESSION["usuario"][$key] = $value;
                }
            }
            echo "200";
        } else {
            echo "401";
        }
    }
}

//Get pedir informacion
//Post crear informacion

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //Tiene inicio de sesion o no tiene

    if (isset($_SESSION["usuario"])) {

        //Tiene inicio
        $usuarioArray = array();

        $usuarioArray = $_SESSION["usuario"];
        $json_usuario = json_encode($usuarioArray);

        header('Content-Type: application/json');
        echo $json_usuario;
    } else {
        echo "401";
    }
}
