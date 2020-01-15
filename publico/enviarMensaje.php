<?php
header('Content-Type: application/json');  

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$nombre = limpiarTextoSinHtml($data['nombre']);
$correo = limpiarTextoSinHtml($data['correo']);
$mensaje = limpiarTextoConHtml($data['mensaje']);

$textosJson = file_get_contents('../../json/editables.json');
$textos = json_decode($textosJson, true);
$correoEmpresa = $textos["contacto.tabla.correo"];
echo $correoEmpresa;

if (mail($correoEmpresa, "Correo desde Logar Fotógrafos ". $nombre, "[No contestes a este correo]\nCon correo: " . $correo . "\nContenido del mensaje:". $mensaje)){
    echo "El mensaje se ha enviado correctamente";
} else {
    echo "No se ha podido enviar el mensaje";
}


function limpiarTextoSinHtml($s){
    // Quita símbolos raros como "H\ola"
    // También quita tags html
    // Se usa en todo lo que no debería contener HTML
    return htmlentities(trim(strip_tags(stripslashes($s))), ENT_NOQUOTES, "UTF-8");
}

function limpiarTextoConHtml($s){
    // Quita símbolos raros como "H\ola"
    // No quita tags tipo &lt;html&gt pero el resto sí
    // Se usa para el textArea
    return strip_tags(htmlentities(trim(stripslashes($s))), ENT_NOQUOTES);
}