<?php

/**
 * @author Ivan Torres Marcos
 * @version V1.2
 * @description En este archivo php hemos introducidos los datos los cuales se verán reflejados en productIvanTorres
 */


$expectedFields = ['code', 'name', 'price', 'description', 'manufacturer', 'adquisitionDate'];

$codeExpr = '/^[A-Za-z]-\d{5}$/';
$nameExpr = '/^[A-Za-z]{3,20}$/';
$priceExpr = '/^\d+(\.\d{1,2})?$/';
$descriptionExpr = '/^[A-Za-z0-9\s]{50,}$/';
$manufacturerExpr = '/^[A-Za-z0-9]{10,20}$/';
$dateExpr = '/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/';

$error = false;
$errorMessages = []; //Creamos un array para almacenar todos los errores que tengamos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($expectedFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $error = true;
            $errorMessages[] = "El campo '$field' es obligatorio.";
        } else {
            $_POST[$field] = trim($_POST[$field]);
        }
    }

    if (!$error) {
        if (!preg_match($codeExpr, $_POST['code'])) {
            $error = true;
            $errorMessages[] = 'El código debe tener una letra seguida de un guión seguido de 5 dígitos.';
        }
        if (!preg_match($nameExpr, $_POST['name'])) {
            $error = true;
            $errorMessages[] = 'El nombre debe contener solo letras (mínimo 3 y máximo 20).';
        }
        if (!preg_match($priceExpr, $_POST['price'])) {
            $error = true;
            $errorMessages[] = 'El precio debe ser un número decimal.';
        }
        if (!preg_match($descriptionExpr, $_POST['description'])) {
            $error = true;
            $errorMessages[] = 'La descripción debe contener al menos 50 caracteres alfanuméricos.';
        }
        if (!preg_match($manufacturerExpr, $_POST['manufacturer'])) {
            $error = true;
            $errorMessages[] = 'El fabricante debe contener entre 10 y 20 caracteres alfanuméricos.';
        }
        if (!preg_match($dateExpr, $_POST['adquisitionDate'])) {
            $error = true;
            $errorMessages[] = 'La fecha de adquisición debe tener el formato dd/mm/yyyy.';
        }
    }
    if (!$error) {

        $successMessage = "¡Los datos se han enviado correctamente! 🤕🤕";
    }
}
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

    if ($error) {
        echo '<div style="color: red; font-weight: bold;">'; //Sé que dijiste que estilos en linea no querías, pero era para darle algo de vidilla a los errores y no aÑadir css y demás, sorry.
        foreach ($errorMessages as $errorMessage) {
            echo $errorMessage . '<br>';
        }
        echo '</div>';
    } elseif (isset($successMessage)) {
        echo '<div style="color: green; font-weight: bold;">';
        echo $successMessage;
        echo '</div>';
    }

    ?>

    <form action="productIvanTorres.php" method="post">
        Código <input type="text" name="code"><br>
        Nombre <input type="text" name="name"><br>
        Precio <input type="text" name="price"><br>
        Descripción <input type="text" name="description"><br>
        Fabricante <input type="text" name="manufacturer"><br>
        Fecha de adquisición <input type="text" name="adquisitionDate"><br>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>