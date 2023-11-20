<?php
session_start();

include_once(__DIR__.'/includes/dbconnection.inc.php');

// Obtener la lista de usuarios
$connection = getDBConnection();
$users = $connection->query('SELECT user, email, rol FROM users;', PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - MerchaShop</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php
    include_once(__DIR__.'/includes/header.inc.php');
    ?>

    <section class="usuarios">
        <h2>Usuarios</h2>
        <ul>
            <?php
            foreach ($users as $user) {
                echo '<li>';
                echo '<strong>Usuario:</strong> ' . $user->user . '<br>';
                echo '<strong>Email:</strong> ' . $user->email . '<br>';
                echo '<strong>Rol:</strong> ' . $user->rol . '<br>';
                echo '</li>';
            }
            ?>
        </ul>
    </section>
</body>
</html>

<?php
// Cerrar la conexión y liberar recursos
unset($users);
unset($connection);
?>