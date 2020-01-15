<?php
    include_once '../conexion.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es usuario */
    $user = $data['user'];
    $pass = $data['pass'];
    $id_foto = $data['id_foto'];
    $seleccionada = $data['seleccionada'];

    include '../publico/esUsuario.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            UPDATE FotosPrivadas
            INNER JOIN Bodas ON FotosPrivadas.id_boda = Bodas.id_boda 
            INNER JOIN Usuarios ON Bodas.id_usuario = Usuarios.id_usuario
            SET seleccionada = ?
            WHERE id_foto = ?
            AND user = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("iis", $seleccionada, $id_foto, $user);

        /* ejecutar la consulta */
        $stmt->execute();
        
        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf("Error actualizar la selección de la imagen: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();