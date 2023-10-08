<?php

require_once(__DIR__ . '/INC/functions.inc.php');
/**
Crear una aplicación web que contenga un script PHP applyforTunombre.php con formulario POST para enviar los datos 
de un candidato para una oferta de trabajo (usuario, nombre, apellidos, DNI, dirección, mail, teléfono, fecha de nacimiento).

El script PHP applyforTunombre.php realizará todas las tareas (mostrar formularios, validar datos, mostrar errores, mostrar mensaje de éxito).
Si se necesita se pueden crear archivos adicionales para estilos o para almacenar funciones php.
Si todos los campos son correctos muestra un mensaje indicando que se ha registrado correctamente la solicitud y no se mostrará el formulario.
Si algún campo no cumple los requisitos se mostrará otra vez el formulario original pero esta vez con todos los campos ya introducidos anteriormente 
y con un mensaje informativo debajo de cada campo erróneo.
Los datos se deben validar con expresiones regulares.

 

Currículo y foto
Modificar la aplicación web anterior para que en el formulario también se envíe el currículo del candidato en formato pdf y una foto del candidato.
El currículo se debe guardar con el nombre dni-nombre-apellido1.pdf en una carpeta llamada cvs dentro del directorio raíz de la aplicación web.
La foto se debe guardar con el nombre dni.png dentro de una carpeta llamada candidates dentro de la carpeta en la que se guardan las imágenes del directorio raíz de la aplicación web.

 

Final
Modificar la aplicación web anterior para que se almacenen dos versiones (tamaños) de la foto que envíe el candidato.
Se debe almacenar la imagen original y una versión más pequeña. El nombre de la imagen pequeña debe ser dni- thumbnail.png.
Añade todos los archivos de htdocs a una carpeta con tu nombre y comprime esa carpeta en un archivo rar o zip y adjunta ese archivo a la tarea.
 * 
 * 
 * 
 * 
 */
/**
 * @author Ivan Torres Marcos
 * @version V1.2
 * @description En este archivo php hemos introducidos los datos los cuales se verán reflejados en productIvanTorres
 */



$userExpr = '/^[a-z0-9_]+$/'; //User: Debe contener solo letras minúsculas, números y guiones bajos.
$nameandSurnamesExpr = '/^[A-z\s]+$/'; //Nombre y apellidos: Debe contener solo letras mayúsculas y minúsculas, y puede incluir espacios.
$dniExpr = '/^\d{8}[A-HJ-NP-TV-Z]$/'; //DNI: Debe seguir el patrón de 8 dígitos seguido de una letra en mayúscula (puede ser 'X', 'Y' o 'Z' para casos especiales).
$directionExpr = '/^[a-zA-Z0-9\s,.-\/]+$/'; //Dirección: Puede contener letras mayúsculas y minúsculas, números, espacios y los siguientes caracteres especiales: coma, punto, guion, número de casa y barra diagonal.
$emailExpr = '/^[\w.-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/'; //Email: Debe seguir el patrón de una o más letras, números, guiones, puntos o guiones bajos, seguidos de un símbolo de arroba (@), seguido de un dominio válido (p. ej., gmail.com).
$mobileNumberExpr = '/^[\d\s()-]+$/'; //Teléfono: Puede contener solo números, y puede incluir paréntesis, guiones y espacios en formatos comunes de números de teléfono.
$birthDateExpr = '/^\d{2}-\d{2}-\d{4}$/'; // Fecha de nacimiento: Puede contener solo números, y puede incluir paréntesis, guiones y espacios en formatos comunes de números de teléfono.

$errorMessages = []; //Creamos un array para almacenar todos los errores que tengamos
$requiredMessages = []; //Creamos un array para almacenar todos los requires que tengamos



