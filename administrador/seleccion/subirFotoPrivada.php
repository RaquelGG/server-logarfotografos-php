<?php
    header('Content-Type: application/json');  
    include_once '../../conexion.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es admin */
    $user = $data['user'];
    $pass = $data['pass'];
    $url = $data['url'];
    $id_boda = $data['id_boda'];
    $nombre = $data['nombre'];

    include '../esAdmin.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            INSERT INTO FotosPrivadas (id_boda, url, nombre)
            VALUES (?, ?, ?);
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("iss", $id_boda, $url, $nombre);

        /* ejecutar la consulta */
        $stmt->execute();

        /* ligar variables de resultado */
        $stmt->bind_result($resultado);

        $stmt->fetch();

        /* Enviamos el resultado (1 si es usuario y 0 si no lo es) */
        echo $resultado;
        
        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf("Error al subir la imagen: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();