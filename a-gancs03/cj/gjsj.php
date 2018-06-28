<?php header('Content-type: text/html;charset=utf-8');
include_once 'mysql_ty.php';
$msg = 0;
try
{
	if ($data == 'ok')
	{
		$result = $mydata1_db->query('select gj_count,gjteam_count from mydata4_db.sports_copy_config');
		$row = $result->fetch();
		$gj_count = floatval($row['gj_count']);
		$gjteam_count = floatval($row['gjteam_count']);
		if (!strpos('=' . $arrcur[2], 'gj_count'))
		{
			$newline = true;
		}
		else
		{
			$newline = false;
		}
		$arryparam['newLine'] = $newline;
		$arryparam['gjCount'] = $gj_count;
		$out = $objSoapClient->GetGJMain($arryparam);
		$json = $out->GetGJMainResult;
		if ($json)
		{
			if (is_numeric($json))
			{
				$new_gj_count = floatval($json);
			}
			else
			{
				$jsonArray = json_decode($json, true);
				$new_gj_count = 0;
				foreach ($jsonArray['Table'] as $row)
				{
					if ($new_gj_count == 0)
					{
						$new_gj_count = $row['newGjCount'];
					}
					$params = array(':match_id' => $row['match_id']);
					$sql = 'select x_id from mydata4_db.t_guanjun where match_id=:match_id';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$rowCount = $stmt->rowCount();
					$params = array(':match_name' => $row['match_name'], ':x_title' => $row['x_title'], ':match_date' => $row['match_date'], ':match_time' => $row['match_time'], ':match_coverdate' => $row['match_coverdate'], ':add_time' => $row['add_time'], ':x_result' => $row['x_result'], ':match_id' => $row['match_id'], ':match_type' => $row['match_type']);
					if ($rowCount)
					{
						$sql = 'update mydata4_db.t_guanjun set  match_name=:match_name, x_title=:x_title, match_date=:match_date, match_time=:match_time,match_coverdate=:match_coverdate, add_time=:add_time, x_result=:x_result, match_type=:match_type where match_id=:match_id and x_result is null';
					}
					else
					{
						$sql = 'insert into mydata4_db.t_guanjun set  match_id=:match_id, match_name=:match_name, x_title=:x_title, match_date=:match_date, match_time=:match_time,match_coverdate=:match_coverdate, add_time=:add_time,x_result=:x_result, match_type=:match_type';
					}
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$msg++;
				}
			}
			$mydata1_db->query('update mydata4_db.sports_copy_config set gj_count=\'' . $new_gj_count . '\'');
			if ($newline)
			{
				$sql = 'update mydata3_db.sys_admin set COOKIE=concat(COOKIE,\',gj_count\')';
				$mydata1_db->query($sql);
			}
		}
		if (!strpos('=' . $arrcur[2], 'gjteam_count'))
		{
			$newline = true;
		}
		else
		{
			$newline = false;
		}
		$arryparam['newLine'] = $newline;
		$arryparam['gjteamCount'] = $gjteam_count;
		$out = $objSoapClient->GetGJTeam($arryparam);
		$json = $out->GetGJTeamResult;
		if ($json)
		{
			if (is_numeric($json))
			{
				$new_gjteam_count = floatval($json);
			}
			else
			{
				$jsonArray = json_decode($json, true);
				$new_gjteam_count = 0;
				foreach ($jsonArray['Table'] as $row)
				{
					if ($new_gjteam_count == 0)
					{
						$new_gjteam_count = $row['newGjteamCount'];
					}
					$params = array(':t_match_id' => $row['t_match_id']);
					$sql = 'select x_id from mydata4_db.t_guanjun where match_id=:t_match_id';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$x_id = $stmt->fetchColumn();
					if ($x_id)
					{
						$params = array(':xid' => $x_id, ':match_id' => $row['match_id']);
						$sql = 'select tid from mydata4_db.t_guanjun_team where xid=:xid and match_id=:match_id';
						$stmt = $mydata1_db->prepare($sql);
						$stmt->execute($params);
						$tid = $stmt->fetchColumn();
						if ($tid)
						{
							$params = array(':xid' => $x_id, ':team_name' => $row['team_name'], ':point' => $row['point'], ':match_id' => $row['match_id'], ':match_type' => $row['match_type'], ':tid' => $tid);
							$sql = 'update mydata4_db.t_guanjun_team set      xid         =   :xid    , team_name   =   :team_name    , point       =   :point    , match_id    =   :match_id    , match_type  =   :match_type  where tid=:tid';
						}
						else
						{
							$params = array(':xid' => $x_id, ':team_name' => $row['team_name'], ':point' => $row['point'], ':match_id' => $row['match_id'], ':match_type' => $row['match_type']);
							$sql = 'insert into mydata4_db.t_guanjun_team set      xid         =' . "\t" . ':xid    , team_name   =   :team_name    , point       =   :point    , match_id    =   :match_id    , match_type  =   :match_type';
						}
						$stmt = $mydata1_db->prepare($sql);
						$stmt->execute($params);
						$msg++;
					}
				}
			}
			$mydata1_db->query('update mydata4_db.sports_copy_config set gjteam_count=\'' . $new_gjteam_count . '\'');
			if ($newline)
			{
				$sql = 'update mydata3_db.sys_admin set COOKIE=concat(COOKIE,\',gjteam_count\')';
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
 echo $msg;?> 条冠军数据！ 
			  <span id="timeinfo"></span> 
          </td> 
	  </tr> 
  </table> 
  </body> 
  </html>