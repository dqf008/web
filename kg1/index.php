<?php
set_time_limit(0);
ini_set('display_errors','on');

	$TicketStatus = [
		'WIN'=>'有中奖',
		'LOSE'=>'没中奖',
		'FREEGAME-WIN'=>'当局为免费游戏，有中奖',
		'FREEGAME-LOSE'=>'当局为免费游戏，没中奖',
		'BIG-WIN'=>'中高赔率奖项',
		'BONUS-GAME-WIN'=>'中彩金游戏',
		'JP-GRAND-WIN'=>'中 JP-Grand',
		'JP-MAJOR-WIN'=>'中 JP-Major',
		'JP-MINOR-WIN'=>'中 JP-Minor',
		'JP-MINI-WIN'=>'中 JP-Mini',
	];
	$GameList = [
		'1001' => '阿拉伯之夜',
		'1002' => '琅琊传奇',
		'1003' => 'KISS一夏',
		'1004' => '七姬的诱惑',
		'1005' => '神探金瓶梅',
		'1006' => '武媚传奇',
		'1007' => '萌娘学园',
		'1008' => '哥是传说',
		'1009' => '甜心三上悠亚',
		'1010' => '魔女道',
		'1011' => '乳姬无双',
		'1012' => '性爱诊疗室',
		'1013' => '淫乱学园',
		'1014' => '明日花潮吹大作战',
		'1015' => '快感三上悠亚',
		'1016' => '女大生调教日记',
		'1017' => '忧の无限中出约会',
		'1018' => '神之乳RION',
		'1019' => '旬果的发情诱惑',
		'1020' => '豆腐西施淫乱觉醒',		
		'1021' => 'G奶俱乐部',
		'1022' => '女王啪啪啪',
		'1023' => '千菜的调教教室',
		'1024' => '换妻公寓',
		'1025' => '和室里的激情',
		'1026' => '高潮甜点屋',
		'1027' => '香姬水果盘',
		'1028' => '极乐BAR',
		'0015' => '梯子游戏',
		'0016' => '甜心福袋',
	];
	require_once("kg_action.php");

	$DO_URL = "http://www.kgslots.com/kg_api/action/doValidate_ssl.php";
	$FW_URL = "http://www.kgslots.com/kg_api/action/fwValidate_ssl.php";

	$LANGUAGE = "zh-cn";
	$CURRENCY = "CNY";
	$ODD_TYPE = "A";

	$TEST_VENDOR_ID = "CS0025";
	$TEST_VENDOR_KEY= "da602ceef6891edeb7f86503acb7d20c";
	$TEST_NICK_NAME = "KGTEST";
	$TEST_PLAYER_NAME = "KT0002";
	$TEST_SECURE_TOKEN = $TEST_VENDOR_ID.time();// this is example.
	$TEST_BILL_NUMBER = $TEST_VENDOR_ID.time();	// this is example, big letter + Number will valid.
	$TEST_GAME_ID = "1010";
	$TEST_CREDIT = "100000";
	$TEST_HOME_URL = "http://www.kgslots.com";
	
	$TEST_START_TIME = "2017-11-26 00:00:00";
	$TEST_END_TIME = "2017-11-26 23:59:59";
	$TEST_BILL_NUMBER_INDEX = "0";
	$TEST_RECORD_COUNT = "10";
	//----------------------------------------------------------------------------------------------------
	
	if( strlen($TEST_VENDOR_ID) <= 0 || strlen($TEST_VENDOR_KEY)<=0){
		exit("请输入 TEST_VENDOR_ID 或 TEST_VENDOR_KEY");
	} 
	
	//echo ("如果只有看到此行讯息时，请自行将呼叫函式的程式码注解删除掉</br>");
	
	
	// 建立玩家.
	$crtParams = [];
	$crtParams['Loginname'] = $TEST_PLAYER_NAME;
	$crtParams['SecureToken'] = $TEST_SECURE_TOKEN;
	$crtParams['NickName'] = $TEST_NICK_NAME;
	$crtParams['Cur'] = $CURRENCY;
	$crtParams['Oddtype'] = $ODD_TYPE;
	//echo kg_player_create($TEST_VENDOR_ID, $TEST_VENDOR_KEY, $crtParams, $DO_URL);
