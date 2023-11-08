<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discografía - Ivan Torres</title>
</head>

<body>
    <h1><a href="index.php">Discografía - Ivan Torres</a></h1>

    <?php
    include_once(__DIR__ . '/INC/connection.inc.php');

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
                        echo '<li><a href="group/' . $grupo['codigo'] . '">' . $grupo['nombre'] . '</a></li>';
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
        

</body>

</html>
