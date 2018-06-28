<?php
!defined('IN_LOT')&&die('Access Denied');
$qtime = date('Y-m-d', $qtime);
$page = isset($_GET['page'])&&preg_match('/^[1-9]\d*$/', $_GET['page'])?$_GET['page']:1;
$limit = 48;
$params = array(':type' => 'JSLH', ':qtime' => strtotime($qtime.' 00:00:00'), ':etime' => strtotime($qtime.' 23:59:59'));
$sql = 'SELECT COUNT(*) AS `count` FROM `c_auto_data` WHERE `type`=:type AND `qishu` BETWEEN :qtime AND :etime AND `status` BETWEEN 0 AND 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$count = $stmt->fetch();
$count = $count['count'];
if($count>0){
    $count = ceil($count/$limit);
    $page>$count&&$page = $count;
    if($count>11){
        $start = $page-5;
        $end = $page+5;
        if($start<1){
            $start = 1;
            $end = $start+10;
        }else if($end>$count){
            $end = $count;
            $start = $end-10;
        }
    }else{
        $start = 1;
        $end = $count;
    }
    $params[':limit'] = $limit;
    $params[':index'] = ($page-1)*$limit;
    $sql = 'SELECT * FROM `c_auto_data` WHERE `type`=:type AND `qishu` BETWEEN :qtime AND :etime AND `status` BETWEEN 0 AND 1 ORDER BY `qishu` DESC LIMIT :index, :limit';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
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
<?php
while($rows = $stmt->fetch()){
    $rows['value'] = unserialize($rows['value']);
?>                            <tr>
                                <td class="td-hd"><?php echo $rows['value']['qishu']; ?></td>
                                <td><?php echo date('Y-m-d<b\r />H:i:s', $rows['opentime']); ?></td>
                                <td align="center">
                                    <table class="table-noborder">
                                        <tr>
<?php foreach($rows['value']['opencode'] as $key=>$ball){ ?>                                            <td align="center"><span class="icon ball-style s-<?php echo $rows['value']['color'][$key]; ?>"><?php echo substr('00'.$ball, -2); ?></span></td>
<?php } ?>                                        </tr>
                                        <tr>
<?php foreach($rows['value']['animal'] as $key=>$animal){ ?>                                            <td align="center"><?php echo $key>=6?'<span class="red">'.$animal.'</span>':$animal; ?></td>
<?php } ?>                                        </tr>
                                    </table>
                                </td>
<?php foreach($rows['value']['info'] as $info){ ?>                                <td><?php echo $info; ?></td>
<?php } ?>                            </tr>
<?php } ?>                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pager">
<?php if($page==1){ ?>                <span class="disabled">首页</span>
                <span class="disabled">上一页</span>
<?php }else{ ?>                <a href="?i=<?php echo $LOT['i'].'&lotteryId='.$LOT['l'].'&date='.$qtime ?>">首页</a>
                <a href="?i=<?php echo $LOT['i'].'&lotteryId='.$LOT['l'].'&date='.$qtime.'&page='.($page-1) ?>">上一页</a>
<?php }if($count>11&&$page>6){ ?>                <span class="spacer">...</span>
<?php }for($i=$start;$i<=$end;$i++){if($i==$page){ ?>                <span class="current"><?php echo $i; ?></span>
<?php }else{ ?>                <a href="?i=<?php echo $LOT['i'].'&lotteryId='.$LOT['l'].'&date='.$qtime.'&page='.$i ?>"><?php echo $i; ?></a>
<?php }}if($count>11&&$count-$page>5){ ?>                <span class="spacer">...</span>
<?php }if($page==$count){ ?>                <span class="disabled">下一页</span>
                <span class="disabled">尾页</span>
<?php }else{ ?>                <a href="?i=<?php echo $LOT['i'].'&lotteryId='.$LOT['l'].'&date='.$qtime.'&page='.($page+1) ?>">下一页</a>
                <a href="?i=<?php echo $LOT['i'].'&lotteryId='.$LOT['l'].'&date='.$qtime.'&page='.$count ?>">尾页</a>
<?php } ?>            </div>
<?php }else{ ?>            <div id="history"><div id="history_detail">暂无数据</div></div>
<?php } ?>            <input type="hidden" id="hid-empty-data" value="暂无数据"/>
            <script>
                require(['dialog-index'], function (Account) {new Account()});
                require(['history'], function (App) {new App({lotteryId: '<?php echo $LOT['l']; ?>', refresh: true})});
            </script>
