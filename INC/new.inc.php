<?php
// Verificar si se han enviado datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar los datos del formulario
    $texto = $_POST['texto'];  // Obtener el texto de la revelación, asegúrate de validar y limpiar los datos
    $userid = $_SESSION['user_id'];  // Obtener el ID del usuario actual, asumiendo que ya ha iniciado sesión

    // Validar y procesar los datos antes de almacenarlos en la base de datos
    // ...

    // Realizar la conexión a la base de datos
    $utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    $conexion = connection('revels', 'revel', 'lever', $utf8);

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
        header("Location: /INC/revel.php?id=$revelId");
        exit;
    } else {
        echo 'Error al guardar la revelación en la base de datos.';
        exit;
    }
}

// Si no se han enviado datos, mostrar el formulario
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/new.css">
    <link rel="shortcut icon" href="/MEDIA-REVELS-LOGO/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Nueva Revel.</title>
</head>

<body cz-shortcut-listen="true" class="body">
    <!-- FORMULARIO PARA NUEVA REVEL -->
    <div class="new-revel-form">
        <form method="post" action="">
            <div class="mb-3">
                <label for="texto" class="form-label">Texto de la Revel:</label>
                <textarea class="form-control" id="texto" name="texto" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Publicar Revel</button>
        </form>
    </div>

</body>

</html>
