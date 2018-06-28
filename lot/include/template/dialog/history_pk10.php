<?php
!defined('IN_LOT')&&die('Access Denied');
$params = array(':qtime' => date('Y-m-d 00:00:00', $qtime), ':etime' => date('Y-m-d 23:59:59', $qtime));
$sql = 'SELECT * FROM `c_auto_4` WHERE `datetime`>=:qtime AND `datetime`<=:etime ORDER BY `qishu` DESC';
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
                                <th>开奖号码</th>
                                <th colspan="3">冠亚和</th>
                                <th colspan="5">龙虎斗</th>
                            </tr>
                        </thead>
                        <tbody>
<?php while($rows = $stmt->fetch()){$rows['ball_0'] = $rows['ball_1']+$rows['ball_2']; ?>                            <tr>
                                <td class="td-hd"><?php echo $rows['qishu']; ?></td>
                                <td><?php echo $rows['datetime']; ?></td>
                                <td class="hide-icon-text">
<?php for($i=1;$i<=10;$i++){ ?>                                    <span class="icon bj<?php echo $rows['ball_'.$i]; ?>">&nbsp;</span>
<?php } ?>                                </td>
                                <td><?php echo $rows['ball_0']; ?></td>
                                <td><?php echo $rows['ball_0']==11?'和':($rows['ball_0']>11?'大':'小'); ?></td>
                                <td><?php echo $rows['ball_0']==11?'和':(fmod($rows['ball_0'], 2)==0?'双':'单'); ?></td>
                                <td><?php echo $rows['ball_1']>$rows['ball_10']?'龙':'虎'; ?></td>
                                <td><?php echo $rows['ball_2']>$rows['ball_9']?'龙':'虎'; ?></td>
                                <td><?php echo $rows['ball_3']>$rows['ball_8']?'龙':'虎'; ?></td>
                                <td><?php echo $rows['ball_4']>$rows['ball_7']?'龙':'虎'; ?></td>
                                <td><?php echo $rows['ball_5']>$rows['ball_6']?'龙':'虎'; ?></td>
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
