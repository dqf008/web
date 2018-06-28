<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once("../include/function.php");
include_once $C_Patch . "/class/user.php";
include_once $C_Patch . "/database/mysql.config.php";
$callback = $_GET['callback'];
if(!empty($_SESSION['adminid']) && !empty($_REQUEST["uid"])){
  $uid = (int)$_REQUEST["uid"];
}else{
  $uid = $_SESSION["uid"];
}
$data = array();
if (!empty($uid)) {
    $userinfo = user::getinfo($uid);
    
    if(!empty($_GET['v']) && $_GET['v'] == '2'){
        $data['AGIN'] = sprintf("%.2f", $userinfo['agmoney']);
        $data['AG'] = sprintf("%.2f", $userinfo['agqmoney']);
        $data['BBIN'] = sprintf("%.2f", $userinfo['bbmoney']);
        $data['OG'] = sprintf("%.2f", $userinfo['ogmoney']);
        $data['MAYA'] = sprintf("%.2f", $userinfo['mayamoney']);
        $data['SHABA'] = sprintf("%.2f", $userinfo['shabamoney']);
        $data['PT'] = sprintf("%.2f", $userinfo['ptmoney']);
        $data['MW'] = sprintf("%.2f", $userinfo['mwmoney']);
        $data['KG'] = sprintf("%.2f", $userinfo['kgmoney']);
        $data['CQ9'] = sprintf("%.2f", $userinfo['cq9money']);
        $data['MG2'] = sprintf("%.2f", $userinfo['mg2money']);
        $data['VR'] = sprintf("%.2f", $userinfo['vrmoney']);
        $data['BGLIVE'] = sprintf("%.2f", $userinfo['bgmoney']);
        $data['SB'] = sprintf("%.2f", $userinfo['sbmoney']);
        $data['PT2'] = sprintf("%.2f", $userinfo['pt2money']);
        $data['OG2'] = sprintf("%.2f", $userinfo['og2money']);
        $data['DG'] = sprintf("%.2f", $userinfo['dgmoney']);
        $data['KY'] = sprintf("%.2f", $userinfo['kymoney']);
        $data['BBIN2'] = sprintf("%.2f", $userinfo['bbin2money']);
        $data['MG'] = sprintf("%.2f", $userinfo['mgmoney']);
        $json['info'] = 'ok';
        $json['data'] = $data;
        echo $callback . '(' . json_encode($json) . ')';
    }else{
        $data['info'] = 'ok';
        $data['AGIN'] = sprintf("%.2f", $userinfo['agmoney']);
        $data['AG'] = sprintf("%.2f", $userinfo['agqmoney']);
        $data['BBIN'] = sprintf("%.2f", $userinfo['bbmoney']);
        $data['OG'] = sprintf("%.2f", $userinfo['ogmoney']);
        $data['MAYA'] = sprintf("%.2f", $userinfo['mayamoney']);
        $data['SHABA'] = sprintf("%.2f", $userinfo['shabamoney']);
        $data['PT'] = sprintf("%.2f", $userinfo['ptmoney']);
        $data['MW'] = sprintf("%.2f", $userinfo['mwmoney']);
        $data['KG'] = sprintf("%.2f", $userinfo['kgmoney']);
        $data['CQ9'] = sprintf("%.2f", $userinfo['cq9money']);
        $data['MG2'] = sprintf("%.2f", $userinfo['mg2money']);
        $data['VR'] = sprintf("%.2f", $userinfo['vrmoney']);
        $data['BGLIVE'] = sprintf("%.2f", $userinfo['bgmoney']);
        $data['SB'] = sprintf("%.2f", $userinfo['sbmoney']);
        $data['PT2'] = sprintf("%.2f", $userinfo['pt2money']);
        $data['OG2'] = sprintf("%.2f", $userinfo['og2money']);
        $data['DG'] = sprintf("%.2f", $userinfo['dgmoney']);
        $data['KY'] = sprintf("%.2f", $userinfo['kymoney']);
        $data['BBIN2'] = sprintf("%.2f", $userinfo['bbin2money']);
        $data['MG'] = sprintf("%.2f", $userinfo['mgmoney']);
        $data['agName'] = $userinfo['agUserName'];
		$data['agqName'] = $userinfo['agqUserName'];
		$data['bbinName'] = $userinfo['bbinUserName'];
		$data['ogName'] = $userinfo['ogUserName'];
		$data['mayaName'] = $userinfo['mayaUserName'];
		$data['shabaName'] = $userinfo['shabaUserName'];
		$data['ptName'] = $userinfo['ptUserName'];
		$data['mwName'] = $userinfo['mwUserName'];
		$data['kgName'] = $userinfo['kgUserName'];
		$data['cq9Name'] = $userinfo['cq9UserName'];
		$data['mg2Name'] = $userinfo['mg2UserName'];
		$data['vrName'] = $userinfo['vrUserName'];
        $data['bgName'] = $userinfo['bgUserName'];
        $data['sbName'] = $userinfo['sbUserName'];
        $data['pt2Name'] = $userinfo['pt2UserName'];
        $data['og2Name'] = $userinfo['og2UserName'];
        $data['dgName'] = $userinfo['dgUserName'];
        $data['kyName'] = $userinfo['kyUserName'];
        $data['bbin2Name'] = $userinfo['bbin2UserName'];
        $data['mgName'] = $userinfo['mgUserName'];
        echo $callback . '(' . json_encode($data) . ')';
    }
    exit;
} else {
    $data['info'] = 'no';
    $data['msg'] = '<font color=red>&nbsp;--&nbsp;</font>';
    echo $callback . '(' . json_encode($data) . ')';
    exit;
}