<?php
session_start();

include_once('../INC/connection.inc.php');

$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = connection('revels', 'revel', 'lever', $utf8);

if ($conexion->errorCode() != PDO::ERR_NONE) {
    echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
    exit;
}

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
        $stmtDeleteRevel->bindParam(':userID', $_SESSION['user_id']);
        $stmtDeleteRevel->execute();

        // Confirmar la transacción si todo ha ido bien
        $conexion->commit();

        // Redirigir o realizar otras acciones después de la eliminación
        header('Location: /user/' . urlencode($_SESSION['usuario']));
        exit();
    } catch (PDOException $e) {
        // Revertir la transacción si algo salió mal
        $conexion->rollBack();

        // Manejar el error como desees
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // Manejar el caso en el que no se ha enviado la solicitud adecuada o falta el parámetro necesario
    echo 'Acceso no permitido.';
    exit;
}
?>
