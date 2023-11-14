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


    // Procesar el formulario de eliminación
    if (isset($_POST['delete_album'])) {
        try {
            $codigo_album = $_POST['delete_album'];
            $stmt = $conexion->prepare('DELETE FROM albumes WHERE codigo = :codigo');
            $stmt->bindParam(':codigo', $codigo_album);
            $stmt->execute();
            $codigo_grupo = $_GET['codigo'];
            header('Location: /group/' . $codigo_grupo);
            exit();
        } catch (Exception $e) {
            echo 'Error en la base de datos: ' . $e->getMessage();
        }
    }





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

            $stmt = $conexion->prepare('INSERT INTO albumes (titulo,grupo, anyo, formato, fechacompra, precio) VALUES (:titulo,:grupo, :anyo, :formato, :fechacompra, :precio)');

            // Asignar los valores a los parámetros
            $stmt->bindParam(':titulo', $_POST['titulo']);
            $stmt->bindParam(':grupo', $_POST['codigo']);
            $stmt->bindParam(':anyo', $_POST['anyo']);
            $stmt->bindParam(':formato', $_POST['formato']);
            $stmt->bindParam(':fechacompra', $_POST['fechacompra']);
            $stmt->bindParam(':precio', $_POST['precio']);
            echo 'Query: ' . $stmt->queryString . '<br>';

            $stmt->execute();

            echo 'Inserción exitosa.';
            var_dump($_POST);

            header('Location: /group/' . $_POST['codigo']);
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
    <?php echo $_GET['codigo']; ?>


    <title>Discografía - TuNombre</title>
</head>

<body>
    <div class="info">
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
                $codigo_value=$grupo['codigo'];

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
                            echo '<td>' . $album['precio'] . ' € <form action="" method="post" style="display:inline;">
                            <input type="hidden" name="delete_album" value="' . $album['codigo'] . '">
                            <button type="submit" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este álbum?\')">
                                <i class="bx bxs-trash"></i>
                            </button>
                        </form></td> ';
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
    </div>
    <form  class=formulario action="" method="post">

        <input type="hidden" name="codigo" value="<?php echo $codigo_value; ?>">

        <label for="titulo">Título del álbum:</label>
        <input type="text" name="titulo" id="titulo" required>

        <label for="anyo">Año albúm:</label>
        <select name="anyo" id="anyo">
            <?php

            for ($i = 1990; $i <= date('Y'); $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            }
            ?>
        </select>

        <label for="formato">Formato:</label>
        <select name="formato" id="formato" required>
            <option value="vinilo">Vinilo</option>
            <option value="cd">CD</option>
            <option value="dvd">DVD</option>
            <option value="mp3">MP3</option>
        </select>

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