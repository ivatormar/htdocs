<?php
require_once(__DIR__ . '/INC/functions.php');
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
$dniExpr = '/^\d{8}[A-HJ-NP-TV-Z]$/';
$directionExpr = '/^[a-zA-Z0-9\s,.-\/]+$/';
$emailExpr = '/^[\w.-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/';
$mobileNumberExpr = '/^[\d\s()-]+$/';
$birthDateExpr = '/^\d{2}-\d{2}-\d{4}$/';

$errorMessages = []; //Creamos un array para almacenar todos los errores que tengamos
$requiredMessages = []; //Creamos un array para almacenar todos los requires que tengamos



if (isset($_POST['name'])) {
    if (!isset($_POST['code']) || empty($_POST['code'])) { //Ponemos el empty para validar que no es un string vacío
        $requiredMessages[] = 'El campo CODE es obligatorio.<br>';
    } else {
        $_POST['code'] = trim($_POST['code']);
        if (!preg_match($codeExpr, $_POST['code'])) {
            $errorMessages[] = 'El código debe tener una letra seguida de un guión seguido de 5 dígitos.';
        }
    }

    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $requiredMessages[] = 'El campo NAME es obligatorio.<br>';
    } else {
        $_POST['name'] = trim($_POST['name']); //Eliminamos los espacios
        if (!preg_match($nameExpr, $_POST['name'])) {

            $errorMessages[] = 'El nombre debe contener solo letras (mínimo 3 y máximo 20).';
        }
    }



    if (!isset($_POST['price']) || empty($_POST['price'])) {
        $requiredMessages[] = 'El campo PRICE es obligatorio.<br>';
    } else {
        $_POST['price'] = trim($_POST['price']);
        if (!preg_match($priceExpr, $_POST['price'])) {
            $errorMessages[] = 'El precio debe ser un número decimal.';
        }
    }


    if (!isset($_POST['description']) || empty($_POST['description'])) {
        $requiredMessages[] = 'El campo DESCRIPTION es obligatorio.<br>';
    } else {
        $_POST['description'] = trim($_POST['description']);
        if (!preg_match($descriptionExpr, $_POST['description'])) {
            $errorMessages[] = 'La descripción debe contener al menos 50 caracteres alfanuméricos.';
        }
    }


    if (!isset($_POST['manufacturer']) || empty($_POST['manufacturer'])) {
        $requiredMessages[] = 'El campo MANUFACTURER es obligatorio.<br>';
    } else {
        $_POST['manufacturer'] = trim($_POST['manufacturer']);
        if (!preg_match($manufacturerExpr, $_POST['manufacturer'])) {
            $errorMessages[] = 'El fabricante debe contener entre 10 y 20 caracteres alfanuméricos.';
        }
    }

    if (!isset($_POST['acquisitionDate']) || empty($_POST['acquisitionDate'])) {
        $requiredMessages[] = 'El campo  ACQUISITION DATE es obligatorio.<br>';
    } else {
        $_POST['acquisitionDate'] = trim($_POST['acquisitionDate']);
        if (!preg_match($dateExpr, $_POST['acquisitionDate'])) {
            $errorMessages[] = 'La fecha de adquisición debe tener el formato dd/mm/yyyy.';
        }
    }
}
$dni = '44535252F';
if (validarDNI($dni)) {
    echo 'DNI APTO';
} else {
    echo 'DNI NO APTO';
}



// $successMessage = "¡Los datos se han enviado correctamente! 🤕🤕";


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Ivan Torres</title>
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

    echo '<div>'; //Mostramos los errores
    foreach ($errorMessages as $message) {
        echo $message . '<br>';
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
        Fecha de nacimiento <input type="text" name="acquisitionDate"><br>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>