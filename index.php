<!DOCTYPE html>
<html>

<head>
    <title>Rick and Morty Characters</title>
</head>

<body>
    <header>
        <a href="index.php?name=rick">Rick</a>
        <a href="index.php?name=morty">Morty</a>
    </header>

    <form method="GET" action="index.php">
        <input type="text" name="search" placeholder="Buscar personaje">
        <input type="submit" value="Buscar">
    </form>

    <?php
    // Función para hacer una solicitud a la API
    include_once(__DIR__."/includes/makeRequest.inc.php");
    
    // Obtener el nombre del personaje a buscar o filtrar
    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    
    // Construir la URL de la API según la opción seleccionada
    $baseUrl = 'https://rickandmortyapi.com/api/character/';
    $url = $baseUrl;
    if ($name === 'rick' || $name === 'morty') {
        $url .= '?name=' . $name;
    
        // Array para almacenar todos los personajes
        $allCharacters = array();
    
        // Hacer solicitudes a la API hasta que no haya más páginas de resultados
        $page = 1;
        do {
            $response = makeRequest($url . '&page=' . $page);
            $data = json_decode($response, true);
    
            if (isset($data['results'])) {
                $characters = $data['results'];
    
                // Agregar los personajes a la lista
                $allCharacters = array_merge($allCharacters, $characters);
    
                // Incrementar el número de página
                $page++;
            } else {
                break;
            }
        } while (!empty($data['info']['next']));
    
        // Mostrar los resultados
        if (!empty($allCharacters)) {
            echo '<h2>Resultados:</h2>';
            foreach ($allCharacters as $character) {
                $id = $character['id'];
                $name = $character['name'];
                $image = $character['image'];
                echo '<a href="character.php?id=' . $id . '">';
                echo '<h3>' . $name . '</h3>';
                echo '<img src="' . $image . '" alt="' . $name . '">';
                echo '</a>';
            }
        } else {
            echo '<p>No se encontraron resultados para ' . $name . '</p>';
        }
    } elseif (!empty($search)) {
        // Construir la URL de la API para realizar la búsqueda
        $url .= '?name=' . urlencode($search);
    
        // Array para almacenar todos los personajes
        $allCharacters = array();
    
        // Hacer solicitudes a la API hasta que no haya más páginas de resultados
        $page = 1;
        do {
            $response = makeRequest($url . '&page=' . $page);
            $data = json_decode($response, true);
    
            if (isset($data['results'])) {
                $characters = $data['results'];
    
                // Agregar los personajes a la lista
                $allCharacters = array_merge($allCharacters, $characters);
    
                // Incrementar el número de página
                $page++;
            } else {
                break;
            }
        } while (!empty($data['info']['next']));
    
        // Mostrar los resultados
        if (!empty($allCharacters)) {
            echo '<h2>Resultados:</h2>';
            foreach ($allCharacters as $character) {
                $id = $character['id'];
                $name = $character['name'];
                $image = $character['image'];
                echo '<a href="character.php?id=' . $id . '">';
                echo '<h3>' . $name . '</h3>';
                echo '<img src="' . $image . '" alt="' . $name . '">';
                echo '</a>';
            }
        } else {
            echo '<p>No se encontraron resultados para ' . $search . '</p>';
        }
    }
    ?>
</body>

</html>