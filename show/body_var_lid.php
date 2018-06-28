<?php
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
$bool = false;

$gtype = $_REQUEST['gtype'];
$wtype = $_REQUEST['w_type'];

$where = "";
$date = date('m-d');
$gq_array = array();
switch ($wtype) {
	case 'FT':
		$table = 'bet_match';
		switch ($gtype){
			case 'r':
				$where = 'Match_Type=1 AND Match_CoverDate>now() AND Match_Date=\''.$date.'\' and Match_HalfId is not null';
				break;
			case 're':
				include '../cache/zqgq.php';
				if (isset($zqgq) && !empty($zqgq)){
					$zqcount = count($zqgq);
					for ($i = 0;$i < $zqcount;$i++){
						$gq_array[] = $zqgq[$i]['Match_Name'];
					}
				}
				break;
			case 'bd':
				$where = 'match_date=\''.$date.'\' and Match_Type=1 and Match_IsShowbd=1 and Match_CoverDate>now() and Match_Bd21>0';
				break;
			case 'hbd':
				$where = 'match_date=\''.$date.'\' and Match_CoverDate>now() and Match_Hr_Bd10>0';
				break;
			case 'rqs':
				$where = 'match_date=\''.$date.'\' and Match_Type=1 and Match_IsShowt=1 and Match_Total01Pl>0 AND Match_CoverDate>now()';
				break;
			case 'bqc':
				$where = 'match_date=\''.$date.'\' and Match_CoverDate>now() and Match_BqMM>0';
				break;

		}
		break;
	case 'FU':
		$table = 'bet_match';
		$where .= 'Match_Type=0 AND Match_CoverDate>now() AND Match_Date>\''.$date.'\' and Match_HalfId is not null';
		break;
	case 'BK':
		$table = 'lq_match';

		switch ($gtype){
			case 'r':
				$where = 'Match_CoverDate>now() AND Match_Date=\''.$date.'\'';
				break;
			case 're':
				include '../cache/lqgq.php';
				if (isset($lqgq) && !empty($lqgq)){
					$lqcount = count($lqgq);
					for ($i = 0;$i < $lqcount;$i++){
						$gq_array[] = $lqgq[$i]['Match_Name'];
					}
				}
				break;
		}
		break;
	case 'BU':
		$table = 'lq_match';
		$where = 'Match_CoverDate>now() AND Match_Date>\''.$date.'\'';
		break;
	case 'TN':
		$table = 'tennis_match';
		$where = 'Match_CoverDate>now() AND Match_Date=\''.$date.'\'';
		break;
	case 'BM':
		$table = 'badminton_match';
		$where = 'Match_CoverDate>now() AND Match_Date=\''.$date.'\'';
		break;
	case 'TU':
		$table = 'tennis_match';
		$where = 'Match_CoverDate>now() AND Match_Date>\''.$date.'\'';
		break;
	case 'VB':
		$table = 'volleyball_match';
		$where = 'Match_CoverDate>now() AND Match_Date=\''.$date.'\'';
		
		break;
	case 'VU':
		$table = 'volleyball_match';
		$where = 'Match_CoverDate>now() AND Match_Date>\''.$date.'\'';
		break;
	case 'BS':
		$table = 'baseball_match';
		$where = 'Match_CoverDate>now() AND Match_Date=\''.$date.'\'';
		
		break;
	case 'BSU':
		$table = 'baseball_match';
		$where = 'Match_CoverDate>now() AND Match_Date>\''.$date.'\'';
		break;
	case 'OP':
		$table = 'other_match';
		$where = 'Match_CoverDate>now() AND Match_Date=\''.$date.'\'';
		break;
	case 'SK':
		$table = 'snooker_match';
		$where = 'Match_CoverDate>now() AND Match_Date=\''.$date.'\'';
		break;
}

if($gtype=='re'){
	if (isset($gq_array) && !empty($gq_array)){
		$gq_array = array_values(array_unique($gq_array));
		foreach ($gq_array as $t){
			$lsm .= $t.'_'.$t . '|';
		}
	}
	
}else{
	$sql = 'select match_name,Match_ID from mydata4_db.'.$table.' where '.$where.' group by match_name';
	$stmt = $mydata1_db->query($sql);
	while ($rows = $stmt->fetch()){
		$lsm .= $rows['Match_ID'].'_'.$rows['match_name'] . '|';
	}
}

$lsm = rtrim($lsm, '|');
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>选择联盟</title>
	<link href="/sprots_images/bet_maincortol.css" rel="stylesheet" type="text/css">
	<link href="/sprots_images/reset.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="../js/jquery.js"></script>
</head>
<script>
var time = 91;
function onLoad(){
	fixlidWindow();
	var language = rtrim(parent.document.getElementById('league').value);
	var all = 'ok';
	if(language!=""){
		var checkboxs=document.getElementsByName("liangsai");
		
		for(var i=0;i<checkboxs.length;i++) { 
			if(language.indexOf(checkboxs[i].value)>=0){
			  checkboxs[i].checked = true;
			}else{
			  checkboxs[i].checked = false;
			  all = 'no';
			}
		}

		
	}

	if(all == 'no'){
		document.getElementsByName("sall")[0].checked = false;
	}else{
		document.getElementsByName("sall")[0].checked = true;
	}

	var h = document.body.clientHeight;
	parent.show_legview("",h);
}

$(document).ready(function(){
	Refresh(); //自动刷新
});

function Refresh(){
	time=time-1;
	if(time<1){
		reload_lid();
	}else{
		$("#retime").html(time);
	}
	setTimeout("Refresh()",1000);
}

