<?php
!defined('IN_LOT')&&die('Access Denied');
include(IN_LOT.'include/class/lunar.class.php');
/* 未开期数信息 */
$query = $mydata2_db->query('SELECT * FROM `ka_kithe` WHERE `na`=0 ORDER BY `nn` DESC LIMIT 1');
$LOT['marksix'] = $query->rowCount()>0?$query->fetch():array();
/* 自动封盘 */
if(!empty($LOT['marksix'])){
    $params = array();
    if(strtotime($LOT['marksix']['zfbdate'])<=$LOT['bjtime']){
        $params[':kitm'] = 0;
        $params[':kizt'] = 0;
        $params[':kizm'] = 0;
        $params[':kizm6'] = 0;
        $params[':kigg'] = 0;
        $params[':kiws'] = 0;
        $params[':kilm'] = 0;
        $params[':kisx'] = 0;
        $params[':kibb'] = 0;
        $params[':zfb'] = 0;
    }
    if(strtotime($LOT['marksix']['zfbdate1'])<=$LOT['bjtime']&&$LOT['marksix']['best']==1){
        $params[':kitm'] = 1;
        $params[':kizt'] = 1;
        $params[':kizm'] = 1;
        $params[':kizm6'] = 1;
        $params[':kigg'] = 1;
        $params[':kiws'] = 1;
        $params[':kilm'] = 1;
        $params[':kisx'] = 1;
        $params[':kibb'] = 1;
        $params[':zfb'] = 1;
        $params[':best'] = 0;
    }
    if($LOT['marksix']['zfb']==1){
        strtotime($LOT['marksix']['kitm1'])<=$LOT['bjtime']&&$params[':kitm'] = 0;
        strtotime($LOT['marksix']['kizt1'])<=$LOT['bjtime']&&$params[':kizt'] = 0;
        strtotime($LOT['marksix']['kizm1'])<=$LOT['bjtime']&&$params[':kizm'] = 0;
        strtotime($LOT['marksix']['kizm61'])<=$LOT['bjtime']&&$params[':kizm6'] = 0;
        strtotime($LOT['marksix']['kigg1'])<=$LOT['bjtime']&&$params[':kigg'] = 0;
        strtotime($LOT['marksix']['kilm1'])<=$LOT['bjtime']&&$params[':kilm'] = 0;
        strtotime($LOT['marksix']['kisx1'])<=$LOT['bjtime']&&$params[':kisx'] = 0;
        strtotime($LOT['marksix']['kibb1'])<=$LOT['bjtime']&&$params[':kibb'] = 0;
        strtotime($LOT['marksix']['kiws1'])<=$LOT['bjtime']&&$params[':kiws'] = 0;
    }
    if(!empty($params)){
        $sql = array();
        foreach($params as $key=>$val){
            $sql[] = '`'.substr($key, 1).'`='.$key;
        }
        $stmt = $mydata2_db->prepare('UPDATE `ka_kithe` SET '.implode(', ', $sql).' WHERE `id`='.intval($LOT['marksix']['id']));
        $stmt->execute($params);
    }
}
/* 波色信息 */
$LOT['color'] = array(
    1 => 'red',
    2 => 'red',
    3 => 'blue',
    4 => 'blue',
    5 => 'green',
    6 => 'green',
    7 => 'red',
    8 => 'red',
    9 => 'blue',
    10 => 'blue',
    11 => 'green',
    12 => 'red',
    13 => 'red',
    14 => 'blue',
    15 => 'blue',
    16 => 'green',
    17 => 'green',
    18 => 'red',
    19 => 'red',
    20 => 'blue',
    21 => 'green',
    22 => 'green',
    23 => 'red',
    24 => 'red',
    25 => 'blue',
    26 => 'blue',
    27 => 'green',
    28 => 'green',
    29 => 'red',
    30 => 'red',
    31 => 'blue',
    32 => 'green',
    33 => 'green',
    34 => 'red',
    35 => 'red',
    36 => 'blue',
    37 => 'blue',
    38 => 'green',
    39 => 'green',
    40 => 'red',
    41 => 'blue',
    42 => 'blue',
    43 => 'green',
    44 => 'green',
    45 => 'red',
    46 => 'red',
    47 => 'blue',
    48 => 'blue',
    49 => 'green',
);
/* 生肖年信息 */
$LOT['_temp'] = array();
$LOT['_temp'][0] = array(
    '鼠',
    '牛',
    '虎',
    '兔',
    '龙',
    '蛇',
    '马',
    '羊',
    '猴',
    '鸡',
    '狗',
    '猪',
);
$LOT['_temp'][1] = array(
    array(1, 13, 25, 37, 49),
    array(2, 14, 26, 38),
    array(3, 15, 27, 39),
    array(4, 16, 28, 40),
    array(5, 17, 29, 41),
    array(6, 18, 30, 42),
    array(7, 19, 31, 43),
    array(8, 20, 32, 44),
    array(9, 21, 33, 45),
    array(10, 22, 34, 46),
    array(11, 23, 35, 47),
    array(12, 24, 36, 48),
);
$LOT['animal'] = array();
/* 加载农历年份 */
$_ldate = strtotime($LOT['marksix']['zfbdate']);
$_lunar = new Lunar();
$_ldate = $_lunar->convertSolarToLunar(date('Y', $_ldate), date('m', $_ldate), date('d', $_ldate));
unset($_lunar);
foreach($LOT['_temp'][0] as $key=>$val){
    $key = fmod($_ldate[0]-$key+8, 12);
    $LOT['animal'][$val] = $LOT['_temp'][1][$key];
}
unset($LOT['_temp']); // 释放临时信息
/* 香港六合彩投注信息 */
/* 特码A-B */
$return = array();
$return[1] = array(
    array('特码', '特A'),
    array(
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10',
        11 => '11',
        12 => '12',
        13 => '13',
        14 => '14',
        15 => '15',
        16 => '16',
        17 => '17',
        18 => '18',
        19 => '19',
        20 => '20',
        21 => '21',
        22 => '22',
        23 => '23',
        24 => '24',
        25 => '25',
        26 => '26',
        27 => '27',
        28 => '28',
        29 => '29',
        30 => '30',
        31 => '31',
        32 => '32',
        33 => '33',
        34 => '34',
        35 => '35',
        36 => '36',
        37 => '37',
        38 => '38',
        39 => '39',
        40 => '40',
        41 => '41',
        42 => '42',
        43 => '43',
        44 => '44',
        45 => '45',
        46 => '46',
        47 => '47',
        48 => '48',
        49 => '49',
        50 => '单',
        51 => '双',
        52 => '大',
        53 => '小',
        54 => '合单',
        55 => '合双',
        56 => '红波',
        57 => '绿波',
        58 => '蓝波',
        59 => '家禽',
        60 => '野兽',
        61 => '尾大',
        62 => '尾小',
        63 => '大单',
        64 => '小单',
        65 => '大双',
        66 => '小双',
    ),
);
$return[2] = $return[1];
$return[2][0][1] = '特B';

