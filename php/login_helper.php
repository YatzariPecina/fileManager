<?php
require "db.php";

/**
 * Función con la que validamos el usuario por su username y password. Si no se validan
 * los datos, regresara un false, en caso de que se valide correctamente el usuario,
 * regresara un assoc array con los datos del usuario.
 */
function autentificar($username, $password) {

    // Si no nos han enviado los parámetros, regresamos false.
    if (!$username || !$password) {
        return false;
    }

    //Parametros para la consulta
    $sqlConsult = "SELECT * FROM usuarios WHERE username = '" . $username . "'";
    $conection = getDbConnection(); //Obtener conexion
    $stmt = $conection->prepare($sqlConsult);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $resultado = $stmt->fetchAll();
    $user = NULL;  // Aquí pondremos al usuario que encontramos

    // Recorremos todo el array para encontrar al usuario por el username, esto
    // para simular una consulta a DB de una tabla de usuarios
    foreach ($resultado as $u) {
        if ($username == $u["username"]) {
            $user = $u;
            break;
        }
    }

    // Si no encontramos al usuario, regresamos false
    if (!$user) {
        return false;
    }

    // Se obtiene el hash que representa el password junto con el salt
    $passwordMasSalt = $password . $user["password_salt"];
    $passwordEncrypted = strtoupper(hash("sha512", $passwordMasSalt));

    // Comparamos si el password encrypted del password que nos pasaron es el
    // que corresponde al password encrypted del usuario, si no es así, el
    // login es incorrecto y se regresa un false
    if ($passwordEncrypted != $user["password_encrypted"]) {
        return false;
    }

    // En este punto ya se realizó correctamente la autenticación, por lo que
    // regresamos un assoc array con los datos del usuario
    return [
        "id" => $user["id"],
        "username" => $user["username"],
        "nombre" => $user["nombre"],
        "esAdmin" => $user["es_admin"]
    ];
}
