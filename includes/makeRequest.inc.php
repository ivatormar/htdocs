<?php
/**
 * @author Ivan Torres Marcos
 * @version 1.2
 * @description Función para realizar las peticiones a la API mediante file_get_contents
 *
 */
function makeRequest($url) {
//Con el operador @ conseguiimos suprimir/manejamos los mensajes de error que provengan de file_get_contents
// con tal de mostrar lo que queramos, ya que de lo contrario mostrariamos todo esto
// Warning: file_get_contents(https://rickandmortyapi.com/api/character/?name=asd&page=1): Failed to open stream: HTTP request failed! HTTP/1.1 404 Not Found in C:\xampp\htdocs\includes\makeRequest.inc.php on line 3
 
// Verifica si la URL existe antes de intentar obtener su contenido
 if (!file_exists($url)) {
    // Aquí puedes manejar el error si lo deseas
    echo 'La URL no existe';
    return false;
}    

$response = @file_get_contents($url);

    if ($response === false) {
        echo 'El nombre no existe, por lo que: ';
        return false;
    }

    return $response;
}
