<?php
!defined('IN_LOT')&&die('Access Denied');
/* 波色信息 */
$LOT['color'] = array(
    1 => 'red',
    2 => 'red',
    3 => 'blue',
    4 => 'blue',
    5 => 'green',
    6 => 'green',
    7 => 'red',
    8 => 'red',
    9 => 'blue',
    10 => 'blue',
    11 => 'green',
    12 => 'red',
    13 => 'red',
    14 => 'blue',
    15 => 'blue',
    16 => 'green',
    17 => 'green',
    18 => 'red',
    19 => 'red',
    20 => 'blue',
    21 => 'green',
    22 => 'green',
    23 => 'red',
    24 => 'red',
    25 => 'blue',
    26 => 'blue',
    27 => 'green',
    28 => 'green',
    29 => 'red',
    30 => 'red',
    31 => 'blue',
    32 => 'green',
    33 => 'green',
    34 => 'red',
    35 => 'red',
    36 => 'blue',
    37 => 'blue',
    38 => 'green',
    39 => 'green',
    40 => 'red',
    41 => 'blue',
    42 => 'blue',
    43 => 'green',
    44 => 'green',
    45 => 'red',
    46 => 'red',
    47 => 'blue',
    48 => 'blue',
    49 => 'green',
);
$color = array(
    'red' => '红',
    'green' => '绿',
    'blue' => '蓝',
);
$sql = 'SELECT * FROM `mydata2_db`.`ka_kithe` WHERE `na`>0 ORDER BY `nn` DESC LIMIT 50';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute();
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
                                <th width="30">总和</th>
                                <th width="30">总和单双</th>
                                <th width="30">总和大小</th>
                                <th width="30">特码单双</th>
                                <th width="30">特码大小</th>
                                <th width="30">合数单双</th>
                                <th width="30">特码波色</th>
                            </tr>
                        </thead>
                        <tbody>
<?php while($rows = $stmt->fetch()){
    $rows['sum'] = $rows['n1']+$rows['n2']+$rows['n3']+$rows['n4']+$rows['n5']+$rows['n6']+$rows['na'];
    $rows['s'] = substr('00'.$rows['na'], -2);
    $rows['s'] = substr($rows['s'], 0, 1)+substr($rows['s'], -1);
?>                            <tr>
                                <td class="td-hd"><?php echo $rows['nn']; ?></td>
                                <td><?php echo date('Y-m-d<b\r />H:i:s', strtotime($rows['nd'])); ?></td>
                                <td align="center">
                                    <table class="table-noborder">
                                        <tr>
                                            <td align="center"><span class="icon ball-style b-<?php echo $LOT['color'][$rows['n1']]; ?>"><?php echo $rows['n1']; ?></span></td>
                                            <td align="center"><span class="icon ball-style b-<?php echo $LOT['color'][$rows['n2']]; ?>"><?php echo $rows['n2']; ?></span></td>
                                            <td align="center"><span class="icon ball-style b-<?php echo $LOT['color'][$rows['n3']]; ?>"><?php echo $rows['n3']; ?></span></td>
                                            <td align="center"><span class="icon ball-style b-<?php echo $LOT['color'][$rows['n4']]; ?>"><?php echo $rows['n4']; ?></span></td>
                                            <td align="center"><span class="icon ball-style b-<?php echo $LOT['color'][$rows['n5']]; ?>"><?php echo $rows['n5']; ?></span></td>
                                            <td align="center"><span class="icon ball-style b-<?php echo $LOT['color'][$rows['n6']]; ?>"><?php echo $rows['n6']; ?></span></td>
                                            <td align="center"><span class="icon ball-style b-<?php echo $LOT['color'][$rows['na']]; ?>"><?php echo $rows['na']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td align="center"><?php echo $rows['x1']; ?></td>
                                            <td align="center"><?php echo $rows['x2']; ?></td>
                                            <td align="center"><?php echo $rows['x3']; ?></td>
                                            <td align="center"><?php echo $rows['x4']; ?></td>
                                            <td align="center"><?php echo $rows['x5']; ?></td>
                                            <td align="center"><?php echo $rows['x6']; ?></td>
                                            <td align="center"><span class="red"><?php echo $rows['sx']; ?></span></td>
                                        </tr>
                                    </table>
                                </td>
                                <td><?php echo $rows['sum']; ?></td>
                                <td><?php echo fmod($rows['sum'], 2)==0?'双':'单'; ?></td>
                                <td><?php echo $rows['sum']>174?'大':'小'; ?></td>
                                <td><?php echo $rows['na']==49?'和':(fmod($rows['na'], 2)==0?'双':'单'); ?></td>
                                <td><?php echo $rows['na']==49?'和':($rows['na']>24?'大':'小'); ?></td>
                                <td><?php echo $rows['na']==49?'和':(fmod($rows['s'], 2)==0?'双':'单'); ?></td>
                                <td><?php echo $color[$LOT['color'][$rows['na']]]; ?></td>
<?php } ?>                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
<?php }else{ ?>            <div id="history"><div id="history_detail">暂无数据</div></div>
<?php } ?>            <input type="hidden" id="hid-empty-data" value="暂无数据"/>
            <script>
                require(['dialog-index'], function (Account) {new Account()});
                require(['history'], function (App) {new App({lotteryId: '<?php echo $LOT['l']; ?>', hide: true})});
            </script>
