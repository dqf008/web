<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/4/27
 * Time: 14:56
 */

namespace app\common;

use app\common\model\Db1_ag_zhenren_zz;
use app\common\model\Db1_commonbetdetail;
use app\common\model\Db1_daily_report;
use app\common\model\Db1_hunterbetdetail;
use app\common\model\Db5_aibo_close_game;
use think\Config;

/**
 * Class Casino 真人视讯 & 电子游戏
 *
 * @package app\common
 */
class Casino
{
    private static $_casino = [];

    private static $_slots = [];

    const PID_AG_HUNTER = 6;

    /**
     * counts 真人视讯 & 电子游戏注单统计
     *
     * @param $uid
     * @param $startTime
     * @param $endTime
     * @param string $type
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function counts($uid, $startTime, $endTime, $type = 'casino')
    {
        $startTime = strtotime($startTime.' 00:00:00');
        $endTime = strtotime($endTime.' 23:59:59');
        $key = $uid.'_'.$startTime.'_'.$endTime;
        if (! array_key_exists($key, self::$_casino) || ! array_key_exists($key, self::$_slots)) {
            $return = [
                'slots' => [
                    'rowCount' => 0,
                    'betAmount' => 0,
                    'netAmount' => 0,
                ],
                'casino' => [
                    'rowCount' => 0,
                    'betAmount' => 0,
                    'netAmount' => 0,
                ],
            ];
            $casino = Common::get_casino_list();
            $db = new Db1_daily_report;
            $db->where('uid', $uid);
            $db->whereBetween('report_date', [$startTime, $endTime]);
            $db->field('platform_id,bet_amount,net_amount,rows_num');
            $rows = $db->select();
            foreach ($rows as $row) {
                if (array_key_exists($row['platform_id'], $casino)) {
                    $gameType = $casino[$row['platform_id']]['type'] == 'slots' ? 'slots' : 'casino';
                    $return[$gameType]['netAmount'] += $row['net_amount'];
                    $return[$gameType]['betAmount'] += $row['bet_amount'];
                    $return[$gameType]['rowCount'] += $row['rows_num'];
                }
            }
            self::$_casino[$key] = $return['casino'];
            self::$_slots[$key] = $return['slots'];
        }

        if ($type == 'slots') {
            return self::$_slots[$key];
        } else {
            return self::$_casino[$key];
        }
    }

    /**
     * report 真人视讯 & 电子游戏下注记录
     *
     * @param $uid
     * @param $startTime
     * @param $endTime
     * @param $pid
     * @param $limit
     * @return array
     * @throws \think\exception\DbException
     */
    public static function report($uid, $startTime, $endTime, $pid, $limit)
    {
        $return = [];
        $casino = Common::get_casino_list();
        if (array_key_exists($pid, $casino)) {
            if ($pid == self::PID_AG_HUNTER) {
                $return = self::_hunterReport($uid, $startTime, $endTime, $limit);
            } else {
                $return = self::_commonReport($casino[$pid], $uid, $startTime, $endTime, $limit);
            }
        }

        return $return;
    }

    /**
     * getStatus 获取游戏平台状态
     *
     * @param $type
     * @param bool $bool
     * @return array|bool
     * @throws \think\exception\DbException
     */
    public static function getStatus($type, $bool = false)
    {
        $return = [
            'close' => false,
            'msg' => null,
        ];
        $list = Common::get_casino_transfer();
        if (array_key_exists($type, $list) && isset($list[$type]['closeId']) && $list[$type]['closeId'] > 0) {
            $rows = Db5_aibo_close_game::get($list[$type]['closeId']);
            if ($rows && $rows['status'] == 1) {
                $return['close'] = true;
                $return['msg'] = ! empty($rows['title']) ? $rows['title'] : null;
            }
        }

        return $bool ? $return['close'] : $return;
    }