/* 正码A-B */
$return[3] = array(
    array('正码', '正A'),
    array(
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10',
        11 => '11',
        12 => '12',
        13 => '13',
        14 => '14',
        15 => '15',
        16 => '16',
        17 => '17',
        18 => '18',
        19 => '19',
        20 => '20',
        21 => '21',
        22 => '22',
        23 => '23',
        24 => '24',
        25 => '25',
        26 => '26',
        27 => '27',
        28 => '28',
        29 => '29',
        30 => '30',
        31 => '31',
        32 => '32',
        33 => '33',
        34 => '34',
        35 => '35',
        36 => '36',
        37 => '37',
        38 => '38',
        39 => '39',
        40 => '40',
        41 => '41',
        42 => '42',
        43 => '43',
        44 => '44',
        45 => '45',
        46 => '46',
        47 => '47',
        48 => '48',
        49 => '49',
        50 => '总单',
        51 => '总双',
        52 => '总大',
        53 => '总小',
    ),
);
$return[4] = $return[3];
$return[4][0][1] = '正B';

/* 正特1-6 */
$return[5] = array(
    array('正特', '正1特'),
    array(
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10',
        11 => '11',
        12 => '12',
        13 => '13',
        14 => '14',
        15 => '15',
        16 => '16',
        17 => '17',
        18 => '18',
        19 => '19',
        20 => '20',
        21 => '21',
        22 => '22',
        23 => '23',
        24 => '24',
        25 => '25',
        26 => '26',
        27 => '27',
        28 => '28',
        29 => '29',
        30 => '30',
        31 => '31',
        32 => '32',
        33 => '33',
        34 => '34',
        35 => '35',
        36 => '36',
        37 => '37',
        38 => '38',
        39 => '39',
        40 => '40',
        41 => '41',
        42 => '42',
        43 => '43',
        44 => '44',
        45 => '45',
        46 => '46',
        47 => '47',
        48 => '48',
        49 => '49',
        50 => '单',
        51 => '双',
        52 => '大',
        53 => '小',
        54 => '合单',
        55 => '合双',
        56 => '红波',
        57 => '绿波',
        58 => '蓝波',
        59 => '合大',
        60 => '合小',
    ),
);
$return[10] = $return[9] = $return[8] = $return[7] = $return[6] = $return[5];
$return[6][0][1] = '正2特';
$return[7][0][1] = '正3特';
$return[8][0][1] = '正4特';
$return[9][0][1] = '正5特';
$return[10][0][1] = '正6特';

