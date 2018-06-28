<?php
function des_encode($input, $key='959923777'){
    $size = mcrypt_get_block_size('des', 'ecb');
    $pad = $size-(strlen($input)%$size);
    $input = $input.str_repeat(chr($pad), $pad);
    $td = mcrypt_module_open('des', '', 'ecb', '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $data = mcrypt_generic($td, $input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    $data = base64_encode($data);
    return preg_replace('/\s*/', '', $data);
}
function des_decode($input, $key='959923777'){
    $input = base64_decode($input);
    $td = mcrypt_module_open('des','','ecb','');
    //使用MCRYPT_DES算法,cbc模式
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    $ks = mcrypt_enc_get_key_size($td);
    mcrypt_generic_init($td, $key, $iv);
    //初始处理
    $decrypted = mdecrypt_generic($td, $input);
    //解密
    mcrypt_generic_deinit($td);
    //结束
    mcrypt_module_close($td);
    $pad = ord($decrypted{strlen($decrypted)-1});
    if($pad>strlen($decrypted)){
        return '';
    }elseif(strspn($decrypted, chr($pad), strlen($decrypted)-$pad)!=$pad){
        return '';
    }else{
        return substr($decrypted, 0, -1 * $pad);
    }
}

function dz_authcode($string, $operation='DECODE', $key='959923777', $expiry=0){
    $ckey_length = 4;

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
function params_encode($params, $des='959923777'){
    $_return = false;
    if(is_array($params)){
        $temp = array();
        foreach($params as $key=>$val){
            $temp[] = $key.'='.$val;
        }
        $_return = implode('/\\\\\\\\/', $temp);
        $_return = des_encode($_return, $des);
    }
    return $_return;
}
function get_server_ip(){
    $server_ip = '0.0.0.0';
    if(isset($_SERVER)){
        if(isset($_SERVER['SERVER_ADDR'])){
            $server_ip = $_SERVER['SERVER_ADDR'];
        }elseif(isset($_SERVER['LOCAL_ADDR'])){
            $server_ip = $_SERVER['LOCAL_ADDR'];
        }
    }elseif(function_exists('getenv')){
        $server_ip = getenv('SERVER_ADDR');
        empty($server_ip)&&$server_ip = getenv('LOCAL_ADDR');
    }elseif(function_exists('gethostbyname')){
        isset($_SERVER['SERVER_NAME'])&&$server_ip = gethostbyname($_SERVER['SERVER_NAME']);
    }
    return $server_ip;
}
// function get_client_ip(){
//     $client_ip = '0.0.0.0';
//     if(isset($_SERVER)){
//         if(isset($_SERVER['HTTP_CLIENT_IP'])){
//             $client_ip = $_SERVER['HTTP_CLIENT_IP'];
//         }elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
//             $client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
//         }else{
//             $client_ip = $_SERVER['REMOTE_ADDR'];
//         }
//     }elseif(function_exists('getenv')){
//         $client_ip = getenv('HTTP_CLIENT_IP');
//         empty($client_ip)&&$client_ip = getenv('HTTP_X_FORWARDED_FOR');
//         empty($client_ip)&&$client_ip = getenv('REMOTE_ADDR');
//     }
//     return $client_ip;
// }