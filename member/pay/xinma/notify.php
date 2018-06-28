<?php
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
require_once "utils.php";
file_put_contents("success.txt", file_get_contents("php://input") . "\n", FILE_APPEND);
//$_REQUEST = '{"createTime":"20171213101224","status":"02","nonceStr":"7dUNLPZboJJxlll6KVymZHlzMqZrkdpG","resultDesc":"成功","outTradeNo":"151313123333871","sign":"0617BD9C55F61ABA934032CF748B34B5","productDesc":"测试支付描述","orderNo":"p2017121310122500086432","branchId":"171200273152","resultCode":"00","resCode":"00","payType":"10","resDesc":"成功","orderAmt":100}';
$_REQUEST = file_get_contents("php://input");
$data = json_decode($_REQUEST);
$appKey = $arr_online_config['新码微信']['pay_mkey']; //注意，Key是根据商户密钥去做调整, 跟DEMO下单页面填写的是一样的
if ($data->resultCode == '00' && $data->resCode == '00') {
    $resultToSign = array();
    foreach ($data as $key => $value) {
        if ($key != 'sign') {
            $resultToSign[$key] = $value;
        }
    }
    $str = formatBizQueryParaMap($resultToSign);
    global $SignKey;
    $resultSign = strtoupper(md5($str . "&key=" . $appKey));
    if ($resultSign != $data->sign) {
        echo '签名验证失败';
    } else {
        //echo '订单通知支付成功';
        $mid = $data->outTradeNo; //订单号
        $sql = "SELECT * FROM k_money_order WHERE `mid`='{$mid}'";
        $query = $mydata1_db->query($sql);
        if ($query->rowCount() > 0) {
            $order = $query->fetch();
            if ($order) {
                $res = insert_online_money($order['username'], $data->outTradeNo, $data->orderAmt / 100, $order['pay_online']);
                if ($res) {
                    $responseToServer = array();
                    $responseToServer['resDesc'] = 'SUCCESS';
                    $responseToServer['resCode'] = '00';
                    //返回给服务器
                    echo json_encode($responseToServer);
                }
            }
        }
        //注意，接入方系统要自己去更新相应订单的状态（建议根据outTradeNo）。而因为网络等原因，通知可能会触发多次，业务系统也要做好判断，防止同个订单被重复处理。
        //另外，前端页面要提示支付成功的，可以通过类似ajax持续去接入方后台数据库查订单状态。后台回调接收服务器的回调数据后更新订单状态为已支付。这时候ajax查询到已支付，页面就提示成功。
    }
} else {
    echo $data->resDesc;
}