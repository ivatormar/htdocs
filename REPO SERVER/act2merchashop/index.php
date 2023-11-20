<?php
session_start();

// Verificar si el usuario no está logueado y está intentando acceder a páginas restringidas
if (!isset($_SESSION['user']) && ($_SERVER['REQUEST_URI'] !== '/index.php' && $_SERVER['REQUEST_URI'] !== '/sales.php')) {
    header('Location: /login.php'); // Redirigir a la página de inicio de sesión
    exit();
}

// Verificar los roles de usuario permitidos para acceder a determinadas páginas
if (isset($_SESSION['user']) && isset($_SESSION['user']['rol']) && $_SESSION['user']['rol'] === 'customer' && $_SERVER['REQUEST_URI'] === '/users.php') {

    header('Location: /index.php'); // Redirigir al usuario a la página principal si intenta acceder a users.php
    exit();
}

// Lógica para manejar la actualización del carrito
if (isset($_GET['add']) || isset($_GET['subtract']) || isset($_GET['remove'])) {
    // ... (mantén esta parte igual)
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MerchaShop</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php
    require_once(__DIR__ . '/includes/header.inc.php');
    ?>

    <?php if (!isset($_SESSION['user'])) : ?>
        <!-- Mostrar formulario de registro para usuarios no logueados -->
        <section class="registro">
            <h2>Registro</h2>
            <form action="/signup.php" method="post">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>

                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Registrarse</button>
            </form>
            <p>¿Ya tienes una cuenta? <a href="/login.php">Inicia sesión aquí</a>.</p>
        </section>

        <!-- Enlace a sales.php -->
        <section class="sales-link">
            <a href="/sales.php">
                <img src="/img/sales_image.jpg" alt="Ofertas">
            </a>
        </section>
    <?php else : ?>
        <!-- Mostrar lista de productos para usuarios logueados -->
        <div id="carrito">
            <?php
            if (!isset($_SESSION['basket'])) {
                $productsInBasket = 0;
            } else {
                $productsInBasket = count($_SESSION['basket']);
            }
            echo $productsInBasket;
            echo ' producto';
            if ($productsInBasket !== 1) {
                echo 's';
            }
            ?>
            en el carrito.
            <a href="/basket" class="boton">Ver carrito</a>
        </div>

        <section class="productos">
            <?php
            include_once(__DIR__.'/includes/dbconnection.inc.php'); 
            $connection = getDBConnection();
            $products = $connection->query('SELECT * FROM products;', PDO::FETCH_OBJ);

            foreach ($products as $product) {
                echo '<article class="producto">';
                echo '<h2>' . $product->name . '</h2>';
                echo '<span>(' . $product->category . ')</span>';
                echo '<img src="/img/products/' . $product->image . '" alt="' . $product->name . '" class="imgProducto"><br>';
                echo '<span>' . $product->price . ' €</span><br>';
                echo '<span class="botonesCarrito">';
                echo '<a href="/add/' . $product->id . '" class="productos"><img src="/img/mas.png" alt="añadir 1"></a>';
                echo '<a href="/subtract/' . $product->id . '" class="productos"><img src="/img/menos.png" alt="quitar 1"></a>';
                echo '<a href="/remove/' . $product->id . '" class="productos"><img src="/img/papelera.png" alt="quitar todos"></a>';
                echo '</span>';
                echo '<span>Stock: ' . $product->stock . '</span>';
                echo '</article>';
            }

            unset($products);
            unset($connection);
            ?>
        </section>
    <?php endif; ?>
</body>
</html>
