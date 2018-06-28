<?php
require_once dirname(__FILE__) . '/conjunction.php';
require_once dirname(__FILE__) . '/config.php';
if(!empty($_GET['act']) && $_GET['act']=='info'){
	$res = $mydata2_db->query('select nn as kithe from ka_kithe order by nn desc limit 1')->fetch(PDO::FETCH_ASSOC);
	$kithe = $res['kithe'];

	$sql = 'select sum(sum_m) as sum from ka_tan where kithe=' . $kithe . ' limit 1';
    $res = $mydata2_db->query($sql)->fetch(PDO::FETCH_ASSOC);
    $data['sum'] = sprintf('%.2f',$res['sum']);

    $sql = 'select content from webinfo where code="marksix-sum" limit 1';
    $res = $mydata1_db->query($sql)->fetch(PDO::FETCH_ASSOC);
    $data['val'] = sprintf('%.2f',$res['content']);
	die(json_encode($data));
}

if(!empty($_GET['act']) && $_GET['act']=='save'){
	$money = $_GET['money'];
	$money = sprintf('%.2f',$money);
	$sql = 'select content from webinfo where code="marksix-sum" limit 1';
    $res = $mydata1_db->query($sql)->fetch(PDO::FETCH_ASSOC);
    if($res){
    	$sql = 'update webinfo set content="'.$money.'" where  code="marksix-sum"';
    	$mydata1_db->exec($sql);
    }else{
    	$sql = 'insert webinfo(code,content) values("marksix-sum","'.$money.'")';
    	$mydata1_db->exec($sql);
    }
    die();
}

$six_action = array('kithe', 'logout', 'top', 'kakithe', 'kithe_add', 'kithe_edit', 'kaguan', 'kazong', 'kadan', 'kamem', 'kazi', 'editadmin', 'modify_pass', 'tj', 'right', 'sm', 'guan_add', 'guan_edit', 'zong_add', 'zong_edit', 'mem_add', 'mem_edit', 'rake_tm', 'server', 'rake_update', 'rake_update2', 'rake_zm', 'rake_ztm', 'rake_zm6', 'rake_gg', 'rake_lm', 'rake_wbz', 'rake_sx', 'rake_wx', 'rake_bb', 'rake_ws', 'look', 'pz_tm', 'server_tm', 'pz_zm', 'server_zm', 'pz_zt', 'server_zt', 'pz_zm6', 'server_zm6', 'pz_sx', 'pz_sx1', 'server_sx', 'pz_dd', 'server_dd', 'pz_lm', 'server_lm', 'pz_lmg', 'server_lmg', 'pz_bb', 'server_bb', 'pz_ws', 'server_ws', 'pz_gg', 'server_gg', 'x1', 'x2', 'x3', 'x4', 'x5', 're_pb', 're_all', 're_guan', 're_zong', 're_dai', 're_mem', 'ka_del', 'ka_xxx', 'kawin', 'xt_abcd', 'xt_stds', 'xt_ds', 'xt_kk', 'xt_copy', 'xt_bak', 'pz_wx', 'server_wx', 'xt_nn', 'tm', 'kaaout', 'kaaout1', 'rake_mm', 'rake_hy', 'rake_mzm', 'rake_mzt', 'rake_mgg', 'rake_mlm', 'rake_mwbz', 'rake_mbb', 'rake_msx', 'rake_mws', 'rake_mwx', 'xx5', 'ykithe', 'edit', 'xx1', 'xxx5', 'pz_all', 'server_all', 'dy', 'e1', 'look1', 'tm2', 'rake_bbb', 'pz_bbb', 'rake_mbbb', 'rake_ts', 'pz_ts', 'rake_mts', 'pz_ztws', 'rake_ztws', 'rake_mztws', 'server_ztws', 'pz_qsb', 'rake_qsb', 'rake_mqsb', 'server_qsb', 'pz_zhx', 'rake_zhx', 'rake_zxsb', 'rake_mzhx', 'server_zhx', 'rake_sxx', 'rake_mzm6', 'rake_zx', 'rake_lx', 'pz_wbz', 'server_wbz', 'pz_lx', 'pz_lxg', 'pz_wsl', 'backup', 'server_bbb', 'server_ts', 'server_lx', 'server_lxg', 'server_zx', 'server2', 'rake_sxt', 'rake_wsl', 'rake_msxt', 'rake_mwsl', 'mmtop', 'l', 'list', 'chongsuan', 'maxsum');

if (in_array($action, $six_action)){
    require_once $action .'.php';
    exit();
}
?> 
<html>
<head>
  <title>后台登陆</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
  <link rel="stylesheet" href="images/xp.css" type="text/css">
  <style type="text/css">
	  body {
		  margin: 0px;
		  background-color: #FFFFFF;
	  }
	  .dndn {
		  BORDER-RIGHT: #d6d3ce 0px outset;BORDER-TOP: #d6d3ce 0px outset;FONT-SIZE: 9pt;BACKGROUND: #d6d3ce;BORDER-LEFT: #d6d3ce 0px outset;BORDER-BOTTOM: #d6d3ce 0px outset
	  }
	  body,td,th {
		  font-size: 12px;
		  color: #333333;
	  }
	  html{width: 100%;height: 100%;}
	  body{width: 100%;height: 100%;margin: 0;overflow:hidden;overflow-y: auto;*overflow:visible;*overflow-y:visible;_overflow:hidden;_overflow-y:auto;}
  </style>
</head>

