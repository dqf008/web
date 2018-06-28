<?php
return [
    'MAYA' => [
        'field' => 'mayamoney',
        'name' => '玛雅娱乐厅',
        'func' => 'giro_MAYA',
        'api' => '../cj/live/live_money_MAYA.php',
        'closeId' => 13,
    ],
    'AG' => [
        'field' => 'agqmoney',
        'name' => 'AG极速厅',
        'closeId' => 3,
    ],
    'BBIN2' => [
        'field' => 'bbin2money',
        'name' => '新BBIN旗舰厅',
        'func' => 'giro_BBIN2',
        'api' => '../cj/live/live_money_BBIN.php',
        'closeId' => 0,
    ],
    'MG2' => [
        'field' => 'mg2money',
        'name' => '新MG电子',
        'func' => 'giro_MG2',
        'api' => '../cj/live/live_money_MG2.php',
        'closeId' => 0,
    ],
    'MW' => [
        'field' => 'mwmoney',
        'name' => 'MW电子',
        'func' => 'giro_MW',
        'api' => '../cj/live/live_money_MW.php',
        'closeId' => 4,
    ],
    'PT2' => [
        'field' => 'pt2money',
        'name' => '新PT电子',
        'func' => 'giro_PT2',
        'api' => '../cj/live/live_money_PT.php',
        'closeId' => 0,
    ],
    'OG2' => [
        'field' => 'og2money',
        'name' => '新OG东方厅',
        'func' => 'giro_OG2',
        'api' => '../cj/live/live_money_OG.php',
        'closeId' => 0,
    ],
    'SHABA' => [
        'field' => 'shabamoney',
        'name' => '沙巴体育',
        'closeId' => 0,
    ],
    'DG' => [
        'field' => 'dgmoney',
        'name' => 'DG视讯',
        'func' => 'giro_DG',
        'api' => '../cj/live/live_money_DG.php',
        'closeId' => 0,
    ],
    'KG' => [
        'field' => 'kgmoney',
        'name' => 'AV女优',
        'func' => 'giro_KG',
        'api' => '../cj/live/live_money_KG.php',
        'closeId' => 0,
    ],
    'VR' => [
        'field' => 'vrmoney',
        'name' => 'VR彩票',
        'func' => 'giro_VR',
        'api' => '../cj/live/live_money_VR.php',
        'closeId' => 0,
    ],
    'CQ9' => [
        'field' => 'cq9money',
        'name' => 'CQ9电子',
        'func' => 'giro_CQ9',
        'api' => '../cj/live/live_money_CQ9.php',
        'closeId' => 0,
    ],
    'BGLIVE' => [
        'field' => 'bgmoney', // 数据库余额字段
        'name' => 'BG视讯', // 平台名称
        'tips' => ['BG捕鱼'], // 相同转账渠道的游戏名称
        'col' => 1, // 占用列数
        'func' => 'giro_BG', // 转账函数名
        'api' => '../cj/live/live_money_BG.php', // 余额刷新地址
        'closeId' => 0, // 游戏维护表对应 ID
    ],
    'KY' => [
        'field' => 'kymoney',
        'name' => '开元棋牌',
        'func' => 'giro_KY',
        'api' => '../cj/live/live_money_KY.php',
        'closeId' => 0,
    ],
    'SB' => [
        'field' => 'sbmoney',
        'name' => '申博视讯',
        'func' => 'giro_SB',
        'api' => '../cj/live/live_money_SB.php',
        'closeId' => 2
    ],
    'BBIN' => [
        'field' => 'bbmoney',
        'name' => 'BBIN旗舰厅',
        'closeId' => 8,
    ],
    'MG' => [
        'field' => 'mgmoney',
        'name' => 'MG电子',
        'closeId' => 2
    ],
    'AGIN' => [
        'field' => 'agmoney',
        'name' => 'AG国际厅',
        'tips' => ['XIN电子', 'AG街机', 'BG电子', 'AG体育'],
        'col' => 3,
        'closeId' => 6,
    ],
];