<?php
   session_start();
   include_once(__DIR__ . '/INC/connection.inc.php');
   
   $utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
   $conexion = connection('revels', 'revel', 'lever', $utf8);
   
   // Verificar si hay errores de conexión
   if ($conexion->errorCode() != PDO::ERR_NONE) {
       echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
       exit;
   }
   
   // Verificar si se ha enviado el formulario de búsqueda
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_query'])) {
       $search_query = $_POST['search_query'];
   
       // Consultar usuarios que coincidan con la búsqueda
       $search_query_param = "%{$search_query}%";
       $stmt = $conexion->query("SELECT * FROM users WHERE usuario LIKE '$search_query_param'");
       $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
   }
   
   // Verificar si se ha enviado el formulario de seguimiento/dejar de seguir
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['follow']) || isset($_POST['unfollow']))) {
       $follower_id = $_SESSION['user_id'];
       $user_to_follow_id = $_POST['user_id'];
   
       // Verificar si el usuario ya sigue al otro usuario
       $stmt_follow = $conexion->query("SELECT * FROM follows WHERE userid = $follower_id AND userfollowed = $user_to_follow_id");
       $is_following = $stmt_follow->fetch(PDO::FETCH_ASSOC);
   
       // Si ya sigue al usuario y se hizo clic en "Dejar de seguir", eliminar el seguimiento
       if ($is_following && isset($_POST['unfollow'])) {
           $stmt_unfollow = $conexion->query("DELETE FROM follows WHERE userid = $follower_id AND userfollowed = $user_to_follow_id");
           header('Location:/index');
           exit();
       }
       // Si no sigue al usuario y se hizo clic en "Seguir", agregar el seguimiento
       elseif (!$is_following && isset($_POST['follow'])) {
           $stmt_follow = $conexion->query("INSERT INTO follows (userid, userfollowed) VALUES ($follower_id, $user_to_follow_id)");
           header('Location:/index');
           exit();
       }
   }
?>
<!DOCTYPE html>
<html lang="es">
   <?php include_once(__DIR__ . '/INC/headNavbarTablon.inc.php') ?>
   <body cz-shortcut-listen="true" class="body">
      <div class="content">
         <?php include_once(__DIR__ . '/INC/sidebar.inc.php') ?>
         <!-- Mostrar resultados de búsqueda -->
         <div class="search-results-container">
            <?php
               if (isset($search_results) && !empty($search_results)) {
                   echo '<h2>Resultados de búsqueda:</h2>';
                   echo '<ul>';
                   foreach ($search_results as $user) {
                       echo '<li>';
                       echo '<span>' . htmlspecialchars($user['usuario']) . '</span>';
               
                       // Verificar si el usuario está siendo seguido
                       $user_id = $user['id'];
                       $stmt_follow = $conexion->query("SELECT * FROM follows WHERE userid = {$_SESSION['user_id']} AND userfollowed = $user_id");
                       $is_following = $stmt_follow->fetch(PDO::FETCH_ASSOC);
               
                       // Mostrar botón de seguir o dejar de seguir
                       echo '<form method="post" action="">';
                       echo '<input type="hidden" name="user_id" value="' . $user['id'] . '">';
               
                       if ($is_following) {
                           // Si ya sigue al usuario, mostrar botón para dejar de seguir
                           echo '<button type="submit" name="unfollow" class="btn btn-danger">Dejar de seguir</button>';
                       } else {
                           // Si no sigue al usuario, mostrar botón para seguir
                           echo '<button type="submit" name="follow" class="btn btn-primary">Seguir</button>';
                       }
               
                       echo '</form>';
                       echo '</li>';
                   }
                   echo '</ul>';
               } else {
                   echo '<p>No se encontraron resultados.</p>';
               }
            ?>
         </div>
         <div class="volver">
            <a href="/index">Volver al tablón</a>
         </div>
      </div>
   </body>
</html>