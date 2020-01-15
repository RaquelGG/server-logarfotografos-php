<?php
    header('Content-Type: application/json');  
    include_once '../conexion.php';


    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $user = $data['user'];
    $pass = $data['pass'];

    include '../administrador/esAdmin.php';

    /* Si no se ha ejecutado exit, entonces es administrador */
    echo 1;