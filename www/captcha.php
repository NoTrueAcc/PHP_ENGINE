<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17.04.2017
 * Time: 20:22
 */

session_start();
$rand = mt_rand(1000, 9999);
$_SESSION['rand'] = $rand;
$im = imagecreatetruecolor(90, 50);
$c = imagecolorallocate($im, 255, 255, 255);
imagettftext($im, 20, -10, 10, 30, $c, "fonts/verdana.ttf", $rand);
header("Content-type: image/png");
imagepng($im);
imagedestroy($im);

?>