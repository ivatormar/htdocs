<?php
session_start();
//Limpiamos todas las variables de sesion
session_unset();
// Cierra la sesión
session_destroy();
// Redirige al usuario a la página de inicio
header("Location: /index");
exit;