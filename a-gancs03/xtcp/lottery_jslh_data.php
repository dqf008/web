<?php
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
include_once '../../cj/include/jslh.func.php';
check_quanxian('cpgl');
check_quanxian('cpkj');

$page = array('limit' => 50);
$page['cur'] = isset($_GET['page'])?$_GET['page']:'1';

$action = isset($_POST['action'])?$_POST['action']:'default';

$config_file = '../../cache/jslh.conf.php';
$jslh_config = [
    'mode' => 'r',
    'level' => 100,
    'ratio' => ['5000', '10000', '0'],
    'check' => false,
];
$level = [
    's1' => 100,
    's2' => 200,
    's3' => 400,
    's4' => 800,
    's5' => 1600,
    's6' => 3200,
];
file_exists($config_file)&&$jslh_config = include($config_file);
if(isset($jslh_config['level'])&&in_array($jslh_config['level'], $level)){
    foreach($level as $key=>$val){
        if($val==$jslh_config['level']){
            $jslh_config['level'] = $key;
            break;
        }
    }
}else{
    $jslh_config['level'] = 's1';
}

if(in_array($action, array('random', 'setting', 'check', 'delete', 'change', 'save'))){
    $_return = array();
    switch($action){
        case 'random':
            if(!isset($_POST['qishu'])||empty($_POST['qishu'])||($qishu = getRealqs($_POST['qishu']))<=0){
                $jslh_config['mode'] = 'r';
            }
            $check = isset($jslh_config['check'])&&$jslh_config['check'];
            $tempRanking = getRanking(isset($_POST['history'])?$qishu:0, $check);
            if($jslh_config['mode']=='s'||(isset($jslh_config['ratio'][2])&&$jslh_config['ratio'][2]!=0)){
                $keys = $tempArray = [[], []];
                for($i=0;$i<$level[$jslh_config['level']];$i++){
                    // 随机计算结果
                    $tempArray[0][$i] = getNumber($tempRanking, $check);
                }
                $tempArray[1] = checkBet($qishu, $tempArray[0]);
                if(empty($tempArray[1])){
                    $i = array_rand($tempArray[0]);
                    $tempMsg = '已结算或无下注信息！';
                }else{
                    if($jslh_config['mode']=='s'){
                        $jslh_config['ratio'] = rand($jslh_config['ratio'][0], $jslh_config['ratio'][1]);
                        foreach($tempArray[1] as $key=>$val){
                            if($val[2]>=$jslh_config['ratio']){
                                $keys[0][$key] = $val[2]; // 大于设定值
                            }else{
                                $keys[1][$key] = $val[2]; // 取最大值
                            }
                        }
                    }else{
                        $jslh_config['ratio'] = $jslh_config['ratio'][2];
                        $jslh_data = [0, 0, 0];
                        $data_file = '../../cache/jslh.data.php';
                        file_exists($data_file)&&$jslh_data = include($data_file);
                        foreach($tempArray[1] as $key=>$val){
                            if(round(-10000*($jslh_data[1]+$val[1])/($jslh_data[0]+$val[0]))>=$jslh_config['ratio']){
                                $keys[0][$key] = $val[2]; // 大于设定值
                            }else{
                                $keys[1][$key] = $val[2]; // 取最大值
                            }
                        }
                    }
                    if(!empty($keys[0])){
                        asort($keys[0]); // 从小到大排序
                        $keys[0] = array_keys($keys[0]);
                        $i = array_shift($keys[0]); // 取出第一个键名
                    }else{
                        arsort($keys[1]); // 从大到小排序
                        $keys[1] = array_keys($keys[1]);
                        $i = array_shift($keys[1]); // 取出第一个键名
                    }
                    $tempMsg = '下注: '.sprintf('%.2f', $tempArray[1][$i][0]).' 派彩: '.sprintf('%.2f', $tempArray[1][$i][1]).' 比例: '.sprintf('%.2f', $tempArray[1][$i][2]/100).'%';
                }
                $tempNum = $tempArray[0][$i];
            }else{
                $tempNum = getNumber($tempRanking, $check);
                $tempMsg = '点击计算';
            }
            $_return['status'] = 'success';
            $_return['msg'] = [$tempNum, $tempMsg];
            break;
        case 'setting':
            if(is_array($_POST['ratio'])){
                for($i=0;$i<=2;$i++){
                    if(isset($_POST['ratio'][$i])&&preg_match('/^\-?\d+(\.\d+)?$|^\-?0+\.\d+$/', $_POST['ratio'][$i])){
                        // $_POST['ratio'][$i]<-100&&$_POST['ratio'][$i] = -100;
                        $_POST['ratio'][$i]>=100&&$_POST['ratio'][$i] = 100;
                        $jslh_config['ratio'][$i] = floor($_POST['ratio'][$i]*100);
                    }
                }
            }else{
                $_POST['mode'] = 'r';
                $jslh_config['ratio'] = ['5000', '10000', '0'];
            }
            if(isset($_POST['mode'])&&$_POST['mode']=='s'){
                $jslh_config['mode'] = 's';
            }else{
                $jslh_config['mode'] = 'r';
            }
            if(isset($_POST['level'])&&in_array($_POST['level'], array_keys($level))){
                $jslh_config['level'] = $level[$_POST['level']];
            }else{
                $jslh_config['level'] = 100;
            }
            if(isset($_POST['check'])&&$_POST['check']=='true'){
                $jslh_config['check'] = true;
            }else{
                $jslh_config['check'] = false;
            }
            file_put_contents($config_file, '<?php'.PHP_EOL.'return unserialize(\''.serialize($jslh_config).'\');');
            $_return['status'] = 'success';
            admin::insert_log($_SESSION['adminid'], '修改了极速六合的配置信息');
            break;
        case 'check':
            $_return['status'] = 'failed';
            $_POST['opencode'] = array_unique($_POST['opencode']);
            $tempNum = [];
            if(count($_POST['opencode'])==7){
                foreach($_POST['opencode'] as $ball){
                    $ball = intval($ball);
                    if($ball<=0||$ball>49){
                        $_return['msg'] = '请正确选择开奖号码！';
                        break;
                    }
                    $tempNum[] = $ball;
                }
            }else{
                $_return['msg'] = '请正确选择开奖号码！';
            }
            if(empty($_return['msg'])){
                if(isset($_POST['qishu'])&&!empty($_POST['qishu'])&&($qishu = getRealqs($_POST['qishu']))>0){
                    $tempArray = checkBet($qishu, [$tempNum]);
                    if(empty($tempArray)||$tempArray[0]<=0){
                        $_return['msg'] = '已开奖或无下注信息！';
                    }else{
                        $_return['msg'] = '下注: '.sprintf('%.2f', $tempArray[0][0]).' 派彩: '.sprintf('%.2f', $tempArray[0][1]).' 比例: '.sprintf('%.2f', $tempArray[0][2]/100).'%';
                        $_return['status'] = 'success';
                    }
                }else{
                    $_return['msg'] = '请正确填写彩票期号！';
                }
            }
            break;
        case 'delete':
            $_return['status'] = 'failed';
            $params = array(':id' => isset($_POST['id'])?$_POST['id']:0, ':type' => 'JSLH');
            $stmt = $mydata1_db->prepare('SELECT `value` FROM `c_auto_data` WHERE `id`=:id AND `type`=:type');
            $stmt->execute($params);
            if($stmt->rowCount()>0){
                $rows = $stmt->fetch();
                $rows['value'] = unserialize($rows['value']);
                $stmt = $mydata1_db->prepare('DELETE FROM `c_auto_data` WHERE `id`=:id AND `type`=:type');
                $_return['status'] = $stmt->execute($params)?'success':'failed';
                admin::insert_log($_SESSION['adminid'], '删除极速六合[第'.$rows['value']['qishu'].'期]开奖信息[ID: '.$params[':id'].']');
            }
            break;

        case 'change':
            $_return['status'] = 'failed';
            $params = array(':id' => isset($_POST['id'])?$_POST['id']:0, ':type' => 'JSLH');
            $stmt = $mydata1_db->prepare('SELECT `qishu`, `value`, `status` FROM `c_auto_data` WHERE `id`=:id AND `type`=:type');
            $stmt->execute($params);
            if($stmt->rowCount()>0){
                $info = $stmt->fetch();
                if($info['status']==2){
                    $info['value'] = unserialize($info['value']);
                    $mydata1_db->query('UPDATE `c_auto_data` SET `status`=0 WHERE `id`='.$params[':id']);
                    admin::insert_log($_SESSION['adminid'], '结算极速六合[第'.$info['value']['qishu'].'期]，开奖结果：'.implode(',', $info['value']['opencode']));
                }else if($info['status']==1){
                    $mydata1_db->query('UPDATE `c_auto_data` SET `status`=2 WHERE `id`='.$params[':id']);
                    $stmt = $mydata1_db->prepare('SELECT * FROM `c_bet_data` WHERE `type`=:type AND `qishu`=:qishu AND `status`=1');
                    $stmt->execute(array(':type' => 'JSLH', ':qishu' => $info['qishu']));
                    $_return['msg'] = 0;
                    while($rows = $stmt->fetch()){
                        $bets = $mydata1_db->prepare('UPDATE `c_bet_data` SET `status`=0 WHERE `id`=:id');
                        $bets->execute(array(':id' => $rows['id']))&&$rows['win']>0&&update_money($rows['id'], $rows['uid'], -1*$rows['win']/100, 'RECALC', true);
                        $_return['msg']++;
                    }
                    admin::insert_log($_SESSION['adminid'], '重算极速六合[第'.$info['qishu'].'期]');
                }
                $_return['status'] = 'success';
            }
            break;

        case 'save':
            $_POST['opencode'] = isset($_POST['opencode'])&&is_array($_POST['opencode'])?$_POST['opencode']:array();
            $_return['status'] = 'failed';
            $_return['msg'] = '';
            $params = [':type' => 'JSLH'];
            $isPre = false;
            if(isset($_POST['qishu'])&&!empty($_POST['qishu'])&&($qishu = getRealqs($_POST['qishu']))>0){
                $params[':qishu'] = $qishu;
                $params[':opentime'] = $qishu+90;
                $isPre = $params[':opentime']-43200>time();
                if((! isset($_POST['pre']) || $_POST['pre'] != 'true') && $isPre){
                    $_return['msg'] = '第 '.$_POST['qishu'].' 期的开奖时间为 '.date('Y-m-d H:i:s', $params[':opentime']);
                }
            }else{
                $_return['msg'] = '请正确填写彩票期号！';
            }
            $_POST['opencode'] = array_unique($_POST['opencode']);
            $tempNum = [];
            if(count($_POST['opencode'])==7){
                foreach($_POST['opencode'] as $ball){
                    $ball = intval($ball);
                    if($ball<=0||$ball>49){
                        $_return['msg'] = '请正确选择开奖号码！';
                        break;
                    }
                    $tempNum[] = $ball;
                }
            }else{
                $_return['msg'] = '请正确选择开奖号码！';
            }
            if(empty($_return['msg'])){
                $stmt = $mydata1_db->prepare('SELECT `id`, `value`, `status` FROM `c_auto_data` WHERE `qishu`=:qishu AND `type`=:type');
                $stmt->execute([':qishu' => $qishu, ':type' => 'JSLH']);
                if(isset($_POST['id'])&&!empty($_POST['id'])){
                    $rows = $stmt->fetch();
                    if(!$rows||$rows['id']!=$_POST['id']){
                        $_return['msg'] = $_POST['qishu'].' 期已存在！';
                    }else{
                        $params[':id'] = $rows['id'];
                        $params[':value'] = unserialize($rows['value']);
                        $params[':value']['qishu'] = $_POST['qishu'];
                        $params[':value']['opencode'] = $tempNum;
                        $params[':value']['color'] = getColor($tempNum);
                        $params[':value']['animal'] = getAnimal($tempNum, $qishu);
                        $params[':value']['info'] = [array_sum($tempNum)];
                        $params[':value']['info'][] = fmod($params[':value']['info'][0], 2)==1?'单':'双';
                        $params[':value']['info'][] = $params[':value']['info'][0]>174?'大':'小';
                        $params[':value']['info'][] = $tempNum[6]==49?'和':(fmod($tempNum[6], 2)==1?'单':'双');
                        $params[':value']['info'][] = $tempNum[6]==49?'和':($tempNum[6]>24?'大':'小');
                        $tempNum[6] = substr('00'.$tempNum[6], -2);
                        $params[':value']['info'][] = $tempNum[6]==49?'和':(fmod(substr($tempNum[6], -1)+substr($tempNum[6], 0, 1), 2)==1?'单':'双');
                        $color = ['red' => '红', 'green' => '绿', 'blue' => '蓝'];
                        $params[':value']['info'][] = $color[$params[':value']['color'][6]];
                        $params[':value'] = serialize($params[':value']);
                        $params[':status'] = $rows['status'] == 3 && ! $isPre ? 2 : $rows['status'];
                        $sql = 'UPDATE `c_auto_data` SET `qishu`=:qishu, `opentime`=:opentime, `value`=:value, `status`=:status WHERE `id`=:id AND `type`=:type';
                        $stmt = $mydata1_db->prepare($sql);
                        $stmt->execute($params)&&admin::insert_log($_SESSION['adminid'], '修改极速六合[第'.$_POST['qishu'].'期]开奖信息[ID: '.$_POST['id'].']');
                        $_return['status'] = 'success';
                    }
                }else{
                    if($stmt->rowCount()>0){
                        $_return['msg'] = $_POST['qishu'].' 期已存在！';
                    }else{
                        $params[':value'] = array(
                            'qishu' => $_POST['qishu'],
                            'opencode' => $tempNum,
                            'info' => [array_sum($tempNum)],
                        );
                        $params[':value']['color'] = getColor($tempNum);
                        $params[':value']['animal'] = getAnimal($tempNum, $qishu);
                        $params[':value']['info'][] = fmod($params[':value']['info'][0], 2)==1?'单':'双';
                        $params[':value']['info'][] = $params[':value']['info'][0]>174?'大':'小';
                        $params[':value']['info'][] = $tempNum[6]==49?'和':(fmod($tempNum[6], 2)==1?'单':'双');
                        $params[':value']['info'][] = $tempNum[6]==49?'和':($tempNum[6]>24?'大':'小');
                        $tempNum[6] = substr('00'.$tempNum[6], -2);
                        $params[':value']['info'][] = $tempNum[6]==49?'和':(fmod(substr($tempNum[6], -1)+substr($tempNum[6], 0, 1), 2)==1?'单':'双');
                        $color = ['red' => '红', 'green' => '绿', 'blue' => '蓝'];
                        $params[':value']['info'][] = $color[$params[':value']['color'][6]];
                        $params[':value'] = serialize($params[':value']);
                        $params[':status'] = $isPre ? 3 : 0;
                        $sql = 'INSERT INTO `c_auto_data` (`type`, `qishu`, `opentime`, `value`, `status`) VALUES (:type, :qishu, :opentime, :value, :status)';
                        $stmt = $mydata1_db->prepare($sql);
                        $stmt->execute($params)&&admin::insert_log($_SESSION['adminid'], '添加极速六合[第'.$_POST['qishu'].'期]开奖信息');
                        $_return['status'] = 'success';
                    }
                }
            }
            break;
    }
    exit(json_encode($_return));
}

