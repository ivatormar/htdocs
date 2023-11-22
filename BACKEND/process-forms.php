<?php

// Procesar el formulario de actualización del perfil
if (isset($_POST['update_profile'])) {
    // Procesar el formulario de actualización
    include_once(__DIR__.'/account.inc.php');
}

// Procesar el formulario de eliminación de revelación
elseif (isset($_POST['delete_revel'])) {
    include_once(__DIR__.'/delete.inc.php');
}

// Procesar el formulario de confirmación de eliminación de cuenta
elseif (isset($_POST['confirm_delete_account'])) {
    include_once(__DIR__.'/cancel.inc.php');
}
?>