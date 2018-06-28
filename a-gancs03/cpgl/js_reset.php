<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cpgl');
check_quanxian('cpcd');
if ($_GET['action'] == 'jsreset'){
	$qihao = $_GET['qihao'];
	$atype = $_GET['atype'];
	$t = $_GET['t'];
	$result_num = 0;
	$caizhong = '';
	$gameType = '';
	if ($atype == 'kl8'){
		$caizhong = '北京快乐8';
		$gameType = 'BJKL8';
	}else if ($atype == 'ssl'){
		$caizhong = '上海时时乐';
		$gameType = 'SHSSL';
	}else if ($atype == '3d'){
		$caizhong = '福彩3D';
		$gameType = 'FC3D';
	}else if ($atype == 'pl3'){
		$caizhong = '体彩排列三';
		$gameType = 'TCPL3';
	}else if ($atype == 'qxc'){
		$caizhong = '七星彩';
		$gameType = 'QXC';
//    }else if ($atype == 'ffqxc'){
//        $caizhong = '分分七星彩';
//        $gameType = 'FFQXC';
//    }else if ($atype == 'wfqxc'){
//        $caizhong = '五分七星彩';
//        $gameType = 'WFQXC';
    }else if ($atype == 'pcdd'){
        $caizhong = 'PC蛋蛋';
        $gameType = 'PCDD';
//    }else if ($atype == 'ffpcdd'){
//        $caizhong = '分分PC蛋蛋';
//        $gameType = 'FFPCDD';
	}else{
		exit('彩种无效，停止重算！错误提示：' . $atype);
	}
	
	$params = array(':qihao' => $qihao, ':atype' => $atype);
	$sql = 'select * from lottery_data where bet_ok=1 and mid=:qihao and atype=:atype order by id';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	while ($rows = $stmt->fetch()){
		$id = $rows['id'];
		$cp_uid = $rows['uid'];
		$username = $rows['username'];
		$money = $rows['money'];
		$win = $rows['win'];
		$remoney = 0;
		if (0 < $win){
			$remoney = $remoney - $money - $win;
		}
		$params_u = array(':username' => $username);
		$sql_u = 'select uid from k_user where username=:username limit 1';
		$stmt_u = $mydata1_db->prepare($sql_u);
		$stmt_u->execute($params_u);
		$kuid = $stmt_u->fetchColumn();
		$params_k = array(':money' => $remoney, ':kuid' => $kuid);
		$sql_k = 'update k_user set money=money+:money where uid=:kuid';
		$stmt_k = $mydata1_db->prepare($sql_k);
		$stmt_k->execute($params_k);
		$creationTime = date('Y-m-d H:i:s');
		$params_l = array(':gameType' => $gameType, ':cp_uid' => $cp_uid, ':remoney' => $remoney, ':remoney2' => $remoney, ':creationTime' => $creationTime, ':kuid' => $kuid);
		$sql_l = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)
		SELECT k.uid,k.username,:gameType,\'RECALC\',:cp_uid,:remoney,k.money-:remoney2,k.money,:creationTime FROM k_user k WHERE k.uid=:kuid ';
		$stmt_l = $mydata1_db->prepare($sql_l);
		$stmt_l->execute($params_l);
		$params_c = array(':id' => $id);
		$sql_c = 'update lottery_data set bet_ok=0,win=money*odds where id=:id';
		$stmt_c = $mydata1_db->prepare($sql_c);
		$stmt_c->execute($params_c);
		$result_num = $result_num + 1;
	}
	$params = array(':qihao' => $qihao);
	if ($atype == 'kl8'){
		$sql = 'update lottery_k_kl8 set ok=0 where qihao=:qihao ';
	}else if ($atype == 'ssl'){
		$sql = 'update lottery_k_ssl set ok=0 where qihao=:qihao ';
	}else if ($atype == '3d'){
		$sql = 'update lottery_k_3d set ok=0 where qihao=:qihao ';
	}else if ($atype == 'pl3'){
		$sql = 'update lottery_k_pl3 set ok=0 where qihao=:qihao ';
	}else if ($atype == 'qxc') {
        	$sql   = 'update lottery_k_qxc set status=0 where qishu=:qihao';
    	}else if($atype =='pcdd'){
        	$sql = 'update lottery_k_pcdd set ok=0 where qihao=:qihao';
	}else{
		exit('彩种无效，停止重算！错误提示：' . $atype);
	}
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	include_once '../../class/admin.php';
	$message = '重算:' . $caizhong . '，期数：' . $qihao . '，' . $result_num . '条注单重算！';
	admin::insert_log($_SESSION['adminid'], $message);
	echo "<script>alert('重算成功！重算".$result_num."条注单!');</script>";
	if ($_GET['t'] == 1) {
        if ($atype == 'pcdd') {
            $return_url = 'lottery_auto_pcdd.php?lottery_type='.$atype;
        } else if ($atype=='qxc'){
            $return_url = 'lottery_auto_qxc.php?lottery_type='.$atype;
        }else{
            $return_url = 'lottery_auto_' . $atype . '.php';
        }
		echo "<script>window.location.href='".$return_url."';</script>";
	}
}
?>