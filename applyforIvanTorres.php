<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once(__DIR__ . '/INC/functions.inc.php');

/**
 * @author Ivan Torres Marcos
 * @version V1.2
 * @description En este archivo php hemos introducidos los datos los cuales se verán reflejados en productIvanTorres
 */



$userExpr = '/^[a-z0-9_]+$/'; //User: Debe contener solo letras minúsculas, números y guiones bajos.
$nameandSurnamesExpr = '/^[A-z\s]+$/'; //Nombre y apellidos: Debe contener solo letras mayúsculas y minúsculas, y puede incluir espacios.
$dniExpr = '/^\d{8}[A-HJ-NP-TV-Z]$/'; //DNI: Debe seguir el patrón de 8 dígitos seguido de una letra en mayúscula (puede ser 'X', 'Y' o 'Z' para casos especiales).
$directionExpr = '/^[a-zA-Z0-9\s,.-\/]+$/'; //Dirección: Puede contener letras mayúsculas y minúsculas, números, espacios y los siguientes caracteres especiales: coma, punto, guion, número de casa y barra diagonal.
$emailExpr = '/^[\w.-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/'; //Email: Debe seguir el patrón de una o más letras, números, guiones, puntos o guiones bajos, seguidos de un símbolo de arroba (@), seguido de un dominio válido (p. ej., gmail.com).
$mobilephoneNumberExpr = '/^[\d\s()-]+$/'; //Teléfono: Puede contener solo números, y puede incluir paréntesis, guiones y espacios en formatos comunes de números de teléfono.
$birthDateExpr = '/^\d{2}-\d{2}-\d{4}$/'; // Fecha de nacimiento: Puede contener solo números, y puede incluir paréntesis, guiones y espacios en formatos comunes de números de teléfono.

$errorMessages = []; //Creamos un array para almacenar todos los errores que tengamos
$requiredMessages = []; //Creamos un array para almacenar todos los requires que tengamos
$successMessages = []; //Creamos un array para almacenar los mensajes de exito



if (isset($_POST['name'])) {

    //USER
    if (!isset($_POST['user']) || empty($_POST['user'])) { //Ponemos el empty para validar que no es un string vacío
        $requiredMessages['user'] = 'El campo USUARIO es obligatorio.<br>';
    } else {

        $_POST['user'] = trim($_POST['user']);
        if (!preg_match($userExpr, $_POST['user'])) {
            $errorMessages['user'] = 'Usuario: Debe contener solo letras minúsculas, números y guiones bajos.';
        } else {
            $successMessages['user'] = 'Usuario enviado correctamente.';
        }
    }

    //NAME
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $requiredMessages['name'] = 'El campo NOMBRE es obligatorio.<br>';
    } else {
        $_POST['name'] = trim($_POST['name']); //Eliminamos los espacios
        if (!preg_match($nameandSurnamesExpr, $_POST['name'])) {
            $errorMessages['name'] = 'Nombre y apellidos: Debe contener solo letras mayúsculas y minúsculas, y puede incluir espacios.';
        } else {
            $successMessages['name'] = 'Nombre enviado correctamente.';
        }
    }
    //SURNAME
    if (!isset($_POST['surname']) || empty($_POST['surname'])) {
        $requiredMessages['surname'] = 'El campo APELLIDOS es obligatorio.<br>';
    } else {
        $_POST['surname'] = trim($_POST['surname']); //Eliminamos los espacios
        if (!preg_match($nameandSurnamesExpr, $_POST['surname'])) {
            $errorMessages['surname'] = 'Nombre y apellidos: Debe contener solo letras mayúsculas y minúsculas, y puede incluir espacios.';
        } else {
            $successMessages['surname'] = 'Apellidos enviado correctamente.';
        }
    }


    //DNI
    if (!isset($_POST['dni']) || empty($_POST['dni'])) {
        $requiredMessages['dni'] = 'El campo DNI es obligatorio.<br>';
    } else {
        $_POST['dni'] = trim($_POST['dni']);
        if (validarDNI($_POST['dni'])) {
            if (!preg_match($dniExpr, $_POST['dni'])) {
                $errorMessages['dni'] = 'DNI: Debe seguir el patrón de 8 dígitos seguido de una letra en mayúscula para casos especiales.';
            } else {
                $successMessages['dni'] = 'DNI enviado correctamente.';
            }
        }
    }

    //DIRECTION
    if (!isset($_POST['direction']) || empty($_POST['direction'])) {
        $requiredMessages['direction'] = 'El campo DIRECCIÓN es obligatorio.<br>';
    } else {
        $_POST['direction'] = trim($_POST['direction']);
        if (!preg_match($directionExpr, $_POST['direction'])) {
            $errorMessages['direction'] = 'Dirección: Puede contener letras mayúsculas y minúsculas, números, espacios y los siguientes caracteres especiales: coma, punto, guion, número de casa y barra diagonal.';
        } else {
            $successMessages['direction'] = 'Dirección enviado correctamente';
        }
    }

    //EMAIL
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $requiredMessages['email'] = 'El campo EMAIL es obligatorio.<br>';
    } else {
        $_POST['email'] = trim($_POST['email']);
        if (!preg_match($emailExpr, $_POST['email'])) {
            $errorMessages['email'] = 'Email: Debe seguir el patrón de una o más letras, números, guiones, puntos o guiones bajos, seguidos de un símbolo de arroba (@), seguido de un dominio válido (p. ej., gmail.com).';
        } else {
            $successMessages['email'] = 'Email enviado correctamente.';
        }
    }
    //MOBILEPHONENUMBER
    if (!isset($_POST['mobilephoneNumber']) || empty($_POST['mobilephoneNumber'])) {
        $requiredMessages['mobilephoneNumber'] = 'El campo TELÉFONO es obligatorio.<br>';
    } else {
        $_POST['mobilephoneNumber'] = trim($_POST['mobilephoneNumber']);
        if (!preg_match($mobilephoneNumberExpr, $_POST['mobilephoneNumber'])) {
            $errorMessages['mobilephoneNumber'] = 'Teléfono: Debe seguir el patrón de una o más letras, números, guiones, puntos o guiones bajos, seguidos de un símbolo de arroba (@), seguido de un dominio válido (p. ej., gmail.com).';
        } else {
            $successMessages['mobilephoneNumber'] = 'Teléfono enviado correctamente';
        }
    }

    //BIRTHDATE
    if (!isset($_POST['birthDate']) || empty($_POST['birthDate'])) {
        $requiredMessages['birthDate'] = 'El campo FECHA DE NACIMIENTO es obligatorio.<br>';
    } else {
        $_POST['birthDate'] = trim($_POST['birthDate']);
        if (!preg_match($birthDateExpr, $_POST['birthDate'])) {
            $errorMessages['birthDate'] = 'Fecha de nacimiento: Debe seguir este formato dd-mm-aaaa.';
        } else {
            $successMessages['birthDate'] = 'Fecha de nacimiento enviado correctamente';
        }
    }
}











