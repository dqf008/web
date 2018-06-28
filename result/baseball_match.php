<?php 
session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
$date = date('Y-m-d', time());
$month = array("January","February","March","April","May","June","July","August","September","October","November","December");
if ($_GET['list_date']){
	$date = $_GET['list_date'];
}

$chg_type = $month[date('m',strtotime($date))-1];

$last_url = "/result/baseball_match.php?list_date=".date('Y-m-d',strtotime($date)-24*60*60)."&langx=zh-cn";
if( strtotime(date('Y-m-d', time())) > strtotime($date) ){
	$next_url = "/result/baseball_match.php?list_date=".date('Y-m-d',strtotime($date)+24*60*60)."&langx=zh-cn";
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
  <title>home</title> 
  <link href="../skin/sports/right.css" rel="stylesheet" type="text/css" /> 
  <link href="/sprots_images/reset.css" rel="stylesheet" type="text/css">
  <link href="/sprots_images/my_account.css" rel="stylesheet" type="text/css">
  <link href="/sprots_images/calendar.css" rel="stylesheet" type="text/css">

  <script language="javascript"> 
	  if(self==top){ 
		  top.location='/index.php';
	  } 

	  var game_type = 'BS';
	  var chg_type = "<?=$chg_type?>";
	  var game_date = "<?=$date?>";
	  var max_day ="<?=date('Y-m-d')?>";
	  var lasttr ='N';//最後的tr是否為藍色


  </script> 
  <script language="javascript" src="/js/jquery.js"></script>  
  <script language="javascript"> 
	  var i = 31;
	  function check(){ 
		  clearTimeout(aas);
		  i = i -1;
		  $("#location").html("对不起,您点击页面太快,请在"+i+"秒后进行操作");
		  if(i == 1){ 
			  window.location.href ='bet_match.php' 
		  } 
		  var aas = setTimeout("check()",1000);
	  } 
  </script>

  <script src="/sprots_images/util.js"></script>
  <script src="/sprots_images/ClassFankCal_history.js"></script>
  <script src="/sprots_images/result.js"></script> 
  <!--script language="javascript" src="/js/mouse.js"></script--> 
</head> 
<body onLoad="init();">
<div id="div_state" class="acc_leftMain">
	<!--header-->
	<div class="acc_header noFloat"><span class="acc_refreshBTN" onClick="reload_var();"></span><h1>赛果</h1></div>

    <div class="acc_state_head">
        <span class="acc_result_ball">
	        <ul class="acc_selectMS">
	          	<li id = "sel_gtype" onClick="showOption('gtype');" class="acc_selectMS_first" >足球</li>
	        	<ul id = "chose_gtype" class="acc_selectMS_options" style="display:none;">
	              <li id = "gtype_FT" value = "FT">足球</li>
	              <li id = "gtype_BK"   value="BK">篮球 / 美式足球</li>
	              <li id = "gtype_TN" value = "TN">网球</li>
	              <li id = "gtype_VB" value = "VB">排球</li>
	              <!--li id = "gtype_BM" value = "BM">羽毛球</li>
	              <li id = "gtype_TT" value = "TT">乒乓球</li-->
	              <li id = "gtype_BS" value = "BS">棒球</li>
	              <!--li id = "gtype_SK" value = "SK">斯诺克/台球</li>
	              <li id = "gtype_OP" value = "OP">其他</li-->
	            </ul>
	        </ul>
        </span>

        <span class="acc_result_small">
	        <ul class="acc_selectMS">
	         	<li id = "sel_type" onClick="showOption('type');" class="acc_selectMS_first">赛事</li>
		        	<ul id = "chose_type" class="acc_selectMS_options" style="display:none;">
		              <li id ="Matches" value = "">赛事</li>
		              <!--li id ="Outright" value = "FS">冠军</li-->
		            </ul>
		        </li>
	        </ul>
        </span>

        <span class="acc_result_small">
          <span class="acc_state_title">选择日期</span>
         	<ul class="acc_selectMS">
         		<li id="date_start" onClick="showDate();" class="acc_selectMS_first"><?=$date?></li>
         	</ul>
          </span>

        <span class="acc_previous_btn" onclick='setUrl("<?=$last_url?>")'>前一天</span>
        <span class="acc_next_btn" onclick='setUrl("<?=$next_url?>")'>下一天</span>
        </div>

       <div>
          <table cellpadding="0" cellspacing="0" border="0" id="results_tableLine" class="acc_results_table">
             <tr class="acc_results_tr_title">
                <td class="acc_results_timew" style="width:15%;"></td>
                <td class="acc_results_teamw" style="width:65%;"></td>
                <td class="acc_results_otherw" style="width:10%;">半场</td>
                <td class="acc_results_otherw" style="width:10%;">全场</td>
             </tr>
		<?php 
		$params[':match_Date'] = date('m-d', strtotime($date));
		$sql = 'select Match_Date,Match_Time,match_name,match_master,Match_MatchTime,match_guest,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from mydata4_db.baseball_match where MB_Inball is not null and  match_Date=:match_Date and match_js=1';//
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$rows = $stmt->fetch();

		if(!$rows){
			echo "<tr><td height='100' colspan='4' align='center' bgcolor='#FFFFFF'>暂无任何赛果</td></tr>";
		}else{
			do{
				if($temp_match_name!=$rows["match_name"]){
					$temp_match_name=$rows["match_name"]; 
		?>
		<tr class="acc_results_league">
		    <td colspan="4" ><span><?=$rows["match_name"]?></span></td>
		</tr>
		<?php
				}
		?>

			<tr class="acc_result_tr_top" >
			    <td rowspan="2" class="acc_result_time"><?=$rows["Match_MatchTime"]?></td>
			    <td class="acc_result_team acc_result_full"><?=$rows["match_master"]?> &nbsp;&nbsp;</td>
			    <td class="acc_result_full"><span class="BlackWord"><?=$rows["MB_Inball"]<0?"赛事无效":$rows["MB_Inball_HR"] ?></span></td>
			    <td class="acc_result_bg"><span class="BlackWord"><?=$rows["MB_Inball"]<0?"赛事无效":$rows["MB_Inball"]===null ?'':$rows["MB_Inball"]?></span></td>
			    
			   
			 </tr>

			 <tr class="acc_result_tr_other">
			    <td class="acc_result_team acc_result_full"><?=$rows["match_guest"]?> &nbsp;&nbsp;</td>
			    <td class="acc_result_full"><span class="BlackWord"><?=$rows["TG_Inball"]<0?"赛事无效":$rows["TG_Inball_HR"] ?></span></td>
			    <td class="acc_result_bg"><span class="BlackWord"><?=$rows["TG_Inball"]<0?"赛事无效":$rows["TG_Inball"]===null ?'':$rows["TG_Inball"]?></span></td>
			    
			 </tr>
		<?php
			}while($rows = $stmt->fetch());
		}
		?>
			<tr><td style="height:100px;"></td><tr>
          </table>
          
      </div>

	 <div name="fank_calander_element" class="cal_div" style="position: absolute; top: 87px; left: 387px; display: none;"></div>
</div>
</body> 
</html>
