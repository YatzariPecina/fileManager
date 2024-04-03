<?php
require "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $genero = $_POST['genero'];
    $fechaNac = $_POST['fechaNac'];

    //Crea el salt para la contraseña
    $passwordSalt = strtoupper(bin2hex(random_bytes(32)));
    //Concatenar password con el salt
    $passwordWithSalt = $password . $passwordSalt;
    //Encriptar el password
    $passwordEncriptado = strtoupper(hash("sha512", $passwordWithSalt));

    //Fecha y hora actual
    $zona_horaria = new DateTimeZone('America/Mexico_City');
    $fecha_actual = new DateTime('now', $zona_horaria);

    $sql = "INSERT INTO `usuarios`(`username`, `password_encrypted`, `password_salt`, `nombre`, `apellidos`, `genero`, `fecha_nacimiento`, `fecha_hora_registro`, `es_admin`, `activo`) VALUES ('" . $username . "', '" . $passwordEncriptado . "', '" . $passwordSalt . "', '" . $nombre ."', '" . $apellidos . "', '" . $genero . "', '" . $fechaNac . "', '" . $fecha_actual->format('Y-m-d H:i:s') . "', '" . 1 . "', '" . 1 . "')";
    $conection = getDbConnection(); //Obtener conexion
    $stmt = $conection->prepare($sql);

    // Ejecutar la consulta
    $stmt->execute();

    echo "Registro exitoso para el usuario: $username";
} else {
    echo "Error: Método de solicitud no permitido";
}
?>