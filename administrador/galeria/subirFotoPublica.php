<?php
    include_once '../../conexion.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es admin */
    $user = $data['user'];
    $pass = $data['pass'];
    $url = $data['url'];
    $servicio = $data['servicio'];

    include '../esAdmin.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            INSERT INTO FotosPublicas (url, servicio)
            VALUES (?, ?);
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("ss", $url, $servicio);

        /* ejecutar la consulta */
        $stmt->execute();
        
        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf("Error al editar la etiqueta de la imagen: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();