<?php
session_start();

include_once(__DIR__ . '/includes/dbconnection.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $email = $_POST['email'];

    // Validar el campo
    if (empty($email)) {
        $_SESSION['error'] = 'Por favor, ingresa tu dirección de correo electrónico.';
        header('Location: /passwordRecovery.php');
        exit();
    }

    // Verificar si el correo electrónico existe en la base de datos
    $connection = getDBConnection();
    $stmt = $connection->prepare("SELECT email FROM users WHERE email = :email");
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generar o recuperar un token único
        $token = bin2hex(random_bytes(32));

        // Verificar si ya existe un registro para el correo electrónico
        $stmt = $connection->prepare("SELECT email FROM passwordrecovery WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $existingToken = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingToken) {
            // Si existe, actualizamos el token existente
            $stmt = $connection->prepare("UPDATE passwordrecovery SET token = :token WHERE email = :email");
            $stmt->bindValue(":token", $token);
            $stmt->bindValue(":email", $email);
            $stmt->execute();
        } else {
            // Si no existe, insertamos un nuevo registro
            $stmt = $connection->prepare("INSERT INTO passwordrecovery (email, token) VALUES (:email, :token)");
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":token", $token);
            $stmt->execute();
        }

        // Redirigir a una página de éxito
        $_SESSION['success'] = 'Hemos enviado instrucciones para restablecer tu contraseña a tu correo electrónico.';
        header('Location: /resetPassword.php?token=' . $token . '&email=' . $email); // Pasar token y email en la URL
        exit();
    } else {
        // Si el correo electrónico no está registrado, mostrar un mensaje de error
        $_SESSION['error'] = 'No se encontró ninguna cuenta asociada a ese correo electrónico.';
        header('Location: /passwordRecovery.php');
        exit();
    }
}
?>

<!-- Resto del HTML para el formulario de recuperación de contraseña -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - MerchaShop</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php
    include_once(__DIR__ . '/includes/header.inc.php');
    ?>

    <section class="formulario">
        <h2>Recuperar Contraseña</h2>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<p class="error-message">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<p class="success-message">' . $_SESSION['success'] . '</p>';
            unset($_SESSION['success']);
        }
        ?>
        <form action="/passwordRecovery.php" method="post">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Enviar Instrucciones</button>
        </form>
        <a href="/login.php">Volver al Inicio de Sesión</a>
    </section>
</body>

</html>
