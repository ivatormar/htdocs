<?php
   /**
    * @author Ivan Torres Marcos
    * @version 1.3
    * @description Con este php solicitamos simplemente nos pasan por URL el token y el mail el cual solicita el cambio de 
    * password y hacemos un UPDATE.
    *
    */
   include_once(__DIR__ . '/includes/dbconnection.inc.php');
   require_once(__DIR__ . '/includes/language_utils.inc.php');

   
   // Iniciar sesión
  
   
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       // Obtener datos del formulario
       $email = $_POST['email'];
       $newPassword = $_POST['new_password'];
   
       // Validar la contraseña y realizar otras validaciones necesarias
       if (strlen($newPassword) < 4) {
           $_SESSION['error'] = $lang['caracteresError'];
           header('Location: /resetPassword.php?token=' . $_POST['token'] . '&email=' . $email);
           exit;
       }
   
       // Hashear la nueva contraseña
       $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
   
       // Actualizar la contraseña en la tabla "users"
       $conn = getDBConnection();
   
       // Preparar la consulta SQL
       $sql = "UPDATE users SET password = :password WHERE email = :email";
       $stmt = $conn->prepare($sql);
   
       $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
       $stmt->bindParam(':email', $email, PDO::PARAM_STR);
   
       // Ejecutar la consulta
       if ($stmt->execute()) {
           // Eliminar el registro de recuperación de contraseña en la tabla "passwordrecovery"
           $sql = "DELETE FROM passwordrecovery WHERE email = :email";
           $stmt = $conn->prepare($sql);
           $stmt->bindParam(':email', $email, PDO::PARAM_STR);
           $stmt->execute();
   
           // Establecer el mensaje de éxito en la sesión
           $_SESSION['success'] = $lang['contraseñaExito'];
   
           // Redirigir al index.php
           header('Location: /index.php');
           exit;
       } else {
           $_SESSION['error'] = $lang['updateError'];
           header('Location: /resetPassword.php?token=' . $_POST['token'] . '&email=' . $email);
           exit;
       }
   } else {
       // Obtener el token y el correo electrónico de la URL
       $token = $_GET['token'];
       $email = $_GET['email'];
   
       // Verificar si el token y el correo electrónico son válidos y existen en la base de datos
       $conn = getDBConnection();
   
       // Preparar la consulta SQL
       $sql = "SELECT * FROM passwordrecovery WHERE email = :email AND token = :token";
       $stmt = $conn->prepare($sql);
   
       // Asignar los valores de los parámetros
       $stmt->bindParam(':email', $email, PDO::PARAM_STR);
       $stmt->bindParam(':token', $token, PDO::PARAM_STR);
   
       // Ejecutar la consulta
       $stmt->execute();
   
       // Verificar si se encontró un registro con el token y el correo electrónico proporcionados
       if ($stmt->rowCount() === 0) {
           $_SESSION['error'] = $lang['tokenError'];
           header('Location: /index.php'); // Otra página de destino si es necesario
           exit;
       }
   }
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?= $lang['h2ResetPassword']?></title>
      <link rel="stylesheet" href="/css/style.css">
   </head>
   <body>
      <?php
         include_once(__DIR__ . '/includes/header.inc.php');
         ?>
      <h2><?= $lang['h2ResetPassword']?></h2>
      <?php
      if (isset($_SESSION['error'])) {
         echo '<p>' . $_SESSION['error'] . '</p>';
         unset($_SESSION['error']); // Clear the error message after displaying it
      }
      if (isset($_SESSION['success'])) {
         echo '<p>' . $_SESSION['success'] . '</p>';
         unset($_SESSION['success']); // Clear the error message after displaying it
      }
      ?>
      <form method="post" action="resetPassword.php">
         <input type="hidden" name="email" value="<?= $email; ?>">
         <input type="hidden" name="token" value="<?= $token; ?>">
         <label for="new_password"><?= $lang['nuevaContraseña']?>:</label>
         <input type="password" name="new_password" id="new_password">
         <br>
         <input type="submit" value="<?= $lang['guardarContraseña']?>">
      </form>
   </body>
</html>
<?php
   // Cerrar la conexión
   $conn = null;
   exit;
?>