<?php
session_start();

// ... Otras configuraciones ...
include_once(__DIR__.'/includes/dbconnection.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validar los campos
    if (empty($username) || empty($email) || empty($password)) {
        // Si algún campo está vacío, muestra un mensaje de error
        $_SESSION['error'] = 'Por favor, completa todos los campos.';
        // Puedes redirigir a la página de registro nuevamente o manejarlo de acuerdo a tus necesidades
        header('Location: /signup.php');
        exit();
    }

    // Hash de la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la base de datos
    $connection = getDBConnection(); // Función que devuelve la conexión a la base de datos
    $stmt = $connection->prepare("INSERT INTO users (user, email, password) VALUES (?, ?, ?)");

    // Verificar si la ejecución fue exitosa
    if ($stmt->execute([$username, $email, $hashedPassword])) {
        // Registro exitoso
        $_SESSION['message'] = 'Registro exitoso. Inicia sesión para continuar.';
        header('Location: /login.php');
        exit();
    } else {
        // Error en el registro
        $_SESSION['error'] = 'Error al registrar el usuario.';
    }

    // Cerrar la conexión y liberar recursos
    $stmt = null;
    $connection = null;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - MerchaShop</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php
    include_once(__DIR__.'/includes/header.inc.php'); 

    ?>

    <section class="formulario">
        <h2>Registro</h2>
        <form action="" method="post">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Registrarse</button>
        </form>
    </section>
</body>

</html>
