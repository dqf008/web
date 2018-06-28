<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/4/27
 * Time: 17:01
 */

namespace app\common;

use app\common\model\Db1_huikuan;
use app\common\model\Db1_k_money;
use app\common\model\Db1_k_money_log;
use app\common\model\Db1_k_user;
use app\common\model\Db1_payments_group;

/**
 * Class Finance 用户财务类
 *
 * @package app\common
 */
class Finance
{
    private static $finance = [];

    /**
     * payments 获取支付通道
     *
     * @param int $gid
     * @param null $key
     * @param array $default
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function payments($gid, $key = null, $default = [])
    {
        if (! isset(self::$finance[$gid])) {
            $formType = 'web';
            if (array_key_exists('HTTP_REFERER', $_SERVER)) {
                $url = parse_url($_SERVER['HTTP_REFERER']);
                if (array_key_exists('path', $url) && substr($url['path'].'/', 0, 8) == '/mobile/') {
                    $formType = 'mobile';
                }
            }
            $keys = [
                'bank' => 'deposit',
                'wechat' => 'wechat',
                'wechat_h5' => 'wechat',
                'alipay' => 'alipay',
                'alipay_h5' => 'alipay',
                'qq' => 'qq',
                'qq_h5' => 'qq',
                'jd' => 'jd',
                'jd_h5' => 'jd',
                'unionpay' => 'unionpay',
                'unionpay_h5' => 'unionpay',
            ];
            self::$finance[$gid] = [
                'deposit' => [],
                'wechat' => [],
                'alipay' => [],
                'qq' => [],
                'jd' => [],
                'extend' => [],
                'payment' => [],
            ];
            $model = new Db1_payments_group;
            $model->alias('g');
            $model->join(['payments_config c'], 'g.config_id=c.id', 'left');
            $model->join(['payments_list l'], 'c.payment_id=l.id', 'left');
            $model->where('g.group_id', $gid);
            $model->where('g.activate', 1);
            $model->where('c.activate', 1);
            $model->where('l.activate', 1);
            $model->field([
                'g.id',
                'c.id config_id',
                'c.display',
                'c.support',
                'c.extend',
                'l.id payment_id',
                'l.name',
                'l.token',
                'l.extend payment_extend',
            ]);
            $rows = $model->select();
            foreach ($rows as $item) {
                $support = json_decode($item->support, true);
                if (json_last_error() == JSON_ERROR_NONE && ! empty($support)) {
                    $id = $item->id;
                    $config_id = $item->config_id;
                    $payment_id = $item->payment_id;
                    self::$finance[$gid]['extend'][$config_id] = json_decode($item->extend, true);
                    if (json_last_error() != JSON_ERROR_NONE) {
                        self::$finance[$gid]['extend'][$config_id] = [];
                    }
                    self::$finance[$gid]['payment'][$payment_id] = [
                        'extend' => json_decode($item->payment_extend, true),
                        'token' => $item->token,
                    ];
                    if (json_last_error() != JSON_ERROR_NONE) {
                        self::$finance[$gid]['payment'][$payment_id]['extend'] = [];
                    }
                    foreach ($support as $k => $c) {
                        if (array_key_exists($k, $keys) && array_key_exists($formType, $c) && $c[$formType]) {
                            $name = empty($c['display']) ? $item['display'] : $c['display'];
                            self::$finance[$gid][$keys[$k]][] = [
                                'name' => empty($name) ? $item['name'] : $name,
                                'code' => Common::auth_code(json_encode([
                                    'id' => $id,
                                    'config_id' => $config_id,
                                    'payment_id' => $payment_id,
                                    'type' => $k,
                                    'fee' => $c['fee'],
                                ], JSON_UNESCAPED_UNICODE), 'ENCODE'),
                            ];
                        }
                    }
                }
            }
        }

        return Common::get_array(self::$finance[$gid], $key, $default);
    }

    /**
     * generate_id 产生订单号
     *
     * @param string $prefix
     * @param string $custom
     * @param int $length
     * @param string $key
     * @return string
     */
    public static function generate_id($custom = '0', $length = 32, $prefix = 'DEPOSIT', $key = '123456789')
    {
        $keys = str_split(! is_string($key) || empty($key) ? '123456789' : $key);
        $return = $custom.date('ymdHis').rand(0, 9);
        $len = $length - strlen($prefix) - strlen($return) - 1;
        if ($len > 0) {
            $return = str_repeat('0', $len).$return;
        } else {
            $return = substr($return, -1 * $length);
        }
        $verify = 0;
        foreach (str_split($return) as $i => $v) {
            $i = fmod($i, 9);
            $verify += $v * $keys[$i];
        }
        $verify = fmod($verify, 11);
        $return .= $verify > 9 ? 'X' : $verify;

        return $prefix.$return;
    }

