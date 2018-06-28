<?php
require_once 'AppConfig.php';
require_once 'AppUtil.php';
/**
 * 查询返回的model
 */
 class RspModel{
	public $appid = "";
	public $cusid = "";
	public $trxcode = "";
	public $timestamp = "";
	public $randomstr = "";
	public $sign = "";
	public $bizseq = "";
	public $retcode = "";
	public $retmsg = "";
	public $amount = "";
	public $trxreserve = "";
	
	//初始化
	public function init($code,$msg){
		$this->retcode = $code;
		$this->retmsg = $msg;
		$this->appid = AppConfig::APPID;
		$this->cusid = AppConfig::CUSID;
		$this->trxcode = "T001";
		$this->timestamp = date("YmdHms");
		$this->randomstr = $this->timestamp;
	}
	//对对象进行签名
	public function sign(){
		$array = array();
		foreach($this as $key => $value) {
			if($value!=""){
				$array[$key] = $value;
			}
       }
       $signStr = AppUtil::SignArray($array, AppConfig::APPKEY);
       $this->sign = $signStr;	
	}


 }
?>