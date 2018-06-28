<?php if (!defined('PHPYOU_VER'))
{
	exit('非法进入');
}?> <link rel="stylesheet" href="images/xp.css" type="text/css"> 
  <script language="javascript" type="text/javascript" src="js_admin.js"></script> 
   
  <SCRIPT language=JAVASCRIPT> 
	  if(self == top) {location = '/';}  
	  if(window.location.host!=top.location.host){top.location=window.location;}  
  </SCRIPT> 
  <div align="center"> 
    <table width="100%" border="0" cellspacing="0" cellpadding="5"> 
      <tr class="tbtitle"> 
        <td width="29%"><?php require_once '1top.php';?></td> 
        <td width="34%">&nbsp;</td> 
        <td width="37%">&nbsp;</td> 
      </tr> 
      <tr > 
        <td height="5" colspan="3"></td> 
      </tr> 
    </table> 
    <table width="99%" border="1" cellpadding="5" cellspacing="1" bordercolor="f1f1f1"> 
      <tr> 
        <td bordercolor="cccccc" bgcolor="#FDF4CA">第<?=$_GET['kithe'];?>期撤销结算</td> 
      </tr> 
      <tr> 
        <td bordercolor="cccccc"><table width="90%" border="0" cellspacing="0" cellpadding="5" align="center" class="about"> 
          <tr>  
            <td><?php $kithe = $_GET['kithe'];
if ($kithe != '')
{
	$store_kithe = $_GET['kithe'];
	if (time() - intval($_SESSION['reCount' . $store_kithe]) <= 30)
	{?> <script type='text/javascript'>alert('为了防止重算错误，30秒之内不允许重复操作');history.back();</script><?php exit();
	}
	$_SESSION['reCount' . $store_kithe] = time();
	$params = array(':kithe' => $_GET['kithe']);
	$stmt = $mydata2_db->prepare('select count(*) from ka_tan where checked=0 and kithe=:kithe');
	$stmt->execute($params);
	$recordNum = $stmt->fetchColumn();
	if (0 < $recordNum)
	{?> <script type='text/javascript'>alert('不能重算,请相关管理人员！');history.back();</script><?php exit();
	}
	$stmt = $mydata1_db->prepare('delete from mydata1_db.ka_jiesuan_temp');
	$stmt->execute();
	$params = array(':kithe' => $_GET['kithe']);
	$sql = 'insert into mydata1_db.ka_jiesuan_temp' . "\r\n" . '                    select username,kithe,' . "\r\n" . '                    round(sum(if(bm=1,sum_m*rate,if(bm=2,sum_m,0))),2) as paicai,' . "\r\n" . '                    round(sum(if(bm=2,0,sum_m*abs(user_ds)/100)),2) as tuishui,' . "\r\n" . '                    0' . "\r\n" . '                    from mydata2_db.ka_tan ' . "\r\n" . '                    where kithe=:kithe' . "\r\n" . '                    and checked=1' . "\r\n" . '                    group by username';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$params = array(':kithe' => $_GET['kithe']);
	$stmt = $mydata2_db->prepare('update ka_tan set checked=0,bm=0 where kithe=:kithe');
	$stmt->execute($params);
	$sql = 'update mydata1_db.k_user k,mydata1_db.ka_jiesuan_temp t' . "\r\n" . '                        set t.checked=1,k.money = k.money-(t.paicai+t.tuishui),t.checked=2' . "\r\n" . '                        where k.username = t.username';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute();
	$creationTime = date('Y-m-d H:i:s', time() - (12 * 3600));
	$params = array(':kithe' => $_GET['kithe'], ':creationTime' => $creationTime);
	$sql = 'INSERT INTO mydata1_db.k_money_log (' . "\r\n" . '                            uid,' . "\r\n" . '                            userName,' . "\r\n" . '                            gameType,' . "\r\n" . '                            transferType,' . "\r\n" . '                            transferOrder,' . "\r\n" . '                            transferAmount,' . "\r\n" . '                            previousAmount,' . "\r\n" . '                            currentAmount,' . "\r\n" . '                            creationTime) ' . "\r\n" . '                        SELECT ' . "\r\n" . '                            k.uid,' . "\r\n" . '                            k.username,' . "\r\n" . '                            \'SIX\',' . "\r\n" . '                            \'RECALC\',' . "\r\n" . '                            concat(t.kithe,\'_\',k.username),' . "\r\n" . '                            -(t.paicai+t.tuishui),' . "\r\n" . '                            money+(t.paicai+t.tuishui),' . "\r\n" . '                            money,' . "\r\n" . '                            :creationTime' . "\r\n" . '                        FROM mydata1_db.ka_jiesuan_temp t ' . "\r\n" . '                            left join mydata1_db.k_user k on t.username = k.username' . "\r\n" . '                        where k.username is not null' . "\r\n" . '                        and t.kithe=:kithe';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$params = array(':nn' => $kithe);
	$sql = 'update ka_kithe set score=0 where nn=:nn';
	$stmt = $mydata2_db->prepare($sql);
	$stmt->execute($params);
	unset($_SESSION['count' . $store_kithe]);?>撤销结算完成，会员金额已恢复成未结算前状态，请确认开奖结果再结算！<?php }?> 		  </td> 
         </tr> 
        </table> 
	   </td> 
      </tr> 
    </table> 
  </div>