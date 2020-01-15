<?php
header('Content-Type: application/json');
include_once '../conexion.php';
$json = file_get_contents('php://input');
$data = json_decode($json, true);

/* Comprobamos si es admin */
$user = $data['user'];
$pass = $data['pass'];
$jsn = $data['jsn'];
include './esAdmin.php';

$fp = fopen('../../json/editables.json', 'w');
fwrite($fp, json_encode($jsn));
fclose($fp);
