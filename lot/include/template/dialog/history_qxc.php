<?php
!defined('IN_LOT')&&die('Access Denied');
$sql = 'SELECT * FROM `lottery_k_qxc` WHERE `status`=1 ORDER BY `qishu` DESC LIMIT 50';
$stmt = $mydata1_db->query($sql);
if($stmt->rowCount()>0){
?>
            <div id="history">
                <div id="history_detail">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>期数</th>
                                <th>开奖时间</th>
                                <th>仟位</th>
                                <th>佰位</th>
                                <th>拾位</th>
                                <th>个位</th>
                                <th>分位</th>
                                <th>拾分</th>
                                <th>佰分</th>
                            </tr>
                        </thead>
                        <tbody>
<?php while($rows = $stmt->fetch()){$rows['ball'] = unserialize($rows['value']); ?>                            <tr>
                                <td class="td-hd"><?php echo $rows['qishu']; ?></td>
                                <td><?php echo date('Y-m-d H:i:s', $rows['kaijiang']); ?></td>
<?php foreach($rows['ball'] as $key=>$ball){ ?>                                <td><span class="icon <?php echo $key>3?'red-':''; ?>ball"><?php echo $ball; ?></span></td>
<?php } ?>                            </tr>
<?php } ?>                        </tbody>
                    </table>
                </div>
            </div>
<?php }else{ ?>            <div id="history"><div id="history_detail">暂无数据</div></div>
<?php } ?>            <input type="hidden" id="hid-empty-data" value="暂无数据"/>
            <script>
                require(['dialog-index'], function (Account) {new Account()});
                require(['history'], function (App) {new App({lotteryId: '<?php echo $LOT['l']; ?>', hide: true})});
            </script>
