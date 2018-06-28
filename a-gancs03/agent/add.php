<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('dlgl');
$agent_id = isset($_GET['id'])?intval($_GET['id']):(isset($_POST['id'])?intval($_POST['id']):0);
$is_add = $agent_id>0?(isset($_GET['add'])&&$_GET['add']=='true')||(isset($_POST['add'])&&$_POST['add']=='true'):true;

$stmt = $mydata1_db->query('SELECT * FROM `agent_config` WHERE `uid`=0 ORDER BY `id` ASC');
$agent_groups = [0 => []];
$groups_rows = [];
while($rows = $stmt->fetch()){
	!isset($agent_groups[$rows['tid']])&&$agent_groups[$rows['tid']] = [];
	if($rows['tid']==0){
		$agent_groups[0][] = $rows['id'];
	}else{
		$agent_groups[$rows['tid']][$rows['id']] = $rows['default'];
	}
	$groups_rows[$rows['id']] = $rows;
}
$agent_top1 = $agent_id==0||(!$is_add&&$groups_rows[$agent_id]['tid']==0);

if(isset($_POST['action'])&&$_POST['action']=='save'){
	$agent_data = ['ck_v1' => 0, 'ck_v1r' => 0, 'qk_v1' => 0, 'qk_v1r' => 0, 'ty_v1' => 0, 'ty_v1r' => 0, 'ty_v2' => 0, 'ty_v2r' => 0, 'lhc_v1' => 0, 'lhc_v1r' => 0, 'lhc_v2' => 0, 'lhc_v2r' => 0, 'jsc_v1' => 0, 'jsc_v1r' => 0, 'jsc_v2' => 0, 'jsc_v2r' => 0, 'ssc_v1' => 0, 'ssc_v1r' => 0, 'ssc_v2' => 0, 'ssc_v2r' => 0, 'ptc_v1' => 0, 'ptc_v1r' => 0, 'ptc_v2' => 0, 'ptc_v2r' => 0, 'zr_v1' => 0, 'zr_v1r' => 0, 'zr_v2' => 0, 'zr_v2r' => 0, 'hl_v1' => 0, 'hl_v1r' => 0, 'sxf_v1' => 0, 'sxf_v1r' => 0];
	if($agent_top1){
		$agent_data['add_dl'] = 0;
//		$agent_data['yx_v1'] = 0;
	}else{
		$agent_data['zdy_zshy'] = 0;
	}
	foreach($agent_data as $key=>$val){
		if(isset($_POST[$key])&&is_numeric($_POST[$key])){
			$agent_data[$key] = floatval($_POST[$key]);
		}
	}
	$params = [
		':name' => isset($_POST['name'])?strip_tags($_POST['name']):'',
		':value' => serialize($agent_data),
	];
	if($params[':name']==''){
		message('代理组名称不能为空！');
	}else{
		if($is_add){
			$params[':tid'] = $agent_id;
			$params[':default'] = $agent_id>0?count($agent_groups[$agent_id])+1:0;
			$sql = 'INSERT INTO `agent_config` (`uid`, `tid`, `username`, `default`, `value`) VALUES (0, :tid, :name, :default, :value)';
			admin::insert_log($_SESSION['adminid'], '添加了代理组['.$params[':name'].']');
		}else{
			$params[':id'] = $agent_id;
			$sql = 'UPDATE `agent_config` SET `username`=:name, `value`=:value WHERE `id`=:id';
			admin::insert_log($_SESSION['adminid'], '修改了代理组['.$params[':name'].']');
		}
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		message($is_add?'添加成功！':'修改成功');
	}
	exit;
}

