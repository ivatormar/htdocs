<?php
/**
 * @author Ivan Torres Marcos
 * @version 1.2
 * @description En este php lo que hacemos es crear la conexión a nuestra DB de Pokemon
 * y, si no recibe por URL no mostrará nada ,si pasamos por URL localhost:8080/api/pokemon/$id 
 * mostraremos (Nombre, peso, altura y estadísticas base del pokemon con la id recibida.), sino, 
 * localhost:8080/api/pokemon mostraremos (numero_pokedex y nombre de todos los pokemon de la base de datos.),sino,
 * localhost:8080/api/type mostraremos (id_tipo y nombre de todos los tipos de pokemon de la base de datos.),sino
 * con el ID indicado.
 *
 */
try {
    // Conexión a la base de datos
    $connection = new PDO('mysql:dbname=pokemon;host=127.0.0.1', 'Ash', 'pikachu', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    
    // Inicializar $stmt, sino la inicializo me salta un error de que no se encuentra la variable
    $stmt = null;

    // Verificar si el parámetro '/api/pokemon/id' está presente en la URL
    if (isset($_GET['/api/pokemon/id'])) {
        $stmt = $connection->prepare("SELECT nombre,peso,altura,ps,ataque,defensa,especial,velocidad FROM pokemon p, estadisticas_base e WHERE p.numero_pokedex = :numero_pokedex AND p.numero_pokedex=e.numero_pokedex");
        $stmt->bindParam(':numero_pokedex', $_GET['/api/pokemon/id']);

    // Verificar si el parámetro '/api/type' está presente en la URL
    } else if(isset($_GET['/api/type'])){
        $stmt = $connection->prepare("SELECT id_tipo,nombre FROM tipo");

    // Verificar si el parámetro '/api/pokemon' está presente en la URL
    } else if(isset($_GET['/api/pokemon'])){
        $stmt = $connection->prepare("SELECT numero_pokedex,nombre FROM pokemon");
        
    // Verificar si el parámetro '/api/type/id' está presente en la URL
    } else if(isset($_GET['/api/type/id'])){
        $stmt = $connection->prepare("SELECT t.nombre,p.nombre,p.numero_pokedex FROM pokemon p, pokemon_tipo pt, tipo t WHERE t.id_tipo = :id_tipo AND p.numero_pokedex=pt.numero_pokedex AND pt.id_tipo=t.id_tipo");
        $stmt->bindParam(':id_tipo', $_GET['/api/type/id']);
    } else {
        $data = array(
            'API' => 'Pokemon API - Ivan Torres',
            'Endpoints' => array(
                '/api/pokemon/id',
                '/api/type',
                '/api/pokemon',
                '/api/type/id'
            )
            );
            $jsonString=json_encode($data);
            header('Content-Type: application/json; charset=utf-8');
            echo ($jsonString);
        }

    // Verificar si $stmt no es null antes de ejecutar
    if ($stmt) {
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Generar JSON y mostrarlo
        $jsonString = json_encode($result);
        header('Content-Type: application/json; charset=utf-8');
        echo ($jsonString);
    }

} catch (PDOException $e) {
    // Manejo de errores de la base de datos
    echo 'Error de conexión: ' . $e->getMessage();
}