<script>
  function show(i){
	  a1.style.display = "none";
	  a4.style.display = "none";
	  a5.style.display = "none";
	  a2.style.display = "none";
	  a3.style.display = "none";
	  i.style.display = "";
  }
  function re_re1(bb){
	  re1.style.color="494949"
	  re2.style.color="494949"
	  re3.style.color="494949"
	  re4.style.color="494949"
	  re5.style.color="494949"
	  re6.style.color="494949"
	  re7.style.color="494949"
	  re8.style.color="494949"
	  re9.style.color="494949"
	  re10.style.color="494949"
	  bb.style.color="ff0000"
  }
  function rm_rm1(bb){
	  rm1.style.color="494949"
	  rm2.style.color="494949"
	  rm3.style.color="494949"
	  rm4.style.color="494949"
	  rm5.style.color="494949"
	  rm6.style.color="494949"
	  rm7.style.color="494949"
	  bb.style.color="ff0000"
  }
  function rb_rb1(bb){
	  rb1.style.color="494949"
	  rb2.style.color="494949"
	  rb3.style.color="494949"
	  rb4.style.color="494949"
	  rb5.style.color="494949"
	  rb6.style.color="494949"
	  rb7.style.color="494949"
	  rb8.style.color="494949"
	  rb9.style.color="494949"
	  rb10.style.color="494949"
	  rb11.style.color="494949"
	  rb12.style.color="494949"
	  rb13.style.color="494949"
	  bb.style.color="ff0000"
  }
  function rl_rl1(bb){
	  rl1.style.color="494949"
	  rl2.style.color="494949"
	  rl3.style.color="494949"
	  rl4.style.color="494949"
	  rl5.style.color="494949"
	  rl6.style.color="494949"
	  rl7.style.color="494949"
	  rl8.style.color="494949"
	  bb.style.color="ff0000"
  }
  function rmn_rmn1(bb){
	  rmn1.style.color="494949"
	  rmn2.style.color="494949"
	  rmn3.style.color="494949"
	  bb.style.color="ff0000"
  }
  function MM_findObj(n, d) { //v4.01
	var p,i,x;if(!d) d=document;if((p=n.indexOf("?"))>0&&parent.frames.length) {
	  d=parent.frames[n.substring(p+1)].document;n=n.substring(0,p);}
	if(!(x=d[n])&&d.all) x=d.all[n];for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	if(!x && d.getElementById) x=d.getElementById(n);return x;
  }
  function MM_changeProp(objName,x,theProp,theValue) { //v6.0
	var obj = MM_findObj(objName);
	if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
	  if (theValue == true || theValue == false)
		eval("obj."+theProp+"="+theValue);
	  else eval("obj."+theProp+"='"+theValue+"'");
	}
  }
  function MM_validateForm() { //v4.0
	var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
	for (i=0;i<(args.length-2);i+=3) { test=args[i+2];val=MM_findObj(args[i]);
	  if (val) { nm=val.name;if ((val=val.value)!="") {
		if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
		  if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.';
		} else if (test!='R') { num = parseFloat(val);
		  if (isNaN(val)) errors+='- '+nm+' must contain a number.';
		  if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
			min=test.substring(8,p);max=test.substring(p+1);
			if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.';
	  } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.';}
	} if (errors) alert('The following error(s) occurred:'+errors);
	document.MM_returnValue = (errors == '');
  }
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" cellspacing="0" border="0" cellpadding="0" height="100%">
  <tr>
	  <td valign="top" height="74">
		  <iframe id="frmTop" style="Z-INDEX:1;VISIBILITY:inherit;WIDTH:100%;HEIGHT:74px" name="top" src="index.php?action=top" frameborder="0"></iframe>
	  </td>
  </tr>
  <tr>
	  <td valign="top">
		  <iframe id="frmRight" style="Z-INDEX:1;VISIBILITY:inherit;WIDTH:100%;HEIGHT: 100%" name="right" src="index.php?action=kithe" scrolling="yes" frameborder="0"></iframe>
	  </td>
  </tr>
</table>

<style>
	#edit{
		padding:5px;
	}
	#edit input {
		width: 100%;
		height:40px;
		line-height: 40px;
		font-size: 30px;
		text-align: right;
		padding:0 5px;
	}
	#edit .line{
		position: relative;
		padding-left:140px;
		height: 40px;
		line-height: 30px;
		margin-bottom: 5px;
	}
	#edit .line span {
		position: absolute;
		line-height: 40px;
		font-size: 30px;
		width: 145px;
		font-weight: bold;
		display: block;
	    left: 0;
	    top: 0;

	}
</style>
<div id="edit" style="display:none;">
	<div class="line"><span>本期总额:</span><input id="sum" disabled></div>
	<div class="line"><span>本期限额:</span><input id="money"></div>
</div>
<script src='https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js'></script>
<script src="https://cdn.jsdelivr.net/gh/sentsin/layer@3.1.1/dist/layer.js"></script>
<script type="text/javascript">
var change = function(){
	$('#sum').val('加载中...')
	$('#money').val('加载中...')
	layer.open({
		type: 1,
		title: "注单总额度限制",
		shadeClose: true,
		content: $('#edit'),
		btn: ['确认修改', '取消'],
		yes: function (index, layero){
			$.get('?act=save&money='+$('#money').val(),function(res){
				if(res == '1'){
					alert('修改失败');
				}else{
					alert('修改成功');
					layer.close(index)
				}
			});
		}
	});
	$.getJSON('?act=info', function(json){
		lock = false;
		$('#sum').val(json.sum)
		$('#money').val(json.val)
		if(parseFloat(json.sum) > parseFloat(json.val)){
			$('#sum').attr('style','color:red')
		}else{
			$('#sum').attr('style','')
		}
	});
}
</script>
</body>
</html>