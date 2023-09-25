<title>Ivan Torres Marcos</title>
<link rel="stylesheet" href="styles.css">
<img src="IMG_20230114_145106.jpg" alt="yo">
<br>
<br>




<?php
echo ('<table border="1">');
echo ('<tr style="background-color: blue;">'); // Primera fila en azul
echo ('<td style="background-color: red;">X</td>'); // Primera celda en rojo

for ($i = 1; $i <= 10; $i++) { // Esto es para la primera fila
    echo ('<td>' . $i . '</td>');
}
echo ('</tr>');

for ($rows = 1; $rows <= 10; $rows++) {
    echo ('<tr');
    if ($rows % 2 == 0) {
        echo (' style="background-color: yellow;"'); // Filas pares en amarillo
    } else {
        echo (' style="background-color: green;"'); // Filas impares en verde
    }
    echo ('>'); //Aqui cerramos el tr
    echo ('<td style="background-color: blue;">' . $rows . '</td>'); // Primera columna en azul
    for ($col = 1; $col <= 10; $col++) {
        echo ('<td>' . $rows * $col . '</td>');
    }
    echo ('</tr>'); // Cerramos filas
}
echo ('</table>');
?>




