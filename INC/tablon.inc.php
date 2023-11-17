<?php

// Realizar la conexión a la base de datos
$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = connection('revels', 'revel', 'lever', $utf8);

// Verificar si hay errores de conexión
if ($conexion->errorCode() != PDO::ERR_NONE) {
    echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
    exit;
}

// Consultar todas las revels del usuario actual y de los usuarios a los que sigue
$userId = $_SESSION['user_id'];

$stmt = $conexion->prepare('SELECT r.*, u.usuario AS autor_usuario
                            FROM revels r
                            INNER JOIN users u ON r.userid = u.id
                            WHERE r.userid = :userId OR r.userid IN (SELECT userfollowed FROM follows WHERE userid = :userId)
                            ORDER BY r.fecha DESC');
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$revels = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/tablon.css">
    <link rel="shortcut icon" href="/MEDIA-REVELS-LOGO/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Revels.</title>
</head>

<body cz-shortcut-listen="true" class="body">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="/index.php">
                <img src="/MEDIA-REVELS-LOGO/logo-navbar.png" alt="logoNav">
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="me-3">
                    <div class="form-white input-group" style="width: 250px;">
                        <input type="search" class="form-control rounded" placeholder="Search..." aria-label="Search" aria-describedby="search-addon">
                    </div>
                </form>
            </div>
            <h3>
                ¡Bienvenido, <?php echo $_SESSION['usuario'] ?>!
            </h3>
            <div class="buttons">
                <button type="button" class="btn button-33" data-mdb-ripple-color="#ffffff"> Mi perfil </button>
                <button type="button" class="btn button-33" data-mdb-ripple-color="#ffffff"> Nuevo Revel </button>
                <form method="post" action="/INC/logout.inc.php">
                    <button type="submit" class="btn button-33"> Salir </button>
                </form>
            </div>
        </div>
    </nav>
    <div class="content">
        <aside class="sidebar">
            <div class="followedUsers">
                <h2>Usuarios que sigues</h2>
                <ul>
                    <li><i></i> Usuario 1</li>
                    <li><i></i> Usuario 2</li>
                    <!-- Agrega más usuarios según sea necesario -->
                </ul>
            </div>
        </aside>
        <!-- Mostrar las revels -->
        <div class="revels-container">
            <?php
            foreach ($revels as $revel) {
                echo '<div class="revel">';
                echo '<div class="revel-box">';
                echo '<p class="revel-text"><a href="/INC/revel.inc.php?id=' . $revel['id'] . '">' . htmlspecialchars($revel['texto']) . '</a></p>';
                echo '<p class="revel-info">Publicado por <a href="/INC/user.inc.php?usuario=' . urlencode($revel['autor_usuario']) . '">' . htmlspecialchars($revel['autor_usuario']) . '</a> - Fecha: ' . htmlspecialchars($revel['fecha']) . '</p>';
                // Agregar las imágenes para indicar si gusta o no aquí
                // Y también el número de comentarios
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>

</html>
