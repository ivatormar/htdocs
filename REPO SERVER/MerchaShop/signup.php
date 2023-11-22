<?php
   /**
    * @author Ivan Torres Marcos
    * @version 1.0
    * @description En este php procederemos a realizar el registro de usuarios
    *
    */
   
   session_start();
   include_once(__DIR__ . '/includes/dbconnection.inc.php');
   
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       try {
           // Validacion de campos
           if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
               $_SESSION['error'] = 'Por favor, completa todos los campos.';
               header('Location: /signup.php');
               exit();
           }
           //Hasheamos la contraseña 
           $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
   
           $connection = getDBConnection();
   
           // Comenzar una transacción
           $connection->beginTransaction();
   
           $token = uniqid();
   
           $stmt = $connection->prepare("INSERT INTO users (user, email, password, token) VALUES (?, ?, ?, ?)");
   
           if ($stmt->execute([$_POST['username'], $_POST['email'], $hashedPassword, $token])) {
               // Confirmar la transacción si la inserción tiene éxito
               $connection->commit();
               header('Location: /login.php');
               exit();
           } else {
               // Revertir la transacción en caso de error
               $connection->rollBack();
               $_SESSION['error'] = 'Error al registrar el usuario.';
               header('Location: /signup.php');
               exit();
           }
       } catch (PDOException $e) {
           // Manejo de excepciones y capturación
           $connection->rollBack();
   
           // Verificar si la excepción es debido a una violación de integridad (duplicado)
           if ($e->getCode() == 23000) {
               if (strpos($e->getMessage(), 'Duplicate entry') !== false)
                   $_SESSION['error'] = 'El usuario o el correo electrónico ya existen.';
           } else {
               $_SESSION['error'] = 'Error al registrar el usuario: ' . $e->getMessage();
           }
   
           header('Location: /signup.php');
           exit();
       } finally {
           // Cerrar la conexión en cualquier caso
           $stmt = null;
           $connection = null;
       }
   }
   
   // Recuperar mensaje de error después de la redirección
   $errorMsg = isset($_SESSION['error']) ? $_SESSION['error'] : '';
   unset($_SESSION['error']);
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
         <?php
            if (!empty($errorMsg)) {
                echo '<p class="error-message">' . $errorMsg . '</p>';
            }
            ?>
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