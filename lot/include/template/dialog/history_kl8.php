<?php
!defined('IN_LOT')&&die('Access Denied');
$params = array(':qtime' => date('Y-m-d 00:00:00', $qtime), ':etime' => date('Y-m-d 23:59:59', $qtime));
$sql = 'SELECT * FROM `lottery_k_kl8` WHERE `ok`=1 AND `addtime`>=:qtime AND `addtime`<=:etime ORDER BY `qihao` DESC';
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
                                <th colspan="2">盘位</th>
                            </tr>
                        </thead>
                        <tbody>
<?php while($rows = $stmt->fetch()){$rows['sum'] = $rows['jpsum'] = $rows['spsum'] = 0; ?>                            <tr>
                                <td class="td-hd" style="line-height:60px"><?php echo $rows['qihao']; ?></td>
                                <td><?php echo $rows['addtime']; ?></td>
                                <td><?php
$balls = '';
for($i=1;$i<=20;$i++){
    $rows['sum']+= $rows['hm'.$i];
    $rows['hm'.$i]<=40&&$rows['spsum']++;
    fmod($rows['hm'.$i], 2)!=0&&$rows['jpsum']++;
    $balls.= '<span class="icon ball">'.$rows['hm'.$i].'</span>';
    if($i==10){
        echo $balls;
        $balls = '<br />';
    }
}
echo $balls;
?></td>
                                <td><?php echo $rows['sum']; ?></td>
                                <td><?php echo $rows['sum']==810?'和':($rows['sum']>810?'大':'小'); ?></td>
                                <td><?php echo fmod($rows['sum'], 2)==0?'双':'单'; ?></td>
                                <td><?php echo $rows['spsum']>10?'上':($rows['spsum']<10?'下':'中'); ?><br />盘</td>
                                <td><?php echo $rows['jpsum']>10?'奇':($rows['jpsum']<10?'偶':'和'); ?><br />盘</td>
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
