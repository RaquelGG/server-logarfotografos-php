<?php
    header('Content-Type: application/json');  
    include_once '../../conexion.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es admin */
    $user = $data['user'];
    $pass = $data['pass'];
    $id_boda = $data['id_boda'];
    $fecha = $data['fecha'];
    $servicio = $data['servicio'];

    include '../../esAdmin.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            UPDATE Bodas 
            SET
                fecha = ?,
                servicio = ?
            WHERE id_boda = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("ssi", $fecha, $servicio, $id_boda);

        /* ejecutar la consulta */
        $stmt->execute();
        
        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf("Error al editar la fecha o servicio: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();