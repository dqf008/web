<?php 
header('Content-type: text/html;charset=utf-8');

function message($value, $url = '')
{
	header('Content-type: text/html;charset=utf-8');
	$js = '<script type="text/javascript" language="javascript">' . "\r\n";
	$js .= 'alert("' . $value . '");' . "\r\n";
	if ($url)
	{
		$js .= 'window.location.href="' . $url . '";' . "\r\n";
	}
	else
	{
		$js .= 'window.history.go(-1);' . "\r\n";
	}
	$js .= '</script>' . "\r\n";
 	echo $js;
	exit();
}

function logout_msg($message)
{
	echo "<script>alert('".$message."');top.location.href='out.php';</script>";
	exit();
}
?>