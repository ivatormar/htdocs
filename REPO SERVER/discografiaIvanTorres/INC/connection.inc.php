<?php

function connection(string $database, string $user, string $pass, array $options): PDO {
    try {
        $dsn = "mysql:host=localhost;dbname=$database;charset=utf8";
        $conexion = new PDO($dsn, $user, $pass, $options);
        return $conexion;
    } catch (PDOException $e) {
        print 'Fallo durante la conexión: ' . $e->getMessage();
        return null;
    }
}