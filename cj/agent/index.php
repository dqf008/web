<?php
// 代理数据统计过程可能比较消耗系统资源，建议在非高峰时段运行
(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '127.0.0.1') && exit('Access Denied'); 
set_time_limit(0);
define('IN_AGENT', dirname(__FILE__).'/');

header('Content-Type: text/html; charset=utf-8');
include_once (IN_AGENT.'../include/function.php');
include_once (IN_AGENT.'../../agent/include/functions.php');

// 缓存代理列表
$agent_list = [];
$agent_data_list = [];
$agent_groups = [];
$agent_default = 0;
$time_list = [];
$count_data = 0;

$start_time = strtotime(isset($_GET['date'])&&!empty($_GET['date'])?$_GET['date']:date('Y-m-d'));
$end_time = $start_time-(isset($_GET['days'])&&!empty($_GET['days'])?$_GET['days']*86400:0);
if(date('H')=='17'){
    $agent_config = 0;
    $agent_config_file = IN_AGENT.'../../cache/agent.time.php';
    file_exists($agent_config_file)&&$agent_config = include($agent_config_file);
    if($agent_config>time()){
        $end_time-= 86400;
    }else{
        switch (date('w')){
            case 1:
                $end_time-= 86400*7; // 整理上周数据
                break;
            case 3:
                $end_time-= 86400*30; // 整理最近30天数据
                break;
            default:
                $end_time-= 86400;
                break;
        }
        file_put_contents($agent_config_file, '<?php'.PHP_EOL.'return '.(time()+79200).';');
    }
}
//$start_time = strtotime(date('2018-01-03'));
//$end_time = $start_time-(30*86400);
while (count($time_list)<=30) {
    if($start_time>=$end_time){
        $time_list[] = $start_time;
        $start_time-= 86400;
    }else{
        break;
    }
}

$handler = opendir(IN_AGENT.'data/');
while (($filename = readdir($handler)) !== false) {
    if($filename!='.'&&$filename!='..'&&substr($filename, -10)=='.agent.php'){
        $agent_data_list[] = realpath(IN_AGENT.'data/'.$filename);
    }
}
closedir($handler);

$stmt = $mydata1_db->query('SELECT `id`, `tid`, `default`, `value` FROM `agent_config` WHERE `uid`=0 AND `tid`=0');
while($rows = $stmt->fetch()){
    $rows['value'] = unserialize($rows['value']);
    $agent_groups[$rows['id']] = $rows;
    $rows['default']==1&&$agent_default = $rows['id'];
}

$stmt = $mydata1_db->query('SELECT `u`.`uid`, `u`.`username`, `u`.`top_uid`, `c`.`id`, `c`.`tid`, `c`.`value` FROM `k_user` AS `u` LEFT JOIN `agent_config` AS `c` ON `u`.`uid`=`c`.`uid` WHERE `u`.`is_daili`=1 AND `u`.`is_delete`=0 AND `u`.`is_stop`=0 ORDER BY `u`.`uid` ASC');
while ($rows = $stmt->fetch()) {
    if(!empty($rows['value'])&&!empty($rows['tid'])){
        $rows['value'] = unserialize($rows['value']);
    }else if($agent_default>0){
        $rows['value'] = $agent_groups[$agent_default]['value'];
        $rows['tid'] = $agent_groups[$agent_default]['id'];
        $params = [
            ':uid' => $rows['uid'],
            ':tid' => $rows['tid'],
            ':username' => $rows['username'],
        ];
        if(empty($rows['id'])){
            $params[':value'] = 'a:0:{}';
            $sql = 'INSERT INTO `agent_config` (`uid`, `tid`, `username`, `value`) VALUES (:uid, :tid, :username, :value)';
        }else{
            $params[':id'] = $rows['id'];
            $sql = 'UPDATE `agent_config` SET `uid`=:uid, `tid`=:tid, `username`=:username WHERE `id`=:id';
        }
        $stmt1 = $mydata1_db->prepare($sql);
        $stmt1->execute($params);
    }else{
        continue;
    }
    $agent_list[$rows['uid']] = $rows;
}