function rtrim(s) {
	var lastIndex = s.lastIndexOf(',');
    if (lastIndex > -1) {
        s = s.substring(0, lastIndex);
    }
    return s;　　
}

function Ok(){ 
	var lsm='';
	var checkboxs=document.getElementsByName("liangsai");
	for(var i=0;i<checkboxs.length;i++) { 
	  if(checkboxs[i].checked){ 
		  lsm += checkboxs[i].value+",";
	  } 
	} 
	

	parent.document.getElementById("league").value  =  lsm;
	parent.loaded(lsm,0);
	parent.LegBack();
} 

function fixlidWindow(){
	var legView = parent.document.getElementById('legView');
 	var scrollTop = parent.document.documentElement.scrollTop || parent.document.body.scrollTop || 0;
	legView.style.top=scrollTop+"px";
	legView.style.display = "";
	$(".bet_select_bg").css("height",parent.document.body.offsetHeight<document.body.clientHeight?document.body.clientHeight:parent.document.body.offsetHeight);
	parent.document.body.style.overflow = "hidden";
}

function fx(){ //反选 
  var all = 'yes';
  var checkboxs=document.getElementsByName("liangsai");
  for(var i=0;i<checkboxs.length;i++) { 
	  checkboxs[i].checked = !checkboxs[i].checked;
	  if(!checkboxs[i].checked){
	  	all = 'no';
	  }
  } 

  if(all == 'no'){
		document.getElementsByName("sall")[0].checked = false;
	}else{
		document.getElementsByName("sall")[0].checked = true;
	}
} 

function selall(){//全选
	var chk = document.getElementById('sall');
	var checkboxs=document.getElementsByName("liangsai");
	if(chk.checked){
	    for(i=0;i<checkboxs.length;i++){
            checkboxs[i].checked=true;
        };
	}else{
	    for(i=0;i<checkboxs.length;i++){
            checkboxs[i].checked=false;
        };
	}
}

function sel(){
	var all = 'yes';
	var checkboxs=document.getElementsByName("liangsai");
  	for(var i=0;i<checkboxs.length;i++) { 
		if(!checkboxs[i].checked){
			all = 'no';
		}
  	} 

  	if(all == 'no'){
		document.getElementsByName("sall")[0].checked = false;
	}else{
		document.getElementsByName("sall")[0].checked = true;
	}
}

function reload_lid(){
	location.reload();
}


function back(){
	parent.LegBack();
}

</script>
<body  id="LEG" onLoad="onLoad();" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false" >
<div class="bet_select_bg">
	<!--right buttons-->
    <div class="bet_right_btn" id="bet_right">
        <ul class="bet_right_ul">
           <li class="bet_right_refresh" onClick="reload_lid();">刷新</li>
           <li class="bet_right_top" onClick="fx();">反选</li>
           <li class="bet_right_close" onClick="back();">关闭</li>
           
       </ul>
    </div>
    <!--right buttons-->
	<div class="bet_select_content" >
		<div class="bet_select_content1">
			<table class="bet_select_table" cellpadding="0" cellspacing="0" border="0">
	         
	            <tr class="bet_select_title">
	               <td colspan="6">
	                       <div class="bet_select_left">选择联赛</div>
	                       
	                       <div class="bet_select_right">
	                       		<label><input type="checkbox"  class="bet_selsect_box" checked="checked" value="all" id="sall"  name="sall" onClick="selall();"><span></span>  全选</label>
	                       	  
	                          <span class="bet_select_time_btn" onClick="reload_lid();"><tt id="retime"></tt></span>
	                          <span class="bet_select_close" onClick="back();"></span>
	                       </div>
	                       
	               </td>
	            </tr>
	          	<? if($lsm == ""){?>
		            <tr>
						<td colspan="6" class="bet_no_game_lid">您选择的项目暂时没有联盟。</td>
		            </tr>
	            <? 
	        	}else{
	        		$lsms = explode('|',$lsm);
	        		for($i=0;$i<sizeof($lsms);$i++){
	        			$match = explode('_',$lsms[$i]);
	        			
	        			if($i%3==0){
	        				echo '<tr class="bet_select_all">';
	        			}
	            ?>
		   			
					<td class="bet_box_w" >
						<label>
							<input type="checkbox" name="liangsai" id="LEG<?=$match[0]?>" checked="checked" onClick="sel();"  class="bet_selsect_box" value="<?=$match[0]?>" >
							<span></span>
						</label>
					</td>
		          	<td class="bet_team_w"><span class="bet_select_team"><?=$match[1]?></span></td>
	            <?
	            		if(sizeof($lsms)<=3){
            				if(sizeof($lsms)==1){
            					echo "<td></td><td></td></tr>";
            				}elseif(sizeof($lsms)==2){
            					if($i==1){
	            					echo "<td></td></tr>";
	            				}
            				}else{
            					if($i==2){
	            					echo "</tr>";
	            				}
            				}
            			}else{
		            		if($i%3==2){
		            			echo '</tr>';
		        			}else{
		        				if(sizeof($lsms)-$i ==0){
		        					echo '</tr>';
		        				}
		        			}
		        		}
	            	} 
	        	}
	        	?>
	        	<tr class="bet_select_all">
	               <td colspan="6">
	                  <div class="bet_select_center"><span class="bet_select_submit" onClick="Ok();">送出</span></div>
	               </td>
	            </tr>
	        </table>
        </div>

	</div>

</div>

</body>
</html>

