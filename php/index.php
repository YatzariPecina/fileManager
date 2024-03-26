<?php
require "config.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
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
?>