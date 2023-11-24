<?php
/**
 * @author Ivan Torres Marcos
 * @version 1.3
 * @description En register.php lo que hacemos es hacer un formulario de registro "básico" con toda la validación de los inputs y las queries necesarias en
 * la base de datos para hacer el INSERT apropiado, además de comprobar si el usuario existe o no junto a su mail.
 *
 */
include_once(__DIR__ . '/connection.inc.php');
$registration_successful = false;

$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = connection('revels', 'revel', 'lever', $utf8);
$errors = array("usuario" => "", "email" => "", "contrasenya" => "" ,"terminos"=>"");

if ($conexion->errorCode() != PDO::ERR_NONE) {
    echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación del campo "User"
    if (empty($_POST['usuario'])) {
        $errors["usuario"] = "El campo de usuario es obligatorio.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $_POST['usuario'])) {
        $errors["usuario"] = "El usuario solo puede contener letras, números y guiones bajos (_).";
    }

    // Validación del campo "Email"
    if (empty($_POST['email'])) {
        $errors["email"] = "El campo de correo electrónico es obligatorio.";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "El correo electrónico no es válido.";
    }

    // Validación del campo "Password"
    if (empty($_POST['contrasenya'])) {
        $errors["contrasenya"] = "El campo de contraseña es obligatorio.";
    } elseif (strlen($_POST['contrasenya']) < 6) {
        $errors["contrasenya"] = "La contraseña debe tener al menos 6 caracteres.";
    }

    // Verificación adicional: Usuario y correo electrónico no deben existir
    $existing_user_query = $conexion->prepare('SELECT COUNT(*) FROM users WHERE usuario = :usuario OR email = :email');
    $existing_user_query->execute(array(':usuario' => $_POST['usuario'], ':email' => $_POST['email']));
    $existing_user_count = $existing_user_query->fetchColumn();

    if ($existing_user_count > 0) {
        $errors["usuario"] = "El usuario ya está registrado.";
        $errors["email"] = "El correo electrónico ya está registrado.";
        $_POST['usuario'] = ''; // Limpimaos campos de los forms
        $_POST['email'] = ''; // Limpimaos campos de los forms
    }

    // Verificación del checkbox de términos y condiciones
    if (!isset($_POST['terminos'])) {
        $errors["terminos"] = "Debes aceptar los términos y condiciones.";
    }

    // Procesar el formulario si no hay errores
    if (empty($errors["usuario"]) && empty($errors["email"]) && empty($errors["contrasenya"]) && empty($errors["terminos"])) {
        $success_message = "¡Ya puedes loguearte!";
        try {
            if ($conexion->errorCode() != PDO::ERR_NONE) {
                throw new Exception('Error al conectar a la base de datos: ' . $conexion->errorInfo()[2]);
            }
            echo "Antes del var_dump";
            $hashedPassword = password_hash($_POST['contrasenya'], PASSWORD_DEFAULT);

            $stmt = $conexion->prepare('INSERT INTO users (usuario, contrasenya, email) VALUES (:usuario, :contrasenya, :email)');
          
            $stmt->bindParam(':usuario', $_POST['usuario']);
            $stmt->bindParam(':contrasenya', $hashedPassword);
            $stmt->bindParam(':email', $_POST['email']);

            $stmt->execute();
            $registration_successful = true;
        } catch (Exception $e) {
            echo 'Error en la base de datos: ' . $e->getMessage();
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
    <link rel="shortcut icon" href="/MEDIA-REVELS-LOGO/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>REVELS</title>
</head>

<body cz-shortcut-listen="true">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="">
                <img src="/MEDIA-REVELS-LOGO/logo-navbar.png" alt="logoNav">
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="button-container">
                <button type="button" id="btnLogin" class="btn button-34"><a class="login-a" href="/login">LOGIN</a></button>
            </div>
        </div>
    </nav>
    <!-- REGISTER FORM -->
    <div class="login-page">
        <div class="form">
            <h2>¡Welcome to Revels, SIGN UP!</h2>
            <form class="login-form" action="" method="post">
                <input type="text" name="usuario" placeholder="User" id="usuario" required value="<?php echo ($registration_successful) ? '' : (isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''); ?>" />
                <p class="error-message"><?php echo $errors["usuario"]; ?></p>
                <input type="password" name="contrasenya" placeholder="Password" id="contrasenya" required />
                <p class="error-message"><?php echo $errors["contrasenya"]; ?></p>
                <input type="text" name="email" placeholder="Email" id="email" required value="<?php echo ($registration_successful) ? '' : (isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''); ?>" />
                <p class="error-message"><?php echo $errors["email"]; ?></p>
                <div class="checkbox-container">
                    <input type="checkbox" id="terminos" name="terminos">
                    <label for="terminos">Acepte los términos y condiciones</label>
                    <p class="error-message"><?php echo $errors["terminos"]; ?></p>
                </div>

                <input type="submit" value="Sign up" class="button-34" id="signUp">
                <p class="message">Do you have an account? <a href="/login">Login</a></p>
            </form>
            <?php
            // Display success message if registration was successful
            if ($registration_successful) {
                echo '<p class="success-message">¡Registro exitoso! ¡Ya puedes loguearte!</p>';
            }
            ?>
        </div>
    </div>
</body>

</html>
