
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
        include_once(__DIR__.('/INC/users.inc.php'));
        foreach ($users as $usuario) {
            echo $usuario;
        }
        ?>
</body>
</html>