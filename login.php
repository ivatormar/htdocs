<?php

/**
 * @author Ivan Torres Marcos
 * @version 1.2
 * @description En este php hacemos el login del usuario ademaás, damos la posibilidad de recuperar la contraseña
 * En esta nueva versión hemos añadido todas las variables correspondientes para hacer la "internacionalización".
 */

session_start();
include_once(__DIR__ . '/includes/dbconnection.inc.php');
include_once(__DIR__ . '/includes/header.inc.php');
require_once(__DIR__ . '/includes/language_utils.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Validar los campos
   if (empty($_POST['username']) || empty($_POST['password'])) {
      // Si algún campo está vacío, muestra un mensaje de error
      $_SESSION['error'] = 'Por favor, completa todos los campos.';
      // Puedes redirigir a la página de inicio de sesión nuevamente o manejarlo de acuerdo a tus necesidades
      header('Location: /login.php');
      exit();
   }

   // Consultar la base de datos para obtener el usuario
   $connection = getDBConnection(); // Función que devuelve la conexión a la base de datos

   $stmt = $connection->prepare("SELECT user, email, password, rol FROM users WHERE user = :username OR email = :username");
   $stmt->bindValue(":username", $_POST['username']);
   $stmt->execute();
   $user = $stmt->fetch(PDO::FETCH_ASSOC);


   // Verificar las credenciales
   if ($user !== false && password_verify($_POST['password'], $user['password'])) {
      $_SESSION['user'] = [
         'user' => $user['user'],
         'email' => $user['email'],
         'rol' => $user['rol']
      ];

      if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
         // Generar y guardar un token en la base de datos
         $token = uniqid();
         $stmt = $connection->prepare("UPDATE users SET token = ? WHERE user = ?");
         $stmt->execute([$token, $user['user']]);

         // Configurar cookies para el autologin
         setcookie('remember_user', $user['user'], time() + 86400 * 30, '/', '', true, true); // Secure y HttpOnly
         setcookie('remember_token', $token, time() + 86400 * 30, '/', '', true, true); // Secure y HttpOnly
      }

      header('Location: /index.php');
      exit();
   } else {

      $_SESSION['error'] = $lang['incorrect_credentials'];
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
   <title><?= $lang['login_heading'] ?> - MerchaShop</title>
   <link rel="stylesheet" href="/css/style.css">
</head>

<body>
   <?php
   include_once(__DIR__ . '/includes/header.inc.php');
   ?>
   <section class="formulario">
      <h2><?= $lang['login_heading'] ?></h2>
      <?php
      if (isset($_SESSION['error'])) {
         echo '<p>' . $_SESSION['error'] . '</p>';
         unset($_SESSION['error']); // Clear the error message after displaying it
      }
      ?>
      <form action="/login.php" method="post">
         <label for="username"><?= $lang['user'] ?>:</label>
         <input type="text" id="username" name="username" >
         <label for="password"><?= $lang['password'] ?>:</label>
         <input type="password" id="password" name="password" >
         <label for="remember"><?= $lang['stay_connected'] ?>:</label>
         <input type="checkbox" id="remember" name="remember">
         <button type="submit"><?= $lang['login_heading'] ?></button>
      </form>
      <a href="/passwordRecovery.php"><?= $lang['forgot_password'] ?></a>
   </section>
</body>

</html>