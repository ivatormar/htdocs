<?php
session_start();

// ... Otras configuraciones ...

include_once(__DIR__.'/includes/dbconnection.inc.php');

// Verificar si el usuario no está logueado y está intentando acceder a páginas restringidas
if (!isset($_SESSION['user']) && ($_SERVER['REQUEST_URI'] !== '/index.php' && $_SERVER['REQUEST_URI'] !== '/sales.php')) {
    header('Location: /login.php'); // Redirigir a la página de inicio de sesión
    exit();
}

// Verificar los roles de usuario permitidos para acceder a determinadas páginas
if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'customer' && $_SERVER['REQUEST_URI'] === '/users.php') {
    header('Location: /index.php'); // Redirigir al usuario a la página principal si intenta acceder a users.php
    exit();
}

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
    include('header.inc.php');
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
