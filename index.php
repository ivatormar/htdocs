<?php
include_once(__DIR__ . '/INC/utils.inc.php');
include_once(__DIR__ . '/INC/Person.inc.php');
include_once(__DIR__ . '/INC/GrandPrix.inc.php');
include_once(__DIR__ . '/INC/Rider.inc.php');
include_once(__DIR__ . '/INC/Mechanic.inc.php');
include_once(__DIR__ . '/INC/TraitCalcAge.inc.php');


$teams = $GLOBALS['teams'];
$circuits = $GLOBALS['circuits'];

// Añadir 2 mecánicos y 2 pilotos a cada equipo
foreach ($teams as $team) {
    for ($i = 0; $i < 2; $i++) {
        $mechanic = new Mechanic(randomName(), randomBirthday(), randomSpeciality());
        $team->addMechanic($mechanic);
        echo 'PILILA';
        $rider = new Rider(randomName(), randomBirthday(), randomDorsal($dorsals));
        $team->addRider($rider);
    }
    var_dump($mechanic);
    var_dump($rider);
}


// Crear carreras
// $grandPrixs = [];
// for ($i = 0; $i < 3; $i++) {
//     $circuit = $circuits[$i];
//     $grandPrix = new GrandPrix(randomDate(), $circuit);
//     foreach ($teams as $team) {
//         $riders = $team->getRiders();
//         foreach ($riders as $rider) {
//             $position = randomPosition();
//             $grandPrix->addRider($rider, $position);
//         }
//     }
//     $grandPrixs[] = $grandPrix;
// }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Resultados del Gran Premio</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Resultados del Gran Premio</h1>

    <h2>Equipos</h2>
    <table>
        <tr>
            <th>Equipo</th>
            <th>País</th>
            <th>Mecánicos</th>
            <th>Riders</th>
        </tr>
        <?php foreach ($teams as $team) : ?>
            <tr>
                <td><?php echo $team->name; ?></td>
                <td><?php echo $team->country; ?></td>
                <td>
                    <?php foreach ($team->mechanics as $mechanic) : ?>
                        <?php echo $mechanic->name . '<br>'; ?>
                    <?php endforeach; ?>
                </td>
                <td>
                    <?php foreach ($team->riders as $rider) : ?>
                        <?php echo $rider->name . '<br>'; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- <h2>Carreras</h2>
    <?php foreach ($grandPrixs as $grandPrix) : ?>
        <h3><?php echo $grandPrix->circuit->name; ?></h3>
        <table>
            <tr>
                <th>Posición</th>
                <th>Piloto</th>
                <th>Equipo</th>
            </tr>
            <?php foreach ($grandPrix->getResults() as $position => $rider) : ?>
                <tr>
                    <td><?php echo $position; ?></td>
                    <td><?php echo $rider->getName(); ?></td>
                    <td><?php echo $rider->getTeam()->getName(); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?> -->
</body>

</html>