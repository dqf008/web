<?php
$main=1;
$sub=1;
$cururl=$_SERVER['PHP_SELF'];
$cururl=str_ireplace("/member/","",$cururl);

switch($cururl){
	case "userinfo.php":
	case "password.php":
	case "sys_msg.php":
	case "sys_msg_del.php":
	case "sys_msg_show.php":
		$main=1;
		break;
	case "set_card.php";
	case "set_money.php":
	case "hk_money.php":
	case "get_money.php":
	case "data_money.php":
	case "data_h_money.php":
	case "data_t_money.php":
	case "data_o_money.php":
	case "zr_money.php":
	case "zr_data_money.php":
		$main=2;
		break;
	case "record_ty.php":
	case "record_ss.php":
	case "record_js.php":
	case "record_pt.php":
	case "record_lh.php":
	case "record_zr.php":
	case "record_sb.php":
	case "record_by.php":
	case "record_dz.php":
		$main=3;
		break;
	case "report.php":
		$main=4;
		break;
	case "agent_reg.php":
	case "agent.php":
	case "agent_user.php":
	case "agent_user_money.php":
	case "agent_user_t_money.php":
	case "agent_user_o_money.php":
	case "agent_user_h_money.php":
	case "agent_report.php":
	case "agent_user_record_ty.php":
	case "agent_user_record_ss.php":
	case "agent_user_record_pt.php":
	case "agent_user_record_lh.php":
	case "agent_user_record_zr.php":
		$main=5;
		break;
	default:
		$main=1;
		$sub=1;
		break;
}

if(strstr($cururl,"/pay/")){
	$main=2;
	$sub=1;
}

switch($cururl){
	case "userinfo.php":
	case "set_money.php":
	case "hk_money.php":
	case "record_ty.php":
	case "report.php":
	case "agent_reg.php":
	case "agent.php":
		$sub=1;
		break;
	case "password.php":
	case "get_money.php":
	case "record_js.php":
	case "record_ss.php":
	case "agent_user.php":
		$sub=2;
		break;
	case "sys_msg.php":
	case "sys_msg_del.php":
	case "sys_msg_show.php":
	case "data_money.php":
	case "data_h_money.php":
	case "data_t_money.php":
	case "data_o_money.php":
	case "record_pt.php":
	case "agent_report.php":
		$sub=3;
		break;
	case "zr_money.php":
	case "record_lh.php":
	case "agent_user_money.php":
	case "agent_user_t_money.php":
	case "agent_user_o_money.php":
	case "agent_user_h_money.php":
		$sub=4;
		break;
	case "zr_data_money.php":
	case "record_zr.php":
	case "agent_user_record_ty.php":
	case "agent_user_record_ss.php":
	case "agent_user_record_pt.php":
	case "agent_user_record_lh.php":
	case "agent_user_record_zr.php":
		$sub=5;
		break;
	case "record_sb.php":
		$sub=6;
		break;
	case "record_by.php":
		$sub=7;
		break;
	case "record_dz.php":
		$sub=8;
		break;
	default:
		$sub=1;
		break;
}

switch($cururl){
	case "agent_user_money.php":
	case "data_money.php":
	case "agent_user_record_ty.php":
		$subsub=1;
		break;
	case "agent_user_h_money.php":
	case "data_h_money.php":
	case "agent_user_record_ss.php":
		$subsub=2;
		break;
	case "agent_user_t_money.php":
	case "data_t_money.php":
	case "agent_user_record_pt.php":
		$subsub=3;
		break;
	case "agent_user_o_money.php":
	case "data_o_money.php":
	case "agent_user_record_lh.php":
		$subsub=4;
		break;
	case "agent_user_record_zr.php":
		$subsub=5;
		break;
	default:
		$subsub=1;
		break;
}

$full_url=isset($main_url)?"/member/":"";
$is_daili=$_SESSION["is_daili"];
?>
<tr>
	<td width="360" height="61" rowspan="2" style="color:#ffffff;">
		&nbsp;&nbsp;美东时间：<span id="EST_reciprocal"></span> 
		  <script> 
            var timestamp = <?php echo time()-(12*60*60); ?>*1000;
            var localtime = new Date().getTime();
            var setUSATime = function(){
                var dateObject = new Date((new Date().getTime())-(localtime-timestamp));
                //比对时间差防止部分浏览器出现延迟
                var dataString = {
                    "Y":dateObject.getFullYear(),
                    "M":" 0"+(dateObject.getMonth()+1),
                    "D":" 0"+dateObject.getDate(),
                    "H":" 0"+dateObject.getHours(),
                    "i":" 0"+dateObject.getMinutes(),
                    "S":" 0"+dateObject.getSeconds()
                };
                document.getElementById('EST_reciprocal').innerHTML = dataString["Y"]+"-"+
                    dataString["M"].substr(dataString["M"].length-2, 2)+"-"+
                    dataString["D"].substr(dataString["D"].length-2, 2)+" "+
                    dataString["H"].substr(dataString["H"].length-2, 2)+":"+
                    dataString["i"].substr(dataString["i"].length-2, 2)+":"+
                    dataString["S"].substr(dataString["S"].length-2, 2);
                setTimeout("setUSATime()", 1000);
            };
            setUSATime();
		  </script> 
	</td>
	<td width="600" height="29" valign="middle"><a href="javascript:void(0);" onclick="reflash()" class="clase pngFix"></a></td>
</tr>
<tr>
	<td height="32">
		<div class="menu">
			<ul>
				<li <?=$main==1?"class='current'":""?>><a href="javascript:void(0);" onclick="Go('<?=$full_url?>userinfo.php');return false">我的账户</a></li>
				<li <?=$main==2?"class='current'":""?>><a href="javascript:void(0);" onclick="Go('<?=$full_url?>set_money.php');return false">财务中心</a></li>
				<li <?=$main==3?"class='current'":""?>><a href="javascript:void(0);" onclick="Go('<?=$full_url?>record_ty.php');return false">下注记录</a></li>
				<li <?=$main==4?"class='current'":""?>><a href="javascript:void(0);" onclick="Go('<?=$full_url?>report.php');return false">历史报表</a></li>
				<?php if($is_daili==1){ ?>
				<li <?=$main==5?"class='current'":""?>><a href="javascript:void(0);" onclick="Go('<?=$full_url?>agent.php');return false">代理中心</a></li>
				<?php }else{ ?>
				<li <?=$main==5?"class='current'":""?>><a href="javascript:void(0);" onclick="Go('<?=$full_url?>agent_reg.php');return false">申请代理</a></li>
				<?php } ?>
			</ul>
		</div>
	</td>
</tr>
