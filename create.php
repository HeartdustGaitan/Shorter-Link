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
            $html = "Tu enlace acortado es: <br/> <a href='http://linkorto.com/shrtr/" . $short . "'> linkorto.com/shrtr/" . $short . "</a>";
        } else {
            $html = "Error: no se pudo insertar en la base de datos";
        }

        $query->close();
        $db->close();
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linkorto</title>
    <link type="text/css" rel="stylesheet" href="./css/style.css?v=4" />
    <link rel="icon" href="icons/LK.ico" type="image/x-icon">
</head>
<body>
    <div id="pagewrap">
        <h1>Linkorto</h1>

        <div>
            <?= $html ?>
            <br /><br />
            <span><a href="./">X</a></span>
        </div>
    </div>
</body>
</html>
