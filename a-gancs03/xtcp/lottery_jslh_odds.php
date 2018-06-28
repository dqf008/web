<?php
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('cpgl');
check_quanxian('cppl');

$type = isset($_GET['type'])?$_GET['type']:'1';
!in_array($type, range('1', '99'))&&$type = '1';

$action = isset($_POST['action']) ? $_POST['action'] : 'default';

if($action=='save'){
    $_return = array('status' => 'failed');
    $data = isset($_POST['data'])&&is_array($_POST['data'])?$_POST['data']:array();
    $stmt = $mydata1_db->prepare('SELECT `id`, `value` FROM `c_odds_data` WHERE `type`=:type AND `class`=:class');
    $stmt->execute(array(':type' => 'JSLH', ':class' => $type));
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
        admin::insert_log($_SESSION['adminid'], '修改[极速六合]赔率信息');
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
                                <a id="ssc01" href="lottery_jssc_odds.php" class="menu_com">极速赛车</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc02" href="lottery_jsssc_odds.php" class="menu_com">极速时时彩</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc03" href="lottery_jslh_odds.php" class="menu_curr">极速六合</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc04" href="lottery_ffk3_odds.php" class="menu_com">分分快3</a>&nbsp;&nbsp;-&nbsp;&nbsp;
                                <a id="ssc05" href="lottery_sfk3_odds.php" class="menu_com">超级快3</a>  -
                                <a id="ssc06" href="lottery_wfk3_odds.php" class="menu_com">好运快3</a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" bgcolor="#FFFFFF" style="color:#000"><a href="?type=1" class="<?php echo $type=='1'?'sub_curr':'sub_com'; ?>">特码</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=3" class="<?php echo in_array($type, range(3, 8))?'sub_curr':'sub_com'; ?>">正特</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=2" class="<?php echo $type=='2'?'sub_curr':'sub_com'; ?>">正码</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_oddszm6.php" class="sub_com">正码1-6</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_oddsgg.php" class="sub_com">过关</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="lottery_jslh_oddslm.php" class="sub_com">连码</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=21" class="<?php echo $type=='21'?'sub_curr':'sub_com'; ?>">半波</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=22" class="<?php echo $type=='22'?'sub_curr':'sub_com'; ?>">一肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=23" class="<?php echo $type=='23'?'sub_curr':'sub_com'; ?>">尾数</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=24" class="<?php echo $type=='24'?'sub_curr':'sub_com'; ?>">特码生肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=38" class="<?php echo in_array($type, range(38, 47))?'sub_curr':'sub_com'; ?>">合肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=25" class="<?php echo in_array($type, range(25, 31))?'sub_curr':'sub_com'; ?>">生肖连</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=32" class="<?php echo in_array($type, range(32, 37))?'sub_curr':'sub_com'; ?>">尾数连</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=48" class="<?php echo in_array($type, range(48, 55))?'sub_curr':'sub_com'; ?>">全不中</a></td>
                        </tr>
<?php if(in_array($type, range(3, 8))){ ?>                        <tr>
                            <td align="center" bgcolor="#FFFFFF" style="color:#000"><a href="?type=3" class="<?php echo $type=='3'?'sub_curr':'sub_com'; ?>">正1特</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=4" class="<?php echo $type=='4'?'sub_curr':'sub_com'; ?>">正2特</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=5" class="<?php echo $type=='5'?'sub_curr':'sub_com'; ?>">正3特</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=6" class="<?php echo $type=='6'?'sub_curr':'sub_com'; ?>">正4特</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=7" class="<?php echo $type=='7'?'sub_curr':'sub_com'; ?>">正5特</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=8" class="<?php echo $type=='8'?'sub_curr':'sub_com'; ?>">正6特</a></td>
                        </tr>
<?php }else if(in_array($type, range(25, 31))){ ?>                        <tr>
                            <td align="center" bgcolor="#FFFFFF" style="color:#000"><a href="?type=25" class="<?php echo $type=='25'?'sub_curr':'sub_com'; ?>">二肖连中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=26" class="<?php echo $type=='26'?'sub_curr':'sub_com'; ?>">三肖连中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=27" class="<?php echo $type=='27'?'sub_curr':'sub_com'; ?>">四肖连中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=28" class="<?php echo $type=='28'?'sub_curr':'sub_com'; ?>">五肖连中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=29" class="<?php echo $type=='29'?'sub_curr':'sub_com'; ?>">二肖连不中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=30" class="<?php echo $type=='30'?'sub_curr':'sub_com'; ?>">三肖连不中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=31" class="<?php echo $type=='31'?'sub_curr':'sub_com'; ?>">四肖连不中</a></td>
                        </tr>
<?php }else if(in_array($type, range(32, 37))){ ?>                        <tr>
                            <td align="center" bgcolor="#FFFFFF" style="color:#000"><a href="?type=32" class="<?php echo $type=='32'?'sub_curr':'sub_com'; ?>">二尾连中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=33" class="<?php echo $type=='33'?'sub_curr':'sub_com'; ?>">三尾连中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=34" class="<?php echo $type=='34'?'sub_curr':'sub_com'; ?>">四尾连中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=35" class="<?php echo $type=='35'?'sub_curr':'sub_com'; ?>">二尾连不中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=36" class="<?php echo $type=='36'?'sub_curr':'sub_com'; ?>">三尾连不中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=37" class="<?php echo $type=='37'?'sub_curr':'sub_com'; ?>">四尾连不中</a></td>
                        </tr>
<?php }else if(in_array($type, range(38, 47))){ ?>                        <tr>
                            <td align="center" bgcolor="#FFFFFF" style="color:#000"><a href="?type=38" class="<?php echo $type=='38'?'sub_curr':'sub_com'; ?>">二肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=39" class="<?php echo $type=='39'?'sub_curr':'sub_com'; ?>">三肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=40" class="<?php echo $type=='40'?'sub_curr':'sub_com'; ?>">四肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=41" class="<?php echo $type=='41'?'sub_curr':'sub_com'; ?>">五肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=42" class="<?php echo $type=='42'?'sub_curr':'sub_com'; ?>">六肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=43" class="<?php echo $type=='43'?'sub_curr':'sub_com'; ?>">七肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=44" class="<?php echo $type=='44'?'sub_curr':'sub_com'; ?>">八肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=45" class="<?php echo $type=='45'?'sub_curr':'sub_com'; ?>">九肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=46" class="<?php echo $type=='46'?'sub_curr':'sub_com'; ?>">十肖</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=47" class="<?php echo $type=='47'?'sub_curr':'sub_com'; ?>">十一肖</a></td>
                        </tr>
<?php }else if(in_array($type, range(48, 55))){ ?>                        <tr>
                            <td align="center" bgcolor="#FFFFFF" style="color:#000"><a href="?type=48" class="<?php echo $type=='48'?'sub_curr':'sub_com'; ?>">五不中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=49" class="<?php echo $type=='49'?'sub_curr':'sub_com'; ?>">六不中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=50" class="<?php echo $type=='50'?'sub_curr':'sub_com'; ?>">七不中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=51" class="<?php echo $type=='51'?'sub_curr':'sub_com'; ?>">八不中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=52" class="<?php echo $type=='52'?'sub_curr':'sub_com'; ?>">九不中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=53" class="<?php echo $type=='53'?'sub_curr':'sub_com'; ?>">十不中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=54" class="<?php echo $type=='54'?'sub_curr':'sub_com'; ?>">十一不中</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=55" class="<?php echo $type=='55'?'sub_curr':'sub_com'; ?>">十二不中</a></td>
                        </tr>
<?php } ?>                    </table>
                    <table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                        <tr style="background-color:#3C4D82;color:#FFF">
                            <td height="22" align="center"><strong>选项</strong></td>
                            <td height="22" align="center"><strong>赔率</strong></td>
                            <td height="22" align="center"><strong>选项</strong></td>
                            <td height="22" align="center"><strong>赔率</strong></td>
                        </tr>
<?php
$stmt = $mydata1_db->prepare('SELECT `value` FROM `c_odds_data` WHERE `type`=:type AND `class`=:class');
$stmt->execute(array(':type' => 'JSLH', ':class' => $type));
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