<?php
include_once(__DIR__ . '/INC/connection.inc.php');
$errores = array(); // Inicializa el array de errores
$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = connection('discografia', 'vetustamorla', '15151', $utf8);

if ($conexion->errorCode() != PDO::ERR_NONE) {
    echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['delete_grupo'])) {
        try {
            $codigo_grupo = $_POST['delete_grupo'];
            $stmt = $conexion->prepare('DELETE FROM grupos WHERE codigo = :codigo');
            $stmt->bindParam(':codigo', $codigo_grupo);
            $stmt->execute();
            $codigo_grupo = $_GET['codigo'];
            header('Location: /index');
            exit();
        } catch (Exception $e) {
            echo 'Error en la base de datos: ' . $e->getMessage();
        }
    }






    // Validar el nombre del grupo
    if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
        $errores['nombre'] = 'El nombre del grupo es obligatorio.';
    } else if (strlen($_POST['nombre']) > 50) {
        $errores['nombre'] = 'El nombre del grupo no puede tener más de 50 caracteres.';
    }

    // Validar el género del grupo
    if (!isset($_POST['genero']) || empty($_POST['genero'])) {
        $errores['genero'] = 'El género del grupo es obligatorio.';
    } else if (strlen($_POST['genero']) > 50) {
        $errores['genero'] = 'El género del grupo no puede tener más de 50 caracteres.';
    }

    // Validar el país del grupo
    if (!isset($_POST['pais']) || empty($_POST['pais'])) {
        $errores['pais'] = 'El país del grupo es obligatorio.';
    } else if (strlen($_POST['pais']) > 20) {
        $errores['pais'] = 'El país del grupo no puede tener más de 20 caracteres.';
    }

    if (!isset($_POST['inicio']) || empty($_POST['inicio'])) {
        $errores['inicio'] = 'El año de inicio del grupo es obligatorio.';
    }

    if (count($errores) > 0) {
        foreach ($errores as $error) {
            echo '<div class="alert alert-danger">' . $error . '</div>';
        }
    }

    if (count($errores) === 0) {
        try {
            // Comprobamos que la conexión se ha establecido correctamente
            if ($conexion->errorCode() != PDO::ERR_NONE) {
                throw new Exception('Error al conectar a la base de datos: ' . $conexion->errorInfo()[2]);
            }

            $stmt = $conexion->prepare('INSERT INTO grupos (nombre, genero, pais, inicio) VALUES (:nombre, :genero, :pais, :inicio)');

            $stmt->bindParam(':nombre', $_POST['nombre']);
            $stmt->bindParam(':genero', $_POST['genero']);
            $stmt->bindParam(':pais', $_POST['pais']);
            $stmt->bindParam(':inicio', $_POST['inicio']);

            $stmt->execute();

            header('Location: /index');
        } catch (Exception $e) {
            echo 'Error en la base de datos: ' . $e->getMessage();
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/STYLE/style.css">

    <title>Discografía - Ivan Torres</title>
</head>

<body>
    <div class="info">
    <h1><a href="index.php">Discografía - Ivan Torres</a></h1>

    <?php
    try {
        $utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $conexion = connection('discografia', 'vetustamorla', '15151', $utf8);

        if ($conexion) {
            $result = $conexion->query('SELECT * FROM grupos');

            if ($result) {
                $grupos = $result->fetchAll(PDO::FETCH_ASSOC);

                if ($grupos) {
                    echo '<h2>Lista de Grupos:</h2>';
                    echo '<ol>';

                    foreach ($grupos as $grupo) {
                        echo '<li><a href="group/' . $grupo['codigo'] . '">' . $grupo['nombre'] . '</a>  <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="delete_grupo" value="' . $grupo['codigo'] . '">
                        <button type="submit" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este grupo?\')">
                            <i class="bx bxs-trash"></i>
                        </button>
                    </form></li>';
                    }

                    echo '</ol>';
                } else {
                    echo 'No hay grupos disponibles actualmente.';
                }
            } else {
                echo 'No se pudo ejecutar la consulta SQL.';
            }
        } else {
            echo 'La conexión a la base de datos no se estableció correctamente.';
        }
    } catch (Exception $e) {
        echo 'Error en la base de datos: ' . $e->getMessage();
    }
    ?>
    </div>
    <form class=formulario action="index.php" method="post">
        <label for="nombre">Nombre del grupo:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="genero">Género:</label>
        <input type="text" name="genero" id="genero" required>

        <label for="pais">País:</label>
        <input type="text" name="pais" id="pais" required>

        <label for="inicio">Año de inicio:</label>
        <select name="inicio" id="inicio">
            <?php

            for ($i = 1990; $i <= date('Y'); $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            }
            ?>
        </select>

        <input type="submit" value="Crear grupo">
    </form>


</body>

</html>