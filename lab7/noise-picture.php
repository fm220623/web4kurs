<?php
session_start();

$image = imagecreatefromjpeg('noise.jpg');
$textColor = imagecolorallocate($image, 0, 0, 0);

$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
$string = '';
for ($i = 0; $i < 5; $i++) {
    $string .= $chars[rand(0, strlen($chars) - 1)];
}

$_SESSION['captcha'] = $string;

$fonts = ['fonts/bellb.ttf', 'fonts/georgia.ttf'];

$x = 20;
for ($i = 0; $i < strlen($string); $i++) {
    $font = $fonts[rand(0, 1)];
    $size = rand(18, 30);
    $angle = rand(-15, 15);
    
    imagettftext($image, $size, $angle, $x, 30, $textColor, $font, $string[$i]);
    $x += 40;
}

header('Content-Type: image/jpeg');
imagejpeg($image, NULL, 50);
imagedestroy($image);
?>