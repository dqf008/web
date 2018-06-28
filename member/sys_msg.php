<?php 
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../class/user.php';
include_once '../common/function.php';
include_once '../include/newpage.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <title>系统消息</title> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
      <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
	  <link type="text/css" rel="stylesheet" href="images/member.css"/> 
	  <script type="text/javascript" src="images/member.js"></script> 
	  <!--[if IE 6]><script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]--> 
  </head> 
  <body> 
  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;">
  <?php 
	include_once("mainmenu.php");
  ?>
  <tr> 
	<td colspan="2" align="center" valign="middle">
		<?php 
			include_once("usermenu.php");
		?>
		 <div class="content"> 
		  <table width="98%" border="0" cellspacing="0" cellpadding="5"> 
			<tr> 
				  <th width="40" align="center">状态</th> 
				  <th align="center">短信标题</th> 
				  <th width="100" align="center">发布时间</th> 
				  <th width="100" align="center"><a href="javascript:void(0);" onclick="if(confirm('您真的要删除全部消息吗？')){Go('sys_msg_del.php?id=-1');}return false" style="color:#F00">全部删除</a></th> 
			</tr>
			<?php 
			$params = array(':uid' => $uid);
			$sql = 'select msg_id from k_user_msg where uid=:uid order by islook asc,msg_id desc';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$sum = $stmt->rowCount();
			$thisPage = 1;
			if (@($_GET['page']))
			{
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
					$id .= intval($row['msg_id']) . ',';
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
				$sql	=	"select islook,msg_title,msg_time,msg_id from k_user_msg where msg_id in($id) order by islook asc,msg_id desc";
				$query = $mydata1_db->query($sql);
				$i = 1;
				while ($rows = $query->fetch())
				{
			?> 	
					<tr bgcolor="<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>" align="center" onMouseOver="this.style.backgroundColor='#FFFFCC'" onMouseOut="this.style.backgroundColor='<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>'" >
						<td align="center"><font color="#FF0000"><?=$rows["islook"]==1?'已读':'未读'?></font></td>
						<td align="left"><a href="javascript:void(0);" onclick="Go('sys_msg_show.php?id=<?=$rows["msg_id"]?>');return false"><?=strlen(trim($rows["msg_title"]))?$rows["msg_title"]:'无标题信息'?></a></td>
						<td align="center"><?=date("Y-m-d",strtotime($rows["msg_time"]))?></td>
						<td align="center"><a href="javascript:void(0);" onclick="if(confirm('您真的要删除该条消息吗？')){Go('sys_msg_del.php?id=<?=$rows["msg_id"]?>');}return false" style="color:#00F">点击删除</a></td>
					</tr>
		
					<?php
							$i++;
						}
					}
					?>					  <tr> 
						  <th colspan="4" align="center"> 
							  <div class="Pagination">
							  	<?=$page->get_htmlPage("sys_msg.php?1=1");?>					  
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
