<?php
header('Content-type: text/html;charset=utf-8');
$dir = dirname(dirname(__FILE__)); 
include_once __DIR__ . '/config.php';
include_once __DIR__ . '/../../database/mysql.config.php';
include_once __DIR__ . '/curl_http.php';
include_once($dir."/class/cj.php");

/**
 * 解压数组字符
 */
function a_decode64($str = ''){
   if($str == '') return '';
    return  unserialize(gzuncompress(base64_decode($str))); 
   
}

function write_file($filename,$data,$method="rb+",$iflock=1){
	@touch($filename);
	$handle=@fopen($filename,$method);
	if($iflock){
		@flock($handle,LOCK_EX);
	}
	@fputs($handle,$data);
	if($method=="rb+") @ftruncate($handle,strlen($data));
	@fclose($handle);
	@chmod($filename,0777);	
	if( is_writable($filename) ){
		return true;
	}else{
		return false;
	}
}

function typeName($type){
	$str = array();
    switch ($type) {
      case 'AGIN':
        $str['title'] = 'AG国际厅';
        $str['istype'] = 'isag';
        $str['zzusername'] = 'agUserName';
        $str['zzpassword'] = 'agPassWord';
        $str['zzmoney'] = 'agmoney';
        $str['zztime'] = 'agAddtime';
        break;
      case 'AG':
        $str['title'] = 'AG极速厅';
        $str['istype'] = 'isagq';
        $str['zzusername'] = 'agqUserName';
        $str['zzpassword'] = 'agqPassWord';
        $str['zzmoney'] = 'agqmoney';
        $str['zztime'] = 'agqAddtime';
        break;
      case 'BBIN':
        $str['title'] = 'BB波音厅';
        $str['istype'] = 'isbbin';
        $str['zzusername'] = 'bbinUserName';
        $str['zzpassword'] = 'bbinPassWord';
        $str['zzmoney'] = 'bbmoney';
        $str['zztime'] = 'bbinAddtime';
        break;
      case 'OG':
        $str['title'] = 'OG东方厅';
        $str['istype'] = 'isog';
        $str['zzusername'] = 'ogUserName';
        $str['zzpassword'] = 'ogPassWord';
        $str['zzmoney'] = 'ogmoney';
        $str['zztime'] = 'ogAddtime';
        break;
      case 'MAYA':
        $str['title'] = '玛雅娱乐厅';
        $str['istype'] = 'ismaya';
        $str['zzusername'] = 'mayaUserName';
        $str['zzpassword'] = 'mayaGameMemberID';//游戏ID
        $str['zzmoney'] = 'mayamoney';
        $str['zztime'] = 'mayaAddtime';
        break;
      case 'MW':
        $str['title'] = 'MW游戏';
        $str['istype'] = 'ismw';
        $str['zzusername'] = 'mwUserName';
        $str['zzpassword'] = 'mwPassWord';
        $str['zzmoney'] = 'mwmoney';
        $str['zztime'] = 'mwAddtime';
        break;
    /*case 'MG':
        $str['title'] = 'MG电子游戏';
        $str['istype'] = 'ismg';
        $str['zzusername'] = 'mgUserName';
        $str['zzpassword'] = 'mgPassWord';
        $str['zzmoney'] = 'mgmoney';
        $str['zztime'] = 'mgAddtime';
        break;*/
    case 'MG2':
        $str['title'] = '新MG电子游戏';
        $str['istype'] = 'ismg2';
        $str['zzusername'] = 'mg2UserName';
        $str['zzpassword'] = 'mg2PassWord';
        $str['zzmoney'] = 'mg2money';
        $str['zztime'] = 'mg2Addtime';
        break;
    case 'VR':
        $str['title'] = 'VR彩票';
        $str['istype'] = 'isvr';
        $str['zzusername'] = 'vrUserName';
        $str['zzpassword'] = 'vrPassWord';
        $str['zzmoney'] = 'vrmoney';
        $str['zztime'] = 'vrAddtime';
        break;
    case 'BGLIVE':
        $str['title'] = 'BG视讯';
        $str['istype'] = 'isbg';
        $str['zzusername'] = 'bgUserName';
        $str['zzpassword'] = 'bgPassWord';
        $str['zzmoney'] = 'bgmoney';
        $str['zztime'] = 'bgAddtime';
        break;
      case 'KG':
        $str['title'] = 'AV女优';
        $str['istype'] = 'iskg';
        $str['zzusername'] = 'kgUserName';
        $str['zzpassword'] = 'kgPassWord';
        $str['zzmoney'] = 'kgmoney';
        $str['zztime'] = 'kgAddtime';
        break;
       case 'CQ9':
        $str['title'] = 'CQ9电子游戏';
        $str['istype'] = 'iscq9';
        $str['zzusername'] = 'cq9UserName';
        $str['zzpassword'] = 'cq9PassWord';
        $str['zzmoney'] = 'cq9money';
        $str['zztime'] = 'cq9Addtime';
        break;
      case 'PT':
        $str['title'] = 'PT电子游戏';
        $str['istype'] = 'ispt';
        $str['zzusername'] = 'ptUserName';
        $str['zzpassword'] = 'ptPassWord';
        $str['zzmoney'] = 'ptmoney';
        $str['zztime'] = 'ptAddtime';
        break;
      case 'SHABA':
        $str['title'] = '沙巴体育';
        $str['istype'] = 'isshaba';
        $str['zzusername'] = 'shabaUserName';
        $str['zzpassword'] = 'shabaPassWord';
        $str['zzmoney'] = 'shabamoney';
        $str['zztime'] = 'shabaAddtime';
        break;
       case 'HUNTER':
       	$str['zzmoney'] = 'agmoney';
        $str['zztime'] = 'agAddtime';
        break;
		case 'YOPLAY':
       	$str['zzmoney'] = 'agmoney';
        $str['zztime'] = 'agAddtime';
        break;
       case 'XIN':
       	$str['zzmoney'] = 'agmoney';
        $str['zztime'] = 'agAddtime';
        break;
       case 'BG':
        $str['zzmoney'] = 'agmoney';
        $str['zztime'] = 'agAddtime';
        break;
        case 'SBTA':
        $str['zzmoney'] = 'agmoney';
        $str['zztime'] = 'agAddtime';
        break;
       /*case 'IPM':
        $str['title'] = 'IPM体育';
        $str['istype'] = 'isipm';
        $str['zzusername'] = 'ipmUserName';
        $str['zzpassword'] = 'ipmPassWord';
        $str['zzmoney'] = 'ipmmoney';
        $str['zztime'] = 'ipmAddtime';
        break;*/
        case 'SB':
        $str['title'] = '申博视讯';
        $str['istype'] = 'issb';
        $str['zzusername'] = 'sbUserName';
        $str['zzpassword'] = 'sbPassWord';
        $str['zzmoney'] = 'sbmoney';
        $str['zztime'] = 'sbAddtime';
        break;
        case 'RT':
        $str['zzmoney'] = 'sbmoney';
        $str['zztime'] = 'sbAddtime';
        break;
        case 'LAX':
        $str['zzmoney'] = 'sbmoney';
        $str['zztime'] = 'sbAddtime';
        break;
        case 'PT2':
        $str['title'] = '新PT电子';
        $str['istype'] = 'ispt2';
        $str['zzusername'] = 'pt2UserName';
        $str['zzpassword'] = 'pt2PassWord';
        $str['zzmoney'] = 'pt2money';
        $str['zztime'] = 'pt2Addtime';
        break;
        case 'OG2':
        $str['title'] = '新OG东方厅';
        $str['istype'] = 'isog2';
        $str['zzusername'] = 'og2UserName';
        $str['zzpassword'] = 'og2PassWord';
        $str['zzmoney'] = 'og2money';
        $str['zztime'] = 'og2Addtime';
        break;
        case 'DG':
        $str['title'] = 'DG视讯';
        $str['istype'] = 'isdg';
        $str['zzusername'] = 'dgUserName';
        $str['zzpassword'] = 'dgPassWord';
        $str['zzmoney'] = 'dgmoney';
        $str['zztime'] = 'dgAddtime';
        break;
        case 'KY':
        $str['title'] = '开元棋牌';
        $str['istype'] = 'isky';
        $str['zzusername'] = 'kyUserName';
        $str['zzpassword'] = 'kyPassWord';
        $str['zzmoney'] = 'kymoney';
        $str['zztime'] = 'kyAddtime';
        break;
    }

    return $str;
}

