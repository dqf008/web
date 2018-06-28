<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/4/27
 * Time: 12:56
 */

namespace app\common;

use app\common\model\Db1_k_bet;
use app\common\model\Db1_k_bet_cg;
use app\common\model\Db1_k_bet_cg_group;
use app\common\model\Db4_t_guanjun;

/**
 * Class Sports 系统体育
 *
 * @package app\common
 */
class Sports
{
    /**
     * counts 系统体育下注统计
     *
     * @param $uid
     * @param $startTime
     * @param $endTime
     * @param bool $checkout
     * @param string $type
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function counts($uid, $startTime, $endTime, $checkout = false, $type = 'single')
    {
        $return = [
            'rowCount' => 0,
            'betAmount' => 0,
            'netAmount' => 0,
        ];
        $dates = [$startTime.' 00:00:00', $endTime.' 23:59:59'];
        if ($type == 'multiple') {
            // 体育串关
            $db = new Db1_k_bet_cg_group;
            if ($checkout) {
                $db->whereIn('status', [1, 3]);
            } else {
                $db->whereBetween('status', [0, 4]);
            }
        } else {
            // 体育单式
            $db = new Db1_k_bet;
            if ($checkout) {
                $db->whereIn('status', [1, 2, 4, 5]);
            } else {
                $db->whereBetween('status', [0, 8]);
            }
        }
        $db->where('uid', $uid);
        if (! empty($dates)) {
            $db->whereBetween('bet_time', $dates);
        }
        $db->field('win,bet_money');
        $rows = $db->select();
        foreach ($rows as $row) {
            $return['rowCount']++;
            $return['netAmount'] += $row['win'] - $row['bet_money'];
            $return['betAmount'] += $row['bet_money'];
        }

        return $return;
    }

    /**
     * sportsReport 体育下注详情
     *
     * @param $uid
     * @param $startTime
     * @param $endTime
     * @param int $status
     * @param int $limit
     * @param string $type
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function report($uid, $startTime, $endTime, $type = 'single', $limit = 10, $status = 0)
    {
        $dates = [$startTime.' 00:00:00', $endTime.' 23:59:59'];
        $limit = $limit <= 0 ? 1 : ($limit > 100 ? 100 : $limit);
        $status = intval($status);

        if ($type == 'multiple') {
            $return = self::_multipleReport($uid, $dates, $limit);
        } else {
            $return = self::_singleReport($uid, $dates, $limit, $status);
        }

        return $return;
    }

    /**
     * _singleReport 体育单式
     *
     * @param $uid
     * @param $dates
     * @param int $status
     * @param int $limit
     * @return array
     * @throws \think\exception\DbException
     */
    private static function _singleReport($uid, $dates, $limit = 10, $status = 0)
    {
        $return = [
            'page' => [],
            'data' => [],
        ];
        $match_result = [];
        $db = new Db1_k_bet;
        $db->where('uid', $uid)->whereBetween('bet_time', $dates)->order('bid', 'DESC');
        switch ($status) {
            case 1:
                $db->whereIn('status', [1, 2, 4, 5, 8]); // 已结算
                break;

            case 2:
                $db->where('status', 0); // 未结算
                break;

            case 3:
                $db->whereIn('status', [3, 6, 7]); // 注单取消
                break;

            default:
                $db->whereBetween('status', [0, 8]); // 全部
                break;
        }
        $rows = $db->paginate($limit);
        $return['page'] = $rows->render();
        foreach ($rows as $row) {
            $row['bet_time'] = explode(' ', $row['bet_time']);
            $row['match_showtype'] = strtolower($row['match_showtype']);
            $temp = explode('-', $row['bet_info']);
            if (isset($temp[3])) {
                $temp[2] = preg_replace('[\[(.*)\]]', '', $temp[2].$temp[3]);
                unset($temp[3]);
            }
            // 如果是波胆
            if (strpos($temp[0], '胆')) {
                $bodan_score = explode('@', $temp[1], 2);
                $row['score'] = $bodan_score[0];
                $temp[1] = '波胆@'.$bodan_score[1];
            }
            $is_other = in_array($row['ball_sort'], ['冠军', '金融']);
            $row['remark'] = $row['match_name'];
            if ($row['match_type'] == 2) {
                $row['remark'] .= ' '.$row['match_time'];
                if (strpos($row['ball_sort'], '滚球') == false) {
                    if ($row['match_nowscore'] == '') {
                        $row['remark'] .= ' (0:0)';
                    } else {
                        if ($row['match_showtype'] == 'h') {
                            $row['remark'] .= ' ('.$row['match_nowscore'].')';
                        } else {
                            $row['remark'] .= ' ('.strrev($row['match_nowscore']).')';
                        }
                    }
                }
            }
            $row['remark'] .= '<br />';
            $row['team'] = explode(strpos($row['master_guest'], 'VS.') ? 'VS.' : 'VS', $row['master_guest']);
            if (strpos($temp[1], '让') > 0) {
                if ($row['match_showtype'] == 'c') {
                    $row['remark'] .= $row['team'][1];
                    $row['remark'] .= ' '.str_replace(['主让', '客让'], ['', ''], $temp[1]).' ';
                    $row['remark'] .= $row['team'][0].'(主)';
                } else { //主让
                    $row['remark'] .= $row['team'][0];
                    $row['remark'] .= ' '.str_replace(['主让', '客让'], ['', ''], $temp[1]).' ';
                    $row['remark'] .= $row['team'][1];
                }
                $temp[1] = '';
            } else {
                $row['remark'] .= $row['team'][0];
                if (isset($row['score'])) {
                    $row['remark'] .= ' '.$row['score'].' ';
                } else {
                    if ($row['team'][1] != '') {
                        $row['remark'] .= ' VS ';
                    }
                }
                $row['remark'] .= $row['team'][1];
            }
            $row['remark'] .= '<br />';
            //半全场替换显示
            if ($is_other) {
                $row['remark'] .= str_replace('@', ' @ ', $row['bet_info']);
            } else {
                $arraynew = [$row['team'][0], $row['team'][1], '和局', ' / ', '局'];
                $arrayold = ['主', '客', '和', '/', '局局'];
                $ss = str_replace($arrayold, $arraynew, preg_replace('[\((.*)\)]', '', end($temp)));
                $ss = explode('@', $ss);
                if ($ss[0] == '独赢') {
                    $row['remark'] .= $temp[1].' ';
                } else {
                    if (strpos($ss[0], '独赢')) {
                        $row['remark'] .= $temp[1].'-';
                    }
                }
                $row['remark'] .= str_replace(' ', '', $ss[0]);
                if ($row['match_nowscore'] != '') {
                    if ($row['match_showtype'] == 'h' || (! strrpos($temp[0], '球'))) {
                        $row['remark'] .= ' ('.$row['match_nowscore'].')';
                    } else {
                        $row['remark'] .= ' ('.strrev($row['match_nowscore']).')';
                    }
                }
                $row['remark'] .= ' @ '.$ss[1];
            }
            if (! in_array($row['status'], [0, 3, 7, 6])) {
                if ($row['match_showtype'] == 'c' && strpos('&match_ao,match_ho,match_bho,match_bao&',
                        $row['point_column']) > 0) {
                    $row['remark'] .= ' ['.$row['TG_Inball'].':'.$row['MB_Inball'].']';
                } else {
                    if ($is_other) {
                        if (! isset($match_result[$row['match_id']])) {
                            $match_result[$row['match_id']] = '';
                            $query = (new Db4_t_guanjun)->field('x_result')->where('match_id',
                                $row['match_id']);
                            if ($query) {
                                $match_result[$row['match_id']] = str_replace('<br>', ' ', $query['x_result']);
                            } else {
                                $match_result[$row['match_id']] = '';
                            }
                        }
                        if (isset($match_result[$row['match_id']]) && $match_result[$row['match_id']] != '') {
                            $row['remark'] .= ' ['.$match_result[$row['match_id']].']';
                        }
                    } else {
                        $row['remark'] .= ' ['.$row['MB_Inball'].':'.$row['TG_Inball'].']';
                    }
                }
            }
            if ($row['ball_sort'] == '足球滚球' || $row['ball_sort'] == '足球上半场滚球' || $row['ball_sort'] == '篮球滚球') {
                if ($row['lose_ok'] == 0) {
                    $row['remark'] .= ' [确认中]';
                } else {
                    if ($row['status'] == 0) {
                        $row['remark'] .= ' [已确认]';
                    }
                }
            }
            $status = [
                '未结算',
                '赢',
                '输',
                '注单无效',
                '赢一半',
                '输一半',
                '进球无效',
                '红卡取消',
                '和局',
            ];
            $return['data'][] = [
                'id' => $row['bid'],
                'expect' => $row['match_id'],
                'betMode' => $row['ball_sort'].($is_other ? '' : ' '.$temp[0]),
                'betContent' => [explode('<br />', $row['remark'])],
                'betMoney' => $row['bet_money'],
                'winMoney' => $row['bet_win'],
                'winLoseMoney' => $row['status'] == 0 ? 0 : $row['win'] - $row['bet_money'],
                'rewardMoney' => $row['fs'],
                'date' => $row['bet_time'][0],
                'time' => $row['bet_time'][1],
                'status' => $row['status'],
                'statusText' => $status[$row['status']],
            ];
        }

        return $return;
    }

