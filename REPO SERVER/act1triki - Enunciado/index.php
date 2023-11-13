<?php

/**
 *	Script que informa del uso de cookies en él
 * 
 *	@author Iván Torres Marcos
 *	@version V.1.3
 *	@description Implementamos "facilmenete" el uso de las cookies en esta app
 */

if (!isset($_COOKIE['theme'])) {
	setcookie('theme', 'dark', time() + 60);
}

if (isset($_GET['accept'])) {
	if ($_GET['accept'] == true) {
		setcookie('accept', 'true', time() + 60, httponly: true);
		header('location:index.php');
		exit;
	}
}

//Si el theme es true, y clicamos en el boton de light me setea el css al de light, sino dark
if (isset($_GET['theme'])) {
	if ($_GET['theme'] == 'light') {
		$cssStyle = 'light';
		setcookie('theme', 'light');
	} else {
		$cssStyle = 'dark';
		setcookie('theme', 'dark');
	}
} else {
	$cssStyle = 'dark';
}

//Si recibimos por get el delete al clicar, me borra las cookies de theme creada previamente
if (isset($_GET['delete'])) {
	setcookie('theme', '', time() - 1);
	setcookie('accept', '', time() - 1);

	header('location:index.php');
	exit;
}

?>
<!doctype html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Triki: el monstruo de las Cookies</title>
	<link rel="stylesheet" href="css/<?= $cssStyle ?>.css">
</head>

<body>
	<?php
	if (!isset($_COOKIE['accept'])) {
		echo '<div id="cookies">
		Este sitio web utiliza cookies propias y puede que de terceros.<br>
		Al utilizar nuestros servicios, aceptas el uso que hacemos de las cookies.<br>
		<div><a href="index.php?accept=true;">ACEPTAR</a></div>
	</div>';
	}
	?>
	<h1>Bienvenido a la web de Triki, el monstruo de las cookies</h1>

	<h2>Bienvenido a la web donde no se gestionan las cookies, se devoran.</h2>
	<img src="img/triki.jpg" alt="Imagen de triki mirando una galleta">

	<div id="botones">
		<a href="index.php?theme=light" class="styleButton">Claro</a>
		<a href="index.php?theme=dark" class="styleButton">Oscuro</a>
	</div>
	<br>

	<div><a href="index.php?delete">Borrar cookies</a></div>
</body>

</html>