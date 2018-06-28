<?php
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cpgl');
check_quanxian('cppl');
$type = $_REQUEST['type'];
$save = $_REQUEST['save'];
if ($type == ''){
    $type = 1;
}
$lotteryType = $_GET['lottery_type'];
$lotteryNames = array('gdchoose5'=>'广东11选5','sdchoose5'=>'山东11选5','fjchoose5'=>'福建11选5','bjchoose5'=>'北京11选5','ahchoose5'=>'安徽11选5','yfchoose5'=>'一分11选5','sfchoose5'=>'三分11选5');

$type == '1' ? $se1 = '#FF0' : $se1 = '#FFF';
$type == '2' ? $se2 = '#FF0' : $se2 = '#FFF';
$type == '3' ? $se3 = '#FF0' : $se3 = '#FFF';
$type == '4' ? $se4 = '#FF0' : $se4 = '#FFF';
$type == '5' ? $se5 = '#FF0' : $se5 = '#FFF';
$type == '6' ? $se6 = '#FF0' : $se6 = '#FFF';
$type == '7' ? $se7 = '#FF0' : $se7 = '#FFF';
$type == '8' ? $se8 = '#FF0' : $se8 = '#FFF';
$type == '9' ? $se9 = '#FF0' : $se9 = '#FFF';
$type == '10' ? $se10 = '#FF0' : $se10 = '#FFF';
$type == '11' ? $se11 = '#FF0' : $se11 = '#FFF';
$type == '12' ? $se12 = '#FF0' : $se12 = '#FFF';
$type == '13' ? $se13 = '#FF0' : $se13 = '#FFF';
$type == '14' ? $se14 = '#FF0' : $se14 = '#FFF';
$type == '15' ? $se15 = '#FF0' : $se15 = '#FFF';
$type == '16' ? $se16 = '#FF0' : $se16 = '#FFF';
$type == '17' ? $se17 = '#FF0' : $se17 = '#FFF';
if ($save == 'ok'){
    if ($type !=6 && $type <8){
        $params = array(':h1' => $_REQUEST['Num_1'], ':h2' => $_REQUEST['Num_2'], ':h3' => $_REQUEST['Num_3'], ':h4' => $_REQUEST['Num_4'], ':h5' => $_REQUEST['Num_5'], ':h6' => $_REQUEST['Num_6'], ':h7' => $_REQUEST['Num_7'], ':h8' => $_REQUEST['Num_8'], ':h9' => $_REQUEST['Num_9'], ':h10' => $_REQUEST['Num_10'], ':h11' => $_REQUEST['Num_11'], ':h12' => $_REQUEST['Num_12'], ':h13' => $_REQUEST['Num_13'], ':h14' => $_REQUEST['Num_14'], ':h15' => $_REQUEST['Num_15'], ':type' => 'ball_' . $type,':name'=>$lotteryType);
        $sql = 'update c_odds_choose5 set h1=:h1,h2=:h2,h3=:h3,h4=:h4,h5=:h5,h6=:h6,h7=:h7,h8=:h8,h9=:h9,h10=:h10,h11=:h11,h12=:h12,h13=:h13,h14=:h14,h15=:h15 where type=:type and `name`=:name';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        echo "<script>alert(\"赔率修改完毕！\");window.open('odds_choose5.php?lottery_name=".$lotteryType."&type=".$type."','mainFrame');</script>";
        exit();
    }

    if ($type == 6){
        $params = array(':h1' => $_REQUEST['Num_1'], ':h2' => $_REQUEST['Num_2'], ':h3' => $_REQUEST['Num_3'], ':h4' => $_REQUEST['Num_4'],  ':type' => 'ball_' . $type,':name'=>$lotteryType);
        $sql = 'update c_odds_choose5 set h1=:h1,h2=:h2,h3=:h3,h4=:h4 where type=:type and `name`=:name';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        echo "<script>alert(\"赔率修改完毕！\");window.open('odds_choose5.php?lottery_name=".$lotteryType."&type=".$type." ','mainFrame');</script>";
        exit();
    }
    if ($type >= 8){
        $params = array(':h1' => $_REQUEST['Num_1'], ':h2' => $_REQUEST['Num_2'], ':type' => 'ball_' . $type,':name'=>$lotteryType);
        $sql = 'update c_odds_choose5 set h1=:h1,h2=:h2 where type=:type and `name`=:name';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        echo "<script>alert(\"赔率修改完毕！\");window.open('odds_choose5.php?lottery_name=".$lotteryType."&type=".$type."','mainFrame');</script>";
        exit();
    }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Welcome</title>
    <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" />
</head>
<script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script>
<script type="text/javascript">
    //读取当前期数盘口赔率与投注总额
    function loadinfo(){
        $.post("get_odds_choose5.php", {type :<?=$type;?>,lottery_type:<?php echo '"'.$lotteryType.'"'?>}, function(data)
        {
            for(var key in data.oddslist){
                odds = data.oddslist[key];
                $("#Num_"+key).val(odds);
            }
        }, "json");
    }
    function UpdateRate(num ,i){
        $.post("updaterate_choose5.php", {type :<?=$type;?>,num : num ,i : i,lottery_type:<?php echo '"'.$lotteryType.'"'?>}, function(data)
        {
            odds = data.oddslist[num];
            xodds = $("#Num_"+num).val();
            if(odds != xodds){
                $("#Num_"+num).css("color","red");
            }
            $("#Num_"+num).val(odds);
        }, "json");
    }
</script>
<body>
<div id="pageMain">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td valign="top">
                <?php include_once 'Menu_Odds.php';?>
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
                    <tr>
                        <td align="center" bgcolor="#3C4D82" style="color:#FFF">
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=1" style="color:<?=$se1;?>;font-weight:bold;">第一球</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=2" style="color:<?=$se2;?>;font-weight:bold;">第二球</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=3" style="color:<?=$se3;?>;font-weight:bold;">第三球</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=4" style="color:<?=$se4;?>;font-weight:bold;">第四球</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=5" style="color:<?=$se5;?>;font-weight:bold;">第五球</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=6" style="color:<?=$se6;?>;font-weight:bold;">总和</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=7" style="color:<?=$se7;?>;font-weight:bold;">全五中一</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=8" style="color:<?=$se8;?>;font-weight:bold;">正码一VS正码二龙虎</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=9" style="color:<?=$se9;?>;font-weight:bold;">正码一VS正码三龙虎</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=10" style="color:<?=$se10;?>;font-weight:bold;">正码一VS正码四龙虎</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=11" style="color:<?=$se11;?>;font-weight:bold;">正码一VS正码五龙虎</a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" bgcolor="#3C4D82" style="color:#FFF">
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=12" style="color:<?=$se12;?>;font-weight:bold;">正码二VS正码三龙虎</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=13" style="color:<?=$se13;?>;font-weight:bold;">正码二VS正码四龙虎</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=14" style="color:<?=$se14;?>;font-weight:bold;">正码二VS正码五龙虎</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=15" style="color:<?=$se15;?>;font-weight:bold;">正码三VS正码四龙虎</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=16" style="color:<?=$se16;?>;font-weight:bold;">正码三VS正码五龙虎</a>
                            <a href="?lottery_type=<?php echo $lotteryType?>&type=17" style="color:<?=$se17;?>;font-weight:bold;">正码四VS正码五龙虎</a>
                        </td>
                    </tr>
                </table>
                <?php if ($type!=6 && $type < 8){?>
                    <table border="0"align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                        <form name="form1" method="post" action="?lottery_type=<?echo $lotteryType;?>&type=<?=$type;?>&save=ok">
                            <tr style="background-color:#3C4D82;color:#FFF">
                                <td width="50" height="22" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                                <td width="50" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                                <td width="50" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                                <td width="50" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                                <td width="50" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                            </tr>
                            <tr>
                                <td height="28" align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/01.png" /></td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('1','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_1" id="Num_1" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('1','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/02.png" /></td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('2','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_2" id="Num_2" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('2','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/03.png" /></td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('3','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_3" id="Num_3" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('3','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/04.png" /></td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('4','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_4" id="Num_4" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('4','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/05.png" /></td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('5','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_5" id="Num_5" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('5','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td height="28" align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/06.png" /></td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('6','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_6" id="Num_6" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('6','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/07.png" /></td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('7','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_7" id="Num_7" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('7','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/08.png" /></td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('8','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_8" id="Num_8" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('8','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/09.png" /></td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('9','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_9" id="Num_9" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('9','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/10.png" /></td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('10','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_10" id="Num_10" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('10','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td height="28" align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/11.png" /></td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('11','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_11" id="Num_11" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('11','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td height="28" align="center"bgcolor="#FFFFFF">大</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('21','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_21" id="Num_21" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('21','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF">小</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('22','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_22" id="Num_22" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('22','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF">单</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('23','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_23" id="Num_23" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('23','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF">双</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('24','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_24" id="Num_24" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('24','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                            <tr>
                                <td height="28" colspan="10" align="center"bgcolor="#FFFFFF"><input type="submit"  class="submit80" name="Submit" value="确认修改" /></td>
                            </tr></form>
                    </table>
                <?php }else if ($type == 4){?>
                    <table border="0"align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                        <form name="form1" method="post" action="?lottery_type=<?=$lotteryType;?>&type=<?=$type;?>&save=ok">
                            <tr style="background-color:#3C4D82;color:#FFF">
                                <td width="50" height="22" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                                <td width="50" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                                <td width="50" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                                <td width="50" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                            </tr>
                            <tr>
                                <td height="28" align="center"bgcolor="#FFFFFF">总和大</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('1','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_1" id="Num_1" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('1','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF">总和小</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('2','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_2" id="Num_2" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('2','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF">总和单</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('3','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_3" id="Num_3" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('3','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF">总和双</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('4','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_4" id="Num_4" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('4','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td height="28" colspan="8" align="center"bgcolor="#FFFFFF"><input type="submit"  class="submit80" name="Submit" value="确认修改" /></td>
                            </tr></form>
                    </table>
                <?php }else if ($type == 6){?>
                    <table border="0"align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                        <form name="form1" method="post" action="?lottery_type=<?=$lotteryType;?>&type=<?=$type;?>&save=ok">
                            <tr style="background-color:#3C4D82;color:#FFF">
                                <td width="50" height="22" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                                <td width="50" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                                <td width="50" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                                <td width="50" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                            </tr>
                            <tr>
                                <td height="28" align="center"bgcolor="#FFFFFF">总和大</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('1','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_1" id="Num_1" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('1','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF">总和小</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('2','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_2" id="Num_2" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('2','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF">总和单</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('3','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_3" id="Num_3" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('3','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF">总和双</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('4','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_4" id="Num_4" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('4','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td height="28" colspan="8" align="center"bgcolor="#FFFFFF"><input type="submit"  class="submit80" name="Submit" value="确认修改" /></td>
                            </tr></form>
                    </table>
                <?php }else if ($type >=8){?>
                    <table border="0"align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                        <form name="form1" method="post" action="?lottery_type=<?=$lotteryType;?>&type=<?=$type;?>&save=ok">
                            <tr style="background-color:#3C4D82;color:#FFF">
                                <td width="50" height="22" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                                <td width="50" align="center"><strong>号码</strong></td>
                                <td align="center"><strong>当前赔率</strong></td>
                            </tr>
                            <tr>
                                <td height="28" align="center"bgcolor="#FFFFFF">龙</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('1','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_1" id="Num_1" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('1','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                                <td align="center"bgcolor="#FFFFFF">虎</td>
                                <td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3">
                                        <tr>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('2','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td>
                                            <td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_2" id="Num_2" /></td>
                                            <td align="center"><a style="cursor:hand" onClick="UpdateRate('2','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td height="28" colspan="8" align="center"bgcolor="#FFFFFF"><input type="submit"  class="submit80" name="Submit" value="确认修改" /></td>
                            </tr></form>
                    </table>
                <?php }?>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">loadinfo();</script>
</body>
</html>