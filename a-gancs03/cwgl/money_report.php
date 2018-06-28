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
	  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="font12" style="border:1px solid #798EB9;"> 
		  <form name="form1" method="get" action=""> 
		  <tr bgcolor="#FFFFFF"> 
			  <td align="left"> 
				  <select name="time" id="time"> 
					  <option value="CN" <?=$time=='CN' ? 'selected' : ''?>>中国时间</option>
          			  <option value="EN" <?=$time=='EN' ? 'selected' : ''?>>美东时间</option>
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
                  &nbsp;<input name="find" type="submit" id="find" value="汇总"/> 
			  </td> 
		  </tr> 
		  <tr>
		  	<td><div id="date_quick"></div>
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
	  	</script></td>
		  </tr>
		  </form> 
	  </table>
	 <?php 
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
	?>	  
	<table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;line-height:20px;" bgcolor="#798EB9"> 
		  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
			  <td colspan="8"><?php echo $time=='CN'?'中国':'美东'; ?>时间 <?php echo $btime; ?> 至 <?php echo $etime; ?> 财务汇总</td> 
		  </tr>
            <tr align="center" style="background-color:#aee0f7;"> 
              <td>收入项目</td> 
              <td>数量</td> 
              <td>金额</td> 
              <td>支出项目</td> 
              <td>数量</td> 
              <td>金额</td> 
              <td colspan="2">其它项目</td> 
          </tr>
	<?php
    $report = array(
        'zxhk' => 'SELECT COUNT(*) AS COUNT, SUM(money) AS SUM FROM huikuan WHERE status=1 AND adddate>=:q_btime AND adddate<=:q_etime',
        'zxcz' => 'SELECT COUNT(*) AS COUNT, SUM(m_value) AS SUM FROM k_money WHERE type=1 AND status=1 AND m_make_time>=:q_btime AND m_make_time<=:q_etime',
        'rghk' => 'SELECT COUNT(*) AS COUNT, SUM(m_value) AS SUM FROM k_money WHERE type=3 AND status=1 AND m_make_time>=:q_btime AND m_make_time<=:q_etime',
        'zxqk' => 'SELECT COUNT(*) AS COUNT, SUM(m_value) AS SUM FROM k_money WHERE type=2 AND status=1 AND m_make_time>=:q_btime AND m_make_time<=:q_etime',
        'fsps' => 'SELECT COUNT(*) AS COUNT, SUM(m_value) AS SUM FROM k_money WHERE type=5 AND status=1 AND m_make_time>=:q_btime AND m_make_time<=:q_etime',
        'cjps' => 'SELECT COUNT(*) AS COUNT, SUM(m_value) AS SUM FROM k_money WHERE type=4 AND status=1 AND m_make_time>=:q_btime AND m_make_time<=:q_etime',
        'qtjk' => 'SELECT COUNT(*) AS COUNT, SUM(m_value) AS SUM FROM k_money WHERE type=6 AND status=1 AND m_value>0 AND m_make_time>=:q_btime AND m_make_time<=:q_etime',
        'qtkk' => 'SELECT COUNT(*) AS COUNT, SUM(m_value) AS SUM FROM k_money WHERE type=6 AND status=1 AND m_value<0 AND m_make_time>=:q_btime AND m_make_time<=:q_etime',
    );
    foreach($report as $key=>$sql){
        $params = array(':q_btime' => $q_btime, ':q_etime' => $q_etime);
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $report[$key] = $stmt->fetch();
    }
	?>		  
            <tr align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#ffffff'" style="background-color:#ffffff;"> 
                 <td>在线汇款</td> 
                 <td><?php echo $report['zxhk']['COUNT']; ?> 单</td> 
                 <td><?php echo sprintf("%.2f", $report['zxhk']['SUM']); ?> <a href="hccw.php?time=<?php echo $time; ?>&amp;bdate=<?php echo $bdate; ?>&amp;bhour=<?php echo $bhour; ?>&amp;bsecond=<?php echo $bsecond; ?>&amp;edate=<?php echo $edate; ?>&amp;ehour=<?php echo $ehour; ?>&amp;esecond=<?php echo $esecond; ?>&amp;type=7">(详情)</a></td> 
                 <td>在线取款</td> 
                 <td><?php echo $report['zxqk']['COUNT']; ?> 单</td> 
                 <td><?php echo sprintf("%.2f", -1*$report['zxqk']['SUM']); ?> <a href="hccw.php?time=<?php echo $time; ?>&amp;bdate=<?php echo $bdate; ?>&amp;bhour=<?php echo $bhour; ?>&amp;bsecond=<?php echo $bsecond; ?>&amp;edate=<?php echo $edate; ?>&amp;ehour=<?php echo $ehour; ?>&amp;esecond=<?php echo $esecond; ?>&amp;type=2">(详情)</a></td> 
                 <td>加款</td> 
                 <td>扣款</td> 
            </tr>
            <tr align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#ffffff'" style="background-color:#ffffff;"> 
                 <td>在线充值</td> 
                 <td><?php echo $report['zxcz']['COUNT']; ?> 单</td> 
                 <td><?php echo sprintf("%.2f", $report['zxcz']['SUM']); ?> <a href="hccw.php?time=<?php echo $time; ?>&amp;bdate=<?php echo $bdate; ?>&amp;bhour=<?php echo $bhour; ?>&amp;bsecond=<?php echo $bsecond; ?>&amp;edate=<?php echo $edate; ?>&amp;ehour=<?php echo $ehour; ?>&amp;esecond=<?php echo $esecond; ?>&amp;type=1">(详情)</a></td> 
                 <td>返水派送</td> 
                 <td><?php echo $report['fsps']['COUNT']; ?> 单</td> 
                 <td><?php echo sprintf("%.2f", $report['fsps']['SUM']); ?> <a href="hccw.php?time=<?php echo $time; ?>&amp;bdate=<?php echo $bdate; ?>&amp;bhour=<?php echo $bhour; ?>&amp;bsecond=<?php echo $bsecond; ?>&amp;edate=<?php echo $edate; ?>&amp;ehour=<?php echo $ehour; ?>&amp;esecond=<?php echo $esecond; ?>&amp;type=5">(详情)</a></td> 
                 <td><?php echo $report['qtjk']['COUNT']; ?> 单</td> 
                 <td><?php echo $report['qtkk']['COUNT']; ?> 单</td> 
            </tr>
			<tr align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#ffffff'" style="background-color:#ffffff;"> 
                 <td>人工汇款</td> 
                 <td><?php echo $report['rghk']['COUNT']; ?> 单</td> 
                 <td><?php echo sprintf("%.2f", $report['rghk']['SUM']); ?> <a href="hccw.php?time=<?php echo $time; ?>&amp;bdate=<?php echo $bdate; ?>&amp;bhour=<?php echo $bhour; ?>&amp;bsecond=<?php echo $bsecond; ?>&amp;edate=<?php echo $edate; ?>&amp;ehour=<?php echo $ehour; ?>&amp;esecond=<?php echo $esecond; ?>&amp;type=3">(详情)</a></td> 
                 <td>彩金派送</td> 
                 <td><?php echo $report['cjps']['COUNT']; ?> 单</td> 
                 <td><?php echo sprintf("%.2f", $report['cjps']['SUM']); ?> <a href="hccw.php?time=<?php echo $time; ?>&amp;bdate=<?php echo $bdate; ?>&amp;bhour=<?php echo $bhour; ?>&amp;bsecond=<?php echo $bsecond; ?>&amp;edate=<?php echo $edate; ?>&amp;ehour=<?php echo $ehour; ?>&amp;esecond=<?php echo $esecond; ?>&amp;type=4">(详情)</a></td> 
                 <td><?php echo sprintf("%.2f", $report['qtjk']['SUM']); ?> <a href="hccw.php?time=<?php echo $time; ?>&amp;bdate=<?php echo $bdate; ?>&amp;bhour=<?php echo $bhour; ?>&amp;bsecond=<?php echo $bsecond; ?>&amp;edate=<?php echo $edate; ?>&amp;ehour=<?php echo $ehour; ?>&amp;esecond=<?php echo $esecond; ?>&amp;type=6">(详情)</a></td> 
                 <td><?php echo sprintf("%.2f", -1*$report['qtkk']['SUM']); ?> <a href="hccw.php?time=<?php echo $time; ?>&amp;bdate=<?php echo $bdate; ?>&amp;bhour=<?php echo $bhour; ?>&amp;bsecond=<?php echo $bsecond; ?>&amp;edate=<?php echo $edate; ?>&amp;ehour=<?php echo $ehour; ?>&amp;esecond=<?php echo $esecond; ?>&amp;type=6">(详情)</a></td> 
            </tr>
	</table>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="font12" style="margin-top:5px;line-height:20px;"> 
      <tr> 
          <td> 
              <p>项目入款（在线汇款+在线充值+人工汇款）：<?php echo sprintf("%.2f", $report['zxhk']['SUM']+$report['zxcz']['SUM']+$report['rghk']['SUM']); ?></p> 
              <p>会员优惠（返水派送+彩金派送）：<?php echo sprintf("%.2f", $report['fsps']['SUM']+$report['cjps']['SUM']); ?></p> 
              <p>实际收入（在线汇款+在线充值+人工汇款-在线取款）：<?php echo sprintf("%.2f", $report['zxhk']['SUM']+$report['zxcz']['SUM']+$report['rghk']['SUM']+$report['zxqk']['SUM']); ?></p> 
              <p style="color:#f00">温馨提示：1.实际收入未减去手续费；2.其它项目加减款未列入以上计算；3.本页内容仅供记账参考。</p> 
          </td> 
      </tr> 
  </table> 

	</div> 
  </div> 
  </body> 
  </html>