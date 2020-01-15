<?php
    //error_reporting(E_ALL);
    //header('Content-Type:text/plain'); 
    // Nos conectamos a la base de datos
    
    $datos = json_decode(file_get_contents(dirname(__FILE__).'/../.auth.json'), true);
    $mysqli = new mysqli($datos['host'], $datos['user'], $datos['password'], $datos['database']);
    /* verificar conexión */
    if (mysqli_connect_errno()) {
        printf("Error en la conexión: %s\n", mysqli_connect_error());
        //exit();
    } 
?>