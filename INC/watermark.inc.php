<?php

//Establecemos la resolución correspondiente
$height=$width=15;
$waterMark=imagecreatetruecolor($height,$width);

$backgroundColor=imagecolorallocate($waterMark,255,255,255,40);
$blackColor=imagecolorallocate($waterMark,0,0,0);

imagefill($waterMark,0,0,$backgroundColor);
imagestring($waterMark,5,10,75,'IVAN TORRES',$blackColor);

header('content-type: image/png');
imagepng($waterMark);

imagedestroy($waterMark);