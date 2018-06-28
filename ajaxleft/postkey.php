<?php 
if (isset($_SESSION['postkey']) && (0 < strlen($_SESSION['postkey']))){
	$_SESSION['postkey'] = $_SESSION['postkey'];
}else{
	$_SESSION['postkey'] = md5(uniqid(rand(), true));
}

$postkey = $_SESSION['postkey'];

function StrToHex($string, $postkey){
	$hex = '';
	for ($i = 0;$i < strlen($string);$i++){
		$hex .= dechex(ord($string[$i]));
	}
	$hex = strtoupper($hex);
	return strtoupper(md5($hex . $postkey));
}
?>