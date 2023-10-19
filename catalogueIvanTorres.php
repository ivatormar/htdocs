<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $dir = __DIR__."/IMG/";
    $files = glob($dir."*.png");
    
    foreach($files as $img) {
        
            echo '<img src="watermark.php?img='.$img. '" alt="'.$img.'" />';
        
    }
    ?>
</body>
</html>