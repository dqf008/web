<?php 
function checkFile($dir, $file, $fileList, $cacheFileList){
	if (in_array($dir, array('logList', date('Ymd'), date('Ymd', strtotime('-1 day')), 'cache', 'other', 'cj', 'xtgl'))){
		if ((strrchr($file, '.') == '.jpg') || (strrchr($file, '.') == '.txt')){
			return false;
		}
		
		if (array_key_exists($file, $fileList) && array_key_exists($file, $cacheFileList)){
			return false;
		}
	}
	return true;
}

function saveTree($directory, $fileName, $num){
	$mydir = dir($directory);
	while ($file = $mydir->read()){
		if (($file != '.') && ($file != '..')){
			if (is_dir($directory . '/' . $file)){
				saveTree($directory . '/' . $file, $fileName, $num);
			}else{
				global $str;
				$temp = explode('/', $directory . '/' . $file);
				$count = count($temp);
				$str .= '$' . $fileName;
				$i = $num;
				for (;$i < $count;$i++)
				{
					$str .= '[\'' . $temp[$i] . '\']';
				}
				$str .= '=' . (filemtime($directory . '/' . $file) + 5) . ';' . "\r\n";
			}
		}
	}
	$mydir->close();
}

function array_diff_assoc_recursive($array1, $array2, $array3){
	foreach ($array1 as $key => $value){
		if (is_array($value)){
			if (!is_array($array2[$key]) && !is_array($array3[$key])){
				$difference[$key] = $value;
			}else{
				$new_diff = array_diff_assoc_recursive($value, $array2[$key], $array3[$key]);
				if (count($new_diff)){
					$difference[$key] = $new_diff;
				}
			}
		}else if (!isset($array2[$key]) || ($array2[$key] != $value)){
			if (!isset($array3[$key])){
				$difference[$key] = $value;
			}
		}
	}
	return !isset($difference) ? array() : $difference;
}
?>