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
    echo '<h2>' . $character['name'] . '</h2>';
    echo '<img src="' . $character['image'] . '" alt="' . $character['name'] . '">';
    echo '<p>Especie: ' .$character['species'] . '</p>';
    echo '<p>Estado: ' . $character['status'] . '</p>';
    echo '<p>Género: ' . $character['gender'] . '</p>';
    echo '<p>Origen: ' . $character['origin']['name'] . '</p>'; // Display the origin name
    echo '<p>Ubicación: ' . $character['location']['name'] . '</p>';
    echo '<p>Episodios:</p>';
    echo '<ul>';
    foreach ($character['episode'] as $episode) {
        echo '<li><a href="' . $episode . '">' . $episode . '</a></li>';
    }
    echo '</ul>';
    echo '<p>URL: <a href="' . $character['url'] . '">' . $character['url'] . '</a></p>';
    echo '<p>Creado: ' . $character['created'] . '</p>';
} else {
    echo '<p>No se encontró información para el personaje solicitado.</p>';
}
?>
</body>
</html>