?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <?php require_once(__DIR__ . '/INC/header.inc.php'); ?>
</head>

<body>
    <h1>Oferta de trabajo</h1>
    <?php if (count($successMessages) == 8) {
        echo '<h1 class="success"> 🐸 Todos los campos se han enviado correctamente 🐸</h1>';
        echo '<iframe src="https://giphy.com/embed/XIqCQx02E1U9W" width="780" height="400" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>';
    } else { ?>
        <div class="form-container">

            <form action="#" method="post"> <!--Lo que hacemos con el php de value es comprobar si existe la variable y si tiene el contador de errores a 0 entonces si es asi setea la variable al valor introducido, sino la limpia -->
                <label for="user">Usuario</label><input type="text" name="user" value="<?php echo isset($_POST['user']) && preg_match($userExpr, $_POST['user']) ? $_POST['user']  : ''; ?>"><br>
                <?php echo showMessages('user', $requiredMessages, $errorMessages) ?>
                <label for="name">Nombre</label> <input type="text" name="name" value="<?php echo isset($_POST['name']) && preg_match($nameandSurnamesExpr, $_POST['name']) ? $_POST['name'] : ''; ?>"><br>
                <?php echo showMessages('name', $requiredMessages, $errorMessages) ?>
                <label for="surname">Apellidos</label> <input type="text" name="surname" value="<?php echo isset($_POST['surname']) && preg_match($nameandSurnamesExpr, $_POST['surname']) ? $_POST['surname'] : ''; ?>"><br>
                <?php echo showMessages('surname', $requiredMessages, $errorMessages) ?>
                <label for="dni">DNI</label><input type="text" name="dni" value="<?php echo isset($_POST['dni']) && preg_match($dniExpr, $_POST['dni']) && validarDNI($_POST['dni']) ? $_POST['dni'] : ''; ?>"><br>
                <?php echo showMessages('dni', $requiredMessages, $errorMessages) ?>
                <label for="direction">Dirección</label> <input type="text" name="direction" value="<?php echo isset($_POST['direction']) && preg_match($directionExpr, $_POST['direction']) ? $_POST['direction'] : ''; ?>"><br>
                <?php echo showMessages('direction', $requiredMessages, $errorMessages) ?>
                <label for="email">Email</label> <input type="text" name="email" value="<?php echo isset($_POST['email']) && preg_match($emailExpr, $_POST['email']) ? $_POST['email'] : ''; ?>"><br>
                <?php echo showMessages('email', $requiredMessages, $errorMessages) ?>
                <label for="mobilephoneNumber">Teléfono</label><input type="text" name="mobilephoneNumber" value="<?php echo isset($_POST['mobilephoneNumber']) && preg_match($mobilephoneNumberExpr, $_POST['mobilephoneNumber']) ? $_POST['mobilephoneNumber'] : ''; ?>"><br>
                <?php echo showMessages('mobilephoneNumber', $requiredMessages, $errorMessages) ?>
                <label for="birthDate">Fecha de nacimiento</label><input type="text" name="birthDate"><br>
                <?php echo showMessages('birthDate', $requiredMessages, $errorMessages) ?>
                <input type="submit" value="Enviar" class="btn">
            </form>
        </div>
    <?php } ?>


</body>

</html>