<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $archivos = scandir(DIR_UPLOAD);

    $nombreArchivos = array();

    foreach ($archivos as $archivo) {
        if (is_file(DIR_UPLOAD .  $archivo)) {

            $nombreArchivos[] = array(
                "nombre" => $archivo,
                "size" => round(filesize(DIR_UPLOAD . $archivo) / 1024, 2)
            );
        }
    }

    $json_response = json_encode($nombreArchivos);

    header('Content-Type: application/json');
    echo $json_response;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombreFile"])) {
        $nombreArchivo = $_POST["nombreFile"];
        $rutaArchivo = DIR_UPLOAD . $nombreArchivo;

        // Verificar si el archivo existe
        if (file_exists($rutaArchivo)) {
            // Intentar eliminar el archivo
            if (unlink($rutaArchivo)) {
                // Si se eliminó correctamente, responder con éxito
                http_response_code(200);
                exit("Archivo eliminado correctamente.");
            } else {
                // Si hubo un error al eliminar el archivo, responder con error
                http_response_code(500);
                exit("Error al eliminar el archivo.");
            }
        } else {
            // Si el archivo no existe, responder con error
            http_response_code(404);
            exit("El archivo no existe.");
        }
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Definir el array de extensiones permitidas
            $extensionesPermitidas = array_keys($CONTENT_TYPES_EXT);

            // Obtener la extensión del archivo subido
            $nombreArchivo = $_FILES["archivo"]["name"];
            $extensionArchivo = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

            // Verificar si la extensión está permitida
            if (!in_array($extensionArchivo, $extensionesPermitidas)) {
                http_response_code(400); // Bad Request
                exit("Error: Tipo de archivo no permitido.");
            }

            // Generar el nombre de archivo final
            $nombreFinal = isset($_POST['nombreArchivo']) ? $_POST['nombreArchivo'] : basename($nombreArchivo, "." . $extensionArchivo) . "." . $extensionArchivo;

            // Ruta completa donde se guardará el archivo
            $rutaFinal = DIR_UPLOAD . $nombreFinal;

            // Copiar el archivo subido a la ruta final
            if (copy($_FILES["archivo"]["tmp_name"], $rutaFinal)) {
                echo "Archivo subido correctamente.";
            } else {
                http_response_code(500); // Internal Server Error
                exit("Error al subir el archivo.");
            }
        }
    }
}
