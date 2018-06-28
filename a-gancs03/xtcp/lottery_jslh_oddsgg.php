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
            $stmt = $mydata1_db->prepare('SELECT `value` FROM `c_odds_data` WHERE `id`=:id AND `type`=:type');
            $stmt->execute(array(':type' => 'JSLH', ':id' => $id));
            if($rows = $stmt->fetch()){
                $rows['value'] = unserialize($rows['value']);
                $params = array(
                    ':id' => $id,
                    ':value' => NULL,
                );
                foreach($val as $key=>$v){
                    $key = intval($key);
                    if($key>0&&isset($rows['value'][$key])){
                        $rows['value'][$key]['odds'] = is_numeric($v)&&$v>0?floatval($v):0;
                    }
                }
                $params[':value'] = serialize($rows['value']);
                $stmt = $mydata1_db->prepare('UPDATE `c_odds_data` SET `value`=:value WHERE `id`=:id');
                $stmt->execute($params)&&$_return['status']++;
            }
        }
    }
    $_return['status'] = $_return['status']>0?'success':'failed';
    admin::insert_log($_SESSION['adminid'], '修改[极速六合]赔率信息');
    exit(json_encode($_return));
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
                    var e = $(this), k = e.data("id");
                    typeof(data[k])=="undefined"&&(data[k] = {}),
                    e.find("td[data-key]").map(function(){
                        var d = $(this), i = d.data("key");
                        data[k][i] = d.find("input").val();
                    })
                });
                console.log(data);
                $.post("<?php echo basename(__FILE__); ?>", {action: "save", data: data}, function(data){
                    if(data["status"]=="success"){
                        alert("保存成功！");
                    }else{
                        alert("保存失败！");
                    }
                    t.attr("disabled", false).val("保存赔率");
                }, "json");
            });
            $("tr[data-id] td").on("mouseover mouseout",function(e){
                var t = $(this), p = t.parent(), f = $("tr[data-id="+p.data("id")+"]:first").find("td:first");
                if(p.find("td").size()>2&&t.index()==0){
                    p = $("tr[data-id="+p.data("id")+"]");
                }
                if(e.type=="mouseover"){
                    p.css("background-color", "#EBEBEB");
                    f.css("background-color", "#EBEBEB");
                }else if(e.type=="mouseout"){
                    p.css("background-color", "#FFFFFF");
                    f.css("background-color", "#FFFFFF");
                }
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
                                <a id="ssc01" href="lottery_jssc_odds.php" class="menu_com">极速赛车</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc02" href="lottery_jsssc_odds.php" class="menu_com">极速时时彩</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc03" href="lottery_jslh_odds.php" class="menu_curr">极速六合</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc04" href="lottery_ffk3_odds.php" class="menu_com">分分快3</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc05" href="lottery_sfk3_odds.php" class="menu_com">超级快3</a>  -
                                <a id="ssc06" href="lottery_wfk3_odds.php" class="menu_com">好运快3</a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" bgcolor="#FFFFFF" style="color:#000"><a href="lottery_jslh_odds.php?type=1" class="sub_com">特码</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_odds.php?type=3" class="sub_com">正特</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_odds.php?type=2" class="sub_com">正码</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_oddszm6.php" class="sub_com">正码1-6</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_oddsgg.php" class="sub_curr">过关</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_oddslm.php" class="sub_com">连码</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_odds.php?type=21" class="sub_com">半波</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_odds.php?type=22" class="sub_com">一肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_odds.php?type=23" class="sub_com">尾数</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_odds.php?type=24" class="sub_com">特码生肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_odds.php?type=38" class="sub_com">合肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_odds.php?type=25" class="sub_com">生肖连</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_odds.php?type=32" class="sub_com">尾数连</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_odds.php?type=48" class="sub_com">全不中</a></td>
                        </tr>
                    </table>
                    <table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                        <tr style="background-color:#3C4D82;color:#FFF">
                            <td height="22" align="center" width="20%"><strong>玩法</strong></td>
                            <td height="22" align="center" width="20%"><strong>选项</strong></td>
                            <td height="22" align="center" width="20%"><strong>赔率</strong></td>
                        </tr>
<?php
$class = [
    15 => '正码1',
    16 => '正码2',
    17 => '正码3',
    18 => '正码4',
    19 => '正码5',
    20 => '正码6',
];
$stmt = $mydata1_db->prepare('SELECT `id`, `class`, `value` FROM `c_odds_data` WHERE `type`=:type AND `class` BETWEEN 15 AND 20 ORDER BY `id` ASC');
$stmt->execute(array(':type' => 'JSLH'));
while($rows = $stmt->fetch()){
    $rows['value'] = unserialize($rows['value']);
    foreach($rows['value'] as $key=>$val){
?>                        <tr style="background-color:#FFFFFF;line-height:20px;" data-id="<?php echo $rows['id']; ?>">
<?php if($key==1){ ?>                            <td height="28" align="center" rowspan="<?php echo count($rows['value']);?>"><?php echo $class[$rows['class']]; ?></td> 
<?php } ?>                            <td height="28" align="center"><?php echo $val['class']; ?></td> 
                            <td height="28" align="center" data-key="<?php echo $key; ?>">
                                <a href="javascript:;"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a>
                                <input class="input1" maxlength="10" size="4" value="<?php echo $val['odds']; ?>" />
                                <a href="javascript:;"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a>
                            </td> 
                        </tr>
<?php }} ?>                        <tr>
                            <td height="28" colspan="3" align="center" bgcolor="#FFFFFF"><input type="button" class="submit80" value="保存赔率" /></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>