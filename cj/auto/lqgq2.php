<?php header('Content-type: text/html;charset=utf-8');
include_once 'mysql_ty.php';
include_once 'pub_library.php';
$msg = '本次无篮球滚球数据采集';
try
{
	if ($data == 'ok')
	{
		$result = $mydata1_db->query('select lgunqiu_count from mydata4_db.sports_copy_config');
		$row = $result->fetch();
		$lgunqiu_count = floatval($row['lgunqiu_count']);
		if (!strpos('=' . $arrcur[2], 'lgunqiu_count'))
		{
			$newline = true;
		}
		else
		{
			$newline = false;
		}
		$arryparam['newLine'] = $newline;
		$arryparam['lgunqiuCount'] = $lgunqiu_count;
		$out = $objSoapClient->GetLQGQ2($arryparam);
		$json = $out->GetLQGQ2Result;
		if ($json)
		{
			if (is_numeric($json))
			{
				$new_lgunqiu_count = floatval($json);
			}
			else
			{
				$jsonArray = json_decode($json, true);
				$new_lgunqiu_count = 0;
				foreach ($jsonArray['Table'] as $row)
				{
					if ($new_lgunqiu_count == 0)
					{
						$new_lgunqiu_count = $row['newLgunqiuCount'];
					}
					$mid_str = $row['mid_str'];
					if ($mid_str)
					{
						$mid_str = preg_replace('/lasttime    =    (.*?);/is', 'lasttime    =    ' . (time() + 10) . ';', $mid_str);
						if (!write_file($C_Patch . '/cache/lqgq.php', '<?php ' . stripcslashes($mid_str) . '?>'))
						{
							$msg = '缓存文件写入失败！请先设/cache/lqgq.php文件权限为：0777';
						}
						else
						{
							$msg = '篮球滚球数据缓存生成成功！';
						}
					}
					else
					{
						$msg = '本次无篮球滚球数据采集';
					}
					$params = array(':mid_str' => $mid_str);
					$sql = 'update mydata4_db.gunqiu set mid_str=:mid_str,lasttime=DATE_ADD(now(),INTERVAL 10 SECOND) WHERE id=2';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
				}
			}
			$mydata1_db->query('update mydata4_db.sports_copy_config set lgunqiu_count=\'' . $new_lgunqiu_count . '\'');
			if ($newline)
			{
				$sql = 'update mydata3_db.sys_admin set COOKIE=concat(COOKIE,\',lgunqiu_count\')';
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