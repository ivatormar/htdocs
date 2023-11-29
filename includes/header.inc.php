<?php

/**
 * @author Ivan Torres Marcos
 * @version 1.1
 * @description Cabecera de nuestro codigo para mostrar una cosa u otra en función del rol del usuario
 *
 */

$preferredLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

$defaultLanguage = 'en';

// Check if the preferred language is available
if (strpos($preferredLanguage, 'es') !== false) {
    $defaultLanguage = 'es'; // Set the default language to Spanish if available
} elseif (strpos($preferredLanguage, 'val') !== false) {
    $defaultLanguage = 'val'; // Set the default language to Valencian if available
}

$disableFlag = '';
if ($defaultLanguage === 'es') {
    $disableFlag = 'spainFlag';
} elseif ($defaultLanguage === 'en') {
    $disableFlag = 'englishFlag';
} elseif ($defaultLanguage === 'val') {
    $disableFlag = 'valencianFlag';
}

echo '<header>';
echo '<h1><a href="/index">MerchaShop</a></h1>';

echo '<div class="flags">';
echo '<a href="/index?lang=es" class="spainFlag' . ($disableFlag === 'spainFlag' ? ' disabled' : '') . '"><img src="/img/bandera_españa.png" style="width:50px"></a>';
echo '<a href="/index?lang=en" class="englishFlag' . ($disableFlag === 'englishFlag' ? ' disabled' : '') . '"><img src="/img/bandera_inglaterra.jpg" style="width:50px"></a>';
echo '<a href="/index?lang=val" class="valencianFlag' . ($disableFlag === 'valencianFlag' ? ' disabled' : '') . '"><img src="/img/bandera_valencia.png" style="width:50px"></a>';
echo '</div>';

echo '</div>';

// Verificar si el usuario está logueado
if (isset($_SESSION['user'])) {
    // Usuario logueado
    echo 'Bienvenido, ' . $_SESSION['user']['user'];
    // Verificar el rol del usuario
    if (isset($_SESSION['user']['rol']) && $_SESSION['user']['rol'] === 'admin') {
        echo '<br><a href="/users.php">Administrar usuarios</a>';
    }
    echo '<br><a href="/logout.php">Cerrar sesión</a>';
} else {
    // Usuario no logueado
    echo '<a href="/index">Principal</a><br>';

    // Añadir enlaces de registro e inicio de sesión
    echo '<a href="/login.php">Iniciar sesión</a><br>';
    echo '<a href="/signup.php">Registrarse</a>';
}



echo '</header>';
