<?php
!defined('IN_LOT')&&die('Access Denied');
$sql = 'SELECT * FROM `mydata2_db`.`ka_tan` WHERE `username`="'.$LOT['user']['username'].'" AND `checked`=0';
$stmt = $mydata1_db->query($sql);
$rows = $stmt->fetchAll();
?>
<div class="tab tab-dialog">
	<h2 style="text-align:center;color:#6f4d28;font-weight:bold">六合彩</h2>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>投注时间</th>
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
					<?= $v['adddate']?>
				</td>
				<td><?=$v['id']?></td>
				<td><?=$v['kithe']?></td>
				<td>
					<?php 
					$arr = [];
					$v['class1']&&$arr[] = $v['class1'];
					$v['class2']&&$arr[] = $v['class2'];
					$v['class3']&&$arr[] = $v['class3'];
					echo implode('/',$arr);
					?>
				</td>
				<td><?=sprintf('%.2f',$v['sum_m'])?></td>
				<td><?=sprintf('%.2f',$v['rate']*$v['sum_m'])?></td>
				<td>未结算</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>