<?php
!defined('IN_LOT') && die('Access Denied');
$params = [':uid' => $LOT['user']['uid'], ':atype' => $LOT['lottery_type']];
$sql    = 'SELECT * FROM `lottery_data` WHERE `uid`=:uid AND `atype`=:atype order by bet_time desc';
$stmt   = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rows         = $stmt->fetchAll();
$lotteryType  = $LOT['lottery_type'];
$contentText=array('3THTX'=>'三同号通选','3LHTX'=>'三连号通选');
$lotteryNames = [
    'jsk3'  => '江苏快3',
    'ahk3'  => '安徽快3',
    'gxk3'  => '广西快3',
    'shk3'  => '上海快3',
    'hbk3'  => '湖北快3',
    'hebk3' => '河北快3',
    'fjk3'  => '福建快3',
    'bjk3'  => '北京快3',
    'gsk3'  => '甘肃快3',
    'gzk3'  => '贵州快3',
    'jlk3'  => '吉林快3',
    'jxk3'  => '江西快3',
    'nmgk3' => '内蒙古快3',
];
?>
<h2 style="text-align:center;color:#6f4d28;font-weight:bold"><?php echo $lotteryNames[$lotteryType] ?></h2>
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
    <?php if($rows){ foreach ($rows as $v) { ?>
        <tr>
            <td>
                <?php
                echo $v['bet_time'].'<br/>'.date('Y-m-d H:i:s',strtotime($v['bet_time'])+12*3600);
                ?>
            </td>
            <td><?= $v['mid'] ?></td>
            <td>
                <?php
                $arr = [];
                $v['btype'] && $arr[] = $v['btype'];
                $v['content'] && $arr[] = isset($contentText[$v['content']])?$contentText[$v['content']]:$v['content'];
                echo implode('/', $arr);

                ?>
            </td>
            <td><?= sprintf('%.2f', $v['odds']) ?></td>
            <td><?= sprintf('%.2f', $v['money']) ?></td>
            <td>
                <?php if($v['bet_ok']==1 && $v['win'] >0){
                    echo sprintf('%.2f', $v['win']);
                }else{
                    echo sprintf('%.2f', 0);
                } ?>
            </td>
            <td><?php if($v['bet_ok']==0){
                    echo "未结算";
                }else if($v['win']>0){
                    echo "<span style='color:#FF0000;'>中奖</span>";
                }else{
                    echo "<span style='color:#FF0000;'>未中奖</span>";
                } ?></td>
        </tr>
    <?php }}?>
    </tbody>
</table>


