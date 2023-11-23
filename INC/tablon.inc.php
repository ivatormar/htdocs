<?php
// Realizar la conexión a la base de datos
include_once(__DIR__ . '/obtenerNumeroComments.inc.php');
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

$stmt = $conexion->prepare('
   SELECT r.*, u.usuario AS autor_usuario,(SELECT COUNT(*) FROM likes WHERE revelid = r.id) AS likes, (SELECT COUNT(*) FROM dislikes WHERE revelid = r.id) AS dislikes
   FROM revels r
   INNER JOIN users u ON r.userid = u.id
   WHERE r.userid = :userId OR r.userid IN (SELECT userfollowed FROM follows WHERE userid = :userId)
   ORDER BY r.fecha DESC
');
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
<?php include_once(__DIR__ . '/headNavbarTablon.inc.php') ?>

<body cz-shortcut-listen="true" class="body">
    <div class="content">
        <?php include_once(__DIR__ . '/sidebar.inc.php') ?>
        <!-- Mostrar las revels -->
        <div class="revels-container">
            <?php
            foreach ($revels as $revel) {
                echo '<div class="revel">';
                echo '<div class="revel-box">';
                echo '<p class="revel-text"><a href="/revel/' . $revel['id'] . '">' . htmlspecialchars(substr($revel['texto'], 0, 50)) . '</a></p>';
                echo '<p class="revel-info">Publicado por <a href="/user/' . urlencode($revel['autor_usuario']) . '">' . htmlspecialchars($revel['autor_usuario']) . '</a> - Fecha: ' . htmlspecialchars($revel['fecha']) . '</p>';

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

                // Mostrar el número de likes y dislikes
                echo '<p class="like-info">Likes: ' . $revel['likes'] . '</p>';
                echo '<p class="dislike-info">Dislikes: ' . $revel['dislikes'] . '</p>';

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