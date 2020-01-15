<?php
    header('Content-Type: application/json');  
    include '../conexion.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            SELECT url, servicio, id_foto
            FROM FotosPublicas 
        ")) {

        /* ejecutar la consulta */
        $stmt->execute();

        /* ligar variables de resultado */
        $stmt->bind_result($url, $servicio, $id_foto);

        $fotos = [];
        while($stmt->fetch()) {
            if ($id_foto <= 5) continue; // porque son las fotos de fondo
              $fotos[] = [
                "src" => str_replace("undefined", "", $url),
                "srcset" => str_replace("undefined", "l", $url),
                "alt" => $servicio,
                "width" => rand(2, 4),
                "height" => rand(2, 3),
                "key" => strval($id_foto)
              ];
        }

        /* Lo codificamos en JSON y enviamos */
        echo json_encode($fotos);

        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf("Error al obtener las fotos: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();