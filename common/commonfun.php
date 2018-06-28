<?php 
function get_client_ip(){
	if (isset($_SERVER['HTTP_X_REAL_FORWARDED_FOR'])){
		$ip = $_SERVER['HTTP_X_REAL_FORWARDED_FOR'];
	}else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else if (isset($_SERVER['HTTP_CLIENT_IP'])){
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	!is_valid_ip_addr($ip)&&$ip = $_SERVER['REMOTE_ADDR'];
	return $ip;
}

function is_valid_ip_addr($ip=NULL){
	$_return = !empty($ip);
	$_return&&$_return = preg_match('/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/', $ip, $matches)?true:false;
	$_return&&$_return = $matches[1]>0&&$matches[1]<255;
	$_return&&$_return = max(array($matches[2], $matches[3], $matches[4]))<255;
	return $_return;
}

function display_error_exit($error_msg){
	header('Content-type: text/html;charset=utf-8');
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" />";
	exit($error_msg);
}

function clear_html_code($string){
	$string = trim(strip_tags($string));
	$string = addslashes($string);
	return $string;
}

function encoding_html($string){
	$string = trim(htmlspecialchars($string));
	return $string;
}
?>