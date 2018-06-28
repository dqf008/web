<?php 
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../include/newpage.php';
include_once '../class/user.php';
include_once '../common/function.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
if (!user::is_daili($uid))
{
	message('你还不是代理，请先申请', 'agent_reg.php');
}
$selectuser = trim($_GET['selectuser']);
$username = trim($_GET['username']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <title>下线会员</title> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
      <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
	  <link type="text/css" rel="stylesheet" href="images/member.css"/> 
	  <script type="text/javascript" src="images/member.js"></script> 
	  <!--[if IE 6]><script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]--> 
	  <script type="text/javascript" src="../js/calendar.js"></script> 
  </head> 
  <body> 
  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;">
  <?php include_once 'mainmenu.php';?>	  
  <tr> 
		<td colspan="2" align="center" valign="middle">
		  <?php include_once 'agentmenu.php';?>			  
		  <div class="content"> 
				  <table width="98%" border="0" cellspacing="0" cellpadding="5"> 
					  <form id="form1" name="form1" action="?query=true" method="get"> 
					  <tr> 
						  <td height="25" colspan="7" align="center" bgcolor="#D6D6D6"> 
                            会员账号 
                            <input name="selectuser" type="text" id="selectuser" size="15"  value="<?=$selectuser;?>" title="不填，表示显示所有下线会员"/> 
                            &nbsp;&nbsp;真实姓名 
                            <input name="username" type="text" id="username" size="15"  value="<?=$username;?>" title="不填，表示显示所有下线会员"/> 
							&nbsp;&nbsp;<input type="submit" name="query" class="submit_73" value="查询" /> 
						  </td> 
					  </tr> 
					  </form> 
					  <tr> 
						  <th align="center">会员账号</th> 
						  <th align="center">真实姓名</th> 
						  <th align="center">注册时间(美东/北京)</th> 
						  <th align="center">最近登录(美东/北京)</th> 
						  <th align="center">当前余额</th> 
						  <th align="center">注册方式</th>
						  <th align="center">在线</th> 
						  <th align="center">状态</th> 
					  </tr>
<?php 
$params = array(':uid' => $uid);
$sql = 'SELECT uid from `k_user` where `top_uid`=:uid ';
if(!empty($selectuser)){
    $sql.= ' AND `username` like :username ';
    $params[':username'] = '%'.$selectuser.'%';
}
if(!empty($username)){
    $sql.= ' AND `pay_name` like :pay_name ';
    $params[':pay_name'] = '%'.$username.'%';
}
$stmt = $mydata1_db->prepare($sql.'order by `uid` desc');
$stmt->execute($params);
$sum = $stmt->rowCount();
$thisPage = 1;
if ($_GET['page']){
	$thisPage = $_GET['page'];
}
$page = new newPage();
$perpage = 20;
$thisPage = $page->check_Page($thisPage, $sum, $perpage);
$id = '';
$i = 1;
$start = (($thisPage - 1) * $perpage) + 1;
$end = $thisPage * $perpage;
while ($row = $stmt->fetch())
{
	if (($start <= $i) && ($i <= $end))
	{
		$id .= intval($row['uid']) . ',';
	}
	if ($end < $i)
	{
		break;
	}
	$i++;
}
if ($id)
{
	$id = rtrim($id, ',');
	$sql = 'select u.*,l.is_login from k_user u left outer join k_user_login l on u.uid=l.uid where u.uid in(' . $id . ') order by u.uid desc';
	$query = $mydata1_db->query($sql);
	$i = 1;
	$sum_money = 0;
	$sum_sxf = 0;
	while ($rows = $query->fetch())
	{?> 					  <tr bgcolor="<?=$i % 2==0 ? '#FFFFFF' : '#F5F5F5';?>" align="center" onMouseOver="this.style.backgroundColor='#FFFFCC'" onMouseOut="this.style.backgroundColor='<?=$i % 2==0 ? '#FFFFFF' : '#F5F5F5';?>'" > 
						  <td align="center"><?=$rows['username'];?></td> 
						  <td align="center"><?=$rows['pay_name'];?></td> 
						  <td align="center"><?=date('Y-m-d H:i:s',strtotime($rows['reg_date']));?><br> <?=date('Y-m-d H:i:s',strtotime($rows['reg_date']) + (1 * 12 * 3600));?></td> 
						  <td align="center"><?=date('Y-m-d H:i:s',strtotime($rows['login_time']));?><br> <?=date('Y-m-d H:i:s',strtotime($rows['login_time']) + (1 * 12 * 3600));?></td> 
						  <td align="center"> <?=sprintf('%.2f',$rows['money']);?></td> 
						  <td align="center"><?=$rows['reg_mode']=='0'?'电脑注册':'手机注册'?><br/><?=date('y-m-d H:i',strtotime($rows['reg_date']))?></td>
						  <td align="center"><?=$rows['is_login']==1 ? "<span style='color:#ff0000'>在线</span>" : "离线";?></td> 
						  <td align="center"><?=$rows['is_stop']==0 ? "<span style='color:#ff0000'>启用</span>" : "停用";?></td> 
					  </tr><?php $i++;
	}
}?> 					  <tr> 
						  <th colspan="7" align="center"> 
							  <div class="Pagination">
							  <?=$page->get_htmlPage("agent_user.php?cn_begin=".$cn_begin."&s_begin_h=".$s_begin_h."&s_begin_i=".$s_begin_i."&cn_end=".$cn_end."&s_end_h=".$s_end_h."&s_end_i=".$s_end_i);?>							  
							  </div> 
						  </th> 
					  </tr> 
				  </table> 
			  </div> 
		  </td> 
	  </tr> 
  </table> 
  </body> 
  </html> 
