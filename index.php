<?php
session_start();
include_once(__DIR__ . '/INC/connection.inc.php');
$login = false;
$registration_successful = false;

if (isset($_SESSION['user_id'])) {
    // El usuario está logueado
    $login = true;
}

$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = connection('revels', 'revel', 'lever', $utf8);



if ($conexion->errorCode() != PDO::ERR_NONE) {
    echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
    exit;
}





?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>REVELS</title>
</head>
    <?php
    if ($login === true) {
        include_once(__DIR__ . '/INC/tablon.inc.php');
    } else {
        include_once(__DIR__.'/INC/register.inc.php');
    }

    ?>
</body>

</html>