function update_money($id, $uid, $money, $type='RECKON', $update=false){
    global $mydata1_db;
    $return = false;
    $params = array(':uid' => $uid);
    $sql = 'SELECT `money`, `username` FROM `k_user` WHERE `uid`=:uid LIMIT 1';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    if($stmt->rowCount()>0){
        $user = $stmt->fetch();
        if($update||$money>0){
            $params[':money'] = $money;
            $sql = 'UPDATE `k_user` SET `money`=`money`+:money WHERE `uid`=:uid';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
        }
        $stmt = $mydata1_db->prepare('INSERT INTO `k_money_log` (`uid`, `userName`, `gameType`, `transferType`, `transferOrder`, `transferAmount`, `previousAmount`, `currentAmount`, `creationTime`) VALUES (:uid, :userName, :gameType, :transferType, :transferOrder, :transferAmount, :previousAmount, :currentAmount, :creationTime)');
        $stmt->execute(array(
            ':uid' => $uid,
            ':userName' => $user['username'],
            ':gameType' => 'JSLH',
            ':transferType' => $type,
            ':transferOrder' => 'LOT_'.$id,
            ':transferAmount' => $money,
            ':previousAmount' => $user['money'],
            ':currentAmount' => $user['money']+$money,
            ':creationTime' => date('Y-m-d H:i:s'),
        ));
        $return = true;
    }
    return $return;
}
function getRealqs($qishu=0){
    $return = 0;
    if(preg_match('/^[1-9]\d{10}$/', $qishu)){
        $return = mktime(0, 0, 0, substr($qishu, 4, 2), substr($qishu, 6, 2), substr($qishu, 0, 4));
        $qishu = substr($qishu, -3);
        if($qishu>0&&$qishu<=960){
            $return+= $qishu*90;
            $return-= 90;
        }else{
            $return = 0;
        }
    }
    return $return;
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
        .selected {background-color:#aee0f7}
    </style>
    <script type="text/javascript" charset="utf-8" src="/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="/js/calendar.js"></script>
    <script type="text/javascript" charset="utf-8" src="../js/layer/layer.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".font12:first").on("click", "input[type=button]", function(){
                var t = $(this), e = t.closest(".font12"), p = {action: "setting", mode: e.find("select:first").val(), level: e.find("select:last").val(), check: e.find("input[type=checkbox]").is(":checked")?'true':'false'};
                p["ratio"] = e.find("input[type=text]").map(function(){
                    return $(this).val()
                }).get(),
                    $.post("<?php echo basename(__FILE__); ?>", p, function(data){
                        if(data["status"]=="success"){
                            alert("保存成功！")
                        }else if(typeof(data["msg"])!="undefined"){
                            alert(data["msg"])
                        }else{
                            alert("操作失败！")
                        }
                    }, "json");
            }),
                $(".font12:first .data-status").on("click", function(){
                    layer.open({
                        type: 2,
                        shadeClose: true,
                        fix: true,
                        skin: 'layui-layer-lan',
                        title: "极速六合",
                        content: "lottery_status.php?type=jslh",
                        area: ['550px', '310px'],
                        shift: 0,
                        scrollbar: false
                    });
                }),
                $(".font12:eq(1)").on("click", "input[type=button]", function(){
                    var t = $(this), e = t.closest(".font12");
                    if(t.index()>0){
                        e.removeData("id"),
                            e.find("input[type=text]").val(""),
                            e.find("input[type=checkbox]").prop("checked", false),
                            e.find("input[type=button]:first").val("添加"),
                            e.find("select").find("option:first").attr("selected", true),
                            $(".selected").removeClass("selected")
                    }else{
                        var p = {action: "save", id: e.data("id"), qishu: e.find("input[type=text]").val(), pre: e.find("input[type=checkbox]").is(":checked")};
                        p["opencode"] = e.find("select").map(function(){
                            return $(this).val()
                        }).get(),
                            $.post("<?php echo basename(__FILE__); ?>", p, function(data){
                                if(data["status"]=="success"){
                                    if(typeof(p["id"])!="undefined"){
                                        $(".selected img").each(function(i){
                                            i = p["opencode"][i],
                                                $(this).attr("src", "../lotto/images/num"+i+".gif").data("ball", i)
                                        }),
                                            alert("修改成功！"),
                                            t.siblings("input").trigger("click")
                                    }else{
                                        alert("添加成功！"),
                                            window.location.reload()
                                    }
                                }else if(typeof(data["msg"])!="undefined"){
                                    alert(data["msg"])
                                }else{
                                    alert("操作失败！")
                                }
                            }, "json");
                    }
                }),
                $(".font12:eq(1)").on("click", "a[data-action]", function(){
                    var t = $(this), e = t.closest(".font12"), p = {action: t.data("action"), qishu: e.find("input[type=text]").val()};
                    switch(t.data("action")){
                        case "check":
                            t.html("请稍等..."),
                                p["opencode"] = e.find("select").map(function(){
                                    return $(this).val()
                                }).get(),
                                $.post("<?php echo basename(__FILE__); ?>", p, function(data){
                                    t.html("点击计算");
                                    if(data["status"]=="success"){
                                        t.html(data["msg"])
                                    }else if(typeof(data["msg"])!="undefined"){
                                        alert(data["msg"])
                                    }else{
                                        alert("操作失败！")
                                    }
                                }, "json");
                            break;
                        case "random":
                            t.html("请稍等..."),
                                e.find("a[data-action=check]").html("点击计算"),
                                $.post("<?php echo basename(__FILE__); ?>", p, function(data){
                                    if(data["status"]=="success"){
                                        $.each(data["msg"][0], function(i, v){
                                            e.find("select").eq(i).find("option[value="+v+"]").attr("selected", true);
                                        }),
                                            e.find("a[data-action=check]").html(data["msg"][1])
                                    }else if(typeof(data["msg"])!="undefined"){
                                        alert(data["msg"])
                                    }else{
                                        alert("操作失败！")
                                    }
                                    t.html("随机生成一组号码")
                                }, "json");
                            break;
                    }
                }),
                $(".font12:eq(1) select").on("change", function(){
                    var e = $(this), v = e.val(), s = e.siblings("select");
                    e.closest(".font12").find("a[data-action=check]").html("点击计算"),
                        s.find("option[value="+v+"]:selected").siblings(":first").attr("selected", true)
                }),
                $("#pageMain").on("click", "td[data-id] a", function(){
                    var t = $(this), e = t.parent();
                    $(".selected").removeClass("selected");
                    switch(t.data("action")){
                        case "delete":
                            confirm("确定删除第 "+e.siblings(":first").text()+" 期开奖数据？") && $.post("<?php echo basename(__FILE__); ?>", {action: "delete", id: e.data("id")}, function(data){
                                if(data["status"]=="success"){
                                    e.parent().fadeOut("fast", function(){$(this).remove()})
                                }else{
                                    alert("删除失败！")
                                }
                            }, "json");
                            break;
                        case "modify":
                            var i = $(".font12:eq(1)"), s = i.find("select");
                            e.siblings().andSelf().addClass("selected"),
                                $("#pageMain").animate({scrollTop: 0}, "fast"),
                                i.closest(".font12").data("id", e.data("id")),
                                i.find("input[type=text]").val(e.siblings().first().text()),
                            i.find("input[type=checkbox]").prop("checked", e.data("status") == "3");
                            i.find("tr").last().find("input:first").val("保存"),
                                e.parent().find("img[data-ball]").map(function(e){
                                    s.eq(e).find("option").eq($(this).data("ball")).attr("selected", true)
                                });
                            break;
                        case "change":
                            t.data("change")||t.data("status")=="0" ? alert("请勿重复点击") : (confirm("确定进行"+t.html()+"？") ? (e.prev().html("请稍后"), t.data("change", true), $.post("<?php echo basename(__FILE__); ?>", {action: "change", id: e.data("id")}, function(data){
                                if(data["status"]=="success"){
                                    if(t.data("status")=="1"){
                                        alert("重算完成！共"+data["msg"]+"条注单")
                                    }else{
                                        alert("请等待系统自动结算")
                                    }
                                    window.location.reload()
                                }else if(typeof(data["msg"])!="undefined"){
                                    alert(data["msg"])
                                }else{
                                    alert("操作失败！")
                                }
                                t.removeData("change")
                            }, "json")) : !1);
                            break;
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
                        <td align="center" bgcolor="#3C4D82" style="color:#FFF" colspan="2">
                            <a id="ssc01" href="lottery_jssc_data.php" class="menu_com">极速赛车</a> -
                            <a id="ssc02" href="lottery_jsssc_data.php" class="menu_com">极速时时彩</a> -
                            <a id="ssc03" href="lottery_jslh_data.php" class="menu_curr">极速六合</a> -
                            <a id="ssc04" href="lottery_ffk3_data.php" class="menu_com">分分快3</a> -
                            <a id="ssc05" href="lottery_sfk3_data.php" class="menu_com">超级快3</a> -
                            <a id="ssc06" href="lottery_wfk3_data.php" class="menu_com">好运快3</a>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#F0FFFF" width="100">彩票类别：</td>
                        <td align="left" bgcolor="#FFFFFF">极速六合</td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#F0FFFF" width="100">杀率模式：</td>
                        <td align="left" bgcolor="#FFFFFF">
                            <select>
                                <option value="r"<?php echo $jslh_config['mode']!='s'?' selected="true"':''; ?>>整体杀率</option>
                                <option value="s"<?php echo $jslh_config['mode']=='s'?' selected="true"':''; ?>>单期杀率</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#F0FFFF" width="100">计算等级：</td>
                        <td align="left" bgcolor="#FFFFFF">
                            <select>
                                <option value="s1"<?php echo $jslh_config['level']=='s1'?' selected="true"':''; ?>>默认</option>
                                <option value="s2"<?php echo $jslh_config['level']=='s2'?' selected="true"':''; ?>>一级</option>
                                <option value="s3"<?php echo $jslh_config['level']=='s3'?' selected="true"':''; ?>>二级</option>
                                <option value="s4"<?php echo $jslh_config['level']=='s4'?' selected="true"':''; ?>>三级</option>
                                <option value="s5"<?php echo $jslh_config['level']=='s5'?' selected="true"':''; ?>>四级</option>
                                <option value="s6"<?php echo $jslh_config['level']=='s6'?' selected="true"':''; ?>>五级</option>
                            </select>
                            <span style="color:red">级别越高杀率越接近设定值，但是越消耗性能</span>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#F0FFFF" width="100">单期杀率：</td>
                        <td align="left" bgcolor="#FFFFFF">最低 <input type="text" size="5" value="<?php echo sprintf('%.2f', $jslh_config['ratio'][0]/100); ?>" /> % 最高 <input type="text" size="5" value="<?php echo sprintf('%.2f', $jslh_config['ratio'][1]/100); ?>" /> % <span style="color:red">允许负数，最大 100.00%；如果需要固定比例，请设置为相同数值</span></td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#F0FFFF" width="100">整体杀率：</td>
                        <td align="left" bgcolor="#FFFFFF"><input type="text" size="5" value="<?php echo sprintf('%.2f', $jslh_config['ratio'][2]/100); ?>" /> % <span style="color:red">允许负数，0 为不启用，最大 100.00%</span>，<a href="javascript:;" class="data-status">查看统计数据</a></td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#F0FFFF" width="100">号码规律性：</td>
                        <td align="left" bgcolor="#FFFFFF"><input type="checkbox"<?php echo $jslh_config['check']?' checked="true"':''; ?> /> 启用 <span style="color:red">* 该功能为实验性功能</span></td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#F0FFFF" width="100">温馨提醒：</td>
                        <td align="left" bgcolor="#FFFFFF">部分情况下系统可能无法按照设定比例进行开奖，该情况可能会导致无法达到预期杀率</td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#FFFFFF" width="100">&nbsp;</td>
                        <td align="left" bgcolor="#FFFFFF">
                            <input type="button" class="submit80" value="保存" />
                        </td>
                    </tr>
                </table>
                <table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                    <tr style="background-color:#3C4D82;color:#FFF">
                        <td height="22" align="center" colspan="2"><strong>添加遗漏开奖信息</strong></td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#F0FFFF" width="100">彩票期号：</td>
                        <td align="left" bgcolor="#FFFFFF">
                            <input type="text" />
                            <!-- 预设开奖 -->
                            <input type="checkbox" id="preOpen" />
                            <label for="preOpen">预设</label>
                            <a href="javascript:;" data-action="random">随机生成一组号码</a>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#F0FFFF" width="100">开奖号码：</td>
                        <td align="left" bgcolor="#FFFFFF">
                            <select>
                                <option value="">正码1</option>
                                <?php for($i=1;$i<=49;$i++){ ?>									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>								</select>
                            <select>
                                <option value="">正码2</option>
                                <?php for($i=1;$i<=49;$i++){ ?>									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>								</select>
                            <select>
                                <option value="">正码3</option>
                                <?php for($i=1;$i<=49;$i++){ ?>									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>								</select>
                            <select>
                                <option value="">正码4</option>
                                <?php for($i=1;$i<=49;$i++){ ?>									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>								</select>
                            <select>
                                <option value="">正码5</option>
                                <?php for($i=1;$i<=49;$i++){ ?>									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>								</select>
                            <select>
                                <option value="">正码6</option>
                                <?php for($i=1;$i<=49;$i++){ ?>									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>								</select>
                            <span>＋</span>
                            <select>
                                <option value="">特码</option>
                                <?php for($i=1;$i<=49;$i++){ ?>									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>								</select>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#F0FFFF" width="100">杀率计算：</td>
                        <td align="left" bgcolor="#FFFFFF"><a href="javascript:;" data-action="check">点击计算</a> (正比盈利负比亏损)</td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#FFFFFF" width="100">&nbsp;</td>
                        <td align="left" bgcolor="#FFFFFF">
                            <input type="button" class="submit80" value="添加" />
                            <input type="button" class="submit80" value="取消" />
                            <a href="lottery_jslh_datapl.php">批量添加</a>
                        </td>
                    </tr>
                </table>
                <table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                    <tr style="background-color:#3C4D82;color:#FFF">
                        <td height="22" align="center"><strong>期数</strong></td>
                        <td height="22" align="center"><strong>开奖时间(北京/美东)</strong></td>
                        <td height="22" align="center"><strong>正码1</strong></td>
                        <td height="22" align="center"><strong>正码2</strong></td>
                        <td height="22" align="center"><strong>正码3</strong></td>
                        <td height="22" align="center"><strong>正码4</strong></td>
                        <td height="22" align="center"><strong>正码5</strong></td>
                        <td height="22" align="center"><strong>正码6</strong></td>
                        <td height="22" align="center"><strong>特码</strong></td>
                        <td height="22" align="center"><strong>金额</strong></td>
                        <td height="22" align="center"><strong>统计</strong></td>
                        <td height="22" align="center"><strong>状态</strong></td>
                        <td height="22" align="center"><strong>操作</strong></td>
                    </tr>
                    <?php
                    // 配置SQL语句
                    $params = array(':type' => 'JSLH');

                    // 计算分页
                    $stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `COUNT` FROM `c_auto_data` WHERE `type`=:type');
                    $stmt->execute($params);
                    $page['count'] = $stmt->fetch();
                    $page['count'] = $page['count']['COUNT'];
                    $page['all'] = ceil($page['count']/$page['limit']);
                    $page['all']<1&&$page['all'] = 1;
                    if(is_numeric($page['cur'])&&$page['cur']>0){
                        $page['cur']>$page['all']&&$page['cur'] = $page['all'];
                    }else{
                        $page['cur'] = '1';
                    }

                    $params[':start'] = ($page['cur']-1)*$page['limit'];
                    $params[':limit'] = $page['limit'];
                    $status = array('<font color="#0000FF">未结算</font>', '<font color="#FF0000">已结算</font>', '<font color="#0000FF">重算未结</font>', '<font color="#0000FF">开奖预设</font>');
                    $stmt = $mydata1_db->prepare('SELECT * FROM `c_auto_data` WHERE `type`=:type ORDER BY `qishu` DESC LIMIT :start, :limit');
                    $stmt->execute($params);
                    while($rows = $stmt->fetch()){
                        $rows['value'] = unserialize($rows['value']);
                        ?>						<tr onmouseover="this.style.backgroundColor='#EBEBEB'" onmouseout="this.style.backgroundColor='#ffffff'" style="background-color:#FFFFFF;line-height:20px;">
                            <td align="center"><?php echo $rows['value']['qishu']; ?></td>
                            <td align="center"><?php echo date('Y-m-d H:i:s', $rows['opentime']).'<br />'.date('Y-m-d H:i:s', $rows['opentime']-43200); ?></td>
                            <?php foreach($rows['value']['opencode'] as $ball){ ?>							<td align="center"><img src="../lotto/images/num<?php echo $ball; ?>.gif" data-ball="<?php echo $ball; ?>" /></td>
                            <?php } ?>							<td align="center"><?php echo $rows['status']==1?'下注: '.number_format($rows['value']['bet']['money']/100, 2, '.', '').'<br />派彩: '.number_format($rows['value']['bet']['win']/100, 2, '.', ''):'--'; ?></td>
                            <td align="center"><?php echo $rows['status']==1?'会员: '.$rows['value']['bet']['user'].'<br />注单: '.$rows['value']['bet']['rows']:'--'; ?></td>
                            <td align="center"><?php echo $status[$rows['status']].($rows['status']==1?'<br />'.sprintf('%.2f', -1*$rows['value']['bet']['ratio']/100).'%':''); ?></td>
                            <td align="center" data-id="<?php echo $rows['id']; ?>" data-status="<?php echo $rows['status']; ?>"><a href="javascript:;" data-action="change" data-status="<?php echo $rows['status']; ?>"<?php echo $rows['status'] == 3 ? ' style="display:none"' : '' ; ?>><?php echo $rows['status']==1?'重算':'开奖'; ?></a>&nbsp;<a href="javascript:;" data-action="modify">修改</a>&nbsp;<a href="javascript:;" data-action="delete">删除</a></td>
                        </tr>
                        <?php
                    }
                    $page['url'] = '?page=';
                    $page['range'] = array(1, $page['all']);
                    if($page['all']>5){
                        $page['range'][1] = 5;
                        if($page['cur']>3){
                            $page['range'] = array($page['cur']-2, $page['cur']+2);
                        }
                        if($page['range'][1]>$page['all']){
                            $page['range'] = array($page['all']-4, $page['all']);
                        }
                    }
                    ?>						<tr style="background-color:#FFF">
                        <td colspan="16" align="center" valign="middle">
                            <div class="Pagination">
                                <a href="<?php echo $page['cur']>1?$page['url'].'1':'javascript:;'; ?>" class="tips">首页</a>
                                <a href="<?php echo $page['cur']>1?$page['url'].($page['cur']-1):'javascript:;'; ?>" class="tips">上一页</a>
                                <?php if($page['range'][0]>1){ ?>									<span class="dot">……</span>
                                <?php }for($p=$page['range'][0];$p<=$page['range'][1];$p++){ ?>									<a href="<?php echo $page['cur']!=$p?$page['url'].$p:'javascript:;" class="current'; ?>"><?php echo $p; ?></a>
                                <?php }if($page['range'][1]<$page['all']){ ?>									<span class="dot">……</span>
                                <?php } ?>									<a href="<?php echo $page['cur']<$page['all']?$page['url'].($page['cur']+1):'javascript:;'; ?>" class="tips">下一页</a>
                                <a href="<?php echo $page['cur']<$page['all']?$page['url'].$page['all']:'javascript:;'; ?>" class="tips">末页</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>