<?php 
$userId = $_SESSION['user_id'];

// Consultar a los usuarios que sigue el usuario actual
$stmt = $conexion->prepare('SELECT u.id, u.usuario
                            FROM users u
                            INNER JOIN follows f ON u.id = f.userfollowed
                            WHERE f.userid = :userId');
$stmt->bindParam(':userId', $userId);

if ($stmt->execute()) {
    $usuariosSeguidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}else{
    echo 'Error al ejecutar la consulta';
}
?>

<aside class="sidebar">
    <div class="followedUsers">
        <h2>Usuarios que sigues</h2>
        <ul>
            <?php foreach ($usuariosSeguidos as $usuario) : ?>
                <li><a href="/user.php?usuario=<?php echo $usuario['usuario']; ?>"><i class='bx bx-user'></i><?php echo htmlspecialchars($usuario['usuario']); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>