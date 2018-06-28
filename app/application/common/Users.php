<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/4/27
 * Time: 14:37
 */

namespace app\common;

use app\common\model\Db1_history_bank;
use app\common\model\Db1_k_money_log;
use app\common\model\Db1_k_user;
use app\common\model\Db1_k_user_login;
use app\common\model\Db1_k_user_msg;
use think\Request;

/**
 * Class Users 用户公共类
 *
 * @package app\common
 */
class Users
{
    private static $_user = null;

    /**
     * getUserInfo 获取用户信息
     *
     * @param bool $more
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getUserInfo($more = false)
    {
        $return = ['id' => 0];
        $user = self::get();
        if ($user && $user['is_stop'] != 1 && $user['is_delete'] != 1) {
            $db = new Db1_k_user_login;
            $login = $db->where('uid', $user['uid'])->field('is_login')->find();
            if (! empty($login) && $login['is_login'] == 1) {
                $return = [
                    'id' => $user['uid'],
                    'gid' => $user['gid'],
                    'username' => $user['username'],
                    'fullName' => $user['pay_name'],
                    'agent' => $user['is_daili'] == 1,
                    'money' => sprintf('%.2f', $user['money']),
                    'loginTime' => $user['login_time'],
                    'bank' => $user['pay_card'],
                    'cardNo' => Common::cut_num($user['pay_num']),
                    'address' => $user['pay_address'],
                    'mobile' => Common::cut_title($user['mobile'], 8),
                    'email' => Common::cut_title($user['email']),
                    'allowTransfer' => $user['iszhuan'] == 1,
                ];
                if ($more) {
                    $return['password'] = $user['password'];
                    $return['fundPwd'] = $user['qk_pwd'];
                }
            }
        }

        return $return;
    }

    /**
     * get 获取用户对象
     *
     * @return mixed
     * @throws \think\exception\DbException
     */
    public static function get()
    {
        if (self::$_user === null) {
            $request = Request::instance();
            if ($request->has('uid', 'session')) {
                $db = new Db1_k_user;
                self::$_user = $db->get($request->session('uid/d', 0));
            }
        }

        return self::$_user;
    }

    /**
     * updatePassword 修改用户密码
     *
     * @param $uid
     * @param $password
     * @param string $type
     * @return false|int
     * @throws \think\exception\DbException
     */
    public static function updatePassword($uid, $password, $type = 'login')
    {
        $db = Db1_k_user::get($uid);
        if ($type == 'fund') {
            $db->birthday = $password;
            $db->qk_pwd = md5($password);
        } else {
            $db->sex = $password;
            $db->password = md5($password);
            $db->modify_pwd_t = date('Y-m-d H:i:s');
        }

        return $db->isUpdate(true)->save();
    }

    /**
     * getUserNotice 用户站内信息
     *
     * @param $uid
     * @param int $limit
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getNotice($uid, $limit = 5)
    {
        $return = [
            'data' => [],
            'page' => [],
        ];
        $limit = $limit <= 0 ? 1 : ($limit > 100 ? 100 : $limit);
        $db = new Db1_k_user_msg;
        $rows = $db->where('uid', $uid)->order('msg_time', 'DESC')->order('msg_id', 'DESC')->paginate($limit);
        $return['page'] = $rows->render();
        foreach ($rows as $row) {
            $row['msg_info'] = str_replace("\r\n", "\n", $row['msg_info']);
            $row['msg_info'] = str_replace("\r", "\n", $row['msg_info']);
            $row['msg_info'] = str_replace("\n", '<br />', $row['msg_info']);
            $return['data'][] = [
                'id' => $row['msg_id'],
                'title' => $row['msg_title'],
                'content' => $row['msg_info'],
                'author' => $row['msg_from'],
                'addTime' => $row['msg_time'],
                'read' => $row['islook'] == 1,
            ];
        }

        return $return;
    }

    /**
     * notice Model 站内信息
     *
     * @param $uid
     * @param $id
     * @return \app\common\model\Db1_k_user_msg
     */
    public static function notice($uid, $id)
    {
        $db = new Db1_k_user_msg;
        $db->where('msg_id', $id);
        $db->where('uid', $uid);

        return $db;
    }

    /**
     * setCard 设置银行账户信息
     *
     * @param $uid
     * @param array $data
     * @return bool
     * @throws \think\exception\DbException
     */
    public static function setCard($uid, $data = [])
    {
        if (empty($data) || ! isset($data['bank']) || ! isset($data['cardNo']) || ! isset($data['address'])) {
            return false;
        } else {
            $db = Db1_k_user::get($uid);
            $db->pay_card = $data['bank'];
            $db->pay_num = $data['cardNo'];
            $db->pay_address = $data['address'];
            $db->isUpdate(true)->save();
            $bank = new Db1_history_bank;
            $bank->uid = $uid;
            $bank->username = $db['username'];
            $bank->pay_card = $db['pay_card'];
            $bank->pay_num = $db['pay_num'];
            $bank->pay_address = $db['pay_address'];
            $bank->pay_name = $db['pay_name'];
            $bank->save();

            return true;
        }
    }

    /**
     * money 更新用户余额并写入日志
     *
     * @param $uid
     * @param $money
     * @param $orderId
     * @param $gameType
     * @param $transferType
     * @return bool|mixed
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function money($uid, $money, $orderId, $gameType, $transferType)
    {
        $return = false;
        $user = Db1_k_user::get($uid);
        if (! empty($user)) {
            $previousAmount = $user->money;
            if ($money > 0) {
                $user->setInc('money', $money);
            }
            if ($money < 0) {
                $user->setDec('money', abs($money));
            }
            $db = new Db1_k_money_log;
            $db->setAttr('uid', $user->uid);
            $db->setAttr('userName', $user->username);
            $db->setAttr('gameType', $gameType);
            $db->setAttr('transferType', $transferType);
            $db->setAttr('transferOrder', $orderId);
            $db->setAttr('transferAmount', $money);
            $db->setAttr('previousAmount', $previousAmount);
            $db->setAttr('currentAmount', $previousAmount + $money);
            $db->setAttr('creationTime', date('Y-m-d H:i:s'));
            $db->save();
            $return = $previousAmount + $money;
        }

        return $return;
    }
}