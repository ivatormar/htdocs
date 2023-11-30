<?php

// Define the available languages
$availableLanguages = ['es', 'val', 'en'];

function setLanguage() {
    global $availableLanguages;

    // Check if the language is set in the session
    if (isset($_GET['lang']) && in_array($_GET['lang'], $availableLanguages)) {
        $_SESSION['language'] = $_GET['lang'];

        // Set a cookie to remember the selected language
        setcookie('preferred_language', $_GET['lang'], time() + (365 * 24 * 60 * 60), '/');
    } elseif (isset($_COOKIE['preferred_language']) && in_array($_COOKIE['preferred_language'], $availableLanguages)) {
        // Use the language stored in the cookie
        $_SESSION['language'] = $_COOKIE['preferred_language'];
    } else {
        // If no cookie, set default language to 'es'
        $_SESSION['language'] = 'es';
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
    switch ($language) {
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

// Initialize session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Call setLanguage to set the language and load the language file
setLanguage();

?>
