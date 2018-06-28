<?php header('Content-type: text/html;charset=utf-8');
include_once 'mysql_ty.php';
$msg = 0;
try
{

	if ($data == 'ok')
	{
		$result = $mydata1_db->query('select tygg_count,zqds_count from mydata4_db.sports_copy_config');
		$row = $result->fetch();
		$tygg_count = floatval($row['tygg_count']);
		$zqds_count = floatval($row['zqds_count']);
		if (!strpos('=' . $arrcur[2], 'zqds_count'))
		{
			$newline = true;
		}
		else
		{
			$newline = false;
		}
		$arryparam['newLine'] = $newline;
		$arryparam['zqdsCount'] = $zqds_count;
		$out = $objSoapClient->GetZQDS($arryparam);
		$json = $out->GetZQDSResult;
		if ($json)
		{
			if (is_numeric($json))
			{
				$new_zqds_count = floatval($json);
			}
			else
			{
				$jsonArray = json_decode($json, true);
				$new_zqds_count = 0;
				foreach ($jsonArray['Table'] as $row)
				{
					if ($new_zqds_count == 0)
					{
						$new_zqds_count = $row['newZqdsCount'];
					}
					$params = array(':Match_ID' => $row['Match_ID']);
					$sql = 'select id,match_js,match_sbjs from mydata4_db.bet_match where Match_ID=:Match_ID';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$rowCount = $stmt->rowCount();
					$exist_row = $stmt->fetch();
					$params = array();
					$sql = '';
					$commonsql = '';
					foreach ($row as $key => $value)
					{
						if (($key != 'ID') && ($key != 'MB_Inball') && ($key != 'TG_Inball') && ($key != 'MB_Inball_HR') && ($key != 'TG_Inball_HR') && ($key != 'Match_JS') && ($key != 'Match_SBJS') && ($key != 'newZqdsCount') && ($key != 'Match_LstTime'))
						{
							$params[':' . $key] = $value;
							$commonsql .= ',' . $key . ' = :' . $key;
						}
					}
					if ($rowCount)
					{
						if (($exist_row['match_js'] != '1') && ($exist_row['match_sbjs'] != '1'))
						{
							$params[':MB_Inball'] = $row['MB_Inball'];
							$params[':TG_Inball'] = $row['TG_Inball'];
							$params[':MB_Inball_HR'] = $row['MB_Inball_HR'];
							$params[':TG_Inball_HR'] = $row['TG_Inball_HR'];
							$params[':Match_ID2'] = $params[':Match_ID'];
							$commonsql .= ',MB_Inball = :MB_Inball';
							$commonsql .= ',TG_Inball = :TG_Inball';
							$commonsql .= ',MB_Inball_HR = :MB_Inball_HR';
							$commonsql .= ',TG_Inball_HR = :TG_Inball_HR';
							$sql = 'update mydata4_db.bet_Match set Match_LstTime = now()' . $commonsql . ' where Match_ID=:Match_ID2';
						}
						else if ($exist_row['match_js'] != '1')
						{
							$params[':MB_Inball'] = $row['MB_Inball'];
							$params[':TG_Inball'] = $row['TG_Inball'];
							$params[':Match_ID2'] = $params[':Match_ID'];
							$commonsql .= ',MB_Inball = :MB_Inball';
							$commonsql .= ',TG_Inball = :TG_Inball';
							$sql = 'update mydata4_db.bet_Match set Match_LstTime = now()' . $commonsql . ' where Match_ID=:Match_ID2';
						}
						else
						{
							$sql = '';
						}
					}
					else
					{
						$params[':MB_Inball'] = $row['MB_Inball'];
						$params[':TG_Inball'] = $row['TG_Inball'];
						$params[':MB_Inball_HR'] = $row['MB_Inball_HR'];
						$params[':TG_Inball_HR'] = $row['TG_Inball_HR'];
						$commonsql .= ',MB_Inball = :MB_Inball';
						$commonsql .= ',TG_Inball = :TG_Inball';
						$commonsql .= ',MB_Inball_HR = :MB_Inball_HR';
						$commonsql .= ',TG_Inball_HR = :TG_Inball_HR';
						$sql = 'insert into mydata4_db.bet_Match set Match_LstTime = now()' . $commonsql;
					}
					if ($sql)
					{
						$stmt = $mydata1_db->prepare($sql);
						$stmt->execute($params);
						$msg++;
					}
				}
			}
			$mydata1_db->query('update mydata4_db.sports_copy_config set zqds_count=\'' . $new_zqds_count . '\'');
			if ($newline)
			{
				$sql = 'update mydata3_db.sys_admin set COOKIE=concat(COOKIE,\',zqds_count\')';
				$mydata1_db->query($sql);
			}
		}
		if (!strpos('=' . $arrcur[2], 'tygg_count'))
		{
			$newline = true;
		}
		else
		{
			$newline = false;
		}
		$arryparam['newLine'] = $newline;
		$arryparam['tyggCount'] = $tygg_count;
		$out = $objSoapClient->GetTYGG($arryparam);
		$json = $out->GetTYGGResult;
		if ($json)
		{
			if (is_numeric($json))
			{
				$new_tygg_count = floatval($json);
			}
			else
			{
				$jsonArray = json_decode($json, true);
				$new_tygg_count = 0;
				foreach ($jsonArray['Table'] as $row)
				{
					if ($new_tygg_count == 0)
					{
						$new_tygg_count = $row['newTyggCount'];
					}
					$params = array(':msg' => $row['msg']);
					$sql = 'select nid from k_notice where msg=:msg';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					if ($stmt->rowCount() < 1)
					{
						$is_class = 1;
						$is_show = 1;
						if (strpos($row['msg'], 'TAG'))
						{
							$is_class = 9;
							$is_show = 0;
						}
						$params = array(':msg' => $row['msg'], ':end_time' => $row['end_time'], ':add_time' => $row['add_time'], ':is_class' => $is_class, ':is_show' => $is_show);
						$sql = 'insert into k_notice(msg,is_show,end_time,add_time,sort,is_class) values(:msg,:is_show,:end_time,:add_time,\'1\',:is_class)';
						$stmt = $mydata1_db->prepare($sql);
						$stmt->execute($params);
						$msg++;
					}
				}
			}
			$mydata1_db->query('update mydata4_db.sports_copy_config set tygg_count=\'' . $new_tygg_count . '\'');
			if ($newline)
			{
				$sql = 'update mydata3_db.sys_admin set COOKIE=concat(COOKIE,\',tygg_count\')';
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
 echo $msg;?> 条足球数据！ 
			  <span id="timeinfo"></span> 
          </td> 
	  </tr> 
  </table> 
  </body> 
  </html>