<?php
//include_once '../../conexion.php';

$ok = false;
    
/* crear una sentencia preparada */
if ($stmt = $mysqli->prepare("
    SELECT pass
    FROM Usuarios 
    WHERE user = ?
    AND esAdmin = 1
")) {

    /* ligar parámetros para marcadores */
    $stmt->bind_param("s", $user);

    /* ejecutar la consulta */
    $stmt->execute();

    /* ligar variables de resultado */
    $stmt->bind_result($passBd);

    $stmt->fetch();

    /* Enviamos el resultado (1 si es Admin y 0 si no lo es) */
    if (password_verify($pass, $passBd)) {
        $ok = true;
    } 
    
    /* cerrar sentencia */
    $stmt->close();

} else {
    //printf('"Error al comprobar usuario: %s"', mysqli_connect_error());
}
/* cerrar conexión */
if (!$ok) {
    echo 0;
    $mysqli->close();
    exit(0);
}