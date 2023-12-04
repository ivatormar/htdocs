<?php
/**
 * @author Ivan Torres Marcos
 * @version 1.2
 * @description En este php lo que hacemos es crear la conexión a nuestra DB de MercaShop
 * y, si no recibe por URL ?product=id , mostraremos todos los productos, sino, el producto
 * con el ID indicado.
 *
 */
try {
    // Conexión a la base de datos
    $connection = new PDO('mysql:dbname=merchashop;host=127.0.0.1', 'Lumos', 'Nox', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    // Verificar si el parámetro 'product' está presente en la URL
        if (isset($_GET['product'])) {
            $productId = $_GET['product'];
            $stmt = $connection->prepare("SELECT id,name, category, price,sale,stock,image FROM products WHERE id = :id");
            $stmt->bindParam(':id', $productId);
        } else {
            // Si 'product' no está presente, obtener todos los productos
            $stmt = $connection->prepare("SELECT * FROM products");
        }
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Generar JSON y mostrarlo
    $jsonString = json_encode($result);
    header('Content-Type: application/json; charset=utf-8');
    echo ($jsonString);
} catch (PDOException $e) {
    // Manejo de errores de la base de datos
    echo 'Error de conexión: ' . $e->getMessage();
}
