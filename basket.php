<?php
   /**
    *	Script que implementa un carrito de la compra con variables de sesión
    * 
    *	@author Álex Torres
    */
   session_start();
   require_once(__DIR__ . '/includes/language_utils.inc.php');

   
   if(isset($_GET['add']) || isset($_GET['subtract']) || isset($_GET['remove'])) {
   	if(isset($_GET['add']) && $_GET['add']!='') {
   		if(!isset($_SESSION['basket'][$_GET['add']]))
   			$_SESSION['basket'][$_GET['add']] = 1;
   		else
   			$_SESSION['basket'][$_GET['add']] += 1;
   	}
   	if(isset($_GET['subtract']) && $_GET['subtract']!='' && isset($_SESSION['basket'][$_GET['subtract']])) {
   		$_SESSION['basket'][$_GET['subtract']] -= 1;
   		if($_SESSION['basket'][$_GET['subtract']]<=0)
   			unset($_SESSION['basket'][$_GET['subtract']]);
   	}
   	if(isset($_GET['remove']) && $_GET['remove']!='' && isset($_SESSION['basket'][$_GET['remove']])) {
   		unset($_SESSION['basket'][$_GET['remove']]);
   	}
   
   	
   }
?>
<!doctype html>
<html lang="es">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>MerchaShop - <?=$lang['h2Carrito'] ?></title>
      <link rel="stylesheet" href="/css/style.css">
   </head>
   <body>
      <?php
         require_once('includes/header.inc.php');
         ?>
      <div id="carrito">
         <?php
            if(!isset($_SESSION['basket']))
            	$products = 0;
            else
            	$products = count($_SESSION['basket']);
            echo $products;
            echo $lang['producto'];
            if($products>1)
            	echo 's';
            $lang['carrito']
            ?>
         <a href="/basket" class="boton"><?=$lang['ver']?></a>	
      </div>
      <h2><?=$lang['h2Carrito'] ?></h2>
      <section>
         <?php
            if(!isset($_SESSION['basket']) || count($_SESSION['basket'])==0)
            	echo '<div>'.$lang['carritoVacio'].'</div>';
            else 
            {
            	require_once('includes/dbconnection.inc.php');
            	$connection = getDBConnection();
            
            	$basketTotal = 0;
               if ($_SESSION['language'] === 'en') {
                  // Convert the basket total to pounds
                  $basketTotal *= 0.85; // Assuming 1 Euro is equal to 0.85 pounds
              }
             
            	echo '<table>';
            	echo '<tr><td>'.$lang['tablaProducto'].'</td><td>'.$lang['unidades'].'</td><td>'.$lang['precio'].'</td><td>'.$lang['subtotal'].'</td></tr>';
            	foreach($_SESSION['basket'] as $productId => $quantity) {
            		$product = $connection->query('SELECT name, price FROM products WHERE id='. $productId .';', PDO::FETCH_OBJ);
            		$product = $product->fetch();
                  if ($_SESSION['language'] === 'en') {
                     $product->price*=0.85;
                     
                    }
            		echo '<tr>';
            		echo '<td>'. $product->name .'</td>';
            		echo '<td>'. $quantity .'</td>';
            		echo '<td>'. $product->price .' '.$lang['moneda'].' / '.$lang['unidad'].' </td>';
            		echo '<td> '. $quantity*$product->price .' '.$lang['moneda'].'</td>';
            
            		$basketTotal += $product->price * $quantity;
            		
            		echo '</tr>';
            	}
             
            	
            	echo '<tr><td></td><td></td><td>Total</td><td>'. $basketTotal .' '.$lang['moneda'].' </td></tr>';
            	echo '</table>';
            	
            	unset($product);
            	unset($connection);
            }
            ?>
         <br><br>
         <a href="/index" class="boton"><?=$lang['volverCarrito'] ?></a>				
      </section>
   </body>
</html>