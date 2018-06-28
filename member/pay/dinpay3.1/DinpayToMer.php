<?php // TODO: SEPARATE
header('content-Type: text/html;charset=utf-8');
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
$extra_return_param = $_POST['extra_return_param'];
$pay_online = base64Decode(explode('-', $extra_return_param)[0]);
include_once '../moneyconfig.php';
include_once '../moneyfunc.php';

file_put_contents('aa.txt', $pay_pubKey);
include_once 'Query.php';

$pubKey = openssl_get_publickey($pay_pubKey);
if (basename(dirname($notice_url)) != basename(dirname(__FILE__)))
{?> 当前第三方已变更,请联系客服!<?php exit();
}
$merchant_code = $_POST['merchant_code'];
$notify_type = $_POST['notify_type'];
$notify_id = $_POST['notify_id'];
$interface_version = $_POST['interface_version'];
$sign_type = $_POST['sign_type'];
$dinpaySign = base64_decode($_POST['sign']);
$order_no = $_POST['order_no'];
$order_time = $_POST['order_time'];
$order_amount = $_POST['order_amount'];
$trade_no = $_POST['trade_no'];
$trade_time = $_POST['trade_time'];
$trade_status = $_POST['trade_status'];
$bank_seq_no = $_POST['bank_seq_no'];
$signStr = '';
if ($bank_seq_no != '')
{
	$signStr = $signStr . 'bank_seq_no=' . $bank_seq_no . '&';
}
if ($extra_return_param != '')
{
	$signStr = $signStr . 'extra_return_param=' . $extra_return_param . '&';
}
$signStr = $signStr . 'interface_version=' . $interface_version . '&';
$signStr = $signStr . 'merchant_code=' . $merchant_code . '&';
$signStr = $signStr . 'notify_id=' . $notify_id . '&';
$signStr = $signStr . 'notify_type=' . $notify_type . '&';
$signStr = $signStr . 'order_amount=' . $order_amount . '&';
$signStr = $signStr . 'order_no=' . $order_no . '&';
$signStr = $signStr . 'order_time=' . $order_time . '&';
$signStr = $signStr . 'trade_no=' . $trade_no . '&';
$signStr = $signStr . 'trade_status=' . $trade_status . '&';
$signStr = $signStr . 'trade_time=' . $trade_time;
if (openssl_verify($signStr, $dinpaySign, $pubKey, OPENSSL_ALGO_MD5))
{
	$s_name = explode('-', $extra_return_param)[1];
	$m_orderid = $order_no;
	$m_oamount = $order_amount;
	if (($payquery == 1) && !queryOrder($m_orderid, $m_oamount))
	{?> 订单查询失败,请联系客服,提交您的订单号!订单号:<?=$m_orderid;
		exit();
	}
	$result_insert = insert_online_money($s_name, $m_orderid, $m_oamount);
	if ($result_insert == -1)
	{?> 会员信息不存在，无法入账<?php }
	else if ($result_insert == 0)
	{?> 会员已经入账，无需重复入账<?php }
	else if ($result_insert == -2)
	{?> 数据库操作失败<?php }
	else if ($result_insert == 1)
	{?> SUCCESS <br />支付成功 <br/>交易金额：<?=$m_oamount;
	}
	else
	{?> 支付失败<?php }
}
else
{?> 验签失败<?php }?> <html> 
  <head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  </head> 
  <body> 
  <!-- 此处可添加页面展示  提示相关信息给消费者  --> 
  </body> 
  </html>