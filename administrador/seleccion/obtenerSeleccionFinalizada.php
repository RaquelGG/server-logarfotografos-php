<?php
header('Content-Type: application/json');
include_once '../../conexion.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

/* Comprobamos si es admin */
$user = $data['user'];
$pass = $data['pass'];
$id_boda = intval($data['id_boda']);

include '../esAdmin.php';

/* crear una sentencia preparada */
if ($stmt = $mysqli->prepare("
            SELECT nombre
            FROM FotosPrivadas
            WHERE id_boda = ?
        ")) {

    /* ligar parámetros para marcadores */
    $stmt->bind_param("i", $id_boda);

    /* ejecutar la consulta */
    $stmt->execute();

    /* ligar variables de resultado */
    $stmt->bind_result($nombre);

    $seleccion = "";

    while ($stmt->fetch()) {
        $seleccion = $seleccion . $nombre . "-*-"; //Ponemos estos caracteres especiales para después, en el cliente reemplazarlos
    }

    /* Enviamos el resultado */

    echo substr($seleccion, 0, -3);
    //echo $seleccion;

    /* cerrar sentencia */
    $stmt->close();
} else {
    printf('"Error al comprobar usuario: %s"', mysqli_connect_error());
}
/* cerrar conexión */
$mysqli->close();
