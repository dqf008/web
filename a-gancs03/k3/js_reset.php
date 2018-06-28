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
	if ($atype == 'jsk3'){
		$caizhong = '江苏快3';
		$gameType = 'jsk3';
	}else if ($atype == 'ahk3'){
		$caizhong = '安徽快3';
		$gameType = 'ahk3';
    }else if ($atype == 'gxk3'){
        $caizhong = '广西快3';
        $gameType = 'gxk3';
	}else if ($atype == 'shk3'){
		$caizhong = '上海快3';
		$gameType = 'shk3';
	}else if ($atype == 'hbk3'){
		$caizhong = '湖北快3';
		$gameType = 'hbk3';
	}else if ($atype == 'hebk3'){
		$caizhong = '河北快3';
		$gameType = 'hbk3';
    }else if ($atype == 'fjk3'){
        $caizhong = '福建快3';
        $gameType = 'fjk3';
//    }else if ($atype == 'ffk3'){
//        $caizhong = '分分快3';
//        $gameType = 'ffk3';
//    }else if ($atype == 'sfk3'){
//        $caizhong = '三分快3';
//        $gameType = 'sfk3';
    }else if ($atype == 'bjk3'){
        $caizhong = '北京快3';
        $gameType = 'bjk3';
    }else if ($atype == 'jxk3'){
        $caizhong = '江西快3';
        $gameType = 'jxk3';
    }else if ($atype == 'jlk3'){
        $caizhong = '吉林快3';
        $gameType = 'jlk3';
    }else if ($atype == 'hnk3'){
        $caizhong = '河南快3';
        $gameType = 'hnk3';
    }else if ($atype == 'gsk3'){
        $caizhong = '甘肃快3';
        $gameType = 'gsk3';
    }else if ($atype == 'qhk3'){
        $caizhong = '青海快3';
        $gameType = 'qhk3';
    }else if ($atype == 'gzk3'){
        $caizhong = '贵州快3';
        $gameType = 'gzk3';
    }else if ($atype == 'nmgk3'){
        $caizhong = '内蒙古快3';
        $gameType = 'nmgk3';
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
		$sql_l = "INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)
		SELECT k.uid,k.username,:gameType,'RECALC',:cp_uid,:remoney,k.money-:remoney2,k.money,:creationTime FROM k_user k WHERE k.uid=:kuid";
		$stmt_l = $mydata1_db->prepare($sql_l);
		$stmt_l->execute($params_l);
		$params_c = array(':id' => $id);
		$sql_c = 'update lottery_data set bet_ok=0,win=money*odds where id=:id';
		$stmt_c = $mydata1_db->prepare($sql_c);
		$stmt_c->execute($params_c);
		$result_num = $result_num + 1;
	}
	$params = array(':qihao' => $qihao,':lottery_name'=>$atype);

    $sql = 'update lottery_k3 set ok=0 where qihao=:qihao and name=:lottery_name ';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	include_once '../../class/admin.php';
	$message = '重算:' . $caizhong . '，期数：' . $qihao . '，' . $result_num . '条注单重算！';
	admin::insert_log($_SESSION['adminid'], $message);
	echo "<script>alert('重算成功！重算".$result_num."条注单!');</script>";
	if ($_GET['t'] == 1){
		$return_url = 'lottery_auto_k3.php?lottery_type='.$atype;
		echo "<script>window.location.href='".$return_url."';</script>";
	}
}
?>