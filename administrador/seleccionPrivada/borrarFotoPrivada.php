<?php
header('Content-Type: application/json');
include_once '../../conexion.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

/* Comprobamos si es admin */
$user = $data['user'];
$pass = $data['pass'];
$nombre = $data['nombre'];
$fecha = $data['fecha'];

echo "usuario: " . $user;
echo "| pass: " . $pass;

include '../esAdmin.php';

$directorio = '../../../../bodas/' . $fecha;
if (unlink($directorio . '/' . $nombre)) { // Elimina del servidor
    /* crear una sentencia preparada */// Elimina de la base de datos
    /*
    if ($stmt = $mysqli->prepare("
        DELETE Bodas
        FROM Bodas 
        WHERE nombre = ?
        ")) {

        $stmt->bind_param("s", $nombre);

        $stmt->execute();

        $stmt->close();
    } else {
        printf("Error al eliminar boda: %s\n", mysqli_connect_error());
        exit();
    }*/

    // BORRAMOS LOS ENLACES A LAS FOTOS
    /* crear una sentencia preparada */
    if ($stmt = $mysqli->prepare("
        DELETE FotosPrivadas
        FROM FotosPrivadas 
        WHERE nombre = ?
        ")) {

        /* ligar parámetros para marcadores */
        $stmt->bind_param("s", $nombre);

        /* ejecutar la consulta */
        $stmt->execute();

        /* cerrar sentencia */
        $stmt->close();
    } 
}else {
    printf("Error al eliminar la tabla de fotos: %s\n", mysqli_connect_error());
}
/* cerrar conexión */
$mysqli->close();
