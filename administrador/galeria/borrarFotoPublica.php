<?php
    include_once '../../conexion.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es admin */
    $user = $data['user'];
    $pass = $data['pass'];
    $id_foto = $data['id_foto'];

    include '../esAdmin.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            DELETE FotosPublicas
            FROM FotosPublicas 
            WHERE id_foto = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("i", $id_foto);

        /* ejecutar la consulta */
        $stmt->execute();
        
        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf("Error al eliminar imagenes: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();