    /**
     * transfer 额度转换
     *
     * @param $uid
     * @param string $out
     * @param string $in
     * @param int $money
     * @param bool $all
     * @return array
     * @throws \think\exception\DbException
     */
    public static function transfer($uid, $out = 'SYSTEM', $in = 'SYSTEM', $money = 0, $all = false)
    {
        $return = [
            'result' => false,
            'msg' => null,
        ];
        $money = floatval($money);
        $list = Common::get_casino_transfer();
        switch (true) {
            case $out == $in:
                $return['msg'] = Constant::CASINO_CAN_NOT_SAME_PLATFORM;
                break;

            case ! $all && $money != intval($money):
                $return['msg'] = Constant::CASINO_ONLY_INTEGER_MONEY;
                break;

            case ! $all && $money <= 0:
                $return['msg'] = Constant::CASINO_INVALID_TRANSFER_MONEY;
                break;

            case empty($out) || empty($in):
            case $out != 'SYSTEM' && ! array_key_exists($out, $list):
            case $in != 'SYSTEM' && ! array_key_exists($in, $list):
            case self::getStatus($out, true) || self::getStatus($in, true):
                $return['msg'] = Constant::INVALID_CASINO;
                break;

            default:
                /* 安全引用 Start */
                $error_reporting = ini_get('error_reporting'); // 原错误报告类型
                $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT']; // 原文档目录
                error_reporting(E_ALL & ~E_NOTICE); // 忽略 NOTICE 错误
                $ob_status = ob_get_status();
                if (empty($ob_status)) {
                    ob_start(); // 开启缓存区
                }
                $_SERVER['DOCUMENT_ROOT'] = realpath(ROOT_PATH.'/../'); // 设置 DOCUMENT_ROOT 路径
                $db_user_utf8 = $db_user_gbk = Config::get('database.username'); // 设置数据库账户
                $db_pwd_utf8 = $db_pwd_gbk = Config::get('database.password'); // 设置数据库密码
                include(APP_PATH.'/../../cj/live/live_giro.php'); // 正式引入文件
                $GLOBALS['C_Patch'] = &$C_Patch; // 将 $C_Patch 定义为全局变量
                $GLOBALS['mydata1_db'] = &$mydata1_db; // 将 $mydata1_db 定义为全局变量
                $GLOBALS['client'] = &$client; // 将 $client 定义为全局变量
                $GLOBALS['site_id'] = &$site_id; // 将 $site_id 定义为全局变量

                if ($out != 'SYSTEM') {
                    $func = isset($list[$out]['func']) && ! empty($list[$out]['func']) ? $list[$out]['func'] : 'giro';
                    $return['msg'] = $func($uid, $out, 'OUT', $money, $in == 'SYSTEM' && $all);
                }
                if ($in != 'SYSTEM' && ($out == 'SYSTEM' || $return['msg'] == 'ok')) {
                    $func = isset($list[$in]['func']) && ! empty($list[$in]['func']) ? $list[$in]['func'] : 'giro';
                    $return['msg'] = $func($uid, $in, 'IN', $money);
                }
                error_reporting($error_reporting); // 恢复原错误报告类型
                $_SERVER['DOCUMENT_ROOT'] = $DOCUMENT_ROOT; // 恢复原文档目录
                if (empty($ob_status)) {
                    ob_end_clean(); // 清理并关闭缓存区
                } else {
                    ob_clean(); // 清理缓存区
                }
                /* 安全引用 End */
                $return['result'] = $return['msg'] == 'ok';
                break;
        }

        return $return;
    }

    /**
     * transferReport 额度转换记录
     *
     * @param $uid
     * @param $startTime
     * @param $endTime
     * @param string $platform
     * @param int $limit
     * @param string $type
     * @return array
     * @throws \think\exception\DbException
     */
    public static function transferReport($uid, $startTime, $endTime, $platform = 'ALL', $limit = 10, $type = 'ALL')
    {
        $return = [
            'data' => [],
            'page' => [],
        ];
        $type = strtoupper($type);
        $db = new Db1_ag_zhenren_zz;
        $db->where('uid', $uid);
        $db->whereBetween('zz_time', [$startTime.' 00:00:00', $endTime.' 23:59:59']);
        if (strtoupper($platform) != 'ALL') {
            $db->where('live_type', $platform);
        }
        if ($type != 'ALL') {
            $db->where('zz_type', $type);
        }
        $db->order('id', 'DESC');
        $rows = $db->paginate($limit);
        $return['page'] = $rows->render();
        foreach ($rows as $row) {
            $row['zz_time'] = explode(' ', $row['zz_time']);
            $return['data'][] = [
                'id' => $row['id'],
                'orderId' => $row['billno'],
                'date' => $row['zz_time'][0],
                'time' => $row['zz_time'][1],
                'platform' => $row['live_type'],
                'type' => $row['zz_type'],
                'money' => $row['zz_money'],
                'status' => $row['ok'],
                'result' => $row['result'],
            ];
        }

        return $return;
    }

