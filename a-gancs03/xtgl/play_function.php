<?php

//写入
function save_play(){
	global $pay_online_type;
	$str5 = '';
	$gids = $pay_online_type;
	//print_r($gids);
	foreach ($gids as $k=>$v ){
		//print_r($v);
		$str5.= get_str($k,$v);
	}
	$str4 = '<?php ' . "\r\n";
	$str4 .= 'unset($pay_online_type);' . "\r\n";
	$str4 .= 'unset($payquery);' . "\r\n";
	$str4 .= $str5;
	$str4 .= '$payquery' . "\t" . '=' . "\t" . intval($_POST['payquery']) . ';' . "\r\n";
	//echo $str4;
	//echo $str;
	if (!file_put_contents('../../member/pay/cache/pay_conf.php', $str4 . '?>')){
		echo "error";
	}
}


//删除
function del_play($typename){
	global $pay_online_type;
	foreach ($pay_online_type as $key => $value) {
		foreach ($value as $k => $v) {
				//print_r($v);
				if($v==$typename){
				unset($pay_online_type[$key][$k]);
			}
		}
		
	}
}

function add__play($typename){
	global $pay_online_type;
	foreach ($pay_online_type as $key => $value) {
		//print_r($value);
		$res = in_array($typename,$value,true);
		if(!$res){
			$pay_online_type[$key][] = $typename;
		}
		
	}
}


function get_str($gid, $v){
	foreach ($v as $k=>$gs){
		$str4 .= '$pay_online_type[' . $gid . '][] = \'' . $v[$k] . '\';' . "\r\n";
	}
	return $str4;
}