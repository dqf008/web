<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cwgl');
$time = $_GET['time'];
$time = ($time == '' ? 'EN' : $time);
$bdate = $_GET['bdate'];
$bdate = ($bdate == '' ? date('Y-m-d', time()) : $bdate);
$bhour = $_GET['bhour'];
$bhour = ($bhour == '' ? '00' : $bhour);
$bsecond = $_GET['bsecond'];
$bsecond = ($bsecond == '' ? '00' : $bsecond);
$edate = $_GET['edate'];
$edate = ($edate == '' ? date('Y-m-d', time()) : $edate);
$ehour = $_GET['ehour'];
$ehour = ($ehour == '' ? '23' : $ehour);
$esecond = $_GET['esecond'];
$esecond = ($esecond == '' ? '59' : $esecond);
$btime = $bdate . ' ' . $bhour . ':' . $bsecond . ':00';
$etime = $edate . ' ' . $ehour . ':' . $esecond . ':59';
$username = $_GET['username'];
?> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
	  <title>Welcome</title> 
	  <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" /> 
	  <script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 
	  <script language="JavaScript" src="/js/calendar.js"></script> 
  </head> 
  <body> 
  <div id="pageMain"> 
	  <script type="text/javascript"> 
		  function checkInput() { 
			  var userName = $.trim($("#username").val());
			
			  if (userName == "") { 
				  alert("请先输入会员名称！");
				  return false;
			  } 
			
			  return true;
		  } 
	  </script> 
	  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="font12" style="border:1px solid #798EB9;"> 
		  <form name="form1" method="get" action="" onSubmit="return checkInput();"> 
		  <tr bgcolor="#FFFFFF"> 
			  <td align="left"> 
				  <select name="time" id="time" disabled="disabled"> 
					  <option value="CN" <?=$time_type=='CN' ? 'selected' : ''?>>中国时间</option>
          			  <option value="EN" <?=$time_type=='EN' ? 'selected' : ''?>>美东时间</option>
				  </select> 
				  &nbsp;开始日期 
				  <input name="bdate" type="text" id="bdate" value="<?=$bdate?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" /> 
				  <select name="bhour" id="bhour">
				  <?php 
					for ($i = 0;$i < 24;$i++){
						$list=$i<10?"0".$i:$i;
				  ?>					  
				  <option value="<?=$list?>" <?=$bhour==$list?"selected":""?>><?=$list?></option>
				  <?php }?> 				  
				  </select>
				  &nbsp;时 
				  <select name="bsecond" id="bsecond">
				  <?php 
					for ($i = 0;$i < 60;$i++){
						$list=$i<10?"0".$i:$i;
				  ?>					  
				  <option value="<?=$list?>" <?=$bsecond==$list ? 'selected' : '' ?>><?=$list?></option>
				  <?php }?> 				  
				  </select>
				  &nbsp;分 
				  &nbsp;结束日期 
				  <input name="edate" type="text" id="edate" value="<?=$edate?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" /> 
				  <select name="ehour" id="ehour">
				  <?php 
					for ($i = 0;$i < 24;$i++){
						$list=$i<10?"0".$i:$i;
				  ?>					  
				  <option value="<?=$list?>"<?=$ehour==$list?"selected":""?>><?=$list?></option><?php }?> 				  
				  </select>
				  &nbsp;时 
				  <select name="esecond" id="esecond">
				  <?php 
					for ($i = 0;$i < 60;$i++){
						$list=$i<10?"0".$i:$i;
				  ?>					  
				  <option value="<?=$list?>" <?=$esecond==$list ? 'selected' : '' ?>><?=$list?></option>
				  <?php }?> 				  
				  </select>
				  &nbsp;分 
				  &nbsp;会员名称 
				  <input name="username" type="text" id="username" value="<?=$username?>" size="15" maxlength="20"/> 
				  <input type="hidden" name="ok" id="ok" value="1" /> 
                  &nbsp;<input name="find" type="submit" id="find" value="查找"/> 
				  &nbsp;<span style="color:#f00">提示：蓝色行表示上下记录出现异常，请注意核查</span>
			  </td> 
		  </tr> 
		  <tr>
		  	<td>
				<div id="date_quick"></div>
	  	<script type="text/javascript" src="/skin/js/jquery-1.7.2.min.js"></script>
	  	<script type="text/javascript">
	  		$(function(){
		  		var time = <?=time()?>;
	  			$("#date_quick").html('快速日期选择：<button value="0">今日</button><button value="1">昨日</button><button value="2">一周</button><button value="3">本月</button><button value="4">上月</button><button value="5">六个月</button><button value="6">一年</button>');
	  			$("#date_quick button").css('margin-right','10px');
	  			$("#date_quick button").click(function(){
	  				switch($(this).val()){
	  					case "0":
	  						$('#bdate').val('<?=date('Y-m-d')?>');
	  						$('#edate').val('<?=date('Y-m-d')?>');
	  						break;
	  					case "1":
	  						$('#bdate').val('<?=date('Y-m-d',strtotime('-1 day'))?>');
	  						$('#edate').val('<?=date('Y-m-d',strtotime('-1 day'))?>');
	  						break;
	  					case "2":
	  						$('#bdate').val('<?=date('Y-m-d',strtotime('-6 day'))?>');
	  						$('#edate').val('<?=date('Y-m-d')?>');
	  						break;
	  					case "3":
	  						$('#bdate').val('<?=date('Y-m-01')?>');
	  						$('#edate').val('<?=date('Y-m-t')?>');
	  						break;
	  					case "4":
	  						$('#bdate').val('<?=date("Y-m-01",strtotime("last month"))?>');
	  						$('#edate').val('<?=date("Y-m-t",strtotime("last month"))?>');
	  						break;
	  					case "5":
	  						$('#bdate').val('<?=date("Y-m-01",strtotime("-5 month"))?>');
	  						$('#edate').val('<?=date("Y-m-t")?>');
	  						break;
	  					case "6":
	  						$('#bdate').val('<?=date("Y-m-01",strtotime("-11 month"))?>');
	  						$('#edate').val('<?=date("Y-m-t")?>');
	  						break;
	  					default:return;
	  				}
	  			});
	  		});
	  	</script>
		  	</td>
		  </tr>
		  </form> 
	  </table>
	 <?php 
	  if (intval($_GET['ok']) == 1){
		$color = '#FFFFFF';
		$over = '#EBEBEB';
		$out = '#ffffff';
		if ($time == 'CN'){
			$q_btime = date('Y-m-d H:i:s', strtotime($btime) - (12 * 3600));
			$q_etime = date('Y-m-d H:i:s', strtotime($etime) - (12 * 3600));
		}else{
			$q_btime = $btime;
			$q_etime = $etime;
		}
		
		if ($username == '')
		{
			message('请先输入会员名称！');
			exit();
		}
		$params = array(':username' => $username, ':q_btime' => $q_btime, ':q_etime' => $q_etime);
		$sqlwhere = 'username=:username AND creationTime>=:q_btime AND creationTime<=:q_etime';
	?>	  
	<table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;line-height:20px;" bgcolor="#798EB9"> 
		  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
			  <td>会员账号</td> 
			  <td>交易类别</td> 
			  <td>交易单号</td> 
			  <td>交易前金额</td> 
			  <td>交易金额</td> 
			  <td>交易后金额</td> 
			  <td>交易时间</td> 
		  </tr>
	<?php 
	$sql = 'SELECT * FROM k_money_log WHERE ' . $sqlwhere . ' ORDER BY id ASC,creationTime ASC';
	//print_r($params);
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$i = 0;
	$rows = array();
	while ($row = $stmt->fetch()){
		if (0 < $i && $tempAmount != $row['previousAmount']){
			$row['color'] = 'color:#ff0000';
			$row['over'] = '#aee0f7';
			$row['out'] = '#aee0f7';
		}else{
			$row['color'] = '';
			$row['over'] = '#EBEBEB';
			$row['out'] = '#ffffff';
		}
		$i++;
		$tempAmount = $row['currentAmount'];
		$rows[] = $row;
	}
	krsort($rows);
	$color = '';
	foreach($rows as $row){
	?>		  
			<tr align="center" onMouseOver="this.style.backgroundColor='<?=$row['over']?>'" onMouseOut="this.style.backgroundColor='<?=$row['out']?>'" style="background-color:<?=$row['out']?>;"> 
			  <td><?=$row['userName']?></td> 
			  <td><?=showtypename($row['gameType'],$row['transferType'])?></td> 
			  <td><?=$row['transferOrder']?></td> 
			  <td style="<?=$row['color']?>"><?=sprintf('%.2f',$row['previousAmount'])?></td> 
			  <td><?=sprintf('%.2f',$row['transferAmount'])?></td> 
			  <td style="<?=$color?>"><?=sprintf('%.2f',$row['currentAmount'])?></td> 
			  <td><?=$row['creationTime']?></td> 
          </tr>
	<?php $color = $row['color'];}?> 	  
	</table>
	<?php }?> 
	</div> 
  </div> 
  </body> 
  </html>
  <?php 
  function showTypeName($gameType, $transferType){
	$typeName = '';
	switch ($gameType){
		case 'SportsDS':
			switch ($transferType){
				case 'BET': 
					$typeName = '体育单式-下注';
					break;
				case 'CANCEL_BET': 
					$typeName = '体育单式-取消下注';
					break;
				case 'RECKON': 
					$typeName = '体育单式-派彩';
					break;
				case 'RECALC': 
					$typeName = '体育单式-取消派彩';
					break;
				default: 
					$typeName = '';
					break;
			}
			break;
		case 'SportsCG': 
			switch ($transferType){
				case 'BET': 
					$typeName = '体育串关-下注';
					break;
				case 'CANCEL_BET': 
					$typeName = '体育串关-取消下注';
					break;
				case 'RECKON': 
					$typeName = '体育串关-派彩';
					break;
				case 'RECALC': 
					$typeName = '体育串关-取消派彩';
					break;
				default: 
					$typeName = '';
					break;
			}
			break;
		case 'FC3D': 
			switch ($transferType){
				case 'BET': 
					$typeName = '福彩3D-下注';
					break;
				case 'CANCEL_BET': 
					$typeName = '福彩3D-取消下注';
					break;
				case 'RECKON': 
					$typeName = '福彩3D-派彩';
					break;
				case 'RECALC': 
					$typeName = '福彩3D-取消派彩';
					break;
				default: 
					$typeName = '';
					break;
			}
			break;
		case 'BJKL8': 
			switch ($transferType){
				case 'BET': 
					$typeName = '北京快乐8-下注';
					break;
				case 'CANCEL_BET': 
					$typeName = '北京快乐8-取消下注';
					break;
				case 'RECKON': 
					$typeName = '北京快乐8-派彩';
					break;
				case 'RECALC': 
					$typeName = '北京快乐8-取消派彩';
					break;
				default: 
					$typeName = '';
					break;
			}
			break;
        case 'PCDD':
            switch ($transferType){
                case 'BET':
                    $typeName = 'PC蛋蛋-下注';
                    break;
                case 'CANCEL_BET':
                    $typeName = 'PC蛋蛋-取消下注';
                    break;
                case 'RECKON':
                    $typeName = 'PC蛋蛋-派彩';
                    break;
                case 'RECALC':
                    $typeName = 'PC蛋蛋-取消派彩';
                    break;
                default:
                    $typeName = '';
                    break;
            }
            break;
		case 'TCPL3': 
			switch ($transferType){
				case 'BET': 
					$typeName = '体彩排列三-下注';
					break;
				case 'CANCEL_BET': 
					$typeName = '体彩排列三-取消下注';
					break;
				case 'RECKON': 
					$typeName = '体彩排列三-派彩';
					break;
				case 'RECALC': 
					$typeName = '体彩排列三-取消派彩';
					break;
				default: 
					$typeName = '';
					break;
			}
			break;
		case 'SHSSL': 
			switch ($transferType){
				case 'BET': 
					$typeName = '上海时时乐-下注';
					break;
				case 'CANCEL_BET': 
					$typeName = '上海时时乐-取消下注';
					break;
				case 'RECKON': 
					$typeName = '上海时时乐-派彩';
					break;
				case 'RECALC': 
					$typeName = '上海时时乐-取消派彩';
					break;
				default: 
					$typeName = '';
					break;
			}
			break;
		case 'CQSSC': 
			switch ($transferType){
				case 'BET': 
					$typeName = '重庆时时彩-下注';
					break;
				case 'CANCEL_BET': 
					$typeName = '重庆时时彩-取消下注';
					break;
				case 'RECKON': 
					$typeName = '重庆时时彩-派彩';
					break;
				case 'RECALC': 
					$typeName = '重庆时时彩-取消派彩';
					break;
				default: 
					$typeName = '';
					break;
			}
			break;
        case 'TJSSC':
            switch ($transferType){
                case 'BET':
                    $typeName = '天津时时彩-下注';
                    break;
                case 'CANCEL_BET':
                    $typeName = '天津时时彩-取消下注';
                    break;
                case 'RECKON':
                    $typeName = '天津时时彩-派彩';
                    break;
                case 'RECALC':
                    $typeName = '天津时时彩-取消派彩';
                    break;
                default:
                    $typeName = '';
                    break;
            }
            break;
        case 'XJSSC':
            switch ($transferType){
                case 'BET':
                    $typeName = '新疆时时彩-下注';
                    break;
                case 'CANCEL_BET':
                    $typeName = '新疆时时彩-取消下注';
                    break;
                case 'RECKON':
                    $typeName = '新疆时时彩-派彩';
                    break;
                case 'RECALC':
                    $typeName = '新疆时时彩-取消派彩';
                    break;
                default:
                    $typeName = '';
                    break;
            }
            break;
        case 'QXC':
            switch ($transferType){
                case 'BET':
                    $typeName = '七星彩-下注';
                    break;
                case 'CANCEL_BET':
                    $typeName = '七星彩-取消下注';
                    break;
                case 'RECKON':
                    $typeName = '七星彩-派彩';
                    break;
                case 'RECALC':
                    $typeName = '七星彩-取消派彩';
                    break;
                default:
                    $typeName = '';
                    break;
            }
            break;
		case 'GDKLSF':
		case 'CQKLSF':
		case 'TJKLSF':
		case 'HNKLSF':
		case 'SXKLSF':
		case 'SFKLSF':
		    $gameNames =['GDKLSF'=>'广东快乐十分','CQKLSF'=>'重庆快乐十分','TJKLSF'=>'天津快乐十分','HNKLSF'=>'湖南快乐十分','SXKLSF'=>'山西快乐十分','SFKLSF'=>'三分快乐十分'];
			switch ($transferType){
				case 'BET': 
					$typeName = $gameNames[$gameType].'-下注';
					break;
				case 'CANCEL_BET': 
					$typeName = $gameNames[$gameType].'-取消下注';
					break;
				case 'RECKON': 
					$typeName = $gameNames[$gameType].'-派彩';
					break;
				case 'RECALC': 
					$typeName = $gameNames[$gameType].'-取消派彩';
					break;
				default: 
					$typeName = '';
					break;
			}
			break;
		case 'BJPK10': 
			switch ($transferType){
				case 'BET': 
					$typeName = '北京赛车PK拾-下注';
					break;
				case 'CANCEL_BET': 
					$typeName = '北京赛车PK拾-取消下注';
					break;
				case 'RECKON': 
					$typeName = '北京赛车PK拾-派彩';
					break;
				case 'RECALC': 
					$typeName = '北京赛车PK拾-取消派彩';
					break;
				default: 
					$typeName = '';
					break;
			}
			break;
        case 'GDSYXW':
        case 'SDSYXW':
        case 'FJSYXW':
        case 'BJSYXW':
        case 'AHSYXW':
        case 'YFSYXW':
        case 'FFSYXW':
        case 'SFSYXW':
            $gameNames =['GDSYXW'=>'广东11选5','SDSYXW'=>'山东11选5','FJSYXW'=>'福建11选5','BJSYXW'=>'北京11选5','AHSYXW'=>'安徽11选5','FFSYXW'=>'分分11选5','YFSYXW'=>'分分11选5','SFSYXW'=>'三分11选5'];
            switch ($transferType){
                case 'BET':
                    $typeName = $gameNames[$gameType].'-下注';
                    break;
                case 'CANCEL_BET':
                    $typeName = $gameNames[$gameType].'-取消下注';
                    break;
                case 'RECKON':
                    $typeName = $gameNames[$gameType].'-派彩';
                    break;
                case 'RECALC':
                    $typeName = $gameNames[$gameType].'-取消派彩';
                    break;
                default:
                    $typeName = '';
                    break;
            }
            break;
        case 'JSK3':
        case 'FJK3':
        case 'AHK3':
        case 'BJK3':
        case 'HBK3':
        case 'HEBK3':
        case 'HNK3':
        case 'SHK3':
        case 'JXK3':
        case 'NMGK3':
        case 'JLK3':
        case 'GZK3':
        case 'QHK3':
        case 'GSK3':
        case 'GXK3':
        case 'FFK3':
        case 'SFK3':
        case 'WFK3':
        case 'jsk3':
        case 'fjk3':
        case 'ahk3':
        case 'bjk3':
        case 'hbk3':
        case 'hebk3':
        case 'hnk3':
        case 'shk3':
        case 'jxk3':
        case 'nmgk3':
        case 'jlk3':
        case 'gzk3':
        case 'qhk3':
        case 'gsk3':
        case 'gxk3':
        case 'ffk3':
        case 'sfk3':
            $gameType = strtoupper($gameType);
            $gameNames =['JSK3'=>'江苏快3','FJK3'=>'福建快3','AHK3'=>'安徽快3','BJK3'=>'北京快3','HEBK3'=>'河北快3','HNK3'=>'河南快3','SHK3'=>'上海快3',
                'JXK3'=>'江西快3','NMGK3'=>'内蒙古快3','JLK3'=>'吉林快3','GZK3'=>'贵州快3','QHK3'=>'青海快3','GSK3'=>'甘肃快3','GXK3'=>'广西快3','FFK3'=>'分分快3','SFK3'=>'超级快3','WFK3'=>'好运快3'
            ];
            switch ($transferType){
                case 'BET':
                    $typeName = $gameNames[$gameType].'-下注';
                    break;
                case 'CANCEL_BET':
                    $typeName = $gameNames[$gameType].'-取消下注';
                    break;
                case 'RECKON':
                    $typeName = $gameNames[$gameType].'-派彩';
                    break;
                case 'RECALC':
                    $typeName = $gameNames[$gameType].'-取消派彩';
                    break;
                default:
                    $typeName = '';
                    break;
            }
            break;
		case 'JSSC': 
			switch ($transferType){
				case 'BET': 
					$typeName = '极速赛车-下注';
					break;
				case 'CANCEL_BET': 
					$typeName = '极速赛车-取消下注';
					break;
				case 'RECKON': 
					$typeName = '极速赛车-派彩';
					break;
				case 'RECALC': 
					$typeName = '极速赛车-取消派彩';
					break;
				default: 
					$typeName = '';
					break;
			}
			break;
		case 'JSSSC': 
			switch ($transferType){
				case 'BET': 
					$typeName = '极速时时彩-下注';
					break;
				case 'CANCEL_BET': 
					$typeName = '极速时时彩-取消下注';
					break;
				case 'RECKON': 
					$typeName = '极速时时彩-派彩';
					break;
				case 'RECALC': 
					$typeName = '极速时时彩-取消派彩';
					break;
				default: 
					$typeName = '';
					break;
			}
			break;
		case 'JSLH': 
			switch ($transferType){
				case 'BET': 
					$typeName = '极速六合-下注';
					break;
				case 'CANCEL_BET': 
					$typeName = '极速六合-取消下注';
					break;
				case 'RECKON': 
					$typeName = '极速六合-派彩';
					break;
				case 'RECALC': 
					$typeName = '极速六合-取消派彩';
					break;
				default: 
					$typeName = '';
					break;
			}
			break;
		case 'XYFT': 
			switch ($transferType){
				case 'BET': 
					$typeName = '幸运飞艇-下注';
					break;
				case 'CANCEL_BET': 
					$typeName = '幸运飞艇-取消下注';
					break;
				case 'RECKON': 
					$typeName = '幸运飞艇-派彩';
					break;
				case 'RECALC': 
					$typeName = '幸运飞艇-取消派彩';
					break;
				default: 
					$typeName = '';
					break;
			}
			break;
        case 'JSFT':
            switch ($transferType){
                case 'BET':
                    $typeName = '极速飞艇-下注';
                    break;
                case 'CANCEL_BET':
                    $typeName = '极速飞艇-取消下注';
                    break;
                case 'RECKON':
                    $typeName = '极速飞艇-派彩';
                    break;
                case 'RECALC':
                    $typeName = '极速飞艇-取消派彩';
                    break;
                default:
                    $typeName = '';
                    break;
            }
            break;
		case 'SIX': 
		switch ($transferType){
			case 'BET': 
				$typeName = '六合彩-下注';
				break;
			case 'CANCEL_BET': 
				$typeName = '六合彩-取消下注';
				break;
			case 'RECKON': 
				$typeName = '六合彩-派彩';
				break;
			case 'RECALC': 
				$typeName = '六合彩-取消派彩';
				break;
			default: 
				$typeName = '';
				break;
		}
		break;
		case 'ADMINACCOUNT': switch ($transferType)
		{
			case 'IN': $typeName = '系统加款';
			break;
			case 'OUT': $typeName = '系统减款';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'HUIKUAN': switch ($transferType)
		{
			case 'IN': $typeName = '汇款入账';
			break;
			case 'ROLLBACK': $typeName = '汇款重算';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'ONLINEPAY': switch ($transferType)
		{
			case 'IN': $typeName = '在线支付';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'TIKUAN': switch ($transferType)
		{
			case 'OUT': $typeName = '用户提款';
			break;
			case 'CANCEL_OUT': $typeName = '取消用户提款';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'FANSHUI': switch ($transferType)
		{
			case 'IN': $typeName = '系统返水';
			break;
			case 'CANCEL_IN': $typeName = '取消系统返水';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'AGLIVE': switch ($transferType)
		{
			case 'OUT': $typeName = 'AG极速厅转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消AG极速厅转出额度';
			break;
			case 'IN': $typeName = '转入AG极速厅账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入AG极速厅账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'AGINLIVE': switch ($transferType)
		{
			case 'OUT': $typeName = 'AG国际厅转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消AG国际厅转出额度';
			break;
			case 'IN': $typeName = '转入AG国际厅账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入AG国际厅账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'BBINLIVE': switch ($transferType)
		{
			case 'OUT': $typeName = 'BB波音厅转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消BB波音厅转出额度';
			break;
			case 'IN': $typeName = '转入BB波音厅账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入BB波音厅账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'OGLIVE': switch ($transferType)
		{
			case 'OUT': $typeName = 'OG东方厅转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消OG东方厅转出额度';
			break;
			case 'IN': $typeName = '转入OG东方厅账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入OG东方厅账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'MAYALIVE': switch ($transferType)
		{
			case 'OUT': $typeName = '玛雅娱乐厅转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消玛雅娱乐厅转出额度';
			break;
			case 'IN': $typeName = '转入玛雅娱乐厅账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入玛雅娱乐厅账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'SHABALIVE': switch ($transferType)
		{
			case 'OUT': $typeName = '沙巴体育转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消沙巴体育转出额度';
			break;
			case 'IN': $typeName = '转入沙巴体育账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入沙巴体育账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'PTLIVE': switch ($transferType)
		{
			case 'OUT': $typeName = 'PT电子转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消PT电子转出额度';
			break;
			case 'IN': $typeName = '转入PT电子账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入PT电子账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'MWLIVE': switch ($transferType)
		{
			case 'OUT': $typeName = 'MW电子转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消MW电子转出额度';
			break;
			case 'IN': $typeName = '转入MW电子账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入MW电子账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'KGLIVE': switch ($transferType)
		{
			case 'OUT': $typeName = 'AV女优转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消AV女优转出额度';
			break;
			case 'IN': $typeName = '转入AV女优账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入AV女优账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'CQ9LIVE': switch ($transferType)
		{
			case 'OUT': $typeName = 'CQ9转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消CQ9转出额度';
			break;
			case 'IN': $typeName = '转入CQ9账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入CQ9账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'VRLIVE': switch ($transferType)
		{
			case 'OUT': $typeName = 'VR彩票转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消VR彩票转出额度';
			break;
			case 'IN': $typeName = '转入VR彩票账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入VR彩票账号';
			break;
			default: $typeName = '';
			break;
		}
		break;		
		case 'BGLIVE': switch ($transferType)
		{
			case 'OUT': $typeName = 'BG视讯转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消BG视讯转出额度';
			break;
			case 'IN': $typeName = '转入BG视讯账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入BG视讯账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'SB': switch ($transferType)
		{
			case 'OUT': $typeName = '申博视讯转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消申博视讯转出额度';
			break;
			case 'IN': $typeName = '转入申博视讯账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入申博视讯账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'DG': switch ($transferType)
		{
			case 'OUT': $typeName = 'DG视讯转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消DG视讯转出额度';
			break;
			case 'IN': $typeName = '转入DG视讯账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入DG视讯账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'KY': switch ($transferType)
		{
			case 'OUT': $typeName = '开元棋牌转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消开元棋牌转出额度';
			break;
			case 'IN': $typeName = '转入开元棋牌账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入开元棋牌账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'MG2LIVE': switch ($transferType)
		{
			case 'OUT': $typeName = '新MG转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消新MG转出额度';
			break;
			case 'IN': $typeName = '转入新MG账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入新MG账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'PT2': switch ($transferType)
		{
			case 'OUT': $typeName = '新PT电子转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消新PT电子转出额度';
			break;
			case 'IN': $typeName = '转入新PT电子账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入新PT电子账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		case 'OG2': switch ($transferType)
		{
			case 'OUT': $typeName = '新OG东方厅转出额度';
			break;
			case 'CANCEL_OUT': $typeName = '取消新OG东方厅转出额度';
			break;
			case 'IN': $typeName = '转入新OG东方厅账号';
			break;
			case 'CANCEL_IN': $typeName = '取消转入新OG东方厅账号';
			break;
			default: $typeName = '';
			break;
		}
		break;
		default: $typeName = $gameType . '_' .$transferType;
		break;
	}
	return $typeName;
}
?>