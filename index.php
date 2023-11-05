<?php

/**
 * @author Ivan Torres Marcos
 * @version 1.6
 * @description Indice principal de la app.
 *
 */


include_once(__DIR__ . '/INC/utils.inc.php');
include_once(__DIR__ . '/INC/Person.inc.php');
include_once(__DIR__ . '/INC/GrandPrix.inc.php');
include_once(__DIR__ . '/INC/Rider.inc.php');
include_once(__DIR__ . '/INC/Mechanic.inc.php');
include_once(__DIR__ . '/INC/TraitCalcAge.inc.php');
include_once(__DIR__ . '/INC/Circuit.inc.php');


$teams = $GLOBALS['teams'];
$circuits = $GLOBALS['circuits'];

// Añadimos 2 mecánicos y 2 pilotos a cada equipo
foreach ($teams as $team) {
    $mechanic = null;
    $rider = null;
    for ($i = 0; $i < 2; $i++) {
        $mechanic = new Mechanic(randomName(), randomBirthday(), randomSpeciality());
        $team->addMechanic($mechanic);
        $rider = new Rider(randomName(), randomBirthday(), randomDorsal($dorsals));
        $team->addRider($rider);
    }
    // var_dump($mechanic);
    // var_dump($rider);

}


// Creamos carreras
$grandPrixs = [];
foreach ($circuits as $circuit) {
    $grandPrix = new GrandPrix(mktime(0, 0, 0, rand(1, 12), rand(1, 31), 2023), $circuit);

    $allRiders = []; //*Tuve que hacer este array_merge y luego shufflearlos porque previamente solo me hacía el shuffle intraequipos, no de todos los riders de los equipos
    foreach ($teams as $team) {
        $allRiders = array_merge($allRiders, $team->riders);
    }

    shuffle($allRiders); // Barajamos el orden de todos los pilotos

    $positions = range(1, count($allRiders)); // Obtenemos posiciones del 1 al número de pilotos
    shuffle($positions); // Barajamos las posiciones

    foreach ($positions as $index => $position) {
        $rider = $allRiders[$index];
        $grandPrix->addRider($rider, $position);
    }

    $grandPrixs[] = $grandPrix;
}

?>
<!DOCTYPE html>
<html lang="en">
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/style.css">
    <title>Resultados del Gran Premio</title>
</head>

<body>
    <h1>Resultados del Gran Premio</h1>
    <h2>Equipos</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre del equipo</th>
                <th>País</th>
                <th>Mecánicos</th>
                <th>Pilotos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($teams as $team) { ?>
                <tr>
                    <td><?= $team->name ?></td>
                    <td><?= $team->country ?></td>
                    <td>
                        <?php foreach ($team->mechanics as $mechanic) { ?>
                            <?= $mechanic ?><br>
                        <?php } ?>
                    </td>
                    <td>
                        <?php foreach ($team->riders as $rider) { ?>
                            <?= $rider ?><br>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="race-grid">
        <?php foreach ($grandPrixs as $grandPrix) { ?>
            <div class="race-card">
                <h3><?= $grandPrix->circuit ?> - <?= date("d/m/Y", $grandPrix->date) ?></h3>
                <h4>Resultados</h4>
                <ul><?= $grandPrix->results() ?></ul>
            </div>
        <?php } ?>
    </div>

</body>

</html>