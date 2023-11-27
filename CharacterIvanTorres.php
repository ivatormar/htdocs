<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cogemos el language que recibimos por el POST
    $_SESSION['language'] = $_POST['language'];
}

// Comprobamos si existe la variable de session
if (isset($_SESSION['language'])) {
    $character = [];
    if ($_SESSION['language'] === 'spanish') {
        $character['spanish'] = [
            'info' => 'Todo es un joven de complexión musculosa, piel bronceada y de alta estatura, midiendo aproximadamente lo mismo que Satoru Gojo[2]. Tiene el cabello ligeramente largo que siempre lleva recogido en un rodete con mechones desordenados sobresaliendo en la parte superior[4]. Sus ojos son pequeños y de color negro[5]. Una de sus características más notables es la gran cicatriz que lleva del lado izquierdo de su rostro. Tras los eventos ocurridos durante el Arco de El Incidente de Shibuya, se vio obligado a cortar su mano izquierda para no ser sometido a la desfiguración de Mahito[6].'
        ];
    } elseif ($_SESSION['language'] === 'valencian') {
        $character['valencian'] = [
            'info' => "Tot és un jove de complexió *musculosa, pell bronzejada i d'alta alçada, mesurant aproximadament el mateix que *Satoru *Gojo[2]. Té el cabell lleugerament llarg que sempre porta recollit en un *rodete amb flocs desordenats sobreeixint en la part superior[4]. Els seus ulls són xicotets i de color negre[5]. Una de les seues característiques més notables és la gran cicatriu que porta del costat esquerre del seu rostre. Després dels esdeveniments ocorreguts durant l'Arc de l'Incident de *Shibuya, es va veure obligat a tallar la seua mà esquerra per a no ser sotmés a la desfiguració de *Mahito[6]."
        ];
    } else {
        $character['english'] = [
            'info' => "Todo is a young man of muscular build, tanned skin and tall stature, measuring about the same height as Satoru Gojo[2]. He has slightly long hair that he always wears in a bun with messy locks sticking out at the top[4]. His eyes are small and black[5]. One of his most notable features is the large scar on the left side of his face. After the events that occurred during The Shibuya Incident Arc, he was forced to cut off his left hand so as not to be subjected to Mahito's disfigurement[6]."
        ];
    }
} else {
    // Cogemos el lenguaje por defecto que tenga nuestro navegador
    $defaultLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

    if ($defaultLanguage === 'es') {
        $character['spanish'] = [
            'info' => 'Todo es un joven de complexión musculosa, piel bronceada y de alta estatura, midiendo aproximadamente lo mismo que Satoru Gojo[2]. Tiene el cabello ligeramente largo que siempre lleva recogido en un rodete con mechones desordenados sobresaliendo en la parte superior[4]. Sus ojos son pequeños y de color negro[5]. Una de sus características más notables es la gran cicatriz que lleva del lado izquierdo de su rostro. Tras los eventos ocurridos durante el Arco de El Incidente de Shibuya, se vio obligado a cortar su mano izquierda para no ser sometido a la desfiguración de Mahito[6].'
        ];
        $_SESSION['language'] = 'spanish';
    } elseif ($defaultLanguage === 'ca') {
        $character['valencian'] = [
            'info' => "Tot és un jove de complexió *musculosa, pell bronzejada i d'alta alçada, mesurant aproximadament el mateix que *Satoru *Gojo[2]. Té el cabell lleugerament llarg que sempre porta recollit en un *rodete amb flocs desordenats sobreeixint en la part superior[4]. Els seus ulls són xicotets i de color negre[5]. Una de les seues característiques més notables és la gran cicatriu que porta del costat esquerre del seu rostre. Després dels esdeveniments ocorreguts durant l'Arc de l'Incident de *Shibuya, es va veure obligat a tallar la seua mà esquerra per a no ser sotmés a la desfiguració de *Mahito[6]."
        ];
        $_SESSION['language'] = 'valencian';
    } else {
        $character['english'] = [
            'info' => "Todo is a young man of muscular build, tanned skin and tall stature, measuring about the same height as Satoru Gojo[2]. He has slightly long hair that he always wears in a bun with messy locks sticking out at the top[4]. His eyes are small and black[5]. One of his most notable features is the large scar on the left side of his face. After the events that occurred during The Shibuya Incident Arc, he was forced to cut off his left hand so as not to be subjected to Mahito's disfigurement[6]."
        ];
        $_SESSION['language'] = 'english';
    }
}
?>

<!DOCTYPE html>
<html lang="<?php $defaultLanguage ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Character - Ivan Torres</title>
</head>

<body>
    <div class="content">
    <div class="tenor-gif-embed" data-postid="20976953" data-share-method="host" data-aspect-ratio="1.77778" data-width="60%"><a href="https://tenor.com/view/jujutsu-kaisen-aoi-todo-gif-20976953">Jujutsu Kaisen Aoi Todo GIF</a>from <a href="https://tenor.com/search/jujutsu+kaisen-gifs">Jujutsu Kaisen GIFs</a></div> <script type="text/javascript" async src="https://tenor.com/embed.js"></script>
        <?php
        $currentLanguage = $_SESSION['language'];
        echo '<h1> Aoi Todou </h1>';
        echo '<p>' . $character[$_SESSION['language']]['info'] . '</p>';
        ?>
    </div>

    <form method="POST" action="">
        <label for="language">Seleccione idioma:</label>
        <select name="language" id="language">
            <?php
            $languages = array(
                'spanish' => 'Español',
                'valencian' => 'Valencià',
                'english' => 'English'
            );

            foreach ($languages as $value => $label) {
                $selected = ($_SESSION['language'] === $value) ? 'selected' : '';
                echo "<option value=\"$value\" $selected>$label</option>";
            }
            ?>
        </select>
        <button type="submit">Cambiar</button>
    </form>
</body>

</html>