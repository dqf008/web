<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
include_once('KDPay.class.php');
$P_UserId = $pay_mid;
$SalfStr = $pay_mkey;
$faveValue = $amount;
$pd_id = $payChannel;
$kdPay = new KDPay($P_UserId, $SalfStr);
//设置充值方式
$kdPay->setPayChannel($pd_id);
//设置金额
$kdPay->setFaveValue($faveValue);
$kdPay->setOrder($_payId);
//设置同步和异步地址
$kdPay->setNotifyAndResult($notice_url, $notice_url);
//获取跳转地址
$redirect_url = $kdPay->getRedirectUrl();
/************************
 * 下步进行订单入库保存
 * 订单号为$kdpay->getOrder();
 */
//下面这句是提交到API
header("location:$redirect_url");