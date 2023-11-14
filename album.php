<?php

/**
 * @author Ivan Torres Marcos
 * @version 1.3
 * @description Codigo principal para el insert de nuevos canciones
 *
 */


include_once(__DIR__ . '/INC/connection.inc.php');
$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = connection('discografia', 'vetustamorla', '15151', $utf8);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    //Obtenemos los values para los hidden venideros
    $stmt = $conexion->prepare('SELECT album, posicion FROM canciones WHERE codigo = :codigo');
    $stmt->execute([':codigo' => $codigo_cancion]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Asignamos los valores a las variables
    $codigo_album = $result['album'];
    $posicion = $result['posicion'];



    $errores=[];//A pesar de que en PHP no es necesario inicializar variables he estado probando y los count no funcionan sino inicializas el array

    if (isset($_POST['delete_cancion'])) {
        try {
            $codigo_cancion = $_POST['delete_cancion'];
            $stmt = $conexion->prepare('DELETE FROM canciones WHERE codigo = :codigo');
            $stmt->bindParam(':codigo', $codigo_cancion);
            $stmt->execute();
            $codigo_cancion = $_GET['codigo'];
            header('Location: /album/' . $_GET['codigo']);
            exit();
        } catch (Exception $e) {
            echo 'Error en la base de datos: ' . $e->getMessage();
        }
    }


    if ($conexion->errorCode() != PDO::ERR_NONE) {
        echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
        exit;
    }


    if (!isset($_POST['titulo']) || empty($_POST['titulo'])) {
        $errores['titulo'] = 'El titulo de la canción es obligatoria.';
    } else if (strlen($_POST['titulo']) > 50) {
        $errores['titulo'] = 'El titulo de la canción no puede tener más de 50 caracteres.';
    }



    if (!isset($_POST['duracion']) || empty($_POST['duracion'])) {
        $errores['duracion'] = 'El duracion de la canción es obligatoria.';
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

            $stmt = $conexion->prepare('INSERT INTO canciones (titulo, album, duracion, posicion) VALUES (:titulo, :album, :duracion, :posicion)');

            $stmt->bindParam(':titulo', $_POST['titulo']);
            $stmt->bindParam(':album', $_POST['codigo']);
            $stmt->bindParam(':duracion', $_POST['duracion']);
            $stmt->bindParam(':posicion', $_POST['posicion']);

            $stmt->execute();

            header('Location: /album/' . $_POST['codigo']);
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
    <h1><a href="/index">Discografía - Ivan Torres</a></h1>

    <?php
    if (isset($_GET['codigo'])) {

        try {

            if ($conexion) {

                $codigo_album = $_GET['codigo'];
                $stmt = $conexion->prepare('SELECT *
                    FROM albumes
                    JOIN grupos ON albumes.grupo = grupos.codigo
                    WHERE albumes.codigo = :codigo');
                $stmt->execute([':codigo' => $codigo_album]);
                $album = $stmt->fetch(PDO::FETCH_ASSOC);




                if ($album) {
                    echo '<h2>Detalles del Álbum:</h2>';
                    echo '<p>Nombre del Grupo: ' . $album['nombre'] . '</p>';
                    echo '<p>Título del Álbum: ' . $album['titulo'] . '</p>';

                    // Consulta para obtener las canciones del álbum
                    $stmt = $conexion->prepare('SELECT codigo,titulo, duracion FROM canciones WHERE album = :codigo');
                    $stmt->execute([':codigo' => $codigo_album]);
                    $canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);


                    if ($canciones) {
                        echo '<h2>Listado de Canciones:</h2>';
                        echo '<table>';
                        echo '<tr><th>Canción</th><th>Duración</th></tr>';

                        foreach ($canciones as $cancion) {
                            $duracion = $cancion['duracion'];
                            $cancionMins = floor($duracion / 60);  // Obtenemos los minutos enteros
                            $cancionSegs = $duracion % 60;  // Obtenemos los segundos restantes

                            echo '<tr><td>' . $cancion['titulo'] . '</td><td>' . $cancionMins . ' minutos y ' . $cancionSegs . ' segundos <a href=""><form action="" method="post" style="display:inline;">
                            <input type="hidden" name="delete_cancion" value="' . $cancion['codigo'] . '">
                            <button type="submit" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta canción?\')">
                                <i class="bx bxs-trash"></i>
                            </button>
                        </form></td></tr>';
                        }

                        echo '</table>';
                    } else {
                        echo 'No se encontraron canciones para este álbum.';
                    }
                } else {
                    echo 'No se encontró el álbum en la base de datos.';
                }
            } else {
                echo 'La conexión a la base de datos no se estableció correctamente.';
            }
        } catch (Exception $e) {
            echo 'Error en la base de datos: ' . $e->getMessage();
        }
    } else {
        echo 'Código de álbum no válido.';
    }
    ?>
    </div>

    <form class="formulario" method="post">
        <input type="hidden" name="codigo" value="<?php echo $codigo_album ?>">
        <input type="hidden" name="posicion" value="<?php echo $posicion; ?>">

        <label for="titulo">Título de la canción:</label>
        <input type="text" name="titulo" id="titulo" required>

        <label for="duracion">Duración (en segundos):</label>
        <input type="number" name="duracion" id="duracion" required>

        <input type="submit" value="Crear canción">
    </form>
    <br>
    <a href="/group/<?= $album['codigo'] ?>">Volver a la lista de álbumes</a>



</body>

</html>