$agent_data = [];
if(!$is_add){
	$agent_data = unserialize($groups_rows[$agent_id]['value']);
	is_array($agent_data)||$agent_data = [];
	// $agent_data['tid'] = $groups_rows[$agent_id]['tid'];
	$agent_data['name'] = $groups_rows[$agent_id]['username'];
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Welcome</title>
	<link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" />
	<style type="text/css">
		.menu_curr {color:#FF0;font-weight:bold} 
		.menu_com {color:#FFF;font-weight:bold} 
		.sub_curr {color:#f00;font-weight:bold} 
		.sub_com {color:#333;font-weight:bold} 
		.selected {background-color:#aee0f7} 
	</style>
	<script type="text/javascript" charset="utf-8" src="/js/jquery.js"></script>
	<script type="text/javascript" charset="utf-8" src="/js/calendar.js"></script>
	<script type="text/javascript">
		$(document.body).ready(function(){
			var zshy = $("#zshy").find("td"), tips1 = zshy.filter(":last-child").find("span:last-child");
			var xcdl = $("#xcdl").find("td"), tips2 = xcdl.filter(":last-child").find("span:last-child");
			var str, rate = ["", "%", "‰", "‱"];

			tips1.html("0");
			zshy.find("input, select").on("blur", function(){
				str = "";
				zshy.find("input").map(function(){
					var t = $(this), val = parseFloat(t.val());
					if(!isNaN(val)&&val!=0){
						if(t.parent().data("minus")){
							str+= "－";
						}else if(str!=""){
							str+= "＋";
						}
						str+= t.prevAll(":first-child").html();
						str+= t.prev("span").html();
						str+= val;
						str+= rate[t.next("select").val()];
					}
				});
				tips1.html(str==""?0:str);
			});
			tips2.html("0");
			xcdl.find("input, select").on("blur", function(){
				str = "";
				xcdl.find("input").map(function(){
					var t = $(this), val = parseFloat(t.val());
					if(!isNaN(val)&&val!=0){
						if(t.parent().data("minus")){
							str+= "－";
						}else if(str!=""){
							str+= "＋";
						}
						str+= t.prevAll(":first-child").html();
						str+= t.prev("span").html();
						str+= val;
						str+= rate[t.next("select").val()];
					}
				});
				tips2.html(str==""?0:str);
			});
<?php if(!$is_add&&!empty($agent_data)){ ?>			var data = <?php echo json_encode($agent_data); ?>;
			$.each(data, function(name, data){
				var t = $("[name='"+name+"']");
				switch((t.prop("tagName")&&t.prop("tagName").toLocaleLowerCase())){
					case "input":
					if(t.prop("type").toLocaleLowerCase()=="radio"){
						if(parseInt(data)==1){
							t.filter("[value='1']").prop("checked", true);
						}
					}else{
						t.val(data);
					}
					break;
					case "select":
					t.find("option[value='"+parseInt(data)+"']").prop("selected", true);
					break;
				}
				t.trigger("blur");
			});
<?php } ?>		});
	</script>
</head>
<body>
	<div id="pageMain">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td valign="top">
					<form action="add.php" method="POST">
						<input type="hidden" name="action" value="save" />
						<input type="hidden" name="add" value="<?php echo $is_add?'true':'false'; ?>" />
						<input type="hidden" name="id" value="<?php echo $agent_id; ?>" />
						<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
							<tr>
								<td align="center" bgcolor="#3C4D82" style="color:#FFF" colspan="2"><strong><?php echo $is_add?'添加':'编辑'; ?>代理组</strong></td>
							</tr>
							<tr>
								<td align="right" bgcolor="#F0FFFF" width="150">上层代理组：</td>
								<td align="left" bgcolor="#FFFFFF"><?php echo $agent_top1?'顶层代理组':$groups_rows[$is_add?$agent_id:$groups_rows[$agent_id]['tid']]['username']; ?></td>
							</tr>
							<tr>
								<td align="right" bgcolor="#F0FFFF">代理组名称：</td>
								<td align="left" bgcolor="#FFFFFF"><input name="name" type="text" value="" size="25" /></td>
							</tr>
<?php if($agent_top1){ ?>							<tr>
								<td align="right" bgcolor="#F0FFFF">邀请直属会员成为代理：</td>
								<td align="left" bgcolor="#FFFFFF"><input type="radio" name="add_dl" value="0" checked="true"/>禁止&nbsp;&nbsp;<input type="radio" name="add_dl" value="1" />允许</td>
							</tr>
							<tr style="display:none">
								<td align="right" bgcolor="#F0FFFF">有效直属会员：</td>
								<td align="left" bgcolor="#FFFFFF"><input type="text" class="textfield" size="8" name="yx_v1" value="0" /> 天 <span style="color:red">“有效直属会员”指设定天数内有进行有效存款的会员，0为不限制</span></td>
							</tr>
							<tr style="display:none">
								<td align="right" bgcolor="#F0FFFF">有效直属会员特别说明：</td>
								<td align="left" bgcolor="#FFFFFF" style="color:red">1.系统统计数据前将对直属会员进行判断，不属于有效直属会员的记录将被忽略（即不被统计并且不被保存到统计数据）；<br />2.修改后代理报表不能即时更新，需要等待系统重新生成报表数据（仅最近30天统计数据）</td>
							</tr>
<?php }else{ ?>							<tr>
								<td align="right" bgcolor="#F0FFFF">佣金计算公式：</td>
								<td align="left" bgcolor="#FFFFFF"><input type="radio" name="zdy_zshy" value="0" checked="true"/>继承上层&nbsp;&nbsp;<input type="radio" name="zdy_zshy" value="1" />自定义</td>
							</tr>
<?php } ?>							<tr>
								<td align="right" bgcolor="#F0FFFF">直属会员：</td>
								<td align="left" bgcolor="#FFFFFF">
									<table width="100%" border="0" cellpadding="0" cellspacing="0" id="zshy" class="font12">
										<tr>
											<td align="left">
												<span>会员有效存款</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="ck_v1" value="0" />
												<select name="ck_v1r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_01.gif"></td>
										</tr>
										<tr>
											<td align="left">
												<span>体育有效投注</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="ty_v1" value="0" />
												<select name="ty_v1r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_01.gif"></td>
										</tr>
										<tr>
											<td align="left">
												<span>体育盈亏</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="ty_v2" value="0" />
												<select name="ty_v2r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_01.gif"></td>
										</tr>
										<tr>
											<td align="left">
												<span>六合彩有效投注</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="lhc_v1" value="0" />
												<select name="lhc_v1r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_01.gif"></td>
										</tr>
										<tr>
											<td align="left">
												<span>六合彩盈亏</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="lhc_v2" value="0" />
												<select name="lhc_v2r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_01.gif"></td>
										</tr>
										<tr>
											<td align="left">
												<span>极速彩有效投注</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="jsc_v1" value="0" />
												<select name="jsc_v1r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_01.gif"></td>
										</tr>
										<tr>
											<td align="left">
												<span>极速彩盈亏</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="jsc_v2" value="0" />
												<select name="jsc_v2r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_01.gif"></td>
										</tr>
										<tr>
											<td align="left">
												<span>时时彩有效投注</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="ssc_v1" value="0" />
												<select name="ssc_v1r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_01.gif"></td>
										</tr>
										<tr>
											<td align="left">
												<span>时时彩盈亏</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="ssc_v2" value="0" />
												<select name="ssc_v2r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_01.gif"></td>
										</tr>
										<tr>
											<td align="left">
												<span>普通彩有效投注</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="ptc_v1" value="0" />
												<select name="ptc_v1r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_01.gif"></td>
										</tr>
										<tr>
											<td align="left">
												<span>普通彩盈亏</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="ptc_v2" value="0" />
												<select name="ptc_v2r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_01.gif"></td>
										</tr>
										<tr>
											<td align="left">
												<span>真人与电子有效投注</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="zr_v1" value="0" />
												<select name="zr_v1r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_01.gif"></td>
										</tr>
										<tr>
											<td align="left">
												<span>真人与电子盈亏</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="zr_v2" value="0" />
												<select name="zr_v2r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_02.gif"></td>
										</tr>
										<tr>
											<td align="left" data-minus="true">
												<span>红利派送</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="hl_v1" value="0" />
												<select name="hl_v1r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="left"><img src="../images/bvbv_02.gif"></td>
										</tr>
										<tr>
											<td align="left" data-minus="true">
												<span>手续费</span>
												<span>×</span>
												<input type="text" class="textfield" size="8" name="sxf_v1" value="0" />
												<select name="sxf_v1r">
													<option value="0">倍</option>
													<option value="1">% (百分比)</option>
													<option value="2">‰ (千分比)</option>
													<option value="3">‱ (万分比)</option>
												</select>
											</td>
										</tr>
                                        <tr>
                                            <td align="left"><img src="../images/bvbv_02.gif"></td>
                                        </tr>
                                        <tr>
                                            <td align="left" data-minus="true">
                                                <span>会员提款</span>
                                                <span>×</span>
                                                <input type="text" class="textfield" size="8" name="qk_v1" value="0" />
                                                <select name="qk_v1r">
                                                    <option value="0">倍</option>
                                                    <option value="1">% (百分比)</option>
                                                    <option value="2">‰ (千分比)</option>
                                                    <option value="3">‱ (万分比)</option>
                                                </select>
                                            </td>
                                        </tr>
										<tr>
											<td align="left" height="25">
												<span>直属会员公式：代理佣金</span>
												<span>=</span>
												<span>0</span>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td align="right" bgcolor="#FFFFFF">温馨提示：</td>
								<td align="left" bgcolor="#FFFFFF" style="color:red">“下层代理”存款、游戏记录将计算在“直属会员”中；<br />“有效存款”指在线充值、二维码存款、汇款等</td>
							</tr>
							<tr>
								<td align="right" bgcolor="#FFFFFF">&nbsp;</td>
								<td align="left" bgcolor="#FFFFFF"><input type="submit" class="submit80" value="保存" /></td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>