    /**
     * verify_id 验证订单号
     *
     * @param string $prefix
     * @param string $id
     * @param string $key
     * @return bool
     */
    public static function verify_id($id = '', $prefix = 'DEPOSIT', $key = '123456789')
    {
        $return = false;
        $length = strlen($prefix);
        if (empty($prefix) || substr($id, 0, $length) == $prefix) {
            $keys = str_split(! is_string($key) || empty($key) ? '123456789' : $key);
            $verify = 0;
            foreach (str_split(substr($id, $length, -1)) as $i => $v) {
                $i = fmod($i, 9);
                $verify += $v * $keys[$i];
            }
            $verify = fmod($verify, 11);
            $return = substr($id, -1) == ($verify > 9 ? 'X' : $verify);
        }

        return $return;
    }

    /**
     * money 会员财务注单统计
     *
     * @param $uid
     * @param $startTime
     * @param $endTime
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function counts($uid, $startTime, $endTime)
    {
        $dates = [$startTime.' 00:00:00', $endTime.' 23:59:59'];

        // 入款总计、取款总计、红利总计 & 返水总计：k_money
        $return = self::_kMoneyCounts($uid, $dates);

        // 入款总计：huikuan
        $return['deposit'] += self::_huikuanCounts($uid, $dates);

        return $return;
    }

    /**
     * report 会员财务注单记录
     *
     * @param $uid
     * @param $startTime
     * @param $endTime
     * @param string $type
     * @param int $limit
     * @param int $status
     * @param int $otherType
     * @return array
     * @throws \think\exception\DbException
     */
    public static function report(
        $uid,
        $startTime,
        $endTime,
        $type = 'deposit',
        $limit = 10,
        $status = 0,
        $otherType = 0
    ) {
        $return = [];
        $dates = [$startTime.' 00:00:00', $endTime.' 23:59:59'];
        $limit = $limit <= 0 ? 1 : ($limit > 100 ? 100 : $limit);
        $status = intval($status);

        switch ($type) {
            case 'deposit':
                $return = self::_kMoneyReport($uid, $dates, 1, $limit, $status);
                break;

            case 'transfer':
                $return = self::_huikuanReport($uid, $dates, $limit, $status);
                break;

            case 'withdraw':
                $return = self::_kMoneyReport($uid, $dates, 2, $limit, $status, false, false, true, true);
                break;

            case 'other':
                $otherType = intval($otherType);
                if ($otherType > 0 && $otherType < 5) {
                    $type = $otherType + 2;
                } else {
                    $type = [3, 6];
                }
                $return = self::_kMoneyReport($uid, $dates, $type, $limit, $status, true, true);
                break;
        }

        return $return;
    }

    /**
     * withdraw 提款申请
     *
     * @param $uid
     * @param $money
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function withdraw($uid, $money)
    {
        $user = Db1_k_user::get($uid);
        $previousMoney = $user['money'];
        $user->setDec('money', $money);
        $order = $user['username'].'_'.date('YmdHis');

        $log = new Db1_k_money_log;
        $log['uid'] = $uid;
        $log['userName'] = $user['username'];
        $log['gameType'] = 'TIKUAN';
        $log['transferType'] = 'OUT';
        $log['transferOrder'] = $order;
        $log['transferAmount'] = -1 * $money;
        $log['previousAmount'] = $previousMoney;
        $log['currentAmount'] = $previousMoney - $money;
        $log['creationTime'] = date('Y-m-d H:i:s');
        $log->save();

        $db = new Db1_k_money;
        $db['uid'] = $uid;
        $db['status'] = 2;
        $db['m_value'] = -1 * $money;
        $db['m_order'] = $order;
        $db['pay_card'] = $user['pay_card'];
        $db['pay_num'] = $user['pay_num'];
        $db['pay_address'] = $user['pay_address'];
        $db['pay_name'] = $user['pay_name'];
        $db['about'] = '';
        $db['assets'] = $previousMoney;
        $db['balance'] = $previousMoney - $money;
        $db['type'] = 2;
        $db->save();
    }

    /**
     * transfer 银行转账
     *
     * @param $uid
     * @param $bank
     * @param $money
     * @param string $transfer
     * @param string $address
     * @param string $time
     * @throws \think\exception\DbException
     */
    public static function transfer($uid, $bank, $money, $transfer = '', $address = '', $time = '')
    {
        $user = Db1_k_user::get($uid);
        $db = new Db1_huikuan;
        $db['money'] = $money;
        $db['bank'] = $bank;
        $db['date'] = $time;
        $db['status'] = 2;
        $db['manner'] = $transfer;
        $db['address'] = $address;
        $db['adddate'] = date('Y-m-d H:i:s');
        $db['uid'] = $user['uid'];
        $db['lsh'] = $user['username'].'_'.date('YmdHis');
        $db['assets'] = $user['money'];
        $db['balance'] = $user['money'] + $money;
        $db->save();
    }

