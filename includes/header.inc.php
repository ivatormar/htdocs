<?php
echo '<header>';
echo '<h1><a href="/index">MerchaShop</a></h1>';

// Verificar si el usuario está logueado
if (isset($_SESSION['user'])) {
    // Usuario logueado
    echo 'Bienvenido, ' . $_SESSION['user']['user'];
     // Verificar el rol del usuario
     if (isset($_SESSION['user']['rol']) && $_SESSION['user']['rol'] === 'admin') {
        echo '<br><a href="/users.php">Administrar usuarios</a>';
    }
    echo '<br><a href="/logout.php">Cerrar sesión</a>';

   
} else {
    // Usuario no logueado
    echo '<a href="/index">Principal</a><br>';
    
    // Añadir enlaces de registro e inicio de sesión
    echo '<a href="/login.php">Iniciar sesión</a><br>';
    echo '<a href="/signup.php">Registrarse</a>';
}

echo '</header>';
?>
