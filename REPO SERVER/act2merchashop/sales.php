<?php
session_start();

// ... Otras configuraciones ...
include_once(__DIR__.'/includes/dbconnection.inc.php');

try {
    // Verificar si el usuario no está logueado y está intentando acceder a páginas restringidas
    if (!isset($_SESSION['user']) && (basename($_SERVER['REQUEST_URI']) !== 'index.php' && basename($_SERVER['REQUEST_URI']) !== 'sales.php')) {
        header('Location: /login.php'); // Redirigir a la página de inicio de sesión
        exit();
    }

    // Verificar los roles de usuario permitidos para acceder a determinadas páginas
    if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'customer' && basename($_SERVER['REQUEST_URI']) === 'users.php') {
        header('Location: /index.php'); // Redirigir al usuario a la página principal si intenta acceder a users.php
        exit();
    }

    // Obtener productos en oferta
    $connection = getDBConnection();
    $salesProducts = $connection->query('SELECT * FROM products WHERE sale > 0;', PDO::FETCH_OBJ);

} catch (PDOException $e) {
    // Manejar la excepción (puedes mostrar un mensaje de error o redirigir a una página de error)
    echo 'Error en la conexión a la base de datos: ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas - MerchaShop</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php
   include_once(__DIR__.'/includes/header.inc.php'); 
    ?>

    <section class="productos">
        <h2>Ofertas</h2>
        <?php
        foreach($salesProducts as $product) {
            echo '<article class="producto">';
                echo '<h3>'. $product->name .'</h3>';
                echo '<span>('. $product->category .')</span>';
                echo '<img src="/img/products/'. $product->image .'" alt="'. $product->name .'" class="imgProducto"><br>';
                echo '<span>'. $product->price .' €</span><br>';
            echo '</article>';
        }
        ?>
    </section>
</body>
</html>
<?php
// Cerrar la conexión y liberar recursos
$connection = null;
?>
