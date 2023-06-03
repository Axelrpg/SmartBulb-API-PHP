<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "focos";

// Crear una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener el valor del campo
$sql = "SELECT estado FROM bulb WHERE id = 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $valor = $row["estado"];

    // Enviar solicitud HTTP a Arduino cuando el valor es 1
if ($valor == 1) {
    $url = "http://192.168.149.162/activar_rele";
    $response = file_get_contents($url);

    // Verificar la respuesta y realizar acciones adicionales si es necesario
    if ($response === false) {
        echo "Error al enviar la solicitud";
    } else {
        echo "Solicitud enviada correctamente";
    }
}

// Enviar otra solicitud HTTP a Arduino cuando el valor es 0
elseif ($valor == 0) {
    $url = "http://192.168.149.162/desactivar_rele";
    $response = file_get_contents($url);

    // Verificar la respuesta y realizar acciones adicionales si es necesario
    if ($response === false) {
        echo "Error al enviar la solicitud";
    } else {
        echo "Solicitud enviada correctamente";
    }
}
} else {
    echo "No se encontraron resultados";
}

$conn->close();
?>
