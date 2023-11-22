<!-- cancel: si no recibe datos mostrará un formulario con un aviso de confirmación de eliminación
de la cuenta con un checkbox y un botón para aceptar. Si se pulsa el botón de aceptar se
enviarán los datos a la propia página. Si se reciben los datos del formulario de confirmación se
eliminará al usuario, sus Revels y los comentarios a estas y se cerrará la sesión y redirigirá a la  -->


<?php
session_start();
include_once(__DIR__ . '/INC/connection.inc.php');
$checkboxValue = isset($_POST['confirm_checkbox']) ? $_POST['confirm_checkbox'] : false;

if ($checkboxValue) {
    try {
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
        $conexion->rollBack();

        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo "Debes marcar la casilla de confirmación para eliminar la cuenta.";
}
?>