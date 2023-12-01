<?php

// Define the available languages
$availableLanguages = ['es', 'val', 'en'];

function isLanguageSet($language) {
    return isset($_SESSION['language']) && $_SESSION['language'] === $language;
}

function setLanguage() {
    global $availableLanguages;

    // Check if the language is set in the session
    if (isset($_GET['lang']) && in_array($_GET['lang'], $availableLanguages)) {
        if (!isLanguageSet($_GET['lang'])) {
            $_SESSION['language'] = $_GET['lang'];

            // Set a cookie to remember the selected language
            setcookie('preferred_language', $_GET['lang'], time() + (365 * 24 * 60 * 60), '/');
            header('Location:'.$_SERVER['PHP_SELF']);
            exit;
        }
    } elseif (isset($_COOKIE['preferred_language']) && in_array($_COOKIE['preferred_language'], $availableLanguages)) {
        // Use the language stored in the cookie
        if (!isLanguageSet($_COOKIE['preferred_language'])) {
            $_SESSION['language'] = $_COOKIE['preferred_language'];
        }
    } else {
        // If no cookie, set default language to 'es'
        if (!isset($_SESSION['language'])) {
            $_SESSION['language'] = 'es';
        }
    }

    // Include the language file based on the selected language or use the default language
    $language = isset($_SESSION['language']) ? $_SESSION['language'] : 'es'; // Default to Spanish if no language is set
    loadLanguageFile($language);
}


function loadLanguageFile($language) {
    global $availableLanguages, $lang;

    // Check if the language is available
    if (!in_array($language, $availableLanguages)) {
        $language = 'es'; // Fallback to Spanish if the language is not recognized
    }

    // Load the appropriate language file
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


// Call setLanguage to set the language and load the language file
 setLanguage();

?>