    /**
     * _commonReport 通用真人视讯下注记录
     *
     * @param $platform
     * @param $uid
     * @param $startTime
     * @param $endTime
     * @param $limit
     * @return array
     * @throws \think\exception\DbException
     */
    private static function _commonReport($platform, $uid, $startTime, $endTime, $limit)
    {
        $return = [
            'data' => [],
            'page' => [],
        ];
        $db = new Db1_commonbetdetail;
        $db->table($platform['tableName']);
        $db->where('uid', $uid);
        $db->whereBetween('betTime', [$startTime.' 00:00:00', $endTime.' 23:59:59']);
        $db->order('betTime', 'DESC');
        $db->order('id', 'DESC');
        $rows = $db->paginate($limit);
        $return['page'] = $rows->render();
        foreach ($rows as $row) {
            $row['betTime'] = explode(' ', $row['betTime']);
            $content = [$row['gameType']];
            if (! empty($row['playType']) && $row['playType'] != 'null') {
                $content[] = $row['playType'];
            }
            if ($row->offsetExists('result') && ! empty($row['result']) && $row['result'] != 'null') {
                $result = $row['result'];
            } else {
                switch (true) {
                    case $row['betAmount'] == 0:
                        $result = '无效';
                        break;

                    case $row['netAmount'] == 0:
                        $result = '和局';
                        break;

                    case $row['netAmount'] > 0:
                        $result = '赢';
                        break;

                    default:
                        $result = '输';
                        break;
                }
            }
            $return['data'][] = [
                'id' => $row['billNo'],
                'expect' => empty($row['gameCode']) ? '-' : $row['gameCode'],
                'date' => $row['betTime'][0],
                'time' => $row['betTime'][1],
                'betMoney' => $row['betAmount'],
                'validMoney' => $row['validBetAmount'],
                'winLoseMoney' => $row['netAmount'],
                'betContent' => $content,
                'status' => $row['flag'],
                'result' => $result,
            ];
        }

        return $return;
    }

    /**
     * _hunterReport AG 捕鱼王下注记录
     *
     * @param $uid
     * @param $startTime
     * @param $endTime
     * @param $limit
     * @return array
     * @throws \think\exception\DbException
     */
    private static function _hunterReport($uid, $startTime, $endTime, $limit)
    {
        $return = [
            'data' => [],
            'page' => [],
        ];
        $db = new Db1_hunterbetdetail;
        $db->where('uid', $uid);
        $db->whereBetween('creationTime', [$startTime.' 00:00:00', $endTime.' 23:59:59']);
        $db->order('creationTime', 'DESC');
        $db->order('id', 'DESC');
        $rows = $db->paginate($limit);
        $return['page'] = $rows->render();
        foreach ($rows as $row) {
            $row['creationTime'] = explode(' ', $row['creationTime']);
            switch (true) {
                case $row['Cost'] == 0 && $row['Earn'] == 0:
                    $result = '无效';
                    break;

                case $row['transferAmount'] == 0:
                    $result = '和局';
                    break;

                case $row['transferAmount'] > 0:
                    $result = '赢';
                    break;

                default:
                    $result = '输';
                    break;
            }
            $return['data'][] = [
                'id' => $row['tradeNo'],
                'expect' => empty($row['sceneId']) ? '-' : $row['sceneId'],
                'date' => $row['creationTime'][0],
                'time' => $row['creationTime'][1],
                'betMoney' => $row['Cost'],
                'validMoney' => $row['Cost'],
                'winLoseMoney' => $row['transferAmount'],
                'betContent' => [
                    $row['ctype'],
                    $row['Roomid'].' 房间',
                    $row['Roombet'].' 倍场',
                ],
                'status' => '已结算',
                'result' => $result,
            ];
        }

        return $return;
    }
}