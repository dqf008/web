<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../member/pay/moneyconfig.php';
check_quanxian('xtgl');
if (@($_GET['action']) == 'save'){
	if (count($_POST) < 1){
		message('网站设置失败!');
	}
	$str5 = '';
	$gids = $_POST['gid'];
	
	for ($i = 0;$i < count($gids);$i++){
		$str = 'paytype_' . $gids[$i];
		$gs = $_POST[$str];
		if ($gs){
			$str5 = $str5 . getStr($gids[$i], $gs);
		}
	}
	$str4 = '';//'<?php ' . "\r\n";
	$str4 .= 'unset($pay_online_type);' . "\r\n";
	$str4 .= 'unset($payquery);' . "\r\n";
	$str4 .= $str5;
	$str4 .= '$payquery' . "\t" . '=' . "\t" . intval($_POST['payquery']) . ';' . "\r\n";
	$mydata1_db->exec('update webinfo set content="'.$str4.'" where code="pay_conf"');
	/*$path = '../../member/pay/cache/pay_conf.php';
	if($fp = fopen($path, 'w')) {
	    $startTime = microtime();
	    do {
	            $canWrite = flock($fp, LOCK_EX);
	        if(!$canWrite) usleep(round(rand(0, 100)*1000));
	    } while ((!$canWrite) ＆＆ ((microtime()-$startTime) < 1000));
	 
	    if ($canWrite) {
	      fwrite($fp, $str4);
	    }
	    fclose($fp);
	}*/
	/*if (!write_file('../../member/pay/cache/pay_conf.php', $str4 . '?>')){
		message('缓存文件写入失败！请先设/web/member/pay/cache/pay_conf.php文件权限为：0777');
	}*/
	message('设置成功!');
}
//查出在线支付

//echo "<pre/>";
//print_r($arr_online_config);
?>
<HTML> 
<HEAD> 
	  <META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
	  <TITLE>用户组列表</TITLE> 
	  <style type="text/css"> 
	  table.gridtable { 
			  font-family: verdana,arial,sans-serif;
			  font-size:11px;
			  color:#333333;
			  border-width: 1px;
			  border-color: #666666;
			  border-collapse: collapse;
	  } 
	  table.gridtable th { 
			  border-width: 1px;
			  padding: 8px;
			  border-style: solid;
			  border-color: #666666;
			  background-color: #dedede;
	  } 
	  table.gridtable td { 
			  border-width: 1px;
			  padding: 8px;
			  border-style: solid;
			  border-color: #666666;
			  background-color: #ffffff;
	  } 
	  </style> 
</HEAD> 

<body> 
  <form action="set_pay.php?action=save" method="post" name="form1" id="form1"> 
		  <table  class="gridtable" style="width: 750px;"> 
			  <tr> 
				  <th style="width: 80px;">用户组</th> 
				  <th>支付类型</th> 
			  </tr>
<?php 
$sql = 'select g.id,g.name from `k_group` g order by g.id asc';
$query = $mydata1_db->query($sql);
while ($rows = $query->fetch())
{
?>                   	 
				<input type="hidden" name="gid[]" value="<?=$rows['id'];?>"> 
				  <tr> 
					  <td><?=$rows['name'];?></td> 
					  <td>
<?php 
$i = 1;
foreach ($arr_online_config as $k => $v){
	$cked = '';
	if(empty($v['online_name'])) continue;
	if (count($pay_online_type[$rows['id']]))
	{
		$cked = (in_array($k, $pay_online_type[$rows['id']]) ? 'checked' : '');
	}
?>
                              <span style="float: left;margin-left: 10px;margin-top: 5px;"> 
							  <input type="checkbox" name="paytype_<?=$rows['id'];?>[]" value="<?=$k;?>"<?=$cked;?>><?=$k;?>
							  </span>
<?php 
	$i++;
}
?>           				
					  </td> 
				  </tr>
<?php }?>                  
		  </table> 
   
	  <div style="text-align: left;margin-top: 10px;border-width:0px;font-size:11px;"> 
		  在线支付检验开关：<input name="payquery" type="checkbox" id="payquery" value="1" <?=$payquery==1 ? 'checked' : '';?>>目前支持智付3.0、易宝、宝付、新生、环讯新版、融宝等在线支付平台</td> 
	  </div> 
	  <div style="text-align: center;margin-top: 10px;border-width:0px;font-size:11px;"> 
			  <input type="submit" value="确 定"> 
			  <input type="button" value="重 置" onClick="javascript:document.form1.reset();"> 
	  </div> 
	  </form> 
</body> 
</HTML>
<?php 
function getStr($gid, $gs){
	for ($i = 0;$i < count($gs);$i++){
		$str4 .= '$pay_online_type[' . $gid . '][] = \'' . $gs[$i] . '\';' . "\r\n";
	}
	return $str4;
}
?>