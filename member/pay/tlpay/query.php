<?php
	require_once 'AppConfig.php';
	require_once 'AppUtil.php';
	require_once 'RspModel.php';

	$params = array();
	foreach($_POST as $key=>$val) {//将参数遍历获取
		$params[$key] = $val;
	}
	if(count($params)<1){//如果参数为空,则不进行处理
		echo "error";
		exit();
	}
	$rsp = new RspModel();
	if(AppUtil::ValidSign($params, AppConfig::APPKEY)){//验签成功,进行业务处理返回
		//验签成功后,分公司在此跟商户的系统进行个性化对接
		$rsp->init("0000", "查询成功");//查询成功
		$rsp->amount = "1";//1分钱测试交易
		$rsp->bizseq = "20160000001";
		$rsp->trxreserve = "05|Q1#张三|Q2#186-2828-9999|Q3#广州市天河区体育西路107号|X#不显示的备注信息";
		$rsp->sign();//返回加签
	}
	else{
		$rsp->init("9999", "验证签名失败");//验证签名失败
		$rsp->sign();//返回加签
	}
	echo json_encode($rsp);

?>  
