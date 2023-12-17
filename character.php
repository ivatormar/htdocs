<?php
    /**
     * @author Ivan Torres Marcos
     * @version 1.4
     * @description Character.php el cual permite obtener los detalles de cada personaje buscado,
     * o simplemente de Rick o Morty.
     *
     */
    include_once(__DIR__."/INCLUDES/commonHTML.inc.php");
    include_once(__DIR__ . "/INCLUDES/makeRequest.inc.php");

    // Obtener el ID del personaje desde el parámetro de la URL
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    // Construir la URL de la API para obtener los detalles del personaje
    $url = 'https://rickandmortyapi.com/api/character/' . $id;

    // Hacer la solicitud a la API y obtener los detalles del personaje
    $response = makeRequest($url);
    $character = json_decode($response, true);

    // Mostrar los detalles del personaje
    if (!empty($character)) {
        echo'<div class="characterDiv">';
        echo'<div class="nameImg">';
        echo '<h2>' . $character['name'] . '</h2>';
        echo '<img src="' . $character['image'] . '" alt="' . $character['name'] . '">';
        echo '</div>';
        echo '<div class="info">';
        echo '<div class="infoPlus">';
        echo '<p>Especie: ' . $character['species'] . '</p>';
        echo '<p>Estado: ' . $character['status'] . '</p>';
        echo '<p>Género: ' . $character['gender'] . '</p>';
        echo '<p>Origen: ' . $character['origin']['name'] . '</p>'; // Display the origin name
        echo '<p>Ubicación: ' . $character['location']['name'] . '</p>';
        echo '</div>';
        echo '<div class="infoPlus">';
        echo '<p>Episodios:</p>';
        echo '</div>';
        echo '<div class="episodeList" id="scrollbar">';
        echo '<ul>';
        foreach ($character['episode'] as $episode) {
            echo '<li><a href="' . $episode . '">' . $episode . '</a></li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '<div class="infoPlus">';
        echo '<p>URL: <a href="' . $character['url'] . '">' . $character['url'] . '</a></p>';
        echo '<p>Creado: ' . $character['created'] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p>No se encontró información para el personaje solicitado.</p>';
    }
    ?>
</body>

</html>