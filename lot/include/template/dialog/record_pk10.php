<?php
!defined('IN_LOT')&&die('Access Denied');
$sql = 'SELECT * FROM `c_bet_3` WHERE `uid`='.$LOT['user']['uid'].' AND `type`="北京赛车PK拾" AND `js`=0';
$stmt = $mydata1_db->query($sql);
$rows = $stmt->fetchAll();
?>
<div class="tab tab-dialog">
	<h2 style="text-align:center;color:#6f4d28;font-weight:bold">北京赛车PK拾</h2>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>投注时间(美东/北京)</th>
				<th>下注单号</th>
				<th>下注期号</th>
				<th>投注信息</th>
				<th>下注金额</th>
				<th>可赢</th>
				<th>状态</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($rows as $v){ ?>
			<tr>
				<td>
					<?php 
					echo $v['addtime'].'<br/>'.date('Y-m-d H:i:s',strtotime($v['addtime'])+12*3600); 
					?>
				</td>
				<td><?=$v['id']?></td>
				<td><?=$v['qishu']?></td>
				<td><?=$v['mingxi_1']?>【<span style="color:red;"><?=$v['mingxi_2']?></span>】</td>
				<td><?=sprintf('%.2f',$v['money'])?></td>
				<td><?=sprintf('%.2f',$v['odds']*$v['money'])?></td>
				<td>未结算</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>