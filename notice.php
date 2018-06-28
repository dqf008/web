<?php 
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
$time = time() - filemtime('notice.json');
if($time<30){
	$sys_notice = file_get_contents('notice.json');
}else{
	$sys_notice = file_get_contents("http://103.248.137.174/index.php?g=Home&m=Index&a=index");
	$sys_notice = json_decode($sys_notice, true);
	foreach ($sys_notice['data'] as $k => $v) {
	    unset($sys_notice['data'][$k]['id']);
	    unset($sys_notice['data'][$k]['updatetime']);
	    unset($sys_notice['data'][$k]['endtime']);
	    unset($sys_notice['data'][$k]['is_open']);
	    unset($sys_notice['data'][$k]['starttime']);
	    unset($sys_notice['data'][$k]['sort']);
	    unset($sys_notice['data'][$k]['platform']);
	    $sys_notice['data'][$k]['addtime'] = date('Y-m-d H:i', $v['addtime']);
	}
	$sys_notice = json_encode($sys_notice);
	file_put_contents('notice.json',$sys_notice);
}
echo $sys_notice;