/* 正码1-6 */
$return[11] = array(
    array('正1-6', '正码1', 11, 16), //指定类型id的范围
    array(
        1 => '大',
        2 => '小',
        3 => '单',
        4 => '双',
        5 => '红波',
        6 => '绿波',
        7 => '蓝波',
        8 => '合大',
        9 => '合小',
        10 => '合单',
        11 => '合双',
        12 => '尾大',
        13 => '尾小',
    ),
);
$return[16] = $return[15] = $return[14] = $return[13] = $return[12] = $return[11];
$return[12][0][1] = '正码2';
$return[13][0][1] = '正码3';
$return[14][0][1] = '正码4';
$return[15][0][1] = '正码5';
$return[16][0][1] = '正码6';

/* 过关 */
$return[17] = array(
    array('过关', '正码1', 17, 22, 'guoguan', 2, 8), //指定类型id的范围以及下注类型
    array(
        1 => '单',
        2 => '双',
        3 => '大',
        4 => '小',
        5 => '红波',
        6 => '绿波',
        7 => '蓝波',
    ),
);
$return[22] = $return[21] = $return[20] = $return[19] = $return[18] = $return[17];
$return[18][0][1] = '正码2';
$return[19][0][1] = '正码3';
$return[20][0][1] = '正码4';
$return[21][0][1] = '正码5';
$return[22][0][1] = '正码6';

/* 半波 */
$return[23] = array(
    array('半波', '半波'),
    array(
        1 => '红单',
        2 => '红双',
        3 => '红大',
        4 => '红小',
        5 => '绿单',
        6 => '绿双',
        7 => '绿大',
        8 => '绿小',
        9 => '蓝单',
        10 => '蓝双',
        11 => '蓝大',
        12 => '蓝小',
        13 => '红合单',
        14 => '红合双',
        15 => '绿合单',
        16 => '绿合双',
        17 => '蓝合单',
        18 => '蓝合双',
    ),
);

/* 生肖：一肖 */
$return[24] = array(
    array('生肖', '一肖'),
    array(
        1 => '鼠',
        2 => '牛',
        3 => '虎',
        4 => '兔',
        5 => '龙',
        6 => '蛇',
        7 => '马',
        8 => '羊',
        9 => '猴',
        10 => '鸡',
        11 => '狗',
        12 => '猪',
    ),
);

/* 尾数 */
$return[25] = array(
    array('正特尾数', '正特尾数'),
    array(
        1 => '0',
        2 => '1',
        3 => '2',
        4 => '3',
        5 => '4',
        6 => '5',
        7 => '6',
        8 => '7',
        9 => '8',
        10 => '9',
    ),
);

/* 生肖：特肖 */
$return[26] = $return[24];
$return[26][0][1] = '特肖';

