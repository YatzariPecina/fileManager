<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!isset($_GET["id"])) {
        http_response_code(400);
        echo json_encode("No se recibieron los datos esperados");
        exit();
    }

    $id_usuario = $_GET["id"];

    $conection = getDbConnection();
    $sql = "SELECT `id`, `username`, `nombre`, `apellidos`, `genero`, `fecha_nacimiento`, `es_admin` FROM usuarios WHERE id = :id";
    $stmt = $conection->prepare($sql);

    $stmt->bindParam(":id", $id_usuario, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($resultados) > 0) {
            http_response_code(200);
            echo json_encode($resultados);
            exit();
        } else {
            http_response_code(400);
            echo json_encode("No existe el usuario");
            exit();
        }
    } else {
        http_response_code(400);
        echo json_encode("Error al realizar la solicitud a la base de datos");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["newPassword"]) && isset($_POST["id"])) {
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

    if ($stmt->execute()) {
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode("Se cambio la contraseña exitosamente");
    } else {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode("No se pudo cambiar la contraseña");
    }
} else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["modificar"])) {
    $datosParaRecibir = array("id", "nombre", "apellidos", "username", "genero", "fechaNac", "grado");

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
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $username = $_POST['username'];
    $genero = $_POST['genero'];
    $fechaNac = $_POST['fechaNac'];
    $grado = $_POST['grado'];

    //Revisar si hay una usuario con igual
    $conection = getDbConnection(); //Obtener conexion
    $sql = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $conection->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();

    // Obtener los resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultados) == 0) {
        http_response_code(400);
        echo json_encode("No existe ese usuario");
        exit();
    }

    $sql = "UPDATE `usuarios` SET `username`=:username,`nombre`=:nombre,`apellidos`=:apellidos,`genero`=:genero,`fecha_nacimiento`=:fechaNac,`es_admin`=:esAdmin WHERE id=:id";
    $stmt = $conection->prepare($sql);

    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
    $stmt->bindParam(':genero', $genero, PDO::PARAM_STR);
    $stmt->bindParam(':fechaNac', $fechaNac, PDO::PARAM_STR);
    $stmt->bindParam(':esAdmin', $grado, PDO::PARAM_BOOL);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Ejecutar la consulta
    $stmt->execute();

    http_response_code(200);
    echo json_encode("Modificacion exitosa para el usuario: $username");
    exit();
} else if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
}else {
    http_response_code(401);
    echo json_encode("Error: Método de solicitud no permitido");
    exit();
}
