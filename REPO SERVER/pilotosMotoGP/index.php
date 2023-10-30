<?php
include_once(__DIR__.'/INC/utils.inc.php');
include_once(__DIR__.'/INC/Person.inc.php');
include_once(__DIR__.'/INC/GrandPrix.inc.php');
include_once(__DIR__.'/INC/Rider.inc.php');
include_once(__DIR__.'/INC/Mechanic.inc.php');
include_once(__DIR__.'/INC/TraitCalcAge.inc.php');




$teams = []; // Array de equipos
$circuits = []; // Array de circuitos

// Genera equipos y circuitos aleatorios
for ($i = 0; $i < 4; $i++) {
    $team = new Team(randomName(), randomName(), randomName());
    $mechanic1 = new Mechanic(randomName(), randomBirthday(), randomSpeciality());
    $mechanic2 = new Mechanic(randomName(), randomBirthday(), randomSpeciality());
    $rider1 = new Rider(randomName(), randomBirthday(), randomDorsal($dorsals));
    $rider2 = new Rider(randomName(), randomBirthday(), randomDorsal($dorsals));
    $team->addMechanic($mechanic1);
    $team->addMechanic($mechanic2);
    $team->addRider($rider1);
    $team->addRider($rider2);
    $teams[] = $team;
}

// // Genera 3 carreras
// $grandPrix1 = new GrandPrix($circuits[0], randomDate(), 1);
// $grandPrix2 = new GrandPrix($circuits[1], randomDate(), 2);
// $grandPrix3 = new GrandPrix($circuits[2], randomDate(), 3);

// Agrega pilotos a las carreras con la posición obtenida


// Muestra la información de los equipos y los resultados de las 3 carreras
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resultados de Carreras</title>
</head>
<body>
    <h1>Información de los Equipos</h1>
    <ul>
        <?php foreach ($teams as $team) {
            echo $team->__toString();

        }
        
        ?>
           
        
    </ul>

    <h1>Resultados de las Carreras</h1>
    <h2>Carrera 1</h2>
    <pre><?php echo $grandPrix1->results(); ?></pre>
    <h2>Carrera 2</h2>
    <pre><?php echo $grandPrix2->results(); ?></pre>
    <h2>Carrera 3</h2>
    <pre><?php echo $grandPrix3->results(); ?></pre>
</body>
</html>
