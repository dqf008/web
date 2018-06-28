<?php
ini_set('display_errors','On');
!defined('IN_LOT')&&die('Access Denied');
$sql = 'SELECT * FROM `lottery_data` WHERE `username`="'.$LOT['user']['username'].'" AND `atype`="pcdd" AND `bet_ok`=0';
$stmt = $mydata1_db->query($sql);
$rows = $stmt->fetchAll();
?>
<div class="tab tab-dialog">
	<h2 style="text-align:center;color:#6f4d28;font-weight:bold">PC蛋蛋</h2>
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
					echo $v['bet_time'].'<br/>'.date('Y-m-d H:i:s',strtotime($v['bet_time'])+12*3600); 
					?>
				</td>
				<td><?=$v['id']?></td>
				<td><?=$v['mid']?></td>
				<td>
				<?php
					$arr = [];
					$v['btype']&&$arr[] = $v['btype'];
					$v['ctype']&&$arr[] = $v['ctype'];
					$v['dtype']&&$arr[] = $v['dtype'];
					echo implode('/',$arr);
				?>
				</td>
				<td><?=sprintf('%.2f',$v['money'])?></td>
				<td><?=sprintf('%.2f',$v['odds']*$v['money'])?></td>
				<td>未结算</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>