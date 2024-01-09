<?php
require("./db_config.php");

$short = $_REQUEST['short'];
$html = ""; // Inicializar la variable para evitar errores

if (!empty($short)) {
    $db = new mysqli($host, $username, $password, $database);

    if ($db->connect_errno) {
        $html = "Error al conectar con la base de datos: " . $db->connect_error;
    } else {
        $query = $db->prepare("SELECT url FROM url_redirects WHERE short = ?");
        $query->bind_param("s", $short);
        $query->execute();
        $query->store_result();

        if ($query->num_rows > 0) {
            $query->bind_result($url);
            $query->fetch();
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $url);
            exit();
        } else {
            $html = "Error: no se encontró la URL corta";
        }

        $query->close();
        $db->close();
    }
} else {
    $html = "Error: URL corta no proporcionada";
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
