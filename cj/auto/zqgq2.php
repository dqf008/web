<?php header('Content-type: text/html;charset=utf-8');
include_once 'mysql_ty.php';
include_once 'pub_library.php';
$msg = '本次无足球滚球数据采集';
try
{
	if ($data == 'ok')
	{
		$result = $mydata1_db->query('select zgunqiu_count from mydata4_db.sports_copy_config');
		$row = $result->fetch();
		$zgunqiu_count = floatval($row['zgunqiu_count']);
		if (!strpos('=' . $arrcur[2], 'zgunqiu_count'))
		{
			$newline = true;
		}
		else
		{
			$newline = false;
		}
		$arryparam['newLine'] = $newline;
		$arryparam['zgunqiuCount'] = $zgunqiu_count;
		$out = $objSoapClient->GetZQGQ2($arryparam);
		$json = $out->GetZQGQ2Result;
		if ($json)
		{
			if (is_numeric($json))
			{
				$new_zgunqiu_count = floatval($json);
			}
			else
			{
				$jsonArray = json_decode($json, true);
				$new_zgunqiu_count = 0;
				foreach ($jsonArray['Table'] as $row)
				{
					if ($new_zgunqiu_count == 0)
					{
						$new_zgunqiu_count = $row['newZgunqiuCount'];
					}
					$mid_str = $row['mid_str'];
					if ($mid_str)
					{
						$mid_str = preg_replace('/lasttime    =    (.*?);/is', 'lasttime    =    ' . (time() + 10) . ';', $mid_str);
						if (!write_file($C_Patch . '/cache/zqgq.php', '<?php ' . stripcslashes($mid_str) . '?>'))
						{
							$msg = '缓存文件写入失败！请先设/cache/zqgq.php文件权限为：0777';
						}
						else
						{
							$msg = '足球滚球数据缓存生成成功！';
						}
					}
					else
					{
						$msg = '本次无足球滚球数据采集';
					}
					$params = array(':mid_str' => $mid_str);
					$sql = 'update mydata4_db.gunqiu set mid_str=:mid_str,lasttime=DATE_ADD(now(),INTERVAL 10 SECOND) WHERE id=1';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
				}
			}
			$mydata1_db->query('update mydata4_db.sports_copy_config set zgunqiu_count=\'' . $new_zgunqiu_count . '\'');
			if ($newline)
			{
				$sql = 'update mydata3_db.sys_admin set COOKIE=concat(COOKIE,\',zgunqiu_count\')';
				$mydata1_db->query($sql);
			}
		}
	}
	else
	{
		$msg = '连接失败';
	}
}
catch (Exception $ex)
{
	$msg = 'Fail';
}
 echo $msg;?>			  <span id="timeinfo"></span> 
          </td> 
	  </tr> 
  </table> 
  </body> 
  </html>