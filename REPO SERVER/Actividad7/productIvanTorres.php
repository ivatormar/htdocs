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



    <form action="processIvanTorres.php" method="get">
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