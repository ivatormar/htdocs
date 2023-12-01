<?php

/**
 * @author Ivan Torres Marcos
 * @version 1.1
 * @description Cabecera de nuestro codigo para mostrar una cosa u otra en función del rol del usuario
 *
 */


$preferredLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

$defaultLanguage = 'es';

// Check if the preferred language is available
if (strpos($preferredLanguage, 'es') !== false) {
    $defaultLanguage = 'es'; // Set the default language to Spanish if available
} elseif (strpos($preferredLanguage, 'val') !== false) {
    $defaultLanguage = 'val'; // Set the default language to Valencian if available
}



require_once(__DIR__.'/language_utils.inc.php');

echo '<header>';
echo '<h1><a href="/index">MerchaShop</a></h1>';



echo '<div class="flags">';
echo '<a href="'.  $_SERVER['PHP_SELF'] .'?lang=es" class="' . (isLanguageSet('es') ? 'flagDisabled' : '') . '"><img src="/img/bandera_españa.png" style="width:50px"></a>';
echo '<a href="'.  $_SERVER['PHP_SELF'] .'?lang=en" class="' . (isLanguageSet('en') ? 'flagDisabled' : '') . '"><img src="/img/bandera_inglaterra.jpg" style="width:50px"></a>';
echo '<a href="'.  $_SERVER['PHP_SELF'] .'?lang=val" class="' . (isLanguageSet('val') ? 'flagDisabled' : '') . '"><img src="/img/bandera_valencia.png" style="width:50px"></a>';
echo '</div>';




echo '</div>';

// Verificar si el usuario está logueado
if (isset($_SESSION['user'])) {
    // Usuario logueado
    echo $lang['bienvenido'] . ', ' . $_SESSION['user']['user'];

    // Verificar el rol del usuario
    if (isset($_SESSION['user']['rol']) && $_SESSION['user']['rol'] === 'admin') {
        echo '<br><a href="/users.php">' . $lang['administrar_usuarios'] . '</a>';
    }

    echo '<br><a href="/logout.php">' . $lang['cerrar_sesion'] . '</a>';
} else {
    // Usuario no logueado
    echo '<a href="/index">' . $lang['principal'] . '</a><br>';

    // Añadir enlaces de registro e inicio de sesión
    echo '<a href="/login.php">' . $lang['iniciar_sesion'] . '</a><br>';
    echo '<a href="/signup.php">' . $lang['registrarse'] . '</a>';
}


echo '</header>';
