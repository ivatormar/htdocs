<?php

/**
 * @author Ivan Torres Marcos
 * @version 1.0
 * @description Un simple logout, limpiamos variables de sesion para no ocupar "espacio" y finalmente destruimos la sesion y lo redirigimos a index.php
 *
 */
session_start();
//Limpiamos todas las variables de sesion
session_unset();
// Cierra la sesión
session_destroy();
// Redirige al usuario a la página de inicio
header("Location: /index");
exit();