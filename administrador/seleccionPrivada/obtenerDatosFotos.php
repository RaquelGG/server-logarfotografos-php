<?php
    header('Content-Type: application/json');  
    include_once '../../conexion.php';
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es usuario */
    $user = $data['user'];
    $pass = $data['pass'];
    $id_boda = $data['id_boda'];

    include '../esAdmin.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            SELECT id_foto, nombre
            FROM Bodas, FotosPrivadas
            WHERE FotosPrivadas.id_boda = Bodas.id_boda
            AND Bodas.id_boda = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("i", $id_boda);

        /* ejecutar la consulta */
        $stmt->execute();

        /* ligar variables de resultado */
        $stmt->bind_result($id_foto, $nombre);

        $fotos = [];
        while($stmt->fetch()) {
            $fotos[] = [
                "src" => '',
                //"srcSet" => str_replace("undefined", "l", $url),
                "alt" => $nombre,
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
        printf('"Error al obtener las id_fotos: %s"', mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();