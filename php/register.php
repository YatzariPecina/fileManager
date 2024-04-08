<?php
require "db.php";

if (isset($_POST["newPassword"]) && isset($_POST["id"])) {
    $newPassword = $_POST["newPassword"];
    $id_usuario = $_POST["id"];

    $conection = getDbConnection();

    //Preparar password
    $passwordSalt = strtoupper(bin2hex(random_bytes(32)));
    //Concatenar password con el salt
    $passwordWithSalt = $newPassword . $passwordSalt;
    //Encriptar el password
    $passwordEncriptado = strtoupper(hash("sha512", $passwordWithSalt));

    $sql = "UPDATE `usuarios` SET `password_encrypted`='" . $passwordEncriptado . "',`password_salt`= '" . $passwordSalt . "' WHERE id = '" . $id_usuario . "'";
    $stmt = $conection->prepare($sql);

    if($stmt->execute()){
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode("Se cambio la contraseña exitosamente");
    }else{
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode("No se pudo cambiar la contraseña");
    }    
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datosParaRecibir = array("nombre", "apellidos", "username", "password", "genero", "fechaNac");

    $datosNoRecibidos = array();

    foreach ($datosParaRecibir as $value) {
        if (!isset($_POST[$value])) {
            $datosNoRecibidos[] = $value;
        }
    }

    if (count($datosNoRecibidos) != 0) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode("Los datos '" . implode(", ", $datosNoRecibidos) . "' son obligatorios");
        exit();
    }

    $datosVacios = array();

    foreach ($datosParaRecibir as $value) {
        if (empty(trim($_POST[$value]))) {
            $datosVacios[] = $value;
        }
    }

    if (count($datosVacios) != 0) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode("Los datos '" . implode(", ", $datosVacios) . "' contienen espacios en blanco");
        exit();
    }

    //Declarar los valores
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $genero = $_POST['genero'];
    $fechaNac = $_POST['fechaNac'];

    //Revisar si hay una usuario con igual
    $conection = getDbConnection(); //Obtener conexion
    $sql = "SELECT * FROM usuarios WHERE username = :username";
    $stmt = $conection->prepare($sql);

    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Obtener los resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultados) != 0) {
        http_response_code(400);
        echo json_encode("Ya existe ese usuario");
        exit();
    }

    //Si no existe ese usuario, entonces preparar todo para agregar a la base de datos

    //Crea el salt para la contraseña
    $passwordSalt = strtoupper(bin2hex(random_bytes(32)));
    //Concatenar password con el salt
    $passwordWithSalt = $password . $passwordSalt;
    //Encriptar el password
    $passwordEncriptado = strtoupper(hash("sha512", $passwordWithSalt));

    //Fecha y hora actual
    $zona_horaria = new DateTimeZone('America/Mexico_City');
    $fecha_actual = new DateTime('now', $zona_horaria);

    $sql = "INSERT INTO `usuarios`(`username`, `password_encrypted`, `password_salt`, `nombre`, `apellidos`, `genero`, `fecha_nacimiento`, `fecha_hora_registro`, `es_admin`, `activo`) VALUES ('" . $username . "', '" . $passwordEncriptado . "', '" . $passwordSalt . "', '" . $nombre . "', '" . $apellidos . "', '" . $genero . "', '" . $fechaNac . "', '" . $fecha_actual->format('Y-m-d H:i:s') . "', '" . 1 . "', '" . 1 . "')";
    $stmt = $conection->prepare($sql);

    // Ejecutar la consulta
    $stmt->execute();

    http_response_code(200);
    echo json_encode("Registro exitoso para el usuario: $username");
    exit();
} else {
    http_response_code(401);
    echo json_encode("Error: Método de solicitud no permitido");
    exit();
}
