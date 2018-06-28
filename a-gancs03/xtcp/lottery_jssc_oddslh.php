<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('cpgl');
check_quanxian('cppl');

$action = isset($_POST['action']) ? $_POST['action'] : 'default';

if($action=='save'){
    $_return = array();
    $data = isset($_POST['data'])&&is_array($_POST['data'])?$_POST['data']:array();
    $_return['status'] = 0;
    foreach($data as $id=>$val){
        $id = intval($id);
        if($id>0&&is_array($val)){
            $params = array(
                ':id' => $id,
                ':type' => 'JSSC',
                ':value' => serialize(array(
                    1 => array(
                        'class' => '龙',
                        'odds' => getFloat($val, 1),
                    ),
                    2 => array(
                        'class' => '虎',
                        'odds' => getFloat($val, 2),
                    ),
                )),
            );
            $stmt = $mydata1_db->prepare('UPDATE `c_odds_data` SET `value`=:value WHERE `id`=:id AND `type`=:type');
            $stmt->execute($params)&&$_return['status']++;
        }
    }
    $_return['status'] = $_return['status']>0?'success':'failed';
    admin::insert_log($_SESSION['adminid'], '修改[极速赛车]赔率信息');
    exit(json_encode($_return));
}

function getFloat($v, $t){
    return isset($v[$t])&&is_numeric($v[$t])&&$v[$t]>0?floatval($v[$t]):0;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Welcome</title>
    <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" />
    <style type="text/css">
        .menu_curr {color:#FF0;font-weight:bold} 
        .menu_com {color:#FFF;font-weight:bold} 
        .sub_curr {color:#f00;font-weight:bold} 
        .sub_com {color:#333;font-weight:bold} 
    </style>
    <script type="text/javascript" charset="utf-8" src="/js/jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("tr[data-id] td").map(function(){
                $(this).on("click", "a", function(){
                    var e = $(this).siblings("input"), v = e.val(), l = v.split(".");
                    l = l.length<=1 ? 1 : l[1].length,
                    v = parseFloat(v=="" ? 0 : v),
                    e.val(($(this).index()==0 ? (v-= 0.1, v <= 0 ? 0 : v) : (v+=0.1, v)).toFixed(v<=0 ? 0 : l))
                })
            });
            $("input[type=button]").on("click", function(){
                var data = {}, t = $(this);
                t.attr("disabled", true).val("正在保存");
                $("tr[data-id]").map(function(){
                    var e = $(this), k = e.data("id"), v = e.find("input");
                    data[k] = {
                        1: v.eq(0).val(),
                        2: v.eq(1).val()
                    }
                });
                $.post("<?php echo basename(__FILE__); ?>", {action: "save", data: data}, function(data){
                    if(data["status"]=="success"){
                        alert("保存成功！");
                    }else{
                        alert("保存失败！");
                    }
                    t.attr("disabled", false).val("保存赔率");
                }, "json");
            })
        });
    </script>
</head>
<body>
    <div id="pageMain">
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
                <td valign="top">
                    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
                        <tr>
                            <td align="center" bgcolor="#3C4D82" style="color:#FFF">
                                <a id="ssc03" href="lottery_jssc_odds.php" class="menu_curr">极速赛车</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc01" href="lottery_jsssc_odds.php" class="menu_com">极速时时彩</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc02" href="lottery_jslh_odds.php" class="menu_com">极速六合</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc02" href="lottery_ffk3_odds.php" class="menu_com">分分快3</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc05" href="lottery_sfk3_odds.php" class="menu_com">超级快3</a>  -
                                <a id="ssc05" href="lottery_wfk3_odds.php" class="menu_com">好运快3</a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" bgcolor="#FFFFFF" style="color:#000"><a href="lottery_jssc_odds.php?type=1" class="sub_com">冠、亚军和</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jssc_odds.php?type=2" class="sub_com">冠军</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jssc_odds.php?type=3" class="sub_com">亚军</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jssc_odds.php?type=4" class="sub_com">第三名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jssc_odds.php?type=5" class="sub_com">第四名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jssc_odds.php?type=6" class="sub_com">第五名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jssc_odds.php?type=7" class="sub_com">第六名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jssc_odds.php?type=8" class="sub_com">第七名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jssc_odds.php?type=9" class="sub_com">第八名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jssc_odds.php?type=10" class="sub_com">第九名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jssc_odds.php?type=11" class="sub_com">第十名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jssc_oddslh.php" class="sub_curr">龙虎斗</a></td>
                        </tr>
                    </table>
                    <table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                        <tr style="background-color:#3C4D82;color:#FFF">
                            <td height="22" align="center" width="20%"><strong>玩法</strong></td>
                            <td height="22" align="center" width="20%"><strong>选项</strong></td>
                            <td height="22" align="center" width="20%"><strong>赔率</strong></td>
                            <td height="22" align="center" width="20%"><strong>选项</strong></td>
                            <td height="22" align="center" width="20%"><strong>赔率</strong></td>
                        </tr>
<?php
$class = [
    12 => '1V10 龙虎',
    13 => '2V9 龙虎',
    14 => '3V8 龙虎',
    15 => '4V7 龙虎',
    16 => '5V6 龙虎',
];
$stmt = $mydata1_db->prepare('SELECT `id`, `class`, `value` FROM `c_odds_data` WHERE `type`=:type AND `class` BETWEEN 12 AND 16 ORDER BY `id` ASC');
$stmt->execute(array(':type' => 'JSSC'));
while($rows = $stmt->fetch()){
    $rows['value'] = unserialize($rows['value']);
?>                        <tr onmouseover="this.style.backgroundColor='#EBEBEB'" onmouseout="this.style.backgroundColor='#ffffff'" style="background-color:#FFFFFF;line-height:20px;" data-id="<?php echo $rows['id']; ?>">
                            <td height="28" align="center"><?php echo $class[$rows['class']]; ?></td> 
                            <td height="28" align="center"><?php echo $rows['value'][1]['class']; ?></td> 
                            <td height="28" align="center">
                                <a href="javascript:;"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a>
                                <input class="input1" maxlength="10" size="4" value="<?php echo $rows['value'][1]['odds']; ?>" />
                                <a href="javascript:;"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a>
                            </td> 
                            <td height="28" align="center"><?php echo $rows['value'][2]['class']; ?></td> 
                            <td height="28" align="center">
                                <a href="javascript:;"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a>
                                <input class="input1" maxlength="10" size="4" value="<?php echo $rows['value'][2]['odds']; ?>" />
                                <a href="javascript:;"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a>
                            </td> 
                        </tr>
<?php } ?>                        <tr>
                            <td height="28" colspan="5" align="center" bgcolor="#FFFFFF"><input type="button" class="submit80" value="保存赔率" /></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>