<?php

/**
 * @author Ivan Torres Marcos
 * @version 2.9
 ** @description Sé que el jefe dijo que teníamos que implementar el BACKEND con su account.php ,list.php, delete.php y cancel.php, 
 ** pero en lugar de moduralizarlo lo que he hecho es comprobar si el user es el mismo que el que está logueado, y en base a eso,
 ** implementamos todas las MISMAS funciones que tendría que tener el BACKEND, es decir, si el user es el mismo que está logueado podré eliminar 
 ** las revels propias del propietario de la cuenta, podré eliminar directamente la cuenta y podré modificar tanto su nombre como su mail. De verdad,
 ** que he procurado moduralizarlo implementar el BACKEND etc, con mas tiempo, quizás hubiese sido capaz, pero me surgió una situación familiar
 ** algo deliacada la semana última y no tenía la cabeza yo para mucho trote y tenía que continuar con el otro proyecto de JS,
 ** disculpas jefe.
 *
 */


session_start();

include_once(__DIR__ . '/INC/connection.inc.php');

$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = connection('revels', 'revel', 'lever', $utf8);

if ($conexion->errorCode() != PDO::ERR_NONE) {
   echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
   exit;
}

$username = $_GET['usuario'];

$stmtUser = $conexion->prepare('SELECT * FROM users WHERE usuario = :username');
$stmtUser->bindParam(':username', $username);
$stmtUser->execute();
$userData = $stmtUser->fetch(PDO::FETCH_ASSOC);

//Por si introducen por URL un usuario que no existe
if (!$userData) {
   header('Location: /index');
   exit;
}


$stmtFollowers = $conexion->prepare('SELECT COUNT(userid) AS followers FROM follows WHERE userfollowed = :userID');
$stmtFollowers->bindParam(':userID', $userData['id']);
$stmtFollowers->execute();
$followersData = $stmtFollowers->fetch(PDO::FETCH_ASSOC);
$followersCount = $followersData['followers'];

