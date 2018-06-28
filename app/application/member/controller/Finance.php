<?php

namespace app\member\controller;

use app\common\Casino;
use app\common\Common;
use app\common\Constant;
use app\common\model\Db1_huikuan;
use app\common\model\Db1_k_money;
use app\common\model\Db1_payments_list;
use app\common\Users;
use app\common\Finance as UsersFinance;
use think\Config;
use think\Controller;
use think\Request;
use think\Session;
use think\Validate;

class Finance extends Controller
{
    private $_return = [];

    private $_user = [];

    private $_startTime = false;

    private $_endTime = false;

    private $_limit = 0;

    /**
     * Report constructor.
     *
     * @param \think\Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->_return = [
            'errorCode' => -1,
            'errorMsg' => Constant::USER_NOT_LOGIN,
        ];
        $this->_user = Users::getUserInfo(true);
        if (isset($this->_user['id']) && $this->_user['id'] > 0) {
            $this->_return['errorCode'] = 0;
            $this->_return['errorMsg'] = Constant::ACTION_SUCCESS;
            $this->_return['data'] = [];
        }
    }

    /**
     * withdraw 提款申请
     *
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function withdraw()
    {
        if ($this->_return['errorCode'] == 0) {
            $this->_return['errorCode'] = 1;
            $now = time();
            $limitMoney = floatval(Common::get_web_setting('withdraw.limit'));
            $time = Common::get_web_setting('withdraw.time');
            $limitTime = [
                strtotime(date('Y-m-d ', $now + 43200).$time[0].':00') - 43200,
                strtotime(date('Y-m-d ', $now + 43200).$time[1].':59') - 43200,
            ];
            $request = Request::instance();
            $lastWithdraw = $request->session('last_get_money', 0);
            $money = $request->post('money', 0, 'floatval');
            $password = $request->post('password');
            $data = [
                'time' => $now,
                'lastTime' => $lastWithdraw,
                'password' => $password,
                'passwordHash' => $password != null && $password != '' ? md5($password) : 'A'.$this->_user['fundPwd'].'B',
                'fundPwd' => $this->_user['fundPwd'],
                'money' => $money,
            ];
            $rule = [
                'time' => ['egt' => $limitTime[0], 'elt' => $limitTime[1]],
                'lastTime' => ['max' => $now],
                'password' => 'require',
                'passwordHash' => 'confirm:fundPwd',
                'money' => ['gt' => 0, 'egt' => $limitMoney, 'elt' => $this->_user['money']],
            ];
            $msg = [
                'time' => sprintf(Constant::WITHDRAW_INVALID_TIME, $time[0], $time[1]),
                'lastTime' => Constant::WITHDRAW_LIMIT_TIME,
                'password' => Constant::WITHDRAW_INVALID_PASSWORD,
                'passwordHash' => Constant::WITHDRAW_INVALID_PASSWORD,
                'money' => Constant::WITHDRAW_INVALID_MONEY,
                'money.egt' => sprintf(Constant::WITHDRAW_LIMIT_MONEY, $limitMoney),
                'money.elt' => Constant::WITHDRAW_EXCEED_MONEY,
            ];
            $validate = new Validate($rule, $msg);
            if (! $validate->check($data)) {
                $this->_return['errorMsg'] = $validate->getError();
            } else {
                $startTime = strtotime(date('Y-m-d 12:00:00'));
                if ($startTime > $now) {
                    $startTime -= 86400;
                }
                $startTime = date('Y-m-d H:i:s', $startTime);
                $db = new Db1_k_money;
                $db->where('uid', $this->_user['id']);
                $db->where('type', 2);
                $db->where('m_make_time', '>=', $startTime);
                $db->where('status', 2);
                if ($db->count() > 0) {
                    $this->_return['errorMsg'] = Constant::WITHDRAW_IN_PROGRESS;
                } else {
                    $maxCount = Common::get_group_setting('withdraw.limit', $this->_user['gid'], -1);
                    $count = 0;
                    if ($maxCount > 0) {
                        $db = new Db1_k_money;
                        $db->where('uid', $this->_user['id']);
                        $db->where('type', 2);
                        $db->where('m_make_time', '>=', $startTime);
                        $count = $db->count();
                    }
                    if ($maxCount == -1 || $count == 0 || $maxCount > $count) {
                        UsersFinance::withdraw($this->_user['id'], $money);
                        Session::set('last_get_money', $now + 30);
                        $this->_return['errorCode'] = 0;
                    } else {
                        $this->_return['errorMsg'] = Constant::WITHDRAW_MAX_COUNT;
                    }
                }
            }
        }

        return $this->_return;
    }

    /**
     * casino 额度转换
     *
     * @return array
     * @throws \think\exception\DbException
     */
    public function casino()
    {
        if ($this->_return['errorCode'] == 0) {
            $this->_return['errorCode'] = 1;
            if ($this->_user['allowTransfer']) {
                $this->_return['errorMsg'] = Constant::INVALID_CASINO;
                $request = Request::instance();
                $transferIn = $request->post('transferIn');
                $transferOut = $request->post('transferOut');
                $transferMoney = $request->post('transferMoney');
                $return = Casino::transfer($this->_user['id'], $transferOut, $transferIn, $transferMoney);
                if ($return['result']) {
                    $this->_return['errorCode'] = 0;
                    $this->_return['errorMsg'] = Constant::CASINO_TRANSFER_SUCCESS;
                } else {
                    $this->_return['errorMsg'] = $return['msg'];
                }
            } else {
                $this->_return['errorMsg'] = Constant::CASINO_DENY_TRANSFER;
            }
        }

        return $this->_return;
    }

