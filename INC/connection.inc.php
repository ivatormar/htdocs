<?php
function connection(string $database, string $user, string $pass, array $options): ?PDO {
    try {
        $dsn = "mysql:host=localhost;dbname=$database;charset=utf8";
        $conexion = new PDO($dsn, $user, $pass, $options);
        // Habilitar el manejo de errores de PDO
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        echo 'Fallo durante la conexión: ' . $e->getMessage();
        return null;
    }
}