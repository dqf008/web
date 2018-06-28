<?php
$_nav = array();
$_nav[] = array(
    'sports.php' => '体育赛事',
    '6hc.php' => '六合彩',
    'ssc.php' => '重庆时时彩',
    'ssl.php' => '上海时时乐',
    'xync.php' => '幸运农场',
    'bjsc.php' => '北京ＰＫ拾',
);
$_nav[] = array(
    '3d.php' => '福彩３Ｄ',
    'pl3.php' => '排列三',
    'klsf.php' => '广东１０分',
    'kl8.php' => '北京快乐８',
    'xyft.php' => '幸运飞艇',
    'xy28.php' => '幸运２８',
);
foreach($_nav as $val){
?>        <div id="qa_nav">
            <ul>
<?php foreach($val as $url=>$title){ ?>                <li class="<?php echo strpos($_SERVER['REQUEST_URI'], $url)?'sport':'rule'; ?>"><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
<?php } ?>            </ul>
        </div>
<?php } ?>