if (isset($_POST['name'])) {
    if (!isset($_POST['user']) || empty($_POST['user'])) { //Ponemos el empty para validar que no es un string vacío
        $requiredMessages[] = 'El campo CODE es obligatorio.<br>';
    } else {
        $_POST['user'] = trim($_POST['user']);
        if (!preg_match($userExpr, $_POST['user'])) {
            $errorMessages[] = 'El código debe tener una letra seguida de un guión seguido de 5 dígitos.';
        }
    }

    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $requiredMessages[] = 'El campo NAME es obligatorio.<br>';
    } else {
        $_POST['name'] = trim($_POST['name']); //Eliminamos los espacios
        if (!preg_match($nameandSurnamesExpr, $_POST['name'])) {

            $errorMessages[] = 'Nombre y apellidos: Debe contener solo letras mayúsculas y minúsculas, y puede incluir espacios.';
        }
    }
    if (!isset($_POST['surname']) || empty($_POST['surname'])) {
        $requiredMessages[] = 'El campo surname es obligatorio.<br>';
    } else {
        $_POST['surname'] = trim($_POST['surname']); //Eliminamos los espacios
        if (!preg_match($nameandSurnamesExpr, $_POST['surname'])) {

            $errorMessages[] = 'Nombre y apellidos: Debe contener solo letras mayúsculas y minúsculas, y puede incluir espacios.';
        }
    }



    if (!isset($_POST['dni']) || empty($_POST['dni'])) {
        $requiredMessages[] = 'El campo dni es obligatorio.<br>';
    } else {
        $_POST['dni'] = trim($_POST['dni']);
        if (validarDNI($_POST['dni'])) {
            $errorMessages[] = 'El DNI es VÁLIDO';
        } else {
            $errorMessages[] = 'El DNI es NO VÁLIDO';
        }
        if (!preg_match($dniExpr, $_POST['dni'])) {
            $errorMessages[] = 'Debe seguir el patrón de 8 dígitos seguido de una letra en mayúscula para casos especiales.';
        }
    }


    if (!isset($_POST['direction']) || empty($_POST['direction'])) {
        $requiredMessages[] = 'El campo direction es obligatorio.<br>';
    } else {
        $_POST['direction'] = trim($_POST['direction']);
        if (!preg_match($directionExpr, $_POST['direction'])) {
            $errorMessages[] = 'Puede contener letras mayúsculas y minúsculas, números, espacios y los siguientes caracteres especiales: coma, punto, guion, número de casa y barra diagonal.';
        }
    }


    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $requiredMessages[] = 'El campo email es obligatorio.<br>';
    } else {
        $_POST['email'] = trim($_POST['email']);
        if (!preg_match($emailExpr, $_POST['email'])) {
            $errorMessages[] = 'Debe seguir el patrón de una o más letras, números, guiones, puntos o guiones bajos, seguidos de un símbolo de arroba (@), seguido de un dominio válido (p. ej., gmail.com).';
        }
    }

    if (!isset($_POST['mobilephoneNumber']) || empty($_POST['mobilephoneNumber'])) {
        $requiredMessages[] = 'El campo mobilephoneNumber es obligatorio.<br>';
    } else {
        $_POST['mobilephoneNumber'] = trim($_POST['mobilephoneNumber']);
        if (!preg_match($mobilephoneNumberExpr, $_POST['mobilephoneNumber'])) {
            $errorMessages[] = 'Debe seguir el patrón de una o más letras, números, guiones, puntos o guiones bajos, seguidos de un símbolo de arroba (@), seguido de un dominio válido (p. ej., gmail.com).';
        }
    }

    if (!isset($_POST['birthDate']) || empty($_POST['birthDate'])) {
        $requiredMessages[] = 'El campo  ACQUISITION DATE es obligatorio.<br>';
    } else {
        $_POST['birthDate'] = trim($_POST['birthDate']);
        if (!preg_match($birthDateExpr, $_POST['birthDate'])) {
            $errorMessages[] = 'La fecha de adquisición debe tener el formato dd/mm/yyyy.';
        }
    }
}




// $successMessage = "¡Los datos se han enviado correctamente! 🤕🤕";


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once(__DIR__ . '/INC/header.inc.php'); ?>
</head>

<body>
    <?php
    /**
     * @author Ivan Torres Marcos
     * @version V1.2
     * @description En este archivo php hemos introducidos los datos los cuales se verán reflejados en productIvanTorres
     */
    echo '<div>'; //Mostramos los campos obligatorios
    foreach ($requiredMessages as $message) {
        echo $message . '<br>';
    }
    echo '</div>';

    echo '<div class="divError>'; //Mostramos los errores //TODO ESTO HAY QUE ARREGLARLO
    if (count($errorMessages) == 0) {
        foreach ($errorMessages as $message) {
            echo $message . '<br>';
        }
    }
    echo '</div>';

    ?>
    <form action="#" method="post">
        Usuario <input type="text" name="user"><br>
        Nombre <input type="text" name="name"><br>
        Apellidos <input type="text" name="surname"><br>
        DNI <input type="text" name="dni"><br>
        Dirección <input type="text" name="direction"><br>
        Email <input type="text" name="email"><br>
        Teléfono <input type="text" name="mobilephoneNumber"><br>
        Fecha de nacimiento <input type="text" name="birthDate"><br>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>