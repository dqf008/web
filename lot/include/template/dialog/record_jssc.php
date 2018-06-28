<?php
!defined('IN_LOT')&&die('Access Denied');
$sql = 'SELECT * FROM `c_bet_data` WHERE `uid`='.$LOT['user']['uid'].' AND `type`="JSSC" AND `status`=0';
$stmt = $mydata1_db->query($sql);
$rows = $stmt->fetchAll();
?>
<div class="tab tab-dialog">
	<h2 style="text-align:center;color:#6f4d28;font-weight:bold">极速赛车</h2>
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
			<?php foreach($rows as $v){ 
				$row = unserialize($v['value']);
				?>
			<tr>
				<td>
					<?php 
					echo date('Y-m-d H:i:s',$v['addtime']).'<br/>'.date('Y-m-d H:i:s',$v['addtime']+43200); 
					?>
				</td>
				<td><?=$v['id']?></td>
				<td><?=$row['qishu']?></td>
				<td><?=$row['class'][0]?>【<?=$row['class'][1]?>】</td>
				<td><?=sprintf('%.2f',$v['money']/100)?></td>
				<td><?=sprintf('%.2f',$v['odds']*$v['money'])?></td>
				<td>未结算</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>