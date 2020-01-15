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
            SELECT nombre, seleccionada, id_foto
            FROM FotosPrivadas, Bodas, Usuarios
            WHERE FotosPrivadas.id_boda=Bodas.id_boda
            AND Usuarios.id_usuario=Bodas.id_usuario
            AND user = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("s", $user);

        /* ejecutar la consulta */
        $stmt->execute();

        /* ligar variables de resultado */
        $stmt->bind_result($nombre, $seleccionada, $id_foto);

        $fotos = [];
        while($stmt->fetch()) {
            $fotos[] = [
                "src" => '',
                //"srcSet" => str_replace("undefined", "l", $url),
                "alt" => $nombre,
                "width" => rand(2, 4),
                "height" => rand(2, 3),
                "isSelected" => $seleccionada,
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