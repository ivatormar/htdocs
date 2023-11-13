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
    <h1><a href="/index.php">Discografía - Ivan Torres</a></h1>

    <?php
    if (isset($_GET['codigo'])) {
        include_once(__DIR__ . '/INC/connection.inc.php');

        try {
            $utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
            $conexion = connection('discografia', 'vetustamorla', '15151', $utf8);

            if ($conexion) {

                $codigo_album = $_GET['codigo'];
                $stmt = $conexion->prepare('SELECT *
                    FROM albumes
                    JOIN grupos ON albumes.grupo = grupos.codigo
                    WHERE albumes.codigo = :codigo');
                $stmt->bindParam(':codigo', $codigo_album);
                $stmt->execute();
                $album = $stmt->fetch(PDO::FETCH_ASSOC);




                if ($album) {
                    echo '<h2>Detalles del Álbum:</h2>';
                    echo '<p>Nombre del Grupo: ' . $album['nombre'] . '</p>';
                    echo '<p>Título del Álbum: ' . $album['titulo'] . '</p>';

                    // Consulta para obtener las canciones del álbum
                    $stmt = $conexion->prepare('SELECT titulo, duracion FROM canciones WHERE album = :codigo');
                    $stmt->bindParam(':codigo', $codigo_album);
                    $stmt->execute();
                    $canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);



                    if ($canciones) {
                        echo '<h2>Listado de Canciones:</h2>';
                        echo '<table>';
                        echo '<tr><th>Canción</th><th>Duración</th></tr>';

                        foreach ($canciones as $cancion) {
                            $duracion = $cancion['duracion'];
                            $cancionMins = floor($duracion / 60);  // Obtenemos los minutos enteros
                            $cancionSegs = $duracion % 60;  // Obtenemos los segundos restantes

                            echo '<tr><td>' . $cancion['titulo'] . '</td><td>' . $cancionMins . ' minutos y ' . $cancionSegs . ' segundos <a href=""><i class="bx bxs-trash"></i></a></td></tr>';
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
    <form action="album.php" method="post">
        <label for="titulo">Título de la canción:</label>
        <input type="text" name="titulo" id="titulo" required>

        <label for="duracion">Duración (en minutos):</label>
        <input type="number" name="duracion" id="duracion" required>

        <input type="submit" value="Crear canción">
    </form>
    <br>
    <a href="/group/<?= $album['codigo'] ?>">Volver a la lista de álbumes</a>



</body>

</html>