/* 生肖连 */
$return[27] = $return[24];
$return[27][0] = array('生肖连', '二肖连中', 4 => 'weilian', 5 => 2, 6 => 8);
$return[33] = $return[32] = $return[31] = $return[30] = $return[29] = $return[28] = $return[27];
$return[28][0][1] = '三肖连中';
$return[28][0][5] = 3;
$return[29][0][1] = '四肖连中';
$return[29][0][5] = 4;
$return[30][0][1] = '五肖连中';
$return[30][0][5] = 5;
$return[31][0][1] = '二肖连不中';
$return[32][0][1] = '三肖连不中';
$return[32][0][5] = 3;
$return[33][0][1] = '四肖连不中';
$return[33][0][5] = 4;

/* 尾数连 */
$return[34] = $return[25];
$return[34][0] = array('尾数连', '二尾连中', 4 => 'weilian', 5 => 2, 6 => 8);
$return[39] = $return[38] = $return[37] = $return[36] = $return[35] = $return[34];
$return[35][0][1] = '三尾连中';
$return[35][0][5] = 3;
$return[36][0][1] = '四尾连中';
$return[36][0][5] = 4;
$return[37][0][1] = '二尾连不中';
$return[38][0][1] = '三尾连不中';
$return[38][0][5] = 3;
$return[39][0][1] = '四尾连不中';
$return[39][0][5] = 4;

/* 合肖2-11 */
$return[40] = $return[24];
$return[40][0] = array('生肖', '二肖', 4 => 'weilian', 5 => 2);
$return[49] = $return[48] = $return[47] = $return[46] = $return[45] = $return[44] = $return[43] = $return[42] = $return[41] = $return[40];
$return[41][0][1] = '三肖';
$return[41][0][5] = 3;
$return[42][0][1] = '四肖';
$return[42][0][5] = 4;
$return[43][0][1] = '五肖';
$return[43][0][5] = 5;
$return[44][0][1] = '六肖';
$return[44][0][5] = 6;
$return[45][0][1] = '七肖';
$return[45][0][5] = 7;
$return[46][0][1] = '八肖';
$return[46][0][5] = 8;
$return[47][0][1] = '九肖';
$return[47][0][5] = 9;
$return[48][0][1] = '十肖';
$return[48][0][5] = 10;
$return[49][0][1] = '十一肖';
$return[49][0][5] = 11;

/* 全不中5-12 */
$return[50] = array(
    array('全不中', '五不中', 4 => 'weilian', 5 => 5),
    array(
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10',
        11 => '11',
        12 => '12',
        13 => '13',
        14 => '14',
        15 => '15',
        16 => '16',
        17 => '17',
        18 => '18',
        19 => '19',
        20 => '20',
        21 => '21',
        22 => '22',
        23 => '23',
        24 => '24',
        25 => '25',
        26 => '26',
        27 => '27',
        28 => '28',
        29 => '29',
        30 => '30',
        31 => '31',
        32 => '32',
        33 => '33',
        34 => '34',
        35 => '35',
        36 => '36',
        37 => '37',
        38 => '38',
        39 => '39',
        40 => '40',
        41 => '41',
        42 => '42',
        43 => '43',
        44 => '44',
        45 => '45',
        46 => '46',
        47 => '47',
        48 => '48',
        49 => '49',
    ),
);
$return[57] = $return[56] = $return[55] = $return[54] = $return[53] = $return[52] = $return[51] = $return[50];
$return[51][0][1] = '六不中';
$return[51][0][5] = 6;
$return[52][0][1] = '七不中';
$return[52][0][5] = 7;
$return[53][0][1] = '八不中';
$return[53][0][5] = 8;
$return[54][0][1] = '九不中';
$return[54][0][5] = 9;
$return[55][0][1] = '十不中';
$return[55][0][5] = 10;
$return[56][0][1] = '十一不中';
$return[56][0][5] = 11;
$return[57][0][1] = '十二不中';
$return[57][0][5] = 12;

/* 连码 */
$return[58] = $return[50];
$return[58][0] = array('连码', '三全中', 4 => 'weilian', 5 => 3);
$return[63] = $return[62] = $return[61] = $return[60] = $return[59] = $return[58];
$return[59][0][1] = '三中二';
$return[60][0][1] = '二全中';
$return[60][0][5] = 2;
$return[61][0][1] = '二中特';
$return[61][0][5] = 2;
$return[62][0][1] = '特串';
$return[62][0][5] = 2;
$return[63][0][1] = '四中一';
$return[63][0][5] = 4;
return $return;