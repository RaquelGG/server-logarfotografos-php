<?php
    header('Content-Type: application/json');  
    include_once '../../conexion.php';
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es usuario */
    $user = $data['user'];
    $pass = $data['pass'];
    $id_boda = intval($data['id_boda']);

    include '../esAdmin.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            SELECT fecha, servicio, Usuarios.id_usuario, user
            FROM Bodas, Usuarios
            WHERE Usuarios.id_usuario=Bodas.id_usuario
            AND Bodas.id_boda = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("i", $id_boda);

        /* ejecutar la consulta */
        $stmt->execute();

        /* ligar variables de resultado */
        $stmt->bind_result($fecha, $servicio, $id_usuario, $usuario);
        
        $stmt->fetch();

        $datos = [
            "fecha" => $fecha,
            "servicio" => $servicio,
            "id_usuario" => $id_usuario,
            "usuario" => $usuario
        ];

        /* Lo codificamos en JSON y enviamos */
        echo json_encode($datos);

        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf('"Error al obtener los datos: %s"', mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();