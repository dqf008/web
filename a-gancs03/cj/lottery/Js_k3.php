<?php header('Content-Type:text/html;charset=utf-8');
include_once '../../../include/config.php';
include_once '../../../database/mysql.config.php';
//include 'Auto_Choose5.php';
$lotteryType = $_REQUEST['lottery_type'];
$lotteryNames = [
    'jsk3'  => '江苏快3',
    'ahk3'  => '安徽快3',
    'gxk3'  => '广西快3',
    'shk3'  => '上海快3',
    'hbk3'  => '湖北快3',
    'hebk3' => '河北快3',
    'fjk3'  => '福建快3',
//    'ffk3'  => '分分快3',
//    'sfk3'  => '三分快3',
    'bjk3'  => '北京快3',
    'gsk3'  => '甘肃快3',
    'gzk3'  => '贵州快3',
    'hnk3'  => '河南快3',
    'jlk3'  => '吉林快3',
    'jxk3'  => '江西快3',
    'nmgk3' => '内蒙古快3',
    'qhk3'  => '青海快3',
];
$qi = floatval($_REQUEST['qihao']);
$params = array(':qihao' => $qi);
$sql = "select * from lottery_k3 where qihao=:qihao and `name`='$lotteryType' order by id desc limit 1";
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rs = $stmt->fetch();
$balls = $rs['balls'];
if (empty($balls))
{
    exit('获取开奖结果失败，停止结算！');
}
$paramsMain = array(':qihao' => $qi,':atype'=>$lotteryType);
$sqlMain = "select * from lottery_data where atype=:atype and bet_ok=0 and mid=:qihao order by bet_time asc";
$stmtMain = $mydata1_db->prepare($sqlMain);
$stmtMain->execute($paramsMain);
while ($rows = $stmtMain->fetch())
{
    $wins = ($rows['money'] * $rows['odds']) - $rows['money'];
    $balls = explode(',',$rows['balls']);
    asort($balls);
    $sum   = array_sum($balls);
    $bigOrSmall = $sum >10?'大':'小';
    $singOrDouble = singleOrDouble($sum);
    $range  = getRange($sum,$singOrDouble);
    switch ($rows['btype']){
        case '和值':
            if($rows['content'] == $bigOrSmall ||$rows['content'] ==$singOrDouble || $rows['content']==$sum || $rows['content']==$range){
                win_update($wins, $rows['id'], $rows['money'] * $rows['odds'], $rows['username']);
            }else{
                no_win_update($rows['id']);
            }
            break;
        case '三同号':
            if($rows['ctype']=='三同号通选' && count(array_unique($balls))==1){
                win_update($wins, $rows['id'], $rows['money'] * $rows['odds'], $rows['username']);
            }elseif ($rows['ctype']=='三同号单选' && threeSameJudge($balls,$rows['content'])){
                win_update($wins, $rows['id'], $rows['money'] * $rows['odds'], $rows['username']);
            }else{
                no_win_update($rows['id']);
            }
            break;
        case '三不同号':
            if($rows['ctype']=='三连号通选' && isThreeEvenNumber($balls)){
                win_update($wins, $rows['id'], $rows['money'] * $rows['odds'], $rows['username']);
            }elseif ($rows['ctype']=='三连号单选' && isThreeEvenNumber($balls,$rows['content'])){
                win_update($wins, $rows['id'], $rows['money'] * $rows['odds'], $rows['username']);
            }elseif($row['ctype']=='三不同号' && isThreeDiff($balls,$row['content'])){
                win_update($wins, $rows['id'], $rows['money'] * $rows['odds'], $rows['username']);
            }else{
                no_win_update($rows['id']);
            }
            break;
        case '二不同号':
            if(twoDiff($balls,$rows['content'])){
                win_update($wins, $rows['id'], $rows['money'] * $rows['odds'], $rows['username']);
            }else{
                no_win_update($rows['id']);
            }
            break;
        case '二同号':
            if($rows['ctype']=='二同号复选' && twoDiff($balls,$rows['content'])){
                win_update($wins, $rows['id'], $rows['money'] * $rows['odds'], $rows['username']);
            }else if($rows['ctype']=='二同号单选' && twoSampleChoose($balls,$rows['content'])){
                win_update($wins, $rows['id'], $rows['money'] * $rows['odds'], $rows['username']);
            }else{
                no_win_update($rows['id']);
            }
            break;
        default:
            no_win_update($rows['id']);
            break;
    }
    $creationTime = date('Y-m-d H:i:s');
    $id = $rows['id'];
    $params = array(':creationTime' => $creationTime, ':id' => $id,':gameType'=>$lotteryType);
    $sql = "\r\n\t\t" . 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,:gameType,\'RECKON\',lottery_data.uid,lottery_data.win+lottery_data.money,k_user.money-(lottery_data.win+lottery_data.money),k_user.money,:creationTime FROM k_user,lottery_data  WHERE k_user.username=lottery_data.username  AND lottery_data.bet_ok=1 AND lottery_data.id=:id';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
}
$params = array(':qihao' => $qi,':name'=>$lotteryType);
$msql = 'update lottery_k3 set ok=1 where qihao=:qihao and name=:name';
$stmt = $mydata1_db->prepare($msql);
$stmt->execute($params) || exit('期数修改失败!!!');
if ($_GET['t'] == 1)
{?> <script>window.location.href='../../k3/lottery_auto_k3.php?lottery_type=<?php echo $lotteryType ?>';</script><?php }

function twoSampleChoose($balls,$content){
    //content为字符串
    $betBalls[0]=$content[0];
    $betBalls[1]= $content[1];
    $betBalls[1] = $content[2];
    asort($betBalls);
    if($balls == $betBalls){
        return true;
    }
    return false;
}
function twoDiff($balls,$content){
    $balls=implode('',$balls);
    if(strpos($balls,$content)!==false){
        return true;
    }
    return false;
}
function isThreeDiff($balls,$content){
    $balls=implode('',$balls);
    if($balls==$content){
        return true;
    }
    return false;
}
function isThreeEvenNumber($balls,$content =''){
    $balls=implode('',$balls);
    if(empty($content) && in_array($balls,array('123','234','345','456'))){
        return true;
    }
    if($balls == $content){
        return true;
    }
    return false;
}
function threeSameJudge($balls,$content){
    $balls=implode('',$balls);
    if($balls==$content){
        return true;
    }
    return false;
}
function singleOrDouble($sum){

    if ($sum % 2 == 0){
        return '双';
    }else{
        return '单';
    }
}
function getRange($sum,$singOrDouble){
    if($sum >9){
        if($singOrDouble=='单'){
            return '大单';
        }else{
            return '大双';
        }
    }else{
        if($singOrDouble=='单'){
            return '小单';
        }else{
            return '小双';
        }
    }
}

function win_update($win, $id, $money, $username)
{
    global $mydata1_db;
    $params = array(':win' => $win, ':id' => $id);
    $msql = 'update lottery_data set win=:win,bet_ok=1 where id=:id';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('中奖修改失败' . $id);
    $params = array(':money' => $money, ':username' => $username);
    $msql = 'update k_user set money=money+:money where username=:username';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('会员加奖失败' . $id);
}
function no_win_update($id)
{
    global $mydata1_db;
    $params = array(':id' => $id);
    $msql = 'update lottery_data set win=-money,bet_ok=1 where id=:id';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('注单修改失败!!!' . $id);
}?>