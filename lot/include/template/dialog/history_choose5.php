<?php
!defined('IN_LOT')&&die('Access Denied');
$lotteryType = isset($LOT['lottery_type'])?$LOT['lottery_type']:'gdchoose5';
$params = array(':qtime' => date('Y-m-d 00:00:00', $qtime), ':etime' => date('Y-m-d 23:59:59', $qtime),':name'=>$lotteryType);
$sql = 'SELECT * FROM `c_auto_choose5` WHERE `datetime`>=:qtime AND `datetime`<=:etime and `name`=:name ORDER BY `qishu` DESC';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
//var_dump($stmt);die();
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
                                <th colspan="3">总和</th>
<!--                                <th colspan="4">龙虎斗</th>-->
                            </tr>
                        </thead>
                        <tbody>
<?php while($rows = $stmt->fetch()){$rows['ball_0'] = 0; ?>                            <tr>
                                <td class="td-hd"><?php echo $rows['qishu']; ?></td>
                                <td><?php echo $rows['datetime']; ?></td>
                                <td>
<?php for($i=1;$i<=5;$i++){$rows['ball_0']+= $rows['ball_'.$i]; ?>                                    <span class="icon ball ball-<?php echo $rows['ball_'.$i]; ?>"><?php echo $rows['ball_'.$i]; ?></span>
<?php } ?>                                </td>
                                <td><?php echo $rows['ball_0']; ?></td>
                                <td><?php echo fmod($rows['ball_0'], 2)==0?'双':'单'; ?></td>
                                <td><?php echo ($rows['ball_0']==30 || $rows['ball_0']==31)?'和':($rows['ball_0']>31?'大':'小'); ?></td>


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
