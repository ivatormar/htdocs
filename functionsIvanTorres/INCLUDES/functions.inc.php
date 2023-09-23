<?php




function numbComparison(int $random1, int $random2)
{
    if ($random1 > $random2) {
        return ('El primer número, ' . $random1 . ' <b>es MAYOR</b> que el segundo ' . $random2);
    } else if ($random1 < $random2) {
        return ('El primer número, ' . $random1 . ' <b>es MENOR</b> que el segundo ' . $random2);
    } else {
        return ('Ambos números <b>son iguales</b>, primer número: ' . $random1 . ', segundo número: ' . $random2);
    }
}

function numbOddOrEven(int $random)
{
    if ($random % 2 == 0) {
        return 'El  número, ' . $random . ' <b>es PAR</b> ';
    } else {
        return 'El  número, ' . $random . ' <b>es IMPAR</b> ';
    }
}

function sumOperation(int $random1, int $random2)
{
    return 'Suma de: ' . $random1 . ' + ' . $random2 . ' = <b>' . $random1 + $random2 . '</b>';
}

function subtractionOperation(int $random1, int $random2)
{
    return 'Resta de: ' . $random1 . ' - ' . $random2 . ' = <b>' . $random1 - $random2 . '</b>';
}

function multiplicationOperation(int $random1, int $random2)
{
    return 'Multiplicación de: ' . $random1 . ' x ' . $random2 . ' = <b>' . $random1 * $random2 . '</b>';
}

function divisionOperation(int $random1, int $random2)
{

    return 'División de: ' . $random1 . ' / ' . $random2 . ' = <b>' . $random1 / $random2 . '</b>';
}

function moduleOperation(int $random1, int $random2)
{

    return 'Módulo de: ' . $random1 . ' % ' . $random2 . ' = <b>' . $random1 % $random2 . '</b>';
}

function powOperation(int $random1, int $random2)
{
    $resultado = $random1 ** $random2;

    if ($resultado == INF) {
        return 'Potencia de: ' . $random1 . ' con base ' . $random2 . ' = <b>' . bcpow($random1, $random2) . '</b>'; //Te he puesto el bcpow para poder representar el INFINITY, ya que al generar numeros random entre 1 a 1000 y potenciarlos se representa como INF, sorry por el scrolling horizontal
    } else {
        return 'Potencia de: ' . $random1 . ' con base ' . $random2 . ' = <b>' . $resultado . '</b>';
    }
}
