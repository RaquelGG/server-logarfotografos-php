<?php
    include_once '../conexion.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es admin */
    $user = $data['user'];
    $pass = $data['pass'];
    $id_foto = $data['id_foto'];
    $url = $data['url'];

    include './esAdmin.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            UPDATE FotosPublicas 
            SET url = ?
            WHERE id_foto = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("si", $url, $id_foto);

        /* ejecutar la consulta */
        $stmt->execute();


    } else {
        printf("Error al editar la imagen de fondo: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();