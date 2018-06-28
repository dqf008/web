<?php 
session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
if(isset($_GET['type'])&&$_GET['type']=='sports'){
    $k_notice = 'k_notice_ty';
    $k_title = '体育公告';
    $k_url = '<em onclick="window.location.href=\'?type=web\'" style="cursor:pointer">网站公告</em>';
}else{
    $k_notice = 'k_notice';
    $k_title = '网站公告';
    $k_url = '<em onclick="window.location.href=\'?type=sports\'" style="cursor:pointer">体育公告</em>';
}
$sql = 'select add_time,msg from '.$k_notice.' where is_show=1 order by `sort` desc,nid desc limit 0,40';
$query = $mydata1_db->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$k_title?></title>
    <link type="text/css" rel="stylesheet" href="images/noticle.css" />
    <script type="text/javascript" src="../skin/js/jquery-1.7.2.min.js?_=171"></script>
</head>
<body>
<div class="main">
    <div class="top"><h2>
        <span><?=$k_title?></span><?=$k_url?></h2>
    </div>
    <div class="content">
        <div class="warp">
        <?php while ($row = $query->fetch()):
            $row['add_time'] = strtotime($row['add_time']); ?>
            <div class="note">
                <div class="fl date">
                    <span><?=date('d', $row['add_time']); ?></span>
                    <b><?=date('m', $row['add_time']); ?></b>
                </div>
                <div class="note-title">
                    <span class="ellipse"></span>
                    <?=date('Y-m-d H:i:s', $row['add_time'])?>
                </div>
                <div class="note-details">
                    <div class="notes"><p><?=$row['msg']?></p></div>
                </div>
            </div>
        <?php endwhile; ?>        
</div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $(".content").css("height", $(window).height()-51);
        $(window).resize(function(){
            $(".content").css("height", $(window).height()-51);
        });
    });
</script>
</body>
</html>