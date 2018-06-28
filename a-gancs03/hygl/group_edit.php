<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('hyzgl');
$id = '0';
if (isset($_GET['id'])){
	$id = intval($_GET['id']);
	$sql = 'select * from `k_group` where id=' . $id . ' limit 1';
	$query = $mydata1_db->query($sql);
	$rs = $query->fetch();
	if(file_exists('../../cache/group_'.$id.'.php')){
        include_once '../../cache/group_'.$id.'.php';
        $tk_num = $pk_db['提款次数'];
	}
}
?> 
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<title>用户组编辑页面</title> 
<style type="text/css"> 
body { 
  margin: 0px;
} 
td{font:13px/120% "宋体";padding:3px;} 
a{ 
  color:#F37605;
  text-decoration: none;
} 
.title td{
    font-weight:bold;
    text-align:left;
    background-color:#CCC;
}
.title2 td{
     font-weight:bold;
     text-align:center;
}
tr:hover{
    background-color:#EBEBEB;
}
</style> 
<script type="text/javascript"> 
  var v;
  var num;
  function check(obj){ 
	  if(obj.name.value==""){ 
		  alert("请您输入会员组名称..");
		  obj.name.focus();
		  return false;
	  } 
	  return true;
  } 

  function isnum(obj){ 
	  v = obj.value;
	  if(v == (parseInt(v)*1)){ 
		   num = v.indexOf(".");
		   if(num == -1) return true;
		   else{ 
			  alert("限额只能为正整数..");
			  obj.select();
              obj.value = 0;
			  return false;
		   } 
	  }else{ 
		  alert("限额只能为正整数..");
		  obj.focus();
		  obj.value = 0;
		  return false;
	  } 
  } 
</script> 
</head> 
<body> 
<form name="form1" method="post" action="group_save.php" onSubmit="return check(this);"> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap background="../images/06.gif">用户组权限管理：编辑用户组信息</td> 
</tr> 
<tr> 
  <td height="24" align="left" nowrap bgcolor="#FFFFFF">&nbsp;&nbsp;<a href="group.php">&lt;&lt;返回会员组</a></td> 
</tr> 
</table> 

<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
  
