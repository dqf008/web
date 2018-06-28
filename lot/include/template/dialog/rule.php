<?php
!defined('IN_LOT')&&die('Access Denied');
$LOT['l'] = isset($_GET['lotteryId'])?$_GET['lotteryId']:'default';
$LOT['l'] = isset($LOT['game'][$LOT['l']])?$LOT['l']:key($LOT['game']);
$l = $LOT['l'];
$k3LotteryName = ['jsk3', 'ynk3', 'fjk3', 'gxk3', 'jxk3', 'shk3', 'hebk3', 'hbk3', 'ffk3', 'sfk3', 'ahk3', 'jlk3', 'hnk3', 'gzk3', 'bjk3', 'qhk3', 'gsk3', 'nmgk3'];
if (in_array($LOT['l'], $k3LotteryName)) {
    $LOT['lottery_type'] = $LOT['l'];
    $l='k3';
}
?>
        <div id="tab" class="tab-colored" data-wdiget="tab" data-current="<?php echo $LOT['l']; ?>">
            <div class="tab-colored-hd mb10 hide">
                <span class="tab-colored-item" data-id="<?php echo $LOT['lottery_type']; ?>"></span>
            </div>
<?php include(IN_LOT.'include/template/dialog/rule_'.$l.'.php'); ?>        </div>
        <script>require(['dialog-index'], function(Account){new Account()})</script>
