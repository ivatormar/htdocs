<!-- list: mostrará una lista de todas las Revels escritas por el usuario similar a la de la página user
junto con un botón para poder eliminar cada una de ellas. -->

<?php
session_start();
include_once(__DIR__ . '/INC/connection.inc.php');

$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = connection('revels', 'revel', 'lever', $utf8);

if ($conexion->errorCode() != PDO::ERR_NONE) {
    echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
    exit;
}

$username = $_GET['usuario'];

$stmtUser = $conexion->prepare('SELECT * FROM users WHERE usuario = :username');
$stmtUser->bindParam(':username', $username);
$stmtUser->execute();
$userData = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    header('Location: /index');
    exit;
}

$stmtRevels = $conexion->prepare('SELECT r.id AS revel_id, r.texto AS revel_texto, r.fecha AS revel_fecha, 
                                   COUNT(l.revelid) AS likes_count, COUNT(d.revelid) AS dislikes_count
                               FROM revels r
                               LEFT JOIN likes l ON r.id = l.revelid
                               LEFT JOIN dislikes d ON r.id = d.revelid
                               WHERE r.userid = :userID
                               GROUP BY r.id');
$stmtRevels->bindParam(':userID', $userData['id']);
$stmtRevels->execute();
$userRevels = $stmtRevels->fetchAll(PDO::FETCH_ASSOC);

include_once('user-view.php');
?>
