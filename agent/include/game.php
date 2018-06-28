<?php
defined('IN_AGENT')||exit('Access denied');

$return = [];
$return['menu'] = [
	'lottery' => '彩票游戏',
	'sports' => '体育赛事',
	'live' => '真人娱乐',
	'game' => '电子游戏',
];
$return['live'] = [];
$return['game'] = [];
$return['sports'] = [
	'sports_ds' => '体育单式',
	'sports_cg' => '体育串关',
];
$return['lottery'] = [
	'lottery_pk10' => '北京赛车PK拾',
	'lottery_cqssc' => '重庆时时彩',
	'lottery_tjssc' => '天津时时彩',
	'lottery_xjssc' => '新疆时时彩',
	'lottery_xyft' => '幸运飞艇',
	'lottery_gdkl10' => '广东快乐10分',
    'lottery_tjkl10' => '天津快乐10分',
	'lottery_cqkl10' => '重庆快乐10分',
	'lottery_hnkl10' => '湖南快乐10分',
	'lottery_sxkl10' => '山西快乐10分',
	'lottery_ynkl10' => '云南快乐10分',
	'lottery_gdchoose5' => '广东11选5',
	'lottery_sdchoose5' => '山东11选5',
	'lottery_fjchoose5' => '福建11选5',
	'lottery_bjchoose5' => '北京11选5',
	'lottery_ahchoose5' => '安徽11选5',
	'lottery_jsk3' => '江苏快3',
	'lottery_fjk3' => '福建快3',
	'lottery_gxk3' => '广西快3',
	'lottery_ahk3' => '安徽快3',
	'lottery_shk3' => '上海快3',
	'lottery_hbk3' => '湖北快3',
	'lottery_hebk3' => '河北快3',
	'lottery_jlk3' => '吉林快3',
	'lottery_gzk3' => '贵州快3',
	'lottery_bjk3' => '北京快3',
	'lottery_gsk3' => '甘肃快3',
	'lottery_nmgk3' => '内蒙古快3',
	'lottery_jxk3' => '江西快3',
	'lottery_ffk3' => '分分快3',
	'lottery_sfk3' => '超级快3',
	'lottery_wfk3' => '好运快3',
	'lottery_shssl' => '上海时时乐',
	'lottery_pl3' => '排列三',
	'lottery_3d' => '福彩3D',
	'lottery_kl8' => '北京快乐8',
	'lottery_pcdd' => 'PC蛋蛋',
	'lottery_qxc' => '七星彩',
	'lottery_marksix' => '六合彩',
	'lottery_jssc' => '极速赛车',
	'lottery_jsssc' => '极速时时彩',
	'lottery_jslh' => '极速六合',
];
$live = include(IN_AGENT.'../cj/include/live.php');
foreach($live as $key=>$val){
	switch ($val[2]) {
		case 'ty_rate':
			$return['sports']['live_'.$key] = $val[1];
			break;

		case 'dz_rate':
			$return['game']['live_'.$key] = $val[1];
			break;

		default:
			$return['live']['live_'.$key] = $val[1];
			break;
	}
}

return $return;
