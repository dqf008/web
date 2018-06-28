<?php
session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/function.php';
include_once '../myfunction.php';
include_once '../class/user.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
// $msg = get_last_message();

$gameType = array('XIN', 'MG', 'PT');
$gamePid = array('XIN' => 'AGIN', 'MG' => 'NMGE', 'PT' => 'PT', /*'NYX' => 'AGIN', 'PNG' => 'AGIN', 'TTG' => 'AGIN'*/);
// $defaultGame = array_values($gameType);
// $defaultGame = $defaultGame[0];
$curGame = isset($_GET['pid'])?$_GET['pid']:$gameType[0];
!in_array($curGame, $gameType)&&$curGame = $gameType[0];

$gameList = array();
$gameList['XIN'] = array();
$gameList['XIN']['section'] = array();
$gameList['XIN']['section'][] = array('热门游戏', array('FRU', 'PKBJ', 'XG01', 'XG02', 'XG06', 'XG08', 'XG07', 'XG09', 'XG03'));
$gameList['XIN']['section'][] = array('最新游戏', array('PKBJ', 'XG09', 'XG02', 'XG01', 'XG06', 'XG08', 'XG07', 'FRU'));
$gameList['XIN']['section'][] = array('老虎机', array('FRU', 'XG01', 'XG02', 'XG06', 'XG08', 'XG07', 'XG09', 'XG03'));
$gameList['XIN']['section'][] = array('视频扑克', array('PKBJ'));
$gameList['XIN']['gamelist'] = array();
$gameList["XIN"]["gamelist"]["501"] = array("水果拉霸", "xin/FRU_ZH.gif","");
$gameList["XIN"]["gamelist"]["539"] = array("灵猴献瑞", "xin/SB30_ZH.gif","");
$gameList["XIN"]["gamelist"]["547"] = array("欧洲列强争霸", "xin/SB35_ZH.gif","");
$gameList["XIN"]["gamelist"]["509"] = array("复古花园", "xin/SB02_ZH.gif","");
$gameList["XIN"]["gamelist"]["508"] = array("太空漫游", "xin/SB01_ZH.gif","");
$gameList["XIN"]["gamelist"]["502"] = array("杰克高手", "xin/PKBJ_ZH.gif","");
$gameList["XIN"]["gamelist"]["550"] = array("竞技狂热", "xin/SB38_ZH.gif","");
$gameList["XIN"]["gamelist"]["XINHTG02"] = array("百家乐", "xin/TG02_ZH.gif","");
$gameList["XIN"]["gamelist"]["549"] = array("上海百乐门", "xin/SB37_ZH.gif","");
$gameList["XIN"]["gamelist"]["548"] = array("捕鱼王者", "xin/SB36_ZH.gif","");
$gameList["XIN"]["gamelist"]["543"] = array("齐天大圣", "xin/SB32_ZH.gif","");
$gameList["XIN"]["gamelist"]["545"] = array("冰河世界", "xin/SB34_ZH.gif","");
$gameList["XIN"]["gamelist"]["546"] = array("水果拉霸2", "xin/FRU2_ZH.gif","");
$gameList["XIN"]["gamelist"]["544"] = array("糖果碰碰乐", "xin/SB33_ZH.gif","");
$gameList["XIN"]["gamelist"]["542"] = array("天空守护者", "xin/SB31_ZH.gif","");
$gameList["XIN"]["gamelist"]["540"] = array("百搭二王", "xin/PKBD_ZH.gif","");
$gameList["XIN"]["gamelist"]["541"] = array("红利百搭", "xin/PKBB_ZH.gif","");
$gameList["XIN"]["gamelist"]["537"] = array("性感女仆", "xin/AV01_ZH.gif","");
$gameList["XIN"]["gamelist"]["513"] = array("日本武士", "xin/SB06_ZH.gif","");
$gameList["XIN"]["gamelist"]["531"] = array("侏罗纪", "xin/SB24_ZH.gif","");
$gameList["XIN"]["gamelist"]["515"] = array("麻将老虎机", "xin/SB08_ZH.gif","");
$gameList["XIN"]["gamelist"]["535"] = array("武财神", "xin/SB28_ZH.gif","");
$gameList["XIN"]["gamelist"]["517"] = array("开心农场", "xin/SB10_ZH.gif","");
$gameList["XIN"]["gamelist"]["512"] = array("甜一甜屋", "xin/SB05_ZH.gif","");
$gameList["XIN"]["gamelist"]["510"] = array("关东煮", "xin/SB03_ZH.gif","");
$gameList["XIN"]["gamelist"]["519"] = array("海底漫游", "xin/SB12_ZH.gif","");
$gameList["XIN"]["gamelist"]["516"] = array("西洋棋老虎机", "xin/SB09_ZH.gif","");
$gameList["XIN"]["gamelist"]["526"] = array("空中战争", "xin/SB19_ZH.gif","");
$gameList["XIN"]["gamelist"]["511"] = array("牧场咖啡", "xin/SB04_ZH.gif","");
$gameList["XIN"]["gamelist"]["520"] = array("鬼马小丑", "xin/SB13_ZH.gif","");
$gameList["XIN"]["gamelist"]["521"] = array("机动乐园", "xin/SB14_ZH.gif","");
$gameList["XIN"]["gamelist"]["522"] = array("惊吓鬼屋", "xin/SB15_ZH.gif","");
$gameList["XIN"]["gamelist"]["528"] = array("越野机车", "xin/SB21_ZH.gif","");
$gameList["XIN"]["gamelist"]["532"] = array("土地神", "xin/SB25_ZH.gif","");
$gameList["XIN"]["gamelist"]["518"] = array("夏日营地", "xin/SB11_ZH.gif","");
$gameList["XIN"]["gamelist"]["523"] = array("疯狂马戏团", "xin/SB16_ZH.gif","");
$gameList["XIN"]["gamelist"]["529"] = array("埃及奥秘", "xin/SB22_ZH.gif","");
$gameList["XIN"]["gamelist"]["533"] = array("布袋和尚", "xin/SB26_ZH.gif","");
$gameList["XIN"]["gamelist"]["527"] = array("摇滚狂迷", "xin/SB20_ZH.gif","");
$gameList["XIN"]["gamelist"]["534"] = array("正财神", "xin/SB27_ZH.gif","");
$gameList["XIN"]["gamelist"]["530"] = array("欢乐时光", "xin/SB23_ZH.gif","");
$gameList["XIN"]["gamelist"]["524"] = array("海洋剧场", "xin/SB17_ZH.gif","");
$gameList["XIN"]["gamelist"]["514"] = array("象棋老虎机", "xin/SB07_ZH.gif","");
$gameList["XIN"]["gamelist"]["536"] = array("偏财神", "xin/SB29_ZH.gif","");
$gameList["XIN"]["gamelist"]["525"] = array("水上乐园", "xin/SB18_ZH.gif","");
$gameList["XIN"]["gamelist"]["507"] = array("极速幸运轮", "xin/TGLW_ZH.gif","");
$gameList["XIN"]["gamelist"]["TA0L"] = array("无法无天", "tain/The_mob_ZH.gif","");
$gameList["XIN"]["gamelist"]["TA0M"] = array("法老秘密", "tain/TA0M_ZH.gif","");
$gameList["XIN"]["gamelist"]["TA0N"] = array("烈火战车", "tain/Full_Throttle_logo_ZH.gif","");
$gameList["XIN"]["gamelist"]["TA0O"] = array("捕猎季节", "tain/Hunting_season_logo_ZH.gif","");
$gameList["XIN"]["gamelist"]["TA0P"] = array("怪兽食坊", "tain/GourMonster_logo_ZH.gif","");
$gameList["XIN"]["gamelist"]["TA0Q"] = array("日与夜", "tain/Day&night_logo_ZH.gif","");
$gameList["XIN"]["gamelist"]["TA0S"] = array("足球竞赛", "tain/Soccer_Challenge_logo_ZH.gif","");
$gameList["XIN"]["gamelist"]["TA0T"] = array("珠光宝气", "tain/TA0T_ZH.gif","");
$gameList["XIN"]["gamelist"]["TA0U"] = array("经典轿车", "tain/Lowriders_logo_ZH.gif","");
$gameList["XIN"]["gamelist"]["TA0V"] = array("星际大战", "tain/Galactic_Cash_logo_ZH.gif","");
$gameList["XIN"]["gamelist"]["TA0W"] = array("海盗夺宝", "tain/Jolly_Roger_logo_ZH.gif","");
$gameList["XIN"]["gamelist"]["TA0X"] = array("巴黎茶座", "tain/Cafe_de_Paris_logo_ZH.gif","");
$gameList["XIN"]["gamelist"]["TA0Y"] = array("金龙献宝", "tain/golden_dragon_logo_ZH.gif","");
$gameList["XIN"]["gamelist"]["608"] = array("大豪客", "xin/highroller_ZH.gif","");
$gameList["XIN"]["gamelist"]["TAITA1L"] = array("欧洲轮盘", "tain/TA1K_Roulette_ZH.gif","");
$gameList["XIN"]["gamelist"]["200"] = array("龙珠", "xin/XG01_ZH.gif","");
$gameList["XIN"]["gamelist"]["201"] = array("幸运8", "xin/XG02_ZH.gif","");
$gameList["XIN"]["gamelist"]["202"] = array("闪亮女郎", "xin/XG03_ZH.gif","");
$gameList["XIN"]["gamelist"]["203"] = array("金鱼", "xin/XG04_ZH.gif","");
$gameList["XIN"]["gamelist"]["204"] = array("中国新年", "xin/XG05_ZH.gif","");
$gameList["XIN"]["gamelist"]["205"] = array("海盗王", "xin/XG06_ZH.gif","");
$gameList["XIN"]["gamelist"]["206"] = array("鲜果狂热", "xin/XG07_ZH.gif","");
$gameList["XIN"]["gamelist"]["207"] = array("小熊猫", "xin/XG08_ZH.gif","");
$gameList["XIN"]["gamelist"]["208"] = array("大豪客", "xin/highroller_ZH.gif","");
$gameList["XIN"]["gamelist"]["209"] = array("龙舟竞渡", "xin/XG10_ZH.gif","");
$gameList["XIN"]["gamelist"]["210"] = array("中秋佳節", "xin/XG11_ZH.gif","");
$gameList["XIN"]["gamelist"]["211"] = array("韩风劲舞", "xin/XG12_ZH.gif","");
$gameList["XIN"]["gamelist"]["212"] = array("美女大格斗", "xin/XG13_ZH.gif","");
$gameList["XIN"]["gamelist"]["213"] = array("龙凤呈祥", "xin/XG14_ZH.gif","");
$gameList["XIN"]["gamelist"]["215"] = array("黄金对垒", "xin/XG16_ZH.gif","");
$gameList["XIN"]["gamelist"]["DTGDTA0"] = array("赛亚烈战", "xin/SX01_ZH.png","");
$gameList["XIN"]["gamelist"]["221"] = array("街头烈战", "xin/SX02_ZH.png","");
$gameList["XIN"]["gamelist"]["802"] = array("金拉霸", "xin/SC03_ZH.png","");
$gameList["XIN"]["gamelist"]["DTGDTAR"] = array("英雄荣耀", "xin/DTAR_ZH.jpg","");
$gameList["XIN"]["gamelist"]["DTGDTB1"] = array("快乐农庄", "xin/DTB1_ZH.png","");
$gameList["XIN"]["gamelist"]["DTGDTAM"] = array("封神榜", "xin/DTAM_ZH.jpg","");
$gameList["XIN"]["gamelist"]["DTGDTAZ"] = array("摇滚之夜", "xin/DTAZ_ZH.jpg","");
$gameList["XIN"]["gamelist"]["156"] = array("猛龙传奇", "xin/SB45_ZH.png","");



$gameList['MG'] = array();
$gameList['MG']['section'] = array();
$gameList['MG']['section'][] = array('热门游戏', array('dragondance', 'KaraokeParty', 'breakdabank', 'FrozenDiamonds', 'tombraider', 'breakAway', 'carnaval', '5reeldrive', 'montecarloriches', 'AlaskanFishing', 'FootballStar', 'BigTop', 'thunderstruckII', 'agentJaneBlonde', 'wildorient', 'bushtelegraph', 'thunderstruck', 'coolWolf', 'ladiesnite', 'BreakDaBankAgain', 'tallyho', 'StarlightKiss', 'AgeOfDiscovery', 'reelthunder', 'theTwistedCircus', 'AdventurePalace', 'BasketballStar', 'bikiniparty', 'LuckyKoi', 'BurningDesire', 'RugbyStar', 'mermaidsmillions'));
$gameList['MG']['section'][] = array('最新游戏', array('FrozenDiamonds', 'KaraokeParty', 'ReelSpinner', 'winsumdimsum', 'PrettyKitty', 'wildorient', 'bikiniparty', 'barBarBlackSheep5Reel', 'dragondance', 'treasureNile', 'majorMillions', 'megaMoolah', 'SterlingSilver3d', 'shoot', 'jackspwrpoker', 'europeanbjgold='));
$gameList['MG']['section'][] = array('老虎机', array('breakAway', 'asianBeauty', 'theTwistedCircus', 'carnaval', 'ladiesnite', 'treasureNile', 'BasketballStar', 'montecarloriches', 'coolWolf', 'bushtelegraph', 'majorMillions', 'springbreak', 'rubyhitman', '5reeldrive', 'FootballStar', 'wildorient', 'couchpotato', 'dragondance', 'FrozenDiamonds', 'thunderstruckII', 'thunderstruck', 'bikiniparty', 'RugbyStar', 'StarlightKiss', 'tallyho', 'AlaskanFishing', 'mermaidsmillions', 'Ariana', 'AgeOfDiscovery', 'Bridesmaids', 'CricketStar', 'BigTop', 'AdventurePalace', 'untamedgiantpanda', 'ReelSpinner', 'WhatAHoot', 'KaraokeParty', 'BurningDesire', 'PrettyKitty', 'reelthunder', 'bigkahuna', 'cashville', 'kingsofcash', 'BreakDaBankAgain', 'tombraider', 'agentJaneBlonde', 'HighSociety', 'SupeItUp', 'breakdabank', 'eagleswings', 'Avalon', 'treasurePalace', 'rhymingReelsGeorgiePorgie', 'MysticDreams', 'SunTide', 'winsumdimsum', 'GoldenEra', 'secretadmirer', 'Harveys', 'mayanprincess', 'Summertime', 'HappyHolidays', 'SoMuchCandy', 'lionsPride', 'LuckyLeprechaun', 'SilverFang', 'tigersEye', 'Cashapillar', 'Kathmandu', 'shoot', 'DeckTheHalls', 'liquidGold', 'CentreCourt', 'beachBabes', 'SoMuchSushi', 'partyIsland', 'loaded', 'SoManyMonsters', 'isis', 'Halloweenies', 'theGrandJourney', 'madhatters', 'SureWin', 'voila', 'boogieMonsters', 'summerHoliday', 'megaMoolah'));
$gameList['MG']['section'][] = array('桌面游戏', array('classicBlackjackGold', 'europeanRoulette', 'vegasStripBlackjackGold', 'vegasSingleDeckBlackjackGold', 'atlanticCityBlackjackGold', 'americanRouletteGold', 'vegasDowntownBlackjackGold'));
$gameList['MG']['section'][] = array('视频扑克', array('jacks', 'jackspwrpoker', 'acesAndEights', 'bonusDeucesWild', 'acesAndFaces', 'doubledoublebonus', 'deuceswildpwrpoker', 'deuceswi'));
$gameList['MG']['gamelist'] = array();