//exit;
	// 玩家登入.
	$lgParams = [];
	$lgParams['Loginname'] = $TEST_PLAYER_NAME;
	$lgParams['SecureToken'] = $TEST_SECURE_TOKEN;	// Expired after two horus.
	echo kg_player_login($TEST_VENDOR_ID, $TEST_VENDOR_KEY, $lgParams, $DO_URL);
	//exit();
	// 存款.
	$depositParams=[];
	$depositParams['Loginname'] = $TEST_PLAYER_NAME;
	$depositParams['Billno'] = $TEST_BILL_NUMBER;	// this is example, big letter + Number will valid.
	$depositParams['Credit'] = $TEST_CREDIT;
	$depositParams['Cur'] = $CURRENCY;
	//echo kg_player_trans_deposit($TEST_VENDOR_ID, $TEST_VENDOR_KEY,$depositParams, $DO_URL);

	// 查询余额.
	$gbParams = [];
	$gbParams['Loginname'] = $TEST_PLAYER_NAME;
	$gbParams['Cur'] = $CURRENCY;
	//echo kg_player_balance($TEST_VENDOR_ID, $TEST_VENDOR_KEY,$gbParams, $DO_URL);

	// 提款.
	$withdraParams=[];
	$withdraParams['Loginname'] = $TEST_PLAYER_NAME;
	$withdraParams['Billno'] = $TEST_BILL_NUMBER;	// this is example, big letter + Number will valid.
	$withdraParams['Credit'] = $TEST_CREDIT;
	$withdraParams['Cur'] = $CURRENCY;
	//echo kg_player_trans_withdrawal($TEST_VENDOR_ID, $TEST_VENDOR_KEY,$withdraParams, $DO_URL);

	// 取得日期区间内的投注记录页数.
	$getPagesParams = [];
	$getPagesParams['Start'] = $TEST_START_TIME;
	$getPagesParams['End'] = $TEST_END_TIME;
  	//$res = kg_player_getPagesWithDate($TEST_VENDOR_ID, $TEST_VENDOR_KEY,$getPagesParams, $DO_URL);
  	//$res = json_decode($res,true);
  	//$pageNum = $res['Data'];
  	//echo $pageNum;
	// 取得日期區間內指定页数的投注纪录
	$getBetRecordOnPageParams = [];
	$getBetRecordOnPageParams['Start'] = $TEST_START_TIME;
	$getBetRecordOnPageParams['End'] = $TEST_END_TIME;
	$getBetRecordOnPageParams['PageNum'] = 4;
	//$json = kg_player_getRecordsWithDateOnPage($TEST_VENDOR_ID, $TEST_VENDOR_KEY,$getBetRecordOnPageParams, $DO_URL);
	//sleep(2);
	//for($i=1;$i<=$pageNum;$i++){
	//	$getBetRecordOnPageParams['PageNum'] = $i;
  	///	$json = kg_player_getRecordsWithDateOnPage($TEST_VENDOR_ID, $TEST_VENDOR_KEY,$getBetRecordOnPageParams, $DO_URL);
  	/*	$res = json_decode($json,true);
	/	foreach ($res['Data'] as $key => $value) {
			$statusName = $TicketStatus[$value['TicketStatus']];
			$value['TicketStatus'] = $statusName ? $statusName : $value['TicketStatus'];
			$gameName = $GameList[$value['GameID']];
			$value['GameID'] = $gameName ? $gameName : $value['GameID'];
			print_r($value);
		}
  		sleep(2);
	}*/
	//$res = json_decode($json,true);
	//echo count($res['Data']);
	// 查询4层jp彩金数值
	$getJPParams = [];
  	//echo kg_player_getJPNumber($TEST_VENDOR_ID, $TEST_VENDOR_KEY,$getJPParams, $DO_URL);
	//------------------------------------------------------------------------------------------------------------------------------

	// 取得游戏链接或直接导向游戏网页.
	$fwParams = [];
	$fwParams['Loginname'] = $TEST_PLAYER_NAME;
	$fwParams['SecureToken'] = $TEST_SECURE_TOKEN;	// Same as player login.
	$fwParams['Cur'] = $CURRENCY;
	$fwParams['GameId'] = $TEST_GAME_ID;
	$fwParams['Oddtype'] = $ODD_TYPE;
	$fwParams['Lang'] = $LANGUAGE;
	$fwParams['HomeURL'] = 0;

	//echo kg_fw_game_opt($TEST_VENDOR_ID, $TEST_VENDOR_KEY,$fwParams, $FW_URL);
	echo kg_fw_game($TEST_VENDOR_ID, $TEST_VENDOR_KEY,$fwParams, $FW_URL);

 ?>
