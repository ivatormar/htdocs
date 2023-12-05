<?php
   /**
    * @author Ivan Torres Marcos
    * @version 1.3
    * @description En este php visualizaremos a todos los usuarios existentes, pero solo lo podrá ver el usuario cuyo rol sea admin.
    * En esta nueva versión hemos añadido todas las variables correspondientes para hacer la "internacionalización".
    *
    */
   session_start();
   include_once(__DIR__ . '/includes/dbconnection.inc.php');
   require_once(__DIR__ . '/includes/language_utils.inc.php');

   
   // Obtener la lista de usuarios
   $connection = getDBConnection();
   $users = $connection->query('SELECT user, email, rol FROM users;', PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?=$lang['usuarios'];?> - MerchaShop</title>
      <link rel="stylesheet" href="/css/style.css">
   </head>
   <body>
      <?php
         include_once(__DIR__ . '/includes/header.inc.php');
         ?>
      <section class="usuarios">
         <h2><?=$lang['usuarios'];?></h2>
         <ul>
            <?php
               //Recorremos los usuarios que existan en nuestra DB, y mostramos su
               foreach ($users as $user) {
                   echo '<li>';
                   echo '<strong>'.$lang['usuario'].':</strong> ' . $user->user . '<br>';
                   echo '<strong>'.$lang['correo'].':</strong> ' . $user->email . '<br>';
                   echo '<strong>'.$lang['rol'].':</strong> ' . $user->rol . '<br>';
                   echo '</li><br>';
               }
               ?>
         </ul>
      </section>
   </body>
</html>
<?php
   // Cerrar la conexión y liberar recursos
   unset($users);
   unset($connection);
?>