function zzType($type,$username,$password){
	$type = strtoupper($type);
	$par = array();

	switch ($type) {
		case 'AGIN':
			$par['params'][':agUserName'] = $username;
			$par['params'][':agPassWord'] = $password;
			$par['strsql'] = 'agUserName = :agUserName,agPassWord=:agPassWord,isag=1,agAddtime=now()';
			$par['where'] = 'isag=0';
			break;
		case 'AG':
			$par['params'][':agqUserName'] = $username;
			$par['params'][':agqPassWord'] = $password;
			$par['strsql'] = 'agqUserName = :agqUserName,agqPassWord=:agqPassWord,isagq=1,agqAddtime=now()';
			$par['where'] = 'isagq=0';
			break;
		case 'BBIN':
			$par['params'][':bbinUserName'] = $username;
			$par['params'][':bbinPassWord'] = $password;
			$par['strsql'] = 'bbinUserName = :bbinUserName,bbinPassWord=:bbinPassWord,isbbin=1,bbinAddtime=now()';
			$par['where'] = 'isbbin=0';
			break;
		case 'OG':
			$par['params'][':ogUserName'] = $username;
			$par['params'][':ogPassWord'] = $password;
			$par['strsql'] = 'ogUserName = :ogUserName,ogPassWord=:ogPassWord,isog=1,ogAddtime=now()';
			$par['where'] = 'isog=0';
			break;
		case 'SHABA':
			$par['params'][':shabaUserName'] = $username;
			$par['params'][':shabaPassWord'] = $password;
			$par['strsql'] = 'shabaUserName = :shabaUserName,shabaPassWord=:shabaPassWord,isshaba=1,shabaAddtime=now()';
			$par['where'] = 'isshaba=0';
			break;
        /*case 'IPM':
            $par['params'][':ipmUserName'] = $username;
            $par['params'][':ipmPassWord'] = $password;
            $par['strsql'] = 'ipmUserName = :ipmUserName,ipmPassWord=:ipmPassWord,isipm=1,ipmAddtime=now()';
            $par['where'] = 'isipm=0';
            break;
		case 'MG':
			$par['params'][':mgUserName'] = $username;
			$par['params'][':mgPassWord'] = $password;
			$par['strsql'] = 'mgUserName = :mgUserName,mgPassWord=:mgPassWord,ismg=1,mgAddtime=now()';
			$par['where'] = 'ismg=0';
			break;*/
        case 'MW':
            $par['params'][':mwUserName'] = $username;
            $par['params'][':mwPassWord'] = $password;
            $par['strsql'] = 'mwUserName = :mwUserName,mwPassWord=:mwPassWord,ismw=1,mwAddtime=now()';
            $par['where'] = 'ismw=0';
            break;
		case 'PT':
			$par['params'][':ptUserName'] = $username;
			$par['params'][':ptPassWord'] = $password;
			$par['strsql'] = 'ptUserName = :ptUserName,ptPassWord=:ptPassWord,ispt=1,ptAddtime=now()';
			$par['where'] = 'ispt=0';
			break;
	}
	return $par;

}
function twoSampleChoose($balls,$content){
    //content为字符串
    $betBalls[0]=$content[0];
    $betBalls[1]= $content[1];
    $betBalls[2] = $content[2];
    asort($betBalls);
    if($balls == $betBalls){
        return true;
    }
    return false;
}

function twoDiff($balls,$content){
    $balls=implode('',$balls);
    if(strpos($balls,$content)!=false){
        return true;
    }
    return false;
}
function isThreeEvenNumber($balls,$content=''){
    $balls=implode('',$balls);
    if(empty($content) && in_array($balls,array('123','234','345','456'))){
        return true;
    }
    if($balls == $content){
        return true;
    }
    return false;
}
function isThreeSameBalls($balls){

    $repeat = getRepeat($balls);
    if(count($repeat)==2){
        return $repeat[0];
    }
    return 0;
}
function isNoSameBalls($balls,$betBalls){

    $betBalls = array($betBalls[0],$betBalls[1],$betBalls[2]);
    asort($betBalls);
    if(count(array_unique($balls))==3 && $balls== $betBalls){
        return true;
    }
    return false;
}
/**
 * 获取重复数字
 * @param $arr
 *
 * @return mixed
 */
function getRepeat($arr){
    $unique_arr = array_unique($arr);
    // 获取重复数据的数组
    $repeat_arr = array_unique(array_diff_assoc($arr, $unique_arr));
    return $repeat_arr;
}
