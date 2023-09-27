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
    $player1Name = $names[$randomKeys[0]];
    $player2Name = $names[$randomKeys[1]];

    $player1 = []; //Creamos dos arrays vacios para luego 
    $player2 = []; //repartir y almacenar las cartas en cada jugador

    for ($index = 0; $index < 20; $index++) {
        if ($index % 2 == 0) {
            $player1[] = $deck[$index];
        } else {
            $player2[] = $deck[$index];
        }
    }

    // Inicializar las puntuaciones de los jugadores
    $scorePlayer1 = 0;
    $scorePlayer2 = 0;

    // Comparar las cartas de cada jugador y calcular las puntuaciones
    for ($i = 0; $i < 10; $i++) {
        $cardPlayer1 = $player1[$i];
        $cardPlayer2 = $player2[$i];

        // Obtener los valores de las cartas
        $valuePlayer1 = $cardPlayer1['value'];
        $valuePlayer2 = $cardPlayer2['value'];

        // Comparar las cartas y sumar puntos
        if ($valuePlayer1 == $valuePlayer2) {
            $scorePlayer1++;
            $scorePlayer2++;
        } elseif ($valuePlayer1 > $valuePlayer2) {
            $scorePlayer1 += 2;
        } else {
            $scorePlayer2 += 2;
        }
    }





    echo '<div class="containerHighestCards">';
    echo '<h3>Cartas de ' . $player1Name . ' :</h3>';
    foreach ($player1 as $card) {
        $claseCarta = 'draw-card'; // Por defecto, asumimos que es un empate

        // Comparar las cartas y asignar la clase CSS correspondiente
        if ($card['value'] > $player2[0]['value']) {
            $claseCarta = 'winner-card';
        } elseif ($card['value'] < $player2[0]['value']) {
            $claseCarta = 'looser-card';
        }

        echo '<img class="barajaImg ' . $claseCarta . '" src="/IMAGES/baraja/' . $card['image'] . '" alt="' . $card['suit'] . ' ' . $card['value'] . '">';
    }
    echo '</div>';


    // echo '<div class="containerHighestCards">';
    // echo '<h3>Cartas de ' . $player1Name . ' :</h3>';
    // foreach ($player1 as $card) {
    //     echo '<img class="barajaImg" src="/IMAGES/baraja/' . $card['image'] . '" alt="' . $card['suit'] . ' ' . $card['value'] . '">';
    // }
    // echo '</div>';


    echo '<div class="containerHighestCards">';
    echo '<h3>Cartas de ' . $player2Name . ' :</h3>';
    foreach ($player2 as $card) {
        $claseCarta = 'draw-card'; // Por defecto, asumimos que es un empate

        // Comparar las cartas y asignar la clase CSS correspondiente
        if ($card['value'] > $player1[0]['value']) {
            $claseCarta = 'winner-card';
        } elseif ($card['value'] < $player1[0]['value']) {
            $claseCarta = 'looser-card';
        }

        echo '<img class="barajaImg ' . $claseCarta . '" src="/IMAGES/baraja/' . $card['image'] . '" alt="' . $card['suit'] . ' ' . $card['value'] . '">';
    }
    echo '</div>';


    //     echo '<div class="containerHighestCards">';
    // echo '<h3>Cartas de ' . $player1Name . ' vs Cartas de ' . $player2Name . ':</h3>';
    // for ($i = 0; $i < 10; $i++) {
    //     $cartaPlayer1 = $player1[$i];
    //     $cartaPlayer2 = $player2[$i];

    //     $claseCartaPlayer1 = '';
    //     $claseCartaPlayer2 = '';

    //     if ($cartaPlayer1['value'] > $cartaPlayer2['value']) {
    //         $claseCartaPlayer1 = 'carta-ganadora';
    //         $claseCartaPlayer2 = 'carta-perdedora';
    //     } elseif ($cartaPlayer1['value'] < $cartaPlayer2['value']) {
    //         $claseCartaPlayer1 = 'carta-perdedora';
    //         $claseCartaPlayer2 = 'carta-ganadora';
    //     }

    //     echo '<div class="carta-container">';
    //     echo '<img class="barajaImg ' . $claseCartaPlayer1 . '" src="/IMAGES/baraja/' . $cartaPlayer1['image'] . '" alt="' . $cartaPlayer1['suit'] . ' ' . $cartaPlayer1['value'] . '">';
    //     echo '<img class="barajaImg ' . $claseCartaPlayer2 . '" src="/IMAGES/baraja/' . $cartaPlayer2['image'] . '" alt="' . $cartaPlayer2['suit'] . ' ' . $cartaPlayer2['value'] . '">';
    //     echo '</div>';
    // }
    // echo '</div>';



    echo '<div class="score">';
    echo "<h3>Puntuación de $player1Name: $scorePlayer1 puntos</h3>";
    echo "<h3>Puntuación de $player2Name: $scorePlayer2 puntos</h3>";

    if ($scorePlayer1 > $scorePlayer2) {
        echo "<h2>$player1Name ha ganado!</h2>";
    } elseif ($scorePlayer2 > $scorePlayer1) {
        echo "<h2>$player2Name ha ganado!</h2>";
    } else {
        echo "<h2>Es un empate!</h2>";
    }
    echo '</div>';




    ?>

</body>

</html>