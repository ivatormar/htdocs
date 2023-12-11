<!DOCTYPE html>
<html>
<head>
    <title>Información del Personaje</title>
</head>
<body>
    <header>
        <a href="index.php?name=rick">Ricky</a>
        <a href="index.php?name=morty">Morty</a>
    </header>

    <form method="GET" action="index.php">
        <input type="text" name="search" placeholder="Buscar personaje">
        <input type="submit" value="Buscar">
    </form>

    <?php
// Función para hacer una solicitud a la API
include_once(__DIR__."/includes/makeRequest.inc.php");

// Obtener el ID del personaje desde el parámetro de la URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Construir la URL de la API para obtener los detalles del personaje
$url = 'https://rickandmortyapi.com/api/character/' . $id;

// Hacer la solicitud a la API y obtener los detalles del personaje
$response = makeRequest($url);
$character = json_decode($response, true);

// Mostrar los detalles del personaje
if (!empty($character)) {
    $name = $character['name'];
    $image = $character['image'];
    $species = $character['species'];
    $status = $character['status'];
    
    echo '<h2>' . $name . '</h2>';
    echo '<img src="' . $image . '" alt="' . $name . '">';
    echo '<p>Especie: ' . $species . '</p>';
    echo '<p>Estado: ' . $status . '</p>';
} else {
    echo '<p>No se encontró información para el personaje solicitado.</p>';
}
?>
</body>
</html>