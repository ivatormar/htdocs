<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/style.css">
    <title>Document</title>
</head>

<body>
    <?php
    /**
     * @author Iván Torres Marcos
     * @version 1.1
     * @description Realizamos un foreach para recorrer el array de los usuarios  y luego llamamos al toString mediante el echo
     *
     */
    include_once(__DIR__ . ('/INC/users.inc.php'));
    foreach ($users as $usuario) {
        echo $usuario;
    }
    ?>
</body>

</html>