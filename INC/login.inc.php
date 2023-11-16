<?php
session_start();
include_once(__DIR__ . '/connection.inc.php');
$login = false;
$errors = array("user" => "", "password" => "");

$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = connection('revels', 'revel', 'lever', $utf8);


if ($conexion->errorCode() != PDO::ERR_NONE) {
    echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
    exit;
}


function validarUsuarioYContraseña($user, $password, $conexion) {
    try {
        $stmt = $conexion->prepare('SELECT * FROM users WHERE usuario = :usuario');
        $stmt->bindParam(':usuario', $user);
        $stmt->execute();
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_data && password_verify($password, $user_data['contrasenya'])) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Manejar el error de la base de datos, si es necesario
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $password = $_POST['password'];

    // Validación del campo "User"
    if (empty($user)) {
        $errors["user"] = "El campo de usuario es obligatorio.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $user)) {
        $errors["user"] = "El usuario solo puede contener letras, números y guiones bajos (_).";
    }

    // Validación del campo "Password"
    if (empty($password)) {
        $errors["password"] = "El campo de contraseña es obligatorio.";
    } elseif (strlen($password) < 6) {
        $errors["password"] = "La contraseña debe tener al menos 6 caracteres.";
    }

    if (empty($errors["user"]) && empty($errors["password"])) {
        if (validarUsuarioYContraseña($user, $password, $conexion)) {
            // Vuelve a obtener los datos del usuario después de validar el inicio de sesión
            $stmt = $conexion->prepare('SELECT * FROM users WHERE usuario = :usuario');
            $stmt->bindParam(':usuario', $user);
            $stmt->execute();
            $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
        
            $_SESSION['user_id'] = $user_data['id']; // Guarda el ID del usuario en la sesión
            $login = true;
            // Redirige al usuario a la página que desees
            header('Location: /index.php');
            exit; // Asegura que el script se detenga después de la redirección
        } else {
            $errors["password"] = "Usuario o contraseña incorrectos.";
        }
}
}
?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Revels.</title>
</head>

<body cz-shortcut-listen="true">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="/index.php">
                <img src="/MEDIA-REVELS-LOGO/logo-navbar.png" alt="logoNav">
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="button-container">
                <button type="button" id="btnLogin" class="btn btn-rounded" data-mdb-ripple-color="#ffffff" style="background-color:#fc92ad"><a class="login-a" href="/index.php">REGISTER</a></button>
            </div>
        </div>
    </nav>

    <!-- LOGIN FORM -->
    <div class="login-page">
        <div class="form">
            <h2>¡Revel yourself!</h2>
            <form class="login-form" method="POST">
                <input type="text" name="user" placeholder="User" required />
                <p class="error-message"><?php echo $errors["user"]; ?></p>
                <input type="password" name="password" placeholder="Password" required />
                <p class="error-message"><?php echo $errors["password"]; ?></p>
                <input type="submit" value="Login" class="loginBtn">
                <p class="message">Don't have an account?<a href="/index.php"> Create one </a></p>
            </form>
        </div>
    </div>

</body>

</html>