$min_days = 0;
$file = IN_AGENT.'../../cache/agent.conf.php';
if(file_exists($file)){
    $config = include($file);
    isset($config['ValidMember'])&&$min_days = intval($config['ValidMember']);
    $min_days<0&&$min_days = 0;
}

foreach ($agent_list as $uid => $user) {
    $agent_data = [];
//    $min_days = $agent_groups[$user['tid']]['value']['yx_v1'];
    $stmt = $mydata1_db->prepare('SELECT `uid`, `username`, `is_daili`, `top_uid` FROM `k_user` WHERE `top_uid`=:uid AND `is_delete`=0 AND `is_stop`=0');
    $stmt->execute([':uid' => $uid]);
    while ($rows = $stmt->fetch()) {
        if($min_days>0){
            $valid_time_list = [];
            foreach($time_list as $time){
                if(valid_member($rows['uid'], $time, $min_days)){
                    $valid_time_list[] = $time;
                }
            }
        }else{
            $valid_time_list = $time_list;
        }
        if(!empty($valid_time_list)){
            $data = get_data($rows['uid'], $rows['username'], $valid_time_list);
            $agent_data = sum_data($agent_data, $data);
        }
    }
    foreach($time_list as $time){
        $params = [
            ':uid' => $uid,
            ':time' => $time,
        ];
        $stmt = $mydata1_db->prepare('SELECT `id` FROM `agent_cache` WHERE `uid`=:uid AND `cache_date`=:time');
        $stmt->execute($params);
        $rows = $stmt->fetch();
        if(isset($agent_data[$time])){
            if($rows){
                $params[':id'] = $rows['id'];
                $sql = 'UPDATE `agent_cache` SET `value`=:value WHERE `id`=:id AND `uid`=:uid AND `cache_date`=:time';
            }else{
                $sql = 'INSERT INTO `agent_cache` (`uid`, `cache_date`, `value`) VALUES (:uid, :time, :value)';
            }
            $params[':value'] = serialize($agent_data[$time]);
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $count_data++;
        }else if($rows){
            $mydata1_db->query('DELETE FROM `agent_cache` WHERE `id`='.$rows['id']);
        }
    }
}

function get_data($uid, $username, $time_list){
    global $mydata1_db, $agent_data_list;

    $result = [];
    foreach($agent_data_list as $filename){
        $data = include($filename);
        $result = sum_data($result, $data);
    }

    return $result;
}

function sum_data($return=[], $data=[]){
    foreach($data as $date=>$list){
        foreach($list as $key=>$value){
            isset($return[$date])||$return[$date] = [];
            isset($return[$date][$key])||$return[$date][$key] = [
                'name' => $value['name'],
                'data' => [],
            ];
            foreach($value['data'] as $k=>$v){
                isset($return[$date][$key]['data'][$k])||$return[$date][$key]['data'][$k] = 0;
                $return[$date][$key]['data'][$k]+= $v;
            }
        }
    }
    return $return;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>代理数据统计</title>
    <style type="text/css">
        <!--
        body,td,th {
            font-size: 12px;
        }
        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }
        -->
    </style></head>
<body>

<script>
    <!--

    var limit="600"
    if (document.images){
        var parselimit=limit
    }
    function beginrefresh(){
        if (!document.images)
            return
        if (parselimit==1)
            window.location.reload()
        else{
            parselimit-=1
            curmin=Math.floor(parselimit)
            if (curmin!=0)
                curtime=curmin+"秒后自动获取!"
            else
                curtime=cursec+"秒后自动获取!"
            timeinfo.innerText=curtime
            setTimeout("beginrefresh()",1000)
        }
    }
    window.onload=beginrefresh
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left" style="padding-left:10px; padding-top:10px; line-height:22px;">
            <input type=button name=button value="刷新" onClick="window.location.reload()">
            <span id="timeinfo"></span><br />

            <font color="#FF0000">本次更新、添加<?=$count_data?>条记录</font></td>
    </tr>
</table>
</body>
</html>

