<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../cache/hlhy.php';
check_quanxian('bbgl');
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
$username = $_GET['username'];
$qiantian = date('Y-m-d', strtotime($bdate) - (24 * 3600));

$cz_ty1 = ['tyds','tycg'];//体育
if(isset($_GET['cz_ty']) && is_array($_GET['cz_ty'])){
	$cz_ty = array_intersect($cz_ty1, $_GET['cz_ty']);

}elseif(count($_GET)>0){
	$cz_ty = [];
}

$cz_pt1 = ['lhc', 'kl8', 'ssl', '3d', 'pl3']; //普通彩票
if(isset($_GET['cz_pt']) && is_array($_GET['cz_pt'])){
	$cz_pt = array_intersect($cz_pt1, $_GET['cz_pt']);
}elseif(count($_GET)>0){
	$cz_pt = [];
}

$cz_gp1 = ['cqssc', 'gdklsf', 'bjsc', 'xyft']; //高频彩
if(isset($_GET['cz_gp']) && is_array($_GET['cz_gp'])){
	$cz_gp = array_intersect($cz_gp1, $_GET['cz_gp']);
}elseif(count($_GET)>0){
	$cz_gp = [];
}

$cz_js1 = ['JSSC', 'JSSSC', 'JSLH']; //极速彩票
if(isset($_GET['cz_js']) && is_array($_GET['cz_js'])){
	$cz_js = array_intersect($cz_js1, $_GET['cz_js']);
}elseif(count($_GET)>0){
	$cz_js = [];
}

if(empty($cz_ty) && empty($cz_pt) && empty($cz_gp) && empty($cz_js)){
	$cz_ty = $cz_ty1; 
	$cz_pt = $cz_pt1;
	$cz_gp = $cz_gp1;
	$cz_js = $cz_js1;
}

