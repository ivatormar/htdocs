<?php

/**
 * @author Ivan Torres Marcos
 * @version V1.1
 * @description Funciones varias: validarDNI y mostrar mensajes
 */



function validarDNI($dni)
{
    // Eliminar posibles espacios y letras en mayúscula
    $dni = strtoupper(trim($dni)); //

    // Comprobar longitud del DNI
    if (strlen($dni) !== 9) {
        return false;
    }

    // Obtener número y letra del DNI
    $numero = substr($dni, 0, 8);
    $letra = substr($dni, -1);

    // Comprobar que el número del DNI es válido
    if (!is_numeric($numero)) {
        return false;
    }

    // Calcular letra esperada
    $letraEsperada = "TRWAGMYFPDXBNJZSQVHLCKE";
    $indice = $numero % 23;
    $letraCalculada = $letraEsperada[$indice];

    // Comparar letra esperada con letra del DNI
    if ($letra !== $letraCalculada) {
        return false;
    }

    return true;
}

// function validator($value, $pattern, $requiredMessage, $errorMessage, $successMessage)
// {
//     if (!isset($_POST[$value]) || empty($_POST[$value])) { //Ponemos el empty para validar que no es un string vacío
//         $requiredMessages[] = $requiredMessage;
//     } else {

//         $_POST[$value] = trim($_POST[$value]);
//         if (!preg_match($pattern, $_POST[$value])) {
//             $errorMessages[] = $errorMessage;
//         } else {
//             $successMessages[] = $successMessage;
//         }
//     }
// }


/**
 * @description Función para mostrar los mensajes de require,error o success después del input
 */
function showMessages($fieldName, $requiredMessages, $errorMessages)
{
    $output = '';

    if (isset($requiredMessages["$fieldName"])) {
        $output .= $requiredMessages["$fieldName"];
    }

    if (isset($errorMessages["$fieldName"])) {
        $output .= $errorMessages["$fieldName"];
    }


    return $output;
}
