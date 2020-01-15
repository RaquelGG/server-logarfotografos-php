<?php
    header('Content-Type: application/json');  
    include_once '../../conexion.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es admin */
    $user = $data['user'];
    $pass = $data['pass'];
    $id_usuario = $data['id_usuario'];
    $fecha = $data['fecha'];
    $servicio = $data['servicio'];

    include '../esAdmin.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            INSERT INTO Bodas (id_usuario, fecha, servicio)
            VALUES (?, ?, ?);
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("iss", $id_usuario, $fecha, $servicio);
        /* ejecutar la consulta */
        $stmt->execute();

        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf("Error al crear boda: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();