    /**
     * deposit 在线存款
     *
     * @param string $type
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function deposit($type = 'list')
    {
        if ($this->_return['errorCode'] == 0) {
            switch ($type) {
                case 'list':
                    $this->_return['data'] = $this->_depositList();
                    break;
                case 'online':
                    Config::set('default_return_type', 'html');
                    $request = Request::instance();
                    $data = [];
                    $data['code'] = $request->post('code');
                    $data['code'] = Common::auth_code($data['code'], 'DECODE');
                    $data['amount'] = $request->post('amount');
                    $limitMoney = floatval(Common::get_web_setting('deposit.limit'));
                    $rule = [
                        'code' => 'require',
                        'amount' => 'require|number|egt:'.$limitMoney,
                    ];
                    $msg = [
                        'code' => Constant::DEPOSIT_TRANSFER_COMMON_INVALID,
                        'amount' => Constant::DEPOSIT_TRANSFER_INVALID_MONEY,
                        'amount.egt' => sprintf(Constant::DEPOSIT_TRANSFER_LIMIT_MONEY, $limitMoney),
                    ];
                    $validate = new Validate($rule, $msg);
                    if (! $validate->check($data)) {
                        $this->_return = $validate->getError();
                        $this->_return = '<script type="text/javascript">!function(e){alert("'.$this->_return.'");e.close()}(window)</script>';
                    } else {
                        //$deposit = Common::get_group_finance('deposit.'.$this->_user['gid']);
                        //$uri = '';
                        //foreach ($deposit as $item) {
                        //    if (Common::auth_code($item['code'], 'DECODE') == $data['code']) {
                        //        $uri = Common::auth_code($item['uri'], 'DECODE');
                        //        break;
                        //    }
                        //}
                        //if (empty($uri)) {
                        //    $this->_return = '<script type="text/javascript">!function(e){alert("'.Constant::DEPOSIT_INVALID_CODE.'");e.close()}(window)</script>';
                        //} else {
                        //    $this->_return = '<form action="'.$uri.'" method="post">';
                        //    $this->_return .= '<input type="hidden" name="pay_online" value="'.$data['code'].'" />';
                        //    $this->_return .= '<input type="hidden" name="S_UID" value="'.$this->_user['id'].'" />';
                        //    $this->_return .= '<input type="hidden" name="S_Name" value="'.$this->_user['username'].'" />';
                        //    $this->_return .= '<input type="hidden" name="MOAmount" value="'.$data['amount'].'" />';
                        //    $this->_return .= '<input type="submit" value="点击继续" />';
                        //    $this->_return .= '</form>';
                        //    $this->_return .= '<script type="text/javascript">!function(e){return "undefined"!=typeof e[0]&&"undefined"!=typeof e[0].submit&&(e[0].getElementsByTagName("input")[4].remove(),e[0].submit())}(document.getElementsByTagName("form"))</script>';
                        //}
                        $data['code'] = json_decode($data['code'], true);
                        $extend = UsersFinance::payments($this->_user['gid'], 'extend.'.$data['code']['config_id']);
                        $payment = UsersFinance::payments($this->_user['gid'], 'payment.'.$data['code']['payment_id']);
                        $gateway = Common::get_array($payment, 'extend.gateway', null);
                        if (empty($extend) || empty($payment) || empty($gateway)) {
                            $this->_return = '<script type="text/javascript">!function(e){alert("'.Constant::DEPOSIT_INVALID_CODE.'");e.close()}(window)</script>';
                        } else {
                            $code = Common::auth_code(json_encode([
                                'order_id' => UsersFinance::generate_id($this->_user['id']),
                                'type' => $data['code']['type'],
                                'uid' => $this->_user['id'],
                                'username' => $this->_user['username'],
                                'amount' => floatval($data['amount']),
                                'fee' => $data['code']['fee'],
                                'config_id' => $data['code']['config_id'],
                                'extend' => $extend,
                            ]), 'ENCODE', $payment['token']);
                            $website = Common::auth_code(json_encode([
                                'website_id' => Common::get_website_id(),
                                'domain' => $_SERVER['HTTP_HOST'],
                                'scheme' => isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http',
                            ]), 'ENCODE', Common::get_array($payment, 'extend.token', 'aibo'));
                            $this->_return = '<form action="'.$gateway.'" method="post">';
                            $this->_return .= '<input type="hidden" name="id" value="'.$data['code']['payment_id'].'" />';
                            $this->_return .= '<input type="hidden" name="website" value="'.htmlspecialchars($website).'" />';
                            $this->_return .= '<input type="hidden" name="code" value="'.htmlspecialchars($code).'" />';
                            $this->_return .= '<button type="submit">点击继续</button>';
                            $this->_return .= '</form>';
                            $this->_return .= '<script type="text/javascript">!function(e){return "undefined"!=typeof e[0]&&"undefined"!=typeof e[0].submit&&(e[0].getElementsByTagName("button")[0].remove(),e[0].submit())}(document.getElementsByTagName("form"))</script>';
                        }
                    }
                    $this->_return = '<!DOCTYPE html><html><head><title></title></head><body>'.$this->_return.'</body></html>';
                    break;
                case 'transfer':
                    $this->_depositTransfer();
                    break;

                case 'qrcode':
                    $this->_depositTransfer(true);
                    break;

                default:
                    $this->_return['errorCode'] = 1;
                    $this->_return['errorMsg'] = Constant::INVALID_ACTION;
                    break;
            }
        }

        return $this->_return;
    }

    /**
     * notify 在线充值通知
     *
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function notify()
    {
        $this->_return = [
            'errorCode' => 0,
            'errorMsg' => 'failed',
        ];

        $request = Request::instance();
        $id = $request->post('id');
        $code = $request->post('code');

        if (! empty($id) && ! empty($code)) {
            $payment = Db1_payments_list::get($id);
            if (! empty($payment)) {
                $code = Common::auth_code($code, 'DECODE', $payment->token);
                if (! empty($code)) {
                    $data = json_decode($code, true);
                    $orderId = Common::get_array($data, 'order_id');
                    if (json_last_error() == JSON_ERROR_NONE && UsersFinance::verify_id($orderId)) {
                        $this->_return = [
                            'errorCode' => 0,
                            'errorMsg' => 'success',
                        ];
                        $model = Db1_k_money::where('m_order', $orderId)->find();
                        if (empty($model)) {
                            $uid = Common::get_array($data, 'uid');
                            $amount = Common::get_array($data, 'amount');
                            $fee = Common::get_array($data, 'fee');
                            $db = new Db1_k_money;
                            $db->setAttr('uid', 0);
                            $db->setAttr('m_order', $orderId);
                            $db->setAttr('m_value', $amount);
                            $db->setAttr('status', 2);
                            $db->setAttr('type', 1);
                            $db->setAttr('money_type', $payment->name);
                            $db->setAttr('pay_mid', Common::get_array($data, 'config_id'));
                            $db->setAttr('sxf', empty($fee) || ! is_numeric($fee) ? 0 : $amount * $fee / 100);
                            if ($db->save()) {
                                $money = Users::money($uid, $amount, $orderId, 'ONLINEPAY', 'IN');
                                $db->setAttr('uid', $uid);
                                $db->setAttr('status', 1);
                                $db->setAttr('update_time', date('Y-m-d H:i:s'));
                                $db->setAttr('about', '该订单在线冲值操作成功');
                                $db->setAttr('assets', $money - $amount);
                                $db->setAttr('balance', $money);
                                $db->save();
                            }
                        }
                    }
                }
            }
        }

        return $this->_return;
    }

    /**
     * _depositList 在线存款-可用通道
     *
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function _depositList()
    {
        $return = [
            'limit' => floatval(Common::get_web_setting('deposit.limit')),
            //'deposit' => Common::get_group_finance('deposit.'.$this->_user['gid'], []),
            'deposit' => UsersFinance::payments($this->_user['gid'], 'deposit'),
            'transfer' => Common::get_group_finance('transfer.'.$this->_user['gid'], []),
            'alipay' => Common::get_group_finance('alipay.'.$this->_user['gid'], []),
            'wechat' => Common::get_group_finance('wechat.'.$this->_user['gid'], []),
            'qq' => Common::get_group_finance('qq.'.$this->_user['gid'], []),
            'jd' => Common::get_group_finance('jd.'.$this->_user['gid'], []),
            'qrcode' => Common::get_group_finance('qrcode.'.$this->_user['gid'], []),
        ];
        //$return['deposit'] = array_merge(UsersFinance::payments($this->_user['gid'], 'deposit'), $return['deposit']);
        $return['wechat'] = array_merge(UsersFinance::payments($this->_user['gid'], 'wechat'), $return['wechat']);
        $return['alipay'] = array_merge(UsersFinance::payments($this->_user['gid'], 'alipay'), $return['alipay']);
        $return['qq'] = array_merge(UsersFinance::payments($this->_user['gid'], 'qq'), $return['qq']);
        $return['jd'] = array_merge(UsersFinance::payments($this->_user['gid'], 'jd'), $return['jd']);

        return $return;
    }

    /**
     * _depositTransfer 在线存款-银行转账
     *
     * @param bool $qrcode
     * @throws \think\exception\DbException
     */
    private function _depositTransfer($qrcode = false)
    {
        $data = [];
        $this->_return['errorCode'] = 1;
        $limitMoney = Common::get_web_setting('deposit.limit');
        $request = Request::instance();
        $data['code'] = $request->post('code');
        $data['code'] = Common::auth_code($data['code'], 'DECODE');
        $data['transfer'] = Common::html_encode($request->post('transfer'));
        $data['amount'] = $request->post('amount');
        $data['username'] = Common::html_encode($request->post('username'));
        $data['address'] = Common::html_encode($request->post('address'));
        $data['time'] = strtotime($request->post('time'));
        $rule = [
            'code' => 'require',
            'amount' => 'require|number|egt:'.$limitMoney,
            'time' => 'require|egt:0',
        ];
        $msg = [
            'code' => Constant::DEPOSIT_TRANSFER_COMMON_INVALID,
            'time' => Constant::DEPOSIT_TRANSFER_INVALID_TIME,
            'amount' => Constant::DEPOSIT_TRANSFER_INVALID_MONEY,
            'amount.egt' => sprintf(Constant::DEPOSIT_TRANSFER_LIMIT_MONEY, $limitMoney),
        ];
        if ($qrcode) {
            $rule['username'] = 'require';
            $msg['username'] = Constant::DEPOSIT_TRANSFER_INVALID_USERNAME;
        } else {
            $rule['transfer'] = 'require';
            $msg['username'] = Constant::DEPOSIT_TRANSFER_INVALID_ACTION;
        }
        $validate = new Validate($rule, $msg);
        if (! $validate->check($data)) {
            $this->_return['errorMsg'] = $validate->getError();
        } else {
            if ($qrcode) {
                $data['address'] = '';
                $data['transfer'] = '会员昵称：'.$data['username'];
            } else {
                if (! empty($data['username'])) {
                    $data['transfer'] .= '<br />转账姓名：'.$data['username'];
                }
            }
            $data['code'] = json_decode($data['code'], true);
            $data['time'] = date('Y-m-d H:i:s', $data['time']);
            $db = new Db1_huikuan;
            $db->where('uid', $this->_user['id']);
            $db->where('status', 0);
            $db->where('adddate', '>=', date('Y-m-d H:i:s', time() - 86400));
            if ($db->count() > 0) {
                $this->_return['errorMsg'] = Constant::DEPOSIT_TRANSFER_WAITING_CONFIRM;
            } else {
                UsersFinance::transfer($this->_user['id'], $data['code']['name'].'<br />'.$data['code']['id'],
                    $data['amount'], $data['transfer'], $data['address'], $data['time']);
                $this->_return['errorCode'] = 0;
                $this->_return['errorMsg'] = Constant::VALID_ACTION;
            }
        }
    }
}
