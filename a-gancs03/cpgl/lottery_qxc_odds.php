<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('cpgl');
check_quanxian('cppl');

$type = isset($_GET['type'])?$_GET['type']:'1';
!in_array($type, array('1', '2', '3', '4', '5', '6'))&&$type = '1';
$pan = isset($_GET['pan'])?$_GET['pan']:'a';
!in_array($pan, array('a', 'b'))&&$pan = 'a';

$action = isset($_POST['action']) ? $_POST['action'] : 'default';

if(in_array($action, array('odds', 'save'))){
    $_return = array();
    switch($action){
        case 'odds':
            $stmt = $mydata1_db->prepare('SELECT * FROM `c_odds_data` WHERE `type`=:type');
            $stmt->execute(array(':type' => 'QXC'));
            while($rows = $stmt->fetch()){
                $rows['value'] = unserialize($rows['value']);
                !is_array($rows['value'])&&$rows['value'] = array(
                    'A' => array(
                        'odds' => 0,
                        'rate' => 0,
                    ),
                    'B' => array(
                        'odds' => 0,
                        'rate' => 0,
                    ),
                );
                $_return[$rows['id']] = array(
                    'a' => array(
                        'odds' => $rows['value']['A']['odds'],
                        'rate' => $rows['value']['A']['rate'],
                    ),
                    'b' => array(
                        'odds' => $rows['value']['B']['odds'],
                        'rate' => $rows['value']['B']['rate'],
                    ),
                );
            }
            break;

        case 'save':
            $data = isset($_POST['data'])&&is_array($_POST['data'])?$_POST['data']:array();
            $_return['status'] = 0;
            foreach($data as $id=>$val){
                $id = intval($id);
                if($id>0&&is_array($val)){
                    $params = array(
                        ':id' => $id,
                        ':type' => 'QXC',
                        ':value' => serialize(array(
                            'A' => array(
                                'odds' => getFloat($val, 'a', 'odds'),
                                'rate' => getFloat($val, 'a', 'rate'),
                            ),
                            'B' => array(
                                'odds' => getFloat($val, 'b', 'odds'),
                                'rate' => getFloat($val, 'b', 'rate'),
                            ),
                        )),
                    );
                    $stmt = $mydata1_db->prepare('UPDATE `c_odds_data` SET `value`=:value WHERE `id`=:id AND `type`=:type');
                    $stmt->execute($params)&&$_return['status']++;
                }
            }
            $_return['status'] = $_return['status']>0?'success':'failed';
            admin::insert_log($_SESSION['adminid'], '修改[七星彩]赔率信息');
            break;
    }
    exit(json_encode($_return));
}

function getFloat($v, $p, $t){
    return isset($v[$p])&&is_array($v[$p])&&isset($v[$p][$t])&&is_numeric($v[$p][$t])&&$v[$p][$t]>0?floatval($v[$p][$t]):0;
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
            $.post("<?php echo basename(__FILE__); ?>", {action: "odds"}, function(data){
                $.each(data, function(key, val){
                    var e = $("tr[data-id="+key+"] input");
                    e.eq(0).val(val['a']['odds']),
                    e.eq(1).val(val['a']['rate']),
                    e.eq(2).val(val['b']['odds']),
                    e.eq(3).val(val['b']['rate'])
                });
            }, "json");
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
                        a: {
                            odds: v.eq(0).val(),
                            rate: v.eq(1).val()
                        },
                        b: {
                            odds: v.eq(2).val(),
                            rate: v.eq(3).val()
                        }
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
                            <td align="center" bgcolor="#3C4D82" style="color:#FFF"><a id="ssc01" href="lottery_qxc_bet.php" class="menu_com">即时注单</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a id="ssc02" href="lottery_qxc_data.php" class="menu_com">开奖设置</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a id="ssc03" href="lottery_qxc_odds.php" class="menu_curr">赔率设置</a></td>
                        </tr>
                        <tr style="display:none">
                            <td align="center" bgcolor="#FFFFFF" style="color:#000"><a href="?type=1" class="<?php echo $type=='1'?'sub_curr':'sub_com'; ?>">二定玩法</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=2" class="<?php echo $type=='2'?'sub_curr':'sub_com'; ?>">三定玩法</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=3" class="<?php echo $type=='3'?'sub_curr':'sub_com'; ?>">四定玩法</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=4" class="<?php echo $type=='4'?'sub_curr':'sub_com'; ?>">一定位</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=5" class="<?php echo $type=='5'?'sub_curr':'sub_com'; ?>">二字现</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=6" class="<?php echo $type=='6'?'sub_curr':'sub_com'; ?>">三字现</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="?type=<?php echo $type?>&amp;pan=a" class="<?php echo $pan=='a'?'sub_curr':'sub_com'; ?>">A盘</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=<?php echo $type?>&amp;pan=b" class="<?php echo $pan=='b'?'sub_curr':'sub_com'; ?>">B盘</a></td>
                        </tr>
                    </table>
                    <table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                        <tr style="background-color:#3C4D82;color:#FFF">
                            <td height="22" align="center" width="20%"><strong>玩法</strong></td>
                            <td height="22" align="center" width="20%"><strong>A盘赔率</strong></td>
                            <td height="22" align="center" width="20%"><strong>A盘返水 (单位：%)</strong></td>
                            <td height="22" align="center" width="20%"><strong>B盘赔率</strong></td>
                            <td height="22" align="center" width="20%"><strong>B盘返水 (单位：%)</strong></td>
                        </tr>
<?php
$stmt = $mydata1_db->prepare('SELECT `id`, `class` FROM `c_odds_data` WHERE `type`=:type');
$stmt->execute(array(':type' => 'QXC'));
while($rows = $stmt->fetch()){
?>                        <tr onmouseover="this.style.backgroundColor='#EBEBEB'" onmouseout="this.style.backgroundColor='#ffffff'" style="background-color:#FFFFFF;line-height:20px;" data-id="<?php echo $rows['id']; ?>">
                            <td height="28" align="center"><?php echo $rows['class']; ?></td> 
                            <td height="28" align="center">
                                <a href="javascript:;"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a>
                                <input class="input1" maxlength="10" size="4" />
                                <a href="javascript:;"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a>
                            </td> 
                            <td height="28" align="center">
                                <a href="javascript:;"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a>
                                <input class="input1" maxlength="10" size="4" />
                                <a href="javascript:;"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a>
                            </td> 
                            <td height="28" align="center">
                                <a href="javascript:;"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a>
                                <input class="input1" maxlength="10" size="4" />
                                <a href="javascript:;"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a>
                            </td> 
                            <td height="28" align="center">
                                <a href="javascript:;"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a>
                                <input class="input1" maxlength="10" size="4" />
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