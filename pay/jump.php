<?php
function getAllHeader(){
	$headers = [];
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
}
$content = file_get_contents('php://input');
$headers = getAllHeader();
$header_joins = [];
foreach ($headers as $k => $v) {
    if ($k == 'X-Pingplusplus-Signature' || $k == 'Content-Type')
    array_push($header_joins, $k . ': ' . $v);
}

function post($url, $headers, $raw_data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  // POST 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $raw_data);  // Post Data
    curl_setopt($ch, CURLOPT_URL, $url);//设置要访问的 URL
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent); //模拟用户使用的浏览器
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1 );  // 使用自动跳转
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);  //设置超时时间
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1 ); // 自动设置Referer
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 收集结果而非直接展示
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // 自定义 Headers
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

$result = post('http://9014.cc/pay/notice.php', $header_joins, $content);

echo $result;