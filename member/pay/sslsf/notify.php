<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
file_put_contents("success.txt", json_encode($_REQUEST) . "\n", FILE_APPEND);
$MemberID = $_REQUEST['MemberID']; //商户号
$TerminalID = $_REQUEST['TerminalID']; //商户终端号
$TransID = $_REQUEST['TransID']; //流水号
$Result = $_REQUEST['Result']; //支付结果
$ResultDesc = $_REQUEST['ResultDesc']; //支付结果描述
$FactMoney = $_REQUEST['FactMoney']; //实际成功金额
$AdditionalInfo = $_REQUEST['AdditionalInfo']; //订单附加消息
$SuccTime = $_REQUEST['SuccTime']; //支付完成时间
$Md5Sign = $_REQUEST['Md5Sign']; //md5签名
$Md5key = $arr_online_config['闪付微信']['pay_mkey'];
$MARK = "~|~";
//MD5签名格式
$WaitSign = md5('MemberID=' . $MemberID . $MARK . 'TerminalID=' . $TerminalID . $MARK . 'TransID=' . $TransID . $MARK . 'Result=' . $Result . $MARK . 'ResultDesc=' . $ResultDesc . $MARK . 'FactMoney=' . $FactMoney . $MARK . 'AdditionalInfo=' . $AdditionalInfo . $MARK . 'SuccTime=' . $SuccTime . $MARK . 'Md5Sign=' . $Md5key);
if ($Md5Sign == $WaitSign) {
    $sql = "SELECT * FROM k_money_order WHERE `mid`='{$TransID}'";
    $query = $mydata1_db->query($sql);
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
        if ($order) {
            $res = insert_online_money($order['username'], $TransID, $order['amount'], $order['pay_online']);
            if ($res) {
                exit("ok");
            } else {
                exit("error");
            }
        }
    }
} else {
    echo ("Md5CheckFail'"); //MD5校验失败
    //处理想处理的事情
}