$gameList["MG"]["gamelist"]["breakaway"] = array("冰球突破", "mg/BreakAway.jpg","");
$gameList["MG"]["gamelist"]["reelgems"] = array("宝石转轴", "mg/ReelGems_250x250.png","");
$gameList["MG"]["gamelist"]["Carnaval"] = array("嘉年华", "mg/Carnaval.png","");
$gameList["MG"]["gamelist"]["ladiesnite"] = array("淑女派对", "mg/LadiesNite_Logo.png","");
$gameList["MG"]["gamelist"]["immortalromance"] = array("不朽情缘", "mg/IR_Logo.jpg","");
$gameList["MG"]["gamelist"]["bustthebank"] = array("抢劫银行", "mg/BustTheBank_Logo.jpg","");
$gameList["MG"]["gamelist"]["springbreak"] = array("春假时光", "mg/SpringBreak_Logo.png","");
$gameList["MG"]["gamelist"]["dragondance"] = array("舞龙", "mg/DragonDance.png","");
$gameList["MG"]["gamelist"]["Playboy"] = array("花花公子", "mg/Playboy_SquareLogo_PlainBackground_colour1_on_black.jpg","");
$gameList["MG"]["gamelist"]["thetwistedcircus"] = array("奇妙马戏团", "mg/MPTheTwistedCircus_Tournament_SquareLogo_WithBackground.png","");
$gameList["MG"]["gamelist"]["goldfactory"] = array("黄金工厂", "mg/GoldFactory_Logo.png","");
$gameList["MG"]["gamelist"]["retroreels"] = array("经典老虎机", "mg/RetroReels_WebIcon1.png","");
$gameList["MG"]["gamelist"]["mermaidsmillions"] = array("百万人鱼", "mg/MPMermaidsMillions_StackedLogo_GraphicBackground.png","");
$gameList["MG"]["gamelist"]["bushtelegraph"] = array("丛林快讯", "mg/BushTelegraph_Logo2.png","");
$gameList["MG"]["gamelist"]["BasketballStar"] = array("篮球巨星", "mg/BasketballStar.png","");
$gameList["MG"]["gamelist"]["thunderstruck"] = array("雷霆万钧", "mg/Thunderstruck_HTML5_splashscreen.png","");
$gameList["MG"]["gamelist"]["sunquest"] = array("追寻太阳", "mg/SunQuest_Logo.png","");
$gameList["MG"]["gamelist"]["karatepig"] = array("空手道猪", "mg/KaratePig_Logo_1.png","");
$gameList["MG"]["gamelist"]["bigkahuna"] = array("森林之王", "mg/BigKahuna_Logo2.jpg","");
$gameList["MG"]["gamelist"]["5reeldrive"] = array("侠盗猎车手", "mg/5ReelDrive_Icon.png","");
$gameList["MG"]["gamelist"]["tallyho"] = array("狐狸爵士", "mg/TallyHo_Logo.png","");
$gameList["MG"]["gamelist"]["vinylcountdown"] = array("恋曲1980", "mg/BTN_VinylCountdown.png","");
$gameList["MG"]["gamelist"]["WhatAHoot"] = array("猫头鹰乐园", "mg/WhatAHoo_Mobile_GameIcon.png","");
$gameList["MG"]["gamelist"]["LuckyFirecracker"] = array("招财鞭炮", "mg/LuckyFirecracker_SquareLogo_GraphicBackground.png","");
$gameList["MG"]["gamelist"]["bikiniparty"] = array("比基尼派对", "mg/BikiniParty_ZH.png","");
$gameList["MG"]["gamelist"]["BigTop"] = array("马戏团", "mg/BigTop_Logo.png","");
$gameList["MG"]["gamelist"]["RetroReelsExtremeHeat"] = array("酷热经典", "mg/RetroReelsExtremeHeat_WebIcon1.png","");
$gameList["MG"]["gamelist"]["tombraider"] = array("古墓丽影", "mg/TombRaider_250x250.png","");
$gameList["MG"]["gamelist"]["leaguesoffortune"] = array("富翁联盟", "mg/LeaguesOfFortune_250x250.jpg","");
$gameList["MG"]["gamelist"]["CoolWolf"] = array("酷派狼人", "mg/CoolWolf_01_Wild Logo.jpg","");
$gameList["MG"]["gamelist"]["thunderstruck2"] = array("雷神索尔II", "mg/TSII_Thor_1024x768.jpg","");
$gameList["MG"]["gamelist"]["StarlightKiss"] = array("星光之吻", "mg/StarlightKiss_Logo_Square_WithBackground.jpg","");
$gameList["MG"]["gamelist"]["Bridesmaids"] = array("伴娘我最大", "mg/Bridesmaids_01_Wild_Logo.png","");
$gameList["MG"]["gamelist"]["BurningDesire"] = array("燃烧欲望", "mg/BurningDesire_logo.png","");
$gameList["MG"]["gamelist"]["Ariana"] = array("爱丽娜", "mg/Ariana_SquareLogo_GraphicBackground.png","");
$gameList["MG"]["gamelist"]["HotInk"] = array("火热刺青", "mg/HotInk_250x250.png","");
$gameList["MG"]["gamelist"]["hohoho"] = array("圣诞节狂欢", "mg/HoHoHo_Logo2.png","");
$gameList["MG"]["gamelist"]["Pistoleras"] = array("神秘枪手", "mg/Pistoleras_StackedLogo_GraphicBackground_ZH.png","");
$gameList["MG"]["gamelist"]["HouseofDragons"] = array("龙宫", "mg/HouseOfDragons_Logo.png","");
$gameList["MG"]["gamelist"]["Avalon"] = array("阿瓦隆", "mg/Avalon_Logo.png","");
$gameList["MG"]["gamelist"]["FootballStar"] = array("足球明星", "mg/FootballStar.jpg","");
$gameList["MG"]["gamelist"]["reelthunder"] = array("雷霆风暴", "mg/ReelThunder_Phone_AddToHomeScreen.png","");
$gameList["MG"]["gamelist"]["reelstrike"] = array("海洋争夺", "mg/ReelStrike.png","");
$gameList["MG"]["gamelist"]["montecarloriches"] = array("金豪大亨", "mg/RivieraRiches_HiDef.png","");
$gameList["MG"]["gamelist"]["AgeOfDiscovery"] = array("大航海时代", "mg/AgeOfDiscovery_Logo.png","");
$gameList["MG"]["gamelist"]["TheFinerReelsOfLife"] = array("品质生活", "mg/TheFinerReelsofLife_SquareLogo_ WithBackground.jpg","");
$gameList["MG"]["gamelist"]["jasonandthegoldenfleece"] = array("金毛骑士团", "mg/JasonAndTheGoldenFleece.jpg","");
$gameList["MG"]["gamelist"]["HotAsHades"] = array("地府烈焰", "mg/HotAsHades.png","");
$gameList["MG"]["gamelist"]["DolphinQuest"] = array("寻访海豚", "mg/DolphinQuest.jpg","");
$gameList["MG"]["gamelist"]["jacks"] = array("视频扑克", "mg/JacksorBetter.png","");
$gameList["MG"]["gamelist"]["cashcrazy"] = array("疯狂现金", "mg/CashCrazy_Logo.png","");
$gameList["MG"]["gamelist"]["secretadmirer"] = array("暗恋", "mg/SecretAdmirer_250x250.png","");
$gameList["MG"]["gamelist"]["PurePlatinum"] = array("白金俱乐部", "mg/PurePlatinum_Mobile_Logo.png","");
$gameList["MG"]["gamelist"]["RedHotDevil"] = array("炙热魔鬼", "mg/RedHotDevil_SquareLogo_GraphicBackground.jpg","");
$gameList["MG"]["gamelist"]["HappyNewYear"] = array("新年快乐", "mg/HappyNewYear_Logo.png","");
$gameList["MG"]["gamelist"]["doublewammy"] = array("双倍惊喜", "mg/DoubleWammySlot_Logo.png","");
$gameList["MG"]["gamelist"]["crazychameleons"] = array("疯狂变色龙", "mg/CrazyChameleons_Logo.png","");
$gameList["MG"]["gamelist"]["luckywitch"] = array("幸运女巫", "mg/LuckyWitch.jpg","");
$gameList["MG"]["gamelist"]["ChainMail"] = array("连锁战甲", "mg/ChainMail.png","");
$gameList["MG"]["gamelist"]["kingsofcash"] = array("现金之王", "mg/KingsOfCash_Mobile_HiDef.png","");
$gameList["MG"]["gamelist"]["FishParty"] = array("海底派对", "mg/FishParty.jpg","");
$gameList["MG"]["gamelist"]["RugbyStar"] = array("橄榄球明星", "mg/RugbyStar_StackedLogo_PlainBackground_ZH.png","");
$gameList["MG"]["gamelist"]["AdventurePalace"] = array("冒险丛林", "mg/AdventurePalace_SquareLogo_GraphicBackground.png","");
$gameList["MG"]["gamelist"]["wildorient"] = array("东方珍兽", "mg/WildOrient_StackedLogo_GraphicBackground.png","");
$gameList["MG"]["gamelist"]["AsianBeauty"] = array("亚洲风情", "mg/AsianBeauty_Logo.png","");
$gameList["MG"]["gamelist"]["AlaskanFishing"] = array("阿拉斯加冰钓", "mg/AlaskanFishing_Logo.png","");
$gameList["MG"]["gamelist"]["RiverofRiches"] = array("财富之河", "mg/RiverOfRiches_Logo.png","");
$gameList["MG"]["gamelist"]["LuckyZodiac"] = array("幸运生肖", "mg/LuckyZodiac_StackedLogo_GraphicBackground_ZH.png","");
$gameList["MG"]["gamelist"]["LuckyLeprechaun"] = array("幸运妖精", "mg/LuckyLeprechaun_HorizontalLogo_GraphicBackground.png","");
$gameList["MG"]["gamelist"]["drwattsup"] = array("瓦特博士", "mg/DrWattsUp.jpg","");
$gameList["MG"]["gamelist"]["girlswithguns"] = array("女孩与枪(丛林热)", "mg/GWGJungleHeat_Logo.jpg","");
$gameList["MG"]["gamelist"]["greatgriffin"] = array("伟大的狮鹫兽", "mg/GreatGriffin_Logo.png","");
$gameList["MG"]["gamelist"]["untamedgiantpanda"] = array("野生熊猫", "mg/UntamedGiantPanda_200x200.jpg","");
$gameList["MG"]["gamelist"]["highfive"] = array("幸运连线", "mg/High5_LogoFull.png","");
$gameList["MG"]["gamelist"]["SantasWildRide"] = array("暴走圣诞", "mg/SantasWildRide_Santa_1920x1200.jpg","");
$gameList["MG"]["gamelist"]["couchpotato"] = array("慵懒土豆", "mg/CouchPotato_Icon.png","");
$gameList["MG"]["gamelist"]["gophergold"] = array("黄金地鼠", "mg/GopherGold_MainLogo.png","");
$gameList["MG"]["gamelist"]["SilverFang"] = array("银狼", "mg/SilverFang_Mobile_Logo.png","");
$gameList["MG"]["gamelist"]["eagleswings"] = array("疾风老鹰", "mg/EaglesWings_250x250.png","");
$gameList["MG"]["gamelist"]["bubblebonanza"] = array("泡泡矿坑", "mg/BubbleBonanza_Logo.png","");
$gameList["MG"]["gamelist"]["AgentJaneBlonde"] = array("特工珍尼", "mg/Agent Jane Blonde_Logo_01.png","");
$gameList["MG"]["gamelist"]["RabbitInTheHat"] = array("魔术兔", "mg/RabbitInTheHat_StackedLogo_GraphicBackground.png","");
$gameList["MG"]["gamelist"]["Terminator2"] = array("魔鬼终结者2", "mg/T2_SquareLogo_GraphicBackground.jpg","");
$gameList["MG"]["gamelist"]["AllAces"] = array("全能王牌", "mg/AllAcesPoker.png","");
$gameList["MG"]["gamelist"]["KittyCabana"] = array("凯蒂卡巴拉", "mg/KittyCabana.png","");
$gameList["MG"]["gamelist"]["orientalfortune"] = array("东方财富", "mg/OrientalFortune_Logo.png","");
$gameList["MG"]["gamelist"]["monstermania"] = array("怪兽大进击", "mg/MonsterMania_Icon2.png","");
$gameList["MG"]["gamelist"]["Serenity"] = array("宁静", "mg/Serenity_StackedLogo_GraphicBackground_ZH.png","");
$gameList["MG"]["gamelist"]["battlestargalactica"] = array("太空堡垒", "mg/BattlestarGalactica.jpg","");
$gameList["MG"]["gamelist"]["oceans"] = array("幸运海洋", "mg/7Oceans_Logo.png","");
$gameList["MG"]["gamelist"]["TheDarkKnightRises"] = array("黑暗骑士：黎明升起", "mg/TDKR_Logo_PlainBackground_Colour.jpg","");
$gameList["MG"]["gamelist"]["skullduggery"] = array("神鬼奇航", "mg/SkullDuggery_Logo.png","");
$gameList["MG"]["gamelist"]["cashclams"] = array("贝壳大亨", "mg/CashClams_Logo.png","");
$gameList["MG"]["gamelist"]["GirlsWithGunsFrozenDawn"] = array("女孩与枪(寒冷的黎明)", "mg/GWGFrozenDawn.jpg","");
$gameList["MG"]["gamelist"]["shoot"] = array("射门高手", "mg/BTN_Shoot_icon.png","");
$gameList["MG"]["gamelist"]["luckytwins"] = array("幸运双星", "mg/LuckyTwins_Logo.png","");
$gameList["MG"]["gamelist"]["PeekaBoo5Reel"] = array("躲猫猫（5轮）", "mg/PeekABoo_Logo.png","");
$gameList["MG"]["gamelist"]["EuroRouletteGold"] = array("欧洲杯轮盘", "mg/EuropeanRouletteGoldSeries_Logo.png","");
$gameList["MG"]["gamelist"]["PremierRoulette"] = array("总理轮盘", "mg/PremierRoulette_Logo.png","");
$gameList["MG"]["gamelist"]["premierroulettede"] = array("鑽石总统轮盘", "mg/PremierRouletteDiamondEdition_Logo.png","");
$gameList["MG"]["gamelist"]["fan7"] = array("炫目缤纷", "mg/Fantastic7s_Logo.png","");
$gameList["MG"]["gamelist"]["pharaohs"] = array("法老王的财富", "mg/PharaohsFortune_Logo.png","");
$gameList["MG"]["gamelist"]["pirates"] = array("海盗天堂", "mg/PiratesParadise_Logo.png","");
$gameList["MG"]["gamelist"]["CutesyPie"] = array("娇媚馅饼", "mg/CutesyPie_Logo.png","");
$gameList["MG"]["gamelist"]["Diamond7s"] = array("钻石七人榄球", "mg/Diamond7s_Logo.png","");
$gameList["MG"]["gamelist"]["Grand7s"] = array("盛大七人欖球", "mg/Grand7s_Logo.png","");
$gameList["MG"]["gamelist"]["FloriditaFandango"] = array("西班牙凡丹戈", "mg/FloriditaFandango_Logo.png","");
$gameList["MG"]["gamelist"]["fruits"] = array("水果老虎机", "mg/FruitSlots_Logo.png","");
$gameList["MG"]["gamelist"]["dm"] = array("双倍魔术", "mg/DoubleMagic_Button.png","");
$gameList["MG"]["gamelist"]["fortunecookie"] = array("幸运饼干", "mg/FortuneCookie_Logo.png","");
$gameList["MG"]["gamelist"]["cherryred"] = array("樱桃红", "mg/CherryRed_Logo.png","");
$gameList["MG"]["gamelist"]["rocktheboat"] = array("摇滚航道", "mg/RocktheBoat_Logo.png","");
$gameList["MG"]["gamelist"]["DoubleDose"] = array("双倍剂量", "mg/DoubleDose_Logo.png","");
$gameList["MG"]["gamelist"]["CityofGold"] = array("黄金之城", "mg/CityofGold_Logo.png","");
$gameList["MG"]["gamelist"]["ThousandIslands"] = array("千群岛", "mg/ThousandIslands_Logo.png","");
$gameList["MG"]["gamelist"]["MochaOrange"] = array("摩卡橙色", "mg/MochaOrange_Logo.png","");
$gameList["MG"]["gamelist"]["flipcard"] = array("翻转卡", "mg/FlipCard.png","");
$gameList["MG"]["gamelist"]["big5"] = array("丛林五霸", "mg/Big5_Logo.png","");
$gameList["MG"]["gamelist"]["jesters"] = array("欢乐小丑", "mg/JestersJackpot_Logo.png","");
$gameList["MG"]["gamelist"]["FlosDiner"] = array("弗洛晚餐", "mg/Flo'sDiner_Logo.png","");
$gameList["MG"]["gamelist"]["jexpress"] = array("奖金快递", "mg/JackpotExpress_Logo.png","");
$gameList["MG"]["gamelist"]["gdragon"] = array("黄金龙", "mg/GoldenDragon_Logo.png","");
$gameList["MG"]["gamelist"]["romanriches"] = array("罗马富豪", "mg/RomanRiches_Logo.png","");
$gameList["MG"]["gamelist"]["belissimo"] = array("贝利西餐厅", "mg/Belissimo_Logo.png","");
$gameList["MG"]["gamelist"]["CaptainCash"] = array("派金船长", "mg/CaptainCash_Logo.png","");
$gameList["MG"]["gamelist"]["Funhouse"] = array("开心乐园", "mg/FunHouse_Logo.png","");
$gameList["MG"]["gamelist"]["crocs"] = array("疯狂鳄鱼", "mg/CrazyCrocs_Logo.png","");
$gameList["MG"]["gamelist"]["BlackjackBonanza"] = array("21点矿坑", "mg/BlackjackBonanza_Logo.png","");
$gameList["MG"]["gamelist"]["chiefsmagic"] = array("魔术酋长", "mg/ChiefsMagic_Logo.png","");
$gameList["MG"]["gamelist"]["royce"] = array("劳斯莱斯", "mg/ReelsRoyce_Logo.png","");
$gameList["MG"]["gamelist"]["trickortreat"] = array("不给糖就捣蛋", "mg/TrickorTreat_Logo.png","");
$gameList["MG"]["gamelist"]["gladiatorsgold"] = array("黄金角斗士", "mg/GladiatorsGold.jpg","");
$gameList["MG"]["gamelist"]["HeavyMetal"] = array("摇滚重金属", "mg/HeavyMetal_Logo.png","");
$gameList["MG"]["gamelist"]["deuceswi"] = array("狂野奖金", "mg/DeucesWild.png","");
$gameList["MG"]["gamelist"]["deucesandjoker"] = array("狂野扑克", "mg/DeucesJoker.png","");
$gameList["MG"]["gamelist"]["cyberstud"] = array("网络扑克", "mg/CyberstudPoker.png","");
$gameList["MG"]["gamelist"]["louisianadouble"] = array("刘易斯扑克", "mg/LouisianaDoublePoker.png","");
$gameList["MG"]["gamelist"]["acesfaces"] = array("经典5PK", "mg/BTN_Aces&Faces.png","");
$gameList["MG"]["gamelist"]["tensorbetter"] = array("尖子威力扑克", "mg/TensOrBetter4PlayPowerPoker_Button.png","");
$gameList["MG"]["gamelist"]["doublejoker"] = array("小丑百搭5PK", "mg/DoubleJokerPokerLevelUp_Logo.png","");
$gameList["MG"]["gamelist"]["baccarat"] = array("百家乐", "mg/Baccarat.png","");
$gameList["MG"]["gamelist"]["sicbo"] = array("骰宝", "mg/Sicbo_01_StackedLogo_GraphicBackground.png","");
$gameList["MG"]["gamelist"]["ThreeWheeler"] = array("三轮车", "mg/ThreeWheeler_Logo.png","");
$gameList["MG"]["gamelist"]["wwizards"] = array("巫师梅林", "mg/WinningWizards.png","");
$gameList["MG"]["gamelist"]["geniesgems"] = array("精灵宝石", "mg/GeniesGems.png","");
$gameList["MG"]["gamelist"]["reddog"] = array("红狗", "mg/RedDog_Logo.png","");
$gameList["MG"]["gamelist"]["jurassicjackpot"] = array("侏罗纪彩金", "mg/Jurassicjackpot_Logo.png","");
$gameList["MG"]["gamelist"]["FrostBite"] = array("结霜冻疮", "mg/FrostBite_Logo.png","");
$gameList["MG"]["gamelist"]["cosmicc"] = array("宇宙猫", "mg/CosmicCat_Logo.png","");
$gameList["MG"]["gamelist"]["MultiWheelRouletteGold"] = array("复式轮盘", "mg/EuropeanRouletteGoldSeries_Logo_2.png","");
$gameList["MG"]["gamelist"]["BaccaratGold"] = array("黄金百家乐", "mg/BaccaratGold.png","");
$gameList["MG"]["gamelist"]["AmericanRoulette"] = array("美式轮盘", "mg/AmericanRoulette.png","");
$gameList["MG"]["gamelist"]["vegasstrip"] = array("拉斯维加斯21点", "mg/VegasStripBlackjack.png","");
$gameList["MG"]["gamelist"]["VegasDownTown"] = array("拉斯维加斯21点", "mg/VegasDowtownBlackjackGold_Button_HiDef.png","");
$gameList["MG"]["gamelist"]["doubleexposure"] = array("决斗21点", "mg/DoubleExposureBlackjackGold_Logo.png","");
$gameList["MG"]["gamelist"]["superfun21"] = array("超级乐21点", "mg/SuperFun21.png","");
$gameList["MG"]["gamelist"]["atlanticcity"] = array("大西洋城21点", "mg/AtlanticCityBJGold_Logo_1.png","");
$gameList["MG"]["gamelist"]["spanish"] = array("西班牙21点", "mg/Spanish21BlackjackGold_Logo.png","");
$gameList["MG"]["gamelist"]["HighLimitBaccarat"] = array("极限百家乐", "mg/HighLimitBaccarat_Button.png","");
$gameList["MG"]["gamelist"]["BonusPoker"] = array("红利扑克", "mg/BonusVideoPoker.png","");
$gameList["MG"]["gamelist"]["DoubleBonusPoker"] = array("双倍红利扑克", "mg/DoubleBonusPoker.png","");
$gameList["MG"]["gamelist"]["BonusPokerDeluxe"] = array("豪华红利5PK", "mg/BonusPokerDeluxe_Logo.png","");
$gameList["MG"]["gamelist"]["doubledoublebonus"] = array("四倍红利5PK", "mg/DoubleDoubleBonus_Logo.png","");
$gameList["MG"]["gamelist"]["AcesAndEights"] = array("对八5PK", "mg/BTN_Aces&Eights.png","");
$gameList["MG"]["gamelist"]["BonusDeucesWild"] = array("红利狂野牌", "mg/BTN_BonusDeucesWild1.png","");
$gameList["MG"]["gamelist"]["MHHoldemHigh"] = array("多手德州扑克改进版", "mg/HoldEmHighGold_Logo.png","");
$gameList["MG"]["gamelist"]["atlanticcitybjgold"] = array("金牌大西洋城21点", "mg/AtlanticCityBJGold_Logo_1.png","");
$gameList["MG"]["gamelist"]["mhatlanticcitybjgold"] = array("金牌大西洋城21点(多组牌)", "mg/AtlanticCityBJGold_Logo_2.png","");
$gameList["MG"]["gamelist"]["VegasStripBlackjackGold"] = array("金牌拉斯维加斯21点", "mg/VegasStripBlackjackGold_Button_HiDef.png","");
$gameList["MG"]["gamelist"]["MultiVegasDowntownBlackjackGold"] = array("金牌拉斯维加斯中心21点", "mg/MultiHandVegasDowntownBlackjackGold_Logo.png","");
$gameList["MG"]["gamelist"]["europeanbjgold"] = array("金牌欧洲21点", "mg/EuropeanBlackjackGold_Logo_1.png","");
$gameList["MG"]["gamelist"]["mheuropeanbjgold"] = array("金牌欧洲21点（多组牌）", "mg/MultiHandEuropeanBlackjackGold_ClarionButton.png","");
$gameList["MG"]["gamelist"]["BeginnerMHEuropeanBJGold"] = array("金牌欧洲新手21点", "mg/EuropeanBlackjackGold_Logo_1.png","");
$gameList["MG"]["gamelist"]["PBJMultiHand"] = array("金牌欧洲总理21点", "mg/MultiHandEuropeanBlackjackGold_ClarionButton.png","");
$gameList["MG"]["gamelist"]["ClassicBlackjackGold"] = array("金牌经典21点", "mg/ClassicBlackjackGold_Logo.png","");
$gameList["MG"]["gamelist"]["VegasSingleDeckBlackjackGold"] = array("金牌拉斯维加斯单牌21点", "mg/VegasSingleDeckBlackjackGold_Logo.png","");
$gameList["MG"]["gamelist"]["BigFiveBlackjackGold"] = array("金牌大五21点", "mg/BigFiveBlackjackGold_Logo.png","");
$gameList["MG"]["gamelist"]["SpanishBlackjackGold"] = array("金牌西班牙21点", "mg/Spanish21BlackjackGold_Logo.png","");
$gameList["MG"]["gamelist"]["DoubleExposureBlackjackGold"] = array("金牌双重亮相", "mg/DoubleExposureBlackjackGold_Logo2.png","");
$gameList["MG"]["gamelist"]["MultiClassicBlackjackGold"] = array("金牌经典21点（多组牌）", "mg/MultiHandClassicBlackjackGold_Logo.png","");
$gameList["MG"]["gamelist"]["TriplePocketPoker"] = array("金牌三重扑克", "mg/TriplePocketHoldem_Logo.png","");
$gameList["MG"]["gamelist"]["HiLoBlackjackGold"] = array("金牌欧洲高低13 21点", "mg/HiLo13EuropeanBlackjackGold_Logo.png","");
$gameList["MG"]["gamelist"]["PBJHiLo"] = array("超级金牌欧洲高低21点", "mg/PremierBlackjackHiLo_Logo_1.png","");
$gameList["MG"]["gamelist"]["HighStreakBJGold"] = array("金牌欧洲连赢21点", "mg/EuropeanHighStreakBlackjackGold_Logo.png","");
$gameList["MG"]["gamelist"]["PBJHighStreak"] = array("超级金牌欧洲连赢21点", "mg/PremierBlackjackHighStreak_Logo_2.png","");
$gameList["MG"]["gamelist"]["MHPerfectPairs"] = array("超级完美对碰21点(多组牌)", "mg/MultiHandEuroPerfectPairsBlackjackGold_Logo.png","");
$gameList["MG"]["gamelist"]["highspeedpoker"] = array("三张扑克(多组牌)", "mg/HighSpeedPokerGold.png","");
$gameList["MG"]["gamelist"]["coolbuck"] = array("酷巴克", "mg/CoolBuck_Logo.png","");
$gameList["MG"]["gamelist"]["JingleBells"] = array("叮当响", "mg/JingleBells_Logo.png","");
$gameList["MG"]["gamelist"]["Fortuna"] = array("幸運财神", "mg/Fortuna_Logo.png","");
$gameList["MG"]["gamelist"]["RapidReels"] = array("快速卷轴", "mg/RapidReels_Logo.png","");
$gameList["MG"]["gamelist"]["GoldCoast"] = array("黄金海岸", "mg/GoldCoast_Logo.png","");
$gameList["MG"]["gamelist"]["Legacy"] = array("黄金遗产", "mg/Legacy_Logo.png","");
$gameList["MG"]["gamelist"]["goblinsgold"] = array("黄金精灵", "mg/GoblinsGold_Logo.png","");
$gameList["MG"]["gamelist"]["SpellBound"] = array("出神入化", "mg/SpellBound_Logo.png","");
$gameList["MG"]["gamelist"]["JewelThief"] = array("珠宝神偷", "mg/JewelThief_Logo.png","");
$gameList["MG"]["gamelist"]["SamuraiSevens"] = array("武士7S", "mg/Samurai7s_Logo_2.png","");
$gameList["MG"]["gamelist"]["lions"] = array("万兽之王", "mg/LionsShare_Logo.png","");
$gameList["MG"]["gamelist"]["Astronomical"] = array("天文奇迹", "mg/Astronomical_Logo.png","");
$gameList["MG"]["gamelist"]["crackerjack"] = array("红利炮竹", "mg/CrackerJack_Logo.png","");
$gameList["MG"]["gamelist"]["JackintheBox"] = array("杰克箱子", "mg/JackintheBox_Logo.png","");
$gameList["MG"]["gamelist"]["totemtreasure"] = array("图腾宝藏", "mg/TotemTreasure_Button.jpg","");
$gameList["MG"]["gamelist"]["zebra"] = array("搞笑斑马", "mg/ZanyZebra_Logo.png","");
$gameList["MG"]["gamelist"]["RingsnRoses"] = array("戒指和玫瑰", "mg/Rings&Roses_Logo.png","");
$gameList["MG"]["gamelist"]["PeekaBoo"] = array("躲猫猫", "mg/PeekABoo_StackedLogo_GraphicBackground_ZH.png","");
$gameList["MG"]["gamelist"]["FairyRing"] = array("神奇蘑菇圈", "mg/FairyRing.png","");
$gameList["MG"]["gamelist"]["FruitSalad"] = array("水果沙拉", "mg/FruitSalad_Logo.png","");
$gameList["MG"]["gamelist"]["partytime"] = array("派对时间", "mg/PartyTime_Logo.png","");
$gameList["MG"]["gamelist"]["Crazy80s"] = array("疯狂八零年代", "mg/Crazy80s_Logo.png","");
$gameList["MG"]["gamelist"]["FrootLoot"] = array("水果圈圈", "mg/FrootLoot_Logo.png","");
$gameList["MG"]["gamelist"]["HotShot"] = array("棒球热", "mg/HotShot_Logo.png","");
$gameList["MG"]["gamelist"]["GoodToGo"] = array("开心出发", "mg/GoodToGo_Logo.png","");
$gameList["MG"]["gamelist"]["triplemagic"] = array("三重魔力", "mg/TripleMagic_Logo.png","");
$gameList["MG"]["gamelist"]["BarBarBlackSheep"] = array("黑绵羊咩咩叫", "mg/BarBarBlackSheep_250x250.jpg","");
$gameList["MG"]["gamelist"]["SonicBoom"] = array("超速音爆", "mg/SonicBoom_Logo.png","");
$gameList["MG"]["gamelist"]["JungleJim"] = array("丛林吉姆", "mg/JungleJim_Logo.png","");
$gameList["MG"]["gamelist"]["Harveys"] = array("哈维", "mg/Harveys_Button_HiDef.png","");
$gameList["MG"]["gamelist"]["Munchkins"] = array("梦境", "mg/Munchkins.png","");
$gameList["MG"]["gamelist"]["Twister"] = array("说谎者", "mg/Twister_Logo.png","");
$gameList["MG"]["gamelist"]["Kathmandu"] = array("加德满都", "mg/Kathmandu_200x200.png","");
$gameList["MG"]["gamelist"]["SupeItUp"] = array("苏佩起来", "mg/SupeItUp_Logo.png","");
$gameList["MG"]["gamelist"]["rrqueenofhearts"] = array("童话转轴红心皇后", "mg/RRHeartsAndTarts_Logo.png","");
$gameList["MG"]["gamelist"]["rrjackandjill"] = array("杰克与吉儿", "mg/RR_JackandJill_SquareLogo_ GraphicBackground.jpg","");
$gameList["MG"]["gamelist"]["SterlingSilver3d"] = array("纯银3D", "mg/SterlingSilver3D_Logo2.png","");
$gameList["MG"]["gamelist"]["DroneWars"] = array("雄蜂战争", "mg/DroneWars_Logo.png","");
$gameList["MG"]["gamelist"]["TheLandofLemuria"] = array("利莫里亚的土地", "mg/TheForgottenLandofLemuria_Button.png","");
$gameList["MG"]["gamelist"]["victorianvillain"] = array("维多利亚反派", "mg/VictorianVillain_Logo.png","");
$gameList["MG"]["gamelist"]["mountolympus"] = array("奥林匹斯山", "mg/MountOlympusRevengeOfMedusa_Logo.png","");
$gameList["MG"]["gamelist"]["jekyllandhyde"] = array("哲基尔&海德", "mg/JekyllAndHyde_Logo.png","");
$gameList["MG"]["gamelist"]["hellsgrannies"] = array("地狱的祖母", "mg/HellsGrannies_Logo.png","");
$gameList["MG"]["gamelist"]["alaxeinzombieland"] = array("尸乐园的亚历克斯", "mg/AlaxeInZombieland.png","");
$gameList["MG"]["gamelist"]["rollerderby"] = array("德比滚筒", "mg/RollerDerby_Logo.jpg","");
$gameList["MG"]["gamelist"]["untamedbengaltiger"] = array("野性孟加拉虎", "mg/UntamedBengalTiger_SquareLogo.jpg","");
$gameList["MG"]["gamelist"]["LuckyRabbitsLoot"] = array("幸运兔的战利品", "mg/LuckyRabbitLoot_Button.png","");
$gameList["MG"]["gamelist"]["bootytime"] = array("宝藏时间", "mg/BootyTime.png","");
$gameList["MG"]["gamelist"]["tigervsbear"] = array("虎VS熊", "mg/TigerVsBear_Logo.png","");
$gameList["MG"]["gamelist"]["whitebuffalo"] = array("白水牛", "mg/WhiteBuffalo_Logo.png","");
$gameList["MG"]["gamelist"]["mystiquegrove"] = array("神秘格罗夫", "mg/MystiqueGrove_Logo.png","");
$gameList["MG"]["gamelist"]["thelostprincessanastasia"] = array("财富联盟", "mg/TheLostPrincessAnastasia_Logo.png","");
$gameList["MG"]["gamelist"]["surfsafari"] = array("冲浪旅行", "mg/SurfSafari_Logo.png","");
$gameList["MG"]["gamelist"]["phantomcash"] = array("幻影现金", "mg/PhantomCash_Logo.png","");
$gameList["MG"]["gamelist"]["CricketStar"] = array("板球明星", "mg/CricketStar.jpg","");
$gameList["MG"]["gamelist"]["Octopays"] = array("海底总动员", "mg/Octopays_Logo.png","");
$gameList["MG"]["gamelist"]["untamedwolfpack"] = array("野狼", "mg/UntamedWolfPack_Logo_Wild.jpg","");
$gameList["MG"]["gamelist"]["mugshotmadness"] = array("面具007", "mg/MugshotMadness_SquareLogo_WithBackground.jpg","");
$gameList["MG"]["gamelist"]["LegendOfOlympus"] = array("奥林帕斯山的传说", "mg/LegendOfOlympus_Logo.png","");
$gameList["MG"]["gamelist"]["galacticons"] = array("迷走星球", "mg/Galacticons_Logo.png","");
$gameList["MG"]["gamelist"]["piggyfortunes"] = array("三只小猪", "mg/PiggyFortunes_Logo.png","");
$gameList["MG"]["gamelist"]["bridezilla"] = array("新娘瑞拉", "mg/Bridezilla_Logo.png","");
$gameList["MG"]["gamelist"]["wildcatch"] = array("野生捕获", "mg/WildCatch_GameLogo.png","");
$gameList["MG"]["gamelist"]["ParadiseFound"] = array("发现天堂", "mg/ParadiseFound_GameLogo.png","");
$gameList["MG"]["gamelist"]["ScaryFriends"] = array("可怕的朋友", "mg/ScaryFriends_Logo.png","");
$gameList["MG"]["gamelist"]["HappyHolidays"] = array("快乐假日", "mg/HappyHolidays.png","");
$gameList["MG"]["gamelist"]["SoMuchSushi"] = array("寿司这么多", "mg/SoMuchSushi_SquareLogo_GraphicBackground.jpg","");
$gameList["MG"]["gamelist"]["SoManyMonsters"] = array("怪物这么多", "mg/SoManyMonsters_SquareLogo_GraphicBackground.jpg","");
$gameList["MG"]["gamelist"]["SoMuchCandy"] = array("糖果这么多", "mg/SoMuchCandy_SquareLogo_GraphicBackground.jpg","");
$gameList["MG"]["gamelist"]["PenguinSplash"] = array("企鹅家族", "mg/PenguinSplash_Logo.png","");
$gameList["MG"]["gamelist"]["GoldenPrincess"] = array("千金小姐", "mg/GoldenPrincess.png","");
$gameList["MG"]["gamelist"]["RoboJack"] = array("机器人杰克", "mg/RoboJack_SquareLogo_GraphicBackground.jpg","");
$gameList["MG"]["gamelist"]["JurassicPark"] = array("侏罗纪公园", "mg/JurassicPark_250x250.jpg","");
$gameList["MG"]["gamelist"]["ForsakenKingdom"] = array("失落的国度", "mg/ForsakenKingdom.png","");
$gameList["MG"]["gamelist"]["TreasureIsland"] = array("金银岛", "mg/TreasureIsland_Logo.png","");
$gameList["MG"]["gamelist"]["Pinocchio"] = array("木偶奇遇记", "mg/Pinocchio'sFortune_Logo.jpg","");
$gameList["MG"]["gamelist"]["VikingQuest"] = array("海盗任务", "mg/VikingQuest_Logo.png","");
$gameList["MG"]["gamelist"]["BigChef"] = array("厨神", "mg/BigChef_SquareLogo_GraphicBackground.png","");
$gameList["MG"]["gamelist"]["GoldenEra"] = array("黄金时代", "mg/GoldenEra.jpg","");
$gameList["MG"]["gamelist"]["DragonsMyth"] = array("飞龙史密斯", "mg/DragonsMyth_Logo.png","");
$gameList["MG"]["gamelist"]["HoundHotel"] = array("酷犬酒店", "mg/HoundHotel.png","");
$gameList["MG"]["gamelist"]["titansofthesunhyperion"] = array("太阳神之许珀里翁", "mg/TitansOfTheSun_Hyperion_StackedLogo_GraphicBackground.png","");
$gameList["MG"]["gamelist"]["titansofthesuntheia"] = array("太阳神之忒伊亚", "mg/TitansOfTheSun_Theia_00_WildLogo.png","");
$gameList["MG"]["gamelist"]["SunTide"] = array("太阳征程", "mg/SunTide_StackedLogo_GraphicBackground.png","");
$gameList["MG"]["gamelist"]["winsumdimsum"] = array("开心点心", "mg/WinSumDimSum_StackedLogo_GraphicBackground.png","");
$gameList["MG"]["gamelist"]["StarDust"] = array("星尘", "mg/StarDust.jpg","");
$gameList["MG"]["gamelist"]["BreakDaBankAgain"] = array("智破银行", "mg/BreakdaBankAgain_Logo1.jpg","");
$gameList["MG"]["gamelist"]["Cashapillar"] = array("现金虫虫", "mg/Cashapillar_250x250.png","");
$gameList["MG"]["gamelist"]["TheRatPack"] = array("鼠帮", "mg/theRatPack.jpg","");
$gameList["MG"]["gamelist"]["StashOfTheTitans"] = array("泰坦帝国", "mg/stashofthetitans_Mobile.png","");
$gameList["MG"]["gamelist"]["GungPow"] = array("火炮战俘", "mg/GungPow.jpg","");
$gameList["MG"]["gamelist"]["DeckTheHalls"] = array("好牌大厅", "mg/DeckTheHalls_Logo.png","");
$gameList["MG"]["gamelist"]["ladyinred"] = array("红衣女郎", "mg/LadyInRed_Logo.png","");
$gameList["MG"]["gamelist"]["CentreCourt"] = array("中心球场", "mg/MPCentreCourt_SquareLogo_WithBackground.png","");
$gameList["MG"]["gamelist"]["mayanprincess"] = array("玛雅公主", "mg/MayanPrincess_01_LoadingScreen_iPhone5.jpg","");
$gameList["MG"]["gamelist"]["RROldKingCole"] = array("老国王科尔", "mg/RhymingReelsOldKingCole_Logo.png","");
$gameList["MG"]["gamelist"]["DiamondDeal"] = array("钻石交易", "mg/DiamondDeal_Logo.png","");
$gameList["MG"]["gamelist"]["WasabiSan"] = array("芥末先生", "mg/WasabiSan_Logo.png","");
$gameList["MG"]["gamelist"]["WorldCupMania"] = array("疯狂世界杯", "mg/WorldCupMania_Logo.png","");
$gameList["MG"]["gamelist"]["CabinFever"] = array("狂热机舱", "mg/CabinFever_Logo.png","");
$gameList["MG"]["gamelist"]["Elementals"] = array("元素生物", "mg/Elementals_Logo.png","");
$gameList["MG"]["gamelist"]["SizzlingScorpions"] = array("灼热蝎子", "mg/BTN_SizzlingScorpions1.png","");
$gameList["MG"]["gamelist"]["WheelofWealth"] = array("财富的自由", "mg/WheelOfWealthSpecialEdition_Button.png","");
$gameList["MG"]["gamelist"]["WitchesWealth"] = array("女巫财富", "mg/WitchesWealth_250x250.png","");
$gameList["MG"]["gamelist"]["spectacular"] = array("华丽剧场", "mg/SpectacularWheelOfWealth1.png","");
$gameList["MG"]["gamelist"]["whatonearth"] = array("征服者入侵", "mg/WhatOnEarth_Logo.png","");
$gameList["MG"]["gamelist"]["moonshine"] = array("空想奇谈", "mg/Moonshine_Logo.png","");
$gameList["MG"]["gamelist"]["dinomight"] = array("迪诺魔法门", "mg/DinoMight_Logo1.png","");
$gameList["MG"]["gamelist"]["loaded"] = array("幸运嘻哈", "mg/Loaded_HD_Logo_Horizontal_GraphicBackground.png","");
$gameList["MG"]["gamelist"]["SureWin"] = array("绝对胜利", "mg/SureWin_120x60.jpg","");
$gameList["MG"]["gamelist"]["cashville"] = array("土豪金", "mg/Cashville_Logo.png","");
$gameList["MG"]["gamelist"]["pollennation"] = array("蜜蜂乐园", "mg/PollenNation_250x250.png","");
$gameList["MG"]["gamelist"]["giftrap"] = array("饶舌礼物", "mg/GiftRap_Logo.png","");
$gameList["MG"]["gamelist"]["Halloweenies"] = array("万圣节怪谈", "mg/Halloweenies_Button.png","");
$gameList["MG"]["gamelist"]["Dogfather"] = array("狗老大", "mg/DogFather.png","");
$gameList["MG"]["gamelist"]["madhatters"] = array("疯狂帽匠", "mg/MadHatters_GameButton.png","");
$gameList["MG"]["gamelist"]["Cashanova"] = array("伯爵功绩", "mg/Cashanova_Logo.png","");
$gameList["MG"]["gamelist"]["wheelofwealthse"] = array("华丽剧场", "mg/WheelOfWealthSpecialEdition.png","");
$gameList["MG"]["gamelist"]["BarsAndStripes"] = array("酒吧和条纹", "mg/Bars&Stripes_HiDef.png","");
$gameList["MG"]["gamelist"]["starscape"] = array("星光斗篷", "mg/BTN_StarScape1.png","");
$gameList["MG"]["gamelist"]["MagicSpell"] = array("魔法咒语", "mg/MagicSpell_Logo.png","");
$gameList["MG"]["gamelist"]["PrimeProperty"] = array("豪宅", "mg/PrimeProperty_Logo.png","");
$gameList["MG"]["gamelist"]["3Empires"] = array("逐鹿三国", "mg/3Empires.jpg","");
$gameList["MG"]["gamelist"]["rubyhitman"] = array("终极杀手", "mg/Hitman.jpg","");
$gameList["MG"]["gamelist"]["TombRaiderII"] = array("古墓丽影之神剑的秘密", "mg/TombRaider_250x250.png","");
$gameList["MG"]["gamelist"]["BigBreak"] = array("重大突破", "mg/BigBreak_SC_Logo.png","");
$gameList["MG"]["gamelist"]["BigKahunaSnakesAndLadders"] = array("大胡纳 - 青蛇与梯子", "mg/BigKahunaSnakesAndLadders_250x250.png","");
$gameList["MG"]["gamelist"]["fatladysings"] = array("丰满歌手", "mg/FatLadySings_Logo.png","");
$gameList["MG"]["gamelist"]["Scrooge"] = array("守财奴", "mg/Scrooge_Logo.png","");
$gameList["MG"]["gamelist"]["jewelsoftheorient"] = array("东方之珠", "mg/JewelsOfTheOrient_Logo.png","");
$gameList["MG"]["gamelist"]["ArcticFortune"] = array("北极祕宝", "mg/ArcticFortune_Logo.png","");
$gameList["MG"]["gamelist"]["BullseyeGameshow"] = array("正中红心", "mg/BTN_Bullseye_Gameshow.png","");
$gameList["MG"]["gamelist"]["HellBoy"] = array("地狱男爵", "mg/Hellboy_LOGO.jpg","");
$gameList["MG"]["gamelist"]["ThunderStruck2HighLimit"] = array("雷霆万钧 2 - 高额投注", "mg/TSII_Thor_1024x768.jpg","");
$gameList["MG"]["gamelist"]["SoccerSafari"] = array("足球乐园", "mg/SoccerSafari_250x250.png","");
$gameList["MG"]["gamelist"]["throneofegypt"] = array("埃及王朝", "mg/ThroneOfEgypt_Logo.png","");
$gameList["MG"]["gamelist"]["steampunkheroes"] = array("蒸汽朋克英雄", "mg/SteamPunkHeroes_Logo.png","");
$gameList["MG"]["gamelist"]["ChainMailNew"] = array("锁子甲", "mg/ChainMail.png","");
$gameList["MG"]["gamelist"]["irisheyes"] = array("翡翠眼珠", "mg/IrishEyes_Belly.png","");
$gameList["MG"]["gamelist"]["crocodopolis"] = array("克罗马科多", "mg/Crocodopolis_Logo.png","");
$gameList["MG"]["gamelist"]["doctorlove"] = array("爱的急救", "mg/DoctorLove_Belly.png","");
$gameList["MG"]["gamelist"]["ramessesriches"] = array("拉美西斯宝藏", "mg/RamessesRiches_Button.png","");
$gameList["MG"]["gamelist"]["jackspwrpoker"] = array("对J高手5PK(多组牌)", "mg/JacksorBetterPowerPoker1.png","");
$gameList["MG"]["gamelist"]["deuceswildpwrpoker"] = array("百搭二王(多组)", "mg/DeucesWildPowerPoker1.png","");
$gameList["MG"]["gamelist"]["jokerpwrpoker"] = array("小丑", "mg/JokerPokerPowerPoker1.png","");
$gameList["MG"]["gamelist"]["DoubleJokerPwrPoker"] = array("小丑百搭5PK(多組牌)", "mg/DoubleJokerPowerPoker1.png","");
$gameList["MG"]["gamelist"]["MoneyMadMonkey"] = array("疯狂猴子", "mg/MoneyMadMonkey_SmallLogo.png","");
$gameList["MG"]["gamelist"]["KingArthur"] = array("阿瑟王", "mg/KingArthur_Logo.png","");
$gameList["MG"]["gamelist"]["AroundTheWorld"] = array("环游世界", "mg/AroundTheWorld.png","");
$gameList["MG"]["gamelist"]["pubfruity"] = array("酒吧果味", "mg/PubFruity_Logo.png","");
$gameList["MG"]["gamelist"]["SpooksAndLadders"] = array("妖怪屋", "mg/Spooks&Ladders_Logo.png","");
$gameList["MG"]["gamelist"]["MagnificentSevens"] = array("华丽七人榄球", "mg/MagnificentSevens_Logo.png","");
$gameList["MG"]["gamelist"]["SpinMagic"] = array("魔法回旋", "mg/SpinMagic_Logo.png","");
$gameList["MG"]["gamelist"]["WheelOfRiches"] = array("财富之轮", "mg/WheelOfWealth1_Button.png","");
$gameList["MG"]["gamelist"]["DawnOfTheBread"] = array("僵尸面包", "mg/DawnOfTheBread_Logo.png","");
$gameList["MG"]["gamelist"]["FreezingFuzzballs"] = array("丢冰球", "mg/FreezingFuzzballs_Logo.png","");
$gameList["MG"]["gamelist"]["WildChampions"] = array("狂野冠军", "mg/WildChampions_Logo.png","");
$gameList["MG"]["gamelist"]["IWCashapillar"] = array("现金虫虫", "mg/Cashapillar_250x250.png","");
$gameList["MG"]["gamelist"]["IWBigBreak"] = array("突破实时", "mg/BigBreak_SC_Logo_GraphicBkg.png","");
$gameList["MG"]["gamelist"]["IWCardSelector"] = array("超级女警", "mg/SuperZeroes_Logo.png","");
$gameList["MG"]["gamelist"]["GrannyPrix"] = array("赛车老奶奶", "mg/GrannyPrix_Logo.png","");
$gameList["MG"]["gamelist"]["SlamFunk"] = array("大满贯芬克", "mg/SlamFunk_Logo.png","");
$gameList["MG"]["gamelist"]["IWHalloweenies"] = array("万圣狂欢", "mg/Halloweenies_Mobile.png","");
$gameList["MG"]["gamelist"]["BunnyBoiler"] = array("兔子跳跳跳", "mg/BunnyBoiler_Button.png","");
$gameList["MG"]["gamelist"]["MumbaiMagic"] = array("孟买魔术", "mg/MumbaiMagic_Logo.png","");
$gameList["MG"]["gamelist"]["BingoBonanza"] = array("宾果富矿", "mg/BingoBonanza_Logo.png","");
$gameList["MG"]["gamelist"]["GoldenGhouls"] = array("僵尸家族", "mg/GoldenGhouls_Logo.png","");
$gameList["MG"]["gamelist"]["BallisticBingo"] = array("弹道宾果", "mg/BallisticBingo1.png","");
$gameList["MG"]["gamelist"]["SuperBonusBingo"] = array("超级奖金宾果", "mg/SuperBonusBingo_Logo.jpg","");
$gameList["MG"]["gamelist"]["LuckyNumbers"] = array("幸运数字", "mg/LuckyNumbers_Logo.png","");
$gameList["MG"]["gamelist"]["CryptCrusade"] = array("黄金墓穴探险", "mg/CryptCrusade_Logo.png","");
$gameList["MG"]["gamelist"]["SixShooterLooter"] = array("六射手掠夺黄金", "mg/SixShooterLooter_Logo.png","");
$gameList["MG"]["gamelist"]["BeerFest"] = array("推啤酒大赛", "mg/BeerFest.png","");
$gameList["MG"]["gamelist"]["PharaohsGems"] = array("法老的宝石", "mg/PharaohsGems1.png","");
$gameList["MG"]["gamelist"]["FoamyFortunes"] = array("钱进泡泡", "mg/FoamyFortunes_Logo.png","");
$gameList["MG"]["gamelist"]["PlunderTheSea"] = array("掠夺海", "mg/PlunderTheSea_Logo.png","");
$gameList["MG"]["gamelist"]["SpaceEvader"] = array("航天金卡强制收兑", "mg/SpaceEvader_Logo.png","");
$gameList["MG"]["gamelist"]["BowledOver"] = array("滚球王", "mg/BowledOver_Logo.png","");
$gameList["MG"]["gamelist"]["OffsideAndSeek"] = array("越位寻求", "mg/Offside&Seek_Logo.png","");
$gameList["MG"]["gamelist"]["TurtleyAwesome"] = array("忍者龟", "mg/TurtleyAwesome_Logo.png","");
$gameList["MG"]["gamelist"]["GameSetAndScratch"] = array("网球刮刮乐", "mg/GameSet&Scratch_Logo.png","");
$gameList["MG"]["gamelist"]["WhackAJackpot"] = array("打地鼠", "mg/WhackAJackpot_Logo.png","");
$gameList["MG"]["gamelist"]["HandToHandCombat"] = array("肉搏战", "mg/HandToHandCombat.png","");
$gameList["MG"]["gamelist"]["Kashatoa"] = array("魔三角", "mg/Kashatoa1.png","");
$gameList["MG"]["gamelist"]["CardClimber"] = array("卡登山", "mg/CardClimber_Logo_Small.png","");
$gameList["MG"]["gamelist"]["KillerClubs"] = array("杀手俱乐部", "mg/KillerClubs1.png","");
$gameList["MG"]["gamelist"]["BunnyBoilerGold"] = array("兔子跳跳跳", "mg/BunnyBoilerGold_Logo.png","");
$gameList["MG"]["gamelist"]["SixShooterLooterGold"] = array("六射手掠夺黄金", "mg/SixShooterLooter_Logo.png","");
$gameList["MG"]["gamelist"]["SpaceEvaderGold"] = array("航天金卡强制收兑", "mg/SpaceEvader_Logo.png","");
$gameList["MG"]["gamelist"]["CryptCrusadeGold"] = array("黄金墓穴探险", "mg/CryptCrusade_Logo.png","");
$gameList["MG"]["gamelist"]["enchantedwoods"] = array("魔法森林", "mg/EnchantedWoods_Logo.png","");
$gameList["MG"]["gamelist"]["germinator"] = array("矿怪联机", "mg/BTN_Germinator.png","");
$gameList["MG"]["gamelist"]["spingo"] = array("旋转魔球", "mg/Spingo_Logo.png","");
$gameList["MG"]["gamelist"]["pharaohbingo"] = array("法老宾果", "mg/PharaohBingo_Logo_2.png","");
$gameList["MG"]["gamelist"]["sambabingo"] = array("森巴宾果", "mg/SambaBingo_Logo.png","");
$gameList["MG"]["gamelist"]["mayanbingo"] = array("玛雅宾果", "mg/MayanBingo_Icon2.png","");
$gameList["MG"]["gamelist"]["electrobingo"] = array("电子宾果", "mg/ElectroBingo_Logo.png","");
$gameList["MG"]["gamelist"]["fourbyfour"] = array("四中四", "mg/FourByFour_Button.png","");
$gameList["MG"]["gamelist"]["hexaline"] = array("彩色蜂窝", "mg/Hexaline_Logo.png","");
$gameList["MG"]["gamelist"]["triangulation"] = array("彩色三角", "mg/Triangulation_Logo.jpg","");
$gameList["MG"]["gamelist"]["KaraokeParty"] = array("K 歌乐韵", "mg/KaraokeParty.png","");
$gameList["MG"]["gamelist"]["MonkeyKeno"] = array("猴子基诺", "mg/MonkeyKeno.png","");
$gameList["MG"]["gamelist"]["FrozenDiamonds"] = array("冰钻奇缘", "mg/FrozenDiamonds.png","");
$gameList["MG"]["gamelist"]["ReelSpinner"] = array("旋转大战", "mg/ReelSpinner.jpg","");
$gameList["MG"]["gamelist"]["ElectricDiva"] = array("雷电歌后", "mg/ElectricDiva.png","");
$gameList["MG"]["gamelist"]["NinjaMagic"] = array("忍者法宝", "mg/NinjaMagic.png","");
$gameList["MG"]["gamelist"]["PrettyKitty"] = array("漂亮猫咪", "mg/PrettyKitty.png","");
$gameList["MG"]["gamelist"]["voila"] = array("这里", "mg/Voila!_Mobile.png","");
$gameList["MG"]["gamelist"]["treasurePalace"] = array("宝殿", "mg/TreasurePalace_HiDef.png","");
$gameList["MG"]["gamelist"]["tigersEye"] = array("虎眼石", "mg/TigersEye_250x250pixels.png","");
$gameList["MG"]["gamelist"]["theGrandJourney"] = array("盛大旅程", "mg/TheGrandJourney_HiDef.png","");
$gameList["MG"]["gamelist"]["summerHoliday"] = array("暑假", "mg/SummerHoliday_Mobile_HiDef.png","");
$gameList["MG"]["gamelist"]["partyIsland"] = array("派对岛", "mg/PartyIsland_Logo.png","");
$gameList["MG"]["gamelist"]["LuckyKoi"] = array("幸运锦鲤", "mg/LuckyKoi_01_Wild Logo.jpg","");
$gameList["MG"]["gamelist"]["liquidGold"] = array("液体黄金", "mg/LiquidGold_Mobile_ButtonHiDef.png","");
$gameList["MG"]["gamelist"]["lionsPride"] = array("狮子的骄傲", "mg/LionsPride_GameIcon.png","");
$gameList["MG"]["gamelist"]["HighSociety"] = array("上流社会", "mg/HighSociety.jpg","");
$gameList["MG"]["gamelist"]["breakdabank"] = array("银行破坏家", "mg/BreakDaBank.png","");
$gameList["MG"]["gamelist"]["boogieMonsters"] = array("布吉怪兽", "mg/BoogieMonsters_Mobile_HiDef.png","");
$gameList["MG"]["gamelist"]["beachBabes"] = array("海滩辣妹", "mg/BeachBabes_HiDef.png","");
$gameList["MG"]["gamelist"]["acesAndFaces"] = array("A与扑克牌!", "mg/Aces&Faces.png","");
$gameList["MG"]["gamelist"]["vegasDowntownBlackjackGold"] = array("金牌拉斯维加斯市中心21点", "mg/VegasDowntownBlackjackGold_250x250.png","");
$gameList["MG"]["gamelist"]["americanRouletteGold"] = array("金牌美式轮盘", "mg/AmericanRouletteGold_Mobile_HiDef.png","");
$gameList["MG"]["gamelist"]["Huangdi_TYE"] = array("轩辕帝传", "mg/Huangdi_TheYellowEmperor_00_wild.png","");
$gameList["MG"]["gamelist"]["FruitVSCandy"] = array("水果糖果", "mg/FruitVsCandy_Button_Logo_Bkg_ZH.png","");
$gameList["MG"]["gamelist"]["secretRomanceDesktop"] = array("秘密爱慕者", "mg/SecretRomance_Button_Logo_Bkg_ZH.png","");
$gameList["MG"]["gamelist"]["Tarzan"] = array("泰山", "mg/Tarzan_138x125.png","");
$gameList["MG"]["gamelist"]["maxdamage"] = array("最大伤害与外星人袭击", "mg/MaxDamage_alien.jpg","");
$gameList["MG"]["gamelist"]["MaxDamageSlot"] = array("最大伤害", "mg/MaxDamage_SquareLogo_GraphicBackground.jpg","");
$gameList["MG"]["gamelist"]["FreeSpirit"] = array("自由精神", "mg/FreeSpiritWheelOfWealth_Logo.png","");
$gameList["MG"]["gamelist"]["picknswitch"] = array("选择与交换", "mg/PickNSwitch_Logo.png","");
$gameList["MG"]["gamelist"]["ChiefsFortune"] = array("幸运酋长", "mg/chiefs_fortune.jpg","");
$gameList["MG"]["gamelist"]["RacingForPinks"] = array("为粉红而战", "mg/RacingForPinks_SquareLogo_GraphicBackground.jpg","");
$gameList["MG"]["gamelist"]["FlyingAce"] = array("王牌飞行员", "mg/FlyingAce_Icon.png","");
$gameList["MG"]["gamelist"]["jokerpok"] = array("小丑扑克", "mg/JokerPoker50Play_Logo.png","");
$gameList["MG"]["gamelist"]["SantaPaws"] = array("圣诞老人爪子", "mg/santaPaws.jpg","");
$gameList["MG"]["gamelist"]["SecretSanta"] = array("神秘圣诞老人", "mg/SecretSanta_SquareLogo_GraphicBackground.jpg","");
$gameList["MG"]["gamelist"]["AllAmerican"] = array("全美扑克", "mg/AllAmerican.png","");
$gameList["MG"]["gamelist"]["europeanadvbj"] = array("欧洲21点", "mg/EuropeanBlackjackGold_Button_1.png","");
$gameList["MG"]["gamelist"]["HairyFairies"] = array("毛绒仙女", "mg/HairyFairies_Logo.png","");
$gameList["MG"]["gamelist"]["flowerpower"] = array("力量之花", "mg/FlowerPower_Logo.png","");
$gameList["MG"]["gamelist"]["UntamedCrownedEagle"] = array("狂野之鹰", "mg/UntamedCrownedEagle_SquareLogo_PlainBackground.jpg","");
$gameList["MG"]["gamelist"]["premiertrotting"] = array("快步马驾车赛", "mg/PremierTrotting_logo.png","");
$gameList["MG"]["gamelist"]["acesfacespwrpoker"] = array("经典5PK(多组牌)", "mg/Aces&Faces.png","");
$gameList["MG"]["gamelist"]["mhbjclassic"] = array("经典21点(多组牌)", "mg/blackjack.jpg","");
$gameList["MG"]["gamelist"]["bj"] = array("经典21点", "mg/classic_blackjack.jpg","");
$gameList["MG"]["gamelist"]["PBJMultiHandBonus"] = array("金牌欧洲总理21点（多组牌）", "mg/MultiHandEuropeanBlackjackGold_ClarionButton.png","");
$gameList["MG"]["gamelist"]["europeanbjgoldredeal"] = array("金牌欧洲Redeal 21点", "mg/EuropeanBlackjackGold_Logo_1.png","");
$gameList["MG"]["gamelist"]["crownandanchor"] = array("皇冠骰子", "mg/Crown&Anchor_Logo.png","");
$gameList["MG"]["gamelist"]["DonDeal"] = array("黑手交易", "mg/DonDeal_Logo.png","");
$gameList["MG"]["gamelist"]["BarBarBlackSheep5Reel"] = array("黑绵羊咩咩叫", "mg/BarBarBlackSheep_250x250.jpg","");
$gameList["MG"]["gamelist"]["LooseCannon"] = array("海盗王", "mg/LooseCannon_SquareLogo_GraphicBackground.jpg","");
$gameList["MG"]["gamelist"]["FrenchRoulette"] = array("法式轮盘", "mg/FrenchRoulette_Logo.png","");
$gameList["MG"]["gamelist"]["msbreakdabankagain"] = array("多台-银行抢匪2", "mg/MS_BreakdaBankAgain_Logo.png","");
$gameList["MG"]["gamelist"]["tensorbetterpwrpoker"] = array("对十天王5PK(多組牌)", "mg/TensOrBetter4PlayPowerPoker_Button.png","");
$gameList["MG"]["gamelist"]["mhbjatlanticcity"] = array("大西洋城21点(多组牌)", "mg/Atlantic_city_blackjack_gold.jpg","");
$gameList["MG"]["gamelist"]["sweetharvest"] = array("大丰收", "mg/SweetHarvest_SquareLogo_WithBackground.jpg","");
$gameList["MG"]["gamelist"]["CastleBuilder"] = array("城堡建筑师", "mg/CastleBuilder_Logo.png","");
$gameList["MG"]["gamelist"]["premierracing"] = array("超級賽馬", "mg/PremierRacing_Logo.png","");
$gameList["MG"]["gamelist"]["SuperZeroes"] = array("超级零点", "mg/SuperZeroes_Logo.png","");
$gameList["MG"]["gamelist"]["DeucesJokerPwrPoker"] = array("百搭二王与小丑 (多组)", "mg/DeucesJokerPowerPoker1.png","");
$gameList["MG"]["gamelist"]["Avalon2"] = array("阿瓦隆2", "mg/AvalonII_200x200.jpg","");
$gameList["MG"]["gamelist"]["majorMillions"] = array("Major Millions 5 Reel", "mg/major_millions.jpg","");
$gameList["MG"]["gamelist"]["isis"] = array("伊西斯", "mg/Isis_Logo.png","");
$gameList["MG"]["gamelist"]["megaMoolah"] = array("百万钞票", "mg/MegaMoolah_Mobile_Lobby.png","");
$gameList["MG"]["gamelist"]["treasureNile"] = array("Treasure Nile", "mg/treasure_nile.jpg","");
$gameList["MG"]["gamelist"]["RRGeorgiePorgie"] = array("乔治与柏志", "mg/RhymingReelsGeorgiePorgie_SquareLogo_GraphicBackground.jpg","");
$gameList["MG"]["gamelist"]["GoldFactoryHighLimit"] = array("黄金工厂-高级版", "mg/GoldFactory_Logo.png","");
$gameList["MG"]["gamelist"]["BullsEye"] = array("命运靶心", "mg/BTN_Bullseye_Gameshow.png","");
$gameList["MG"]["gamelist"]["MysticDreams"] = array("神秘的梦", "mg/MysticDreams_SquareLogo_WithBackground.jpg","");
$gameList["MG"]["gamelist"]["bonuspaigowpoker"] = array("Pai Gow Poker", "mg/pai_gow_poker.jpg","");
$gameList["MG"]["gamelist"]["AmericanRouletteNoAutoplay"] = array("American Roulette", "mg/American_Roulette.jpg","");
$gameList["MG"]["gamelist"]["HighLimitBaccaratNoAutoplay"] = array("High Limit Baccarat", "mg/high_limit_baccarat.jpg","");
$gameList["MG"]["gamelist"]["3CardPoker"] = array("3 Card Poker", "mg/3cardPoker.jpg","");
$gameList["MG"]["gamelist"]["lotsofloot"] = array("LotsaLoot 3-Reel", "mg/LotsaLoot_3_reel.jpg","");
$gameList["MG"]["gamelist"]["LifeOfRiches"] = array("富裕人生", "mg/Life_of_Riches.jpg","");
$gameList["MG"]["gamelist"]["magicboxes"] = array("Magic Boxes", "mg/Magic_boxes.jpg","");
$gameList["MG"]["gamelist"]["ArcticAgents"] = array("Arctic Agents", "mg/Arctic_agents.jpg","");
$gameList["MG"]["gamelist"]["WesternFrontier"] = array("Western Frontier", "mg/western_frontier.jpg","");
$gameList["MG"]["gamelist"]["GameOfThronesLines"] = array("Game Of Thrones - 15 Lines", "mg/game_of_thrones.jpg","");
$gameList["MG"]["gamelist"]["GameOfThronesWays"] = array("Game Of Thrones - 243 Ways", "mg/game_of_thrones_243.jpg","");
$gameList["MG"]["gamelist"]["JungleJim_ElDorado"] = array("丛林吉姆 黄金国", "mg/Jungle_jim_EI_Dorado.jpg","");
$gameList["MG"]["gamelist"]["LostVegas"] = array("迷失拉斯维加斯", "mg/Lost_vegas.jpg","");
$gameList["MG"]["gamelist"]["PollenParty"] = array("花粉之国", "mg/pollen_party.jpg","");
$gameList["MG"]["gamelist"]["EmperorOfTheSea"] = array("青龙出海", "mg/emperor_of_the_sea.jpg","");
$gameList["MG"]["gamelist"]["Dragonz"] = array("幸运龙宝贝", "mg/dragonz.jpg","");
$gameList["MG"]["gamelist"]["fruitfiesta"] = array("Fruit Fiesta 3-Reel", "mg/fruit_Fiesta_3Reel.jpg","");
$gameList["MG"]["gamelist"]["cashsplash5reel"] = array("Cash Splash 5-Reel", "mg/cash_splash_5_reel.jpg","");
$gameList["MG"]["gamelist"]["fruitfiesta5reel"] = array("Fruit Fiesta 5-Reel", "mg/fruit_Fiesta_5Reel.jpg","");
$gameList["MG"]["gamelist"]["MegaMoolahIsis"] = array("Mega Moolah Isis", "mg/mega_moolah_isis.jpg","");
$gameList["MG"]["gamelist"]["jackpotdeuces"] = array("Jackpot Deuces", "mg/jackpot_deuces.jpg","");
$gameList["MG"]["gamelist"]["YouLuckyBarstard"] = array("You Lucky Barstard", "mg/you_lucky_barstard.jpg","");
$gameList["MG"]["gamelist"]["ChavinItlarge"] = array("Chavin it Large", "mg/chavin-it-large-slot.jpg","");
$gameList["MG"]["gamelist"]["abrakebabra"] = array("Abra-Kebab-Ra!", "mg/abra-kebab-ra-slot.png","");
$gameList["MG"]["gamelist"]["bingobangoboom"] = array("Bingo Bango Boom!", "mg/BingoBangoBoom_Logo.png","");
$gameList["MG"]["gamelist"]["doggyreelbingo"] = array("Doggy Reel Bingo", "mg/Doogy_Reel_Bingo.jpg","");
$gameList["MG"]["gamelist"]["copsandrobbers"] = array("Cops and Robbers", "mg/Cops_and_Robbers.jpg","");
$gameList["MG"]["gamelist"]["ladyluxor"] = array("Lady Luxor", "mg/lady-luxor-slot.jpg","");
$gameList["MG"]["gamelist"]["bundleinthejungle"] = array("Bundle in the Jungle", "mg/bundle-in-the-jungle-slot.png","");
$gameList["MG"]["gamelist"]["europeanRoulette"] = array("European Roulette Gold", "mg/European_Roulette_gold.jpg","");
$gameList["MG"]["gamelist"]["jacksOrBetter"] = array("Jacks or Better", "mg/Jacks_or_better.jpg","");
$gameList["MG"]["gamelist"]["deucesWild"] = array("Deuces Wild", "mg/DeucesWild.png","");
$gameList["MG"]["gamelist"]["atlanticCityBlackjackGold"] = array("金牌大西洋城21点", "mg/AtlanticCityBJGold_Logo_1.png","");
$gameList["MG"]["gamelist"]["europeanBlackjackGold"] = array("European Blackjack Gold", "mg/european_blackjeck_gold.jpg","");
$gameList["MG"]["gamelist"]["rhymingReelsGeorgiePorgie"] = array("Rhyming Reels - Georgie Porgie", "mg/RR_GeorgiePorgie.jpg","");
$gameList["MG"]["gamelist"]["rivieraRiches"] = array("Riviera Riches", "mg/RivieraRiches_HiDef.png","");
$gameList["MG"]["gamelist"]["coolBuck5ReelDesktop"] = array("运财酷儿 - 5 Reel", "mg/cool_buck.jpg","");
$gameList["MG"]["gamelist"]["centerCourt"] = array("Centre Court", "mg/centre_court.jpg","");
$gameList["MG"]["gamelist"]["barsNStripes"] = array("Bars & Stripes", "mg/barsNStripes.jpg","");
$gameList["MG"]["gamelist"]["hitman"] = array("Hitman", "mg/Hitman.jpg","");
$gameList["MG"]["gamelist"]["theHeatIsOn"] = array("The Heat Is On", "mg/the_heat_is_on.jpg","");
$gameList["MG"]["gamelist"]["goldwynsFairiesDesktop"] = array("金色女王的仙女", "mg/Goldwyns_fairies.jpg","");
$gameList["MG"]["gamelist"]["fortuneGirlDesktop"] = array("金库甜心", "mg/fortune_girl.jpg","");
$gameList["MG"]["gamelist"]["forbiddenThroneDesktop"] = array("Forbidden Throne", "mg/forbidden_throne.jpg","");
$gameList["MG"]["gamelist"]["theHeatIsOnDesktop"] = array("The Heat Is On", "mg/the_heat_is_on.jpg","");
$gameList["MG"]["gamelist"]["classic243Desktop"] = array("Classic 243", "mg/classic_243.jpg","");
$gameList["MG"]["gamelist"]["shanghaiBeautyDesktop"] = array("Shanghai Beauty", "mg/shanghao_beauty.jpg","");
$gameList["MG"]["gamelist"]["megaMoneyMultiplierDesktop"] = array("巨额现金乘数", "mg/mega_multiplier.jpg","");
$gameList["MG"]["gamelist"]["beautifulBonesDesktop"] = array("美丽骷髅", "mg/Beautiful_Bones.PNG","");
$gameList["MG"]["gamelist"]["jurassicWorldDesktop"] = array("侏㑩纪公园", "mg/JurassicPark_250x250.jpg","");
$gameList["MG"]["gamelist"]["sixAcrobatsDesktop"] = array("杂技群英会", "mg/six_Acrobats.jpg","");
$gameList["MG"]["gamelist"]["sugarParadeDesktop"] = array("糖果巡遊", "mg/Sugar_Parade.jpg","");
$gameList["MG"]["gamelist"]["108heroesDesktop"] = array("108好汉", "mg/108hero.jpg","");
$gameList["MG"]["gamelist"]["castleBuilderIIDesktop"] = array("城堡建筑师", "mg/Castle_Builder_II.jpg","");
$gameList["MG"]["gamelist"]["emotiCoinsDesktop"] = array("表情金币", "mg/EmotiCoins.png","");
$gameList["MG"]["gamelist"]["oinkCountryLoveDesktop"] = array("呼噜噜爱上乡下", "mg/Oink_Country_Love.jpg","");
$gameList["MG"]["gamelist"]["108heroesMultiplierFortunesDesktop"] = array("乘数财富", "mg/108HeroesMF.jpg","");
$gameList["MG"]["gamelist"]["gnomeWoodDesktop"] = array("矮木头", "mg/GnomeWood.jpg","");
$gameList["MG"]["gamelist"]["tastyStreetDesktop"] = array("妹妹很饿", "mg/TastyStreet.jpg","");
$gameList["MG"]["gamelist"]["halloweenDesktop"] = array("Halloween", "mg/Halloween.jpg","");
$gameList["MG"]["gamelist"]["monsterWheelsDesktop"] = array("怪物赛车", "mg/MonsterWheels.jpg","");
$gameList["MG"]["gamelist"]["mobyDickOnlineSlotDesktop"] = array("Moby Dick", "mg/MobyDick.png","");
$gameList["MG"]["gamelist"]["thePhantomoftheOperaDesktop"] = array("The Phantom Of The Opera", "mg/ThePhantomOfTheOpera.jpg","");
$gameList["MG"]["gamelist"]["enchantingSpellsDesktop"] = array("Enchanting Spells", "mg/EnchantingSpells.jpg","");
$gameList["MG"]["gamelist"]["fireNFortuneDesktop"] = array("Fire N' Fortune", "mg/FireN'Fortune.jpg","");
$gameList["MG"]["gamelist"]["mahjongExchangeDesktop"] = array("麻将互换", "mg/MahjongExchange.jpg","");
$gameList["MG"]["gamelist"]["CandyDreams"] = array("梦果子乐园", "mg/CandyDreams.png","");
$gameList["MG"]["gamelist"]["honeyMoonersDesktop"] = array("Honeymooners", "mg/Honeymooners.jpg","");
$gameList["MG"]["gamelist"]["KungFuCash"] = array("功夫财", "mg/KungFuCash.jpg","");
$gameList["MG"]["gamelist"]["goldenMoneyFrog"] = array("Golden Money Frog", "mg/GoldenMoneyFrog.png","");
$gameList["MG"]["gamelist"]["GunSmoke"] = array("Gunsmoke", "mg/Gunsmoke.png","");
$gameList["MG"]["gamelist"]["LegendsOfAfrica"] = array("Legends Of Africa", "mg/LegendsOfAfrica.png","");
$gameList["MG"]["gamelist"]["HauntedHouse"] = array("Haunted House", "mg/HauntedHouse.jpg","");
$gameList["MG"]["gamelist"]["GreenerPasteur"] = array("Greener Pasteur", "mg/GreenerPasteur.jpg","");
$gameList["MG"]["gamelist"]["TempleOfFortune"] = array("Temple of Fortune", "mg/TempleofFortune.png","");
$gameList["MG"]["gamelist"]["MachineGunUnicorn"] = array("Machine-Gun Unicorn", "mg/MachineGunUnicorn.jpg","");
$gameList["MG"]["gamelist"]["GodsOfGiza"] = array("Gods of Giza", "mg/GodsOfGiza.jpg","");
$gameList["MG"]["gamelist"]["DeepSeaDiver"] = array("Deep-Sea Diver", "mg/DeepSeaDiver.jpg","");
$gameList["MG"]["gamelist"]["Ragnarok"] = array("Ragnarok", "mg/Ragnarok.jpg","");
$gameList["MG"]["gamelist"]["ReindeerWilds"] = array("Reindeer Wild Wins", "mg/ReindeerWildWins.png","");
$gameList["MG"]["gamelist"]["FaeriesFortune"] = array("Faeries Fortune", "mg/FaeriesFortune.png","");
$gameList["MG"]["gamelist"]["VolcanoEruption"] = array("Volcano Eruption", "mg/VolcanoEruption.jpg","");
$gameList["MG"]["gamelist"]["SavannaKing"] = array("Savanna King", "mg/SavannaKing.png","");
$gameList["MG"]["gamelist"]["SkiJump"] = array("Ski Jump", "mg/SkiJump.jpg","");
$gameList["MG"]["gamelist"]["CoolAsIce"] = array("Cool as Ice", "mg/CoolAsIce.jpg","");
$gameList["MG"]["gamelist"]["GingerbreadLane"] = array("Gingerbread Lane", "mg/GingerbreadLane.png","");
$gameList["MG"]["gamelist"]["GoldStrike"] = array("Gold Strike", "mg/GoldStrike.png","");
$gameList["MG"]["gamelist"]["luckyLinksDesktop"] = array("幸运链接", "mg/LuckyLinks.jpg","");
$gameList["MG"]["gamelist"]["peekABooMobile"] = array("躲猫猫", "mg/PeekABoo.jpg","");
$gameList["MG"]["gamelist"]["girlsWithGunsJungleHeat"] = array("Girls With Guns Jungle Heat", "mg/GirlsWithGunsJungleHeat.jpg","");
$gameList["MG"]["gamelist"]["TempleQuest"] = array("Temple Quest", "mg/TempleQuest.png","");
$gameList["MG"]["gamelist"]["SpellOfOdin"] = array("Spell of Odin", "mg/SpellofOdin.jpg","");
$gameList["MG"]["gamelist"]["Nauticus"] = array("Nauticus", "mg/Nauticus.png","");
$gameList["MG"]["gamelist"]["Robyn"] = array("Robyn", "mg/Robyn.jpg","");
$gameList["MG"]["gamelist"]["FestivalQueens"] = array("Festival Queens", "mg/FestivalQueens.png","");
$gameList["MG"]["gamelist"]["CherriesGoneWild"] = array("Cherries Gone Wild", "mg/CherriesGoneWild.png","");
$gameList["MG"]["gamelist"]["FoxinWins"] = array("Foxin Wins", "mg/FoxinWins.jpg","");
$gameList["MG"]["gamelist"]["EmperorsGarden"] = array("Emperors Garden", "mg/EmperorsGarden.jpg","");
$gameList["MG"]["gamelist"]["TimberJack"] = array("Timber Jack", "mg/TimberJack.png","");
$gameList["MG"]["gamelist"]["TeddyBearsPicnic"] = array("Teddy Bear Picnic", "mg/TeddyBearsPicnic.jpg","");
$gameList["MG"]["gamelist"]["GoldenGoals"] = array("Golden Goals", "mg/GoldenGoals.png","");
$gameList["MG"]["gamelist"]["WildBirthdayBlast"] = array("Wild Birthday Blast", "mg/WildBirthdayBlast.png","");
$gameList["MG"]["gamelist"]["LuckyStreak"] = array("Lucky Streak", "mg/LuckyStreak.png","");
$gameList["MG"]["gamelist"]["IrishEyes2"] = array("Irish Eyes 2", "mg/IrishEyes2.jpg","");
$gameList["MG"]["gamelist"]["OilMania"] = array("Oil Mania", "mg/OilMania.png","");
$gameList["MG"]["gamelist"]["JourneyOfTheSun"] = array("Journey of the Sun", "mg/JourneyOfTheSun.png","");
$gameList["MG"]["gamelist"]["SovereignOfTheSevenSeas"] = array("Sovereign of the Seven Seas", "mg/SovereignOfTheSevenSeas.png","");
$gameList["MG"]["gamelist"]["SassyBingo"] = array("Sassy Bingo", "mg/SassyBingo.jpg","");
$gameList["MG"]["gamelist"]["jokerjester"] = array("Joker Jester", "mg/JokerJester.png","");
$gameList["MG"]["gamelist"]["firehawk"] = array("Fire Hawk", "mg/FireHawk.png","");
$gameList["MG"]["gamelist"]["kingTuskDesktop"] = array("大象之王", "mg/KingTusk.jpg","");
$gameList["MG"]["gamelist"]["JoyOfSix"] = array("Joy of Six", "mg/JoyOfSix.png","");
$gameList["MG"]["gamelist"]["BingoBonanza50"] = array("Bingo Bonanza", "mg/BingoBonanza.png","");
$gameList["MG"]["gamelist"]["WhackAJackpot50"] = array("Whack-a-Jackpot", "mg/WhackAJackpot.png","");
$gameList["MG"]["gamelist"]["lovebugs"] = array("Love Bugs", "mg/LoveBugs.jpg","");
$gameList["MG"]["gamelist"]["geniewild"] = array("Genie Wild", "mg/GenieWild.png","");
$gameList["MG"]["gamelist"]["tootincarman"] = array("Tootin Car Man", "mg/TootinCarMan.png","");
$gameList["MG"]["gamelist"]["thebermudamysteries"] = array("The Bermuda Mysteries", "mg/TheBermudaMysteries.png","");
$gameList["MG"]["gamelist"]["thesnakecharmer"] = array("Snake Charmer", "mg/TheSnakeCharmer.png","");
$gameList["MG"]["gamelist"]["butterflies"] = array("Butterflies", "mg/Butterflies.png","");
$gameList["MG"]["gamelist"]["bobby7s"] = array("Bobby 7s", "mg/BobbySevens.png","");
$gameList["MG"]["gamelist"]["hotroller"] = array("Hot Roller", "mg/HotRoller.png","");
$gameList["MG"]["gamelist"]["goldahoy"] = array("Gold Ahoy", "mg/GoldAhoy.png","");
$gameList["MG"]["gamelist"]["californiagold"] = array("California Gold", "mg/CaliforniaGold.png","");
$gameList["MG"]["gamelist"]["enchantedmermaid"] = array("Enchanted Mermaid", "mg/EnchantedMermaid.png","");
$gameList["MG"]["gamelist"]["DrMagoo"] = array("Dr Magoo", "mg/DrMagoo.png","");
$gameList["MG"]["gamelist"]["HoneyBuziness"] = array("Honey Buziness", "mg/HoneyBuziness.jpg","");
$gameList["MG"]["gamelist"]["Highlander"] = array("Highlander", "mg/Highlander.jpg","");
$gameList["MG"]["gamelist"]["hollyjollyPenguins"] = array("圣诞企鹅", "mg/HollyJollyPenguins.jpg","");
$gameList["MG"]["gamelist"]["wackyPanda"] = array("囧囧熊猫", "mg/WackyPanda.jpg","");
$gameList["MG"]["gamelist"]["rubyiwbigbreak"] = array("重大突破", "mg/BeginnerBigBreak.png","");
$gameList["MG"]["gamelist"]["Joker8000"] = array("Joker 8000", "mg/Joker8000.png","");
$gameList["MG"]["gamelist"]["BeginnerDeucesWildPwrPoker"] = array("Deuces Wild Power Poker", "mg/DeucesWildPwrPoker.png","");
$gameList["MG"]["gamelist"]["BeginnerEuroRouletteGold"] = array("欧洲杯轮盘", "mg/EuropeanRouletteGoldSeries.png","");
$gameList["MG"]["gamelist"]["BeginnerCosmicCat"] = array("宇宙猫", "mg/BeginnerCosmicCat.png","");
$gameList["MG"]["gamelist"]["3cardpokergold"] = array("3 Card Poker Gold", "mg/3CardPokerGold.png","");
$gameList["MG"]["gamelist"]["KingCashalot"] = array("King Cashalot", "mg/KingCashalot.png","");
$gameList["MG"]["gamelist"]["Tunzamunni"] = array("Tunzamunni", "mg/Tunzamunni.png","");
$gameList["MG"]["gamelist"]["TripleMagic"] = array("Triple Magic", "mg/TripleMagic.png","");
$gameList["MG"]["gamelist"]["rubyiwbillandtedsbj"] = array("Bill and Ted's Bogus Journey", "mg/BillAndTedsBogusJourney.png","");
$gameList["MG"]["gamelist"]["templeofLuxor"] = array("Temple of Luxor", "mg/TempleOfLuxor.png","");
$gameList["MG"]["gamelist"]["laRouge"] = array("La Rouge", "mg/LaRouge.jpg","");
$gameList["MG"]["gamelist"]["epicCity"] = array("Epic City", "mg/EpicCity.png","");
$gameList["MG"]["gamelist"]["mingDynasty"] = array("Ming Dynasty", "mg/MingDynasty.png","");
$gameList["MG"]["gamelist"]["mirrorMagic"] = array("Mirror Magic", "mg/MirrorMagic.png","");
$gameList["MG"]["gamelist"]["lostCityOfIncas"] = array("Lost City Of Incas", "mg/LostCityOfIncas.png","");
$gameList["MG"]["gamelist"]["superWilds"] = array("Superwilds", "mg/SuperWilds.png","");
$gameList["MG"]["gamelist"]["Summertime"] = array("夏令时间", "mg/Summertime_HiDef.png","");
$gameList["MG"]["gamelist"]["snowQueenRiches"] = array("Snow Queen Riches", "mg/SnowQueenRiches.png","");
$gameList["MG"]["gamelist"]["dreamsOfFortune"] = array("Dreams of Fortune", "mg/DreamsofFortune.png","");
$gameList["MG"]["gamelist"]["jasonsquest"] = array("Jason's Quest", "mg/JasonsQuest.png","");
$gameList["MG"]["gamelist"]["giantRiches"] = array("Giant Riches", "mg/GiantRiches.png","");
$gameList["MG"]["gamelist"]["Wolfheart"] = array("Wolfheart", "mg/Wolfheart.png","");
$gameList["MG"]["gamelist"]["eurogoldencup"] = array("Euro Golden Cup", "mg/EuroGoldenCup.jpg","");
$gameList["MG"]["gamelist"]["clashOfQueens"] = array("Clash Of Queens", "mg/ClashOfQueens.png","");
$gameList["MG"]["gamelist"]["jamesWin"] = array("James Win", "mg/JamesWin.png","");
$gameList["MG"]["gamelist"]["bierFest"] = array("Bier Fest", "mg/BierFest.jpg","");
$gameList["MG"]["gamelist"]["CrystalGems"] = array("Crystal Gems", "mg/CrystalGems.png","");





