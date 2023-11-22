<!DOCTYPE html>
<html lang="es">
   <?php include_once('INC/headNavbarTablon.inc.php') ?>
   <body cz-shortcut-listen="true" class="body">
      <div class="content">
         <!-- Contenido de la página -->
         <?php include_once('INC/sidebar.inc.php') ?>
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
               <!-- Resto del código HTML... -->
            </div>
            <!-- Formulario de eliminación de cuenta -->
            <div class="delete-account-container">
               <!-- Resto del código HTML... -->
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
                  <!-- Resto del código HTML... -->
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
