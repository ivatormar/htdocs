<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: /index'); // Redirigir a la página de inicio si no ha iniciado sesión
    exit();
}

include_once('../INC/connection.inc.php');

$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = connection('revels', 'revel', 'lever', $utf8);

if ($conexion->errorCode() != PDO::ERR_NONE) {
    echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
    exit;
}

if (isset($_SESSION['user_id'])) {
    $stmtRevels = $conexion->prepare('SELECT r.id AS revel_id, r.userid, r.texto AS revel_texto, r.fecha AS revel_fecha, 
                                   COUNT(l.revelid) AS likes_count, COUNT(d.revelid) AS dislikes_count
                               FROM revels r
                               LEFT JOIN likes l ON r.id = l.revelid
                               LEFT JOIN dislikes d ON r.id = d.revelid
                               WHERE r.userid = :userID
                               GROUP BY r.id');


    $stmtRevels->bindParam(':userID', $_SESSION['user_id']);
    $stmtRevels->execute();
    $userRevels = $stmtRevels->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Manejar el caso en el que $_SESSION['user_id'] no está definido
    echo 'No se ha iniciado sesión.';
    exit;
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
            <div class="revels-user">
                <h2>Mis Revels</h2>
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
                            <?php if (!empty($userRevels) && $_SESSION['user_id'] == $userRevels[0]['userid']) : ?>
                                <form method="post" action="/BACKEND/delete.inc.php ?>" class="deleteRevelForm">
                                    <input type="hidden" name="revel_id" value="<?php echo $userRevels[0]['revel_id']; ?>">
                                    <input class="button-34" type="submit" name="delete_revel" value="Eliminar Revel">
                                </form>
                                <?php endif; ?>
                            </li>

                    <?php endforeach; ?>
            </div>
        </div>
        <div class="volver">
            <a href="/user/<?php echo urlencode($_SESSION['usuario']); ?>">Volver al Perfil</a>
        </div>
    </div>
</body>

</html>