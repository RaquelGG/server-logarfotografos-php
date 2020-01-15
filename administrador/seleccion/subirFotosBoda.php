<?php
include_once '../../conexion.php';

/* Comprobamos si es admin */
$user = strval($_POST['user']);
$pass = strval($_POST['pass']);
$fotos = $_FILES["fotos"];
$fecha = strval($_POST['fecha']);
$id_boda = "";
$nombre = "";

echo ("usuario: " . $user);
echo ("pass: " . $pass);

echo ("fecha: " . $fecha);
print_r($fotos);

include '../esAdmin.php';

$extractPath = '../../../../bodas/' . $fecha;

// Extraemos el archivo
$zip = new ZipArchive;
$zip->open($fotos["tmp_name"]);
$zip->extractTo($extractPath);
$zip->close();

// Obtenemos el id_boda
/* crear una sentencia preparada */
if ($stmt = $mysqli->prepare("
    SELECT id_boda
    FROM Bodas
    WHERE fecha = ?
")) {
    /* ligar parámetros para marcadores */
    $stmt->bind_param("s", $fecha);
    /* ejecutar la consulta */
    $stmt->execute();

    /* ligar variables de resultado */
    $stmt->bind_result($id);

    $stmt->fetch();

    $id_boda = intval($id);

    /* cerrar sentencia */
    $stmt->close();
} else {
    printf("Error al obtener el id_boda: %s\n", mysqli_connect_error());
}

// Insertamos en la bd los nombres de las imagenes
print_r(scandir($extractPath, 1));
print_r($id_boda);

if ($handler = opendir($extractPath . "/")) {
    while (false !== ($file = readdir($handler))) {
        if ($file == '.' || $file == '..') continue;
        print_r($file);
        if ($stmt = $mysqli->prepare("
            INSERT INTO FotosPrivadas (id_boda, nombre)
            VALUES (?, ?);
        ")) {

            /* ligar parámetros para marcadores */
            $stmt->bind_param("is", $id_boda, $file);
            /* ejecutar la consulta */
            $stmt->execute();

            /* cerrar sentencia */
            $stmt->close();
        } else {
            echo("Error al añadir la foto a la bd: %s\n". mysqli_connect_error());
        }
    }
    closedir($handler);
}
/* cerrar conexión */
$mysqli->close();
