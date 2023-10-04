<?php
if (!isset($_POST['code'])) {
    header('Location: /processIvanTorres.php');
    exit;
} else if (!isset($_POST['name'])) {
    header('Location: /processIvanTorres.php');
    exit;
} else if (!isset($_POST['price'])) {
    header('Location: /processIvanTorres.php');
    exit;
} else if (!isset($_POST['description'])) {
    header('Location: /processIvanTorres.php');
    exit;
} else if (!isset($_POST['manufacturer'])) {
    header('Location: /processIvanTorres.php');
    exit;
} else if (!isset($_POST['adquisitionDate'])) {
    header('Location: /processIvanTorres.php');
    exit;
}
//Falta trim

$codeExpr = '/^[A-z]-\d{5}$/';
$nameExpr = '/^[A-z]{3,20}$/';
$priceExpr = '/^\d+(\.\d{1,2})?$/';
$descriptionExpr = '/^[A-z0-9\s]{50,}$/';
$manufacturerExpr = '/^[A-z0-9]{10,20}$/';
$dateExpr = '/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/';

if (!preg_match($codeExpr, $_POST['code'])) {
    echo 'El código tiene que tener una letra seguida de un guión seguido de 5 dígitos';
} else if (!preg_match($nameExpr, $_POST['name'])) {
    echo 'El código tiene que tener una letra seguida de un guión seguido de 5 dígitos';
} else if (!preg_match($nameExpr, $_POST['name'])) {
    echo 'El código tiene que tener una letra seguida de un guión seguido de 5 dígitos';
} else if (!preg_match($nameExpr, $_POST['name'])) {
    echo 'El código tiene que tener una letra seguida de un guión seguido de 5 dígitos';
} else if (!preg_match($nameExpr, $_POST['name'])) {
    echo 'El código tiene que tener una letra seguida de un guión seguido de 5 dígitos';
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

    ?>



    <form action="processIvanTorres.php" method="post">
        Código <input type="text" name="code"><br>
        Nombre <input type="text" name="name"><br>
        Precio <input type="text" name="price"><br>
        Descripción <input type="text" name="description"><br>
        Fabricante <input type="text" name="manufacturer"><br>
        Fecha de adquisición <input type="text" name="adquisitionDate"><br>
        <input type="submit" value="enviar">
    </form>
</body>

</html>