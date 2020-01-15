<?php
header('Content-Type: application/json');  
include_once '../../conexion.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

/* Comprobamos si es admin */
$user = $data['user'];
$pass = $data['pass'];
$nuevoUser = $data['nuevoUser'];

include '../esAdmin.php';
    
/* crear una sentencia preparada */
if ($stmt = $mysqli->prepare("
    SELECT COUNT(Usuarios.id_usuario) as esUsuario
    FROM Usuarios
    WHERE user = ?
")) {

    /* ligar parámetros para marcadores */
    $stmt->bind_param("s", $nuevoUser);

    /* ejecutar la consulta */
    $stmt->execute();

    /* ligar variables de resultado */
    $stmt->bind_result($esUsuario);

    $stmt->fetch();

    /* Enviamos el resultado (1 si es Usuario y 0 si no lo es) */
    echo $esUsuario;

    /* cerrar sentencia */
    $stmt->close();

} else {
    printf('"Error al comprobar usuario: %s"', mysqli_connect_error());
}
/* cerrar conexión */
$mysqli->close();