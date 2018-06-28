<?php
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
file_put_contents("success.txt", json_encode($_POST) . "\n", FILE_APPEND);
$ReturnArray = array( // 返回字段
    "memberid" => $_POST["memberid"], // 商户ID
    "orderid" => $_POST["orderid"], // 订单号
    "amount" => $_POST["amount"], // 交易金额
    "datetime" => $_POST["datetime"], // 交易时间
    "returncode" => $_POST["returncode"] //响应码
);
$Md5key = $arr_online_config['E宝支付']['pay_mkey']; //密钥（跳转过程中，请检查密钥是否有泄露！）
ksort($ReturnArray);
reset($ReturnArray);
$md5str = "";
foreach ($ReturnArray as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
$sign = strtoupper(md5($md5str . "key=" . $Md5key));
if ($sign == $_POST["sign"]) {
    if ($_POST["returncode"] == "00000") {
        //数据处理---开始
        $mid = $_POST["orderid"]; //订单号
        $sql = "SELECT * FROM k_money_order WHERE `mid`='{$mid}'";
        $query = $mydata1_db->query($sql);
        if ($query->rowCount() > 0) {
            $order = $query->fetch();
            if ($order) {
                $res = insert_online_money($order['username'], $_POST["orderid"], $order['amount'], $order['pay_online']);
                if ($res) {
                    //数据处理---结束
                    //业务处理完成务必输出success
                    exit('success');
                }
            }
        }        
    } else
        exit($_POST["returncode"]);
} else
    exit('签名错误');