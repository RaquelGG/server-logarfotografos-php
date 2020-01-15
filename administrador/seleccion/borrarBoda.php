<?php
header('Content-Type: application/json');
include_once '../../conexion.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

/* Comprobamos si es admin */
$user = $data['user'];
$pass = $data['pass'];
$id_boda = $data['id_boda'];
$fecha = $data['fecha'];

include '../esAdmin.php';

$directorio = '../../../../bodas/' . $fecha;
rrmdir($directorio);

/* crear una sentencia preparada */
if ($stmt = $mysqli->prepare("
            DELETE Bodas
            FROM Bodas 
            WHERE id_boda = ?
        ")) {

    /* ligar parámetros para marcadores */
    $stmt->bind_param("s", $id_boda);

    /* ejecutar la consulta */
    $stmt->execute();

    /* cerrar sentencia */
    $stmt->close();
} else {
    printf("Error al eliminar boda: %s\n", mysqli_connect_error());
    exit();
}
// BORRAMOS LOS ENLACES A LAS FOTOS
/* crear una sentencia preparada */
if ($stmt = $mysqli->prepare("
            DELETE FotosPrivadas
            FROM FotosPrivadas 
            WHERE id_boda = ?
        ")) {

    /* ligar parámetros para marcadores */
    $stmt->bind_param("s", $id_boda);

    /* ejecutar la consulta */
    $stmt->execute();

    /* cerrar sentencia */
    $stmt->close();
} else {
    printf("Error al eliminar la tabla de fotos: %s\n", mysqli_connect_error());
    exit();
}
/* cerrar conexión */
$mysqli->close();

// Borra un directorio y su contenido
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . "/" . $object) && !is_link($dir . "/" . $object))
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);
            }
        }
        rmdir($dir);
    }
}