<tr> 
  <td height="24" valign="top" nowrap bgcolor="#FFFFFF"> 
   
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;"> 
		  <tr align="center"> 
			<td width="25%" align="right">用户组名称：</td> 
			<td colspan="3" align="left"><label> 
			  <input name="name" value="<?=$rs['name']?>" maxlength="20"> 
			</label></td> 
		</tr> 
		  <tr class="title"><td colspan="4">足球</td></tr> 
		  <tr class="title2"><td>类型</td><td>额度</td><td>类型</td><td>额度</td></tr>
		  <tr align="center"> 
			<td align="right">全场让球单注限额：</td> 
			<td align="left"><label> 
			  <input name="qc_rqdz" value="<?=$rs['qc_rqdz']?>" maxlength="10" onBlur="return isnum(this);" > 
			</label></td> 
			<td align="right">全场让球单场限额：</td> 
			<td align="left"><input name="qc_rqdc" value="<?=$rs['qc_rqdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">全场单双单注限额：</td> 
			<td align="left"><input name="qc_dsdz" value="<?=$rs['qc_dsdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">全场单双单场限额：</td> 
			<td align="left"><input name="qc_dsdc" value="<?=$rs['qc_dsdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">全场大小单注限额：</td> 
			<td align="left"><input name="qc_dxdz" value="<?=$rs['qc_dxdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">全场大小单场限额：</td> 
			<td align="left"><input name="qc_dxdc" value="<?=$rs['qc_dxdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">全场独赢单注限额：</td> 
			<td align="left"><input name="qc_dydz" value="<?=$rs['qc_dydz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">全场独赢单场限额：</td> 
			<td align="left"><input name="qc_dydc" value="<?=$rs['qc_dydc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">上半让球单注限额：</td> 
			<td align="left"><input name="sb_rqdz" value="<?=$rs['sb_rqdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">上半让球单场限额：</td> 
			<td align="left"><input name="sb_rqdc" value="<?=$rs['sb_rqdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">上半大小单注限额：</td> 
			<td align="left"><input name="sb_dxdz" value="<?=$rs['sb_dxdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">上半大小单场限额：</td> 
			<td align="left"><input name="sb_dxdc" value="<?=$rs['sb_dxdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">上半独赢单注限额：</td> 
			<td align="left"><input name="sb_dydz" value="<?=$rs['sb_dydz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">上半独赢单场限额：</td> 
			<td align="left"><input name="sb_dydc" value="<?=$rs['sb_dydc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">波胆单注限额：</td> 
			<td align="left"><input name="bd_dz" value="<?=$rs['bd_dz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">波胆单场限额：</td> 
			<td align="left"><input name="bd_dc" value="<?=$rs['bd_dc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">入球数单注限额：</td> 
			<td align="left"><input name="rqs_dz" value="<?=$rs['rqs_dz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">入球数单场限额：</td> 
			<td align="left"><input name="rqs_dc" value="<?=$rs['rqs_dc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">半全场单注限额：</td> 
			<td align="left"><input name="bqc_dz" value="<?=$rs['bqc_dz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">半全场单场限额：</td> 
			<td align="left"><input name="bqc_dc" value="<?=$rs['bqc_dc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">滚球全场让球单注限额：</td> 
			<td align="left"><input name="gq_qcrqdz" value="<?=$rs['gq_qcrqdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">滚球全场让球当场限额：</td> 
			<td align="left"><input name="gq_qcrqdt" value="<?=$rs['gq_qcrqdt']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">滚球全场大小单注限额：</td> 
			<td align="left"><input name="gq_qcdxdz" value="<?=$rs['gq_qcdxdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">滚球全场大小单场限额：</td> 
			<td align="left"><input name="gq_qcdxdc" value="<?=$rs['gq_qcdxdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">滚球上半让球单注限额：</td> 
			<td align="left"><input name="gq_sbrqdz" value="<?=$rs['gq_sbrqdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">滚球上半让球单场限额：</td> 
			<td align="left"><input name="gq_sbrqdc" value="<?=$rs['gq_sbrqdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">滚球上半大小单注限额：</td> 
			<td align="left"><input name="gq_sbdxdz" value="<?=$rs['gq_sbdxdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">滚球上半大小单场限额：</td> 
			<td align="left"><input name="gq_sbdxdc" value="<?=$rs['gq_sbdxdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">滚球全场独赢单注限额：</td> 
			<td align="left"><input name="gq_qcdydz" value="<?=$rs['gq_qcdydz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">滚球全场独赢单场限额：</td> 
			<td align="left"><input name="gq_qcdydc" value="<?=$rs['gq_qcdydc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">滚球上半独赢单注限额：</td> 
			<td align="left"><input name="gq_sbdydz" value="<?=$rs['gq_sbdydz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">滚球上半独赢单场限额：</td> 
			<td align="left"><input name="gq_sbdydc" value="<?=$rs['gq_sbdydc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr class="title"><td colspan="4">蓝球</td></tr> 
		  <tr class="title2"><td>类型</td><td>额度</td><td>类型</td><td>额度</td></tr>
		  <tr align="center"> 
			<td align="right">篮球单双单注限额：</td> 
			<td align="left"><input name="lq_dsdz" value="<?=$rs['lq_dsdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">篮球单双单场限额：</td> 
			<td align="left"><input name="lq_dsdc" value="<?=$rs['lq_dsdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">篮球让分单注限额：</td> 
			<td align="left"><input name="lq_rfdz" value="<?=$rs['lq_rfdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">篮球让分单场限额：</td> 
			<td align="left"><input name="lq_rfdc" value="<?=$rs['lq_rfdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">篮球大小单注限额：</td> 
			<td align="left"><input name="lq_dxdz" value="<?=$rs['lq_dxdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">篮球大小单场限额：</td> 
			<td align="left"><input name="lq_dxdc" value="<?=$rs['lq_dxdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">滚球让分单注限额：</td> 
			<td align="left"><input name="gq_rfdz" value="<?=$rs['gq_rfdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">滚球让分单场限额：</td> 
			<td align="left"><input name="gq_rfdc" value="<?=$rs['gq_rfdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">滚球大小单注限额：</td> 
			<td align="left"><input name="gq_dxdz" value="<?=$rs['gq_dxdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">滚球大小单场限额：</td> 
			<td align="left"><input name="gq_dxdc" value="<?=$rs['gq_dxdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
          <tr class="title"><td colspan="4">网球</td></tr> 
		  <tr class="title2"><td>类型</td><td>额度</td><td>类型</td><td>额度</td></tr> 
		  <tr align="center"> 
			<td align="right">网球独赢单注限额：</td> 
			<td align="left"><input name="wq_dydz" value="<?=$rs['wq_dydz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">网球独赢单场限额：</td> 
			<td align="left"><input name="wq_dydc" value="<?=$rs['wq_dydc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">网球让盘单注限额：</td> 
			<td align="left"><input name="wq_rbdz" value="<?=$rs['wq_rbdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">网球让盘单场限额：</td> 
			<td align="left"><input name="wq_rbdc" value="<?=$rs['wq_rbdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">网球单双单注限额：</td> 
			<td align="left"><input name="wq_dsdz" value="<?=$rs['wq_dsdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">网球单双单场限额：</td> 
			<td align="left"><input name="wq_dsdc" value="<?=$rs['wq_dsdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">网球大小单注限额：</td> 
			<td align="left"><input name="wq_dxdz" value="<?=$rs['wq_dxdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">网球大小单场限额：</td> 
			<td align="left"><input name="wq_dxdc" value="<?=$rs['wq_dxdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr class="title"><td colspan="4">排球</td></tr> 
		  <tr class="title2"><td>类型</td><td>额度</td><td>类型</td><td>额度</td></tr>
		  <tr align="center"> 
			<td align="right">排球独赢单注限额：</td> 
			<td align="left"><input name="pq_dydz" value="<?=$rs['pq_dydz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">排球独赢单场限额：</td> 
			<td align="left"><input name="pq_dydc" value="<?=$rs['pq_dydc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">排球让盘单注限额：</td> 
			<td align="left"><input name="pq_rpdz" value="<?=$rs['pq_rpdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">排球让盘单场限额：</td> 
			<td align="left"><input name="pq_rpdc" value="<?=$rs['pq_rpdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
		  </tr> 
		  <tr align="center"> 
			<td align="right">排球大小单注限额：</td> 
			<td align="left"><input name="pq_dxdz" value="<?=$rs['pq_dxdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">排球大小单场限额：</td> 
			<td align="left"><input name="pq_dxdc" value="<?=$rs['pq_dxdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">排球单双单注限额：</td> 
			<td align="left"><input name="pq_dsdz" value="<?=$rs['pq_dsdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">排球单双单场限额：</td> 
			<td align="left"><input name="pq_dsdc" value="<?=$rs['pq_dsdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr class="title"><td colspan="4">棒球</td></tr> 
		  <tr class="title2"><td>类型</td><td>额度</td><td>类型</td><td>额度</td></tr>
		  <tr align="center"> 
			<td align="right">棒球让分单注限额：</td> 
			<td align="left"><input name="bp_rfdz" value="<?=$rs['bp_rfdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">棒球让分单场限额：</td> 
			<td align="left"><input name="bp_rfdc" value="<?=$rs['bp_rfdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">棒球大小单注限额：</td> 
			<td align="left"><input name="bp_dxdz" value="<?=$rs['bp_dxdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">棒球大小单场限额：</td> 
			<td align="left"><input name="bp_dxdc" value="<?=$rs['bp_dxdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr align="center"> 
			<td align="right">棒球单双单注限额：</td> 
			<td align="left"><input name="bp_dsdz" value="<?=$rs['bp_dsdz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">棒球单双单场限额：</td> 
			<td align="left"><input name="bp_dsdc" value="<?=$rs['bp_dsdc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr class="title"><td colspan="4">冠军</td></tr> 
		  <tr class="title2"><td>类型</td><td>额度</td><td>类型</td><td>额度</td></tr>
		  <tr align="center"> 
			<td align="right">冠军单注限额：</td> 
			<td align="left"><input name="gj_dz" value="<?=$rs['gj_dz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">冠军单场限额：</td> 
			<td align="left"><input name="gj_dc" value="<?=$rs['gj_dc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr class="title"><td colspan="4">金融</td></tr> 
		  <tr class="title2"><td>类型</td><td>额度</td><td>类型</td><td>额度</td></tr>
		  <tr align="center"> 
			<td align="right">金融单注限额：</td> 
			<td align="left"><input name="jr_dz" value="<?=$rs['jr_dz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">金融单场限额：</td> 
			<td align="left"><input name="jr_dc" value="<?=$rs['jr_dc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr class="title"><td colspan="4">串关</td></tr> 
		  <tr class="title2"><td>类型</td><td>额度</td><td>类型</td><td>额度</td></tr>
		  <tr align="center"> 
			<td align="right">串关单注限额：</td> 
			<td align="left"><input name="gg_dz" value="<?=$rs['gg_dz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">串关单天限额：</td> 
			<td align="left"><input name="gg_dc" value="<?=$rs['gg_dc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
		  <tr class="title"><td colspan="4">未定义</td></tr> 
		  <tr class="title2"><td>类型</td><td>额度</td><td>类型</td><td>额度</td></tr>
		  <tr align="center"> 
			<td align="right">未定义单注限额：</td> 
			<td align="left"><input name="wdy_dz" value="<?=$rs['wdy_dz']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
			<td align="right">未定义单场限额：</td> 
			<td align="left"><input name="wdy_dc" value="<?=$rs['wdy_dc']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
	  <tr align="center"> 
		  <td align="right">体育最低下注：</td> 
		  <td align="left"><input name="ty_zd" value="<?=$rs['ty_zd']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
		  <td align="right"></td> 
		  <td align="left"></td> 
	  </tr> 
	  <tr class="title"><td colspan="4">彩票</td></tr> 
		  <tr class="title2"><td>类型</td><td>额度</td><td>类型</td><td>额度</td></tr>
	  <tr align="center"> 
		  <td align="right">彩票最低下注：</td> 
		  <td align="left"><input name="cp_zd" value="<?=$rs['cp_zd']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
		  <td align="right">彩票最高下注：</td> 
		  <td align="left"><input name="cp_zg" value="<?=$rs['cp_zg']?>" maxlength="10" onBlur="return isnum(this);" ></td> 
	  </tr> 
	  
	  <tr class="title"><td colspan="4">提款(美东时间)</td></tr> 
		  <tr class="title2"><td>类型</td><td>次数</td><td></td><td></td></tr>
	  <tr align="center"> 
		  <td align="right">当天提款：</td> 
		  <td align="left"><input name="tk_num" value="<?=$tk_num?>" maxlength="10" onBlur="return isnum(this);" ></td> 
		  <td align="right"></td> 
		  <td align="left"></td> 
	  </tr> 
	  
		  <tr align="center"> 
			<td colspan="4" align="left"><input name="hf_id" type="hidden" value="<?=$id?>">&nbsp;</td> 
	  </tr> 
		  <tr align="center"> 
			<td colspan="4" align="center"> 
			  <input name="tj" type="submit" value="提 交"> 
			&nbsp;&nbsp;&nbsp;&nbsp;　 
			<input type="button" name="cx" value="取 消" onClick="window.location.href='group.php'"> 
			</td> 
	  </tr>    	
  </table> 
  </td> 
</tr> 
</table> 
</form> 
</body> 
</html>