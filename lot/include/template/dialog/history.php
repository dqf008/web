<?php
!defined('IN_LOT') && die('Access Denied');
$qtime = isset($_GET['date']) && preg_match('/^\d{4}\-\d{1,2}\-\d{1,2}$/', $_GET['date']) ? strtotime($_GET['date']) : $LOT['bjtime'];

?>
    <div class="tab tab-dialog">
    <form class="search-form mb10" action="dialog.php?i=history" method="POST" id="q-form">
        <input type="text" value="<?php echo date('Y-m-d', $qtime) ?>" class="input j-datepicker mr10" name="date"
               readonly="readonly"/>
        <span class="select-menu" id="q-id">
                    <span class="q-val"></span>
                    <input type="hidden" id="q-hidden-val" name="lotteryId" value=""/>
                    <ul class="select-options">
<?php foreach ($LOT['game'] as $key => $val) { ?>
    <li><a href="javascript:;" data-id="<?php echo $key; ?>"><?php echo $val; ?></a></li>
<?php } ?>                        </ul>
                    <span class="triangle"></span>
                </span>
        <button class="button" id="q">查询</button>
        <span id="loading" class="red hide">正在加载中...</span>
    </form>
<?php
$LOT['l']      = isset($_GET['lotteryId']) ? $_GET['lotteryId'] : 'default';
$l  = $LOT['l'];
$k3LotteryName = ['jsk3', 'ynk3', 'fjk3', 'gxk3', 'jxk3', 'shk3', 'hebk3', 'hbk3', 'ahk3', 'jlk3', 'hnk3', 'gzk3', 'bjk3', 'qhk3', 'gsk3', 'nmgk3'];
if (in_array($LOT['l'], $k3LotteryName)) {
    $LOT['lottery_type'] = $LOT['l'];
    $l='k3';
}
$choose5LotteryName = ['gdchoose5', 'sdchoose5', 'fjchoose5', 'bjchoose5', 'ahchoose5', 'yfchoose5', 'sfchoose5'];
if (in_array($LOT['l'], $choose5LotteryName)) {
    $LOT['lottery_type'] = $LOT['l'];
    $l='choose5';
}
if (isset($LOT['game'][$LOT['l']])) {
    include(IN_LOT . 'include/template/dialog/' . $LOT['i'] . '_' . $l . '.php');
} else {
    echo '            <div id="history"><div id="history_detail">Access Denied</div></div>' . PHP_EOL;
}
echo '        </div>' . PHP_EOL;