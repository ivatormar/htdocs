<?php
   /**
    *	Script que implementa un carrito de la compra con variables de sesión
    * 
    *	@author Álex Torres
    */
   session_start();
   
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
      <title>MerchaShop - carrito</title>
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
            echo ' producto';
            if($products>1)
            	echo 's';
            ?>
         en el carrito.
         <a href="/basket" class="boton">Ver carrito</a>	
      </div>
      <h2>Carrito</h2>
      <section>
         <?php
            if(!isset($_SESSION['basket']) || count($_SESSION['basket'])==0)
            	echo '<div>El carrito está vacío.</div>';
            else 
            {
            	require_once('includes/dbconnection.inc.php');
            	$connection = getDBConnection();
            
            	$basketTotal = 0;
            
            	echo '<table>';
            	echo '<tr><td>Producto</td><td>Unidades</td><td>Precio</td><td>Subtotal</td></tr>';
            	foreach($_SESSION['basket'] as $productId => $quantity) {
            		$product = $connection->query('SELECT name, price FROM products WHERE id='. $productId .';', PDO::FETCH_OBJ);
            		$product = $product->fetch();
            		echo '<tr>';
            		echo '<td>'. $product->name .'</td>';
            		echo '<td>'. $quantity .'</td>';
            		echo '<td>'. $product->price .' €/unidad</td>';
            		echo '<td>'. $quantity*$product->price .' €</td>';
            
            		$basketTotal += $product->price * $quantity;
            		
            		echo '</tr>';
            	}
            	
            	echo '<tr><td></td><td></td><td>Total</td><td>'. $basketTotal .' €</td></tr>';
            	echo '</table>';
            	
            	unset($product);
            	unset($connection);
            }
            ?>
         <br><br>
         <a href="/index" class="boton">Volver</a>				
      </section>
   </body>
</html>