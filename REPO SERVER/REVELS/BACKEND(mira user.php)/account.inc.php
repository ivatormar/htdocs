<?php
session_start();

include_once('../INC/connection.inc.php');

$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = connection('revels', 'revel', 'lever', $utf8);

if ($conexion->errorCode() != PDO::ERR_NONE) {
    echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
    exit;
}

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    // Si no está logueado, redirige a la página de inicio o realiza alguna acción
    header('Location: /index');
    exit;
}


$stmtFollowers = $conexion->prepare('SELECT COUNT(userid) AS followers FROM follows WHERE userfollowed = :userID');
$stmtFollowers->bindParam(':userID', $userData['id']);
$stmtFollowers->execute();
$followersData = $stmtFollowers->fetch(PDO::FETCH_ASSOC);
$followersCount = $followersData['followers'];

// Obtén los datos del usuario logueado
$userID = $_SESSION['user_id'];
$stmtUser = $conexion->prepare('SELECT * FROM users WHERE id = :userID');
$stmtUser->bindParam(':userID', $userID);
$stmtUser->execute();
$userData = $stmtUser->fetch(PDO::FETCH_ASSOC);


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

// Verifica si el usuario está intentando actualizar su perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $newUsername = $_POST['new_username'];
    $newEmail = $_POST['new_email'];

    $stmtUpdate = $conexion->prepare('UPDATE users SET usuario = :newUsername, email = :newEmail WHERE id = :userID');
    $stmtUpdate->bindParam(':newUsername', $newUsername);
    $stmtUpdate->bindParam(':newEmail', $newEmail);
    $stmtUpdate->bindParam(':userID', $userID);
    $stmtUpdate->execute();

    // Actualiza la variable de sesión si el cambio fue exitoso
    $_SESSION['usuario'] = $newUsername;

    header('Location: /account');
    exit();
}

// Verifica si el usuario está intentando eliminar un revel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_revel'])) {
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
        $stmtDeleteRevel->bindParam(':userID', $userID);
        $stmtDeleteRevel->execute();

        // Confirmar la transacción si todo ha ido bien
        $conexion->commit();

        // Redirigir o realizar otras acciones después de la eliminación
        header('Location: /account');
        exit();
    } catch (PDOException $e) {
        // Revertir la transacción si algo salió mal
        $conexion->rollBack();

        // Manejar el error como desees
        echo 'Error: ' . $e->getMessage();
    }
}

// Verifica si el usuario está intentando eliminar su cuenta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete_account'])) {
    $checkboxValue = isset($_POST['confirm_checkbox']) ? $_POST['confirm_checkbox'] : false;

    if ($checkboxValue) {
        try {
            // Iniciar una transacción para asegurar la consistencia de los datos
            $conexion->beginTransaction();

            // Eliminar las filas en follows que hacen referencia al usuario
            $stmtDeleteFollows = $conexion->prepare('DELETE FROM follows WHERE userid = :userID OR userfollowed = :userID');
            $stmtDeleteFollows->bindParam(':userID', $userID);
            $stmtDeleteFollows->execute();

            // Eliminar los comentarios directamente asociados al usuario
            $stmtDeleteUserComments = $conexion->prepare('DELETE FROM comments WHERE userid = :userID');
            $stmtDeleteUserComments->bindParam(':userID', $userID);
            $stmtDeleteUserComments->execute();

            // Eliminar los comentarios asociados a las revelaciones del usuario
            $stmtDeleteComments = $conexion->prepare('
                DELETE c
                FROM comments c
                INNER JOIN revels r ON c.revelid = r.id
                WHERE r.userid = :userID
            ');
            $stmtDeleteComments->bindParam(':userID', $userID);
            $stmtDeleteComments->execute();

            // Eliminar las revelaciones del usuario
            $stmtDeleteRevels = $conexion->prepare('DELETE FROM revels WHERE userid = :userID');
            $stmtDeleteRevels->bindParam(':userID', $userID);
            $stmtDeleteRevels->execute();

            // Eliminar el usuario
            $stmtDeleteUser = $conexion->prepare('DELETE FROM users WHERE id = :userID');
            $stmtDeleteUser->bindParam(':userID', $userID);
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

            // Manejar el error como desees
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo "Debes marcar la casilla de confirmación para eliminar la cuenta.";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
    <?php include_once('../INC/headNavbarTablon.inc.php') ?>
    <body cz-shortcut-listen="true" class="body">
        <div class="content">
            <!-- Contenido de la página -->
            <?php include_once('../INC/sidebar.inc.php') ?>
            <div class="revels-container">
                <!-- Sección de Datos del Usuario -->
                <div class="datos-usuario">
                    <h2>Datos del Usuario</h2>
                    <p>Usuario: <?php echo htmlspecialchars($userData['usuario']); ?></p>
                    <p>Email: <?php echo htmlspecialchars($userData['email']); ?></p>
                    <p>Seguidores: <?php echo $followersCount; ?></p>
                </div>

                <!-- Sección de Modificar Perfil (si el usuario actual es el propietario del perfil) -->
                <?php if ($_SESSION['user_id'] == $userData['id']) : ?>
                    <div class="update-profile-container">
                        <h2>Modificar Perfil</h2>
                        <form method="post" action="">
                            <!-- Campos para la actualización del perfil -->
                            <label for="new_username">Nuevo Nombre de Usuario:</label>
                            <input type="text" id="new_username" name="new_username" value="<?php echo htmlspecialchars($userData['usuario']); ?>" required>
                            <br>
                            <label for="new_email">Nuevo Correo Electrónico:</label>
                            <input type="email" id="new_email" name="new_email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
                            <br>
                            <!-- Botón de Guardar Cambios -->
                            <input type="submit" name="update_profile" value="Guardar Cambios" class="button-34">
                        </form>
                    </div>
                <?php endif; ?>

                <!-- Sección de Eliminar Cuenta (si el usuario actual es el propietario del perfil) -->
                <?php if ($_SESSION['user_id'] == $userData['id']) : ?>
                    <div class="delete-account-container">
                        <h2>Eliminar Cuenta</h2>
                        <form method="post" action="/account">
                            <!-- Checkbox de confirmación -->
                            <label>
                                <input type="checkbox" name="confirm_checkbox" required>
                                Confirmo que deseo eliminar mi cuenta y toda la información asociada.
                            </label>
                            <br>
                            <!-- Botón de Eliminar Cuenta -->
                            <input type="submit" name="confirm_delete_account" class="button-34" value="Eliminar Cuenta">
                        </form>
                    </div>
                <?php endif; ?>

                <!-- Sección de Revels del Usuario -->
                <div class="revels-user">
                    <div class="tituloh2">
                        <h2>Revels del Usuario</h2>
                    </div>
                    <ul>
                        <!-- Iterar sobre las revelaciones del usuario -->
                        <?php foreach ($userRevels as $revel) : ?>
                            <li>
                                <!-- Enlace a la página de la revelación -->
                                <a href="/revel/<?php echo $revel['revel_id']; ?>">
                                    <!-- Primeros 50 caracteres del texto de la revelación -->
                                    <?php echo htmlspecialchars(substr($revel['revel_texto'], 0, 50)); ?>
                                </a>
                                <!-- Cantidad de Me gusta y No me gusta -->
                                <p>Likes: <?php echo $revel['likes_count']; ?>, Dislikes: <?php echo $revel['dislikes_count']; ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
