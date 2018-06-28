<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('bbgl');
if (intval($_GET['action']) != 1){
	if (!isset($_GET['s_time']) || ($_GET['s_time'] == '')){
		$_GET['s_time'] = date('Y-m-d', strtotime('-2 days'));
	}
}
$_LIVE = include('../../cj/include/live.php');
$_GET['caizhong'] = isset($_GET['caizhong'])?$_GET['caizhong']:'ALL';
$_GET['caizhong'] = isset($_LIVE[$_GET['caizhong']])?$_GET['caizhong']:'ALL';
?> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
  <title>Welcome</title> 
  <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" /> 
  </head> 
  <script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 
  <script language="JavaScript" src="/js/calendar.js"></script> 
  <body> 
  <div id="pageMain"> 
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5"> 
      <tr> 
        <td valign="top"> 
        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9"> 
       <form name="form1" method="get" action="zrorder.php" onSubmit="return check();"> 
        <tr> 
          <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;
             <select name="caizhong" id="caizhong"> 
			  <option value="ALL" <?=$_GET['caizhong']=='ALL' ? 'selected' : ''?>>全部</option>
<?php foreach($_LIVE as $key=>$val){ ?>			  <option value="<?php echo $key; ?>" <?=$_GET['caizhong']==$key&&$_GET['caizhong']!='ALL' ? 'selected' : ''?>><?php echo $val[1]; ?></option>
<?php } ?>            </select> 
            &nbsp;&nbsp;会员：<input name="username" type="text" id="username" value="<?=$_GET['username']?>" size="15">
            &nbsp;&nbsp;日期：
            <input name="s_time" type="text" id="s_time" value="<?=$_GET['s_time']?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />
            ~
            <input name="e_time" type="text" id="e_time" value="<?=$_GET['e_time']?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />&nbsp;&nbsp;
            <input name="action" id="action" type="hidden" value="1">
			<input type="submit" name="Submit" value="搜索"></td> 
          </tr>    
        </form> 
      </table> 
          <table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;" bgcolor="#798EB9">    
              <tr style="background-color:#3C4D82;color:#FFF;line-height:25px"> 
                <td align="center"><strong>账号</strong></td> 
                <td align="center"><strong>真人娱乐</strong></td> 
                <td align="center"><strong>注单数</strong></td> 
                <td align="center"><strong>下注金额</strong></td> 
                <td align="center"><strong>派彩金额</strong></td> 
                <td align="center"><strong>有效投注额</strong></td> 
                <td align="center"><strong>盈亏</strong></td> 
          </tr> 
