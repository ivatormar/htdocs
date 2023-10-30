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
                $codigo = $_GET['codigo'];
                $stmt = $conexion->prepare('SELECT * FROM grupos WHERE codigo = :codigo');
                $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
                $stmt->execute();
                $grupo = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($grupo) {
                    echo '<h2>Detalles del Grupo:</h2>';
                    echo '<p>Nombre del Grupo: ' . $grupo['nombre'] . '</p>';
                    echo '<p>Género: ' . $grupo['genero'] . '</p>';
                    echo '<p>País: ' . $grupo['pais'] . '</p>';
                    echo '<p>Inicio: ' . $grupo['inicio'] . '</p>';

                    // Consulta para obtener los álbumes del grupo
                    $stmt = $conexion->prepare('SELECT * FROM albumes WHERE codigo = :codigo');
                    $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
                    $stmt->execute();
                    $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($albums) {
                        echo '<h2>Álbumes del Grupo:</h2>';
                        echo '<table>';
                        echo '<tr><th>Título</th><th>Año</th><th>Formato</th><th>Fecha de Compra</th><th>Precio</th></tr>';

                        foreach ($albums as $album) {
                            echo '<tr>';
                            echo '<td><a href="album.php?codigo=' . $album['codigo'] . '">' . $album['titulo'] . '</a></td>';
                            echo '<td>' . $album['anyo'] . '</td>';
                            echo '<td>' . $album['formato'] . '</td>';
                            echo '<td>' . $album['fechacompra'] . '</td>';
                            echo '<td>' . $album['precio'] . '</td>';
                            echo '</tr>';
                        }

                        echo '</table>';
                    } else {
                        echo 'No se encontraron álbumes para este grupo.';
                    }
                } else {
                    echo 'No se encontró el grupo en la base de datos.';
                }
            } else {
                echo 'La conexión a la base de datos no se estableció correctamente.';
            }
        } catch (Exception $e) {
            echo 'Error en la base de datos: ' . $e->getMessage();
        }
    } else {
        echo 'Código de grupo no válido.';
    }
    ?>

    <br>
    <a href="index.php">Volver a la lista de grupos</a>

</body>
</html>
