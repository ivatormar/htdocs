<?php
$login = false;
$errors = array("user" => "", "password" => "");

function validarUsuarioYContraseña($user, $password) {
    // Aquí deberías implementar la lógica de validación de usuario y contraseña
    // Puedes verificar las credenciales en una base de datos o utilizar otro método de autenticación.
    // Si las credenciales son válidas, devuelve true; de lo contrario, devuelve false.
    if ($user === 'usuario' && $password === 'contraseña') {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se ha enviado el formulario
    $user = $_POST["user"];
    $password = $_POST["password"];

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
        // Aquí puedes realizar la validación de usuario y contraseña en tu base de datos
        // Si la validación es exitosa, establece $login en true
        // De lo contrario, muestra un mensaje de error
        if (validarUsuarioYContraseña($user, $password)) {
            $login = true;
        } else {
            // Comprueba si el usuario o la contraseña son incorrectos
            if ($user !== 'usuario') {
                $errors["user"] = "Usuario incorrecto.";
            }
            if ($password !== 'contraseña') {
                $errors["password"] = "Contraseña incorrecta.";
            }
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
            if($login === true){
                echo '
                <div class="login">
                    <button type="button" class="btn btn-danger" data-mdb-ripple-color="#ffffff"> Mi perfil </button>
                    <button type="button" class="btn btn-danger" data-mdb-ripple-color="#ffffff"> Nuevo Revel </button>
                    <button type="button" class="btn btn-danger" data-mdb-ripple-color="#ffffff"> Salir </button>
                </div>';
            }
            ?>
            <div class="button-container">
                <button type="button" id="btnLogin" class="btn btn-rounded" data-mdb-ripple-color="#ffffff" style="background-color:#fc92ad"><a class="login-a" href="/index.php">REGISTER</a></button>
            </div>
        </div>
    </nav>

    <!-- LOGIN FORM -->
    <div class="login-page">
        <div class="form">
            <h2>¡ Revel yourself !</h2>
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
