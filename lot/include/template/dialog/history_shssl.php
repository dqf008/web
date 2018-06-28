<?php
!defined('IN_LOT')&&die('Access Denied');
$params = array(':qtime' => date('Y-m-d 00:00:00', $qtime), ':etime' => date('Y-m-d 23:59:59', $qtime));
$sql = 'SELECT * FROM `lottery_k_ssl` WHERE `ok`=1 AND `addtime`>=:qtime AND `addtime`<=:etime ORDER BY `qihao` DESC';
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
                                <th colspan="3">百位</th>
                                <th colspan="3">十位</th>
                                <th colspan="3">个位</th>
                                <th colspan="3">和值</th>
                            </tr>
                        </thead>
                        <tbody>
<?php while($rows = $stmt->fetch()){$rows['sum'] = $rows['hm1']+$rows['hm2']+$rows['hm3']; ?>                            <tr>
                                <td class="td-hd"><?php echo $rows['qihao']; ?></td>
                                <td><?php echo $rows['addtime']; ?></td>
                                <td><span class="icon ball"><?php echo $rows['hm1']; ?></span></td>
                                <td><?php echo $rows['hm1']>4?'大':'小'; ?></td>
                                <td><?php echo fmod($rows['hm1'], 2)==0?'双':'单'; ?></td>
                                <td><span class="icon ball"><?php echo $rows['hm2']; ?></span></td>
                                <td><?php echo $rows['hm2']>4?'大':'小'; ?></td>
                                <td><?php echo fmod($rows['hm2'], 2)==0?'双':'单'; ?></td>
                                <td><span class="icon ball"><?php echo $rows['hm3']; ?></span></td>
                                <td><?php echo $rows['hm3']>4?'大':'小'; ?></td>
                                <td><?php echo fmod($rows['hm3'], 2)==0?'双':'单'; ?></td>
                                <td><?php echo $rows['sum']; ?></td>
                                <td><?php echo $rows['sum']>14?'大':'小'; ?></td>
                                <td><?php echo fmod($rows['sum'], 2)==0?'双':'单'; ?></td>
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
