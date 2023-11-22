<!-- eliminará la revelación cuyo id reciba, todos los comentarios y votos de esta y redirigirá
a la página list del usuario. -->


<?php
session_start();
include_once('INC/connection.inc.php');


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
?>