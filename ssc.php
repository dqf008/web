<?php
$include_file = 'ssc';
$type = intval($_GET['t']);
switch($type){
    case 2:
        $type = 'gdkl10'; //广东快乐10分
    	break;
    case 3:
        $type = 'pk10'; //北京赛车PK拾
    	break;
    case 4:
        $type = 'kl8'; //北京快乐8
    	break;
    case 5:
        $type = 'shssl'; //上海时时乐
    	break;
    case 6:
        $type = '3d'; //福彩3D
    	break;
    case 7:
        $type = 'pl3'; //排列三
    	break;
    case 8:
        $type = 'qxc'; //七星彩
    	break;

    case 100:
        $type = 'jssc'; //极速赛车
    	break;
    case 101:
        $type = 'jsssc'; //极速时时彩
    	break;
    case 102:
        $type = 'jslh'; //极速六合
    	break;

    default:
        $type = 'cqssc'; //重庆时时彩
    break;
}
include_once dirname(__FILE__).'/xp.php';