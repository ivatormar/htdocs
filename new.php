<?php
session_start();
include_once(__DIR__.'/INC/connection.inc.php');
$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = connection('revels', 'revel', 'lever', $utf8);

// Verificar si se han enviado datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['texto'])) {
    // Procesar los datos del formulario
    $texto = $_POST['texto'];
    $userid = $_SESSION['user_id'];

    // Realizar la conexión a la base de datos

    // Verificar si hay errores de conexión
    if ($conexion->errorCode() != PDO::ERR_NONE) {
        echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
        exit;
    }

    // Insertar la nueva revelación en la base de datos
    $stmt = $conexion->prepare('INSERT INTO revels (userid, texto) VALUES (:userid, :texto)');
    $stmt->bindParam(':userid', $userid);
    $stmt->bindParam(':texto', $texto);

    if ($stmt->execute()) {
        // Obtener el ID de la nueva revelación
        $revelId = $conexion->lastInsertId();

        // Redirigir a la página de la nueva revelación
        header("Location:/revel.php?id=$revelId");
        exit;
    } else {
        echo 'Error al guardar la revelación en la base de datos.';
        exit;
    }
}

// Si no se han enviado datos o si 'texto' no está definido en $_POST, mostrar el formulario
?>
<!DOCTYPE html>
<html lang="es">


<?php include_once(__DIR__.'/INC/headNavbarTablon.inc.php')?>

<body cz-shortcut-listen="true" class="body">
    <div class="content">
    <?php include_once(__DIR__ . '/INC/sidebar.inc.php') ?>
    <div class="revels-container">
    <!-- FORMULARIO PARA NUEVA REVEL -->
    <div class="new-revel-form">
        <form method="post" action="">
            <div class="mb-3">
                <label for="texto" class="form-label">Texto de la Revel:</label>
                <textarea class="form-control" id="texto" name="texto" rows="3" required></textarea>
            </div>
            <button id="publishRevel"type="submit" class="btn button-34">Publicar Revel</button>
        </form>
    </div>
    </div>
    <div class="volver">
    <a href="/index.php">Volver al Tablón</a>
    </div>
    </div>
</body>

</html>
