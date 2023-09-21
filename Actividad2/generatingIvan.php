<ul>
    <?php
    for ($i = 1; $i <= 5; $i++) {
        echo ('<li><a href="#sec' . $i . '">Section '  . $i . '</li></a>');
    }

    ?>

</ul>


<?php
echo ('<h1 id="sec1">Negativo-Cero-Positivo</h1>');
$number = rand(-200, 200);
$result = $number <=> 0;
if ($result == -1) {
    echo ('El numero ' . $number . ' es negativo');
} else if ($result == 0) {
    echo ('El numero ' . $number . ' es cero');
} else {
    echo ('El numero ' . $number . ' es positivo');
}
?>

<?php
echo ('<h1 id="sec2">Nota media</h1>');
$finalmark = rand(0, 10);
switch ($finalmark) {
    case 0:
    case 1:
    case 2:
        $finalmark = 'Insuficiente';
        break;
    case 3:
        $finalmark = 'Necesita mejorar';
        break;
    case 4:
        $finalmark = 'Necesita mejorar';
        break;
    case 5:
        $finalmark = 'Aprobado justito';
        break;
    case 6:
        $finalmark = 'Aprobado';
        break;
    case 7:
        $finalmark = 'Notable bajo';
        break;
    case 8:
        $finalmark = 'Notable';
        break;
    case 9:
        $finalmark = 'Sobresaliente';
        break;
    case 10:
        $finalmark = 'Sobresaliente';
        break;
    default:
        echo ('Valor no valido');
        break;
}

?>
<p>Marina Fez tiene una nota media de <?= $finalmark ?></p>

<?php
$ntomultiply = rand(0, 100);
echo ('<h1 id="sec3">Tabla de multiplicar del ' . $ntomultiply . '</h1>');

echo ('<table border="2">
        <tr>
            <td>x</td>
            <td>' . $ntomultiply . '</td>
        </tr>');
for ($i = 0; $i <= 20; $i++) {
    echo ('<tr>
            <td>' . $i . '</td>
            <td>' . $ntomultiply * $i . '</td>
            </tr>');
}
echo ('</table>');

?>

<?php
$columns = rand(1, 10);
$rows = rand(1, 10);
echo '<h1 id="sec4">Tabla de ' . $rows . ' Filas y ' . $columns . ' Columnas</h1>';
echo '<table border="1">';

for ($i = 0; $i < $rows; $i++) { //Aqui tenemos que hacer dos bucles, uno para las filas y otro columnas
    echo ('<tr>');
    for ($j = 0; $j < $columns; $j++) {
        echo ('<td>' . $i . 'x' . $j . '</td>');
    }
    echo ('</tr>');
}
echo '</table>';
?>

<?php

$numRandom = rand(1, 1000);


echo ('<h1 id="sec5">Cálculo de cambio</h1>');

echo ('Total a devolver: ' . $numRandom . '</br>');

$bill500 = intval($numRandom / 500); //Con intval tomamos la parte entera de la división y lo dividimos por 500
$numRandom = $numRandom % 500;
$bill200 = intval($numRandom / 200);
$numRandom = $numRandom % 200;
$bill100 = intval($numRandom / 100);
$numRandom = $numRandom % 100;
$bill50 = intval($numRandom / 50);
$numRandom = $numRandom % 50;
$bill20 = intval($numRandom / 20);
$numRandom = $numRandom % 20;
$bill10 = intval($numRandom / 10);
$numRandom = $numRandom % 10;
$bill5 = intval($numRandom / 5);
$numRandom = $numRandom % 5;
$moneda2 = intval($numRandom / 2);
$numRandom = $numRandom % 2;
$moneda1 = $numRandom;

echo ("$bill500 billetes de 500<br>");
echo ("$bill200 billetes de 200<br>");
echo ("$bill100 billetes de 100<br>");
echo ("$bill50 billetes de 50<br>");
echo ("$bill20 billetes de 20<br>");
echo ("$bill10 billetes de 10<br>");
echo ("$bill5 billete sde 5<br>");
echo ("$moneda2 monedas de 2<br>");
echo ("$moneda1 monedas de 1<br>");
?>