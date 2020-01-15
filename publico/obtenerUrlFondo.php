<?php
    include '../conexion.php';

    $id_foto = $_GET['id_foto'];

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            SELECT url
            FROM FotosPublicas 
            WHERE id_foto = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("i", intval($id_foto));

        /* ejecutar la consulta */
        $stmt->execute();
        
        /* ligar variables de resultado */
        $stmt->bind_result($url);
        
        $a = $stmt->fetch();

        /* Enviamos el resultado */
        $resultado = str_replace("undefined", "", $url);
        echo $resultado;

        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf("Error al obtener la URL: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();