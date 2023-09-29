<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Black Jack</title>
</head>

<body>



    <?php
    /**
     * @author Ivan Torres Marcos
     * @version V1.0
     * @description  En este php lo que haremos será implementar todas las funciones necesarias para 
     * poder jugar al blackjack
     */
    require_once(__DIR__ . '/header.inc.php'); ?>
    <h1>Black Jack </h1>
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

    $players = ['Banca', 'Ivan', 'Pablo', 'Pau', 'David', 'Xuan'];

    // for ($i = 0; $i <= 11; $i++) { //Este es para repartir cartas

    //     for ($j = 0; $j <= 5; $j++) { //Este for es para las manos
    //         if ($j == 0) {
    //             $banca[] = array_pop($deck);
    //             $i++;
    //         } elseif ($j == 1) {
    //             $playerHand1[] = array_pop($deck);
    //             $i++;
    //         } elseif ($j == 2) {
    //             $playerHand2[] = array_pop($deck);
    //             $i++;
    //         } elseif ($j == 3) {
    //             $playerHand3[] = array_pop($deck);
    //             $i++;
    //         } elseif ($j == 4) {
    //             $playerHand4[] = array_pop($deck);
    //             $i++;
    //         } elseif ($j == 5) {
    //             $playerHand5[] = array_pop($deck);
    //             $i++;
    //         }
    //     }
    //     echo '<img class="barajaImg " src="/IMAGES/baraja/' . $playerHand1[$i]['image'] . '" alt="' . $playerHand1[$i]['suit'] . ' ' . $playerHand1[$i]['value'] . '">';
    // }
    $playerHands = [];
    foreach ($players as $player) {
        $playerHands[$player] = []; //Aqui lo que hacemos es rellenar el array playerHands con los nombres de los jugadores
    }

    // Reparte 2 cartas a cada jugador y la banca
    for ($i = 0; $i < 2; $i++) {
        foreach ($players as $player) {
            $playerHands[$player][] = array_pop($deck);
        }
    }

    // Muestra las cartas de todos los jugadores y la banca
    foreach ($players as $player) {
        echo '<h2>Cartas de ' . $player . ':</h2>';
        echo '<div class="containerBlackJackCards">';
        foreach ($playerHands[$player] as $card) {
            echo '<img class="barajaImg" src="/IMAGES/baraja/' . $card['image'] . '" alt="' . $card['suit'] . ' ' . $card['value'] . '">';
        }
        echo '</div>';
    }





    // // Función para calcular el valor de una mano de cartas
    // function calcularValorMano($mano)
    // {
    //     $valor = 0;
    //     $asCount = 0;


    //     //Cogemos los valores de la mano de cada jugador, y metemos las condiciones de los valores, si 
    //     foreach ($mano as $carta) {
    //         $valorCarta = $carta['value'];

    //         if ($valorCarta === 'j' || $valorCarta === 'q' || $valorCarta === 'k') {
    //             $valor += 10;
    //         } elseif ($valorCarta === '1') {
    //             $asCount++;
    //             $valor += 1;
    //         } else {
    //             $valor += intval($valorCarta);
    //         }
    //     }

    //     // Ajustar el valor del AS si es conveniente (si no hace que el jugador se pase de 21)
    //     while ($asCount > 0 && $valor + 10 <= 21) {
    //         $valor += 10;
    //         $asCount--;
    //     }

    //     return $valor;
    // }



    // // Crear un array para representar a cada jugador y la banca
    // $jugadores = [
    //     ['nombre' => 'Jugador 1', 'mano' => []],
    //     ['nombre' => 'Jugador 2', 'mano' => []],
    //     ['nombre' => 'Jugador 3', 'mano' => []],
    //     ['nombre' => 'Jugador 4', 'mano' => []],
    //     ['nombre' => 'Jugador 5', 'mano' => []],
    //     ['nombre' => 'Banca', 'mano' => []],
    // ];

    // // Repartir 2 cartas a cada jugador y a la banca
    // for ($i = 0; $i < 2; $i++) {
    //     foreach ($jugadores as &$jugador) {
    //         $jugador['mano'][] = array_shift($deck);
    //     }
    // }

    // // Función para mostrar la mano de un jugador
    // function mostrarMano($jugador)
    // {
    //     echo '<h3>' . $jugador['nombre'] . ':</h3>';
    //     echo '<div>';
    //     foreach ($jugador['mano'] as $carta) {
    //         echo '<img src="/IMAGES/baraja/' . $carta['image'] . '" alt="' . $carta['suit'] . ' ' . $carta['value'] . '">';
    //     }
    //     echo '</div>';
    // }

    // // Función para determinar el resultado de un jugador
    // function determinarResultado($jugador, $banca)
    // {
    //     $valorJugador = calcularValorMano($jugador['mano']);
    //     $valorBanca = calcularValorMano($banca['mano']);

    //     if ($valorJugador > 21) {
    //         return 'Perdió';
    //     } elseif ($valorJugador > $valorBanca || $valorBanca > 21) {
    //         return 'Ganó';
    //     } elseif ($valorJugador < $valorBanca) {
    //         return 'Perdió';
    //     } else {
    //         return 'Empató';
    //     }
    // }

    // // Jugar el juego
    // foreach ($jugadores as $jugador) {
    //     while (calcularValorMano($jugador['mano']) < 14) {
    //         $jugador['mano'][] = array_shift($deck);
    //     }
    //     mostrarMano($jugador);
    //     $resultado = determinarResultado($jugador, $jugadores[5]);
    //     echo '<p>Resultado: ' . $resultado . '</p>';
    //     echo '<hr>';
    // }
    // 
    ?>



    ?>
</body>

</html>