<?php
/**
 * @author Ivan Torres Marcos
 * @version 1.2
 * @description Php en el que comprobamos el lenguaje "seteado", lo "seteamos", cargamos el "language" correspondiente, y finalmente
 * llamamos a las funciones.
 *
 */



// Definimos los idiomas disponibles
$availableLanguages = ['es', 'val', 'en'];

//Función para comprobar que lenguaje está "puesto".
function isLanguageSet($language)
{
    return isset($_SESSION['language']) && $_SESSION['language'] === $language;
}


//Función para "poner" el lenguaje creando la cookie o cogiendo el 'lang' de la sesión del usuario, o en su defecto, si no
// hay cookie alguna loseteamos a 'es'
function setLanguage()
{
    //Utilizamos global para poder coger los $availableLanguages previos
    global $availableLanguages;

    // Comprobamos si el lenguaje está en la sesión
    if (isset($_GET['lang']) && in_array($_GET['lang'], $availableLanguages)) {
        if (!isLanguageSet($_GET['lang'])) {
            $_SESSION['language'] = $_GET['lang'];

            // "Seteamos" la cookie para recordar que lenguaje tenemos
            setcookie('preferred_language', $_GET['lang'], time() + (365 * 24 * 60 * 60), '/');
            header('Location:' . $_SERVER['PHP_SELF']);
            exit;
        }
    } elseif (isset($_COOKIE['preferred_language']) && in_array($_COOKIE['preferred_language'], $availableLanguages)) {
        // Utilizamos el 'language' que esté en la cookie
        if (!isLanguageSet($_COOKIE['preferred_language'])) {
            $_SESSION['language'] = $_COOKIE['preferred_language'];
        }
    } else {
        // Si no hay cookie, "seteamos" el language a 'es'.
        if (!isset($_SESSION['language'])) {
            $_SESSION['language'] = 'es';
        }
    }

    // Incluímos el fichero del language basandonos en el seleccionado o sino, por defecto, el 'es'
    $language = isset($_SESSION['language']) ? $_SESSION['language'] : 'es';
    loadLanguageFile($language);
}


function loadLanguageFile($language)
{
    global $availableLanguages, $lang;

    // Comprobar si existe el idioma seleccionado, sino, 'es'
    if (!in_array($language, $availableLanguages)) {
        $language = 'es';
    }

    // Cargamos el php apropiado
    switch ($_SESSION['language']) {
        case 'es':
            require_once(__DIR__ . '/es_ES.inc.php');
            break;
        case 'en':
            require_once(__DIR__ . '/en_EN.inc.php');
            break;
        case 'val':
            require_once(__DIR__ . '/ca_CA.inc.php');
            break;
        default:
            require_once(__DIR__ . '/es_ES.inc.php');
    }
}

setLanguage();
