<?php
!defined('IN_LOT')&&die('Access Denied');
$lotteryType = isset($LOT['lottery_type'])?$LOT['lottery_type']:'jsk3';
$params = array(':qtime' => date('Y-m-d 00:00:00', $qtime), ':etime' => date('Y-m-d 23:59:59', $qtime));
$sql = "SELECT * FROM `lottery_k3` WHERE `ok`=1 AND `fengpan`>=:qtime AND `fengpan`<=:etime and name='$lotteryType' ORDER BY `qihao` DESC";
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
if($stmt->rowCount()>0){
?>
            <div id="history">
                <div id="history_detail">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>期数</th>
                                <th>开奖时间</th>
                                <th>号码</th>
                                <th colspan="3">和值</th>
                            </tr>
                        </thead>
                        <tbody>
<?php while($rows = $stmt->fetch()){
    $balls = explode(',',$rows['balls']);
     ?>                            <tr>
                                <td class="td-hd" style="line-height:60px"><?php echo $rows['qihao']; ?></td>
                                <td><?php echo date('Y-m-d H:i:s',$rows['addtime']); ?></td>
                                <td><?php

$sum = array_sum($balls);
 $ballString='';
for($i=0;$i<=2;$i++){
    $ballString.= '<span class="icon ball">'.$balls[$i].'</span>';
}
echo $ballString;
?></td>
                                <td><?php echo $sum; ?></td>
                                <td><?php echo $sum>10?'大':'小'; ?></td>
                                <td><?php echo fmod($sum, 2)==0?'双':'单'; ?></td>
                            </tr>
<?php } ?>                        </tbody>
                    </table>
                </div>
            </div>
<?php }else{ ?>            <div id="history"><div id="history_detail">暂无数据</div></div>
<?php } ?>            <input type="hidden" id="hid-empty-data" value="暂无数据"/>
            <script>
                require(['dialog-index'], function (Account) {new Account()});
                require(['history'], function (App) {new App({lotteryId: '<?php echo $LOT['l']; ?>'})});
            </script>
