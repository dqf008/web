<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/4/27
 * Time: 15:11
 */

namespace app\common;

use app\common\model\Db1_c_bet;
use app\common\model\Db1_c_bet_3;
use app\common\model\Db1_c_bet_choose5;
use app\common\model\Db1_c_bet_data;
use app\common\model\Db1_lottery_data;
use app\common\model\Db2_ka_tan;

/**
 * Class Lottery 系统彩票
 *
 * @package app\common
 */
class Lottery
{
    const TYPE_CQSSC = '重庆时时彩';
    const TYPE_TJSSC = '天津时时彩';
    const TYPE_XJSSC = '新疆时时彩';
    const TYPE_PK10 = '北京赛车PK拾';
    const TYPE_GDKL10 = '广东快乐10分';
    const TYPE_XYFT = '幸运飞艇';
    const TYPE_JSSC = 'JSSC';
    const TYPE_JSSSC = 'JSSSC';
    const TYPE_JSLH = 'JSLH';
    const TYPE_KL8 = 'KL8';
    const TYPE_SHSSL = 'SSL';
    const TYPE_3D = '3d';
    const TYPE_PL3 = 'pl3';
    const TYPE_QXC = 'qxc';
    const TYPE_JSK3 = 'jsk3';
    const TYPE_FJK3 = 'fjk3';
    const TYPE_GXK3 = 'gxk3';
    const TYPE_AHK3 = 'ahk3';
    const TYPE_SHK3 = 'shk3';
    const TYPE_HBK3 = 'hbk3';
    const TYPE_HEBK3 = 'hebk3';
    const TYPE_JLK3 = 'jlk3';
    const TYPE_GZK3 = 'gzk3';
    const TYPE_BJK3 = 'bjk3';
    const TYPE_GSK3 = 'gsk3';
    const TYPE_NMGK3 = 'nmgk3';
    const TYPE_JXK3 = 'jxk3';
    const TYPE_FFK3 = 'ffk3';
    const TYPE_SFK3 = 'sfk3';
    const TYPE_WFK3 = 'WFk3';
    const TYPE_PCDD = 'pcdd';
    const TYPE_CQKL10 = '重庆快乐10分';
    const TYPE_TJKL10 = '天津快乐10分';
    const TYPE_HNKL10 = '湖南快乐10分';
    const TYPE_SXKL10 = '山西快乐10分';
    const TYPE_YNKL10 = '云南快乐10分';
    const TYPE_GDSYXW = 'gdsyxw';
    const TYPE_SDSYXW = 'sdsyxw';
    const TYPE_FJSYXW = 'fjsyxw';
    const TYPE_BJSYXW = 'bjsyxw';
    const TYPE_AHSYXW = 'ahsyxw';