    /**
     * _multipleReport 体育串关
     *
     * @param $uid
     * @param $dates
     * @param int $limit
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private static function _multipleReport($uid, $dates, $limit = 10)
    {
        $return = [
            'page' => [],
            'data' => [],
        ];
        $db = new Db1_k_bet_cg_group;
        $rows = $db->where('uid', $uid)->whereBetween('bet_time', $dates)->order('gid',
            'DESC')->whereBetween('status', [0, 4])->paginate($limit);
        foreach ($rows as $row) {
            $row['bet_time'] = explode(' ', $row['bet_time']);
            $content = [];
            $query = (new Db1_k_bet_cg)->where('gid', $row['gid'])->order('bid', 'DESC')->select();
            $row['ok_count'] = 0;
            foreach ($query as $rs) {
                // 统计已结算单式
                ! in_array($rs['status'], [0, 3]) && $row['ok_count'] = $row['ok_count'] + 1;
                $temp = explode('-', $rs['bet_info']);
                $remark = $temp[0].' '.$rs['match_name'];
                if (strpos($rs['bet_info'], ' - ')) {
                    // 篮球上半之内的,这里换成正则表达替换
                    $temp[2] = $temp[2].preg_replace('[\[(.*)\]]', '', $temp[3]);
                }
                if (isset($temp[3])) {
                    $temp[2] = preg_replace('[\[(.*)\]]', '', $temp[2].$temp[3]);
                    unset($temp[3]);
                }
                // 如果是波胆
                if (strpos($temp[0], '胆')) {
                    $bodan_score = explode('@', $temp[1], 2);
                    $rs['score'] = $bodan_score[0];
                    $temp[1] = '波胆@'.$bodan_score[1];
                }
                // 正则匹配
                $rs['team'] = explode(strpos($rs['master_guest'], 'VS.') ? 'VS.' : 'VS', $rs['master_guest']);
                preg_match('[\((.*)\)]', end($temp), $matches);
                $matches && count($matches) > 0 && $remark .= ' '.$rs['bet_time'].$matches[0];
                $remark .= '<br />';
                if (strpos($temp[1], '让') > 0) { //让球
                    if (strpos($temp[1], '主') === false) { //客让
                        $remark .= $rs['team'][1];
                        $remark .= ' '.str_replace(['主让', '客让'], ['', ''], $temp[1]).' ';
                        $remark .= $rs['team'][0].'(主)';
                    } else { //主让
                        $remark .= $rs['team'][0];
                        $remark .= ' '.str_replace(['主让', '客让'], ['', ''], $temp[1]).' ';
                        $remark .= $rs['team'][1];
                    }
                    $temp[1] = '';
                } else {
                    $remark .= $rs['team'][0];
                    $remark .= isset($rs['score']) ? $rs['score'] : ' VS ';
                    $remark .= $rs['team'][1];
                }
                $remark .= '<br />';
                if (strpos($temp[1], '@')) {
                    $remark .= str_replace('@', ' @ ', $temp[1]);
                } else {
                    $arraynew = [
                        $rs['team'][0],
                        ' / ',
                        $rs['team'][1],
                        '和局',
                        ' @ ',
                    ];
                    $arrayold = ['主', '/', '客', '和', '@'];
                    $temp[1] != '' && $remark .= $temp[1].' ';//半全场替换显示
                    $remark .= str_replace($arrayold, $arraynew, preg_replace('[\((.*)\)]', '', end($temp)));
                }
                if ($rs['status'] == 3 || $rs['MB_Inball'] < 0) {
                    $remark .= ' [取消]';
                } else {
                    if ($rs['status'] > 0) {
                        $remark .= ' ['.$rs['MB_Inball'].':'.$rs['TG_Inball'].']';
                    }
                }
                $content[] = explode('<br />', $remark);
            }
            $winLoseMoney = 0;
            if ($row['cg_count'] == $row['ok_count']) {
                if (in_array($row['status'], [1, 3])) {
                    $statusText = '已结算';
                    $winLoseMoney = $row['win'] - $row['bet_money'];
                } else {
                    $statusText = '可结算';
                }
            } else {
                $statusText = '等待单式';
            }
            $return['data'][] = [
                'id' => $row['gid'],
                'expect' => '共 '.$row['cg_count'].' 场',
                'betMode' => '体育串关 '.$row['cg_count'].'串1',
                'betContent' => $content,
                'betMoney' => $row['bet_money'],
                'winMoney' => $row['bet_win'],
                'winLoseMoney' => $winLoseMoney,
                'rewardMoney' => $row['fs'],
                'date' => $row['bet_time'][0],
                'time' => $row['bet_time'][1],
                'status' => $row['status'],
                'statusText' => $statusText,
            ];
        }

        return $return;
    }
}