<?php
    header('Content-Type: application/json');  
    include_once '../../conexion.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es admin */
    $user = $data['user'];
    $pass = $data['pass'];
    $id_boda = $data['id_boda'];
    $finalizado = $data['finalizado'];

    include '../esAdmin.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            UPDATE Bodas 
            SET finalizado = ?
            WHERE id_foto = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("ii", $finalizado, $id_foto);

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
        printf("Error al editar el estado de la seleccion: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();