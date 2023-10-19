<?php
/**
 * @author Iván Torres Marcos
 * @version 1.2
 * @description Creación de la marca de agua
 *
 */
$image=imagecreatefromstring(file_get_contents($_GET['img']));
$blueColor=imagecolorallocatealpha($image,0,191,255,75);
$myName='IVAN TORRES';

imagettftext($image, 35, 0, 11, 75, $blueColor, __DIR__.'/Bulletto-Killa.ttf', $myName);

header('Content-type:image/png');
imagepng($image);

imagedestroy($image);


