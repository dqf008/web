<?php
/**
 * Created by PhpStorm.
 * User: yangzhe
 * Date: 2017/9/8
 * Time: 21:13
 */

require('Security.php');

class yidao
{
    private $requestUrl = "http://121.196.208.145:8080/externalSendPay/gateWayPay";

    private $merchantCode = "SSSSS00002";
    private $merKey = "P253WWICRZPN3H1C";
    private $TardeCode = "123456789";
    private $version = "1.0.1";
    private $notifyUrl = "http://baidu.xjlwe.top1/pay/index.php?c=Alipay&a=callBackAli";
    private $returnUrl = "http://baidu.xjlwe.top1/pay/index.php?c=Alipay&a=callBackAli";
    private $expireTime = 30;
    private $tranTp = 0;
    private $sign;
    private $subject;
    private $amount;
    private $orgOrderNo;
    private $bankWay = "CCB";
    private $extra_para = "1";
    private $sec;

    /**
     * yidao constructor.
     * @param $merchantCode 商户号
     * @param $merKey  报文加密
     * @param $TardeCode 签名KEY
     */
    public function __construct($merchantCode = false, $merKey =false, $TardeCode =false)
    {
        if ($merchantCode)
        $this->setMerchantCode($merchantCode);
        if ($merKey)
        $this->setMerKey($merKey);
        if ($TardeCode)
        $this->setTardeCode($TardeCode);
        $this->sec = new Security();
    }


    /**
     * 调起网关支付
     * @param $orgOrderNo 订单号 唯一
     * @param $subject 商品名称
     * @param $amount  金额 元
     * @return string 返回请求数据
     */
    public function pay($orgOrderNo, $subject, $amount, $bankWay = "CCB")
    {
        $this->setOrgOrderNo($orgOrderNo);
        $this->setSubject($subject);
        $this->setAmount($amount);
        $this->setBankWay($bankWay);
        //组装参数
        $arr['merchantCode'] = $this->merchantCode;
        $arr['amount'] = $this->amount;
        $arr['version'] = $this->version;
        $arr['notifyUrl'] = urlencode($this->notifyUrl);
        $arr['tranTp'] = $this->tranTp;
        $arr['orgOrderNo'] = $this->orgOrderNo;
        $arr['num'] = '1';
        $arr['desc'] = '1';
        $arr['subject'] = $this->subject;
        $arr['extra_para'] = $this->extra_para;
        $arr['bankWay'] = $this->bankWay;
        $arr['returnUrl'] =urlencode($this->returnUrl);
        return $this->sign($arr);
    }
    /**
     * 调起快捷支付
     * @param $orgOrderNo 订单号 唯一
     * @param $subject 商品名称
     * @param $amount  金额 元
     * @return string 返回请求数据
     */
    public function kjpay($orgOrderNo, $subject, $amount,$cardName,$cardNo,$cardType,$certType,$certNo,$mobile)
    {
        $this->setOrgOrderNo($orgOrderNo);
        $this->setSubject($subject);
        $this->setAmount($amount);
        //组装参数
        $arr['merchantCode'] = $this->merchantCode;
        $arr['amount'] = $this->amount;
        $arr['version'] = $this->version;
        $arr['notifyUrl'] = urlencode($this->notifyUrl);
        $arr['tranTp'] = $this->tranTp;
        $arr['orgOrderNo'] = $this->orgOrderNo;
        $arr['num'] = '1';
        $arr['desc'] = '1';
        $arr['cardName'] = $cardName;
        $arr['cardNo'] = $cardNo;
        $arr['cardType'] = $cardType;
        $arr['certType'] = $certType;
        $arr['certNo'] = $certNo;
        $arr['mobile'] = $mobile;

        $arr['subject'] = $this->subject;
        $arr['extra_para'] = $this->extra_para;
        $arr['bankWay'] = $this->bankWay;
        $arr['returnUrl'] =urlencode($this->returnUrl);
        return $this->sign($arr);
    }


    /**
     * 查询订单状态
     * @param $merchOrderId  订单号
     * @param $txnTime 下单时间
     * @return string 返回请求字符串
     */
    public function queryOrder($merchOrderId,$txnTime){

        $arr['merchantCode']=$this->merchantCode;
        $arr['merchOrderId']=$merchOrderId;
        $arr['tradeTime']=$txnTime;
        $str = self::sortData($arr);
        $baseStr = base64_encode($str);
        $aesPrivage = $this->sec->encrypt($baseStr, $this->merKey);
        $aesPrivage = strtoupper($aesPrivage);
        $sign = strtoupper(md5($aesPrivage . $this->TardeCode));
        $arr['sign'] = $sign;
        $str2 = self::sortData($arr);
        $baseStr2 = base64_encode($str2);

        $transData = $this->sec->encrypt($baseStr2, $this->merKey);
        $data = array();
        $data['merchantCode'] = $this->merchantCode;
        $data['transData'] = $transData;
        $data['TradeCode'] = $this->TardeCode;
        $reqStr = "reqJson=".json_encode($data);
        return $reqStr;
    }

