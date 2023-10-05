<?php

/**
 * @author Ivan Torres Marcos
 * @version V1.2
 * @description En este archivo php hemos introducidos los datos los cuales se verán reflejados en productIvanTorres
 */



$codeExpr = '/^[A-Za-z]-\d{5}$/';
$nameExpr = '/^[A-Za-z]{3,20}$/';
$priceExpr = '/^\d+(\.\d{1,2})?$/';
$descriptionExpr = '/^[A-Za-z0-9\s]{50,}$/';
$manufacturerExpr = '/^[A-Za-z0-9]{10,20}$/';
$dateExpr = '/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/';


$errorMessages = []; //Creamos un array para almacenar todos los errores que tengamos


if (isset($_POST['name'])) {
    if (!isset($_POST['code']) || empty($_POST['code'])) {
        echo 'El campo CODE es obligatorio.<br>';
    } else {
        $_POST['code'] = trim($_POST['code']);
        if (!preg_match($codeExpr, $_POST['code'])) {
            $errorMessages[] = 'El código debe tener una letra seguida de un guión seguido de 5 dígitos.';
        }
    }

    if (!isset($_POST['name']) || empty($_POST['name'])) {
        echo 'El campo NAME es obligatorio.<br>';
    } else {
        $_POST['name'] = trim($_POST['name']);
        if (!preg_match($nameExpr, $_POST['name'])) {

            $errorMessages[] = 'El nombre debe contener solo letras (mínimo 3 y máximo 20).';
        }
    }



    if (!isset($_POST['price']) || empty($_POST['price'])) {
        echo 'El campo PRICE es obligatorio.<br>';
    } else {
        $_POST['price'] = trim($_POST['price']);
        if (!preg_match($priceExpr, $_POST['price'])) {
            $errorMessages[] = 'El precio debe ser un número decimal.';
        }
    }


    if (!isset($_POST['description']) || empty($_POST['description'])) {
        echo 'El campo DESCRIPTION es obligatorio.<br>';
    } else {
        $_POST['description'] = trim($_POST['description']);
        if (!preg_match($descriptionExpr, $_POST['description'])) {
            $errorMessages[] = 'La descripción debe contener al menos 50 caracteres alfanuméricos.';
        }
    }


    if (!isset($_POST['manufacturer']) || empty($_POST['manufacturer'])) {
        echo 'El campo MANUFACTURER es obligatorio.<br>';
    } else {
        $_POST['manufacturer'] = trim($_POST['manufacturer']);
        if (!preg_match($manufacturerExpr, $_POST['manufacturer'])) {
            $errorMessages[] = 'El fabricante debe contener entre 10 y 20 caracteres alfanuméricos.';
        }
    }

    if (!isset($_POST['acquisitionDate']) || empty($_POST['acquisitionDate'])) {
        echo 'El campo  ACQUISITION DTE es obligatorio.<br>';
    } else {
        $_POST['acquisitionDate'] = trim($_POST['acquisitionDate']);
        if (!preg_match($dateExpr, $_POST['acquisitionDate'])) {
            $errorMessages[] = 'La fecha de adquisición debe tener el formato dd/mm/yyyy.';
        }
    }
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


    echo '<div>';
    foreach ($errorMessages as $errorMessage) {
        echo $errorMessage . '<br>';
    }
    echo '</div>';

    ?>
    <form action="#" method="post">
        Código <input type="text" name="code"><br>
        Nombre <input type="text" name="name"><br>
        Precio <input type="text" name="price"><br>
        Descripción <input type="text" name="description"><br>
        Fabricante <input type="text" name="manufacturer"><br>
        Fecha de adquisición <input type="text" name="acquisitionDate"><br>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>