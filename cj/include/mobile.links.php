<?php
/**
 * Created by PhpStorm.
 * User: empty
 * Date: 2018/6/2
 * Time: 下午7:09
 */

return [
    // 默认热门游戏
    'hot' => [
        'casino.maya',
        'casino.agin',
        'casino.sunbet',
        'lottery.jssc',
        'lottery.jsssc',
        'lottery.jslh',
        'slots.mg',
        'slots.fish',
        'slots.ky',
        'slots.av',
        'sports.hg',
        'system.sign',
    ],
    // 后台菜单
    'manage' => [
        'system' => '系统功能',
        'lottery' => '彩票游戏',
        'casino' => '真人电子',
        'slots' => '棋牌游戏',
        'sports' => '体育赛事',
    ],
    // 顶部栏目
    'tabs' => [
        'hot' => [
            'name' => '热门游戏',
            'img' => './images/g-hot.png',
        ],
        'slots' => [
            'name' => '棋牌游戏',
            'img' => './images/g-poker.png',
        ],
        'lottery' => [
            'name' => '彩票游戏',
            'img' => './images/g-lottery.png',
        ],
        'casino' => [
            'name' => '真人电子',
            'img' => './images/g-casino.png',
        ],
        //'slots' => [
        //    'name' => '电子游戏',
        //    'img' => './images/g-slots.png',
        //],
        'sports' => [
            'name' => '体育赛事',
            'img' => './images/g-sports.png',
        ],
    ],
    // 系统功能
    'system' => [
        'sign' => [
            'name' => '签到领红包',
            'img' => './images/g-banker.png',
            'func' => 'sign',
        ],
    ],
    // 彩票游戏
    'lottery' => [
        'vr' => [
            'name' => 'VR彩票',
            'img' => './images/g-vr.png',
            'func' => 'enterGame',
            'argv' => 'VR',
        ],
        'pk10' => [
            'name' => '北京赛车',
            'img' => './images/g-pk10.png',
            'func' => 'go',
            'argv' => '/lottery/index/pk10',
        ],
        'cqssc' => [
            'name' => '重庆时时彩',
            'img' => './images/g-cqssc.png',
            'func' => 'go',
            'argv' => '/lottery/index/cqssc',
        ],
        'jsssc' => [
            'name' => '极速时时彩',
            'img' => './images/g-jsssc.png',
            'func' => 'go',
            'argv' => '/lottery/index/jsssc',
        ],
        'jssc' => [
            'name' => '极速赛车',
            'img' => './images/g-jssc.png',
            'func' => 'go',
            'argv' => '/lottery/index/jssc',
        ],
        'jslh' => [
            'name' => '极速六合',
            'img' => './images/g-jslh.png',
            'func' => 'go',
            'argv' => '/lottery/index/jslh',
        ],
        'marksix' => [
            'name' => '香港六合彩',
            'img' => './images/g-marksix.png',
            'func' => 'go',
            'argv' => '/lottery/index/marksix',
        ],
        'tjssc' => [
            'name' => '天津时时彩',
            'img' => './images/tj_ssc.png',
            'func' => 'go',
            'argv' => '/lottery/index/tjssc',
        ],
        'xjssc' => [
            'name' => '新疆时时彩',
            'img' => './images/xj_ssc.png',
            'func' => 'go',
            'argv' => '/lottery/index/xjssc',
        ],
        'xyft' => [
            'name' => '幸运飞艇',
            'img' => './images/g-xyft.png',
            'func' => 'go',
            'argv' => '/lottery/index/xyft',
        ],
        'jsk3' => [
            'func' => 'go',
            'argv' => '/lottery/index/jsk3',
            'img' => './images/jsk3.png',
            'name' => '江苏快3',
        ],
        'fjk3' => [
            'func' => 'go',
            'argv' => '/lottery/index/fjk3',
            'img' => './images/fjk3.png',
            'name' => '福建快3',
        ],
        'gxk3' => [
            'func' => 'go',
            'argv' => '/lottery/index/gxk3',
            'img' => './images/gxk3.png',
            'name' => '广西快3',
        ],
        'ahk3' => [
            'func' => 'go',
            'argv' => '/lottery/index/ahk3',
            'img' => './images/ahk3.png',
            'name' => '安徽快3',
        ],
        'shk3' => [
            'func' => 'go',
            'argv' => '/lottery/index/shk3',
            'img' => './images/shk3.png',
            'name' => '上海快3',
        ],
        'hbk3' => [
            'func' => 'go',
            'argv' => '/lottery/index/hbk3',
            'img' => './images/hbk3.png',
            'name' => '湖北快3',
        ],
        'hebk3' => [
            'func' => 'go',
            'argv' => '/lottery/index/hebk3',
            'img' => './images/hebk3.png',
            'name' => '河北快3',
        ],
        'jlk3' => [
            'func' => 'go',
            'argv' => '/lottery/index/jlk3',
            'img' => './images/jlk3.png',
            'name' => '吉林快3',
        ],
        'gzk3' => [
            'func' => 'go',
            'argv' => '/lottery/index/gzk3',
            'img' => './images/gzk3.png',
            'name' => '贵州快3',
        ],
        'bjk3' => [
            'func' => 'go',
            'argv' => '/lottery/index/bjk3',
            'img' => './images/bjk3.png',
            'name' => '北京快3',
        ],
        'gsk3' => [
            'func' => 'go',
            'argv' => '/lottery/index/gsk3',
            'img' => './images/gsk3.png',
            'name' => '甘肃快3',
        ],
        'nmgk3' => [
            'func' => 'go',
            'argv' => '/lottery/index/nmgk3',
            'img' => './images/nmgk3.png',
            'name' => '内蒙古快3',
        ],
        'jxk3' => [
            'func' => 'go',
            'argv' => '/lottery/index/jxk3',
            'img' => './images/jxk3.png',
            'name' => '江西快3',
        ],
        'gdchoose5' => [
            'func' => 'go',
            'argv' => '/lottery/index/gdchoose5',
            'img' => './images/gdchoose5.png',
            'name' => '广东11选5',
        ],
        'sdchoose5' => [
            'func' => 'go',
            'argv' => '/lottery/index/sdchoose5',
            'img' => './images/sdchoose5.png',
            'name' => '山东11选5',
        ],
        'fjchoose5' => [
            'func' => 'go',
            'argv' => '/lottery/index/fjchoose5',
            'img' => './images/fjchoose5.png',
            'name' => '福建11选5',
        ],
        'bjchoose5' => [
            'func' => 'go',
            'argv' => '/lottery/index/bjchoose5',
            'img' => './images/bjchoose5.png',
            'name' => '北京11选5',
        ],
        'ahchoose5' => [
            'func' => 'go',
            'argv' => '/lottery/index/ahchoose5',
            'img' => './images/ahchoose5.png',
            'name' => '安徽11选5',
        ],
        'gdkl10' => [
            'func' => 'go',
            'argv' => '/lottery/index/gdkl10',
            'img' => './images/gdklsf.png',
            'name' => '广东快乐10分',
        ],
        'cqkl10' => [
            'func' => 'go',
            'argv' => '/lottery/index/cqkl10',
            'img' => './images/cqklsf.png',
            'name' => '重庆快乐10分',
        ],
        'tjkl10' => [
            'func' => 'go',
            'argv' => '/lottery/index/tjkl10',
            'img' => './images/tjklsf.png',
            'name' => '天津快乐10分',
        ],
        'hnkl10' => [
            'func' => 'go',
            'argv' => '/lottery/index/hnkl10',
            'img' => './images/hnklsf.png',
            'name' => '湖南快乐10分',
        ],
        'sxkl10' => [
            'func' => 'go',
            'argv' => '/lottery/index/sxkl10',
            'img' => './images/sxklsf.png',
            'name' => '山西快乐10分',
        ],
        'ynkl10' => [
            'func' => 'go',
            'argv' => '/lottery/index/ynkl10',
            'img' => './images/ynklsf.png',
            'name' => '云南快乐10分',
        ],
        'qxc' => [
            'func' => 'go',
            'argv' => '/lottery/index/qxc',
            'img' => './images/qxc.png',
            'name' => '七星彩',
        ],
        'kl8' => [
            'func' => 'go',
            'argv' => '/lottery/index/kl8',
            'img' => './images/kl8.png',
            'name' => '北京快乐8',
        ],
        'pcdd' => [
            'func' => 'go',
            'argv' => '/lottery/index/pcdd',
            'img' => './images/pc_28.png',
            'name' => 'PC蛋蛋',
        ],
        'shssl' => [
            'func' => 'go',
            'argv' => '/lottery/index/shssl',
            'img' => './images/shssl.png',
            'name' => '上海时时乐',
        ],
        'pl3' => [
            'func' => 'go',
            'argv' => '/lottery/index/pl3',
            'img' => './images/pl3.png',
            'name' => '排列三',
        ],
        '3d' => [
            'func' => 'go',
            'argv' => '/lottery/index/3d',
            'img' => './images/3d.png',
            'name' => '福彩3D',
        ],
    ],
    // 真人列表
    'casino' => [
        'maya' => [
            'name' => '玛雅娱乐厅',
            'img' => './images/g-maya.png',
            'func' => 'enterGame',
            'argv' => 'MAYA',
        ],
        'agin' => [
            'name' => 'AG国际厅',
            'img' => './images/g-agin.png',
            'func' => 'enterGame',
            'argv' => 'AGIN',
        ],
        'sunbet' => [
            'name' => '申博视讯',
            'img' => './images/g-sunbet.png',
            'func' => 'enterGame',
            'argv' => 'SB',
        ],
        'og' => [
            'name' => 'OG东方厅',
            'img' => './images/g-og.png',
            'func' => 'enterGame',
            'argv' => 'OG2',
        ],
        'dg' => [
            'name' => 'DG视讯',
            'img' => './images/g-dg.png',
            'func' => 'enterGame',
            'argv' => 'DG',
        ],
        'bg' => [
            'name' => 'BG视讯',
            'img' => './images/g-bg.png',
            'func' => 'enterGame',
            'argv' => 'BGLIVE',
        ],
        'bbin' => [
            'name' => 'BBIN波音厅',
            'img' => './images/g-bbin.png',
            'func' => 'enterGame',
            'argv' => 'BBIN2&gameType=live',
        ],
        'mg2' => [
            'name' => '新MG电子',
            'img' => './images/g-mg.png',
            'func' => 'href',
            'argv' => 'game/?g=mg',
        ],
        'mg' => [
            'name' => 'MG电子',
            'img' => './images/g-mg.png',
            'func' => 'href',
            'argv' => '/egame/egame2.php?m=true&p=MG',
        ],
        'fish' => [
            'name' => '捕鱼达人',
            'img' => './images/g-fish.png',
            'func' => 'href',
            'argv' => 'game/?g=fish',
        ],
        'xin' => [
            'name' => 'XIN电子',
            'img' => './images/g-xin.png',
            'func' => 'href',
            'argv' => 'game/?g=xin',
        ],
        'pt' => [
            'name' => 'PT电子',
            'img' => './images/g-pt.png',
            'func' => 'href',
            'argv' => 'game/?g=pt',
        ],
        'cq9' => [
            'name' => 'CQ9电子',
            'img' => './images/g-cq9.png',
            'func' => 'href',
            'argv' => 'game/?g=cq9',
        ],
        'av' => [
            'name' => 'AV女优',
            'img' => './images/g-av.png',
            'func' => 'href',
            'argv' => 'game/?g=av',
        ],
    ],
    // 电子游戏
    'slots' => [
        'ky_830' => [
            'argv' => 'ky&id=830',
            'name' => '抢庄牛牛',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/830.png',
        ],
        'ky_220' => [
            'argv' => 'ky&id=220',
            'name' => '炸金花',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/220.png',
        ],
        'ky_230' => [
            'argv' => 'ky&id=230',
            'name' => '极速炸金花',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/230.png',
        ],
        'ky_620' => [
            'argv' => 'ky&id=620',
            'name' => '德州扑克',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/620.png',
        ],
        'ky_870' => [
            'argv' => 'ky&id=870',
            'name' => '通比牛牛',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/870.png',
        ],
        'ky_610' => [
            'argv' => 'ky&id=610',
            'name' => '斗地主',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/610.png',
        ],
        'ky_630' => [
            'argv' => 'ky&id=630',
            'name' => '十三水',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/630.png',
        ],
        'ky_720' => [
            'argv' => 'ky&id=720',
            'name' => '二八杠',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/720.png',
        ],
        'ky_730' => [
            'argv' => 'ky&id=730',
            'name' => '抢庄牌九',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/730.png',
        ],
        'ky_860' => [
            'argv' => 'ky&id=860',
            'name' => '三公',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/860.png',
        ],
        'ky_600' => [
            'argv' => 'ky&id=600',
            'name' => '21点',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/600.png',
        ],
        'ky_900' => [
            'argv' => 'ky&id=900',
            'name' => '押庄龙虎',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/900.png',
        ],
        'ky_380' => [
            'argv' => 'ky&id=380',
            'name' => '幸运五张',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/380.png',
        ],
        'ky_880' => [
            'argv' => 'ky&id=880',
            'name' => '欢乐红包',
            'func' => 'enterGame',
            'img' => '//cdn.fox008.cc/Multimedia/KY/880.png',
        ],
        'ky' => [
            'name' => '开元棋牌',
            'img' => './images/g-ky.png',
            'func' => 'href',
            'argv' => 'game/?g=ky',
        ],
    ],
    // 体育赛事
    'sports' => [
        'hg' => [
            'name' => '皇冠体育',
            'img' => './images/g-sports-hg.png',
            'func' => 'href',
            'argv' => 'sports/',
        ],
        'sbta' => [
            'name' => 'AG体育',
            'img' => './images/g-sports-sabah.png',
            'func' => 'enterGame',
            'argv' => 'AGIN&gameType=SBTA',
        ],
        'shaba' => [
            'name' => '沙巴体育',
            'img' => './images/g-sports-sabah.png',
            'func' => 'enterGame',
            'argv' => 'SHABA',
        ],
        'bbin' => [
            'name' => 'BBIN体育',
            'img' => './images/g-bbin.png',
            'func' => 'enterGame',
            'argv' => 'BBIN2&gameType=sport',
        ],
    ],
];