    /**
     * _huikuanCounts huikuan 统计
     *
     * @param $uid
     * @param $dates
     * @return int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private static function _huikuanCounts($uid, $dates)
    {
        $return = 0;
        $db = new Db1_huikuan;
        $db->where('uid', $uid);
        $db->whereBetween('adddate', $dates);
        $db->where('status', 1);
        $db->field('money');
        $rows = $db->select();
        foreach ($rows as $row) {
            $return += $row['money'];
        }

        return $return;
    }

    /**
     * _kMoneyCounts k_money 统计
     *
     * @param $uid
     * @param $dates
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private static function _kMoneyCounts($uid, $dates)
    {
        $return = [
            'deposit' => 0,
            'withdraw' => 0,
            'bonus' => 0,
            'reward' => 0,
        ];
        $db = new Db1_k_money;
        $db->where('uid', $uid);
        $db->whereBetween('m_make_time', $dates);
        $db->where('status', 1);
        $db->whereBetween('type', [1, 5])->field('m_value,type');
        $rows = $db->select();
        foreach ($rows as $row) {
            switch ($row['type']) {
                case 1:
                case 3:
                    $return['deposit'] += $row['m_value'];
                    break;

                case 2:
                    $return['withdraw'] += abs($row['m_value']);
                    break;

                case 4:
                    $return['bonus'] += $row['m_value'];
                    break;

                case 5:
                    $return['reward'] += $row['m_value'];
                    break;
            }
        }

        return $return;
    }

    /**
     * _kMoneyReport k_money 财务记录
     *
     * @param $uid
     * @param $dates
     * @param $type
     * @param $limit
     * @param $status
     * @param bool $remark
     * @param bool $otherType
     * @param bool $bankInfo
     * @param bool $abs
     * @return array
     * @throws \think\exception\DbException
     */
    private static function _kMoneyReport(
        $uid,
        $dates,
        $type,
        $limit,
        $status,
        $remark = false,
        $otherType = false,
        $bankInfo = false,
        $abs = false
    ) {
        $return = [
            'data' => [],
            'page' => [],
        ];
        $db = new Db1_k_money;
        $db->where('uid', $uid);
        $db->whereBetween('m_make_time', $dates);
        if (is_array($type)) {
            $db->whereBetween('type', $type);
        } else {
            $db->where('type', $type);
        }
        if ($status > 0) {
            $db->where('status', $status != 1 ? 0 : $status);
        }
        $db->order('m_id', 'DESC');
        $rows = $db->paginate($limit);
        $return['page'] = $rows->render();
        foreach ($rows as $row) {
            $row['m_make_time'] = explode(' ', $row['m_make_time']);
            $data = [
                'id' => $row['m_id'],
                'orderId' => $row['m_order'],
                'date' => $row['m_make_time'][0],
                'time' => $row['m_make_time'][1],
                'money' => $row['m_value'],
                'fee' => $row['sxf'],
                'status' => $row['status'],
            ];
            if ($abs) {
                $data['money'] = abs($data['money']);
            }
            if ($remark) {
                $data['remark'] = $row['about'];
            }
            if ($otherType) {
                $data['type'] = $row['type'] - 2;
            }
            if ($bankInfo) {
                $data['fullName'] = $row['pay_name'];
                $data['bankName'] = $row['pay_card'];
                $data['cardNo'] = Common::cut_num($row['pay_num']);
                $data['address'] = $row['pay_address'];
            }
            $return['data'][] = $data;
        }

        return $return;
    }

    /**
     * _huikuanReport huikuan 财务记录
     *
     * @param $uid
     * @param $dates
     * @param $limit
     * @param $status
     * @return array
     * @throws \think\exception\DbException
     */
    private static function _huikuanReport($uid, $dates, $limit, $status)
    {
        $return = [
            'data' => [],
            'page' => [],
        ];
        $db = new Db1_huikuan;
        $db->where('uid', $uid);
        $db->whereBetween('adddate', $dates);
        if ($status > 0) {
            $db->where('status', $status);
        }
        $db->order('id', 'DESC');
        $rows = $db->paginate($limit);
        $return['page'] = $rows->render();
        foreach ($rows as $row) {
            $row['adddate'] = explode(' ', $row['adddate']);
            $return['data'][] = [
                'id' => $row['id'],
                'orderId' => $row['lsh'],
                'date' => $row['adddate'][0],
                'time' => $row['adddate'][1],
                'money' => $row['money'],
                'fee' => $row['zsjr'],
                'remark' => $row['manner'].'<br />转账时间：'.$row['date'],
                'status' => $row['status'],
                'bankName' => $row['bank'],
                'address' => $row['address'],
            ];
        }

        return $return;
    }
}