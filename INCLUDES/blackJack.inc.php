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

    $playerHands = [];
    foreach ($players as $player) {
        $playerHands[$player] = []; //Aqui lo que hacemos es rellenar el array playerHands con los nombres de los jugadores
    }



    function calculateHandValue($hand)
    {
        $value = 0;
        $aceCount = 0;

        foreach ($hand as $card) {
            $cardValue = $card['value'];

            if ($cardValue === 'j' || $cardValue === 'q' || $cardValue === 'k') {
                $value += 10;
            } elseif ($cardValue === '1') {
                $aceCount++;
                $value += 11;
            } else {
                $value += (int)$cardValue;
            }
        }

        // Ajuste para ases si la suma supera 21
        while ($aceCount > 0 && $value > 21) {
            $value -= 10;
            $aceCount--;
        }

        return $value;
    }

    function determineResult($playerValue, $bankValue)
    {
        if ($playerValue > 21) {
            return 'perdido';
        } elseif ($bankValue > 21 || $playerValue > $bankValue) {
            return 'ganado';
        } elseif ($playerValue < $bankValue) {
            return 'perdido';
        } else {
            return 'empate';
        }
    }

    $results = [];



    // Repartir dos cartas a cada jugador y a la banca
    for ($i = 0; $i <= 5; $i++) {
        $player = $players[$i];

        // Repartir cartas a los jugadores
        if ($player != 'Banca') {
            $playerHands[$player][] = array_shift($deck);
            $playerHands[$player][] = array_shift($deck);

            // Repartir cartas adicionales si el valor es menor que 14
            while (calculateHandValue($playerHands[$player]) < 14) {
                $playerHands[$player][] = array_shift($deck);
            }
        }
        // Repartir cartas a la banca
        else {
            $playerHands[$player][] = array_shift($deck);
            $playerHands[$player][] = array_shift($deck);

            // Repartir cartas adicionales a la banca si el valor es menor que 14
            while (calculateHandValue($playerHands[$player]) < 14) {
                $playerHands[$player][] = array_shift($deck);
            }
        }
    }

    // ...




    echo '<div class="banca-cards">';
    echo '<h2>Cartas de Banca:</h2>';
    foreach ($playerHands['Banca'] as $card) {
        echo '<img class="barajaImg" src="/IMAGES/baraja/' . $card['image'] . '" alt="' . $card['suit'] . ' ' . $card['value'] . '">';
    }

    $bankValue = calculateHandValue($playerHands['Banca']);
    echo '<p>Puntos de la Banca: ' . $bankValue . '</p>';
    echo '</div>';

    echo '<div class="player-cards">';
    foreach ($players as $player) {
        if ($player !== 'Banca') {
            echo '<div class="player">';
            echo '<h2>Cartas de ' . $player . ':</h2>';

            $playerValue = calculateHandValue($playerHands[$player]);
            $result = determineResult($playerValue, $bankValue);
            $results[$player] = $result;
            echo '<p>Puntos de ' . $player . ': ' . $playerValue . ', Resultado: ' . $result . '</p>';

            foreach ($playerHands[$player] as $card) {
                echo '<img class="barajaImg" src="/IMAGES/baraja/' . $card['image'] . '" alt="' . $card['suit'] . ' ' . $card['value'] . '">';
            }
            echo '</div>';
        }
    }
    echo '</div>';



    ?>
</body>

</html>