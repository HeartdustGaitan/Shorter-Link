<?php
// Conexión a la base de datos
$database = "u516712768_linkorto";
$username = "u516712768_admin";
$password = "0#umNLzl&qoR";
$host     = "193.203.166.111";

$conn = new mysqli($host, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos de la tabla url_redirects
$sql = "SELECT id, short, url FROM url_redirects";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="apple-touch-icon" href="./icons/icon-192x192.png">
    <link rel="icon" href="icons/LK.ico" type="image/x-icon">
    <meta name="theme-color" content="#00bcd4">

    <title>Linkorto</title>
    <link type="text/css" rel="stylesheet" href="./css/style.css?v=3" />
    <link rel="manifest" href="manifest.json">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <!-- Agregar estilos adicionales para la responsividad -->
    
</head>
<body>
    <div id="pagewrap">
        <h1>Linkorto</h1>

        <div>
            <form action="./create.php" method="post">
                <span>Ingresa tu enlace aquí</span>
                <input name="url" type="text" />
                <input type="submit" value="shrtr" />
            </form>
        </div>

        <div>
        <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card">';
            echo '<a href="http://linkorto.com/shrtr/' . $row['short'] . '"><p>Short:http://linkorto.com/shrtr/' . $row['short'] . '</p></a>';
            echo '<p>URL: ' . $row['url'] . '</p>';
            echo '</div>';
        }
    } else {
        echo 'No hay datos en la tabla url_redirects.';
    }
    ?>
        </div>
    </div>
    <script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('./service-worker.js')
            .then((registration) => {
                console.log('Service Worker registrado con éxito:', registration);
            })
            .catch((error) => {
                console.error('Error al registrar el Service Worker:', error);
            });
    }
</script>
</body>
</html>
