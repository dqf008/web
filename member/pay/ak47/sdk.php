<?php 
return array(
    'gateway'=>'https://gw.ak47pay.com/native',
    'debug'=>true,
    'certNo'=>'2017091718230511004',
    'password'=>'13R^pq',
    'publicKey'=>file_get_contents('server-public.cer'),
    'privateKey'=>file_get_contents('client-private.pfx'),
    
);

?>