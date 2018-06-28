<?php
!defined('IN_LOT')&&die('Access Denied');
function SSC($num){
    sort($num);
    $a = implode('', $num);
    if($num[0]==$num[1]&&$num[0]==$num[2]&&$num[1]==$num[2]){
        return '豹子';
    }else if($num[0]==$num[1]||$num[0]==$num[2]||$num[1]==$num[2]){
        return '对子';
    }else if($a == '019'||$a == '089'||sorts($num, 3)){
        return '顺子';
    }else if(preg_match('/0\d9/', $a)||sorts($num, 2)){
        return '半顺';
    }else{
        return '杂六';
    }
}
function sorts($a, $p){
    $i = 0;
    foreach($a as $k=>$v){
        if(in_array((($v+10)-1)%10, $a)||in_array(($v+1)%10, $a)){
            $i++;
        }
    }

    if($p<=$i){
        $a = true;
    }else{
        $a = false;
    }
    return $a;
}
$params = array(':qtime' => date('Y-m-d 00:00:00', $qtime), ':etime' => date('Y-m-d 23:59:59', $qtime));
$sql = 'SELECT * FROM `c_auto_2` WHERE `datetime`>=:qtime AND `datetime`<=:etime ORDER BY `qishu` DESC';
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
                                <th colspan="3">总和</th>
                                <th>龙虎和</th>
                                <th>前三</th>
                                <th>中三</th>
                                <th>后三</th>
                            </tr>
                        </thead>
                        <tbody>
<?php while($rows = $stmt->fetch()){$rows['ball_0'] = 0; ?>                            <tr>
                                <td class="td-hd"><?php echo $rows['qishu']; ?></td>
                                <td><?php echo $rows['datetime']; ?></td>
                                <td>
<?php for($i=1;$i<=5;$i++){$rows['ball_0']+= $rows['ball_'.$i]; ?>                                    <span class="icon ball"><?php echo $rows['ball_'.$i]; ?></span>
<?php } ?>                                </td>
                                <td><?php echo $rows['ball_0']; ?></td>
                                <td><?php echo $rows['ball_0']>22?'大':'小'; ?></td>
                                <td><?php echo fmod($rows['ball_0'], 2)==0?'双':'单'; ?></td>
                                <td><?php echo $rows['ball_1']==$rows['ball_5']?'和':($rows['ball_1']>$rows['ball_5']?'龙':'虎'); ?></td>
                                <td><?php echo SSC(array($rows['ball_1'], $rows['ball_2'], $rows['ball_3'])); ?></td>
                                <td><?php echo SSC(array($rows['ball_4'], $rows['ball_2'], $rows['ball_3'])); ?></td>
                                <td><?php echo SSC(array($rows['ball_4'], $rows['ball_5'], $rows['ball_3'])); ?></td>
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
