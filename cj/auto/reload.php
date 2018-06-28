<?php header('Content-type: text/html;charset=utf-8');
include_once 'mysql_ty.php';
try
{
	$str = '线路连接异常';
	if ($data == 'ok')
	{
		if ($_GET['ref'] == 1)
		{
			change_line();
			$str = '线路切换成功';
		}
		else
		{
			$out = $objSoapClient->GetMaxCount($arryparam);
			$json = $out->GetMaxCountResult;
			
			if (is_numeric($json))
			{
				$result = $mydata1_db->query('select * from mydata4_db.sports_copy_config');
				$row = $result->fetch();
				if ($row)
				{
					$i = 1;
					for (;$i <= 12;$i++)
					{
						if ($json < $row[$i])
						{
							$newline = true;
							break;
						}
					}
					if ($newline)
					{
						change_line();
						$str = '线路切换成功';
					}
					else
					{
						$str = '线路连接正常';
					}
				}
				else
				{
					$str = '数据库连接异常';
				}
			}
			else
			{
				$str = $json;
			}
		}
	}
}
catch (Exception $ex)
{
	$str = 'Fail';
}
 echo $str;?>            <input type="button" name="button" value="强制刷新" onClick="window.location.href='reload.php?ref=1';" /> 
          </td> 
	  </tr> 
  </table> 
  </body> 
  </html><?php function change_line()
{
	global $mydata1_db;
	$mydata1_db->query("\r\n" . '        update mydata4_db.sports_copy_config set ' . "\r\n" . '            bqds_count=0,' . "\r\n" . '            zqds_count=0,' . "\r\n" . '            zqgq_count=0,' . "\r\n" . '            zgunqiu_count=0,' . "\r\n" . '            tygg_count=0,' . "\r\n" . '            lqds_count=0,' . "\r\n" . '            lqgq_count=0,' . "\r\n" . '            lgunqiu_count=0,' . "\r\n" . '            gj_count=0,' . "\r\n" . '            gjteam_count=0,' . "\r\n" . '            wqds_count=0,' . "\r\n" . '            pqds_count=0');
	$mydata1_db->query('update mydata3_db.sys_admin set cpservice=\'\',COOKIE=\'\'');
}?>