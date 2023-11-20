<?php
session_start();

// ... Otras configuraciones ...

include_once(__DIR__.'/includes/dbconnection.inc.php'); // Asegúrate de incluir el archivo con la conexión a la base de datos
include_once(__DIR__.'/includes/header.inc.php'); 

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar los campos
    if (empty($username) || empty($password)) {
        // Si algún campo está vacío, muestra un mensaje de error
        $_SESSION['error'] = 'Por favor, completa todos los campos.';
        // Puedes redirigir a la página de inicio de sesión nuevamente o manejarlo de acuerdo a tus necesidades
        header('Location: /login.php');
        exit();
    }

    // Consultar la base de datos para obtener el usuario
    $connection = getDBConnection(); // Función que devuelve la conexión a la base de datos

    $stmt = $connection->prepare("SELECT user, email, password FROM users WHERE user = :username OR email = :username");
    $stmt->bindValue(":username", $username);
    $stmt->execute();

    // Fetch como un array asociativo
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar las credenciales
    if ($user !== false && password_verify($password, $user['password'])) {
        // Contraseña válida, iniciar sesión
        $_SESSION['user'] = $user;
        header('Location: /index.php');
        exit();
    } else {
        // Credenciales incorrectas
        $_SESSION['error'] = 'Credenciales incorrectas.';
        // Puedes redirigir a la página de inicio de sesión nuevamente o manejarlo de acuerdo a tus necesidades
        header('Location: /login.php');
        exit();
    }

    $stmt = null;
    $connection = null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - MerchaShop</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php
   include_once(__DIR__.'/includes/header.inc.php'); // Asegúrate de incluir el archivo con la conexión a la base de datos
    ?>

    <section class="formulario">
        <h2>Iniciar Sesión</h2>
        <form action="/login.php" method="post">
            <label for="username">Usuario o Email:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Iniciar Sesión</button>
        </form>
    </section>
</body>
</html>