$stmtRevels = $conexion->prepare('SELECT r.id AS revel_id, r.texto AS revel_texto, r.fecha AS revel_fecha, 
                                           COUNT(l.revelid) AS likes_count, COUNT(d.revelid) AS dislikes_count
                                       FROM revels r
                                       LEFT JOIN likes l ON r.id = l.revelid
                                       LEFT JOIN dislikes d ON r.id = d.revelid
                                       WHERE r.userid = :userID
                                       GROUP BY r.id');
$stmtRevels->bindParam(':userID', $userData['id']);
$stmtRevels->execute();
$userRevels = $stmtRevels->fetchAll(PDO::FETCH_ASSOC);

//Procesar el formulario de actualización del perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   if (isset($_POST['update_profile'])) {
      if (isset($_POST['update_profile'])) {
         $newUsername = $_POST['new_username'];
         $newEmail = $_POST['new_email'];
   
         // Verificar si el nuevo nombre de usuario ya existe
         $stmtCheckUsername = $conexion->prepare('SELECT id FROM users WHERE usuario = :newUsername AND id != :userID');
         $stmtCheckUsername->bindParam(':newUsername', $newUsername);
         $stmtCheckUsername->bindParam(':userID', $_SESSION['user_id']);
         $stmtCheckUsername->execute();
   
         // Verificar si el nuevo correo electrónico ya existe
         $stmtCheckEmail = $conexion->prepare('SELECT id FROM users WHERE email = :newEmail AND id != :userID');
         $stmtCheckEmail->bindParam(':newEmail', $newEmail);
         $stmtCheckEmail->bindParam(':userID', $_SESSION['user_id']);
         $stmtCheckEmail->execute();
   
         if ($stmtCheckUsername->rowCount() > 0) {
            $updateChangeMessage= "El nombre de usuario ya está en uso. Por favor, elige otro.";
         } elseif ($stmtCheckEmail->rowCount() > 0) {
            $updateChangeMessage= "El correo electrónico ya está en uso. Por favor, elige otro.";
         } else {
            // Si no hay conflictos, proceder con la actualización del perfil
            $stmtUpdate = $conexion->prepare('UPDATE users SET usuario = :newUsername, email = :newEmail WHERE id = :userID');
            $stmtUpdate->bindParam(':newUsername', $newUsername);
            $stmtUpdate->bindParam(':newEmail', $newEmail);
            $stmtUpdate->bindParam(':userID', $_SESSION['user_id']);
            $stmtUpdate->execute();
            $_SESSION['usuario'] = $newUsername; // Volvemos a asignar a la variable usuario el nuevo usuario
   
            header('Location: /user/' . urlencode($newUsername));
            exit();
         }
      }



      //BORRADO DE UN REVEL JUNTO CON EL BORRADO DE SUS LIKES Y DISLIKES Y COMMENTS
   } elseif (isset($_POST['delete_revel'])) {
      try {
         // Iniciar una transacción para asegurar la consistencia de los datos
         $conexion->beginTransaction();

         // Eliminar los comentarios asociados a la revelación
         $stmtDeleteComments = $conexion->prepare('DELETE FROM comments WHERE revelid = :revelID');
         $stmtDeleteComments->bindParam(':revelID', $_POST['revel_id']);
         $stmtDeleteComments->execute();

         // Eliminar los dislikes asociados a la revelación
         $stmtDeleteDislikes = $conexion->prepare('DELETE FROM dislikes WHERE revelid = :revelID');
         $stmtDeleteDislikes->bindParam(':revelID', $_POST['revel_id']);
         $stmtDeleteDislikes->execute();

         // Eliminar los likes asociados a la revelación
         $stmtDeleteLikes = $conexion->prepare('DELETE FROM likes WHERE revelid = :revelID');
         $stmtDeleteLikes->bindParam(':revelID', $_POST['revel_id']);
         $stmtDeleteLikes->execute();

         // Eliminar la revelación
         $stmtDeleteRevel = $conexion->prepare('DELETE FROM revels WHERE id = :revelID AND userid = :userID');
         $stmtDeleteRevel->bindParam(':revelID', $_POST['revel_id']);
         $stmtDeleteRevel->bindParam(':userID', $_SESSION['user_id']);
         $stmtDeleteRevel->execute();

         // Confirmar la transacción si todo ha ido bien
         $conexion->commit();

         // Redirigir o realizar otras acciones después de la eliminación
         header('Location: /user/' . urlencode($userData['usuario']));
         exit();
      } catch (PDOException $e) {
         // Revertir la transacción si algo salió mal
         $conexion->rollBack();

         // Manejar el error como desees
         echo 'Error: ' . $e->getMessage();
      }
   } elseif (isset($_POST['confirm_delete_account'])) {
      $checkboxValue = isset($_POST['confirm_checkbox']) ? $_POST['confirm_checkbox'] : false;

      if ($checkboxValue) {
         try {
            // Iniciar una transacción para asegurar la consistencia de los datos
            $conexion->beginTransaction();

            // Eliminar las filas en follows que hacen referencia al usuario
            $stmtDeleteFollows = $conexion->prepare('DELETE FROM follows WHERE userid = :userID OR userfollowed = :userID');
            $stmtDeleteFollows->bindParam(':userID', $_SESSION['user_id']);
            $stmtDeleteFollows->execute();

            // Eliminar los comentarios directamente asociados al usuario SIN ESTA QUERIE NO FUNCIONABA EL DELETE
            $stmtDeleteUserComments = $conexion->prepare('DELETE FROM comments WHERE userid = :userID');
            $stmtDeleteUserComments->bindParam(':userID', $_SESSION['user_id']);
            $stmtDeleteUserComments->execute();

            // Eliminar los comentarios asociados a las revelaciones del usuario
            $stmtDeleteComments = $conexion->prepare('
                       DELETE c
                       FROM comments c
                       INNER JOIN revels r ON c.revelid = r.id
                       WHERE r.userid = :userID
                   ');
            $stmtDeleteComments->bindParam(':userID', $_SESSION['user_id']);
            $stmtDeleteComments->execute();

            // Eliminar las revelaciones del usuario
            $stmtDeleteRevels = $conexion->prepare('DELETE FROM revels WHERE userid = :userID');
            $stmtDeleteRevels->bindParam(':userID', $_SESSION['user_id']);
            $stmtDeleteRevels->execute();

            // Eliminar el usuario
            $stmtDeleteUser = $conexion->prepare('DELETE FROM users WHERE id = :userID');
            $stmtDeleteUser->bindParam(':userID', $_SESSION['user_id']);
            $stmtDeleteUser->execute();

            // Confirmar la transacción si todo ha ido bien
            $conexion->commit();

            // Cerrar la sesión
            session_unset();
            session_destroy();

            // Redirigir a la página de inicio
            header('Location: /index');
            exit();
         } catch (PDOException $e) {
            // Revertir la transacción si algo salió mal
            $conexion->rollBack();


            echo 'Error: ' . $e->getMessage();
         }
      } else {
         echo "Debes marcar la casilla de confirmación para eliminar la cuenta.";
      }
   } elseif (isset($_POST['change_password'])) {
      if (empty($_POST['new_password'])) {
         $passwordChangeMessage = "La contraseña nueva no puede estar vacía.";
      } else {
         // Verificar si la contraseña actual es correcta
         $stmtCheckPassword = $conexion->prepare('SELECT contrasenya FROM users WHERE id = :userID');
         $stmtCheckPassword->bindParam(':userID', $_SESSION['user_id']);
         $stmtCheckPassword->execute();
         $storedHashedPassword = $stmtCheckPassword->fetchColumn();

         if (password_verify($_POST['current_password'], $storedHashedPassword)) {
            // Verificar si las nuevas contraseñas coinciden
            if ($_POST['new_password'] === $_POST['confirm_new_password']) {
               // Actualizar la contraseña en la base de datos
               $hashedNewPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
               $stmtUpdatePassword = $conexion->prepare('UPDATE users SET contrasenya = :newPassword WHERE id = :userID');
               $stmtUpdatePassword->bindParam(':newPassword', $hashedNewPassword);
               $stmtUpdatePassword->bindParam(':userID', $_SESSION['user_id']);
               $stmtUpdatePassword->execute();

               $passwordChangeMessage = "Contraseña actualizada correctamente.";
            } else {
               $passwordChangeMessage = "Las nuevas contraseñas no coinciden.";
            }
         } else {
            $passwordChangeMessage = "Contraseña actual incorrecta.";
         }
      }
   }
}
// Por si introducen por URL un usuario que no existe o que no sigues
if (!$userData && !$is_following && $_SESSION['user_id'] != $user_to_follow_id) {
   header('Location: /index');
   exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<?php include_once(__DIR__ . '/INC/headNavbarTablon.inc.php') ?>

<body cz-shortcut-listen="true" class="body">
   <div class="content">
      <!-- Contenido de la página -->
      <?php include_once(__DIR__ . '/INC/sidebar.inc.php') ?>
      <div class="revels-container">
         <div class="datos-usuario">
            <!-- Datos del usuario -->
            <h2>Datos del Usuario</h2>
            <p>Usuario: <?php echo htmlspecialchars($userData['usuario']); ?></p>
            <p>Email: <?php echo htmlspecialchars($userData['email']); ?></p>
            <p>Seguidores: <?php echo $followersCount; ?></p>
         </div>
         <!-- Mostrar el formulario de actualización solo si el usuario actual es el propietario del perfil -->
         <?php if ($_SESSION['user_id'] == $userData['id']) : ?>
            <div class="update-profile-container">
               <div class="change-user-mail-container">
                  <h2>Modificar Perfil</h2>
                  <?php
                  if (isset($updateChangeMessage)) {
                     echo '<p class="password-change-message">' . $updateChangeMessage . '</p>';
                  }
                  ?>
                  <form method="post" action="/user/<?php echo urlencode($userData['usuario']); ?>">
                     <label for="new_username">Nuevo Nombre de Usuario:</label>
                     <input type="text" id="new_username" name="new_username" value="<?php echo htmlspecialchars($userData['usuario']); ?>">
                     <br>
                     <label for="new_email">Nuevo Correo Electrónico:</label>
                     <input type="email" id="new_email" name="new_email" value="<?php echo htmlspecialchars($userData['email']); ?>">
                     <br>
                     <input type="submit" name="update_profile" value="Guardar Cambios" class="button-34">
                  </form>
               </div>
               <div class="change-password-container">
                  <h2>Cambiar Contraseña</h2>
                  <?php
                  if (!empty($passwordChangeMessage)) {
                     echo '<p class="password-change-message">' . $passwordChangeMessage . '</p>';
                  }
                  ?>
                  <form method="post" action="/user/<?php echo urlencode($userData['usuario']); ?>">
                     <label for="current_password">Contraseña Actual:</label>
                     <input type="password" id="current_password" name="current_password">
                     <br>
                     <label for="new_password">Nueva Contraseña:</label>
                     <input type="password" id="new_password" name="new_password">
                     <br>
                     <label for="confirm_new_password">Confirmar Nueva Contraseña:</label>
                     <input type="password" id="confirm_new_password" name="confirm_new_password">
                     <br>
                     <input type="submit" name="change_password" value="Cambiar Contraseña" class="button-34">
                  </form>
               </div>
            </div>
            <!-- Formulario de eliminación de cuenta -->
            <div class="delete-account-container">
               <h2>Eliminar Cuenta</h2>
               <form method="post" action="/user/<?php echo urlencode($userData['usuario']); ?>">
                  <label>
                     <input type="checkbox" name="confirm_checkbox">
                     Confirmo que deseo eliminar mi cuenta y toda la información asociada.
                  </label>
                  <br>
                  <input type="submit" name="confirm_delete_account" class="button-34" value="Eliminar Cuenta">
               </form>
            </div>
         <?php endif; ?>
         <!-- Lista de Revels del usuario -->
         <div class="revels-user">
            <div class="tituloh2">
               <h2>Revels del Usuario</h2>
            </div>
            <ul>
               <?php foreach ($userRevels as $revel) : ?>
                  <li>
                     <!-- Enlace a la página revel -->
                     <a href="/revel/<?php echo $revel['revel_id']; ?>">
                        <!-- Primeros 50 caracteres del texto de la revel -->
                        <?php echo htmlspecialchars(substr($revel['revel_texto'], 0, 50)); ?>
                     </a>
                     <!-- Cantidad de me gusta y no me gusta -->
                     <p>Likes: <?php echo $revel['likes_count']; ?>, Dislikes: <?php echo $revel['dislikes_count']; ?></p>
                  </li>
            </ul>
            <!-- Formulario para eliminar la revelación -->
            <?php if ($_SESSION['user_id'] == $userData['id']) : ?>
               <form method="post" action="" id="deleteRevel">
                  <input type="hidden" name="revel_id" value="<?php echo $revel['revel_id']; ?>">
                  <input class="button-34" type="submit" name="delete_revel" value="Eliminar Revel">
               </form>
            <?php endif; ?>
         <?php endforeach; ?>
         </div>
      </div>
      <div class="volver">
         <a href="/index">Volver al Tablón</a>
      </div>
   </div>
</body>

</html>