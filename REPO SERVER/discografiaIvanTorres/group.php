<?php
include_once(__DIR__ . '/INC/connection.inc.php');
$errores = array(); // Inicializa el array de errores

print_r($_POST);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar el nombre del album
    if (!isset($_POST['titulo']) || empty($_POST['titulo'])) {
        $errores['titulo'] = 'El titulo del grupo es obligatorio.';
    } else if (strlen($_POST['titulo']) > 50) {
        $errores['titulo'] = 'El titulo del grupo no puede tener más de 50 caracteres.';
    }

    // Validar el año del album
    if (!isset($_POST['anyo']) || empty($_POST['anyo'])) {
        $errores['anyo'] = 'El año del album es obligatorio.';
    } 

    // Validar el format del album
    if (!isset($_POST['formato']) || empty($_POST['formato'])) {
        $errores['formato'] = 'El formato del album es obligatorio.';
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
            $utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
            $conexion = connection('discografia', 'vetustamorla', '15151', $utf8);
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

            echo 'Inserción exitosa.';
            header('Location: index.php?success=1');
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


    <title>Discografía - TuNombre</title>
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
                $codigo = $_GET['codigo'];
                $stmt = $conexion->prepare('SELECT * FROM grupos WHERE codigo = :codigo');
                $stmt->bindParam(':codigo', $codigo);
                $stmt->execute();
                $grupo = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($grupo) {
                    echo '<h2>Detalles del Grupo:</h2>';
                    echo '<p>Nombre del Grupo: ' . $grupo['nombre'] . '</p>';
                    echo '<p>Género: ' . $grupo['genero'] . '</p>';
                    echo '<p>País: ' . $grupo['pais'] . '</p>';
                    echo '<p>Inicio: ' . $grupo['inicio'] . '</p>';

                    // Consulta para obtener los álbumes del grupo
                    $stmt = $conexion->prepare('SELECT * FROM albumes WHERE grupo = :codigo');
                    $stmt->bindParam(':codigo', $codigo);
                    $stmt->execute();
                    $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);


                    if ($albums) {
                        echo '<h2>Álbumes del Grupo:</h2>';
                        echo '<table>';
                        echo '<tr><th>Título</th><th>Año</th><th>Formato</th><th>Fecha de Compra</th><th>Precio</th></tr>';

                        foreach ($albums as $album) {
                        
                            echo '<tr>';
                            echo '<td><a href="/album/' . $album['codigo'] . '">' . $album['titulo'] . '</a></td>';
                            echo '<td>' . $album['anyo'] . '</td>';
                            echo '<td>' . $album['formato'] . '</td>';
                            echo '<td>' . $album['fechacompra'] . '</td>';
                            echo '<td>' . $album['precio'] . ' € <a href=""><i class="bx bxs-trash"></i></a></td> ';
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
<form action="group.php" method="post">
    <label for="titulo">Título del álbum:</label>
    <input type="text" name="titulo" id="titulo" required>

    <label for="anyo">Año:</label>
    <input type="number" name="anyo" id="anyo" required>

    <label for="formato">Formato:</label>
    <input type="text" name="formato" id="formato" required>

    <label for="fechacompra">Fecha de compra:</label>
    <input type="date" name="fechacompra" id="fechacompra" required>

    <label for="precio">Precio:</label>
    <input type="number" name="precio" id="precio" required>

    <input type="submit" value="Crear álbum">
</form>

    <br>
    <a href="/index.php">Volver a la lista de grupos</a>


</body>

</html>