<?php
if(isset($_GET['action'])){
$params = array();
$params[':s_time'] = isset($_GET['s_time'])&&!empty($_GET['s_time'])?strtotime($_GET['s_time']):time();
$params[':e_time'] = isset($_GET['e_time'])&&!empty($_GET['e_time'])?strtotime($_GET['e_time']):time();
$sql = 'SELECT `r`.*,`u`.`username` FROM `daily_report` AS `r` LEFT OUTER JOIN `k_user` AS `u` ON `u`.`uid`=`r`.`uid` WHERE `r`.`report_date` BETWEEN :s_time AND :e_time';
if($_GET['caizhong']!='ALL'){
	$params[':pid'] = $_GET['caizhong'];
	$sql.= ' AND `r`.`platform_id`=:pid';
}
if(isset($_GET['username'])&&!empty($_GET['username'])){
	$_GET['caizhong'] = '1';
	$params[':username'] = $_GET['username'];
	$sql.= ' AND `u`.`username`=:username';
}
$sql .= ' ORDER BY `r`.`report_date` DESC, `r`.`id` DESC';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$return = array();
$return['SUM'] = array(
	'bet_amount' => 0,
	'net_amount' => 0,
	'valid_amount' => 0,
	'rows_num' => 0,
);
while($rows = $stmt->fetch()){
	$uid = $rows['uid'];
	$pid = $rows['platform_id'];
	if(!isset($return[$uid])){
		$return[$uid] = array();
		$return[$uid]['username'] = $rows['username'];
		$return[$uid]['SUM'] = array(
			'bet_amount' => 0,
			'net_amount' => 0,
			'valid_amount' => 0,
			'rows_num' => 0,
		);
	}
	if(!isset($return[$uid][$pid])){
		$return[$uid][$pid] = array(
			'bet_amount' => $rows['bet_amount']/100,
			'net_amount' => $rows['net_amount']/100,
			'valid_amount' => $rows['valid_amount']/100,
			'rows_num' => $rows['rows_num'],
		);
	}else{
		$return[$uid][$pid]['bet_amount']+= $rows['bet_amount']/100;
		$return[$uid][$pid]['net_amount']+= $rows['net_amount']/100;
		$return[$uid][$pid]['valid_amount']+= $rows['valid_amount']/100;
		$return[$uid][$pid]['rows_num']+= $rows['rows_num'];
	}
	$return[$uid]['SUM']['bet_amount']+= $rows['bet_amount']/100;
	$return[$uid]['SUM']['net_amount']+= $rows['net_amount']/100;
	$return[$uid]['SUM']['valid_amount']+= $rows['valid_amount']/100;
	$return[$uid]['SUM']['rows_num']+= $rows['rows_num'];
	$return['SUM']['bet_amount']+= $rows['bet_amount']/100;
	$return['SUM']['net_amount']+= $rows['net_amount']/100;
	$return['SUM']['valid_amount']+= $rows['valid_amount']/100;
	$return['SUM']['rows_num']+= $rows['rows_num'];
}
foreach($return as $uid=>$rows){
	if($uid!='SUM'){
		foreach($rows as $pid=>$amount){
			if(preg_match('/^\d+$/', $pid)){
				if($_GET['caizhong']=='ALL'&&count($rows)<=3){
					$out_color = '#D9E7F4';
					$over_color = '#D9E7F4';
				}else{
					$out_color = '#fff';
					$over_color = '#EBEBEB';
				}
?>       
		<tr align="center" onMouseOver="this.style.backgroundColor='<?php echo $over_color; ?>'" onMouseOut="this.style.backgroundColor='<?php echo $out_color; ?>'" style="background-color:<?php echo $out_color; ?>;line-height:25px;"> 
          <td><?php echo $rows['username']; ?></td> 
          <td><?php echo $_LIVE[$pid][1]; ?></td> 
          <td><?php echo $amount['rows_num']; ?></td> 
          <td><?php echo sprintf('%.2f', $amount['bet_amount']); ?></td> 
          <td><?php echo sprintf('%.2f', $amount['bet_amount']+$amount['net_amount']); ?></td> 
          <td><?php echo sprintf('%.2f', $amount['valid_amount']); ?></td> 
          <td><span style="color:<?php echo $amount['net_amount']<0 ? '#FF0000' : '#009900';?>;"><?php echo sprintf('%.2f', -1*$amount['net_amount']); ?></span></td> 
        </tr>
<?php }}if($_GET['caizhong']=='ALL'&&count($rows)>3){ ?>
        <tr align="center" style="background-color:#D9E7F4;line-height:25px;font-weight: bold;"> 
          <td><?php echo $rows['username']; ?></td> 
          <td>合计</td> 
          <td><?php echo $rows['SUM']['rows_num']; ?></td> 
          <td><?php echo sprintf('%.2f', $rows['SUM']['bet_amount']); ?></td> 
          <td><?php echo sprintf('%.2f', $rows['SUM']['bet_amount']+$rows['SUM']['net_amount']); ?></td> 
          <td><?php echo sprintf('%.2f', $rows['SUM']['valid_amount']); ?></td> 
          <td><span style="color:<?php echo $rows['SUM']['net_amount']<0 ? '#FF0000' : '#009900';?>;"><?php echo sprintf('%.2f', -1*$rows['SUM']['net_amount']); ?></span></td> 
          </tr> 
<?php }}}} ?>       
        <tr align="center" style="background-color:#ffffff;line-height:25px;font-weight: bold;"> 
          <td colspan="2">总合计</td> 
          <td><?php echo $return['SUM']['rows_num']; ?></td> 
          <td><?php echo sprintf('%.2f', $return['SUM']['bet_amount']); ?></td> 
          <td><?php echo sprintf('%.2f', $return['SUM']['bet_amount']+$return['SUM']['net_amount']); ?></td> 
          <td><?php echo sprintf('%.2f', $return['SUM']['valid_amount']); ?></td> 
          <td><span style="color:<?php echo $return['SUM']['net_amount']<0 ? '#FF0000' : '#009900';?>;"><?php echo sprintf('%.2f', -1*$return['SUM']['net_amount']); ?></span></td> 
          </tr> 
      </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="font12" style="margin-top:5px;line-height:20px;"> 
	  <tr> 
		  <td> 
			  <p>温馨提醒：</p> 
			  <p style="color:#f00">1、真人下注非实时结果，需要等待系统生成报表后才能查询！</p> 
			  <p>2、报表时间为美东时间，请注意时间差。</p> 
			  <p>3、查询全部投注的情况下，蓝色行表示下注合计。</p> 
		  </td> 
	  </tr> 
  </table> 
      </td> 
      </tr> 
    </table> 
  </div> 
  </body> 
  </html>