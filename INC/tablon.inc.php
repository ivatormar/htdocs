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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se hizo clic en el botón "Me gusta" o "No me gusta"
    if (isset($_POST['like']) || isset($_POST['dislike'])) {
        $revelId = $_POST['revel_id'];

        // Verificar si el usuario está intentando dar like o dislike a su propia revelación
        $stmtCheckOwnRevel = $conexion->prepare('SELECT userid FROM revels WHERE id = :revelId');
        $stmtCheckOwnRevel->bindParam(':revelId', $revelId);
        $stmtCheckOwnRevel->execute();
        $resultCheckOwnRevel = $stmtCheckOwnRevel->fetch(PDO::FETCH_ASSOC);

        if ($resultCheckOwnRevel['userid'] != $userId) {
            // El usuario no está intentando dar like o dislike a su propia revelación
            // Eliminar cualquier like o dislike previo del usuario para esta revelación
            $stmtDeletePrevious = $conexion->prepare('DELETE FROM likes WHERE revelid = :revelId AND userid = :userId');
            $stmtDeletePrevious->bindParam(':revelId', $revelId);
            $stmtDeletePrevious->bindParam(':userId', $userId);
            $stmtDeletePrevious->execute();

            $stmtDeletePrevious = $conexion->prepare('DELETE FROM dislikes WHERE revelid = :revelId AND userid = :userId');
            $stmtDeletePrevious->bindParam(':revelId', $revelId);
            $stmtDeletePrevious->bindParam(':userId', $userId);
            $stmtDeletePrevious->execute();

            // Insertar el nuevo like o dislike
            if (isset($_POST['like'])) {
                $stmtInsert = $conexion->prepare('INSERT INTO likes (revelid, userid) VALUES (:revelId, :userId)');
            } elseif (isset($_POST['dislike'])) {
                $stmtInsert = $conexion->prepare('INSERT INTO dislikes (revelid, userid) VALUES (:revelId, :userId)');
            }

            $stmtInsert->bindParam(':revelId', $revelId);
            $stmtInsert->bindParam(':userId', $userId);
            $stmtInsert->execute();
        }
    }
}


function obtenerNumeroComentarios($revelId, $conexion)
{
    // Consultar la cantidad de comentarios para la revelación con el ID proporcionado
    $stmt = $conexion->prepare('SELECT COUNT(id) AS cantidad FROM comments WHERE revelid = :revelId');
    $stmt->bindParam(':revelId', $revelId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devolver la cantidad de comentarios
    return $result['cantidad'];
}



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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                <!-- Agrega esto en tu formulario de búsqueda en tablon.inc.php -->
                <form method="post" action="/results.php" class="me-3">
                    <div class="form-white input-group" style="width: 250px;">
                        <input type="search" class="form-control rounded" placeholder="Search..." name="search_query" aria-label="Search" aria-describedby="search-addon">
                        <button id="btnSearch" type="submit" class="btn button-33">Buscar</button>
                    </div>
                </form>

            </div>
            <h3 id='bienvenido'>
                ¡Bienvenid@, <?php echo $_SESSION['usuario'] ?>!
            </h3>
            <div class="buttons">
                <form method="post" action="/user.php?usuario=<?php echo urlencode($_SESSION['usuario']); ?>">
                    <button type="submit" class="btn button-33"> Mi perfil </button>
                </form>
                <form method="post" action="/new.php">
                    <button type="submit" class="btn button-33"> Nuevo Revel </button>
                </form>
                <form method="post" action="/close.php">
                    <button type="submit" class="btn button-33"> Salir </button>
                </form>
            </div>
        </div>
    </nav>
    <div class="content">
        <?php include_once(__DIR__ . '/sidebar.inc.php') ?>

        <!-- Mostrar las revels -->
        <div class="revels-container">
            <?php
            foreach ($revels as $revel) {
                echo '<div class="revel">';
                echo '<div class="revel-box">';
                echo '<p class="revel-text"><a href="/revel.php?id=' . $revel['id'] . '">' . htmlspecialchars($revel['texto']) . '</a></p>';
                echo '<p class="revel-info">Publicado por <a href="/user.php?usuario=' . urlencode($revel['autor_usuario']) . '">' . htmlspecialchars($revel['autor_usuario']) . '</a> - Fecha: ' . htmlspecialchars($revel['fecha']) . '</p>';

                // Agregar botones o iconos para indicar me gusta y no me gusta
                echo '<div class="revel-actions">';
                echo '<form method="post">';
                echo '<input type="hidden" name="revel_id" value="' . $revel['id'] . '">';
                echo '<button type="submit" name="like" class="btn-like"><i class="bx bxs-like"></i></button>';
                echo '</form>';
                echo '<form method="post">';
                echo '<input type="hidden" name="revel_id" value="' . $revel['id'] . '">';
                echo '<button type="submit" name="dislike" class="btn-dislike"><i class="bx bxs-dislike"></i></button>';
                echo '</form>';
                echo '</div>';

                // Mostrar el número de comentarios
                echo '<p class="comment-info">Comentarios: ' . obtenerNumeroComentarios($revel['id'], $conexion) . '</p>';

                echo '</div>';
                echo '</div>';
            }
            ?>

        </div>
    </div>
</body>

</html>