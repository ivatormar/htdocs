<?php

/**
 * @author Alex Torres 
 * @version 1.1
 * @description Indice donde mostramos y añadimos la funcionalidad de los productos.
 * En esta nueva versión hemos añadido todas las variables correspondientes para hacer la "internacionalización".
 */
session_start();
require_once(__DIR__.'/includes/language_utils.inc.php');


// Verificar si hay un mensaje de éxito en la sesión, esto es para cuando venimos del resetPassword.php
if (isset($_SESSION['success'])) {
   echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
   // Eliminar el mensaje de éxito para que no se muestre en futuras visitas
   unset($_SESSION['success']);
}

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
         <!-- Replace static content with translations -->
         <h2><?= $lang['register']; ?></h2>
         <label for="username"><?= $lang['user']; ?>:</label>
         <input type="text" id="username" name="username">
         <label for="email"><?= $lang['email']; ?>:</label>
         <input type="text" id="email" name="email">
         <label for="password"><?= $lang['password']; ?>:</label>
         <input type="text" id="password" name="password">
         <button type="submit"><?= $lang['sign_up']; ?></button>
         <p><?= $lang['have_account']; ?> <a href="/login.php"><?= $lang['login']; ?></a>.</p>

      </section>
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
         echo $lang['product'];
         if ($products > 1)
            echo 's';
            echo $lang['in_cart'];
         ?>
         
         <a href="/basket" class="boton"><?= $lang['view_cart']?></a>
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

</html>