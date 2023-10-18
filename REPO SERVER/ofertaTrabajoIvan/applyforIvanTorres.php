<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once(__DIR__ . '/INC/functions.inc.php');

/**
 * @author Ivan Torres Marcos
 * @version V1.3
 * @description En este archivo php hemos implementado todas las funciones requeridas en el ejercicio parte 1
 * realizará todas las tareas (mostrar formularios, validar datos, mostrar errores, mostrar mensaje de éxito).

 * Si se necesita se pueden crear archivos adicionales para estilos o para almacenar funciones php.
 * Si todos los campos son correctos muestra un mensaje indicando que se ha registrado correctamente la solicitud y no se mostrará el formulario.
 * Si algún campo no cumple los requisitos se mostrará otra vez el formulario original pero esta vez con todos los campos ya introducidos anteriormente y con un mensaje informativo debajo de cada campo erróneo
 * 
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
$successMessages = []; //Creamos un array para almacenar los mensajes de éxito



if (isset($_POST['name'])) {

    //USER
    if (!isset($_POST['user']) || empty($_POST['user'])) { //Ponemos el empty para validar que no es un string vacío
        $requiredMessages['user'] = 'El campo USUARIO es obligatorio.<br>'; //AÑadimos el mensaje al $requiredmessages
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
        if (validarDNI($_POST['dni']) && preg_match($dniExpr, $_POST['dni'])) {
            $successMessages['dni'] = 'DNI enviado correctamente.';
        } else {
            $errorMessages['dni'] = 'DNI: Debe seguir el patrón de 8 dígitos seguido de una letra en mayúscula para casos especiales.';
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

    //PHOTO
    //Si existe el files photo y si al subirlo no tiene ningún error seguimos (esto último me faltaba para poder mostrar el mensaje de que la foto debe ser
    //en formato .png del $requiredMessages, sino, no funcionaba)
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['photo']['type'] === 'image/png') {
            $newRoute = './MEDIA/candidates/' . $_POST['dni'] . '.png';
            $success = move_uploaded_file($_FILES['photo']['tmp_name'], $newRoute);

            if ($success) {
                $successMessages['photo'] = 'Foto subida correctamente';
            } else {
                $errorMessages['photo'] = 'Error al guardar la foto en el servidor.';
            }
        } else {
            $errorMessages['photo'] = 'La foto debe ser en formato .PNG';
        }
    } else {
        $requiredMessages['photo'] = 'Debe subir una FOTO';
    }
    //CV
    //Si existe el files CV y si al subirlo no tiene ningún error seguimos (esto último me faltaba para poder mostrar el mensaje de que la foto debe ser
    //en formato .pdf del $requiredMessages, sino, no funcionaba)
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['cv']['type'] === 'application/pdf') {
            $newRoute = './CVS/' .$_POST['dni']. '-' .$_POST['name']. '-' .$_POST['surname']. '.pdf';
            $success = move_uploaded_file($_FILES['cv']['tmp_name'], $newRoute);

            if ($success) {
                $successMessages['cv'] = 'Curriculum subida correctamente';
            } else {
                $errorMessages['cv'] = 'Error al guardar el CV en el servidor.';
            }
        } else {
            $errorMessages['cv'] = 'El CV debe ser en formato .PDF';
        }
    } else {
        $requiredMessages['cv'] = 'Debe subir un CV';
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Etiquetas para el cache -->
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <?php require_once(__DIR__ . '/INC/header.inc.php'); ?>
</head>

<body>
    <h1>Oferta de trabajo</h1>
    <?php if (count($successMessages) == 10) { //Este if lo hemos metido para que si el array de successMessages es = a 10 (numero total de campos validos) muestre el siguiente mensaje, sino sigas rellenando el form
        echo '<h1 class="success"> 🐸 Todos los campos se han enviado correctamente 🐸</h1>';
        echo '<iframe src="https://giphy.com/embed/XIqCQx02E1U9W" width="780" height="400" frameBorder="0" allowFullScreen></iframe>';
    } else { ?>
        <div class="form-container">
            <form action="#" method="post" enctype="multipart/form-data">
                <!--Lo que hacemos con el php de value es comprobar si existe la variable y si cumple con el pregmatch correspondiente, sino la limpia -->
                <label for="user">Usuario</label><input type="text" name="user" value="<?php echo isset($_POST['user']) && preg_match($userExpr, $_POST['user']) ? $_POST['user']  : ''; ?>"><br>
                <?php echo showMessages('user', $requiredMessages, $errorMessages) ?>
                <label for="name">Nombre</label> <input type="text" name="name" value="<?php echo isset($_POST['name']) && preg_match($nameandSurnamesExpr, $_POST['name']) ? $_POST['name'] : ''; ?>"><br>
                <?php echo showMessages('name', $requiredMessages, $errorMessages) ?>
                <label for="surname">Apellidos</label> <input type="text" name="surname" value="<?php echo isset($_POST['surname']) && preg_match($nameandSurnamesExpr, $_POST['surname']) ? $_POST['surname'] : ''; ?>"><br>
                <?php echo showMessages('surname', $requiredMessages, $errorMessages) ?>
                <label for="dni">DNI</label><input type="text" name="dni" value="<?php echo isset($_POST['dni']) && preg_match($dniExpr, $_POST['dni'])  ? $_POST['dni'] : ''; ?>"><br>
                <?php echo showMessages('dni', $requiredMessages, $errorMessages) ?>
                <label for="direction">Dirección</label> <input type="text" name="direction" value="<?php echo isset($_POST['direction']) && preg_match($directionExpr, $_POST['direction']) ? $_POST['direction'] : ''; ?>"><br>
                <?php echo showMessages('direction', $requiredMessages, $errorMessages) ?>
                <label for="email">Email</label> <input type="text" name="email" value="<?php echo isset($_POST['email']) && preg_match($emailExpr, $_POST['email']) ? $_POST['email'] : ''; ?>"><br>
                <?php echo showMessages('email', $requiredMessages, $errorMessages) ?>
                <label for="mobilephoneNumber">Teléfono</label><input type="text" name="mobilephoneNumber" value="<?php echo isset($_POST['mobilephoneNumber']) && preg_match($mobilephoneNumberExpr, $_POST['mobilephoneNumber']) ? $_POST['mobilephoneNumber'] : ''; ?>"><br>
                <?php echo showMessages('mobilephoneNumber', $requiredMessages, $errorMessages) ?>
                <label for="birthDate">Fecha de nacimiento</label><input type="text" name="birthDate" value="<?php echo isset($_POST['birthDate']) && preg_match($birthDateExpr, $_POST['birthDate']) ? $_POST['birthDate'] : ''; ?>"><br>
                <?php echo showMessages('birthDate', $requiredMessages, $errorMessages) ?>
                <label for="photo">Foto </label><input type="file" name="photo">
                <?php echo showMessages('photo', $requiredMessages, $errorMessages) ?>
                <label for="cv">CV </label><input type="file" name="cv">
                <?php echo showMessages('cv', $requiredMessages, $errorMessages) ?><br>

                <input type="submit" value="Enviar" class="btn">
            </form>
        </div>
    <?php } ?>
</body>

</html>