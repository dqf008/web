<?php
header('Content-type: text/html; charset=utf-8');
class RpcClient{
	protected $url;
	protected $site_id;
	
	public function __construct($url = null, $siteId = null){
		include __DIR__ . '/../cj/include/config.php';
		empty($url) && $url = $cj_url;
		empty($siteId) && $siteId = $site_id;
		$this->url = $url;
		$this->site_id = $siteId;
	}
	
	protected function query($request){
	
	    $header[] = "Content-type: text/xml";//定义content-type为xml 
	    $header[] = "Content-length: ".strlen($request);
	    
	    $ch = curl_init();   
	    curl_setopt($ch, CURLOPT_URL, $this->url);//定义表单提交地址  
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//定义是否直接输出返回流
	    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	    $data = curl_exec($ch);  
		curl_close($ch);//关闭 
		return xmlrpc_decode($data);
	}
	
	public function __call($method,$args){
		array_unshift($args,$this->site_id);
		$request = xmlrpc_encode_request($method,$args);
		return $this->query($request);
	}
}