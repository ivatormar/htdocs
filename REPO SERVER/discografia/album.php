<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discografía - TuNombre</title>
</head>
<body>
    <h1><a href="index.php">Discografía - Ivan Torres</a></h1>

    <?php
    if (isset($_GET['codigo'])) {
        include_once(__DIR__ . '/INC/connection.inc.php');

        try {
            $utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
            $conexion = connection('discografia', 'vetustamorla', '15151', $utf8);

            if ($conexion) {
                $codigo_album = $_GET['codigo'];
                $stmt = $conexion->prepare('SELECT albumes.titulo, grupos.nombre, canciones.titulo AS nombre_cancion
                    FROM albumes
                    JOIN grupos ON albumes.codigo = grupos.codigo
                    LEFT JOIN canciones ON albumes.codigo = canciones.codigo
                    WHERE albumes.codigo = :codigo');
                $stmt->bindParam(':codigo', $codigo_album, PDO::PARAM_STR);
                $stmt->execute();
                $album = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($album) {
                    echo '<h2>Detalles del Álbum:</h2>';
                    echo '<p>Nombre del Grupo: ' . $album['nombre'] . '</p>';
                    echo '<p>Título del Álbum: ' . $album['titulo'] . '</p>';

                    // Consulta para obtener las canciones del álbum
                    $stmt = $conexion->prepare('SELECT titulo AS nombre_cancion FROM canciones WHERE codigo = :codigo');
                    $stmt->bindParam(':codigo', $codigo_album, PDO::PARAM_STR);
                    $stmt->execute();
                    $canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($canciones) {
                        echo '<h2>Listado de Canciones:</h2>';
                        echo '<table>';
                        echo '<tr><th>Canción</th></tr>';

                        foreach ($canciones as $cancion) {
                            echo '<tr><td>' . $cancion['nombre_cancion'] . '</td></tr>';
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

    <br>
    <a href="index.php">Volver a la lista de grupos</a>

</body>
</html>
