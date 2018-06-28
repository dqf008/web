<?php
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
$version = $_POST["version"];
$charset = $_POST["charset"];
$language = $_POST["language"];
$signType = $_POST["signType"];
$tranCode = $_POST["tranCode"];
$merchantID = $_POST["merchantID"];
$merOrderNum = $_POST["merOrderNum"];
$tranAmt = $_POST["tranAmt"];
$feeAmt = $_POST["feeAmt"];
$frontMerUrl = $_POST["frontMerUrl"];
$backgroundMerUrl = $_POST["backgroundMerUrl"];
$tranDateTime = $_POST["tranDateTime"];
$tranIP = $_POST["tranIP"];
$respCode = $_POST["respCode"];
$msgExt = $_POST["msgExt"];
$orderId = $_POST["orderId"];
$gopayOutOrderId = $_POST["gopayOutOrderId"];
$bankCode = $_POST["bankCode"];
$tranFinishTime = $_POST["tranFinishTime"];
$merRemark1 = $_POST["merRemark1"];
$merRemark2 = $_POST["merRemark2"];
$signValue = $_POST["signValue"];
$pay_mkey = $arr_online_config['国付宝2网银']['pay_mkey'];
//注意md5加密串需要重新拼装加密后，与获取到的密文串进行验签
$signValue2 = 'version=[' . $version . ']tranCode=[' . $tranCode . ']merchantID=[' . $merchantID . ']merOrderNum=[' . $merOrderNum . ']tranAmt=[' . $tranAmt . ']feeAmt=[' . $feeAmt . ']tranDateTime=[' . $tranDateTime . ']frontMerUrl=[' . $frontMerUrl . ']backgroundMerUrl=[' . $backgroundMerUrl . ']orderId=[' . $orderId . ']gopayOutOrderId=[' . $gopayOutOrderId . ']tranIP=[' . $tranIP . ']respCode=[' . $respCode . ']gopayServerTime=[]VerficationCode=[' . $pay_mkey . ']';
//VerficationCode是商户识别码为用户重要信息请妥善保存
//注意调试生产环境时需要修改这个值为生产参数
$signValue2 = md5($signValue2);
if ($signValue == $signValue2) {
    if ($respCode == '0000')
    //file_put_contents("log.txt", $merOrderNum);
    //验签成功
    //建议在此处进行商户的业务逻辑处理
    //注意返回参数中不包括用户的session、cookie
        $query = $mydata1_db->query("SELECT * FROM k_money_order WHERE `mid`='" . $merOrderNum . "'");
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
    }
    $res = insert_online_money($order['username'], $order['mid'], $order['amount'], $order['pay_online']);
    if ($res) {
        echo 'RespCode=0000|JumpURL=http://182.16.12.114/member/pay/gfb2pay/true.php?aa=5';
        //如果要正常跳转指定地址，返回应答必须符合规范，参考文档中5.	通知机制
    } else
    //验签失败
    //返回失败信息
        echo 'RespCode=9999|JumpURL=';
}