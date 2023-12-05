<?php
   /**
    *	Script que implementa un carrito de la compra con variables de sesión
    * En esta nueva versión hemos añadido todas las variables correspondientes para hacer la "internacionalización".
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
      <title>MerchaShop - <?=$lang['cart_heading'] ?></title>
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
            echo $lang['product'];
            if($products>1)
            	echo 's';
            $lang['in_cart']
            ?>
         <a href="/basket" class="boton"><?=$lang['view_cart']?></a>	
      </div>
      <h2><?=$lang['cart_heading'] ?></h2>
      <section>
         <?php
            if(!isset($_SESSION['basket']) || count($_SESSION['basket'])==0)
            	echo '<div>'.$lang['empty_cart'].'</div>';
            else 
            {
            	require_once('includes/dbconnection.inc.php');
            	$connection = getDBConnection();
            
            	$basketTotal = 0;
               
             
            	echo '<table>';
            	echo '<tr><td>'.$lang['product_table'].'</td><td>'.$lang['units'].'</td><td>'.$lang['price'].'</td><td>'.$lang['subtotal'].'</td></tr>';
            	foreach($_SESSION['basket'] as $productId => $quantity) {
            		$product = $connection->query('SELECT name, price FROM products WHERE id='. $productId .';', PDO::FETCH_OBJ);
            		$product = $product->fetch();
                  //Si el idioma de la sesión es el en (inglés), multiplicamos el precio x 0.85 para que se convierta a pounds
                  if ($_SESSION['language'] === 'en') {
                     $product->price*=0.85;
                     
                    }
            		echo '<tr>';
            		echo '<td>'. $product->name .'</td>';
            		echo '<td>'. $quantity .'</td>';
            		echo '<td>'. $product->price .' '.$lang['currency'].' / '.$lang['unit'].' </td>';
            		echo '<td> '. $quantity*$product->price .' '.$lang['currency'].'</td>';
            
            		$basketTotal += $product->price * $quantity;
            		
            		echo '</tr>';
            	}
             
            	//Ponemos la variables $lang['moneda'] para cuando esté en inglés poner el simbolo de pounds
            	echo '<tr><td></td><td></td><td>Total</td><td>'. $basketTotal .' '.$lang['currency'].' </td></tr>';
            	echo '</table>';
            	
            	unset($product);
            	unset($connection);
            }
            ?>
         <br><br>
         <a href="/index" class="boton"><?=$lang['return_cart'] ?></a>				
      </section>
   </body>
</html>