    /**
     * @param $arr 参数数组
     * @return string 签名MD5
     */
    public function sign($arr)
    {
        $str = self::sortData($arr);
        $baseStr = base64_encode($str);
        $aesPrivage = $this->sec->encrypt($baseStr, $this->merKey);
        $aesPrivage = strtoupper($aesPrivage);
        $sign = strtoupper(md5($aesPrivage . $this->TardeCode));
        $arr['sign'] = $sign;
        $str2 = self::sortData($arr);
        $baseStr2 = base64_encode($str2);
        $transData = $this->sec->encrypt($baseStr2, $this->merKey);
        $data = array();
        $data['merchantCode'] = $this->merchantCode;
        $data['transData'] = $transData;
        $data['extra_para'] = $this->extra_para;
        return $data;
    }


    /**
     * 解析验证签名
     * @param $str 通知字符串
     * @return array|bool   验签成功返回解析后参数，失败返回false
     */
    public function VerifySign($str){
        //解密
        $sec_dec = $this->sec->decrypt($str,$this->merKey);
        $sec_dec = base64_decode($sec_dec);
        //分割
        $pra = explode("&",$sec_dec);
        $result_pra = array();//异步回调的参数
        foreach($pra as $thispra){
            $temp_pra = explode("=",$thispra);
            $result_pra[$temp_pra[0]] = $temp_pra[1];
        }
        $sign = $result_pra["sign"];
        //移除sign
        unset($result_pra["sign"]);
        $result_str = $this->sortData($result_pra);
        $baseStr = base64_encode($result_str);
        $aesPrivage = $this->sec->encrypt($baseStr, $this->merKey);
        $aesPrivage = strtoupper($aesPrivage);
        $sign2 = strtoupper(md5($aesPrivage . $this->TardeCode));
        if ($sign==$sign2){
            return $result_pra;
        }else{
            return false;
        }

    }

    /**
     * 排序
     * @param $arr
     * @return mixed|string
     */
    public function sortData($arr)
    {
        array_walk($arr, function (&$v) {
            if (is_array($v)) {
                array_walk_recursive($v, function (&$v1) {
                    if (is_object($v1)) {
                        $v1 = get_object_vars($v1);
                        ksort($v1);
                    }
                });
                ksort($v);
            }
        });

        ksort($arr);
        key($arr);
        $str = "";
        foreach (array_keys($arr) as $key) {
            $str .= $key . "=" . $arr[$key] . "&";
        }
        $str = rtrim($str, "&");
        $str = str_replace(" ", "", $str);
        return $str;
    }


    /**
     * @return mixed
     */
    public function getOrgOrderNo()
    {
        return $this->orgOrderNo;
    }

    /**
     * @param mixed $orgOrderNo
     */
    public function setOrgOrderNo($orgOrderNo)
    {
        $this->orgOrderNo = $orgOrderNo;
    }

    /**
     * @return string
     */
    public function getExtraPara()
    {
        return $this->extra_para;
    }

    /**
     * @param string $extra_para
     */
    public function setExtraPara($extra_para)
    {
        $this->extra_para = $extra_para;
    }

    /**
     * @return string
     */
    public function getMerKey()
    {
        return $this->merKey;
    }

    /**
     * @param string $merKey
     */
    public function setMerKey($merKey)
    {
        $this->merKey = $merKey;
    }

    /**
     * @return string
     */
    public function getTardeCode()
    {
        return $this->TardeCode;
    }

    /**
     * @param string $TardeCode
     */
    public function setTardeCode($TardeCode)
    {
        $this->TardeCode = $TardeCode;
    }

    /**
     * @return Security
     */
    public function getSec()
    {
        return $this->sec;
    }

    /**
     * @param Security $sec
     */
    public function setSec($sec)
    {
        $this->sec = $sec;
    }


    /**
     * @return mixed
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @param mixed $sign
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }


    /**
     * @return mixed
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * @param mixed $requestUrl
     */
    public function setRequestUrl($requestUrl)
    {
        $this->requestUrl = $requestUrl;
    }

    /**
     * @return mixed
     */
    public function getMerchantCode()
    {
        return $this->merchantCode;
    }

    /**
     * @param mixed $merchantCode
     */
    public function setMerchantCode($merchantCode)
    {
        $this->merchantCode = $merchantCode;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getBankWay()
    {
        return $this->bankWay;
    }

    /**
     * @param string $bankWay
     */
    public function setBankWay($bankWay)
    {
        $this->bankWay = $bankWay;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getNotifyUrl()
    {
        return $this->notifyUrl;
    }

    /**
     * @param mixed $notifyUrl
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;
    }

    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * @param mixed $returnUrl
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }

    /**
     * @return int
     */
    public function getExpireTime()
    {
        return $this->expireTime;
    }

    /**
     * @param int $expireTime
     */
    public function setExpireTime($expireTime)
    {
        $this->expireTime = $expireTime;
    }

    /**
     * @return int
     */
    public function getTranTp()
    {
        return $this->tranTp;
    }

    /**
     * @param int $tranTp
     */
    public function setTranTp($tranTp)
    {
        $this->tranTp = $tranTp;
    }

}
