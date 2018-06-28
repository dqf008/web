<?php

namespace app\member\controller;

use app\common\Common;
use app\common\Constant;
use app\common\Finance;
use app\common\Sports;
use app\common\Casino;
use app\common\Lottery;
use app\common\Users;
use think\Controller;
use think\Request;

class Report extends Controller
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
        $this->_user = Users::getUserInfo();
        if (isset($this->_user['id']) && $this->_user['id'] > 0) {
            $this->_startTime = Common::check_date($request->post('startTime'));
            $this->_endTime = Common::check_date($request->post('endTime'));
            $this->_limit = $request->post('limit', 10, 'intval');
            if ($this->_startTime !== false && $this->_endTime !== false) {
                $this->_return['errorCode'] = 0;
                $this->_return['errorMsg'] = Constant::ACTION_SUCCESS;
                $this->_return['data'] = [];
            } else {
                $this->_return['errorCode'] = 1;
                $this->_return['errorMsg'] = Constant::INVALID_DATA;
            }
        }
    }

    /**
     * index
     *
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        if ($this->_return['errorCode'] == 0) {
            // 系统体育
            $sports = [];
            $sports['single'] = Sports::counts($this->_user['id'], $this->_startTime, $this->_endTime, true, 'single');
            $sports['multiple'] = Sports::counts($this->_user['id'], $this->_startTime, $this->_endTime, true,
                'multiple');
            $this->_return['data']['sports'] = Common::sum_arrays($sports['single'],
                $sports['multiple']); // 合并两个结构相同的数组

            // 真人视讯
            $this->_return['data']['casino'] = Casino::counts($this->_user['id'], $this->_startTime, $this->_endTime,
                'casino');

            // 电子游戏
            $this->_return['data']['slots'] = Casino::counts($this->_user['id'], $this->_startTime, $this->_endTime,
                'slots');

            // 系统彩票
            $this->_return['data']['lottery'] = Lottery::counts($this->_user['id'], $this->_user['username'],
                $this->_startTime, $this->_endTime);

            // 财务记录
            $money = Finance::counts($this->_user['id'], $this->_startTime, $this->_endTime);

            $this->_return['data'] = array_merge($this->_return['data'], $money);
        }

        return $this->_return;
    }

    /**
     * lastWeek 最近 7 天会员盈亏
     *
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function lastWeek()
    {
        if (isset($this->_user['id']) && $this->_user['id'] > 0) {
            $this->_return['errorCode'] = 0;
            $this->_return['errorMsg'] = Constant::ACTION_SUCCESS;
            $time = time();
            $dates = [
                date('Y-m-d', $time - 604800),
                date('Y-m-d', $time),
            ];
            $this->_return['data'] = [
                'sports' => 0,
                'casino' => 0,
                'slots' => 0,
                'lottery' => 0,
            ];

            // 系统体育
            $rows = Sports::counts($this->_user['id'], $dates[0], $dates[1]);
            $this->_return['data']['sports'] = $rows['netAmount'];

            // 真人视讯
            $rows = Casino::counts($this->_user['id'], $dates[0], $dates[1], 'casino');
            $this->_return['data']['casino'] = $rows['netAmount'];

            // 电子游戏
            $rows = Casino::counts($this->_user['id'], $dates[0], $dates[1], 'slots');
            $this->_return['data']['slots'] = $rows['netAmount'];

            // 系统彩票
            $rows = Lottery::counts($this->_user['id'], $this->_user['username'], $dates[0], $dates[1]);
            $this->_return['data']['lottery'] = $rows['netAmount'];
        }

        return $this->_return;
    }

    /**
     * sports 系统体育下注记录
     *
     * @param string $type
     * @param int $status
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function sports($type = 'default', $status = 0)
    {
        if ($this->_return['errorCode'] == 0) {
            switch ($type) {
                case 'single':
                case 'multiple':
                    $sports = Sports::report($this->_user['id'], $this->_startTime, $this->_endTime, $type,
                        $this->_limit, $status);
                    $this->_return = array_merge($this->_return, $sports);
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
     * lottery 系统彩票下注记录
     *
     * @param string $type
     * @param int $status
     * @return array
     * @throws \think\exception\DbException
     */
    public function lottery($type = 'default', $status = 0)
    {
        if ($this->_return['errorCode'] == 0) {
            $lottery = Lottery::report($this->_user['id'], $this->_user['username'], $this->_startTime, $this->_endTime,
                $type, $this->_limit, $status);
            if (empty($lottery)) {
                $this->_return['errorCode'] = 1;
                $this->_return['errorMsg'] = Constant::INVALID_ACTION;
            } else {
                $this->_return = array_merge($this->_return, $lottery);
            }
        }

        return $this->_return;
    }

    /**
     * casino 真人视讯下注记录
     *
     * @param int $pid
     * @return array
     * @throws \think\exception\DbException
     */
    public function casino($pid = 0)
    {
        if ($this->_return['errorCode'] == 0) {
            $casino = Casino::report($this->_user['id'], $this->_startTime, $this->_endTime, $pid, $this->_limit);
            if (empty($casino)) {
                $this->_return['errorCode'] = 1;
                $this->_return['errorMsg'] = Constant::INVALID_ACTION;
            } else {
                $this->_return = array_merge($this->_return, $casino);
            }
        }

        return $this->_return;
    }

    /**
     * slots 电子游戏下注记录
     *
     * @param int $pid
     * @return array
     * @throws \think\exception\DbException
     */
    public function slots($pid = 0)
    {
        return $this->casino($pid);
    }

    /**
     * finance 财务记录
     *
     * @param int $status
     * @param string $type
     * @param int $otherType
     * @return array
     * @throws \think\exception\DbException
     */
    public function finance($type = 'deposit', $status = 0, $otherType = 0)
    {
        if ($this->_return['errorCode'] == 0) {
            $deposit = Finance::report($this->_user['id'], $this->_startTime, $this->_endTime, $type,
                $this->_limit, $status, $otherType);
            $this->_return = array_merge($this->_return, $deposit);
        }

        return $this->_return;
    }

    /**
     * transfer 额度转换记录
     *
     * @return array
     * @throws \think\exception\DbException
     */
    public function transfer(){
        if ($this->_return['errorCode'] == 0) {
            $request = Request::instance();
            $platform = $request->post('platform', 'ALL');
            $type = $request->post('type', 'ALL');
            $deposit = Casino::transferReport($this->_user['id'], $this->_startTime, $this->_endTime, $platform, $this->_limit, $type);
            $this->_return = array_merge($this->_return, $deposit);
        }

        return $this->_return;
    }
}