    /**
     * counts 系统彩票下注统计
     *
     * @param $uid
     * @param $username
     * @param $startTime
     * @param $endTime
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function counts($uid, $username, $startTime, $endTime)
    {
        $dates = [$startTime.' 00:00:00', $endTime.' 23:59:59'];
        $times = [strtotime($startTime.' 00:00:00'), strtotime($endTime.' 23:59:59')];
        // 彩票游戏：c_bet、c_bet_3
        $rows1 = self::_cBetCounts($uid, $dates, 0);
        $rows2 = self::_cBetCounts($uid, $dates, 1);

        // 彩票游戏：c_bet_data
        $rows3 = self::_cBetDateCounts($uid, $times);

        // 彩票游戏：lottery_data
        $rows4 = self::_lotteryDataCounts($username, $dates);

        // 彩票游戏：mydata2_db.ka_tan
        $rows5 = self::_kaTanCounts($username, $times);

        return Common::sum_arrays($rows1, $rows2, $rows3, $rows4, $rows5);
    }

    /**
     * report 系统彩票下注记录
     *
     * @param $uid
     * @param $username
     * @param $startTime
     * @param $endTime
     * @param null $type
     * @param int $limit
     * @param int $status
     * @return array
     * @throws \think\exception\DbException
     */
    public static function report($uid, $username, $startTime, $endTime, $type = null, $limit = 10, $status = 0)
    {
        $return = [];
        $lottery = Common::get_lottery_list(true);
        if (array_key_exists($type, $lottery)) {
            $dates = [$startTime.' 00:00:00', $endTime.' 23:59:59'];
            $limit = $limit <= 0 ? 1 : ($limit > 100 ? 100 : $limit);
            $status = intval($status);
            switch ($type) {
                case 'cqssc':
                    $return = self::_cBetReport($uid, $dates, self::TYPE_CQSSC, $limit, $status);
                    break;

                case 'pk10':
                    $return = self::_cBetReport($uid, $dates, self::TYPE_PK10, $limit, $status);
                    break;

                case 'gdkl10':
                    $return = self::_cBetReport($uid, $dates, self::TYPE_GDKL10, $limit, $status);
                    break;

                case 'xyft':
                    $return = self::_cBetReport($uid, $dates, self::TYPE_XYFT, $limit, $status);
                    break;

                case 'jssc':
                    $return = self::_cBetDataReport($uid, $dates, self::TYPE_JSSC, $limit, $status);
                    break;

                case 'jsssc':
                    $return = self::_cBetDataReport($uid, $dates, self::TYPE_JSSSC, $limit, $status);
                    break;

                case 'jslh':
                    $return = self::_cBetDataReport($uid, $dates, self::TYPE_JSLH, $limit, $status);
                    break;

                case 'ffk3':
                    $return = self::_cBetDataReport($uid, $dates, self::TYPE_FFK3, $limit, $status);
                    break;

                case 'sfk3':
                    $return = self::_cBetDataReport($uid, $dates, self::TYPE_SFK3, $limit, $status);
                    break;

                case 'wfk3':
                    $return = self::_cBetDataReport($uid, $dates, self::TYPE_WFK3, $limit, $status);
                    break;

                case 'shssl':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_SHSSL, $limit, $status);
                    break;

                case 'pl3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_PL3, $limit, $status);
                    break;

                case '3d':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_3D, $limit, $status);
                    break;

                case 'kl8':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_KL8, $limit, $status);
                    break;

