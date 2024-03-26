<?php
require "config.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $archivos = scandir(DIR_UPLOAD);

    $nombreArchivos = array();

    foreach ($archivos as $archivo) {
        if (is_file(DIR_UPLOAD .  $archivo)) {
            $size = filesize(DIR_UPLOAD . $archivo);

            $nombreArchivos[] = array(
                "nombre" => $archivo,
                "size" => $size
            );
        }
    }

    $json_response = json_encode($nombreArchivos);

    header('Content-Type: application/json');
    echo $json_response;
}
?>