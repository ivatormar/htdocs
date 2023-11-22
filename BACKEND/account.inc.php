<!-- account: si no recibe datos mostrará un formulario cumplimentado con los datos del usuario
para poder modificarlos. Si recibe datos de dicho formulario los almacenará. También mostrará
un enlace a list y un enlace a cancel. -->
<?php
session_start();
include_once(__DIR__ . '/INC/connection.inc.php');
$newUsername = $_POST['new_username'];
$newEmail = $_POST['new_email'];
$stmtUpdate = $conexion->prepare('UPDATE users SET usuario = :newUsername, email = :newEmail WHERE id = :userID');
$stmtUpdate->bindParam(':newUsername', $newUsername);
$stmtUpdate->bindParam(':newEmail', $newEmail);
$stmtUpdate->bindParam(':userID', $_SESSION['user_id']);
$stmtUpdate->execute();
$_SESSION['usuario'] = $newUsername;

header('Location: /user/' . urlencode($newUsername));
exit();
?>