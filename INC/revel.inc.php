<?php
session_start();
include_once(__DIR__.'/connection.inc.php');
// Realizar la conexión a la base de datos
$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = connection('revels', 'revel', 'lever', $utf8);

// Verificar si hay errores de conexión
if ($conexion->errorCode() != PDO::ERR_NONE) {
    echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
    exit;
}

// Verificar si se ha proporcionado un ID de revelación válido en la URL
if (isset($_GET['id'])) {
    $revelId = $_GET['id'];

    // Obtener los detalles de la revelación
    $stmt = $conexion->prepare('SELECT r.*, u.usuario AS autor_usuario
                                FROM revels r
                                INNER JOIN users u ON r.userid = u.id
                                WHERE r.id = :revelId');
    $stmt->bindParam(':revelId', $revelId);
    $stmt->execute();
    $revel = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si la revelación existe
    if ($revel) {
        // Obtener los comentarios de la revelación
        $stmt = $conexion->prepare('SELECT c.*, u.usuario AS autor_usuario
                                    FROM comments c
                                    INNER JOIN users u ON c.userid = u.id
                                    WHERE c.revelid = :revelId
                                    ORDER BY c.fecha ASC');
        $stmt->bindParam(':revelId', $revelId);
        $stmt->execute();
        $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Procesar el formulario de comentario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $textoComentario = $_POST['textoComentario'];  // Obtener el texto del comentario, asegúrate de validar y limpiar los datos
            $userid = $_SESSION['user_id'];  // Obtener el ID del usuario actual, asumiendo que ya ha iniciado sesión

            // Validar y procesar los datos antes de almacenarlos en la base de datos
            // ...

            // Insertar el nuevo comentario en la base de datos
            $stmt = $conexion->prepare('INSERT INTO comments (revelid, userid, texto) VALUES (:revelId, :userid, :textoComentario)');
            $stmt->bindParam(':revelId', $revelId);
            $stmt->bindParam(':userid', $userid);
            $stmt->bindParam(':textoComentario', $textoComentario);

            if ($stmt->execute()) {
                // Redirigir para evitar el reenvío del formulario al actualizar la página
                header("Location: /INC/revel.inc.php?id=$revelId");
                exit;
            } else {
                echo 'Error al guardar el comentario en la base de datos.';
                exit;
            }
        }

        // Mostrar la revelación y los comentarios
        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="/CSS/revel.css">
            <link rel="shortcut icon" href="/MEDIA-REVELS-LOGO/favicon.ico" type="image/x-icon">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            <title>Revelación.</title>
        </head>

        <body cz-shortcut-listen="true" class="body">
            <!-- Mostrar la revelación -->
            <div class="revel-container">
                <div class="revel-box">
                    <p class="revel-text"><?php echo htmlspecialchars($revel['texto']); ?></p>
                    <p class="revel-info">Publicado por <a href="/INC/user.inc.php?id=<?php echo $revel['userid']; ?>"><?php echo htmlspecialchars($revel['autor_usuario']); ?></a> - Fecha: <?php echo htmlspecialchars($revel['fecha']); ?></p>
                </div>
            </div>

            <!-- Mostrar los comentarios -->
            <div class="comentarios-container">
                <h3>Comentarios:</h3>
                <?php
                foreach ($comentarios as $comentario) {
                    echo '<div class="comentario">';
                    echo '<p class="comentario-text">' . htmlspecialchars($comentario['texto']) . '</p>';
                    echo '<p class="comentario-info">Comentado por <a href="/INC/user.inc.php?id=' . $comentario['userid'] . '">' . htmlspecialchars($comentario['autor_usuario']) . '</a> - Fecha: ' . htmlspecialchars($comentario['fecha']) . '</p>';
                    echo '</div>';
                }
                ?>
            </div>

            <!-- Formulario para agregar comentario -->
            <div class="nuevo-comentario-form">
                <h3>Agregar Comentario:</h3>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="textoComentario" class="form-label">Texto del Comentario:</label>
                        <textarea class="form-control" id="textoComentario" name="textoComentario" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Comentario</button>
                </form>
            </div>
            <a href="/index.php">Volver al Tablón</a>
        </body>

        </html>
        <?php
    } else {
        echo 'La revelación no existe.';
        exit;
    }
} else {
    echo 'ID de revelación no proporcionado.';
    exit;
}
?>
