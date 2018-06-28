<?php

namespace app\member\controller;

use app\common\Casino;
use app\common\Constant;
use app\common\Common;
use app\common\Users as UsersClass;
use think\Controller;
use think\Request;
use think\Validate;

class Users extends Controller
{
    private $_return = [];

    private $_user = [];

    /**
     * Users constructor.
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
        $this->_user = UsersClass::getUserInfo(true);
        if (isset($this->_user['id']) && $this->_user['id'] > 0) {
            $this->_return['errorCode'] = 0;
            $this->_return['errorMsg'] = Constant::VERIFY_SUCCESS;
            $this->_return['data'] = [];
        }
    }

    /**
     * index
     *
     * @return array
     */
    public function index()
    {
        if ($this->_return['errorCode'] == 0) {
            unset($this->_user['password']);
            unset($this->_user['fundPwd']);
            $this->_user['withdraw'] = [
                'limit' => floatval(Common::get_web_setting('withdraw.limit')),
                'time' => Common::get_web_setting('withdraw.time'),
            ];
            $this->_return['data'] = $this->_user;
        }

        return $this->_return;
    }

    /**
     * password 用户密码
     *
     * @return array
     * @throws \think\exception\DbException
     */
    public function password()
    {
        if ($this->_return['errorCode'] == 0) {
            $this->_return['errorCode'] = 1;
            $this->_return['errorMsg'] = Constant::VALID_ACTION;
            $request = Request::instance();
            $rule = [
                'password' => 'require',
                'newPassword' => 'require',
                'rePassword' => 'require|confirm:newPassword',
            ];
            $msg = [
                'password.require' => Constant::PASSWORD_REQUIRE,
                'newPassword.require' => Constant::NEW_PASSWORD_REQUIRE,
                'rePassword.require' => Constant::RE_PASSWORD_REQUIRE,
                'rePassword.confirm' => Constant::RE_PASSWORD_CONFIRM,
            ];
            $data = [
                'password' => $request->post('password'),
                'newPassword' => $request->post('newPassword'),
                'rePassword' => $request->post('rePassword'),
            ];
            $type = $request->post('type', 'login');
            $validate = new Validate($rule, $msg);
            if (! $validate->check($data)) {
                $this->_return['errorMsg'] = $validate->getError();
            } else {
                if ($type == 'fund') {
                    $data['password'] = md5($data['password']);
                    $data['oldPassword'] = $this->_user['fundPwd'];
                    $rule = [
                        'password' => 'confirm:oldPassword',
                        'newPassword' => 'integer|length:6',
                    ];
                    $msg = [
                        'password.confirm' => Constant::PASSWORD_CONFIRM,
                        'newPassword' => Constant::NEW_PASSWORD_ONLY_6_NUM,
                    ];
                    $validate = new Validate($rule, $msg);
                    if (! $validate->check($data)) {
                        $this->_return['errorMsg'] = $validate->getError();
                    } else {
                        $this->_return['errorCode'] = 0;
                    }
                } else {
                    $data['password'] = md5($data['password']);
                    $data['oldPassword'] = $this->_user['password'];
                    $rule = [
                        'password' => 'confirm:oldPassword',
                        'newPassword' => 'length:6,20',
                    ];
                    $msg = [
                        'password.confirm' => Constant::PASSWORD_CONFIRM,
                        'newPassword' => Constant::NEW_PASSWORD_INVALID,
                    ];
                    $validate = new Validate($rule, $msg);
                    if (! $validate->check($data)) {
                        $this->_return['errorMsg'] = $validate->getError();
                    } else {
                        $this->_return['errorCode'] = 0;
                    }
                }
            }
            if ($this->_return['errorCode'] == 0) {
                UsersClass::updatePassword($this->_user['id'], $data['newPassword'], $type);
            }
        }

        return $this->_return;
    }

    /**
     * notice 站内消息
     *
     * @param string $type
     * @param int $id
     * @return array
     * @throws \think\exception\DbException
     */
    public function notice($type = 'default', $id = 0)
    {
        if ($this->_return['errorCode'] == 0) {
            $this->_return['errorMsg'] = Constant::VALID_ACTION;
            switch ($type) {
                case 'get':
                    $request = Request::instance();
                    $limit = $request->post('limit', 5, 'intval');
                    $rows = UsersClass::getNotice($this->_user['id'], $limit);
                    $this->_return = array_merge($this->_return, $rows);
                    break;

                case 'read':
                    $id = intval($id);
                    if ($id > 0) {
                        $db = UsersClass::notice($this->_user['id'], $id);
                        $db->islook = 1;
                        $db->isUpdate(true)->save();
                    }
                    break;

                case 'delete':
                    $id = intval($id);
                    if ($id > 0) {
                        UsersClass::notice($this->_user['id'], $id)->delete();
                    }
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
     * card 设置银行卡信息
     *
     * @return array
     * @throws \think\exception\DbException
     */
    public function card()
    {
        if ($this->_return['errorCode'] == 0) {
            $this->_return['errorCode'] = 1;
            if (isset($this->_user['cardNo']) && ! empty($this->_user['cardNo'])) {
                $this->_return['errorMsg'] = Constant::CARD_IS_SET;
            } else {
                $request = Request::instance();
                $request->filter(['app\common\Common::html_encode']);
                $data = [
                    'bank' => $request->post('bank'),
                    'cardNo' => $request->post('cardNo'),
                    'address' => $request->post('address'),
                ];
                $rule = [
                    'bank' => 'require|length:1,50',
                    'cardNo' => 'require|length:1,50',
                    'address' => 'require|length:1,50',
                ];
                $msg = [
                    'bank' => Constant::BANK_INVALID,
                    'cardNo' => Constant::CARD_NO_INVALID,
                    'address' => Constant::ADDRESS_INVALID,
                ];
                $validate = new Validate($rule, $msg);
                if (! $validate->check($data)) {
                    $this->_return['errorMsg'] = $validate->getError();
                } else {
                    $this->_return['errorCode'] = 0;
                    $this->_return['errorMsg'] = Constant::VALID_ACTION;
                    $this->_return['data'] = $data;
                    UsersClass::setCard($this->_user['id'], $data);
                }
            }
        }

        return $this->_return;
    }

    /**
     * casino 获取平台缓存余额
     *
     * @throws \think\exception\DbException
     */
    public function casino()
    {
        if ($this->_return['errorCode'] == 0) {
            $this->_return['errorCode'] = 1;
            $this->_return['errorMsg'] = Constant::INVALID_CASINO;
            $request = Request::instance();
            $type = $request->post('type');
            if (! empty($type)) {
                $list = Common::get_casino_transfer();
                if (array_key_exists($type, $list)) {
                    $this->_return['errorCode'] = 0;
                    $this->_return['errorMsg'] = Constant::ACTION_SUCCESS;
                    $data = Casino::getStatus($type);
                    $user = UsersClass::get();
                    if ($user->offsetExists($list[$type]['field'])) {
                        $data['money'] = floatval($user[$list[$type]['field']]);
                    } else {
                        $data['money'] = '-';
                    }
                    $this->_return['data'] = $data;
                }
            }

            return $this->_return;
        }
    }
}
