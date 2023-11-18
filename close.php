<?php
session_start();

// Cierra la sesión
session_destroy();

// Redirige al usuario a la página de inicio
header("Location: /index");
exit;
