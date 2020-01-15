<?php
    header('Content-Type: application/json');  
    include '../conexion.php';
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es usuario */
    $user = $data['user'];
    $pass = $data['pass'];

    include '../publico/esUsuario.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            SELECT fecha, servicio, descripcion
            FROM Bodas, Usuarios
            WHERE Usuarios.id_usuario=Bodas.id_usuario
            AND user = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("s", $user);

        /* ejecutar la consulta */
        $stmt->execute();

        /* ligar variables de resultado */
        $stmt->bind_result($fecha, $servicio, $descripcion);
        
        $stmt->fetch();

        $datos = [
            "fecha" => $fecha,
            "servicio" => $servicio,
            "descripcion" => $descripcion
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