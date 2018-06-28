<?php

require_once __DIR__ . '/conf.php';

class  RpcClient
{
    protected $url;

    public function __construct($url = '')
    {
        if ($url == '') {
            $this->url = Conf::CJ_URL();
        } else {
            $this->url = $url;
        }
    }

    protected function query($request)
    {

        $header[] = "Content-type: text/xml";//定义content-type为xml
        $header[] = "Content-length: " . strlen($request);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);//定义表单提交地址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//定义是否直接输出返回流
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        $data = curl_exec($ch);
        curl_close($ch);//关闭

        return xmlrpc_decode($data);
    }

    public function __call($method, $args)
    {
        $request = xmlrpc_encode_request($method, $args);
        return $this->query($request);
    }
}