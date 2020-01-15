<?php
    include_once '../conexion.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es usuario */
    $user = $data['user'];
    $pass = $data['pass'];

    include '../publico/esUsuario.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            UPDATE Bodas
            INNER JOIN Usuarios ON Bodas.id_usuario = Usuarios.id_usuario
            SET finalizado = 1
            WHERE user = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("s", $user);

        /* ejecutar la consulta */
        $stmt->execute();
        
        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf("Error finalizando selección: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();