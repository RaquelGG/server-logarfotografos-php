<?php
header('Content-Type: application/json');
include_once '../../conexion.php';
$json = file_get_contents('php://input');
$data = json_decode($json, true);

/* Comprobamos si es usuario */
$user = $data['user'];
$pass = $data['pass'];
$nombre = $data['nombre'];
$fecha = $data['fecha'];

//include '../publico/esUsuario.php';
include '../esAdmin.php';

/* cerrar conexión */
$mysqli->close();

// open the file in a binary mode
$ruta = '../../../../bodas/' . $fecha . '/' . $nombre;
$fp = fopen($ruta, 'rb');

// send the right headers
header("Content-Type: image/jpg");
header("Content-Length: " . filesize($ruta));

// dump the picture and stop the script
fpassthru($fp);
exit;
