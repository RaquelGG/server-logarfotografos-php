<?php
    header('Content-Type: application/json');  
    include_once '../conexion.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es admin */
    $user = $data['user'];
    $pass = $data['pass'];
    $id_foto = $data['id_foto'];
    $servicio = $data['servicio'];

    include './esAdmin.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            UPDATE FotosPublicas 
            SET servicio = ?
            WHERE id_foto = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("si", $servicio, $id_foto);

        /* ejecutar la consulta */
        $stmt->execute();
        
        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf("Error al editar la etiqueta de la imagen: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();