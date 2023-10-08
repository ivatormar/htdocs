<?php

function validarDNI($dni)
{
    // Eliminar posibles espacios y letras en mayúscula
    $dni = strtoupper(trim($dni)); //

    // Comprobar longitud del DNI
    if (strlen($dni) !== 9) {
        return false;
    }

    // Obtener número y letra del DNI
    $numero = substr($dni, 0, 8);
    $letra = substr($dni, -1);

    // Comprobar que el número del DNI es válido
    if (!is_numeric($numero)) {
        return false;
    }

    // Calcular letra esperada
    $letraEsperada = "TRWAGMYFPDXBNJZSQVHLCKE";
    $indice = $numero % 23;
    $letraCalculada = $letraEsperada[$indice];

    // Comparar letra esperada con letra del DNI
    if ($letra !== $letraCalculada) {
        return false;
    }

    return true;
}
