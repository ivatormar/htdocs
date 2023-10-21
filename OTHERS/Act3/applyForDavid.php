<?php

/**
 * @author David Muñoz Herrero <davmunher2@alu.edu.gva.es>
 * 
 * @version 2.1 
 */

require_once(__DIR__ . '/inc/functions.inc.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oferta de trabajo</title>
</head>

<body>
    <?php

    $formats = [
        'userFormat' => '/^[a-zA-Z0-9_]+$/',
        //Debe contener solo letras (mayúsculas o minúsculas), números y guiones bajos.
        'nameAndSurnamesFormat' => '/^[a-zA-Z]+(?:\s[a-zA-Z]+)*$/',
        //Deben contener solo letras (mayúsculas o minúsculas) y espacios, y no pueden empezar ni terminar con un espacio.
        'DNIFormat' => '/^[0-9]{7,8}[A-Za-z]$/',
        //8 dígitos y una letra, o 7 dígitos y una letra
        'directionFormat' => '/^[a-zA-Z0-9\s\-.,#]+$/',
        //Acepta caracteres alfabéticos (mayúsculas y minúsculas), dígitos, espacios en blanco, guiones, comas, puntos, almohadillas (#)
        //y cualquier otro carácter que pueda ser comúnmente utilizado en una dirección.
        'emailFormat' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,}$/',
        //Debe seguir el formato estándar de una dirección de correo electrónico (nombre@dominio.tld).
        'phoneFormat' => '/^(?:(?:\+|00)34[\s]?)?[6-9]\d{8}$/',
        //Formato que debería seguir un número en España
        'birthDateFormat' => '/^\d{2}-\d{2}-\d{4}$/'
        //Expresión Regular (para el formato "DD-MM-YYYY")
    ];
    if (!empty($_POST['user'])) {
        //Si los campos están rellenados, veremos si cumplen el formato que deberían o si no, dependiendo de cada caso, almacenaremos la información en un array o en otro
        if (!preg_match($formats['userFormat'], $_POST['user'])) {
            $errors['userError'] = 'El campo USUARIO no es válido. Recuerda que éste debe contener solo letras (mayúsculas o minúsculas), números y guiones bajos.<br><br>';
        }
        if (!preg_match($formats['nameAndSurnamesFormat'], $_POST['name'])) {
            $errors['nameError'] = 'El campo NOMBRE no es válido. Recuerda que éste debe contener solo letras (mayúsculas o minúsculas) y espacios, y no pueden empezar ni terminar con un espacio.<br><br>';
        }
        if (!preg_match($formats['nameAndSurnamesFormat'], $_POST['surnames'])) {
            $errors['surnamesError'] = 'El campo APELLIDOS no es válido. Recuerda que éste debe contener solo letras (mayúsculas o minúsculas) y espacios, y no pueden empezar ni terminar con un espacio.<br><br>';
        }
        if (!preg_match($formats['DNIFormat'], $_POST['DNI'])) {
            $errors['DNIError'] = 'El campo DNI no es válido. Recuerda que éste debe tener 8 dígitos y una letra, o 7 dígitos y una letra<br><br>';
        }
        if (!preg_match($formats['directionFormat'], $_POST['direction'])) {
            $errors['directionError'] = 'El campo de la DIRECCIÓN no es válido. Recuerda que éste sólo acepta caracteres alfabéticos (mayúsculas y minúsculas), dígitos, espacios en blanco, guiones, comas, puntos, almohadillas (#)
            y cualquier otro carácter que pueda ser comúnmente utilizado en una dirección.<br><br>';
        }
        if (!preg_match($formats['emailFormat'], $_POST['email'])) {
            $errors['emailError'] = 'El campo del EMAIL no es válido. Recuerda que éste debe seguir el formato estándar de una dirección de correo electrónico (nombre@dominio.tld).<br><br>';
        }
        if (!preg_match($formats['phoneFormat'], $_POST['phone'])) {
            $errors['phoneError'] = 'El campo de la NÚMERO no es válido. Recuerda que éste debería ser un número de España<br><br>';
        }
        if (!preg_match($formats['birthDateFormat'], $_POST['birthDate'])) {
            $errors['birthDateError'] = 'El campo de la FECHA no es válido. Recuerda que éste tiene que tener el formato dd-mm-yyyy.<br><br>';
        }
        //Empezamos las comprobaciones de los archivos
        if (!empty($_FILES['curriculum'])) {
            if ($_FILES['curriculum']['error'] != UPLOAD_ERR_OK) {
                switch ($_FILES['curriculum']['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $errors['curriculumFileError'] = 'El fichero de tu curriculum es demasiado grande';
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $errors['curriculumFileError'] = 'No se ha podido subir todo tu archivo del curriculum';
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $errors['curriculumFileError'] = 'No se ha podido subir el fichero del curriculum';
                        break;
                    default:
                        $errors['curriculumFileError'] = 'Error indeterminado con tu fichero del curriculum';
                        break;
                }
            } else {
                if ($_FILES['curriculum']['type'] != 'application/pdf') {
                    $errors['curriculumFileError'] = 'El archivo del curriculum que has enviado no tiene el formato de pdf';
                } else {
                    //Empezamos a manejar el archivo (Ya no puede tener errores con las comprobaciones que hemos hecho)
                    if (dataIsRight($errors['userError'], $errors['nameError'], $errors['surnamesError'], $errors['DNIError'], $errors['directionError'], $errors['emailError'], $errors['phoneError'], $errors['birthDateError'])) {
                        if (is_uploaded_file($_FILES['curriculum']['tmp_name'])) {
                            if (!is_dir(__DIR__ .'/cvs')) {
                                mkdir(__DIR__ . '/cvs', 0777);
                            }
                            //Cuando no haya errores podemos procesar el fichero
                            $firstSurname = getFirstWord($_POST['surnames']);
                            $curriculumNewName = $_POST['DNI'] . '-' . $_POST['name'] . '-' . $firstSurname . '.pdf';
                            move_uploaded_file($_FILES['curriculum']['tmp_name'], __DIR__ . '/cvs/' . $curriculumNewName);
                        }
                    }
                }
            }
            if ($_FILES['photo']['error'] != UPLOAD_ERR_OK) {
                switch ($_FILES['photo']['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $errors['photoFileError'] = 'El fichero de tu foto es demasiado grande';
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $errors['photoFileError'] = 'No se ha podido subir todo tu archivo de la foto';
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $errors['photoFileError'] = 'No se ha podido subir el fichero de la foto';
                        break;
                    default:
                        $errors['photoFileError'] = 'Error indeterminado con tu fichero de la foto';
                        break;
                }
            } else {

                if ($_FILES['photo']['type'] != 'image/png') {
                    $errors['photoFileError'] = 'El archivo de la foto que has enviado no tiene el formato de png';
                } else {
                    //Empezamos a manejar el archivo (Ya no puede tener errores con las comprobaciones que hemos hecho)
                    if (dataIsRight($errors['userError'], $errors['nameError'], $errors['surnamesError'], $errors['DNIError'], $errors['directionError'], $errors['emailError'], $errors['phoneError'], $errors['birthDateError'])) {
                        if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                            if (!is_dir(__DIR__ . '/imgs/candidates')) {
                                mkdir(__DIR__ . '/imgs/candidates', 0777, true);
                            }
                            //Cuando no haya errores podemos procesar el fichero
                            $photoNewName = $_POST['DNI'] . '.png';
                            move_uploaded_file($_FILES['photo']['tmp_name'], __DIR__  . '/imgs/candidates/' . $photoNewName);
                        }
                    }
                }
            }
        } else {
            $errors['curriculumFileError'] = 'No has enviado el archivo del curriculum';
            if (empty($_FILES['photo'])){
                $errors['photoFileError'] = 'No has enviado el archivo de la foto'; 
            }
        }
    } else {
        $errors['voidError'] = 'No se puede dejar ningún campo vacío';
    }
    if (isset($errors)) {
        //Si hay algún error mostrará el formulario, sino mostrará un mensaje para informar que todo se ha enviado correctamente
    ?>
        <form method="post" action="#" enctype="multipart/form-data">
            <label for="user">Usuario: </label><br>
            <input id="user" type="text" name="user" value="<?= $_POST['user'] ?? '' ?>"><br>
            <p>
                <?= $errors['userError'] ?? '' ?>
            </p>

            <label for="name">Nombre: </label><br>
            <input id="name" type="text" name="name" value="<?= $_POST['name'] ?? '' ?>"><br>
            <p>
                <?= $errors['nameError'] ?? '' ?>
            </p>

            <label for="lastNames">Apellidos: </label><br>
            <input id="lastNames" type="text" name="surnames" value="<?= $_POST['surnames'] ?? '' ?>"><br>
            <p>
                <?= $errors['surnamesError'] ?? '' ?>
            </p>

            <label for="DNI">DNI: </label><br>
            <input id="DNI" type="text" name="DNI" value="<?= $_POST['DNI'] ?? '' ?>"><br>
            <p>
                <?= $errors['DNIError'] ?? '' ?>
            </p>

            <label for="direction">Dirección: </label><br>
            <input id="direction" type="text" name="direction" value="<?= $_POST['direction'] ?? '' ?>"><br>
            <p>
                <?= $errors['directionError'] ?? '' ?>
            </p>

            <label for="email">Email: </label><br>
            <input id="email" type="text" name="email" value="<?= $_POST['email'] ?? '' ?>"><br>
            <p>
                <?= $errors['emailError'] ?? '' ?>
            </p>

            <label for="phone">Teléfono: </label><br>
            <input id="phone" type="text" name="phone" value="<?= $_POST['phone'] ?? '' ?>"><br>
            <p>
                <?= $errors['phoneError'] ?? '' ?>
            </p>

            <label for="birthDate">Fecha de nacimiento: </label><br>
            <input id="birthDate" type="text" name="birthDate" value="<?= $_POST['birthDate'] ?? '' ?>"><br>
            <p>
                <?= $errors['birthDateError'] ?? '' ?>
            </p>
            <label for="curriculum">Tu currículum: </label><br>
            <input id="curriculum" type="file" name="curriculum"><br>
            <p>
                <?= $errors['curriculumFileError'] ?? '' ?>
            </p><br>

            <label for="photo">Foto tuya: </label><br>
            <input id="photo" type="file" name="photo"><br>
            <p>
                <?= $errors['photoFileError'] ?? '' ?>
            </p><br>

            <input type="hidden" name="MAX_FILE_SIZE" value="25000">
            <input type="submit" value="Enviar">
        </form>

    <?php
    } else {
        echo '<p>Has introducido toda la información correctamente</p>';
    }
    ?>
</body>

</html>