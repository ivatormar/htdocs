<?php

/**
 * @author Ivan Torres Marcos
 * @version 1.1
 * @description Cabecera de nuestro codigo para mostrar una cosa u otra en función del rol del usuario.
 * En esta nueva versión hemos añadido todas las variables correspondientes para hacer la "internacionalización".
 *
 */


$preferredLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$languages = ['es', 'en', 'val'];
$defaultLanguage = 'es';

// Comprobamos si el "preferred language" está disponible
if (strpos($preferredLanguage, 'es') !== false) {
    $defaultLanguage = 'es'; // Seteamos el 'es' sino está 
} elseif (strpos($preferredLanguage, 'val') !== false) {
    $defaultLanguage = 'val'; // y sino, el valenciano
}
require_once(__DIR__ . '/language_utils.inc.php');

echo '<header>';
    echo '<h1><a href="/index">MerchaShop</a></h1>';
        echo '<div class="flags">';
            foreach ($languages as $language) {
                $class = isLanguageSet($language) ? 'flagDisabled' : '';
                $image = '/img/bandera_' . $language . '.png';
                $url = $_SERVER['PHP_SELF'] . '?lang=' . $language;
                echo '<a href="' . $url . '" class="' . $class . '"><img src="' . $image . '" style="width:50px"></a>';
            }
        echo '</div>';

// Verificar si el usuario está logueado
if (isset($_SESSION['user'])) {
    // Usuario logueado
    echo $lang['welcome'] . ', ' . $_SESSION['user']['user'];

    // Verificar el rol del usuario
    if (isset($_SESSION['user']['rol']) && $_SESSION['user']['rol'] === 'admin') {
        echo '<br><a href="/users.php">' . $lang['manage_users'] . '</a>';
    }

    echo '<br><a href="/logout.php">' . $lang['logout'] . '</a>';
} else {
    // Usuario no logueado
    echo '<a href="/index">' . $lang['main'] . '</a><br>';

    // Añadir enlaces de registro e inicio de sesión
    echo '<a href="/login.php">' . $lang['login'] . '</a><br>';
    echo '<a href="/signup.php">' . $lang['sign_up'] . '</a>';
}
echo '</header>';
