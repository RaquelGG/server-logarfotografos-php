<?php
    header('Content-Type: application/json');  
    include_once '../../conexion.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es admin */
    $user = $data['user'];
    $pass = $data['pass'];

    include '../esAdmin.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            SELECT id_boda, fecha, finalizado, servicio
            FROM Usuarios, Bodas
            WHERE Usuarios.id_usuario=Bodas.id_usuario
            ORDER BY fecha DESC
        ")) {

        
        /* ejecutar la consulta */
        $stmt->execute();

        /* ligar variables de resultado */
        $stmt->bind_result($id_boda, $fecha, $finalizado, $servicio);

        $datos = [];
        while($stmt->fetch()) {
            $datos[] = [
                "id_boda" => $id_boda,
                "fecha" => $fecha,
                "finalizado" => $finalizado,
                "servicio" => $servicio
              ];
        }

        echo json_encode($datos);
        
        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf("Error al comprobar usuario: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();