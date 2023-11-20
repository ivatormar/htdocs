<?php
include_once(__DIR__.'/includes/dbconnection.inc.php');
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];

    // Validar la contraseña y realizar otras validaciones necesarias
    if (strlen($newPassword) < 8) {
        echo "La contraseña debe tener al menos 8 caracteres.";
        exit;
    }

    // Hashear la nueva contraseña
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Actualizar la contraseña en la tabla "users"
    $conn = getDBConnection();

    // Preparar la consulta SQL
    $sql = "UPDATE users SET password = :password WHERE email = :email";
    $stmt = $conn->prepare($sql);

    // Asignar los valores de los parámetros
    $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "¡Contraseña actualizada correctamente!";
    } else {
        echo "Error al actualizar la contraseña.";
    }

    // Eliminar el registro de recuperación de contraseña en la tabla "passwordrecovery"
    $sql = "DELETE FROM passwordrecovery WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo "Registro de recuperación de contraseña eliminado.";
    } else {
        echo "Error al eliminar el registro de recuperación de contraseña.";
    }

    // Cerrar la conexión
    $conn = null;
    exit;
} else {
    // Obtener el token y el correo electrónico de la URL
    $token = $_GET['token'];
    $email = $_GET['email'];

    // Verificar si el token y el correo electrónico son válidos y existen en la base de datos
    $conn = getDBConnection();

    // Preparar la consulta SQL
    $sql = "SELECT * FROM passwordrecovery WHERE email = :email AND token = :token";
    $stmt = $conn->prepare($sql);

    // Asignar los valores de los parámetros
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);

    // Ejecutar la consulta
    $stmt->execute();

    // Verificar si se encontró un registro con el token y el correo electrónico proporcionados
    if ($stmt->rowCount() === 0) {
        echo "Token o correo electrónico inválido.";
        $conn = null;
        exit;
    }

    // Mostrar formulario para ingresar la nueva contraseña
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Reestablecer contraseña</title>
    </head>
    <body>
        <h2>Reestablecer contraseña</h2>
        <form method="post" action="resetPassword.php">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <label for="new_password">Nueva contraseña:</label>
            <input type="password" name="new_password" id="new_password" required>
            <br>
            <input type="submit" value="Guardar contraseña">
        </form>
    </body>
    </html>
    <?php

    // Cerrar la conexión
    $conn = null;
    exit;
}
?>