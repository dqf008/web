<?php
!defined('IN_LOT')&&die('Access Denied');
$sql = 'SELECT * FROM `c_bet_data` WHERE `uid`='.$LOT['user']['uid'].' AND `type`="SFK3"';
$stmt = $mydata1_db->query($sql);
$rows = $stmt->fetchAll();
$contentText=array('3THTX'=>'三同号通选','3LHTX'=>'三连号通选');
?>
<div class="tab tab-dialog">
    <h2 style="text-align:center;color:#6f4d28;font-weight:bold">超级快3</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>投注时间(美东/北京)</th>
                <th>下注期号</th>
                <th>玩法</th>
                <th>赔率</th>
                <th>金额</th>
                <th>中奖金</th>
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
                    <td><?=$row['qishu']?></td>
                    <td><?=$row['class'][0]?>【<?=isset($contentText[$row['class'][1]])? $contentText[$row['class'][1]]:$row['class'][1]; ?>】</td>
                    <td><?=sprintf('%.2f',$row['odds'])?></td>
                    <td><?=sprintf('%.2f',$v['money']/100)?></td>
                    <td>
                        <?php if($v['status']==1 && $v['win'] >0){
                            echo sprintf('%.2f', $v['win']/100);
                        }else{
                            echo sprintf('%.2f', 0);
                        } ?>
                    </td>
                    <td><?php if($v['status']==0){
                            echo "未结算";
                        }else if($v['win']>0){
                            echo "<span style='color:#FF0000;'>中奖</span>";
                        }else{
                            echo "<span style='color:#00FF00;'>未中奖</span>";
                        } ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
</div>