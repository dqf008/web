<?php header('Content-type: text/html;charset=utf-8');
include_once 'mysql_ty.php';
$msg = 0;
try
{
	if ($data == 'ok')
	{
		$result = $mydata1_db->query('select pqds_count from mydata4_db.sports_copy_config');
		$row = $result->fetch();
		$pqds_count = floatval($row['pqds_count']);
		if (!strpos('=' . $arrcur[2], 'pqds_count'))
		{
			$newline = true;
		}
		else
		{
			$newline = false;
		}
		$arryparam['newLine'] = $newline;
		$arryparam['pqdsCount'] = $pqds_count;
		$out = $objSoapClient->GetPQDS($arryparam);
		$json = $out->GetPQDSResult;
		if ($json)
		{
			if (is_numeric($json))
			{
				$new_pqds_count = floatval($json);
			}
			else
			{
				$jsonArray = json_decode($json, true);
				$new_pqds_count = 0;
				foreach ($jsonArray['Table'] as $row)
				{
					if ($new_pqds_count == 0)
					{
						$new_pqds_count = $row['newPqdsCount'];
					}
					$params = array(':Match_ID' => $row['Match_ID']);
					$sql = 'select id from mydata4_db.volleyball_match where Match_ID=:Match_ID';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$rowCount = $stmt->rowCount();
					$params = array();
					$sql = '';
					$commonsql = '';
					$row_i = 0;
					foreach ($row as $key => $value)
					{
						if (($key != 'ID') && ($key != 'Match_JS') && ($key != 'newPqdsCount'))
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
						$sql = 'update mydata4_db.volleyball_match set ' . $commonsql . ' where Match_ID=:Match_ID2 and Match_JS!=\'1\'';
					}
					else
					{
						$sql = 'insert into mydata4_db.volleyball_match set ' . $commonsql;
					}
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$msg++;
				}
			}
			$mydata1_db->query('update mydata4_db.sports_copy_config set pqds_count=\'' . $new_pqds_count . '\'');
			if ($newline)
			{
				$sql = 'update mydata3_db.sys_admin set COOKIE=concat(COOKIE,\',pqds_count\')';
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
 echo $msg;?> 条排球数据！ 
			  <span id="timeinfo"></span> 
          </td> 
	  </tr> 
  </table> 
  </body> 
  </html>