<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Iván Torres Marcos</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mooli&family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <?php

    require_once(__DIR__ . '/INCLUDES/functions.inc.php');

    // Genera números aleatorios
    $random1 = mt_rand(1, 1000);
    $random2 = mt_rand(1, 1000);



    echo '<h2 class="first">Primer número random: ' . $random1 . '</h2>';
    echo '<h2 class="second">Segundo número random: ' . $random2 . '</h2>';

    echo '<h3>Comparando números 🕘</h3><article class="comparison">' . numbComparison($random1, $random2) . '</article>';
    echo '<h3> Número par o impar ✌</h3><article class="odd">' . numbOddOrEven($random1) . '</article>';
    echo '<h3> Número par o impar ✌</h3><article class="even">' . numbOddOrEven($random2) . '</article>';
    echo '<h3>Operación de suma realizándose 🐱‍🏍</h3><article class="sum">' . sumOperation($random1, $random2) . '</article>';
    echo '<h3>Operación de resta realizándose 🐱‍🚀</h3><article class="substraction">' . subtractionOperation($random1, $random2) . '</article>';
    echo '<h3>Operación de multiplicación realizándose 🐱‍👓</h3><article class="multiplication">' . multiplicationOperation($random1, $random2) . '</article>';
    echo '<h3>Operación de división realizándose 🐱‍👤</h3><article class="division">' . divisionOperation($random1, $random2) . '</article>';
    echo '<h3>Operación de módulo realizándose 🐱‍🐉</h3><article class="module">' . moduleOperation($random1, $random2) . '</article>';
    echo '<h3>Operación de potencia realizándose 🐱‍💻</h3><article class="pow">' . powOperation($random1, $random2) . '</article>';








    ?>
</body>

</html>