<?php
<<<<<<< HEAD
   session_start();
   include_once(__DIR__ . '/INC/connection.inc.php');
   $login = false;
   $registration_successful = false;
   
   if (isset($_SESSION['user_id'])) {
       // El usuario está logueado
       $login = true;
   }
   
   $utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
   $conexion = connection('revels', 'revel', 'lever', $utf8);
   if ($conexion->errorCode() != PDO::ERR_NONE) {
       echo 'Error al conectar a la base de datos: ' . $conexion->errorInfo()[2];
       exit;
   }
?>
<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
      <title>REVELS</title>
   </head>
   <?php
      if ($login === true) {
          include_once(__DIR__ . '/INC/tablon.inc.php');
      } else {
          include_once(__DIR__ . '/INC/register.inc.php');
      }
    ?>
   </body>
=======
session_start();






// Lógica para manejar la actualización del carrito
if (isset($_GET['add']) || isset($_GET['subtract']) || isset($_GET['remove'])) {
    if (isset($_GET['add']) && $_GET['add'] != '') {
        if (!isset($_SESSION['basket'][$_GET['add']]))
            $_SESSION['basket'][$_GET['add']] = 1;
        else
            $_SESSION['basket'][$_GET['add']] += 1;
    }
    if (isset($_GET['subtract']) && $_GET['subtract'] != '' && isset($_SESSION['basket'][$_GET['subtract']])) {
        $_SESSION['basket'][$_GET['subtract']] -= 1;
        if ($_SESSION['basket'][$_GET['subtract']] <= 0)
            unset($_SESSION['basket'][$_GET['subtract']]);
    }
    if (isset($_GET['remove']) && $_GET['remove'] != '' && isset($_SESSION['basket'][$_GET['remove']])) {
        unset($_SESSION['basket'][$_GET['remove']]);
    }
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
    if (!isset($_SESSION['user'])) : ?>
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
                <img id="sales_image" src="/img/sales_image.png" alt="Ofertas">
            </a>
        </section>
    <?php else : ?>
        <!-- Mostrar lista de productos para usuarios logueados -->
        <div id="carrito">
            <?php
            if (!isset($_SESSION['basket']))
                $products = 0;
            else
                $products = count($_SESSION['basket']);
            echo $products;
            echo ' producto';
            if ($products > 1)
                echo 's';
            ?>
            en el carrito.
            <a href="/basket" class="boton">Ver carrito</a>
        </div>

        <section class="productos">
            <?php
            include_once(__DIR__ . '/includes/dbconnection.inc.php');
            $connection = getDBConnection();
            $products = $connection->query('SELECT * FROM products;', PDO::FETCH_OBJ);

            ?>
            <section class="sales-link"><br>
                <a href="/sales.php">
                    <img id="sales_image" src="/img/sales_image.png" alt="Ofertas">
                </a>
            </section>

            <?php
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

>>>>>>> 6525240ea77e5304f6b51e58726c22fe585fcb76
</html>