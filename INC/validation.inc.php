<?php

function validarFormulario() {
    // Validar el nombre del grupo
    if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
        $errores['nombre'] = 'El nombre del grupo es obligatorio.';
    } else if (strlen($_POST['nombre']) > 50) {
        $errores['nombre'] = 'El nombre del grupo no puede tener más de 50 caracteres.';
    }

    // Validar el género del grupo
    if (!isset($_POST['genero']) || empty($_POST['genero'])) {
        $errores['genero'] = 'El género del grupo es obligatorio.';
    } else if (strlen($_POST['genero']) > 50) {
        $errores['genero'] = 'El género del grupo no puede tener más de 50 caracteres.';
    }

    // Validar el país del grupo
    if (!isset($_POST['pais']) || empty($_POST['pais'])) {
        $errores['pais'] = 'El país del grupo es obligatorio.';
    } else if (strlen($_POST['pais']) > 20) {
        $errores['pais'] = 'El país del grupo no puede tener más de 20 caracteres.';
    }

    // Validar el año de inicio del grupo
    if (!isset($_POST['inicio']) || empty($_POST['inicio'])) {
        $errores['inicio'] = 'El año de inicio del grupo es obligatorio.';
    } else {
        $inicio = intval($_POST['inicio']);
        if ($inicio < 1990 || $inicio > 2023) {
            $errores['inicio'] = 'El año de inicio del grupo debe estar entre 1990 y 2023.';
        }
    }

    return $errores;
}
