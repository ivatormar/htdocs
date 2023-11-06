<?php
$login = false;
$errors = array("user" => "", "email" => "", "password" => "");
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se ha enviado el formulario
    $user = $_POST["user"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validación del campo "User"
    if (empty($user)) {
        $errors["user"] = "El campo de usuario es obligatorio.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $user)) {
        $errors["user"] = "El usuario solo puede contener letras, números y guiones bajos (_).";
    }

    // Validación del campo "Email"
    if (empty($email)) {
        $errors["email"] = "El campo de correo electrónico es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "El correo electrónico no es válido.";
    }

    // Validación del campo "Password"
    if (empty($password)) {
        $errors["password"] = "El campo de contraseña es obligatorio.";
    } elseif (strlen($password) < 6) {
        $errors["password"] = "La contraseña debe tener al menos 6 caracteres.";
    }

    if (empty($errors["user"]) && empty($errors["email"]) && empty($errors["password"])) {
        $success_message = "¡Registro exitoso!";
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
    <title>INDEXXX</title>
</head>

<body cz-shortcut-listen="true">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/MEDIA-REVELS-LOGO/logo-meouwth.png" alt="logoNav">
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="me-3">
                    <div class="form-white input-group" style="width: 250px;">
                        <input type="search" class="form-control rounded" placeholder="Search..." aria-label="Search" aria-describedby="search-addon">
                    </div>
                </form>
            </div>
            <?php 
            if ($login === true) {
                echo '
                <div class="login">
                    <button type="button" class="btn btn-danger" data-mdb-ripple-color="#ffffff"> Mi perfil </button>
                    <button type="button" class="btn btn-danger" data-mdb-ripple-color="#ffffff"> Nuevo Revel </button>
                    <button type="button" class="btn btn-danger" data-mdb-ripple-color="#ffffff"> Salir </button>
                </div>';
            }
            ?>
            <div class="button-container">
                <button type="button" id="btnLogin" class="btn btn-rounded" data-mdb-ripple-color="#ffffff" style="background-color:#fc92ad"><a class="login-a" href="/INC/login.inc.php">LOGIN</a></button>
            </div>
        </div>
    </nav>

    <!-- REGISTER FORM -->
    <div class="login-page">
        <div class="form">
            <h2>¡Welcome to Revels, SIGN UP!</h2>
            <form class="login-form" method="POST">
                <input type="text" name="user" placeholder="User" required />
                <p class="error-message"><?php echo $errors["user"]; ?></p>
                <input type="text" name="email" placeholder="Email" required />
                <p class="error-message"><?php echo $errors["email"]; ?></p>
                <input type="password" name="password" placeholder="Password" required />
                <p class="error-message"><?php echo $errors["password"]; ?></p>
                <input type="submit" value="Sign up" class="registerBtn">
                <p class="message">Do you have an account? <a href="/INC/login.inc.php">Login</a></p>
                <?php if (!empty($success_message)): ?>
                    <p class="success-message"><?php echo $success_message; ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>

</body>

</html>
