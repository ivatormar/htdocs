<?php
session_start();

include_once(__DIR__.'/INC/connection.inc.php');

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

$stmtFollowers = $conexion->prepare('SELECT COUNT(userid) AS followers FROM follows WHERE userfollowed = :userID');
$stmtFollowers->bindParam(':userID', $userData['id']);
$stmtFollowers->execute();
$followersData = $stmtFollowers->fetch(PDO::FETCH_ASSOC);
$followersCount = $followersData['followers'];

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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Encabezado y estilos -->
</head>

<body>
    <!-- Contenido de la página -->
    <div>
        <!-- Datos del usuario -->
        <h2>Datos del Usuario</h2>
        <p>ID: <?php echo $userData['id']; ?></p>
        <p>Usuario: <?php echo htmlspecialchars($userData['usuario']); ?></p>
        <p>Email: <?php echo htmlspecialchars($userData['email']); ?></p>
        <p>Seguidores: <?php echo $followersCount; ?></p>

        <!-- Lista de Revels del usuario -->
        <h2>Revels del Usuario</h2>
        <ul>
            <?php foreach ($userRevels as $revel) : ?>
                <li>
                    <!-- Enlace a la página revel -->
                    <a href="/revel.php?id=<?php echo $revel['revel_id'];?>">
                        <!-- Primeros 50 caracteres del texto de la revel -->
                        <?php echo htmlspecialchars(substr($revel['revel_texto'], 0, 50)); ?>
                    </a>
                    <!-- Cantidad de me gusta y no me gusta -->
                    <p>Likes: <?php echo $revel['likes_count']; ?>, Dislikes: <?php echo $revel['dislikes_count']; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <a href="/index.php">Volver al Tablón</a>
</body>

</html>