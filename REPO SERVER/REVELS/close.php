<?php
/**
 * @author Ivan Torres Marcos
 * @version 1.1
 * @description En close.php simplemente cerramos la session del usuario y la distruimos.
 *
 */
session_start();
// Cierra la sesión
session_destroy();
// Redirige al usuario a la página de inicio
header("Location: /index");
exit;