                case 'qxc':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_QXC, $limit, $status);
                    break;

                case 'marksix':
                    $return = self::_kaTanReport($username, $dates, $limit, $status);
                    break;

                case 'tjssc':
                    $return = self::_cBetReport($uid, $dates, self::TYPE_TJSSC, $limit, $status);
                    break;

                case 'xjssc':
                    $return = self::_cBetReport($uid, $dates, self::TYPE_XJSSC, $limit, $status);
                    break;

                case 'jsk3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_JSK3, $limit, $status);
                    break;

                case 'fjk3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_FJK3, $limit, $status);
                    break;

                case 'gxk3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_GXK3, $limit, $status);
                    break;

                case 'ahk3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_AHK3, $limit, $status);
                    break;

                case 'shk3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_SHK3, $limit, $status);
                    break;

                case 'hbk3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_HBK3, $limit, $status);
                    break;

                case 'hebk3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_HEBK3, $limit, $status);
                    break;

                case 'jlk3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_JLK3, $limit, $status);
                    break;

                case 'gzk3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_GZK3, $limit, $status);
                    break;

                case 'bjk3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_BJK3, $limit, $status);
                    break;

                case 'gsk3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_GSK3, $limit, $status);
                    break;

                case 'nmgk3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_NMGK3, $limit, $status);
                    break;

                case 'jxk3':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_JXK3, $limit, $status);
                    break;

                case 'pcdd':
                    $return = self::_cLotteryDataReport($username, $dates, self::TYPE_PCDD, $limit, $status);
                    break;

                case 'cqkl10':
                    $return = self::_cBetReport($uid, $dates, self::TYPE_CQKL10, $limit, $status);
                    break;

                case 'tjkl10':
                    $return = self::_cBetReport($uid, $dates, self::TYPE_TJKL10, $limit, $status);
                    break;

                case 'hnkl10':
                    $return = self::_cBetReport($uid, $dates, self::TYPE_HNKL10, $limit, $status);
                    break;

                case 'sxkl10':
                    $return = self::_cBetReport($uid, $dates, self::TYPE_SXKL10, $limit, $status);
                    break;

                case 'ynkl10':
                    $return = self::_cBetReport($uid, $dates, self::TYPE_YNKL10, $limit, $status);
                    break;

                case 'gdsyxw':
                    $return = self::_cBetchoose5Report($uid, $dates, self::TYPE_GDSYXW, $limit, $status);
                    break;

                case 'sdsyxw':
                    $return = self::_cBetchoose5Report($uid, $dates, self::TYPE_SDSYXW, $limit, $status);
                    break;

                case 'fjsyxw':
                    $return = self::_cBetchoose5Report($uid, $dates, self::TYPE_FJSYXW, $limit, $status);
                    break;

                case 'bjsyxw':
                    $return = self::_cBetchoose5Report($uid, $dates, self::TYPE_BJSYXW, $limit, $status);
                    break;

                case 'ahsyxw':
                    $return = self::_cBetchoose5Report($uid, $dates, self::TYPE_AHSYXW, $limit, $status);
                    break;
            }
        }

        return $return;
    }

    /**
     * _cBetCounts c_bet & c_bet_3 下注统计
     *
     * @param $uid
     * @param $dates
     * @param int $type
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private static function _cBetCounts($uid, $dates, $type = 0)
    {
        $return = [
            'rowCount' => 0,
            'betAmount' => 0,
            'netAmount' => 0,
        ];
        if ($type == 1) {
            $db = new Db1_c_bet_3;
        } else {
            $db = new Db1_c_bet;
        }
        $db->where('uid', $uid);
        $db->whereBetween('addtime', $dates);
        $db->where('js', 1);
        $db->field('money,win');
        $rows = $db->select();
        foreach ($rows as $row) {
            $return['rowCount']++;
            $return['netAmount'] += $row['win'];
            $return['betAmount'] += $row['money'];
            if ($row['win'] > 0) {
                $return['netAmount'] -= $row['money'];
            }
        }
        return $return;
    }


    /**
     * _cBetDateCounts c_bet_data 下注统计
     *
     * @param $uid
     * @param $times
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private static function _cBetDateCounts($uid, $times)
    {
        $return = [
            'rowCount' => 0,
            'betAmount' => 0,
            'netAmount' => 0,
        ];
        $db = new Db1_c_bet_data;
        $db->where('uid', $uid);
        $db->whereBetween('addtime', $times);
        $db->where('status', 1);
        $db->field('money,win');
        $rows = $db->select();
        foreach ($rows as $row) {
            $return['rowCount']++;
            $return['netAmount'] += $row['win'];
            $return['betAmount'] += $row['money'];
            if ($row['win'] > 0) {
                $return['netAmount'] -= $row['money'];
            }
        }

        return $return;
    }

    /**
     * _lotteryDataCounts lottery_data 下注统计
     *
     * @param $username
     * @param $dates
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private static function _lotteryDataCounts($username, $dates)
    {
        $return = [
            'rowCount' => 0,
            'betAmount' => 0,
            'netAmount' => 0,
        ];
        $db = new Db1_lottery_data;
        $db->where('username', $username);
        $db->whereBetween('bet_time', $dates);
        $db->where('bet_ok', 1);
        $db->field('money,win');
        $rows = $db->select();
        foreach ($rows as $row) {
            $return['rowCount']++;
            $return['netAmount'] += $row['win'];
            $return['betAmount'] += $row['money'];
        }

        return $return;
    }

    /**
     * _kaTanCounts ka_tan 下注统计
     *
     * @param $username
     * @param $times
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private static function _kaTanCounts($username, $times)
    {
        $return = [
            'rowCount' => 0,
            'betAmount' => 0,
            'netAmount' => 0,
        ];
        $dates = [
            date('Y-m-d H:i:s', $times[0] + 43200),
            date('Y-m-d H:i:s', $times[1] + 43200),
        ];
        $db = new Db2_ka_tan;
        $db->where('username', $username);
        $db->whereBetween('adddate', $dates);
        $db->where('checked', 1);
        $db->where('bm', '<>', 2);
        $db->field('sum_m,rate,bm');
        $rows = $db->select();
        foreach ($rows as $row) {
            $return['rowCount']++;
            if ($row['bm'] == 1) {
                $return['netAmount'] += $row['sum_m'] * $row['rate'];
            }
            $return['netAmount'] -= $row['sum_m'];
            $return['betAmount'] += $row['sum_m'];
        }

        return $return;
    }

    /**
     * _cBetReport c_bet & c_bet3 下注记录
     *
     * @param $uid
     * @param $dates
     * @param $type
     * @param int $limit
     * @param int $status
     * @return array
     * @throws \think\exception\DbException
     */
    private static function _cBetReport($uid, $dates, $type, $limit = 10, $status = 0)
    {
        $return = [
            'data' => [],
            'page' => [],
        ];
        if ($type == self::TYPE_CQSSC || $type == self::TYPE_TJSSC || $type == self::TYPE_XJSSC) {
            $db = new Db1_c_bet;
        } else {
            $db = new Db1_c_bet_3;
        }
        $db->where('type', $type);
        $db->where('uid', $uid);
        $db->whereBetween('addtime', $dates);
        if ($status > 0) {
            if ($status == 1) {
                $db->where('js', 1);
            } else {
                $db->where('js', 0);
            }
        }
        $db->order('id', 'DESC');
        $rows = $db->paginate($limit);
        $return['page'] = $rows->render();
        foreach ($rows as $row) {
            $row['addtime'] = explode(' ', $row['addtime']);
            $return['data'][] = [
                'id' => $row['id'],
                'expect' => $row['qishu'],
                'date' => $row['addtime'][0],
                'time' => $row['addtime'][1],
                'betMoney' => $row['money'],
                'winLoseMoney' => $row['win'] > 0 ? $row['win'] - $row['money'] : $row['win'],
                'betContent' => [$row['mingxi_1'], $row['mingxi_2']],
                'odds' => $row['odds'],
                'status' => $row['js'],
            ];
        }
        return $return;
    }

    /**
     * _cBetchoose5Report c_bet_choose5 下注记录
     *
     * @param $uid
     * @param $dates
     * @param $type
     * @param int $limit
     * @param int $status
     * @return array
     * @throws \think\exception\DbException
     */
    private static function _cBetchoose5Report($uid, $dates, $type, $limit, $status)
    {
        $return = [
            'data' => [],
            'page' => [],
        ];
        $db = new Db1_c_bet_choose5;
        $db->where('type', $type);
        $db->where('uid', $uid);
        $db->whereBetween('addtime', $dates);
        if ($status > 0) {
            if ($status == 1) {
                $db->where('js', 1);
            } else {
                $db->where('js', 0);
            }
        }
        $db->order('id', 'DESC');
        $rows = $db->paginate($limit);
        $return['page'] = $rows->render();
        foreach ($rows as $row) {
            $row['addtime'] = explode(' ', $row['addtime']);
            $return['data'][] = [
                'id' => $row['id'],
                'expect' => $row['qishu'],
                'date' => $row['addtime'][0],
                'time' => $row['addtime'][1],
                'betMoney' => $row['money'],
                'winLoseMoney' => $row['win'] > 0 ? $row['win'] - $row['money'] : $row['win'],
                'betContent' => [$row['mingxi_1'], $row['mingxi_2']],
                'odds' => $row['odds'],
                'status' => $row['js'],
            ];
        }
        return $return;
    }


    /**
     * _cBetDataReport c_bet_data 下注记录
     *
     * @param $uid
     * @param $dates
     * @param $type
     * @param $limit
     * @param $status
     * @return array
     * @throws \think\exception\DbException
     */
    private static function _cBetDataReport($uid, $dates, $type, $limit, $status)
    {
        $return = [
            'data' => [],
            'page' => [],
        ];
        $times = [
            strtotime($dates[0]),
            strtotime($dates[1]),
        ];
        $db = new Db1_c_bet_data;
        $db->where('type', $type);
        $db->where('uid', $uid);
        $db->whereBetween('addtime', $times);
        if ($status > 0) {
            if ($status == 1) {
                $db->where('status', 1);
            } else {
                $db->where('status', 0);
            }
        } else {
            $db->whereBetween('status', [0, 1]);
        }
        $db->order('id', 'DESC');
        $rows = $db->paginate($limit);
        $return['page'] = $rows->render();
        foreach ($rows as $row) {
            $return['data'][] = [
                'id' => $row['id'],
                'expect' => $row['value']['qishu'],
                'date' => date('Y-m-d', $row['addtime']),
                'time' => date('H:i:s', $row['addtime']),
                'betMoney' => $row['money'],
                'winLoseMoney' => ($row['win'] > 0 ? $row['win'] - $row['money'] : $row['win']),
                'betContent' => $row['value']['class'],
                'odds' => $row['value']['odds'],
                'status' => $row['status'],
            ];
        }

        return $return;
    }

    /**
     * _cLotteryDataReport lottery_data 下注记录
     *
     * @param $username
     * @param $dates
     * @param $type
     * @param $limit
     * @param $status
     * @return array
     * @throws \think\exception\DbException
     */
    private static function _cLotteryDataReport($username, $dates, $type, $limit, $status)
    {
        $return = [
            'data' => [],
            'page' => [],
        ];
        $db = new Db1_lottery_data;
        $db->where('atype', $type);
        $db->where('username', $username);
        $db->whereBetween('bet_time', $dates);
        if ($status > 0) {
            if ($status == 1) {
                $db->where('bet_ok', 1);
            } else {
                $db->where('bet_ok', 0);
            }
        }
        $db->order('id', 'DESC');
        $rows = $db->paginate($limit);
        $return['page'] = $rows->render();
        foreach ($rows as $row) {
            $row['bet_time'] = explode(' ', $row['bet_time']);
            $row['money'] = floatval($row['money']);
            $row['win'] = floatval($row['win']);
            $row['odds'] = floatval($row['odds']);
            if ($row['atype'] == 'qxc') {
                if ($row['btype'] == '定位') {
                    $row['ctype'] = explode('/', $row['ctype']);
                    $row['dtype'] .= ' - '.$row['ctype'][0].'注 - '.sprintf('%.2f', $row['ctype'][1]).'/注';
                }
                $row['content'] = [$row['dtype'], $row['content']];
            } else {
                $row['win'] > 0 && $row['win'] += $row['money'];
                $row['atype'] != 'kl8' && $row['btype'] .= ' - '.$row['ctype'].' - '.$row['dtype'];
                $row['content'] = [$row['btype'], $row['content']];
            }
            $return['data'][] = [
                'id' => $row['uid'],
                'expect' => $row['mid'],
                'date' => $row['bet_time'][0],
                'time' => $row['bet_time'][1],
                'betMoney' => $row['money'],
                'winLoseMoney' => $row['win'],
                'betContent' => $row['content'],
                'odds' => $row['odds'],
                'status' => $row['bet_ok'],
            ];
        }

        return $return;
    }

    /**
     * _kaTanReport ka_tan 下注记录
     *
     * @param $username
     * @param $dates
     * @param $limit
     * @param $status
     * @return array
     * @throws \think\exception\DbException
     */
    private static function _kaTanReport($username, $dates, $limit, $status)
    {
        $return = [
            'data' => [],
            'page' => [],
        ];
        $dates = [
            date('Y-m-d H:i:s', strtotime($dates[0]) + 43200),
            date('Y-m-d H:i:s', strtotime($dates[1]) + 43200),
        ];
        $db = new Db2_ka_tan;
        $db->where('username', $username);
        $db->whereBetween('adddate', $dates);
        if ($status > 0) {
            if ($status == 1) {
                $db->where('checked', 1);
            } else {
                $db->where('checked', 0);
            }
        }
        $db->order('id', 'DESC');
        $rows = $db->paginate($limit);
        $return['page'] = $rows->render();
        foreach ($rows as $row) {
            $row['adddate'] = date('Y-m-d H:i:s', strtotime($row['adddate']) - 43200);
            $row['adddate'] = explode(' ', $row['adddate']);
            $row['win'] = $row['sum_m'] * $row['rate'];
            if ($row['class1'] == '过关') {
                $row['class2'] = explode(',', $row['class2']);
                $row['class3'] = explode(',', $row['class3']);
                $row['class4'] = [];
                foreach ($row['class2'] as $key => $val) {
                    if (! empty($val)) {
                        $key *= 2;
                        $row['class4'][] = $val.'-'.$row['class3'][$key].'@'.$row['class3'][$key + 1];
                    }
                }
                $row['content'] = [$row['class1'], implode(',', $row['class4'])];
            } else {
                $row['content'] = [
                    $row['class1'].' - '.$row['class2'],
                    $row['class3'],
                ];
            }
            if ($row['checked'] == 1) {
                if ($row['bm'] == 2) {
                    $row['win'] = 0;
                } else {
                    if ($row['bm'] == 1) {
                        $row['win'] -= $row['sum_m'];
                    } else {
                        $row['win'] = -1 * $row['sum_m'];
                    }
                }
            }
            $return['data'][] = [
                'id' => $row['num'],
                'expect' => $row['kithe'],
                'date' => $row['adddate'][0],
                'time' => $row['adddate'][1],
                'betMoney' => $row['sum_m'],
                'winLoseMoney' => $row['win'],
                'betContent' => $row['content'],
                'odds' => $row['rate'],
                'status' => $row['checked'],
            ];
        }

        return $return;
    }
}