$gameList['PT'] = array();
$gameList['PT']['section'] = array();
$gameList['PT']['section'][] = array('热门游戏', array('bib', 'zcjb', 'ct', 'hlf', 'wlg', 'hk', 'catqk', 'eas', 'ssp', 'whk', 'pmn', 'tpd2', 'ashfmf', 'cnpr', 'irm3', 'shmst', 'pgv', 'gtssmbr'));
$gameList['PT']['section'][] = array('最新游戏', array('ano', 'art', 'fsf', 'hf', 'ir2', 'spm', 'mobbj'));
$gameList['PT']['section'][] = array('老虎机', array('bib', 'zcjb', 'ct', 'hlf', 'wlg', 'hk', 'catqk', 'eas', 'ssp', 'whk', 'pmn', 'tpd2', 'ashfmf', 'cnpr', 'irm3', 'shmst', 'pgv', 'gtssmbr', 'gtspor', 'hlk2', 'fdt', 'gtsmrln', 'fnf50', 'irmn3', 'gtswg', 'chl', 'pst', 'mcb', 'ges', 'gtsir', 'sis', 'gtsfc', 'tmqd', 'xmn50', 'lm', 'fnfrj', 'ashhotj', 'ashcpl', 'glrj', 'dt', 'ashwgaa', 'pnp', 'art', 'dlm', 'bl', 'esmk', 'jpgt', 'jb_mh', 'sol', 'ano', 'fsf', 'hf', 'ir2', 'spm'));
$gameList['PT']['section'][] = array('桌面游戏', array('ba', 'cheaa'));
$gameList['PT']['section'][] = array('视频扑克', array('jb_mh'));
$gameList['PT']['gamelist'] = array();

