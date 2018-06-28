<?php header('Content-type: text/html;charset=utf-8');
include_once 'mysql_ty.php';
$msg = 0;
try
{
	if ($data == 'ok')
	{
		$result = $mydata1_db->query('select bqds_count from mydata4_db.sports_copy_config');
		$row = $result->fetch();
		$bqds_count = floatval($row['bqds_count']);
		if (!strpos('=' . $arrcur[2], 'bqds_count'))
		{
			$newline = true;
		}
		else
		{
			$newline = false;
		}
		$arryparam['newLine'] = $newline;
		$arryparam['bqdsCount'] = $bqds_count;
		$out = $objSoapClient->GetBQDS($arryparam);
		$json = $out->GetBQDSResult;
		if ($json)
		{
			if (is_numeric($json))
			{
				$new_bqds_count = floatval($json);
			}
			else
			{
				$jsonArray = json_decode($json, true);
				$new_bqds_count = 0;
				foreach ($jsonArray['Table'] as $row)
				{
					if ($new_bqds_count == 0)
					{
						$new_bqds_count = $row['newBqdsCount'];
					}
					$params = array(':Match_ID' => $row['Match_ID']);
					$sql = 'select id from mydata4_db.baseball_match where Match_ID=:Match_ID';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$rowCount = $stmt->rowCount();
					$params = array();
					$sql = '';
					$commonsql = '';
					$row_i = 0;
					foreach ($row as $key => $value)
					{
						if (($key != 'ID') && ($key != 'Match_JS') && ($key != 'newBqdsCount'))
						{
							$params[':' . $key] = $value;
							if ($row_i == 0)
							{
								$commonsql .= $key . ' = :' . $key;
							}
							else
							{
								$commonsql .= ',' . $key . ' = :' . $key;
							}
							$row_i++;
						}
					}
					if ($rowCount)
					{
						$params[':Match_ID2'] = $params[':Match_ID'];
						$sql = 'update mydata4_db.baseball_match set ' . $commonsql . ' where Match_ID=:Match_ID2 and Match_JS!=\'1\'';
					}
					else
					{
						$sql = 'insert into mydata4_db.baseball_match set ' . $commonsql;
					}
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$msg++;
				}
			}
			$mydata1_db->query('update mydata4_db.sports_copy_config set bqds_count=\'' . $new_bqds_count . '\'');
			if ($newline)
			{
				$sql = 'update mydata3_db.sys_admin set COOKIE=concat(COOKIE,\',bqds_count\')';
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
 echo $msg;?> 条棒球数据！ 
			  <span id="timeinfo"></span> 
          </td> 
	  </tr> 
  </table> 
  </body> 
  </html>