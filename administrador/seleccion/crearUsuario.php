<?php
    header('Content-Type: application/json');  
    include_once '../../conexion.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    /* Comprobamos si es admin */
    $user = $data['user'];
    $pass = $data['pass'];
    $nuevoUser = $data['nuevoUser'];
    $nuevaPass = password_hash($data['nuevaPass'], PASSWORD_DEFAULT);


    include '../esAdmin.php';

    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
            INSERT INTO Usuarios (user, pass)
            VALUES (?, ?);
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("ss", $nuevoUser, $nuevaPass);
        /* ejecutar la consulta */
        $stmt->execute();

        /* cerrar sentencia */
        $stmt->close();
    } else {
        printf("Error al crear usuario: %s\n", mysqli_connect_error());
    }
    /* cerrar conexión */
    $mysqli->close();