<?php 
require 'SecurityCard.php';
session_start();
$type = 'png';
$width = 50;
$height = 20;
$randval = randStr(4, '');
$_SESSION['slocation'] = $randval;
header('Content-type: image/' . $type);
srand((double) microtime() * 1000000);
if (($type != 'png') && function_exists('imagecreatetruecolor'))
{
	$im = @(imagecreatetruecolor($width, $height));
}
else
{
	$im = @(imagecreate($width, $height));
}
$r = array(210, 50, 120);
$g = array(240, 225, 235);
$b = array(250, 225, 10);
$rr = array(255, 240, 0);
$gg = array(100, 0, 0);
$bb = array(0, 0, 205);
$key = rand(0, 2);
$stringColor = ImageColorAllocate($im, 255, 255, 255);
$backColor = ImageColorAllocate($im, 18, 121, 226);
$borderColor = ImageColorAllocate($im, 16, 140, 232);
$pointColor = ImageColorAllocate($im, 18, 121, 226);
@(imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $backColor));
@(imagerectangle($im, 0, 0, $width - 1, $height - 1, $borderColor));
@(imagestring($im, 5, 7, 3, $randval, $stringColor));
$ImageFun = 'Image' . $type;
$ImageFun($im);
@(ImageDestroy($im));
function randStr($len = 6, $format = 'ALL')
{
	$scode = new SecurityCard();
	return $scode->getLocation();
}
?>