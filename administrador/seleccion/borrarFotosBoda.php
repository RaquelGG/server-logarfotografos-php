<?php
    header('Content-Type: application/json');  
    include_once '../../conexion.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es admin */
    $user = $data['user'];
    $pass = $data['pass'];
    $id_boda = $data['id_boda'];

    include '../../esAdmin.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            DELETE FotosPrivadas 
            FROM FotosPrivadas 
            WHERE id_boda = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("i", $id_boda);

        /* ejecutar la consulta */
        $stmt->execute();
        
        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf("Error al eliminar imagenes: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();