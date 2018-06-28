<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('cpgl');
check_quanxian('cpkj');

$page = array('limit' => 50);
$page['cur'] = isset($_GET['page'])?$_GET['page']:'1';

$action = isset($_POST['action'])?$_POST['action']:'default';

if(in_array($action, array('delete', 'change', 'save'))){
    $_return = array();
    switch($action){
        case 'delete':
            $_return['status'] = 'failed';
            $params = array(':id' => isset($_POST['id'])?$_POST['id']:0);
            $stmt = $mydata1_db->prepare('SELECT `qishu` FROM `lottery_k_qxc` WHERE `id`=:id');
            $stmt->execute($params);
            if($stmt->rowCount()>0){
                $rows = $stmt->fetch();
                $stmt = $mydata1_db->prepare('DELETE FROM `lottery_k_qxc` WHERE `id`=:id');
                $_return['status'] = $stmt->execute($params)?'success':'failed';
                admin::insert_log($_SESSION['adminid'], '删除七星彩[第'.$rows['qishu'].'期]开奖信息[ID: '.$params[':id'].']');
            }
            break;

        case 'change':
            $_return['status'] = 'failed';
            $params = array(':id' => isset($_POST['id'])?$_POST['id']:0);
            $stmt = $mydata1_db->prepare('SELECT * FROM `lottery_k_qxc` WHERE `id`=:id');
            $stmt->execute($params);
            if($stmt->rowCount()>0){
                $info = $stmt->fetch();
                if($info['status']==0){
                    $info['value'] = unserialize($info['value']);
                    if(is_array($info['value'])&&!empty($info['value'])&&str_replace(',', '', $result = implode(',', $info['value']))!=''){
                        $stmt = $mydata1_db->prepare('SELECT * FROM `c_bet_data` WHERE `type`=:type AND `qishu`=:qishu AND `status`=0');
                        $stmt->execute(array(':type' => 'QXC', ':qishu' => $info['qishu']));
                        $_return['msg'] = 0;
                        while($rows = $stmt->fetch()){
                            !is_array($rows['value'] = unserialize($rows['value']))&&$rows['value'] = array();
                            $wins = qxc_wins($rows['value']['type'], $rows['value']['content'], $info['value']); //中奖注数
                            $wins*= $rows['value']['odds']*$rows['value']['money']; //单注赔率
                            $wins+= $rows['money']*$rows['value']['rate']/100; //返水金额
                            $rows['value']['result'] = $result;
                            $bets = $mydata1_db->prepare('UPDATE `c_bet_data` SET `win`=:win, `status`=1, `value`=:value WHERE `id`=:id');
                            $bets->execute(array(
                                ':id' => $rows['id'],
                                ':win' => $wins>0?$wins:-1*$rows['money'],
                                ':value' => serialize($rows['value']),
                            ))&&update_money($rows['id'], $rows['uid'], round($wins)/100);
                            $_return['msg']++;
                        }
                        $stmt = $mydata1_db->prepare('UPDATE `lottery_k_qxc` SET `status`=1 WHERE `id`=:id');
                        $stmt->execute($params);
                        admin::insert_log($_SESSION['adminid'], '结算七星彩[第'.$info['qishu'].'期]，开奖结果：'.$result);
                        $_return['status'] = 'success';
                    }else{
                        $_return['msg'] = '请先设置开奖信息，再进行开奖！';
                    }
                }else{
                    $stmt = $mydata1_db->prepare('SELECT * FROM `c_bet_data` WHERE `type`=:type AND `qishu`=:qishu AND `status`=1');
                    $stmt->execute(array(':type' => 'QXC', ':qishu' => $info['qishu']));
                    $_return['msg'] = 0;
                    while($rows = $stmt->fetch()){
                        $rows['win']==0&&$rows['win'] = $rows['money']; // 和局扣回本金
                        $bets = $mydata1_db->prepare('UPDATE `c_bet_data` SET `status`=0 WHERE `id`=:id');
                        $bets->execute(array(':id' => $rows['id']))&&$rows['win']>0&&update_money($rows['id'], $rows['uid'], -1*$rows['win']/100, 'RECALC', true);
                        $_return['msg']++;
                    }
                    $stmt = $mydata1_db->prepare('UPDATE `lottery_k_qxc` SET `status`=0 WHERE `id`=:id');
                    $stmt->execute($params);
                    admin::insert_log($_SESSION['adminid'], '重算七星彩[第'.$info['qishu'].'期]');
                    $_return['status'] = 'success';
                }
            }
            break;

        case 'save':
            $_POST['ball'] = isset($_POST['ball'])&&is_array($_POST['ball'])?$_POST['ball']:array();
            $_return['status'] = 'failed';
            $_return['msg'] = '';
            $params = array(':value' => serialize($_POST['ball']));
            if(isset($_POST['kaijiang'])&&!empty($_POST['kaijiang'])&&($_POST['kaijiang'] = strtotime($_POST['kaijiang']))>0){
                $params[':kaijiang'] = $_POST['kaijiang'];
            }else{
                $_return['msg'] = '请正确填写开奖时间！';
            }
            if(isset($_POST['fengpan'])&&!empty($_POST['fengpan'])&&($_POST['fengpan'] = strtotime($_POST['fengpan']))>0){
                $params[':fengpan'] = $_POST['fengpan'];
            }else{
                $_return['msg'] = '请正确填写封盘时间！';
            }
            if(isset($_POST['kaipan'])&&!empty($_POST['kaipan'])&&($_POST['kaipan'] = strtotime($_POST['kaipan']))>0){
                $params[':kaipan'] = $_POST['kaipan'];
            }else{
                $_return['msg'] = '请正确填写开盘时间！';
            }
            if(isset($_POST['qishu'])&&!empty($_POST['qishu'])){
                $params[':qishu'] = $_POST['qishu'];
            }else{
                $_return['msg'] = '请填写彩票期号！';
            }
            if(empty($_return['msg'])){
                if(isset($_POST['id'])&&!empty($_POST['id'])){
                    $params[':id'] = $_POST['id'];
                    $sql = 'UPDATE `lottery_k_qxc` SET `qishu`=:qishu, `kaipan`=:kaipan, `fengpan`=:fengpan, `kaijiang`=:kaijiang, `value`=:value WHERE `id`=:id';
                    admin::insert_log($_SESSION['adminid'], '修改七星彩[第'.$params[':qishu'].'期]开奖信息[ID: '.$_POST['id'].']');
                }else{
                    $sql = 'INSERT INTO `lottery_k_qxc` (`qishu`, `kaipan`, `fengpan`, `kaijiang`, `value`) VALUES (:qishu, :kaipan, :fengpan, :kaijiang, :value)';
                    admin::insert_log($_SESSION['adminid'], '增加七星彩[第'.$params[':qishu'].'期]开奖信息');
                }
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params)&&$_return['status'] = 'success';
                $_return['msg'] = $mydata1_db->lastInsertId();
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
            ':gameType' => 'QXC',
            ':transferType' => $type,
            ':transferOrder' => 'QXC_'.$id,
            ':transferAmount' => $money,
            ':previousAmount' => $user['money'],
            ':currentAmount' => $user['money']+$money,
            ':creationTime' => date('Y-m-d H:i:s'),
        ));
        $return = true;
    }
    return $return;
}

