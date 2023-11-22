<?php
/**
 * @author Alex Torres 
 * @version 1.0
 * @description Función para establecer la conexión en la base de datos
 *
 */
function getDBConnection() {
    $dsn = 'mysql:dbname=merchashop;host=127.0.0.1';
    $user = 'Lumos';
    $pass = 'Nox';
    return new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}