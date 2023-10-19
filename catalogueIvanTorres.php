<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/style.css">
    <link rel="shortcut icon" href="/descarga-removebg-preview_1.ico" type="image/x-icon">
    <title>Iván Torres Marcos</title>
</head>
<body>
    <h1>Catálogo Online</h1>
<?php
/**
 * @author Tu Nombre
 * @version 1.2
 * @description Un simple foreach en el que "llamamos" el script de generar la marca de agua cada vez que recorremos la imagen
 *
 */

    $dir = __DIR__."/IMG/";
    $files = glob($dir."*.png");
    

    foreach($files as $img) {
        echo '<div class="imgDiv">';
        
            echo '<img src="watermark.php?img='.$img. '" alt="'.$img.'" />';
        echo '</div>';
    }
    ?>
</body>
</html>