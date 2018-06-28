<?php 
ini_set('display_errors','on');
session_start();    



include_once __DIR__ . '/common/commonfun.php';
include_once __DIR__ . '/ip.php';
if(empty($_SESSION['client_ip']) || $_SESSION['client_ip'] != get_client_ip()){
	$_SESSION['client_ip'] = get_client_ip();
	$_SESSION['site'] = getCityCurl($_SESSION['client_ip']);
}
if(empty($_SESSION['site'])){
	$_SESSION['site'] = getCityCurl($_SESSION['client_ip']);
}
include_once 'include/config.php';
website_close();
include_once 'database/mysql.config.php';
include_once 'common/logintu.php';
include_once 'common/function.php';

$_SESSION['enter'] = 0;
$indexurl = 'myhome.php';
$top_username = '';

$preurl = prefix_url();
$uid = $_SESSION['uid'];
if(!$uid){
	if (isset($_GET['f'])){
		$params = array(':username' => htmlEncode($_GET['f']));
		$stmt = $mydata1_db->prepare('select uid from k_user where username=:username and is_daili=1 limit 1');
		$stmt->execute($params);
		$query_uid = $stmt->fetchColumn();
		if (0 < $query_uid)
		{
			setcookie('f', $query_uid);
			setcookie('tum', htmlEncode($_GET['f']));
			$indexurl = 'myreg.php';
			$top_username = trim($_GET['f']);
		}
	}else{
		$murl = $preurl;
		if(!filter_var($preurl, FILTER_VALIDATE_IP)){//判断是否为IP地址
			$arr = explode('.',$preurl); //用 . 号截取url分割
			if(sizeof($arr)>2){//有前缀域名
				$ms = "";
				for($i=1;$i<sizeof($arr);$i++){
					$ms .= $arr[$i].".";
				}
				$murl = rtrim($ms,".");
			}
			
		}

		$params = array(':url'=>"%".$murl);
		$sql	=	'select * from dlurl where url like :url and isok = 1 limit 1';
		$stmt   =   $mydata1_db->prepare($sql);
		$stmt   ->  execute($params);
		$tcou   =   $stmt->rowCount();
		$rs     =   $stmt->fetch();
		if($tcou){
			$dl_username = $rs['dl_username'];
			$dl_url = $rs['url'];
			
			$arr = explode('.',$dl_url); //用 . 号截取url分割
			if(sizeof($arr)>2){//有前缀域名
				$ms = "";
				for($i=1;$i<sizeof($arr);$i++){
					$ms .= $arr[$i].".";
				}
				$dl_url = rtrim($ms,".");
			}
			if($dl_url == $murl){//排出域名前面不一致  如:aXXX.com与XXX.com只是匹配到后面部分
				$params = array(':dl_username'=>htmlEncode($dl_username));
				$sql    =    "select uid from k_user where username=:dl_username and is_daili=1 limit 1";
		        $stmt   =   $mydata1_db->prepare($sql);
				$stmt   ->  execute($params);
				$tcou   =   $stmt->rowCount();
				$rs     =   $stmt->fetch();
		        if($tcou){
		            setcookie('f',intval($rs["uid"]));
		            setcookie('tum',htmlEncode($dl_username));
		            $indexurl = "myreg.php";
		            $top_username = htmlEncode($dl_username);
		        }
		    }
	    }

	}
}

if ((ismobile() == true) && ($_GET['machinetype'] != 'pc')){
	if ($top_username != ''){
?> 
<script>window.location.href='/m/index.php?f=<?=$top_username ;?>';</script>
<?php }else{?> 
	<script>window.location.href='/m/index.php';</script>
<?php }
	exit();
}
?>
<!DOCTYPE html>
<head>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title><?=$web_site['web_title']?></title>
	<!--meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /-->
	<script type="text/javascript" src="skin/js/jquery-1.7.2.min.js?_=171"></script>
	<script type="text/javascript" src="skin/js/top.js"></script>
	<style type="text/css">
	html{width: 100%;height: 100%;}
	body{width: 100%;height: 100%;margin: 0;overflow:hidden;overflow-x: auto;*overflow:visible;*overflow-x:visible;_overflow:hidden;_overflow-x:auto;}
	</style>
</head>
<body>
<iframe id="index" name="index" src="<?=$indexurl?>" frameborder="0" width="100%" height="100%" marginheight="0" marginwidth="0" scrolling="auto"></iframe>
<script language="JavaScript">  //导航页，需要的特定
        var idx = "<?=$_REQUEST['idx']?>";
		if(idx != null && idx != '' && idx != 0){  
			var index = parseInt(idx);
			menu_url(index);
		}
</script>
</body>
</html>
<?php 
function prefix_url(){
	$s = (!isset($_SERVER['HTTPS']) ? '' : $_SERVER['HTTPS'] == 'on' ? 's' : '');
	$protocol = strtolower($_SERVER['SERVER_PROTOCOL']);
	$protocol = substr($protocol, 0, strpos($protocol, '/')) . $s . '://';
	$port = ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443 ? '' : ':' . $_SERVER['SERVER_PORT']);
	$server_name = (isset($_SERVER['HTTP_HOST']) ? strtolower($_SERVER['HTTP_HOST']) : isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] . $port : getenv('SERVER_NAME') . $port);
	return $server_name;
}

function isMobile(){
	if (isset($_SERVER['HTTP_X_WAP_PROFILE']))	{
		return true;
	}
	if (isset($_SERVER['HTTP_VIA']))
	{
		return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
	}
	if (isset($_SERVER['HTTP_USER_AGENT']))
	{
		$clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
		if (preg_match('/(' . implode('|', $clientkeywords) . ')/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
		{
			return true;
		}
	}
	if (isset($_SERVER['HTTP_ACCEPT']))
	{
		if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && ((strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false) || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
		{
			return true;
		}
	}
	return false;
}?>