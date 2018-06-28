<?php
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('cpgl');
check_quanxian('cppl');

$type = isset($_GET['type'])?$_GET['type']:'1';
!in_array($type, array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11'))&&$type = '1';

$action = isset($_POST['action']) ? $_POST['action'] : 'default';

if($action=='save'){
    $_return = array('status' => 'failed');
    $data = isset($_POST['data'])&&is_array($_POST['data'])?$_POST['data']:array();
    $stmt = $mydata1_db->prepare('SELECT `id`, `value` FROM `c_odds_data` WHERE `type`=:type AND `class`=:class');
    $stmt->execute(array(':type' => 'JSSC', ':class' => $type));
    if($rows = $stmt->fetch()){
        $rows['value'] = unserialize($rows['value']);
        $params = array(
            ':id' => $rows['id'],
            ':value' => NULL,
        );
        foreach($data as $key=>$val){
            $key = intval($key);
            if($key>0&&isset($rows['value'][$key])){
                $rows['value'][$key]['odds'] = is_numeric($val)&&$val>0?floatval($val):0;
            }
        }
        $params[':value'] = serialize($rows['value']);
        $stmt = $mydata1_db->prepare('UPDATE `c_odds_data` SET `value`=:value WHERE `id`=:id');
        $stmt->execute($params)&&$_return['status'] = 'success';
        admin::insert_log($_SESSION['adminid'], '修改[极速赛车]赔率信息');
    }
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
            $("td[data-key]").map(function(){
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
                $("td[data-key]").map(function(){
                    var e = $(this), k = e.data("key");
                    data[k] = e.find("input").val()
                });
                $.post("<?php echo basename(__FILE__); ?>?type=<?php echo $type; ?>", {action: "save", data: data}, function(data){
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
                                <a id="ssc01" href="lottery_jssc_odds.php" class="menu_curr">极速赛车</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc02" href="lottery_jsssc_odds.php" class="menu_com">极速时时彩</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc03" href="lottery_jslh_odds.php" class="menu_com">极速六合</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc04" href="lottery_ffk3_odds.php" class="menu_com">分分快3</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc05" href="lottery_sfk3_odds.php" class="menu_com">超级快3</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc06" href="lottery_wfk3_odds.php" class="menu_com">好运快3</a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" bgcolor="#FFFFFF" style="color:#000"><a href="?type=1" class="<?php echo $type=='1'?'sub_curr':'sub_com'; ?>">冠、亚军和</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=2" class="<?php echo $type=='2'?'sub_curr':'sub_com'; ?>">冠军</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=3" class="<?php echo $type=='3'?'sub_curr':'sub_com'; ?>">亚军</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=4" class="<?php echo $type=='4'?'sub_curr':'sub_com'; ?>">第三名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=5" class="<?php echo $type=='5'?'sub_curr':'sub_com'; ?>">第四名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=6" class="<?php echo $type=='6'?'sub_curr':'sub_com'; ?>">第五名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=7" class="<?php echo $type=='7'?'sub_curr':'sub_com'; ?>">第六名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=8" class="<?php echo $type=='8'?'sub_curr':'sub_com'; ?>">第七名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=9" class="<?php echo $type=='9'?'sub_curr':'sub_com'; ?>">第八名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=10" class="<?php echo $type=='10'?'sub_curr':'sub_com'; ?>">第九名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=11" class="<?php echo $type=='11'?'sub_curr':'sub_com'; ?>">第十名</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jssc_oddslh.php" class="sub_com">龙虎斗</a></td>
                        </tr>
                    </table>
                    <table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                        <tr style="background-color:#3C4D82;color:#FFF">
                            <td height="22" align="center"><strong>选项</strong></td>
                            <td height="22" align="center"><strong>赔率</strong></td>
                            <td height="22" align="center"><strong>选项</strong></td>
                            <td height="22" align="center"><strong>赔率</strong></td>
                        </tr>
<?php
$stmt = $mydata1_db->prepare('SELECT `value` FROM `c_odds_data` WHERE `type`=:type AND `class`=:class');
$stmt->execute(array(':type' => 'JSSC', ':class' => $type));
$i = 2;
if($rows = $stmt->fetch()){
    $rows['value'] = unserialize($rows['value']);
    foreach($rows['value'] as $key=>$val){
        if($i==2){
?>                        <tr onmouseover="this.style.backgroundColor='#EBEBEB'" onmouseout="this.style.backgroundColor='#ffffff'" style="background-color:#FFFFFF;line-height:20px;">
<?php
        }
        $i--;
?>                            <td height="28" align="center"><?php echo $val['class']; ?></td> 
                            <td height="28" align="center" data-key="<?php echo $key; ?>">
                                <a href="javascript:;"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a>
                                <input class="input1" maxlength="10" size="4" value="<?php echo $val['odds']; ?>" />
                                <a href="javascript:;"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a>
                            </td> 
<?php
        if($i<=0){
            $i = 2;
?>                        </tr>
<?php
        }
    }
    $i = fmod(count($rows['value']), 2);
    if($i>0){
        for($i=2-$i;$i>0;$i--){
?>                            <td height="28" align="center"></td> 
                            <td height="28" align="center"></td> 
<?php } ?>                        </tr>
<?php
    }
}
?>                        <tr>
                            <td height="28" colspan="4" align="center" bgcolor="#FFFFFF"><input type="button" class="submit80" value="保存赔率" /></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>