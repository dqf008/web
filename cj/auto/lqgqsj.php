<?php 
header('Content-type: text/html;charset=utf-8');
include_once 'mysql_ty.php';
$msg = 0;
try
{
	if ($data == 'ok')
	{
		$result = $mydata1_db->query('select lqgq_count from mydata4_db.sports_copy_config');
		$row = $result->fetch();
		$lqgq_count = floatval($row['lqgq_count']);
		if (!strpos('=' . $arrcur[2], 'lqgq_count'))
		{
			$newline = true;
		}
		else
		{
			$newline = false;
		}
		$arryparam['newLine'] = $newline;
		$arryparam['lqgqCount'] = $lqgq_count;
		$out = $objSoapClient->GetLQGQSJ($arryparam);
		$json = $out->GetLQGQSJResult;
		if ($json)
		{
			if (is_numeric($json))
			{
				$new_lqgq_count = floatval($json);
			}
			else
			{
				$jsonArray = json_decode($json, true);
				$new_lqgq_count = 0;
				foreach ($jsonArray['Table'] as $row)
				{
					if ($new_lqgq_count == 0)
					{
						$new_lqgq_count = $row['newLqgqCount'];
					}
					$params = array(':Match_ID' => $row['Match_ID']);
					$sql = 'select id from mydata4_db.lq_match where Match_ID=:Match_ID';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$rowCount = $stmt->rowCount();
					$params = array();
					$sql = '';
					$commonsql = '';
					foreach ($row as $key => $value)
					{
						if (($key != 'ID') && ($key != 'Match_JS') && ($key != 'newLqgqCount') && ($key != 'Match_LstTime'))
						{
							$params[':' . $key] = $value;
							$commonsql .= ',' . $key . ' = :' . $key;
						}
					}
					if ($rowCount)
					{
						$params[':Match_ID2'] = $params[':Match_ID'];
						$sql = 'update mydata4_db.lq_match set Match_LstTime = now()' . $commonsql . ' where Match_ID=:Match_ID2 and Match_JS!=\'1\'';
					}
					else
					{
						$sql = 'insert into mydata4_db.lq_match set Match_LstTime = now()' . $commonsql;
					}
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$msg++;
				}
			}
			$mydata1_db->query('update mydata4_db.sports_copy_config set lqgq_count=\'' . $new_lqgq_count . '\'');
			if ($newline)
			{
				$sql = 'update mydata3_db.sys_admin set COOKIE=concat(COOKIE,\',lqgq_count\')';
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
 echo $msg;?> 条篮球滚球！ 
			  <span id="timeinfo"></span> 
          </td> 
	  </tr> 
  </table> 
  </body> 
  </html>