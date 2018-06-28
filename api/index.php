<?php 
header("Access-Control-Allow-Origin: *");
define('API','on');
header("Content-Type=application/json;charset=UTF-8 ");
session_start();
if(!empty($_SERVER['PATH_INFO'])) {
	$path = $_SERVER['PATH_INFO'];
}else if(!empty($_SERVER['QUERY_STRING'])) {
	$path = $_SERVER['QUERY_STRING'];
}else{
	die('PATH ERROR');
}
include __DIR__ . "/../class/Db.class.php";
$params = explode('/', strtolower($path));
switch ($params[1]) { #加载指定文件
    case 'tclist': 
    	$list = get_tclist(); 
    	die(json_encode(['code'=>'00','data'=>$list]));
    case 'tcinfo':
    	$id = (int)$params[2];
    	$info = get_tcinfo($id);
    	die(json_encode(['code'=>'00','data'=>$info]));
    case 'close':
    	close();
    	die();
    default:
        # code...
        break;
}
function close(){
	if($_SERVER['REMOTE_ADDR'] != '103.248.137.174') die();
	$DIR = $_SERVER['DOCUMENT_ROOT'];
	$input = file_get_contents("php://input");
	is_null(json_decode($input, true)) && $input = '';
	file_put_contents($DIR.'/cache/game.close', $input);
	echo 'ok';
}

function get_tclist(){
	$db = new DB();
	$row = $db->row('select title,content from webinfo where code="main-tcconfig"');
	$config = json_decode($row['content'], true);
	
	$data = array();
	$data['title'] = !empty($row['title'])?$row['title']:'平台公告';
	$data['color'] = !empty($config['color'])?$config['color']:'#D99A22';
	$data['time'] = (int)$config['time'];
	$data['mini'] = !empty($config['mini'])?$config['mini']:'0';
	
	$list = $db->query('select id,title,code from webinfo where code like "main-tc-%" order by code desc');
	foreach($list as $k=>$v) $list[$k]['sort'] = explode("-",$v['code'])[2];
	$arr1 = array_map(create_function('$n', 'return $n["sort"];'), $list);
    array_multisort($arr1,SORT_DESC,$list);
    foreach($list as $k=>$v) unset($list[$k]['code'],$list[$k]['sort']);
	$data['list'] = $list;
	return $data;
}

function get_tcinfo($id){
	$db = new DB();
	$row = $db->row('select content from webinfo where code like "main-tc-%" and id=:id order by code desc',['id'=>$id]);
	$content = str_replace('<p></p>','',str_replace('<p><br>','<p>',str_replace('<br></p>','</p>',$row['content'])));
	return $content;
}