function qxc_wins($type, $content, $result){
    $wins = 0;
    switch(true){
        case in_array($type, array('一定位', '二定位', '三定位', '四定位')):
            $content = explode(',', $content);
            foreach($content as $key=>$val){
                if($val=='*'){
                    unset($content[$key]);
                    continue;
                }else{
                    $content[$key] = str_split($val);
                }
            }
            if($type=='一定位'){
                foreach($content as $key=>$val){
                    in_array($result[$key], $val)&&$wins+= 1;
                }
            }else if(count($content)==str_replace(array('二定位', '三定位', '四定位'), array(2, 3, 4), $type)){
                foreach($content as $key=>$val){
                    if(in_array($result[$key], $val)){
                        $wins = 1;
                    }else{
                        $wins = 0;
                        break;
                    }
                }
            }
        break;
        case in_array($type, array('二字现', '三字现')):
            $content = str_split($content);
            $temp = array();
            $show = 0;
            foreach($content as $val){
                $temp['j'.$val] = $val;
            }
            for($i=0;$i<4;$i++){
                $j = $result[$i];
                if(isset($temp['j'.$j])){
                    $show+= 1;
                    unset($temp['j'.$j]);
                }
            }
            $show==str_replace(array('二字现', '三字现'), array(2, 3), $type)&&$wins = 1;
        break;
    }
    return $wins;
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
    <script type="text/javascript">
        $(document).ready(function(){
            $(".font12:eq(0)").on("click", "input[type=button]", function(){
                var t = $(this), e = t.closest(".font12");
                if(t.index()>0){
                    e.removeData("id"),
                    e.find("input[type=text]").val(""),
                    e.find("input[type=button]:eq(0)").val("添加"),
                    e.find("select").find("option:eq(0)").attr("selected", true),
                    $(".selected").removeClass("selected")
                }else{
                    var post = {action: "save", id: e.data("id")}, i = e.find("input[type=text]"), k = ["qishu", "kaipan", "fengpan", "kaijiang", "ball"];
                    post["qishu"] = i.eq(0).val();
                    for(var ii=1;ii<=3;ii++){
                        i.eq(ii).val()!=""&&(post[k[ii]] = i.eq(ii).val()+" "+i.eq(ii).siblings("select").find("option:selected").map(function(){
                            return $(this).text()
                        }).get().join(":")+":00")
                    }
                    post["ball"] = e.find("option:selected").slice(-7).map(function(){
                        return $(this).val()
                    }).get(),
                    $.post("<?php echo basename(__FILE__); ?>", post, function(data){
                        if(data["status"]=="success"){
                            if(typeof(post["id"])!="undefined"){
                                $(".selected").each(function(){
                                    i = $(this).index(),
                                    i<=10&&$(this).html(i<4?post[k[i]]:(i = post["ball"][i-4], i==""?"--":"<img src=\"/Lottery/Images/Ball_2/"+i+".png\" data-ball=\""+i+"\">"))
                                })
                            }else{
                                i = $(".font12:eq(1) tr:eq(0)").after("<tr onmouseover=\"this.style.backgroundColor='#EBEBEB'\" onmouseout=\"this.style.backgroundColor='#ffffff'\" style=\"background-color:#FFFFFF;line-height:20px;\"><td align=\"center\">"+post["qishu"]+"</td><td align=\"center\">"+post["kaipan"]+"</td><td align=\"center\">"+post["fengpan"]+"</td><td align=\"center\">"+post["kaijiang"]+"</td></tr>").next();
                                for(var ii=0;ii<7;ii++){
                                    i.append("<td align=\"center\">"+(typeof(post["ball"][ii])=="undefined"||post["ball"][ii]==""?"--":"<img src=\"/Lottery/Images/Ball_2/"+post["ball"][ii]+".png\" data-ball=\""+post["ball"][ii]+"\">")+"</td>")
                                }
                                i.append("<td align=\"center\"><font color=\"#0000FF\">未开奖</font></td><td align=\"center\" data-id=\""+data["msg"]+"\"><a href=\"javascript:;\" data-action=\"change\" data-status=\"0\">开奖</a>&nbsp;<a href=\"javascript:;\" data-action=\"modify\">修改</a>&nbsp;<a href=\"javascript:;\" data-action=\"delete\">删除</a></td>")
                            }
                            alert("操作成功！"),
                            t.siblings("input").trigger("click")
                        }else if(typeof(data["msg"])!="undefined"){
                            alert(data["msg"])
                        }else{
                            alert("操作失败！")
                        }
                    }, "json");
                }
            })
            $("#pageMain").on("click", "td[data-id] a", function(){
                var t = $(this), e = t.parent();
                $(".selected").removeClass("selected");
                switch(t.data("action")){
                    case "delete":
                    confirm("确定删除第 "+e.siblings(":eq(0)").text()+" 期开奖数据？") && $.post("<?php echo basename(__FILE__); ?>", {action: "delete", id: e.data("id")}, function(data){
                        if(data["status"]=="success"){
                            e.parent().fadeOut("fast", function(){$(this).remove()})
                        }else{
                            alert("删除失败！")
                        }
                    }, "json");
                    break;
                    case "modify":
                    var i = $(".font12:eq(0)").find("input[type=text]"), v;
                    e.siblings().andSelf().addClass("selected"),
                    $("#pageMain").animate({scrollTop: 0}, "fast"),
                    i.closest(".font12").data("id", e.data("id")),
                    e = e.siblings(),
                    i.eq(0).val(e.eq(0).text());
                    for(var ii=1;ii<=3;ii++){
                        v = e.eq(ii).text().split(" "),
                        i.eq(ii).val(v[0]);
                        if(typeof(v[1])!="undefined"){
                            v = v[1].split(":");
                            for(var x in v){
                                i.eq(ii).siblings("select").eq(x).find("option").eq(parseInt(v[x])).attr("selected", true)
                            }
                        }
                    }
                    i = $(".font12:eq(0)").find("tr").last(),
                    i.find("input:eq(0)").val("保存"),
                    i = i.prev().find("select"),
                    i.find("option:eq(0)").attr("selected", true);
                    for(;ii<=10;ii++){
                        v = e.eq(ii).find("img").data("ball"),
                        typeof(v)!="undefined" && i.eq(ii-4).find("option[value="+parseInt(v)+"]").attr("selected", true)
                    }
                    break;
                    case "change":
                    t.data("change") ? alert("请勿重复点击") : (e.prev().html("请稍后"), t.data("change", true), $.post("<?php echo basename(__FILE__); ?>", {action: "change", id: e.data("id")}, function(data){
                        e.prev().html("错误");
                        if(data["status"]=="success"){
                            if(t.data("status")=='0'){
                                alert("结算完成！共"+data["msg"]+"条注单"),
                                t.html("重算"),
                                e.prev().html("<font color=\"#FF0000\">已开奖</font>"),
                                t.data("status", '1')
                            }else{
                                alert("重算完成！共"+data["msg"]+"条注单"),
                                t.html("开奖"),
                                e.prev().html("<font color=\"#0000FF\">未开奖</font>"),
                                t.data("status", '0')
                            }
                        }else if(typeof(data["msg"])!="undefined"){
                            alert(data["msg"])
                        }else{
                            alert("操作失败！")
                        }
                        t.removeData("change")
                    }, "json"));
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
                            <td align="center" bgcolor="#3C4D82" style="color:#FFF" colspan="2"><a id="ssc01" href="lottery_qxc_bet.php" class="menu_com">即时注单</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a id="ssc02" href="lottery_qxc_data.php" class="menu_curr">开奖设置</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a id="ssc03" href="lottery_qxc_odds.php" class="menu_com">赔率设置</a></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="100">彩票类别：</td>
                            <td align="left" bgcolor="#FFFFFF">七星彩</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="100">彩票期号：</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="text" /></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="100">开盘时间：</td>
                            <td align="left" bgcolor="#FFFFFF">
                                <input type="text" onfocus="new Calendar(<?php echo date('Y')-4; ?>, <?php echo date('Y'); ?>).show(this);" size="10" />
                                <select>
<?php for($i=0;$i<24;$i++){ ?>                                    <option value="<?php echo $i; ?>"><?php echo substr('0'.$i, -2); ?></option>
<?php } ?>                                </select>
                                <select>
<?php for($i=0;$i<60;$i++){ ?>                                    <option value="<?php echo $i; ?>"><?php echo substr('0'.$i, -2); ?></option>
<?php } ?>                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="100">封盘时间：</td>
                            <td align="left" bgcolor="#FFFFFF">
                                <input type="text" onfocus="new Calendar(<?php echo date('Y')-4; ?>, <?php echo date('Y'); ?>).show(this);" size="10" />
                                <select>
<?php for($i=0;$i<24;$i++){ ?>                                    <option value="<?php echo $i; ?>"><?php echo substr('0'.$i, -2); ?></option>
<?php } ?>                                </select>
                                <select>
<?php for($i=0;$i<60;$i++){ ?>                                    <option value="<?php echo $i; ?>"><?php echo substr('0'.$i, -2); ?></option>
<?php } ?>                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="100">开奖时间：</td>
                            <td align="left" bgcolor="#FFFFFF">
                                <input type="text" onfocus="new Calendar(<?php echo date('Y')-4; ?>, <?php echo date('Y'); ?>).show(this);" size="10" />
                                <select>
<?php for($i=0;$i<24;$i++){ ?>                                    <option value="<?php echo $i; ?>"><?php echo substr('0'.$i, -2); ?></option>
<?php } ?>                                </select>
                                <select>
<?php for($i=0;$i<60;$i++){ ?>                                    <option value="<?php echo $i; ?>"><?php echo substr('0'.$i, -2); ?></option>
<?php } ?>                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="100">开奖号码：</td>
                            <td align="left" bgcolor="#FFFFFF">
                                <select>
                                    <option value="">仟位</option>
<?php for($i=0;$i<10;$i++){ ?>                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>                                </select>
                                <select>
                                    <option value="">佰位</option>
<?php for($i=0;$i<10;$i++){ ?>                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>                                </select>
                                <select>
                                    <option value="">拾位</option>
<?php for($i=0;$i<10;$i++){ ?>                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>                                </select>
                                <select>
                                    <option value="">个位</option>
<?php for($i=0;$i<10;$i++){ ?>                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>                                </select>
                                <select>
                                    <option value="">分位</option>
<?php for($i=0;$i<10;$i++){ ?>                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>                                </select>
                                <select>
                                    <option value="">拾分</option>
<?php for($i=0;$i<10;$i++){ ?>                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>                                </select>
                                <select>
                                    <option value="">佰分</option>
<?php for($i=0;$i<10;$i++){ ?>                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#FFFFFF" width="100">&nbsp;</td>
                            <td align="left" bgcolor="#FFFFFF">
                                <input type="button" class="submit80" value="添加" />
                                <input type="button" class="submit80" value="取消" />
                            </td>
                        </tr>
                    </table>
                    <table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                        <tr style="background-color:#3C4D82;color:#FFF">
                            <td height="22" align="center"><strong>期数</strong></td>
                            <td height="22" align="center"><strong>开盘时间</strong></td>
                            <td height="22" align="center"><strong>封盘时间</strong></td>
                            <td height="22" align="center"><strong>开奖时间</strong></td>
                            <td height="22" align="center"><strong>仟位</strong></td>
                            <td height="22" align="center"><strong>佰位</strong></td>
                            <td height="22" align="center"><strong>拾位</strong></td>
                            <td height="22" align="center"><strong>个位</strong></td>
                            <td height="22" align="center"><strong>分位</strong></td>
                            <td height="22" align="center"><strong>拾分</strong></td>
                            <td height="22" align="center"><strong>佰分</strong></td>
                            <td height="22" align="center"><strong>开奖结果</strong></td>
                            <td height="22" align="center"><strong>操作</strong></td>
                        </tr>
<?php
// 配置SQL语句
$params = array();

// 计算分页
$stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `COUNT` FROM `lottery_k_qxc`');
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
$status = array('<font color="#0000FF">未开奖</font>', '<font color="#FF0000">已开奖</font>');
$stmt = $mydata1_db->prepare('SELECT * FROM `lottery_k_qxc` ORDER BY `qishu` DESC LIMIT :start, :limit');
$stmt->execute($params);
while($rows = $stmt->fetch()){
    !is_array($rows['value'] = unserialize($rows['value']))&&$rows['value'] = array();
?>                        <tr onmouseover="this.style.backgroundColor='#EBEBEB'" onmouseout="this.style.backgroundColor='#ffffff'" style="background-color:#FFFFFF;line-height:20px;">
                            <td align="center"><?php echo $rows['qishu']; ?></td>
                            <td align="center"><?php echo date('Y-m-d H:i:s', $rows['kaipan']); ?></td>
                            <td align="center"><?php echo date('Y-m-d H:i:s', $rows['fengpan']); ?></td>
                            <td align="center"><?php echo date('Y-m-d H:i:s', $rows['kaijiang']); ?></td>
<?php for($i=0;$i<7;$i++){ ?>                            <td align="center"><?php if(!isset($rows['value'][$i])||$rows['value'][$i]==''){ ?>--<?php }else{ ?><img src="/Lottery/Images/Ball_2/<?php echo $rows['value'][$i]; ?>.png" data-ball="<?php echo $rows['value'][$i]; ?>"><?php } ?></td>
<?php } ?>                            <td align="center"><?php echo $status[$rows['status']]; ?></td>
                            <td align="center" data-id="<?php echo $rows['id']; ?>"><a href="javascript:;" data-action="change" data-status="<?php echo $rows['status']; ?>"><?php echo $rows['status']==1?'重算':'开奖'; ?></a>&nbsp;<a href="javascript:;" data-action="modify">修改</a>&nbsp;<a href="javascript:;" data-action="delete">删除</a></td>
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
?>                        <tr style="background-color:#FFF">
                            <td colspan="14" align="center" valign="middle">
                                <div class="Pagination">
                                    <a href="<?php echo $page['cur']>1?$page['url'].'1':'javascript:;'; ?>" class="tips">首页</a>
                                    <a href="<?php echo $page['cur']>1?$page['url'].($page['cur']-1):'javascript:;'; ?>" class="tips">上一页</a>
<?php if($page['range'][0]>1){ ?>                                    <span class="dot">……</span>
<?php }for($p=$page['range'][0];$p<=$page['range'][1];$p++){ ?>                                    <a href="<?php echo $page['cur']!=$p?$page['url'].$p:'javascript:;" class="current'; ?>"><?php echo $p; ?></a>
<?php }if($page['range'][1]<$page['all']){ ?>                                    <span class="dot">……</span>
<?php } ?>                                    <a href="<?php echo $page['cur']<$page['all']?$page['url'].($page['cur']+1):'javascript:;'; ?>" class="tips">下一页</a>
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