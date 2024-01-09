<?php
require("./db_config.php");

$url = $_REQUEST['url'];

$html = ""; // Inicializar la variable para evitar errores

if(!preg_match("/^[a-zA-Z]+[:\/\/]+[A-Za-z0-9\-_]+\\.+[A-Za-z0-9\.\/%&=\?\-_]+$/i", $url)) {
    $html = "Error: URL inválida";
} else {
    $db = new mysqli($host, $username, $password, $database);

    if ($db->connect_errno) {
        $html = "Error al conectar con la base de datos: " . $db->connect_error;
        // Manejo de errores de conexión aquí
    } else {
        $short = substr(md5(time() . $url), 0, 5);
        $query = $db->prepare("INSERT INTO `url_redirects` (`short`, `url`) VALUES (?, ?)");
        $query->bind_param("ss", $short, $url);

        if ($query->execute()) {
            $html = "Tu URL corta es: <br />shrtr/" . $short;
        } else {
            $html = "Error: no se pudo insertar en la base de datos";
        }

        $query->close();
        $db->close();
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Makes URLs Shrtr</title>
    <link type="text/css" rel="stylesheet" href="./css/style.css" />
</head>
<body>
    <div id="pagewrap">
        <h1>shrt<span>r</span>.me</h1>

        <div>
            <?= $html ?>
            <br /><br />
            <span><a href="./">X</a></span>
        </div>

    </div>
</body>
</html>
