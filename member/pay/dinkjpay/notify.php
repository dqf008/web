<? 
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");

require_once('merchant.php');

$dinpay_public_key = openssl_get_publickey($dinpay_public_key);

//////////////////////////接收智付服务器发送的数据//////////////////////////

$merchant_code	= $_POST["merchant_code"];

$notify_type = $_POST["notify_type"];

$notify_id = $_POST["notify_id"];

$interface_version = $_POST["interface_version"];

$sign_type = $_POST["sign_type"];

$dinpaySign = base64_decode($_POST["sign"]);

$order_no = $_POST["order_no"];

$order_time = $_POST["order_time"];

$order_amount = $_POST["order_amount"];

$extra_return_param = $_POST["extra_return_param"];

$trade_no = $_POST["trade_no"];

$trade_time = $_POST["trade_time"];

$trade_status = $_POST["trade_status"];

$bank_seq_no = $_POST["bank_seq_no"];

/////////////////////////////RSA-S验签///////////////////////////////////////

$signStr = "";

if($bank_seq_no != ""){
    $signStr = $signStr."bank_seq_no=".$bank_seq_no."&";
}

if($extra_return_param != ""){
    $signStr = $signStr."extra_return_param=".$extra_return_param."&";
}

$signStr = $signStr."interface_version=".$interface_version."&";

$signStr = $signStr."merchant_code=".$merchant_code."&";

$signStr = $signStr."notify_id=".$notify_id."&";

$signStr = $signStr."notify_type=".$notify_type."&";

$signStr = $signStr."order_amount=".$order_amount."&";

$signStr = $signStr."order_no=".$order_no."&";

$signStr = $signStr."order_time=".$order_time."&";

$signStr = $signStr."trade_no=".$trade_no."&";


$signStr = $signStr."trade_status=".$trade_status."&";

$signStr = $signStr."trade_time=".$trade_time;


if(openssl_verify($signStr,$dinpaySign,$dinpay_public_key,OPENSSL_ALGO_MD5)){
    //处理
    $order_no = trim($order_no);
    $query = $mydata1_db->query('SELECT * FROM k_money_order WHERE `mid`='.$order_no);
    if($query->rowCount()>0){
        $order = $query->fetch();
    }
    $res =insert_online_money($order['username'],$order['mid'], $order['amount'],$order['pay_online']);
    if($res){
        echo "SUCCESS";//异步通知必须响应大写SUCCESS
    }
   

    /**验签成功，在此处理业务逻辑**/

}else{
    echo "Signature verification failed";  //验签失败，业务结束
}

?>
		
		
		
	







