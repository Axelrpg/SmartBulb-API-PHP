<?php
// URL del ESP32 y ruta para activar el relé
$url = "http://192.168.149.162/desactivar_rele";

// Realizar la solicitud HTTP GET
$response = file_get_contents($url);

// Verificar la respuesta
if ($response === false) {
    echo "Error al enviar la solicitud";
} else {
    echo "Solicitud enviada correctamente";
}
?>