$gameList["PT"]["gamelist"]["kfp"] = array("六福兽", "pt/Liu_Fu_Shou_PSD_Source.png","");
$gameList["PT"]["gamelist"]["ftg"] = array("五虎将", "pt/5TigerGenerals_SourceFile.png","");
$gameList["PT"]["gamelist"]["wlcsh"] = array("五路财神", "pt/WuLuCaiShen_SourceFile.png","");
$gameList["PT"]["gamelist"]["spud"] = array("黄金农场", "pt/spud-o-reilly_source_file.png","");
$gameList["PT"]["gamelist"]["aogs"] = array("众神时代", "pt/AOG_source_file.png","");
$gameList["PT"]["gamelist"]["furf"] = array("神的时代：雷霆4神", "pt/Furious_4_source_file.png","");
$gameList["PT"]["gamelist"]["fm"] = array("古怪猴子", "pt/funky_monkey.jpg","");
$gameList["PT"]["gamelist"]["hk"] = array("高速公路之王", "pt/highway_kings.jpg","");
$gameList["PT"]["gamelist"]["gos"] = array("黄金之旅", "pt/golden_tour.jpg","");
$gameList["PT"]["gamelist"]["bib"] = array("湛蓝深海", "pt/great_blue.jpg","");
$gameList["PT"]["gamelist"]["bob"] = array("熊之舞", "pt/BonusBear_191x181.png","");
$gameList["PT"]["gamelist"]["ct"] = array("船长的宝藏", "pt/captain_treasure.jpg","");
$gameList["PT"]["gamelist"]["c7"] = array("疯狂之七", "pt/crazy7.jpg","");
$gameList["PT"]["gamelist"]["cm"] = array("中国厨房", "pt/china_kitchen.jpg","");
$gameList["PT"]["gamelist"]["hlf"] = array("万圣节财富", "pt/halloween_treasure.jpg","");
$gameList["PT"]["gamelist"]["er"] = array("开心假期", "pt/vacation_station.jpg","");
$gameList["PT"]["gamelist"]["ssp"] = array("圣诞惊喜", "pt/santa_surprise.jpg","");
$gameList["PT"]["gamelist"]["sfh"] = array("非洲炙热", "pt/SafariHeat_191x181.png","");
$gameList["PT"]["gamelist"]["cnpr"] = array("甜蜜派对", "pt/sweet_party.jpg","");
$gameList["PT"]["gamelist"]["eas"] = array("惊喜复活节", "pt/easter_surprise.jpg","");
$gameList["PT"]["gamelist"]["irm3"] = array("钢铁人2", "pt/iron_man2.jpg","");
$gameList["PT"]["gamelist"]["sib"] = array("银子弹", "pt/silver_bullet.jpg","");
$gameList["PT"]["gamelist"]["ges"] = array("艺伎故事", "pt/Geisha_Story_Jackpot_191X181.png","");
$gameList["PT"]["gamelist"]["fnfrj"] = array("趣味水果", "pt/funky_fruit.jpg","");
$gameList["PT"]["gamelist"]["gts50"] = array("热力宝石", "pt/HotGems_191X181.png","");
$gameList["PT"]["gamelist"]["hb"] = array("一夜奇遇", "pt/night_out.jpg","");
$gameList["PT"]["gamelist"]["ashwgaa"] = array("赌徒:北极探险", "pt/WildGambler_191x181.png","");
$gameList["PT"]["gamelist"]["bld"] = array("Blade", "pt/Blade.jpg","");
$gameList["PT"]["gamelist"]["catqk"] = array("猫女王", "pt/cat_queen.jpg","");
$gameList["PT"]["gamelist"]["hlk2"] = array("绿巨人", "pt/hulk.jpg","");
$gameList["PT"]["gamelist"]["sx"] = array("四象", "pt/SiXiang_SOURCE_216x183.png","");
$gameList["PT"]["gamelist"]["mgstk"] = array("Magical Stacks", "pt/MagicalStacks_216x183.png","");
$gameList["PT"]["gamelist"]["fcgz"] = array("翡翠公主", "pt/FeiCui_191x181.png","");
$gameList["PT"]["gamelist"]["spidc"] = array("蜘蛛侠", "pt/spider_man.jpg","");
$gameList["PT"]["gamelist"]["hh"] = array("鬼屋", "pt/Haunted House_191X181.png","");
$gameList["PT"]["gamelist"]["whk"] = array("白狮王", "pt/white_king.jpg","");
$gameList["PT"]["gamelist"]["bs"] = array("白狮", "pt/BaiShi_216x183.png","");
$gameList["PT"]["gamelist"]["sis"] = array("沉默的武士", "pt/Silent Samurai_191x181.png","");
$gameList["PT"]["gamelist"]["dt"] = array("沙漠宝藏", "pt/Desert-Tressure-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["gtsflzt"] = array("飞龙在天", "pt/Fei Long Zai Tian_191x181.png","");
$gameList["PT"]["gamelist"]["gtswg"] = array("赌徒", "pt/wild_gambler.jpg","");
$gameList["PT"]["gamelist"]["tpd2"] = array("泰国天堂", "pt/Thai Paradise_191x181.png","");
$gameList["PT"]["gamelist"]["bt"] = array("百慕大三角", "pt/bermuda_triangle.jpg","");
$gameList["PT"]["gamelist"]["ashfmf"] = array("满月的财富", "pt/fullmoon_fortunes.jpg","");
$gameList["PT"]["gamelist"]["fnf"] = array("神奇四侠", "pt/super4.jpg","");
$gameList["PT"]["gamelist"]["fxf"] = array("诙谐财富", "pt/foxy_fortunes.jpg","");
$gameList["PT"]["gamelist"]["fnf50"] = array("神奇四侠50条线", "pt/fantastic_four.jpg","");
$gameList["PT"]["gamelist"]["spidc2"] = array("蜘蛛侠：绿妖精的攻击", "pt/spider_man2.jpg","");
$gameList["PT"]["gamelist"]["pst"] = array("法老王的秘密", "pt/pharaoh_secrets.jpg","");
$gameList["PT"]["gamelist"]["mcb"] = array("Cash back先生", "pt/cash_back.jpg","");
$gameList["PT"]["gamelist"]["ctp2"] = array("超级船长的宝藏", "pt/caribbean_stud.jpg","");
$gameList["PT"]["gamelist"]["irmn3"] = array("钢铁人3", "pt/iron_man3.jpg","");
$gameList["PT"]["gamelist"]["samz"] = array("亚马逊的秘密", "pt/secrets_of_the_amazon.jpg","");
$gameList["PT"]["gamelist"]["gtsatq"] = array("亚特兰蒂斯女王", "pt/atlantis_queen.jpg","");
$gameList["PT"]["gamelist"]["dt2"] = array("沙漠宝藏2", "pt/desert2.jpg","");
$gameList["PT"]["gamelist"]["elr"] = array("艾丽卡", "pt/elektra.jpg","");
$gameList["PT"]["gamelist"]["fdtjg"] = array("戴图理的神奇七大奖", "pt/frankie_dettori_magic_seven_jackpot.jpg","");
$gameList["PT"]["gamelist"]["cam"] = array("美国队长", "pt/captain_america.jpg","");
$gameList["PT"]["gamelist"]["irl"] = array("爱尔兰运气", "pt/irish_luck.jpg","");
$gameList["PT"]["gamelist"]["fdt"] = array("戴图理的神奇七", "pt/Frankies-Fantastic-7.jpg","");
$gameList["PT"]["gamelist"]["lm"] = array("疯狂乐透", "pt/lotto_madness.jpg","");
$gameList["PT"]["gamelist"]["zcjb"] = array("招财进宝", "pt/Zhao Cai Jin Bao_216x183.png","");
$gameList["PT"]["gamelist"]["arc"] = array("弓兵", "pt/archer.jpg","");
$gameList["PT"]["gamelist"]["glrj"] = array("角斗士彩池游戏", "pt/gladiator_jackpot.jpg","");
$gameList["PT"]["gamelist"]["glr"] = array("角斗士", "pt/gladiatores.jpg","");
$gameList["PT"]["gamelist"]["8bs"] = array("8球老虎机", "pt/8balls.jpg","");
$gameList["PT"]["gamelist"]["dlm"] = array("情圣博士", "pt/dr_lovemone.jpg","");
$gameList["PT"]["gamelist"]["fow"] = array("惊异之林", "pt/forest_wonders.jpg","");
$gameList["PT"]["gamelist"]["scs"] = array("经典老虎机刮刮乐", "pt/classic_slot.jpg","");
$gameList["PT"]["gamelist"]["sf"] = array("苏丹财富", "pt/sultans_fortune.jpg","");
$gameList["PT"]["gamelist"]["ssl"] = array("转轴经典3", "pt/reel_classic3.jpg","");
$gameList["PT"]["gamelist"]["gtscnb"] = array("警察与土匪", "pt/Cops-N-Bandits.jpg","");
$gameList["PT"]["gamelist"]["irm50"] = array("钢铁人2 50线", "pt/50_iron_man2.jpg","");
$gameList["PT"]["gamelist"]["zctz"] = array("招财童子", "pt/ZhaoCaiTongZi_SOURCE_216x183.png","");
$gameList["PT"]["gamelist"]["gtsswk"] = array("孙悟空", "pt/SunWuKong_SourceFile_216x183.png","");
$gameList["PT"]["gamelist"]["ashvrtd"] = array("虚拟赛狗", "pt/Virtual Dogs_216x183.png","");
$gameList["PT"]["gamelist"]["ashlob"] = array("Monty Python´s Life of Brian", "pt/Sourcefile_216x183.png","");
$gameList["PT"]["gamelist"]["topg"] = array("Top Gun", "pt/TopGun_MarketingKit_216x183.png","");
$gameList["PT"]["gamelist"]["ttc"] = array("顶级王牌-明星", "pt/top_trumps.jpg","");
$gameList["PT"]["gamelist"]["pl"] = array("舞线", "pt/party_line.jpg","");
$gameList["PT"]["gamelist"]["gtspor"] = array("非常幸运", "pt/final_fortune.jpg","");
$gameList["PT"]["gamelist"]["gtshwkp"] = array("超级高速公路之王", "pt/highway_kings2.jpg","");
$gameList["PT"]["gamelist"]["gts51"] = array("幸运熊猫", "pt/lucky_panda.jpg","");
$gameList["PT"]["gamelist"]["shmst"] = array("夏洛克的秘密", "pt/sherlock_mystery.jpg","");
$gameList["PT"]["gamelist"]["gtssmbr"] = array("激情桑巴", "pt/brazil_samba.jpg","");
$gameList["PT"]["gamelist"]["gtsmrln"] = array("玛丽莲·梦露", "pt/marilyn_monroe.jpg","");
$gameList["PT"]["gamelist"]["nk"] = array("海星王国", "pt/neptunes_kingdom.jpg","");
$gameList["PT"]["gamelist"]["jb"] = array("丛林摇摆", "pt/jungle_boogie.jpg","");
$gameList["PT"]["gamelist"]["hlk50"] = array("绿巨人50条线", "pt/hulk_solines.jpg","");
$gameList["PT"]["gamelist"]["fff"] = array("酷炫水果农场", "pt/crazy_fruit_farm.jpg","");
$gameList["PT"]["gamelist"]["xmn"] = array("x战警", "pt/x_men.jpg","");
$gameList["PT"]["gamelist"]["glg"] = array("黄金版游戏", "pt/golden_games.jpg","");
$gameList["PT"]["gamelist"]["avng"] = array("复仇者联盟", "pt/avengers.jpg","");
$gameList["PT"]["gamelist"]["essc"] = array("惊喜复活节刮刮乐", "pt/easter_surprise.jpg","");
$gameList["PT"]["gamelist"]["irm2"] = array("钢铁人", "pt/iron_man.jpg","");
$gameList["PT"]["gamelist"]["fbr"] = array("终极足球", "pt/football_rules.jpg","");
$gameList["PT"]["gamelist"]["chl"] = array("樱桃之恋", "pt/cherry_love.jpg","");
$gameList["PT"]["gamelist"]["gtsru"] = array("财富魔方", "pt/rubik_riches.jpg","");
$gameList["PT"]["gamelist"]["trm"] = array("强大的复仇者雷神", "pt/great_revenger.jpg","");
$gameList["PT"]["gamelist"]["gtsdrdv"] = array("大胆的戴夫和荷鲁斯之眼", "pt/daring_dave_and_eye_of_ra.jpg","");
$gameList["PT"]["gamelist"]["ashbob"] = array("Bounty of the Beanstalk", "pt/bounty_of_the_beanstalk.jpg","");
$gameList["PT"]["gamelist"]["paw"] = array("小猪与狼", "pt/piggle_wolf.jpg","");
$gameList["PT"]["gamelist"]["wis"] = array("我心狂野", "pt/Wild-Spirit.jpg","");
$gameList["PT"]["gamelist"]["xmn50"] = array("X战警50条线", "pt/x_men.jpg","");
$gameList["PT"]["gamelist"]["tmqd"] = array("三剑客和女王", "pt/three_musketeers_and_the_queen.jpg","");
$gameList["PT"]["gamelist"]["rnr"] = array("摇摆舞", "pt/Rock-n-Roller.jpg","");
$gameList["PT"]["gamelist"]["rng2"] = array("罗马与荣耀", "pt/Rome-and-Glory-401x216-game-icon.jpg","");
$gameList["PT"]["gamelist"]["ghr"] = array("恶灵骑士", "pt/ghost_rider.jpg","");
$gameList["PT"]["gamelist"]["gtsfc"] = array("足球狂欢节", "pt/football_carnival.jpg","");
$gameList["PT"]["gamelist"]["foy"] = array("青春之泉", "pt/fountain_of_youth.jpg","");
$gameList["PT"]["gamelist"]["pnp"] = array("粉红豹", "pt/pink_panthe.jpg","");
$gameList["PT"]["gamelist"]["rky"] = array("洛基传奇", "pt/rocky.jpg","");
$gameList["PT"]["gamelist"]["lwh"] = array("轮盘旋转赌博游戏", "pt/Spin-A-Win.jpg","");
$gameList["PT"]["gamelist"]["ttcsc"] = array("顶级王牌-明星", "pt/top_trumps.jpg","");
$gameList["PT"]["gamelist"]["ta"] = array("三个朋友", "pt/amigos.jpg","");
$gameList["PT"]["gamelist"]["trl"] = array("真爱", "pt/true_love.jpg","");
$gameList["PT"]["gamelist"]["iceh"] = array("冰球游戏", "pt/ice_hockey.jpg","");
$gameList["PT"]["gamelist"]["drd"] = array("夜魔侠", "pt/back_home.jpg","");
$gameList["PT"]["gamelist"]["lom"] = array("爱情配对", "pt/love_match.jpg","");
$gameList["PT"]["gamelist"]["kkgsc"] = array("金刚刮刮乐", "pt/king_kong.jpg","");
$gameList["PT"]["gamelist"]["ssa"] = array("圣诞刮刮乐", "pt/santa_scratch.jpg","");
$gameList["PT"]["gamelist"]["gtsdgk"] = array("龙之王国", "pt/dragon_kingdom.jpg","");
$gameList["PT"]["gamelist"]["bld50"] = array("Blade 50 Lines", "pt/Blade-50-Lines.jpg","");
$gameList["PT"]["gamelist"]["tst"] = array("网球明星", "pt/tennis_star.jpg","");
$gameList["PT"]["gamelist"]["skp"] = array("Skazka Pro", "pt/Skazka-Pro.jpg","");
$gameList["PT"]["gamelist"]["gtswng"] = array("黄金翅膀", "pt/Wings-of-Gold.jpg","");
$gameList["PT"]["gamelist"]["ttl"] = array("顶级王牌-传奇", "pt/top_trumps_football_legends.jpg","");
$gameList["PT"]["gamelist"]["snsb"] = array("Sunset Beach", "pt/sunset_beach.jpg","");
$gameList["PT"]["gamelist"]["wvm"] = array("金刚狼", "pt/king_kong.jpg","");
$gameList["PT"]["gamelist"]["gtsstg"] = array("苏丹的财富", "pt/sultans_gold.jpg","");
$gameList["PT"]["gamelist"]["gtsbtg"] = array("诸神之战", "pt/battle_of_gods.jpg","");
$gameList["PT"]["gamelist"]["fth"] = array("财富山", "pt/fortune_hill.jpg","");
$gameList["PT"]["gamelist"]["fbm"] = array("狂热足球", "pt/football_mania.jpg","");
$gameList["PT"]["gamelist"]["al"] = array("炼金术师实验室", "pt/alchemist_lab.jpg","");
$gameList["PT"]["gamelist"]["op"] = array("海洋公主", "pt/ocean.jpg","");
$gameList["PT"]["gamelist"]["ub"] = array("丛林巫师", "pt/Ugga-Bugga.jpg","");
$gameList["PT"]["gamelist"]["wan"] = array("通缉令：不论死活", "pt/wanted.jpg","");
$gameList["PT"]["gamelist"]["gts52"] = array("疯狂维京海盗", "pt/Vikingmania.jpg","");
$gameList["PT"]["gamelist"]["gtsjhw"] = array("约翰·韦恩", "pt/john_wayne.jpg","");
$gameList["PT"]["gamelist"]["ah2"] = array("异形猎手", "pt/alien_hunter.jpg","");
$gameList["PT"]["gamelist"]["gtscirsj"] = array("加农炮队长的欢乐马戏团", "pt/captain_cannon_circus_of_cash.jpg","");
$gameList["PT"]["gamelist"]["cifr"] = array("全景电影", "pt/cinerama.jpg","");
$gameList["PT"]["gamelist"]["gtsaod"] = array("无罪或诱惑", "pt/angel_devil.jpg","");
$gameList["PT"]["gamelist"]["tfs"] = array("顶级王牌-全星", "pt/world_football.jpg","");
$gameList["PT"]["gamelist"]["gtslgms"] = array("野生游戏", "pt/crazy_games.jpg","");
$gameList["PT"]["gamelist"]["pks"] = array("法老王国刮刮乐", "pt/pharaoh_kingdom.jpg","");
$gameList["PT"]["gamelist"]["ashbgt"] = array("英国达人秀", "pt/britain_got_talent.jpg","");
$gameList["PT"]["gamelist"]["lvb"] = array("爱之舟", "pt/love_boat.jpg","");
$gameList["PT"]["gamelist"]["irmn3sc"] = array("钢铁人3刮刮乐", "pt/3line_iron_man3.jpg","");
$gameList["PT"]["gamelist"]["gc"] = array("地妖之穴", "pt/goblins_cave.jpg","");
$gameList["PT"]["gamelist"]["gtsgoc"] = array("圣诞节幽灵", "pt/ghosts_christmas.jpg","");
$gameList["PT"]["gamelist"]["ts"] = array("时空过客", "pt/excitement.jpg","");
$gameList["PT"]["gamelist"]["tp"] = array("三倍利润", "pt/triple_profits.jpg","");
$gameList["PT"]["gamelist"]["bbn"] = array("甲虫宾果", "pt/Beetle-Bingo-Scratch.jpg","");
$gameList["PT"]["gamelist"]["sbj"] = array("21点刮刮乐", "pt/blackjack_scratch.jpg","");
$gameList["PT"]["gamelist"]["gtsftf"] = array("足球迷", "pt/fans.jpg","");
$gameList["PT"]["gamelist"]["sro"] = array("轮盘赌刮刮乐", "pt/roulette_card.jpg","");
$gameList["PT"]["gamelist"]["tr"] = array("热带卷轴", "pt/tropic_reels.jpg","");
$gameList["PT"]["gamelist"]["gtsjzc"] = array("爵士俱乐部", "pt/jazz_club.jpg","");
$gameList["PT"]["gamelist"]["ba"] = array("百家乐", "pt/baccarat_pt.jpg","");
$gameList["PT"]["gamelist"]["cheaa"] = array("赌场HOLD'EM游戏", "pt/casino_holdem.jpg","");
$gameList["PT"]["gamelist"]["pso"] = array("罚点球游戏", "pt/goal.jpg","");
$gameList["PT"]["gamelist"]["kn"] = array("基诺", "pt/keno.jpg","");
$gameList["PT"]["gamelist"]["gtssmdm"] = array("无敌金刚", "pt/six_million_dollar_man.jpg","");
$gameList["PT"]["gamelist"]["po"] = array("对J高手", "pt/jacks_or_better_pt.jpg","");
$gameList["PT"]["gamelist"]["tob"] = array("对10高手", "pt/10s_better.jpg","");
$gameList["PT"]["gamelist"]["mmy"] = array("木乃伊迷城", "pt/mummy.jpg","");
$gameList["PT"]["gamelist"]["cr"] = array("双色骰子游戏", "pt/craps.jpg","");
$gameList["PT"]["gamelist"]["car"] = array("加勒比海梭哈扑克", "pt/caribbean_stud_poker.jpg","");
$gameList["PT"]["gamelist"]["jb4"] = array("4线对J高手", "pt/4line_jack_or_better.jpg","");
$gameList["PT"]["gamelist"]["ro_g"] = array("欧式奖金轮盘赌", "pt/rou_premium_european.jpg","");
$gameList["PT"]["gamelist"]["dw"] = array("2点百搭牌", "pt/deluces_wiki.jpg","");
$gameList["PT"]["gamelist"]["rcd"] = array("掷骰子赌博游戏", "pt/roller_coaster.jpg","");
$gameList["PT"]["gamelist"]["dw4"] = array("4线白塔2", "pt/4-Line-Deuces-Wild.jpg","");
$gameList["PT"]["gamelist"]["pbj"] = array("累积二十一点", "pt/bj_pt.jpg","");
$gameList["PT"]["gamelist"]["pbro"] = array("弹球轮盘", "pt/pinball_roulette.jpg","");
$gameList["PT"]["gamelist"]["sb"] = array("骰宝", "pt/Sic-Bo.jpg","");
$gameList["PT"]["gamelist"]["hljb"] = array("两种皇家同花顺", "pt/two_ways_loyal.jpg","");
$gameList["PT"]["gamelist"]["ghl"] = array("猜扑克牌游戏", "pt/wild_elf.jpg","");
$gameList["PT"]["gamelist"]["rps"] = array("石头、剪刀、纸游戏", "pt/Rock-Paper-Scissors.jpg","");
$gameList["PT"]["gamelist"]["pop"] = array("宾果", "pt/pop_bingo.jpg","");
$gameList["PT"]["gamelist"]["rom"] = array("奇迹轮盘", "pt/marvel_roulette.jpg","");
$gameList["PT"]["gamelist"]["psdbj"] = array("超级21点", "pt/bj_pro.jpg","");
$gameList["PT"]["gamelist"]["af"] = array("A及花牌", "pt/Aces-And-Faces.jpg","");
$gameList["PT"]["gamelist"]["rop_g"] = array("奖金轮盘赌专家", "pt/rou_premium_american.jpg","");
$gameList["PT"]["gamelist"]["kf"] = array("财富基诺", "pt/keno_treasure.jpg","");
$gameList["PT"]["gamelist"]["bja"] = array("美式21点", "pt/american_bj.jpg","");
$gameList["PT"]["gamelist"]["af4"] = array("4线A及花牌", "pt/4-Line-Aces-And-Faces.jpg","");
$gameList["PT"]["gamelist"]["bowl"] = array("保龄猜球游戏", "pt/Bonus-Bowling.jpg","");
$gameList["PT"]["gamelist"]["amvp"] = array("Alll American Video Poker", "pt/All-American-Video-Poker.jpg","");
$gameList["PT"]["gamelist"]["rd"] = array("红狗", "pt/red_dog_pt.jpg","");
$gameList["PT"]["gamelist"]["ro3d"] = array("3D轮盘", "pt/3d_roulette.jpg","");
$gameList["PT"]["gamelist"]["bls"] = array("百万幸运球", "pt/megaball.jpg","");
$gameList["PT"]["gamelist"]["bj_mh5"] = array("21点", "pt/blackjack.jpg","");
$gameList["PT"]["gamelist"]["hr"] = array("打比日", "pt/horse_racing.jpg","");
$gameList["PT"]["gamelist"]["str"] = array("异乎寻常", "pt/Stravaganza.jpg","");
$gameList["PT"]["gamelist"]["jb10p"] = array("10线对J高手", "pt/10line_jack_or_better.jpg","");
$gameList["PT"]["gamelist"]["bj21d_mh"] = array("决胜21点2", "pt/aces_faces.jpg","");
$gameList["PT"]["gamelist"]["qbd"] = array("飞镖", "pt/darts.jpg","");
$gameList["PT"]["gamelist"]["atw"] = array("周游列国", "pt/around_the_world.jpg","");
$gameList["PT"]["gamelist"]["jb50"] = array("50线对J高手", "pt/50line_jack_or_better.jpg","");
$gameList["PT"]["gamelist"]["gtsro3d"] = array("3D奖金轮盘赌", "pt/3d_roulette_premium.jpg","");
$gameList["PT"]["gamelist"]["pg"] = array("牌九扑克", "pt/Pai-Gow.jpg","");
$gameList["PT"]["gamelist"]["pep"] = array("全揽扑克", "pt/pick_em_poker.jpg","");
$gameList["PT"]["gamelist"]["dctw"] = array("转骰子游戏", "pt/sicbo.jpg","");
$gameList["PT"]["gamelist"]["fsc"] = array("最终成绩", "pt/final_score.jpg","");
$gameList["PT"]["gamelist"]["p6dbj_mh5"] = array("Blackjack Peek Multihand 5", "pt/blackjack_peek_multihand_5.jpg","");
$gameList["PT"]["gamelist"]["s21"] = array("超级21点", "pt/bj_super21.jpg","");
$gameList["PT"]["gamelist"]["tps"] = array("戴图理神奇7", "pt/Frankies-Fantastic-7.jpg","");
$gameList["PT"]["gamelist"]["af25"] = array("25线A及花牌", "pt/Aces-And-Faces.jpg","");
$gameList["PT"]["gamelist"]["rodz_g"] = array("美式奖金轮盘赌", "pt/rou_premium_american.jpg","");
$gameList["PT"]["gamelist"]["rouk"] = array("俱乐部轮盘赌", "pt/club_roulette.jpg","");
$gameList["PT"]["gamelist"]["rop"] = array("超级轮盘", "pt/roulette_pro.jpg","");
$gameList["PT"]["gamelist"]["tqp"] = array("龙舌兰扑克", "pt/Tequila-Poker.jpg","");
$gameList["PT"]["gamelist"]["frr"] = array("法式轮盘", "pt/french_roulette_2.jpg","");
$gameList["PT"]["gamelist"]["frr_g"] = array("法式奖金轮盘赌", "pt/rou_premium_pro.jpg","");
$gameList["PT"]["gamelist"]["romw"] = array("多轮轮盘", "pt/mul_wheel_roulette.jpg","");
$gameList["PT"]["gamelist"]["pyrrk"] = array("拉美西斯的金字塔", "pt/pyramid_of_ramesses.jpg","");
$gameList["PT"]["gamelist"]["gtscbl"] = array("牛仔和外星人", "pt/cowboy_alien.jpg","");
$gameList["PT"]["gamelist"]["ash3brg"] = array("3卡吹嘘", "pt/three_card_brag.jpg","");
$gameList["PT"]["gamelist"]["ashamw"] = array("Amazon Wild", "pt/amazon_wild.jpg","");
$gameList["PT"]["gamelist"]["gtsbayw"] = array("挑战", "pt/baywatch.jpg","");
$gameList["PT"]["gamelist"]["head"] = array("硬币投掷赌博游戏", "pt/heads_tails.jpg","");
$gameList["PT"]["gamelist"]["bjs"] = array("换牌21点", "pt/bj_switch.jpg","");
$gameList["PT"]["gamelist"]["gs"] = array("钻石谷", "pt/diamond_valley.jpg","");
$gameList["PT"]["gamelist"]["wlg"] = array("舞龙", "pt/dragon_dance.jpg","");
$gameList["PT"]["gamelist"]["esmk"] = array("埃斯梅拉达", "pt/esmeralda.jpg","");
$gameList["PT"]["gamelist"]["evj"] = array("所有人的大奖", "pt/everyone_jackpot.jpg","");
$gameList["PT"]["gamelist"]["jpgt"] = array("奖金巨人", "pt/jackpot_giant.jpg","");
$gameList["PT"]["gamelist"]["jb_mh"] = array("多手对J高手", "pt/jacks_better_multihand.jpg","");
$gameList["PT"]["gamelist"]["mj"] = array("超级杰克", "pt/megajacks.jpg","");
$gameList["PT"]["gamelist"]["qop"] = array("金字塔女王", "pt/queen_of_pyramids.jpg","");
$gameList["PT"]["gamelist"]["sc"] = array("保险箱探宝", "pt/safecracker.jpg","");
$gameList["PT"]["gamelist"]["sol"] = array("好运连胜", "pt/streak_of_luck.jpg","");
$gameList["PT"]["gamelist"]["gtssprs"] = array("黑道家族", "pt/the_sopranos.jpg","");
$gameList["PT"]["gamelist"]["wsffr"] = array("玩转华尔街", "pt/wall_street_fever.jpg","");
$gameList["PT"]["gamelist"]["tclsc"] = array("三个小丑刮刮乐", "pt/3-Clowns-Scratch.jpg","");
$gameList["PT"]["gamelist"]["rodz"] = array("美式轮盘", "pt/america_roulette.jpg","");
$gameList["PT"]["gamelist"]["p6dbj"] = array("Blackjack Peek", "pt/Blackjack-Peek.jpg","");
$gameList["PT"]["gamelist"]["ro"] = array("欧式轮盘", "pt/European-Roulette.jpg","");
$gameList["PT"]["gamelist"]["gts5"] = array("视频轮盘", "pt/video_roulette.jpg","");
$gameList["PT"]["gamelist"]["jp"] = array("王牌扑克", "pt/poker_poker.jpg","");
$gameList["PT"]["gamelist"]["jp50"] = array("50线王牌扑克", "pt/poker_poker.jpg","");
$gameList["PT"]["gamelist"]["drts"] = array("飞镖投掷赌博游戏", "pt/darts.jpg","");
$gameList["PT"]["gamelist"]["gtsavgsc"] = array("复仇者刮刮乐", "pt/The-Avengers-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["gtsbwsc"] = array("海滩游侠刮刮乐", "pt/Baywatch-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["bl"] = array("海滨嘉年华", "pt/Beach-Life.jpg","");
$gameList["PT"]["gamelist"]["gts40"] = array("刀锋战士刮刮乐", "pt/Blade-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["gtscnasc"] = array("美国队长刮刮乐", "pt/Captain-America-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["gtsdrdsc"] = array("夜魔侠刮刮乐", "pt/Daredevil-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["gtsdnc"] = array("现金海豚", "pt/Dolphin-Cash.jpg","");
$gameList["PT"]["gamelist"]["gts48"] = array("现金海豚刮刮乐", "pt/Dolphin-Cash.jpg","");
$gameList["PT"]["gamelist"]["gts41"] = array("神奇四侠刮刮乐", "pt/Fantastic-4-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["ghlj"] = array("猜扑克牌彩池游戏", "pt/Genie's-Hi-Lo-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["gtsghrsc"] = array("恶灵骑士刮刮乐", "pt/Ghost-Rider-PSD-source-file.jpg","");
$gameList["PT"]["gamelist"]["gts37"] = array("角斗士刮刮乐", "pt/Gladiator-PSD-source-file.jpg","");
$gameList["PT"]["gamelist"]["gts46"] = array("生命之神", "pt/Goddess-Of-Life.jpg","");
$gameList["PT"]["gamelist"]["grel"] = array("金色召集", "pt/Gold-Rally.jpg","");
$gameList["PT"]["gamelist"]["ashhotj"] = array("丛林心脏", "pt/Heart-of-The-Jungle-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["hsd"] = array("摊牌扑克", "pt/holdem_showdown.jpg","");
$gameList["PT"]["gamelist"]["irm3sc"] = array("钢铁侠人2刮刮乐", "pt/Iron-Man-PSD-poster-2-high-quality.jpg","");
$gameList["PT"]["gamelist"]["kgdb"] = array("德比王", "pt/Derby-Day-PSD-source-1.jpg","");
$gameList["PT"]["gamelist"]["mro"] = array("迷你轮盘赌", "pt/Mini-Roulette.jpg","");
$gameList["PT"]["gamelist"]["pmn"] = array("黑豹之月", "pt/Panther_moon_source_file.jpg","");
$gameList["PT"]["gamelist"]["gtspwzsc"] = array("战争特区刮刮乐", "pt/Punisher.jpg","");
$gameList["PT"]["gamelist"]["gtsrkysc"] = array("洛基传奇刮刮乐", "pt/Rocky-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["gtsrng"] = array("罗马与荣耀", "pt/Rome-and-Glory-401x216-game-icon.jpg","");
$gameList["PT"]["gamelist"]["gtsspdsc"] = array("蜘蛛侠刮刮乐", "pt/Spiderman-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["gtshlksc"] = array("绿巨人刮刮乐", "pt/The-Incredible-Hulk-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["nian_k"] = array("年年有余", "pt/Nian-Nian-You-Yu_source_file.jpg","");
$gameList["PT"]["gamelist"]["gts42"] = array("粉红豹刮刮乐", "pt/Pink-Panther-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["gtsfj"] = array("跃龙门", "pt/Fortune_Jump.jpg","");
$gameList["PT"]["gamelist"]["ctiv"] = array("拉斯维加斯的猫", "pt/Cat-In-Vegas-694x240-horizontal-banner-transparent.jpg","");
$gameList["PT"]["gamelist"]["tglalcs"] = array("炼金术士的法术", "pt/Alchemists-Spell-401x216-game-icon.jpg","");
$gameList["PT"]["gamelist"]["ashcpl"] = array("宝物箱中寻", "pt/Chests-of-Plenty-401x216-game-icon.jpg","");
$gameList["PT"]["gamelist"]["ashsbd"] = array("辛巴达的金色航程", "pt/Sinbad-401x216-game-icon.jpg","");
$gameList["PT"]["gamelist"]["mjl_d"] = array("超级杰克", "pt/Megajacks-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["gtsgme"] = array("大明帝国", "pt/Great_Ming_Single_PSD.jpg","");
$gameList["PT"]["gamelist"]["ashfta"] = array("Fairest of them All", "pt/Fairest_of_them_all_source_file.jpg","");
$gameList["PT"]["gamelist"]["pon_mh5"] = array("英式21点", "pt/Blackjack-Pontoon-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["bjsd_mh5"] = array("Blackjack Surrender Multihand 5", "pt/Blackjack-Surrender-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["gts47"] = array("Lotto Madness Scratch", "pt/Lotto-Madness-PSD-source.jpg","");
$gameList["PT"]["gamelist"]["gesjp"] = array("艺妓故事彩池游戏", "pt/Geisha-Story-Jackpot-Game_Icon.jpg","");
$gameList["PT"]["gamelist"]["jqw"] = array("金钱蛙", "pt/JinQianWa_SourceFil.jpg","");
$gameList["PT"]["gamelist"]["qnw"] = array("权杖皇后", "pt/Queen-of-Wands-Source-File.jpg","");
$gameList["PT"]["gamelist"]["gts39"] = array("一夜奇遇刮刮乐", "pt/A_Night_Out_138x125.png","");
$gameList["PT"]["gamelist"]["gtscb"] = array("现金魔块", "pt/Cash_Blox_138x125.png","");
$gameList["PT"]["gamelist"]["dnr"] = array("海豚礁", "pt/Dolphin_Reef_138x125.png","");
$gameList["PT"]["gamelist"]["gts44"] = array("艾丽卡刮刮乐", "pt/Elektra_138x125.png","");
$gameList["PT"]["gamelist"]["ms"] = array("魔幻吃角子老虎", "pt/Magic_slots.png","");
$gameList["PT"]["gamelist"]["gtsjxb"] = array("吉祥8", "pt/Ji_Xiang.png","");
$gameList["PT"]["gamelist"]["sisjp"] = array("沉默的武士彩池游戏", "pt/Silent_Samurai_Jackpot_138x125.png","");
$gameList["PT"]["gamelist"]["athn"] = array("神的时代：智慧女神", "pt/Age_of_the_Gods_Goddess_of_Wisdom_Athena_138x125.png","");
$gameList["PT"]["gamelist"]["chao"] = array("超级888", "pt/Chaoji_888_138x125.png","");
$gameList["PT"]["gamelist"]["gemq"] = array("宝石女王", "pt/Gem_Queen_138x125.png","");
$gameList["PT"]["gamelist"]["aztec"] = array("印加帝国头奖", "pt/Inca_JackPot_138x125.png","");
$gameList["PT"]["gamelist"]["longlong"] = array("龙龙龙", "pt/long_long_long.png","");
$gameList["PT"]["gamelist"]["bfb"] = array("水牛闪电", "pt/buffalo_blitz_138x125.png","");
$gameList["PT"]["gamelist"]["zeus"] = array("Age of the Gods : King of Olympus", "pt/Age_of_the_Gods_King_of_Olympus_138x125.png","");
$gameList["PT"]["gamelist"]["hrcls"] = array("Age of the Gods: Prince of Olympus", "pt/Age_of_the_Gods_Prince_of_Olympus_138x125.png","");
$gameList["PT"]["gamelist"]["gtsir"] = array("浮冰流", "pt/ice_run.png","");
$gameList["PT"]["gamelist"]["prol"] = array("Penny Roulette", "pt/Penny_Roulette_138x125.png","");
$gameList["PT"]["gamelist"]["aogro"] = array("Age of the Gods Roulette", "pt/Age_of_the_Gods_roulette_sourcefile_138x125.png","");
$gameList["PT"]["gamelist"]["ririjc"] = array("日日进财", "pt/RiRiJinCai_138x125.png","");
$gameList["PT"]["gamelist"]["fkmj"] = array("疯狂麻将", "pt/Feng_Kuang_Ma_Jiang_138x125.png","");
$gameList["PT"]["gamelist"]["gtsfpc"] = array("魚蝦蟹", "pt/Fish_Prawn_Crab_138x125.png","");
$gameList["PT"]["gamelist"]["hlf2"] = array("Halloween Fortune II", "pt/Halloween Fortune_138x125.png","");
$gameList["PT"]["gamelist"]["mfrt"] = array("Miss Fortune", "pt/MissFortune.png","");
$gameList["PT"]["gamelist"]["ririshc"] = array("日日生財", "pt/Ri_Ri_Sheng_Cai_138x125.png","");
$gameList["PT"]["gamelist"]["gtsje"] = array("Jade Emperor", "pt/Jade_Emperor_138x125.png","");
$gameList["PT"]["gamelist"]["ftsis"] = array("Age of the Gods: Fate Sisters", "pt/Age_of_the_Gods_Fate_Sisters_138x125.png","");
$gameList["PT"]["gamelist"]["mrcb"] = array("Cash back先生", "pt/Mr Cashback.png","");
$gameList["PT"]["gamelist"]["bjp"] = array("完美21点", "pt/Blackjack_138x125.png","");
$gameList["PT"]["gamelist"]["fsf"] = array("神奇四侠50条线", "pt/fantastic_four.jpg","");
$gameList["PT"]["gamelist"]["ir2"] = array("钢铁人2", "pt/iron_man2.jpg","");
$gameList["PT"]["gamelist"]["spm"] = array("蒙提.派森之火腿骑士", "pt/Monty_Pythons_Life_of_Brian_230.png","");
$gameList["PT"]["gamelist"]["art"] = array("北极宝藏", "pt/aztec_treasure.jpg","");
$gameList["PT"]["gamelist"]["mobbj"] = array("Mobile Blackjack", "pt/Blackjack-Scratch.jpg","");
$gameList["PT"]["gamelist"]["ashadv"] = array("Adventures in Wonderland Deluxe", "pt/Adventures_in_Wonderland_Deluxe.png","");
$gameList["PT"]["gamelist"]["savcas"] = array("大草原现金", "pt/Savannah_Cash.png","");
$gameList["PT"]["gamelist"]["frtln"] = array("幸运狮子", "pt/Fortune_Lions.png","");
$gameList["PT"]["gamelist"]["hotktv"] = array("火热KTV", "pt/Hot_KTV.png","");
$gameList["PT"]["gamelist"]["heavru"] = array("武则天", "pt/heavenly_ruler.png","");
$gameList["PT"]["gamelist"]["sling"] = array("四灵", "pt/si_ling.png","");
$gameList["PT"]["gamelist"]["slion"] = array("超级狮子", "pt/super_lion.png","");
$gameList["PT"]["gamelist"]["haocs"] = array("好事成双", "pt/haoshi_cheng_shuang.png","");
$gameList["PT"]["gamelist"]["asfa"] = array("亚洲幻想", "pt/Asian_Fantasy.jpg","");
$gameList["PT"]["gamelist"]["warg"] = array("黄金武士", "pt/warriorsgold.png","");
$gameList["PT"]["gamelist"]["treasq"] = array("八宝一后", "pt/8Treasures1Queen.png","");
$gameList["PT"]["gamelist"]["titimama"] = array("跳跳猫猫", "pt/TiaoTiaoMaoMao.png","");
$gameList["PT"]["gamelist"]["egspin"] = array("埃及旋转", "pt/EgyptSpin.png","");

$gameList["BG"] = array();
$gameList["BG"]['section'] = array();
$gameList["BG"]["gamelist"] = array();
$gameList["BG"]["gamelist"]["BOMBO1D"] = array("豪华版七意兴隆", "bg/BOMBO1D_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1B"] = array("沙漠争雄", "bg/BOMBO1B_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1E"] = array("古典", "bg/BOMBO1E_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1F"] = array("豪华版双倍樱桃", "bg/BOMBO1F_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1G"] = array("金豚供珠 2", "bg/BOMBO1G_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1H"] = array("狂野小丑", "bg/BOMBO1H_ zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1I"] = array("凛凛现金", "bg/BOMBO1I_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO09"] = array("七意兴隆", "bg/BOMBO09_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0A"] = array("金童玉女", "bg/BOMBO0A_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1J"] = array("狂野櫻桃", "bg/BOMBO1J_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1K"] = array("精灵的愿望", "bg/BOMBO1K_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1L"] = array("收获节", "bg/BOMBO1L_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO18"] = array("鸿运当头同心共济", "bg/BOMBO18_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1M"] = array("流氓赌徒", "bg/BOMBO1M_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO12"] = array("精彩入球", "bg/BOMBO12_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO19"] = array("德国十月啤酒嘉年华", "bg/BOMBO19_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1N"] = array("怪物笨蛋", "bg/BOMBO1N_zh_ 188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0P"] = array("金光灿灿", "bg/BOMBO0P_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0N"] = array("黑帮之夜", "bg/BOMBO0N_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO14"] = array("与鲨争胜", "bg/BOMBO14_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1O"] = array("圣诞老人之吻", "bg/BOMBO1O_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO13"] = array("屈原传", "bg/BOMBO13_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO15"] = array("始祖危机", "bg/BOMBO15_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1A"] = array("浪漫蒂克", "bg/BOMBO1A_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1C"] = array("赛前狂欢", "bg/BOMBO1C_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO1P"] = array("异国水果", "bg/BOMBO1P_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO01"] = array("宝石风云", "bg/BOMBO01_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO08"] = array("万圣狂欢", "bg/BOMBO08_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0F"] = array("一千零一夜", "bg/BOMBO0F_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0G"] = array("聚宝转运果", "bg/BOMBO0G_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0K"] = array("火热美眉", "bg/BOMBO0K_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO11"] = array("极度打击", "bg/BOMBO11_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0B"] = array("火龙献瑞", "bg/BOMBO0B_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0R"] = array("请勿打扰", "bg/BOMBO0R_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO05"] = array("奇妙花园", "bg/BOMBO05_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0Q"] = array("耶诞狂欢", "bg/BOMBO0Q_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO04"] = array("甜点甜心", "bg/BOMBO04_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0J"] = array("开工大吉", "bg/BOMBO0J_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO07"] = array("酒神巴克斯", "bg/BOMBO07_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0I"] = array("疯狂小丑", "bg/BOMBO0I_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO03"] = array("小鬼当家", "bg/BOMBO03_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0C"] = array("双倍樱桃", "bg/BOMBO0C_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0D"] = array("冰寒世界", "bg/BOMBO0D_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0E"] = array("金豚供珠", "bg/BOMBO0M_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO06"] = array("运财果", "bg/BOMBO06_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO02"] = array("生财机械宝宝", "bg/BOMBO02_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO16"] = array("甜蜜表情符号", "bg/BOMBO16_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0H"] = array("胜利进行曲", "bg/BOMBO0H_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO17"] = array("巴西奥运", "bg/BOMBO17_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0U"] = array("十二生肖", "bg/BOMBO0U_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0W"] = array("5月5日", "bg/BOMBO0W_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0T"] = array("复活藏宝", "bg/BOMBO0T_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0S"] = array("蛙运享通", "bg/BOMBO0S_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0Y"] = array("炫光迷目", "bg/BOMBO0Y_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO10"] = array("红粉骷髅", "bg/BOMBO10_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0M"] = array("星际极速", "bg/BOMBO0M_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0Z"] = array("可爱龙宝宝", "bg/BOMBO0Z_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0V"] = array("英雄与野兽", "bg/BOMBO0V_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0O"] = array("法老谜藏", "bg/BOMBO0O_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0L"] = array("鲍尔斯家庭历险记", "bg/BOMBO0L_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO0X"] = array("方块围城", "bg/BOMBO0X_zh_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO2A"] = array("法老谷", "bg/Valley of Pharaohs Logo_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO2B"] = array("恶魔热度", "bg/logo Devil's Heat 188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO2C"] = array("金牌天神", "bg/Golden Profits_Logo_188x125.png","");
$gameList["BG"]["gamelist"]["BOMBO2D"] = array("香蕉冲击", "bg/Booming_bananas.png","");
$gameList["BG"]["gamelist"]["BOMBO2E"] = array("奇迹啤酒节", "bg/Wunderfest.png","");
$gameList["BG"]["gamelist"]["BOMBO2F"] = array("黄金女郎", "bg/Golden_Girls.png","");
$gameList["BG"]["gamelist"]["BOMBO2G"] = array("狂野自尊心", "bg/WildPride.png","");
$gameList["BG"]["gamelist"]["BOMBO2H"] = array("热闹酒吧", "bg/BoomingBars.png","");
$gameList["BG"]["gamelist"]["BOMBO2I"] = array("圣诞响叮当", "bg/JingleJingle.png","");
$gameList["BG"]["gamelist"]["BOMBO2J"] = array("异国水果豪华版", "bg/ExoticFruitDeluxe.png","");
$gameList["BG"]["gamelist"]["BOMBO2K"] = array("皇家之战", "bg/RoyalWins.png","");
$gameList["BG"]["gamelist"]["BOMBO2L"] = array("大苹果之战", "bg/BigAppleWins.png","");


$gameImages = array(
    'cdn' => 'http://egame.cnamedns.net/images/',
);
$curList = array();
$section = isset($_GET['sid'])?$_GET['sid']:'ALL';
if(isset($gameList[$curGame]['section'][$section])){
    foreach($gameList[$curGame]['section'][$section][1] as $key){
        isset($gameList[$curGame]['gamelist'][$key])&&$curList[] = '["'.implode('", "', $gameList[$curGame]['gamelist'][$key]).'", "'.$key.'"]';
    }
}else{
    $section = 'ALL';
    foreach($gameList[$curGame]['gamelist'] as $key=>$val){
        $curList[] = '["'.implode('", "', $val).'", "'.$key.'"]';
    }
}
?><!DOCTYPE html>
<html class="ui-mobile ui-mobile-viewport ui-overlay-a">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
  <title><?=$web_site['web_title'];?></title>
  <!--[if lt IE 9]>
      <script src="js/html5.js" type="text/javascript">
      </script>
      <script src="js/css3-mediaqueries.js" type="text/javascript">
      </script>
  <![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
  <meta content="yes" name="apple-mobile-web-app-capable">
  <meta content="black" name="apple-mobile-web-app-status-bar-style">
  <meta content="telephone=no" name="format-detection">
  <meta name="viewport" content="width=device-width">
  <link rel="shortcut icon" href="images/favicon.ico">
  <link rel="stylesheet" href="css/style.css" type="text/css" media="all">
  <link rel="stylesheet" href="js/jquery.mobile-1.4.5.min.css">
  <link rel="stylesheet" href="css/style_index.css" type="text/css" media="all">
  <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script>$(document).bind("mobileinit", function() {$.mobile.ajaxEnabled=false;});</script>
  <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
  <!--js判断横屏竖屏自动刷新-->
  <script type="text/javascript" src="js/top.js"></script>
</head>
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-url="member/orders.php" tabindex="0" style="min-height: 659px;">
  <!--头部开始-->
  <header id="header">
      <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a>
          <span><?php echo $curGame; ?>电子游戏</span>
      <a href="javascript:window.location.href='index.php'" class="ico ico_home ico_home_r ui-link"></a>
  </header>
  <div class="mrg_header"></div>
  <!--头部结束-->
  <script type="text/javascript">
var gameImages = 'https://egame-ssl.ub-66.com/egame_cnamedns_net/images/';
var gameList = <?php echo '['.implode(', ', $curList).']'; ?>;
$(document).ready(function(){
    $(".ui-li-static input").on("keyup", function(){
        loadGame(1, $(this).val());
    });
    loadGame(1);
});
function loadGame(page, keyword){
    if(typeof(page)=="undefined"||page==""){
        page = 1;
    }
    if(typeof(keyword)=="undefined"){
        keyword = "";
    }
    var end = page*18;
    var start = end-18;
    $(".page-div").hide();
    $(".ctop").hide();
    $(".c2").show().find("ul").empty();
    $(".ui-li-static input").val(keyword);
    var i = 0;
    $.each(gameList, function(key, val){
        if(keyword!=""){
            if(val[0].indexOf(keyword)>=0){
                var isShow = i>=start&&i<end;
                var showHTML = val[0].replace(keyword, "<span style=\"color:red\">"+keyword+"</span>");
                i++;
            }
        }else{
            var isShow = key>=start&&key<end;
            var showHTML = val[0];
            i++;
        }
        if(isShow){
            var li = $("<li></li>");
            li.append("<a href=\"javascript:;\" onclick=\"<?php if($uid){ ?>window.open('/cj/live/index.php?type=<?php echo str_replace(array('XIN', 'NYX', 'PNG', 'TTG'), 'AGIN', $curGame); ?>&amp;gameType="+val[3]+"&amp;mobile=true', '_blank')<?php }else{ ?>alert('请登陆')<?php } ?>\"><img src=\""+gameImages+val[1]+"\" /><div style=\"white-space:nowrap;overflow:hidden;text-overflow:ellipsis\">"+showHTML+"</div></a></p>");
            li.appendTo(".c2 ul");
        }
    });
    if(i>0){
        var endPage = Math.ceil(i/18);
        $(".page-div").show();
        $(".footer-page").empty();
        for(var i=1;i<=endPage;i++){
            var a = $("<a data-ajax=\"false\" data-role=\"button\" data-mini=\"true\" data-corners=\"false\" data-shadow=\"false\" class=\"ui-link ui-btn ui-mini\" role=\"button\"></a>");
            if(i==1){
                a.addClass("ui-first-child");
            }
            if(page==i){
                a.addClass("ui-btn-active");
            }
            if(i==endPage){
                a.addClass("ui-last-child");
            }
            a.html(i).attr("href", "javascript:;").on("click", function(){
                parent.$("body, html").animate({scrollTop: 0});
                loadGame($(this).html(), keyword);
            });
            a.appendTo(".footer-page");
        }
        var row_num = $(".c2 ul li").size();
        if(row_num%3>0){
            for(var i=3;i>row_num%3;i--){
                var li = $("<li></li>");
                li.append("<a href=\"javascript:;\"><img src=\"images/game/c2img_more.png\"/>更多游戏</a></p>");
                li.appendTo(".c2 ul");
            }
        }
        row_num = $(".c2 ul li").size();
        $(".c2 ul li").each(function(){
            if($(this).index()%3==2){
                $(this).css("border-right", "0");
            }
            if(row_num-$(this).index()<=3){
                $(this).css("border-bottom", "0");
            }
        });
    }else{
        $(".ctop").show().find("label").html("没有找到“"+keyword+"”的游戏");
        $(".c2").hide();
    }
}
  </script>
  <!--功能列表-->
  <section class="mContent clearfix" style="padding:0px;">
      <div data-role="cotent">
          <ul data-role="listview" class="ui-listview">
              <li class="ui-li-static ui-body-inherit ui-first-child">
                  <div data-role="controlgroup" data-type="horizontal" class="ui-controlgroup ui-controlgroup-horizontal ui-corner-all">
                      <div class="ui-controlgroup-controls ">
                      <?php for($i=0;$i<count($gameType);$i++):
                      		$class = '';
                      		if($curGame==$gameType[$i]) $class = ' ui-btn-active';?>
                      		<a href="?pid=<?=$gameType[$i]?>" data-ajax="false" data-role="button" data-mini="true" data-corners="false" data-shadow="false" class="<?=$class?>" role="button"><?=$gameType[$i]?></a>
                      <?php endfor; ?>
                      </div>
                  </div>
              </li>
              <li class="ui-li-static ui-body-inherit ui-first-child">
                  <div style="overflow-x: scroll">
                  <div style="width:200%" class="sub-menu">
                  <div data-role="controlgroup" data-type="horizontal" class="ui-controlgroup ui-controlgroup-horizontal ui-corner-all">
                      <div class="ui-controlgroup-controls">
                          <a href="?pid=<?=$curGame?>&sid=ALL" data-role="button" data-mini="true" data-corners="false" data-shadow="false" class="ui-link ui-btn ui-mini <?=$section=='ALL'?'ui-btn-active':''?>" role="button">全部</a>

<?php foreach($gameList[$curGame]['section'] as $key=>$val){ ?>
	<a href="?pid=<?=$curGame?>&sid=<?=$key?>" data-role="button" data-mini="true" data-corners="false" data-shadow="false" class="ui-link ui-btn ui-mini<?php if($section!='ALL'&&$section==$key){ ?> ui-btn-active<?php }?>" role="button"><?=$val[0]?></a>
<?php } ?>                      </div>
                  </div>
                  <script type="text/javascript">(function(){$(".sub-menu").width($(".sub-menu .ui-controlgroup-controls").width()+5)})();</script>
                  </div>
                  </div>
              </li>
              <li class="ui-li-static ui-body-inherit">
                  <label><input type="text" placeholder="查找游戏" /></label>
              </li>
          </ul>
          <div style="line-height:5px;height:5px"></div>
          <div class="ctop ctop_info" style="margin:0 5px;display:none">
              <label stylr="width:100%"></label>
          </div>
          <div class="c2">
              <div class="slideTxtBox">
                  <div class="bd">
                      <ul class="cl"></ul>
                  </div>
              </div>
          </div>
          <div style="line-height:5px;height:5px"></div>
          <ul data-role="listview" class="ui-listview page-div">
              <li class="ui-li-static ui-body-inherit ui-first-child">
                  <div data-role="controlgroup" data-type="horizontal" class="ui-controlgroup ui-controlgroup-horizontal ui-corner-all">
                      <div class="ui-controlgroup-controls footer-page"></div>
                  </div>
              </li>
          </ul>
      </div>
  </section>
  <!--底部开始--><?php include_once 'bottom.php';?>    <!--底部结束-->
  <!--我的资料--><?php include_once 'member/myinfo.php';?>
  </body>
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div>
</html>