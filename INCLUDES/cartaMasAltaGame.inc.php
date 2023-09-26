<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta mas alta</title>
</head>

<body>


    <?php
    /**
     * @author Ivan Torres Marcos
     * @version V1.0
     * @description  En este php lo que haremos será implementar todas las funciones necesarias para 
     * poder jugar al juego de carta mas alta
     */

    require_once(__DIR__ . '/header.inc.php'); ?>
    <h1>Juego de carta mas alta</h1>
    <?php
    $deck = [
        ["suit" => "corazones", "value" => "1", "image" => "cor_1.png"],
        ["suit" => "corazones", "value" => "2", "image" => "cor_2.png"],
        ["suit" => "corazones", "value" => "3", "image" => "cor_3.png"],
        ["suit" => "corazones", "value" => "4", "image" => "cor_4.png"],
        ["suit" => "corazones", "value" => "5", "image" => "cor_5.png"],
        ["suit" => "corazones", "value" => "6", "image" => "cor_6.png"],
        ["suit" => "corazones", "value" => "7", "image" => "cor_7.png"],
        ["suit" => "corazones", "value" => "8", "image" => "cor_8.png"],
        ["suit" => "corazones", "value" => "9", "image" => "cor_9.png"],
        ["suit" => "corazones", "value" => "10", "image" => "cor_10.png"],
        ["suit" => "corazones", "value" => "j", "image" => "cor_j.png"],
        ["suit" => "corazones", "value" => "q", "image" => "cor_q.png"],
        ["suit" => "corazones", "value" => "k", "image" => "cor_k.png"],
        ["suit" => "rombos", "value" => "1", "image" => "rom_1.png"],
        ["suit" => "rombos", "value" => "2", "image" => "rom_2.png"],
        ["suit" => "rombos", "value" => "3", "image" => "rom_3.png"],
        ["suit" => "rombos", "value" => "4", "image" => "rom_4.png"],
        ["suit" => "rombos", "value" => "5", "image" => "rom_5.png"],
        ["suit" => "rombos", "value" => "6", "image" => "rom_6.png"],
        ["suit" => "rombos", "value" => "7", "image" => "rom_7.png"],
        ["suit" => "rombos", "value" => "8", "image" => "rom_8.png"],
        ["suit" => "rombos", "value" => "9", "image" => "rom_9.png"],
        ["suit" => "rombos", "value" => "10", "image" => "rom_10.png"],
        ["suit" => "rombos", "value" => "j", "image" => "rom_j.png"],
        ["suit" => "rombos", "value" => "q", "image" => "rom_q.png"],
        ["suit" => "rombos", "value" => "k", "image" => "rom_k.png"],
        ["suit" => "espadas", "value" => "1", "image" => "pic_1.png"],
        ["suit" => "picadas", "value" => "2", "image" => "pic_2.png"],
        ["suit" => "picadas", "value" => "3", "image" => "pic_3.png"],
        ["suit" => "picadas", "value" => "4", "image" => "pic_4.png"],
        ["suit" => "picadas", "value" => "5", "image" => "pic_5.png"],
        ["suit" => "picadas", "value" => "6", "image" => "pic_6.png"],
        ["suit" => "picadas", "value" => "7", "image" => "pic_7.png"],
        ["suit" => "picadas", "value" => "8", "image" => "pic_8.png"],
        ["suit" => "picadas", "value" => "9", "image" => "pic_9.png"],
        ["suit" => "picadas", "value" => "10", "image" => "pic_10.png"],
        ["suit" => "picadas", "value" => "j", "image" => "pic_j.png"],
        ["suit" => "picadas", "value" => "q", "image" => "pic_q.png"],
        ["suit" => "picadas", "value" => "k", "image" => "pic_k.png"],
        ["suit" => "tréboles", "value" => "1", "image" => "tre_1.png"],
        ["suit" => "tréboles", "value" => "2", "image" => "tre_2.png"],
        ["suit" => "tréboles", "value" => "3", "image" => "tre_3.png"],
        ["suit" => "tréboles", "value" => "4", "image" => "tre_4.png"],
        ["suit" => "tréboles", "value" => "5", "image" => "tre_5.png"],
        ["suit" => "tréboles", "value" => "6", "image" => "tre_6.png"],
        ["suit" => "tréboles", "value" => "7", "image" => "tre_7.png"],
        ["suit" => "tréboles", "value" => "8", "image" => "tre_8.png"],
        ["suit" => "tréboles", "value" => "9", "image" => "tre_9.png"],
        ["suit" => "tréboles", "value" => "10", "image" => "tre_10.png"],
        ["suit" => "tréboles", "value" => "j", "image" => "tre_j.png"],
        ["suit" => "tréboles", "value" => "q", "image" => "tre_q.png"],
        ["suit" => "tréboles", "value" => "k", "image" => "tre_k.png"]
    ];
    shuffle($deck);

    $names = ['Ivan', 'Jose', 'Pepe', 'Ramón', 'Lluna'];
    $randomKeys = array_rand($names, 2); //Extraemos dos nombres del array previo
    $player1Name = [$names[$randomKeys[0]]];
    $player2Name = [$names[$randomKeys[1]]];

    $player1 = []; //Creamos dos arrays vacios para luego 
    $player2 = []; //repartir y almacenar las cartas en cada jugador

    for ($index = 0; $index < 10; $index++) { //Sigo sin entender esto
        if ($index % 2 == 0) {
            $player1[] = $card; //Si el indice es par le repartimos una carta al player1
        } else {
            $player2[] = $card;
        }
    }
    echo '<h3>Cartas de $player1Name:</h3>';
    foreach ($player1 as $card) {
        echo "<img src='/IMAGES/baraja/{$card['image']}' alt='{$card['suit']} {$card['value']}'>";
    }


    echo '<h3>Cartas de ' . $player2Name . '</h3>';
    foreach ($player2 as $card) {
        echo "<img src='/IMAGES/baraja/{$card['image']}' alt='{$card['suit']} {$card['value']}'>";
    }






    ?>

</body>

</html>