<?php function base64Encode($a)
{
	$encode = base64_encode($a);
	$encode = str_replace('+', '%2B', $encode);
	return $encode;
}
function base64Decode($encode)
{
	$decode = str_replace('%2B', '+', $encode);
	$decode = base64_decode($decode);
	return $decode;
}?>