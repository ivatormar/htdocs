<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Ivan Torres</title>
</head>

<body>


    <?php
    /**
     * @author Ivan Torres Marcos
     * @version V1.2
     * @description En este archivo php recibimos los datos introducidos de productIvanTorres
     */



    $names = ['Codigo', 'Nombre', 'Precio', 'Descripcion', 'Fabricante', 'Fecha de adquisicion'];

    echo '<table border=1><tr>';

    foreach ($names as $value) {
        echo '<td>' . $value . '</td>';
    }

    echo '</tr><tr>';
    foreach ($_GET as $value) {
        echo '<td>' . $value . '</td>';
    }
    echo '</tr></table>';

    ?>



</body>

</html>
<?php