$zrlist = [
	'AGIN'=>['name'=>'AG国际厅','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'AG'=>['name'=>'AG极速厅','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'BBIN'=>['name'=>'BB波音厅','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'OG'=>['name'=>'OG东方厅','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'MAYA'=>['name'=>'玛雅娱乐厅','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'MG'=>['name'=>'MG电子','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'HG'=>['name'=>'HG名人厅','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'PT'=>['name'=>'PT电子','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'SHABA'=>['name'=>'沙巴体育','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'IPM'=>['name'=>'IPM体育','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'MW'=>['name'=>'MW游戏','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'KG'=>['name'=>'AV女优','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'CQ9'=>['name'=>'CQ9电子','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'MG2'=>['name'=>'新MG电子','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0],
	'VR'=>['name'=>'VR彩票','sum_yl'=>0,'sum_in'=>0,'sum_out'=>0]
];
$ck_zr = $_GET['ck_zr'];
if(empty($ck_zr)){
	foreach($zrlist as $k=>$v) $ck_zr[] = $k;
}
if(!empty($_GET['act']) && $_GET['act'] == 'finance'){
	$params = array();
	$sqlwhere = '';
	$sqlwhere2 = '';
	if ($username != ''){
		$params[':username'] = $username;
		$sqlwhere .= ' and u.username=:username';
		$params[':username2'] = $username;
		$sqlwhere2 .= ' and u.username=:username2';
	}
	$sql = 'select tm.*,su.money as bef_money from (';
	$sql .= 'select username,money,sum(t1_value) as t1_value,sum(t2_value) as t2_value,sum(t3_value) as t3_value,sum(t4_value) as t4_value,sum(t5_value) as t5_value,sum(t6_value) as t6_value,sum(t1_sxf) as t1_sxf,sum(t2_sxf) as t2_sxf,sum(h_value) as h_value,sum(h_zsjr) as h_zsjr from (';
	$params[':q_btime2'] = $params[':q_btime'] = $btime;
	$params[':q_etime2'] = $params[':q_etime'] = $etime;
	$sql .= 'select u.username,u.money,sum(if(m.type=1,m.m_value,0)) as t1_value,sum(if(m.type=2,m.m_value,0)) as t2_value,sum(if(m.type=3,m.m_value,0)) as t3_value,sum(if(m.type=4,m.m_value,0)) as t4_value,sum(if(m.type=5,m.m_value,0)) as t5_value,sum(if(m.type=6,m.m_value,0)) as t6_value,sum(if(m.type=1,m.sxf,0)) as t1_sxf,sum(if(m.type=2,m.sxf,0)) as t2_sxf,0 as h_value, 0 as h_zsjr from k_money m left outer join k_user u on m.uid=u.uid where m.status=1 and m.m_make_time>=:q_btime and m.m_make_time<=:q_etime ' . $sqlwhere . ' group by u.username';
	$sql .= ' union all ';
	$sql .= 'select u.username,u.money,0 as t1_value,0 as t2_value,0 as t3_value,0 as t4_value,0 as t5_value,0 as t6_value,0 as t1_sxf,0 as t2_sxf,sum(ifnull(h.money,0)) as h_value,sum(ifnull(h.zsjr,0)) as h_zsjr from huikuan h left outer join k_user u on h.uid=u.uid where h.status=1 and h.adddate>=:q_btime2 and h.adddate<=:q_etime2 ' . $sqlwhere2 . ' group by u.username';
	$params[':qiantian'] = $qiantian . '%';
	$sql .= ')temp group by username';
	$sql .= ')tm left outer join mydata3_db.save_user su on tm.username=su.username and su.addtime like (:qiantian)';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$list = [];
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$list[] = $row;
	}
	die(json_encode($list));
}
?> 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title>报表明细</title> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-normalize@0.4.0/modern-normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/element-ui@2.2.0/lib/theme-chalk/index.min.css">
    <script language="JavaScript" src="/js/calendar.js"></script> 
    <style>
        body {
		    padding: 8px;
		    font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
		}
		×[v-cloak] {
		    display: none !important
		}
		.el-form-item--mini.el-form-item{
			margin-bottom: 5px;
		}
		.el-checkbox+.el-checkbox{
			margin-left: 5px;
		}
		.el-checkbox__label{
			padding-left: 1px;
		}
		.el-table div.cell{
			text-align: center;
		}
	</style>
</head> 
<body> 
<div id="app">
	<el-form :inline="true" size="mini" class="demo-form-inline">
		<el-form-item><el-input disabled value="美东时间" style="width: 80px;"></el-input></el-form-item>
		<el-form-item label="开始时间">
			<el-date-picker v-model="form.start" type="datetime" style="width:180px" :editable="false" :clearable="false" format="yyyy-MM-dd hh:mm:ss" placeholder="选择日期时间"></el-date-picker>
		</el-form-item>
		<el-form-item label="结束时间">
			<el-date-picker v-model="form.end" type="datetime" style="width:180px" :editable="false" :clearable="false" format="yyyy-MM-dd hh:mm:ss" placeholder="选择日期时间"></el-date-picker>
		</el-form-item><br>
		<el-form-item label="彩种">
			<el-checkbox style="margin-right:10px;" :indeterminate="lottery.isIndeterminate" v-model="lottery.checkAll" @change="lotteryCheckAllChange">全选</el-checkbox>
			<el-checkbox-group style="display:inline-table" v-model="lottery.checked" @change="lotteryCheckedChange">
				<el-checkbox v-for="li in lottery.list" :label="li"></el-checkbox>
			</el-checkbox-group>
		</el-form-item><br>
		<el-form-item label="真人">
			<el-checkbox style="margin-right:10px;" :indeterminate="live.isIndeterminate" v-model="live.checkAll" @change="liveCheckAllChange">全选</el-checkbox>
			<el-checkbox-group style="display:inline-table" v-model="live.checked" @change="liveCheckedChange">
				<el-checkbox v-for="li in live.list" :label="li"></el-checkbox>
			</el-checkbox-group>
		</el-form-item><br>
		<el-form-item label="会员名称"><el-input v-model="form.name"></el-input></el-form-item>
		<el-form-item><el-button type="primary">查找</el-button></el-form-item>
	</el-form>
	<el-table show-summary border style="width:100%" size="mini">
		<el-table-column label="财务报表" class-name="header">
			<el-table-column prop="name" label="会员账号"></el-table-column>
			<el-table-column prop="name" label="余额"></el-table-column>
			<el-table-column prop="name" label="当前余额"></el-table-column>
			<el-table-column prop="name" label="常规存取款">
				<el-table-column prop="name" label="存款"></el-table-column>
				<el-table-column prop="name" label="汇款"></el-table-column>
				<el-table-column prop="name" label="人工汇款"></el-table-column>
				<el-table-column prop="name" label="提款"></el-table-column>
			</el-table-column>
			<el-table-column prop="name" label="红利派送">
				<el-table-column prop="name" label="汇款赠送"></el-table-column>
				<el-table-column prop="name" label="彩金派送"></el-table-column>
				<el-table-column prop="name" label="反水派送"></el-table-column>
			</el-table-column>
			<el-table-column prop="name" label="其他情况"></el-table-column>
			<el-table-column prop="name" label="手续费(银行转账费用)">
				<el-table-column prop="name" label="第三方(1%)"></el-table-column>
				<el-table-column prop="name" label="提款手续费"></el-table-column>
			</el-table-column>
		</el-table-column>
	</el-table>

</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/element-ui@2.2.0/lib/index.min.js"></script>
    <script type="text/javascript">
        var vm = new Vue({
            data: {
            	form:{

            	},
            	lotteryCheckAll:false,
            	lottery:{
            		CheckAll:false,
            		checked:[],
            		list:[
            			'体育单式',
            			'体育串关',
            			'香港六合彩',
            			'重庆时时彩',
            			'广东快乐十分',
            			'北京赛车PK拾',
            			'幸运飞艇',
            			'北京快乐8',
            			'上海时时乐',
            			'福彩3D',
            			'排列三',
            			'极速赛车',
            			'极速时时彩',
            			'极速六合'
            		],
            		isIndeterminate: false
            	},
            	live:{
            		CheckAll:false,
            		checked:[],
            		list:[
            			'AG国际厅',
            			'AG极速厅',
            			'BB波音厅',
            			'OG东方厅',
            			'玛雅娱乐厅',
            			'MG电子',
            			'HG名人厅',
            			'PT电子',
            			'沙巴体育',
            			'IPM体育',
            			'MW游戏',
            			'AV女优',
            			'CQ9电子',
            			'新MG电子',
            			'VR彩票'
            		],
            		isIndeterminate: false
            	}
            },
            methods: {
            	lotteryCheckAllChange(val) {
					this.lottery.checked = val ? this.lottery.list : [];
					this.lottery.isIndeterminate = false;
				},
				lotteryCheckedChange(value) {
					var checkedCount = value.length;
					this.lottery.checkAll = checkedCount === this.lottery.list.length;
					this.lottery.isIndeterminate = checkedCount > 0 && checkedCount < this.lottery.list.length;
				},
				liveCheckAllChange(val) {
					this.live.checked = val ? this.live.list : [];
					this.live.isIndeterminate = false;
				},
				liveCheckedChange(value) {
					var checkedCount = value.length;
					this.live.checkAll = checkedCount === this.live.list.length;
					this.live.isIndeterminate = checkedCount > 0 && checkedCount < this.live.list.length;
				}
            },
            created: function() {
            	_self = this;
            	$.post('?act=finance',this.form,function(json){

            	},'json');
            }
        }).$mount('#app');
    </script>
<div id="pageMain"> 
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="font12" style="border:1px solid #798EB9;"> 
	  <form name="form1" method="get" action=""> 
	  <tr bgcolor="#FFFFFF"> 
		  <td align="left"> 
			  <select name="time" id="time" disabled="disabled"> 
				  <option value="CN" <?=$time=='CN' ? 'selected' : ''?>>中国时间</option>
				<option value="EN" <?=$time=='EN' ? 'selected' : ''?>>美东时间</option>
			  </select> 
			 &nbsp;开始日期
				<input name="bdate" type="text" id="bdate" value="<?=$bdate?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />
				<select name="bhour" id="bhour">
					<?php
					for($i=0;$i<24;$i++){
						$list=$i<10?"0".$i:$i;
					?>
					<option value="<?=$list?>" <?=$bhour==$list?"selected":""?>><?=$list?></option>
					<?php } ?>
				</select>&nbsp;时
				<select name="bsecond" id="bsecond">
					<?php
					for($i=0;$i<60;$i++){
						$list=$i<10?"0".$i:$i;
					?>
					<option value="<?=$list?>" <?=$bsecond==$list?"selected":""?>><?=$list?></option>
					<?php } ?>
				</select>&nbsp;分
				&nbsp;结束日期
				<input name="edate" type="text" id="edate" value="<?=$edate?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />
				<select name="ehour" id="ehour">
					<?php
					for($i=0;$i<24;$i++){
						$list=$i<10?"0".$i:$i;
					?>
					<option value="<?=$list?>" <?=$ehour==$list?"selected":""?>><?=$list?></option>
					<?php } ?>
				</select>&nbsp;时
				<select name="esecond" id="esecond">
					<?php
					for($i=0;$i<60;$i++){
						$list=$i<10?"0".$i:$i;
					?>
					<option value="<?=$list?>" <?=$esecond==$list?"selected":""?>><?=$list?></option>
					<?php } ?>
				</select>&nbsp;分
		  </td> 
	  </tr> 
	  <tr bgcolor="#FFFFFF"> 
		  <td align="left"> 
			  &nbsp;彩种 
			<input name="cz_ty[]" type="checkbox" <?=in_array("tyds",$cz_ty)?"checked":""?> value="tyds" />体育单式
			<input name="cz_ty[]" type="checkbox" <?=in_array("tycg",$cz_ty)?"checked":""?>  value="tycg" />体育串关
			<input name="cz_pt[]" type="checkbox" <?=in_array("lhc",$cz_pt)?"checked":""?>  value="lhc" />香港六合彩
			<input name="cz_gp[]" type="checkbox" <?=in_array("cqssc",$cz_gp)?"checked":""?>  value="cqssc" />重庆时时彩
			<input name="cz_gp[]" type="checkbox" <?=in_array("gdklsf",$cz_gp)?"checked":""?>  value="gdklsf" />广东快乐十分
			<input name="cz_gp[]" type="checkbox" <?=in_array("bjsc",$cz_gp)?"checked":""?>  value="bjsc" />北京赛车PK拾
			<input name="cz_gp[]" type="checkbox" <?=in_array("xyft",$cz_gp)?"checked":""?>  value="xyft" />幸运飞艇
			<input name="cz_pt[]" type="checkbox" <?=in_array("kl8",$cz_pt)?"checked":""?>  value="kl8" />北京快乐8
			<input name="cz_pt[]" type="checkbox" <?=in_array("ssl",$cz_pt)?"checked":""?>  value="ssl" />上海时时乐
			<input name="cz_pt[]" type="checkbox" <?=in_array("3d",$cz_pt)?"checked":""?>  value="3d" />福彩3D
			<input name="cz_pt[]" type="checkbox" <?=in_array("pl3",$cz_pt)?"checked":""?>  value="pl3" />排列三
			<input name="cz_js[]" type="checkbox" <?=in_array("JSSC",$cz_js)?"checked":""?>  value="JSSC" />极速赛车
			<input name="cz_js[]" type="checkbox" <?=in_array("JSSSC",$cz_js)?"checked":""?>  value="JSSSC" />极速时时彩
			<input name="cz_js[]" type="checkbox" <?=in_array("JSLH",$cz_js)?"checked":""?>  value="JSLH" />极速六合
		  </td> 
	  </tr> 
	   <tr bgcolor="#FFFFFF"> 
		  <td align="left"> 
			  &nbsp;真人
			  <?php foreach($zrlist as $k=>$v):?>
			  	<input name="ck_zr[]" type="checkbox" <?=in_array($k,$ck_zr)?"checked":""?> value="<?=$k?>" /><?=$v['name']?>
			  <?php endforeach;?>
			  </td>
			  </tr>
	  <tr bgcolor="#FFFFFF"> 
		  <td align="left"> 
			  &nbsp;会员名称 
			  <input name="username" type="text" id="username" value="<?=$username;?>" size="15" maxlength="20"/> 
			  &nbsp;<input name="find" type="submit" id="find" value="查找"/> 
		  </td> 
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

$cn_q_btime = date('Y-m-d H:i:s', strtotime($btime) + (12 * 3600));
$cn_q_etime = date('Y-m-d H:i:s', strtotime($etime) + (12 * 3600));
$params = array();
$sqlwhere = '';
$sqlwhere2 = '';
if ($username != ''){
	$params[':username'] = $username;
	$sqlwhere .= ' and u.username=:username';
	$params[':username2'] = $username;
	$sqlwhere2 .= ' and u.username=:username2';
}
$sql = 'select tm.*,su.money as bef_money from (';
$sql .= 'select username,money,sum(t1_value) as t1_value,sum(t2_value) as t2_value,sum(t3_value) as t3_value,sum(t4_value) as t4_value,sum(t5_value) as t5_value,sum(t6_value) as t6_value,sum(t1_sxf) as t1_sxf,sum(t2_sxf) as t2_sxf,sum(h_value) as h_value,sum(h_zsjr) as h_zsjr from (';
$params[':q_btime'] = $q_btime;
$params[':q_etime'] = $q_etime;
$params[':q_btime2'] = $q_btime;
$params[':q_etime2'] = $q_etime;
$sql .= 'select u.username,u.money,sum(if(m.type=1,m.m_value,0)) as t1_value,sum(if(m.type=2,m.m_value,0)) as t2_value,sum(if(m.type=3,m.m_value,0)) as t3_value,sum(if(m.type=4,m.m_value,0)) as t4_value,sum(if(m.type=5,m.m_value,0)) as t5_value,sum(if(m.type=6,m.m_value,0)) as t6_value,sum(if(m.type=1,m.sxf,0)) as t1_sxf,sum(if(m.type=2,m.sxf,0)) as t2_sxf,0 as h_value, 0 as h_zsjr from k_money m left outer join k_user u on m.uid=u.uid where m.status=1 and m.m_make_time>=:q_btime and m.m_make_time<=:q_etime ' . $sqlwhere . ' group by u.username';
$sql .= ' union all ';
$sql .= 'select u.username,u.money,0 as t1_value,0 as t2_value,0 as t3_value,0 as t4_value,0 as t5_value,0 as t6_value,0 as t1_sxf,0 as t2_sxf,sum(ifnull(h.money,0)) as h_value,sum(ifnull(h.zsjr,0)) as h_zsjr from huikuan h left outer join k_user u on h.uid=u.uid where h.status=1 and h.adddate>=:q_btime2 and h.adddate<=:q_etime2 ' . $sqlwhere2 . ' group by u.username';
$params[':qiantian'] = $qiantian . '%';
$sql .= ')temp group by username';
$sql .= ')tm left outer join mydata3_db.save_user su on tm.username=su.username and su.addtime like (:qiantian)';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
?>	  
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;line-height:20px;" bgcolor="#798EB9">    
	  <tr align="center" style="background:#3C4D82;color:#ffffff;font-weight:bold;"> 
		  <td colspan="13"><?=$btime;?>至<?=$etime;?>财务报表</td> 
	  </tr> 
	  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
		  <td rowspan="2">会员账号</td> 
		  <td rowspan="2"><?=substr($qiantian, 5, 5);?>余额</td> 
		  <td rowspan="2">当前余额</td> 
		  <td colspan="4">常规存取款</td> 
		  <td colspan="3">红利派送</td> 
		  <td rowspan="2">其他情况</td> 
		  <td colspan="2">手续费(银行转账费用)</td> 
	  </tr> 
	  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
		  <td>存款</td> 
		  <td>汇款</td> 
		  <td>人工汇款</td> 
		  <td>提款</td> 
		  <td>汇款赠送</td> 
		  <td>彩金派送</td> 
		  <td>反水派送</td> 
		  <td>第三方(1%)</td> 
		  <td>提款手续费</td> 
	  </tr>
<?php 
$sum_t1_value = 0;
$sum_t2_value = 0;
$sum_t3_value = 0;
$sum_t4_value = 0;
$sum_t5_value = 0;
$sum_t6_value = 0;
$sum_t1_sxf = 0;
$sum_t2_sxf = 0;
$sum_h_value = 0;
$sum_h_zsjr = 0;
while ($row = $stmt->fetch())
{
	if (in_array($row['username'], $hlhy)){
		continue;
	}
	$sum_t1_value += $row['t1_value'];
	$sum_t2_value += abs($row['t2_value']);
	$sum_t3_value += $row['t3_value'];
	$sum_t4_value += $row['t4_value'];
	$sum_t5_value += $row['t5_value'];
	$sum_t6_value += $row['t6_value'];
	$sum_t1_sxf += $row['t1_sxf'];
	$sum_t2_sxf += $row['t2_sxf'];
	$sum_h_value += $row['h_value'];
	$sum_h_zsjr += $row['h_zsjr'];
	$sum_money += $row['money'];
	$sum_bef_money += $row['bef_money'];
?>		  
		<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over;?>'" onMouseOut="this.style.backgroundColor='<?=$out;?>'" style="background-color:<?=$color;?>;"> 
		  <td><?=$row['username'];?></td> 
		  <td><?=sprintf('%.2f',$row['bef_money']);?></td> 
		  <td><?=sprintf('%.2f',$row['money']);?></td> 
		  <td><?=sprintf('%.2f',$row['t1_value']);?></td> 
		  <td> 
			  <a href="javascript:void(0);" onClick="showCountForBank('<?=$row['username']=="" ? "会员已被删除" :$row['username']?>','<?=$q_btime;?>','<?=$q_etime;?>')" title="点击可见【<?=$row['username'];?>】银行汇款统计"> 
				  <span style="color:#00f;text-decoration: underline;"><?=sprintf('%.2f',$row['h_value']);?></span> 
			  </a> 
		  </td> 
		  <td><?=sprintf('%.2f',$row['t3_value']);?></td> 
		  <td><?=sprintf('%.2f',abs($row['t2_value']));?></td> 
		  <td><?=sprintf('%.2f',$row['h_zsjr']);?></td> 
		  <td><?=sprintf('%.2f',$row['t4_value']);?></td> 
		  <td><?=sprintf('%.2f',$row['t5_value']);?></td> 
		  <td><?=sprintf('%.2f',$row['t6_value']);?></td> 
		  <td><?=sprintf('%.2f',$row['t1_sxf']);?></td> 
		  <td><?=sprintf('%.2f',$row['t2_sxf']);?></td> 
	  </tr>
<?php }?> 		 
	  <tr align="center" style="background:#ffffff;color:#ff0000;"> 
		  <td>合计</td> 
		  <td><?=sprintf('%.2f',$sum_bef_money);?></td> 
		  <td><?=sprintf('%.2f',$sum_money);?></td> 
		  <td><?=sprintf('%.2f',$sum_t1_value);?></td> 
		  <td> 
			  <a href="javascript:void(0);" onClick="showCountForBank('<?=$username;?>','<?=$q_btime;?>','<?=$q_etime;?>')" title="点击可见【合计】银行汇款统计"> 
				  <span style="color:#00f;text-decoration: underline;"><?=sprintf('%.2f',$sum_h_value);?></span> 
			  </a> 
		  </td> 
		  <td><?=sprintf('%.2f',$sum_t3_value);?></td> 
		  <td><?=sprintf('%.2f',$sum_t2_value);?></td> 
		  <td><?=sprintf('%.2f',$sum_h_zsjr);?></td> 
		  <td><?=sprintf('%.2f',$sum_t4_value);?></td> 
		  <td><?=sprintf('%.2f',$sum_t5_value);?></td> 
		  <td><?=sprintf('%.2f',$sum_t6_value);?></td> 
		  <td><?=sprintf('%.2f',$sum_t1_sxf);?></td> 
		  <td><?=sprintf('%.2f',$sum_t2_sxf);?></td> 
	  </tr> 
	  <script> 
		  function showCountForBank(username,btime,etime) 
		  { 
			  var myurl = "countbank.php?username="+username+"&btime="+btime+"&etime="+etime;
			  window.open(myurl, "_blank");
		  } 
	  </script> 
  </table>
<?php 

foreach ($zrlist as $k=>$v) {
	if(!in_array($k,$ck_zr)) unset($zrlist[$k]);
}
$params = array();
$sqlwhere = '';
if ($username != '')
{
	$params[':username'] = $username;
	$sqlwhere .= ' and u.username=:username';
}
$params[':q_btime'] = $q_btime;
$params[':q_etime'] = $q_etime;
$sql = '';
foreach($zrlist as $k=>$v) $sql .= 'sum(if(z.zz_type="IN" and z.live_type="'.$k.'",z.zz_money,0)) as '.$k.'_in,sum(if(z.zz_type="OUT" and z.live_type="'.$k.'",z.zz_money,0)) as '.$k.'_out,';


$sql = 'select '.$sql.' u.username from ag_zhenren_zz z left outer join k_user u on z.uid=u.uid where z.ok=1 and z.zz_time>=:q_btime and z.zz_time<=:q_etime ' . $sqlwhere . ' group by u.username';

$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
?>	  
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;line-height:20px;" bgcolor="#798EB9">    
	  <tr align="center" style="background:#3C4D82;color:#ffffff;font-weight:bold;"> 
		  <td colspan="<?=count($zrlist)*3+1?>"><?=$btime;?>至<?=$etime;?>真人转账报表</td> 
	  </tr> 
	  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
		  <td rowspan="2">会员账号</td> 
		  <?php foreach($zrlist as $v):?><td colspan="3" class="borderright"><?=$v['name']?></td><?php endforeach;?>
	  </tr> 
	  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
	  	  <?php foreach($zrlist as $v):?><td>转入</td><td>转出</td><td>差额</td><?php endforeach;?>
	  </tr>
<?php 

while ($row = $stmt->fetch()){
	if (in_array($row['username'], $hlhy)) continue;
	foreach($zrlist as $k=>$v){
		$zrlist[$k]['sum_in'] += $row[$k.'_in'];
		$zrlist[$k]['sum_out'] += $row[$k.'_out'];
		$zrlist[$k]['yl'] = $row[$k.'_in'] - $row[$k.'_out'];
		$zrlist[$k]['sum_yl'] += $zrlist[$k]['yl'];
	} ?>		  
		<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over;?>'" onMouseOut="this.style.backgroundColor='<?=$out;?>'" style="background-color:<?=$color;?>;"> 
		  <td><?=$row['username'];?></td> 
		  <?php foreach($zrlist as $k=>$v):?>
			  <td><?=sprintf('%.2f',$row[$k.'_in']);?></td> 
			  <td><?=sprintf('%.2f',$row[$k.'_out']);?></td> 
			  <td style="color:<?=$zrlist[$k]['yl']>=0 ? '#ff0000' : '#009900';?>"><?=sprintf('%.2f',$zrlist[$k]['yl'])?></td>
		  <?php endforeach;?>
	  </tr>
<?php }?> 		  
	  <tr align="center" style="background:#ffffff;color:#ff0000;"> 
		  <td>合计</td> 
		  <?php foreach($zrlist as $k=>$v):?>
			  <td><?=sprintf('%.2f', $zrlist[$k]['sum_in'])?></td> 
			  <td><?=sprintf('%.2f', $zrlist[$k]['sum_out'])?></td> 
			  <td style="color:<?=$zrlist[$k]['sum_yl']>=0 ? '#ff0000' : '#009900';?>"><?=sprintf('%.2f',$zrlist[$k]['sum_yl'])?></td> 
		  <?php endforeach;?>
	  </tr> 
  </table> 



  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;line-height:20px;" bgcolor="#798EB9"> 
	  <tr align="center" style="background:#3C4D82;color:#ffffff;font-weight:bold;"> 
		  <td colspan="11"><?=$btime;?>至<?=$etime;?>投注报表</td> 
	  </tr> 
	  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
		  <td rowspan="2">会员账号</td> 
		  <td colspan="6">已结算</td> 
		  <td colspan="2">未结算</td> 
		  <td colspan="2">注单统计(未结算+已结算)</td> 
	  </tr> 
	  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
		  <td>笔数</td> 
		  <td>下注金额</td> 
		  <td>有效投注</td> 
		  <td>派彩</td> 
		  <td>反水</td> 
		  <td>盈亏</td> 
		  <td>笔数</td> 
		  <td>下注金额</td> 
		  <td>笔数</td> 
		  <td>下注金额</td> 
	  </tr><?php $params = array();
$sqlwhere = '';
$sqlwhere2 = '';
$sqlwhere3 = '';
$sqlwhere4 = '';
$sqlwhere5 = '';
$sqlwhere6 = '';
$sql = 'select username,sum(y_num) as y_num,sum(y_bet_money) as y_bet_money,sum(yx_bet_money) as yx_bet_money,sum(y_win) as y_win,sum(y_fs) as y_fs,sum(w_num) as w_num,sum(w_bet_money) as w_bet_money from (';
$sql_cz = '';

if (in_array('tyds', $cz_ty))
{
	if ($username != '')
	{
		$params[':username'] = $username;
		$sqlwhere .= ' and u.username=:username';
	}
	$params[':q_btime'] = $q_btime;
	$params[':q_etime'] = $q_etime;
	$sql_cz = 'select username,if(status<>0,1,0) as y_num,if(status<>0,bet_money,0) as y_bet_money,if(status=1 or status=2 or status=4 or status=5,bet_money,0) as yx_bet_money,if(status<>0,win,0) as y_win,if(status<>0,fs,0) as y_fs,if(status=0,1,0) as w_num,if(status=0,bet_money,0) as w_bet_money from k_bet k left outer join k_user u on k.uid=u.uid where lose_ok=1 and status in (0,1,2,3,4,5,6,7,8) and k.bet_time>=:q_btime and k.bet_time<=:q_etime ' . $sqlwhere;
}
if (in_array('tycg', $cz_ty))
{
	if ($username != '')
	{
		$params[':username2'] = $username;
		$sqlwhere2 .= ' and u.username=:username2';
	}
	$params[':q_btime2'] = $q_btime;
	$params[':q_etime2'] = $q_etime;
	if ($sql_cz != '')
	{
		$sql_cz .= ' union all ';
	}
	$sql_cz .= 'select username,if(status<>0 and status<>2,1,0) as y_num,if(status<>0 and status<>2,bet_money,0) as y_bet_money,if(status=1,bet_money,0) as yx_bet_money,if(status<>0 and status<>2,win,0) as y_win,if(status<>0 and status<>2,fs,0) as y_fs,if(status=0 or status=2,1,0) as w_num,if(status=0 or status=2,bet_money,0) as w_bet_money from k_bet_cg_group k left outer join k_user u on k.uid=u.uid where k.gid>0 and status in (0,1,2,3,4) and k.bet_time>=:q_btime2 and k.bet_time<=:q_etime2 ' . $sqlwhere2;
}
if (in_array('lhc', $cz_pt))
{
	if ($username != '')
	{
		$params[':username3'] = $username;
		$sqlwhere3 .= ' and username=:username3';
	}
	$params[':cn_q_btime'] = $cn_q_btime;
	$params[':cn_q_etime'] = $cn_q_etime;
	if ($sql_cz != '')
	{
		$sql_cz .= ' union all ';
	}
	$sql_cz .= 'select username,if(checked=1,1,0) as y_num,if(checked=1,sum_m,0) as y_bet_money,if(checked=1 and bm<>2,sum_m,0) as yx_bet_money,if(checked=1,(case bm when 1 then sum_m*rate when 2 then sum_m else 0 end),0) as y_win,if(checked=1,(case bm when 2 then 0 else sum_m*user_ds/100 end),0) as y_fs,if(checked=0,1,0) as w_num,if(checked=0,sum_m,0) as w_bet_money from mydata2_db.ka_tan where adddate>=:cn_q_btime and adddate<=:cn_q_etime ' . $sqlwhere3;
}
if (in_array('cqssc', $cz_gp))
{
	if ($username != '')
	{
		$params[':username4'] = $username;
		$sqlwhere4 .= ' and username=:username4';
	}
	$params[':q_btime4'] = $q_btime;
	$params[':q_etime4'] = $q_etime;
	if ($sql_cz != '')
	{
		$sql_cz .= ' union all ';
	}
	$sql_cz .= 'select username,if(js=1,1,0) as y_num,if(js=1,money,0) as y_bet_money,if(js=1 and win<>0,money,0) as yx_bet_money,if(js=1,(case when win<0 then 0 when win=0 then money else win end),0) as y_win,0 as y_fs,if(js=0,1,0) as w_num,if(js=0,money,0) as w_bet_money from c_bet where money>0 and type=\'重庆时时彩\' and addtime>=:q_btime4 and addtime<=:q_etime4 ' . $sqlwhere4;
}
$tmp = [];
if (in_array('gdklsf', $cz_gp))
{
	$tmp[] = '`type`="广东快乐10分"';
}
if (in_array('bjsc', $cz_gp))
{
	$tmp[] = '`type`="北京赛车PK拾"';
}
if (in_array('xyft', $cz_gp))
{
	$tmp[] = '`type`="幸运飞艇"';
}
$cz_type = implode(' or ', $tmp);
if ($cz_type != '')
{
	if ($username != '')
	{
		$params[':username5'] = $username;
		$sqlwhere5 .= ' and username=:username5';
	}
	$params[':q_btime5'] = $q_btime;
	$params[':q_etime5'] = $q_etime;
	if ($sql_cz != '')
	{
		$sql_cz .= ' union all ';
	}
	$sql_cz .= 'select username,if(js=1,1,0) as y_num,if(js=1,money,0) as y_bet_money,if(js=1 and win<>0,money,0) as yx_bet_money,if(js=1,(case when win<0 then 0 when win=0 then money else win end),0) as y_win,0 as y_fs,if(js=0,1,0) as w_num,if(js=0,money,0) as w_bet_money from c_bet_3 where money>0 and (' . $cz_type . ') and addtime>=:q_btime5 and addtime<=:q_etime5 ' . $sqlwhere5;
}
$tmp = [];
if (in_array('kl8', $cz_pt))
{
	$tmp[] = '`atype`="kl8"';
}
if (in_array('ssl', $cz_pt))
{
	$tmp[] = '`atype`="ssl"';
}
if (in_array('3d', $cz_pt))
{
	$tmp[] = '`atype`="3d"';
}
if (in_array('pl3', $cz_pt))
{
	$tmp[] = '`atype`="pl3"';
}
$cz_type = implode(' or ', $tmp);
if ($cz_type != '')
{
	if ($username != '')
	{
		$params[':username6'] = $username;
		$sqlwhere6 .= ' and username=:username6';
	}
	$params[':q_btime6'] = $q_btime;
	$params[':q_etime6'] = $q_etime;
	if ($sql_cz != '')
	{
		$sql_cz .= ' union all ';
	}
	$sql_cz .= 'select username,if(bet_ok=1,1,0) as y_num,if(bet_ok=1,money,0) as y_bet_money,if(bet_ok=1 and win<>0,money,0) as yx_bet_money,if(bet_ok=1,win+money,0) as y_win,0 as y_fs,if(bet_ok=0,1,0) as w_num,if(bet_ok=0,money,0) as w_bet_money from lottery_data where money>0 and (' . $cz_type . ') and bet_time>=:q_btime6 and bet_time<=:q_etime6 ' . $sqlwhere6;
}
$tmp =  [];
if (in_array('JSSC', $cz_js))
{
	$tmp[] = '`type`="JSSC"';
}
if (in_array('JSSSC', $cz_js))
{
	$tmp[] = '`type`="JSSSC"';
}
if (in_array('JSLH', $cz_js))
{
	$tmp[] = '`type`="JSLH"';
}
$cz_type = implode(' or ', $tmp);
if ($cz_type != '')
{
	if ($username != '')
	{
		$params[':username7'] = $username;
		$sqlwhere7 .= ' and u.username=:username7';
	}
	$params[':q_btime7'] = strtotime($q_btime);
	$params[':q_etime7'] = strtotime($q_etime);
	if ($sql_cz != '')
	{
		$sql_cz .= ' union all ';
	}
	$sql_cz .= 'select u.username,if(c.status=1,1,0) as y_num,if(c.status=1,c.money/100,0) as y_bet_money,if(c.status=1 and c.win<>0,c.money/100,0) as yx_bet_money,if(c.status=1,(case when c.win<0 then 0 when c.win=0 then c.money/100 else c.win/100 end),0) as y_win,0 as y_fs,if(c.status=0,1,0) as w_num,if(c.status=0,c.money/100,0) as w_bet_money from c_bet_data c left outer join k_user u on c.uid=u.uid where c.money>0 and (' . $cz_type . ') and c.addtime>=:q_btime7 and c.addtime<=:q_etime7 ' . $sqlwhere7;
}

$sql .= $sql_cz;
$sql .= ') temp group by username';

$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$sum_y_num = 0;
$sum_y_bet_money = 0;
$sum_yx_bet_money = 0;
$sum_y_win = 0;
$sum_y_fs = 0;
$sum_y_yingkui = 0;
$sum_w_num = 0;
$sum_w_bet_money = 0;
while ($row = $stmt->fetch())
{
if (in_array($row['username'], $hlhy)) continue;

$y_yingkui = sprintf('%.2f', $row['y_bet_money'] - $row['y_win'] - $row['y_fs']);
$sum_y_num += $row['y_num'];
$sum_y_bet_money += $row['y_bet_money'];
$sum_yx_bet_money += $row['yx_bet_money'];
$sum_y_win += $row['y_win'];
$sum_y_fs += $row['y_fs'];
$sum_y_yingkui += $y_yingkui;
$sum_w_num += $row['w_num'];
$sum_w_bet_money += $row['w_bet_money'];?>		  
		<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over;?>'" onMouseOut="this.style.backgroundColor='<?=$out;?>'" style="background-color:<?=$color;?>;"> 
		  <td><?=$row['username'];?></td> 
		  <td><?=$row['y_num'];?></td> 
		  <td><?=sprintf('%.2f',$row['y_bet_money']);?></td> 
		  <td><?=sprintf('%.2f',$row['yx_bet_money']);?></td> 
		  <td><?=sprintf('%.2f',$row['y_win']);?></td> 
		  <td><?=sprintf('%.2f',$row['y_fs']);?></td> 
		  <td style="color:<?=$y_yingkui>=0 ? '#ff0000' : '#009900';?>"><?=$y_yingkui;?></td> 
		  <td><?=$row['w_num'];?></td> 
		  <td><?=sprintf('%.2f',$row['w_bet_money']);?></td> 
		  <td><?=$row['y_num'] + $row['w_num'];?></td> 
		  <td><?=sprintf('%.2f',$row['y_bet_money'] + $row['w_bet_money']);?></td> 
	  </tr>
<?php }?> 		  
		<tr align="center" style="background:#ffffff;color:#ff0000;"> 
		  <td>合计</td> 
		  <td><?=$sum_y_num;?></td> 
		  <td><?=sprintf('%.2f',$sum_y_bet_money);?></td> 
		  <td><?=sprintf('%.2f',$sum_yx_bet_money);?></td> 
		  <td><?=sprintf('%.2f',$sum_y_win);?></td> 
		  <td><?=sprintf('%.2f',$sum_y_fs);?></td> 
		  <td style="color:<?=$sum_y_yingkui>=0 ? '#ff0000' : '#009900';?>"><?=sprintf('%.2f',$sum_y_yingkui);?></td> 
		  <td><?=$sum_w_num;?></td> 
		  <td><?=sprintf('%.2f',$sum_w_bet_money);?></td> 
		  <td><?=$sum_y_num + $sum_w_num;?></td> 
		  <td><?=sprintf('%.2f',$sum_y_bet_money +$sum_w_bet_money);?></td> 
	  </tr> 
  </table> 
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="font12" style="margin-top:5px;line-height:20px;"> 
	  <tr> 
		  <td> 
			  <p>备注说明：</p> 
			  <p>1、前一日余额由系统在美东时间当日结束时保存（且只有在后台登陆时才会保存），仅供查账时参考使用</p> 
			  <p>2、有效投注为有产生输赢的注单统计，可作为周反水等优惠活动的基础数据</p> 
			  <p>3、第三方支付的手续费统一按1%进行计算，由于各种第三方支付的手续费率和算法不一样，这部分数据仅供参考</p> 
		  </td> 
	  </tr> 
  </table> 
</div> 
</div> 
</body> 
</html>