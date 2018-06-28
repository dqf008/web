<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

function authCode($string, $operation='DECODE', $key='default', $expiry=0){
    $ckey_length = 4;

    $key=='default'&&session_name()&&$key = session_name();
    $key = md5($key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length?($operation=='DECODE'?substr($string, 0, $ckey_length):substr(md5(microtime()), -$ckey_length)):'';

    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);

    $string = $operation=='DECODE'?base64_decode(substr($string, $ckey_length)):sprintf('%010d', $expiry?$expiry+time():0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for($i=0;$i<=255;$i++){
        $rndkey[$i] = ord($cryptkey[$i%$key_length]);
    }

    for($j=$i=0;$i<256;$i++){
        $j = ($j+$box[$i]+$rndkey[$i])%256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for($a=$j=$i=0;$i<$string_length;$i++){
        $a = ($a+1)%256;
        $j = ($j+$box[$a])%256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result.= chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
    }

    if($operation=='DECODE'){
        if((substr($result, 0, 10)==0||substr($result, 0, 10)-time()>0)&&substr($result, 10, 16)==substr(md5(substr($result, 26).$keyb), 0, 16)){
            return substr($result, 26);
        } else {
            return '';
        }
    }else{
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}
if(isset($_GET['code'])&&($_GET['code'] = authCode($_GET['code']))!=''){
    $_GET['code'] = unserialize($_GET['code']);
    $output = '<form action="'.$_GET['code']['uri'].'" method="post">';
    $output.= '<input type="hidden" name="pay_online" value="'.$_GET['code']['type'].'" />';
    $output.= '<input type="hidden" name="S_UID" value="'.$_GET['code']['uid'].'" />';
    $output.= '<input type="hidden" name="S_Name" value="'.$_GET['code']['username'].'" />';
    $output.= '<input type="hidden" name="MOAmount" value="'.$_GET['code']['amount'].'" />';
    $output.= '<input type="submit" value="点击继续" />';
    $output.= '</form>';
    $output.= '<script type="text/javascript">!function(e){return "undefined"!=typeof e[0]&&"undefined"!=typeof e[0].submit&&e[0].submit()}(document.getElementsByTagName("form"))</script>';
}else{
    $url = (strtolower($_SERVER['HTTPS'])=='on'?'https':'http').'://';
    $url.= $_SERVER['HTTP_HOST'].':';
    $url.= $_SERVER['SERVER_PORT'];
    $url.= $_SERVER['REQUEST_URI'];
    $url = dirname($url);
    $output = '<script type="text/javascript">!function(e){e.location.href="'.$url.'"}(window)</script>';
}
echo '<!DOCTYPE html><html><head><title></title></head><body>'.$output.'</body></html>';
