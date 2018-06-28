<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../cache/hlhy.php';
check_quanxian('bbgl');
$btime = $_GET['btime'];
$etime = $_GET['etime'];
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
  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;line-height:20px;" bgcolor="#798EB9">    
	  <tr align="center" style="background:#3C4D82;color:#ffffff;font-weight:bold;"> 
		  <td colspan="2"><?=$btime;?>至<?=$etime;?>&nbsp;&nbsp; <?=$username==""? "合计" : "会员账号：".$username;?>&nbsp;&nbsp;财务报表</td> 
	  </tr> 
	  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
		  <td>银行</td> 
		  <td>金额</td> 
	  </tr>
<?php 
$color = '#FFFFFF';
$over = '#EBEBEB';
$out = '#ffffff';
$sqlwhere = '';
if (0 < count($hlhy))
{
$sqlwhere = ' and h.uid not in(' . $hl_uid . ')';
}
$params = array();
if ($username != '')
{
$params[':username'] = $username;
$sqlwhere .= ' and username=:username';
}
$params[':btime'] = $btime;
$params[':etime'] = $etime;
$sql = 'select bank,sum(ifnull(h.money,0)) as h_value from huikuan h left join k_user k on h.uid = k.uid where h.status=1 and h.adddate>=:btime and h.adddate<=:etime ' . $sqlwhere . ' group by bank order by bank';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
while ($row = $stmt->fetch())
{
?> 		  
	  <tr align="center" onMouseOver="this.style.backgroundColor='<?=$over;?>'" onMouseOut="this.style.backgroundColor='<?=$out;?>'" style="background-color:<?=$color;?>;"> 
		  <td><?=$row['bank'];?></td> 
		  <td><?=sprintf('%.2f',$row['h_value']);?></td> 
	  </tr>
<?php }?> 	  
</table> 
</div> 
</body> 
</html>