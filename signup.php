<?php
session_start();

include_once(__DIR__ . '/includes/dbconnection.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Validacion de campos
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['error'] = 'Por favor, completa todos los campos.';
        header('Location: /signup.php');
        exit();
    }

    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $connection = getDBConnection(); 
    $token = uniqid();  

    $stmt = $connection->prepare("INSERT INTO users (user, email, password, token) VALUES (?, ?, ?, ?)");

    if ($stmt->execute([$_POST['username'], $_POST['email'], $hashedPassword, $token])) {
        header('Location: /login.php');
        exit();
    } else {
        $_SESSION['error'] = 'Error al registrar el usuario.';
        print_r($stmt->errorInfo());
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
    <title>Registro - MerchaShop</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php
    include_once(__DIR__ . '/includes/header.inc.php');

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