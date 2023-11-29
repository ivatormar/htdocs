<?php

/**
 * @author Alex Torres 
 * @version 1.0
 * @description Indice donde mostramos y añadimos la funcionalidad de los productos
 *
 */


session_start();
if (isset($_GET['lang'])) {
   // Validate and set the language based on the parameter
   $allowedLanguages = ['es', 'val', 'en'];
   $selectedLanguage = $_GET['lang'];

   if (in_array($selectedLanguage, $allowedLanguages)) {
      $_SESSION['language'] = $selectedLanguage;

      // Set a cookie to remember the selected language
      setcookie('preferred_language', $selectedLanguage, time() + (365 * 24 * 60 * 60), '/');
   }
} elseif (isset($_COOKIE['preferred_language'])) {
   // Use the language stored in the cookie
   $_SESSION['language'] = $_COOKIE['preferred_language'];
}

// Include the language file based on the selected language or use the default language
$language = isset($_SESSION['language']) ? $_SESSION['language'] : 'en'; // Default to English if no language is set

// Load the appropriate language file
switch ($language) {
   case 'es':
      require_once(__DIR__ . '/includes/es_ES.lang.php');
      break;
   case 'en':
      require_once(__DIR__ . '/includes/en_EN.inc.php');
      break;
   case 'val':
      require_once(__DIR__ . '/includes/ca_CA.inc.php');
      break;
   default:
      // Fallback to English if the language is not recognized
      require_once(__DIR__ . '/includes/en_EN.inc.php');
}

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
         <h2><?php echo $lang['registro']; ?></h2>
         <label for="username"><?php echo $lang['usuario']; ?>:</label>
         <label for="email"><?php echo $lang['correo']; ?>:</label>
         <label for="password"><?php echo $lang['contraseña']; ?>:</label>
         <button type="submit"><?php echo $lang['registrarse']; ?></button>
         <p><?php echo $lang['cuenta']; ?> <a href="/login.php"><?php echo $lang['iniciar_sesion']; ?></a>.</p>

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

</html>