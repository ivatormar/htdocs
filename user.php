<?php
session_start();

include_once(__DIR__ . '/INC/connection.inc.php');
include_once(__DIR__.'/BACKEND/process-forms.php');
include_once(__DIR__.'/BACKEND/user-view.php');


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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar acciones según el formulario enviado
    include_once(__DIR__.'/BACKEND/process-forms.php');
}

// Por si introducen por URL un usuario que no existe o que no sigues
if (!$userData && !$is_following && $_SESSION['user_id'] != $user_to_follow_id) {
    header('Location: /index');
    exit;
}

include_once(__DIR__.'/BACKEND/user-view.php');
?>







<?php
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
           $newUsername = $_POST['new_username'];
           $newEmail = $_POST['new_email'];
           $stmtUpdate = $conexion->prepare('UPDATE users SET usuario = :newUsername, email = :newEmail WHERE id = :userID');
           $stmtUpdate->bindParam(':newUsername', $newUsername);
           $stmtUpdate->bindParam(':newEmail', $newEmail);
           $stmtUpdate->bindParam(':userID', $_SESSION['user_id']);
           $stmtUpdate->execute();
           $_SESSION['usuario'] = $newUsername; // Volvemos a asignar a la variable usuario el nuevo usuario
   
           header('Location: /user/' . urlencode($newUsername));
           exit();
   
   
   
           //BORRADO DE UN REVEL JUNTO CON EL BORRADO DE SUS LIKES Y DISLIKES Y COMMENTS
       } elseif (isset($_POST['delete_revel'])) {
           $revelId = $_POST['revel_id'];
   
           try {
               // Iniciar una transacción para asegurar la consistencia de los datos
               $conexion->beginTransaction();
   
               // Eliminar los comentarios asociados a la revelación
               $stmtDeleteComments = $conexion->prepare('DELETE FROM comments WHERE revelid = :revelID');
               $stmtDeleteComments->bindParam(':revelID', $revelId);
               $stmtDeleteComments->execute();
   
               // Eliminar los dislikes asociados a la revelación
               $stmtDeleteDislikes = $conexion->prepare('DELETE FROM dislikes WHERE revelid = :revelID');
               $stmtDeleteDislikes->bindParam(':revelID', $revelId);
               $stmtDeleteDislikes->execute();
   
               // Eliminar los likes asociados a la revelación
               $stmtDeleteLikes = $conexion->prepare('DELETE FROM likes WHERE revelid = :revelID');
               $stmtDeleteLikes->bindParam(':revelID', $revelId);
               $stmtDeleteLikes->execute();
   
               // Eliminar la revelación
               $stmtDeleteRevel = $conexion->prepare('DELETE FROM revels WHERE id = :revelID AND userid = :userID');
               $stmtDeleteRevel->bindParam(':revelID', $revelId);
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
               <h2>Modificar Perfil</h2>
               <form method="post" action="/user/<?php echo urlencode($userData['usuario']); ?>">
                  <label for="new_username">Nuevo Nombre de Usuario:</label>
                  <input type="text" id="new_username" name="new_username" value="<?php echo htmlspecialchars($userData['usuario']); ?>" required>
                  <br>
                  <label for="new_email">Nuevo Correo Electrónico:</label>
                  <input type="email" id="new_email" name="new_email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
                  <br>
                  <input type="submit" name="update_profile" value="Guardar Cambios" class="button-34">
               </form>
            </div>
            <!-- Formulario de eliminación de cuenta -->
            <div class="delete-account-container">
               <h2>Eliminar Cuenta</h2>
               <form method="post" action="/user/<?php echo urlencode($userData['usuario']); ?>">
                  <label>
                  <input type="checkbox" name="confirm_checkbox" required>
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