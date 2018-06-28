<?php

	/**
	 * [Send GET Request]
	 * @param  [string] $url    [API URL]
	 * @param  [string] $fParms [params]
	 * @param  [string] $priKey [Vendor key]
	 * @return [obj]          [obj->Status = 0 success, 1 fail, obj->Data= , obj->ErrorCode=, obj->ErrorMsg= ]
	 */
	function send_kg_get_obj($url, $fParms, $priKey)
	{
		$postArray =[];
		$postArray['params'] = get_aes_string($fParms);
		$postArray['key'] = md5($fParms.$priKey);
		$url = $url."?params=".$postArray['params']."&key=".$postArray['key'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($ch);
		$result = [];

		$return_obj = new stdclass;
		$return_obj->Status = "0";
		$return_obj->Data = "";
		$return_obj->ErrorCode = "";
		$return_obj->ErrorMsg = "";

		if (!curl_errno($ch)) {
			switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
				case 200:  # OK
					$return_obj = json_decode($output);
					break;
				default:
					$return_obj->ErrorCode = $http_code;
					$return_obj->ErrorMsg = "Unexpected HTTP code: ".$http_code;
			}
		}
		curl_close($ch);
		return $return_obj;
	}

	/**
	 * [Send GET Request]
	 * @param  [string] $url    [API URL]
	 * @param  [string] $fParms [params]
	 * @param  [string] $priKey [Vendor key]
	 * @return [string]          ["Status= ,Data= ,ErrorCode= ,ErrorMsg= "]
	 */
	function send_kg_get_str($url, $fParms, $priKey)
	{
		$postArray =[];
		$postArray['params'] = get_aes_string($fParms);
		$postArray['key'] = md5($fParms.$priKey);
		$url = $url."?params=".$postArray['params']."&key=".$postArray['key'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($ch);
		$result = "Status='0',Data='',";

		if (!curl_errno($ch)) {
			switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
				case 200:  # OK
					$result = $output;
					break;
				default:
					$result = $result."ErrorMsg = Unexpected HTTP code:".$http_code;
			}
		}
		curl_close($ch);
		return $result;
	}



	/**
	 * [Send GET Request]
	 * @param  [string] $url    [API URL]
	 * @param  [string] $fParms [params]
	 * @param  [string] $priKey [Vendor key]
	 * @return [array]          ["Status"= 0 success, 1 fail, "Data"= , "ErrorCode"= , "ErrorMsg"= ]
	 */
	function send_kg_get($url, $fParms, $priKey)
	{
		$postArray =[];
		$postArray['params'] = get_aes_string($fParms);
		$postArray['key'] = md5($fParms.$priKey);
		$url = $url."?params=".$postArray['params']."&key=".$postArray['key'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($ch);
		$result = [];
		if (!curl_errno($ch)) {
		  switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
		    case 200:  # OK
					$explodeOutput = explode(",",$output);
					foreach ($explodeOutput as $value) {
						$temp = explode("=",$value,2);
						if(count($temp) >1){
							$result[$temp[0]] = $temp[1];
						}
					}
					if( !isset($result["Status"])){
						$result["Status"] = 0;
						$result['ErrorMsg'] = $output;
					}
		      break;
		    default:
					$result['Status'] = 0;
					$result['ErrorMsg'] = "Unexpected HTTP code: ".$http_code;
		  }
		}
		curl_close($ch);
		return $result;
	}

	/**
	 * [Get AES Encrypt params String]
	 * @param  [string] $params [Unencrypt params]
	 * @return [string]        [Encrypt params]
	 */
	function get_aes_string($params)
	{
		$kgAESKey = "3f203ac36b4262ba28afa0366f4a63b9";
		$kgAESIV = "650DD7EB2B195F0A";
		return openssl_encrypt($params, 'aes-256-cbc', $kgAESKey, 0, $kgAESIV);
	}


	/**
	 * [Get Valid KG-API params string]
	 * @param  [string] $buId     [厂商 Id]
	 * @param  [string] $method   [API method]
	 * @param  [array] $dtlParms  [API params]
	 * @return [string]           [Valid get string]
	 */
	function get_format_string($buId, $method, $dtlParms)
	{
		$postString = "CTGent=".$buId.",Method=".$method;
		$parmsString = "";
		foreach ($dtlParms as $key => $value) {
		  	$parmsString = $parmsString.$key."=".$value.",";
		}
		return $postString.",".$parmsString;
	}

	/**
	 * [建立玩家]
	 * @param  [string] $buId      [厂商 Id]
	 * @param  [string] $priKey    [厂商 key]
	 * @param  [array] $userParms  array("Loginname"=>, "Secure Token"=>, "NickName"=>, "Oddtype"=>"A", "Cur"=>"CNY")
	 * @param  [string] $APIUrl    [API Url]
	 * @return [boolean]           [result]
	 */
	function kg_player_create($buId, $priKey, $userParms, $APIUrl)
	{
		$createRet = send_kg_get($APIUrl, get_format_string($buId, "lg", $userParms), $priKey);
		return json_encode($createRet);
	}

	/**
	 * [玩家登入]
	 * @param  [string] $buId      	[厂商 Id]
	 * @param  [string] $priKey    	[厂商 key]
	 * @param  [array] $userParms 	array("Loginname"=>, "SecureToken"=>)
	 * @param  [string] $APIUrl   	[API Url]
	 * @return [boolean]        	[result]
	 */
	function kg_player_login($buId, $priKey, $userParms, $APIUrl)
	{
		$lgRet = send_kg_get($APIUrl, get_format_string($buId, "lg", $userParms), $priKey);
		return json_encode($lgRet);
	}

	/**
	 * [存款]
	 * @param  [string] $buId      	[厂商 Id]
	 * @param  [string] $priKey    	[厂商 key]
	 * @param  [array]  $userParms 	array("Loginname"=>, "Billno"=>(First letter should Big), "Credit"=>(integer and less than one million ), "Cur"=>"CNY")
	 * @param  [string] $APIUrl  	[API Url]
	 * @return [boolean]        	[result]
	 */
	function kg_player_trans_deposit($buId, $priKey, $userParms, $APIUrl)
	{

		$userParms['Type'] = "100";
		$tcRet = send_kg_get($APIUrl, get_format_string($buId, "tc", $userParms), $priKey);

		if($tcRet["Status"] == "1")
		{
			$kgOrderNumber = $tcRet["Data"];
			$userParms['TGSno'] = $kgOrderNumber;
			$tccRet = send_kg_get($APIUrl, get_format_string($buId, "tcc", $userParms), $priKey);
			return json_encode($tccRet);
		}
		else
		{
			return json_encode($tcRet);
		}
	}

	/**
	 * [提款]
	 * @param  [string] $buId     	[厂商 Id]
	 * @param  [string] $priKey   	[厂商 key]
	 * @param  [array] $userParms 	array("Loginname"=>, "Billno"=>(First letter should Big), "Credit"=>(integer and less than one million ), "Cur"=>"CNY")
	 * @param  [string] $APIUrl   	[API Url]
	 * @return [boolean]       	 	[result]
	 */
	function kg_player_trans_withdrawal($buId, $priKey, $userParms, $APIUrl)
	{
		$userParms['Type'] = "200";
		$tcRet = send_kg_get($APIUrl, get_format_string($buId, "tc", $userParms), $priKey);

		if($tcRet["Status"] == "1")
		{
			$userParms['TGSno'] = $tcRet["Data"];
			$tccRet = send_kg_get($APIUrl, get_format_string($buId, "tcc", $userParms), $priKey);
			return json_encode($tccRet);
		}else
		{
			return json_encode($tcRet);
		}
	}

	/**
	 * [查询转账订单状态]
	 * @param  [string] $buId     	[厂商 Id]
	 * @param  [string] $priKey   	[厂商 key]
	 * @param  [array]  $userParms 	array("Billno"=>, "Cur"=>"CNY",)
	 * @param  [string] $APIUrl   	[API Url]
	 * @return [string]         	[status] (0=未处理、1=已完成、2=失败)
	 */
	function kg_player_getOrderStatus($buId, $priKey, $userParms, $APIUrl)
	{
		$gbRet = send_kg_get($APIUrl, get_format_string($buId, "qos", $userParms), $priKey);
		return json_encode($gbRet);
	}

	/**
	 * [余额查询]
	 * @param  [string] $buId     	[厂商 Id]
	 * @param  [string] $priKey   	[厂商 key]
	 * @param  [array]  $userParms 	array("Loginname"=>, "Cur"=>"CNY",)
	 * @param  [string] $APIUrl   	[API Url]
	 * @return [string]         	[balance]
	 */
	function kg_player_balance($buId, $priKey, $userParms, $APIUrl)
	{
		$gbRet = send_kg_get($APIUrl, get_format_string($buId, "gb", $userParms), $priKey);
		return json_encode($gbRet);
	}

	 /**
	 * [日期区间取得投注总页数]
	 * @param  [string] $buId     	[廠商 Id]
	 * @param  [string] $priKey   	[廠商 key]
	 * @param  [array]  $userParms 	array("Start"=>開始時間, "End"=>結束時間)
	 * @param  [string] $APIUrl   	[API Url]
	 * @return [string]         	[JSON]
	 */
	function kg_player_getPagesWithDate($buId, $priKey, $userParms, $APIUrl)
	{
		$gbRet = send_kg_get_obj($APIUrl, get_format_string($buId, "GET_PAGES_WITH_DATE", $userParms), $priKey);
		return json_encode($gbRet);
	}
	
	/**
	 * [日期区间指定页数取得投注纪录]
	 * @param  [string] $buId     	[廠商 Id]
	 * @param  [string] $priKey   	[廠商 key]
	 * @param  [array]  $userParms 	array("Start"=>開始時間, "End"=>結束時間,"PageNum"=>"指定頁數")
	 * @param  [string] $APIUrl   	[API Url]
	 * @return [string]         	[JSON]
	 */
	function kg_player_getRecordsWithDateOnPage($buId, $priKey, $userParms, $APIUrl)
	{
		$gbRet = send_kg_get_obj($APIUrl, get_format_string($buId, "GET_RECORDS_WITH_DATE_ON_PAGE", $userParms), $priKey);
		return json_encode($gbRet);
	}
	
	/**
	 * [查询4层jp彩金数值]
	 * @param  [string] $buId     	[厂商 Id]
	 * @param  [string] $priKey   	[厂商 key]
	 * @param  [array]  $userParms 	array()
	 * @param  [string] $APIUrl   	[API Url]
	 * @return [string]         	[JSON]
	 */
	function kg_player_getJPNumber($buId, $priKey, $userParms, $APIUrl)
	{
		$gbRet = send_kg_get_obj($APIUrl, get_format_string($buId, "gjp", $userParms), $priKey);
		return json_encode($gbRet);
	}

	/**
	 * [取得游戏连结]
	 * @param  [string] $buId      [厂商 Id]
	 * @param  [string] $priKey    [厂商 Key]
	 * @param  [array]  $userParms array("Loginname"=>, "SecureToken"=>,"GameId"=>, "Cur"=>"CNY","Oddtype"=>"A","HomeURL"=>)
	 * @param  [string] $APIUrl    [API Url]
	 * @return [string]            [Game link]
	 */
	function kg_fw_game_opt($buId, $priKey, $userParms, $APIUrl)
	{
		$fwRet = send_kg_get($APIUrl, get_format_string($buId, "fwgame_opt", $userParms), $priKey);
		return json_encode($fwRet);
	}

	/**
	 * [直接导向游戏网页]
	 * @param  [string] $buId      [厂商 Id]
	 * @param  [string] $priKey    [厂商 Key]
	 * @param  [array]  $userParms array("Loginname"=>, "SecureToken"=>,"GameId"=>, "Cur"=>"CNY","Oddtype"=>"A","HomeURL"=>)
	 * @param  [string] $APIUrl    [API Url]
	 *
	 */
	function kg_fw_game($buId, $priKey, $userParms, $APIUrl)
	{
		$url = $APIUrl;
		$fParms = get_format_string($buId, "fwgame", $userParms);
		$priKey = $priKey;

		$postArray =[];
		$postArray['params'] = get_aes_string($fParms);
		$postArray['key'] = md5($fParms.$priKey);
		$url = $url."?params=".$postArray['params']."&key=".$postArray['key'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($ch);

	}

 ?>
