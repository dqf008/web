<?php

namespace app\member\controller;

use app\common\Constant;
use app\common\Common as Comm;
use app\common\model\Db1_k_notice;
use think\Request;

class Common
{
    /**
     * notice 网站公告
     *
     * @return array
     * @throws \think\exception\DbException
     */
    public function notice()
    {
        $return = [
            'errorCode' => 0,
            'errorMsg' => Constant::ACTION_SUCCESS,
            'data' => [],
            'page' => [],
        ];
        $request = Request::instance();
        $limit = $request->post('limit', 5, 'intval');
        $db = new Db1_k_notice;
        $db->where('is_show', 1);
        $db->order('sort', 'DESC');
        $db->order('nid', 'DESC');
        $rows = $db->paginate($limit);

        $return['page'] = $rows->render();
        foreach ($rows as $row) {
            $return['data'][] = [
                'id' => $row['nid'],
                'content' => $row['msg'],
                'addTime' => $row['add_time'],
            ];
        }

        return $return;
    }

    /**
     * getGameList 获取游戏游戏列表
     *
     * @param string $type
     * @return array
     */
    public function getGameList($type = 'default')
    {
        $return = [
            'errorCode' => 0,
            'errorMsg' => Constant::ACTION_SUCCESS,
        ];
        switch ($type) {
            case 'lottery':
                $return['data'] = Comm::get_lottery_list();
                break;

            case 'casino':
            case 'slots':
                $casino = Comm::get_casino_list();
                $return['data'] = [];
                foreach ($casino as $id => $val) {
                    if ($val['type'] == $type) {
                        $return['data'][] = [
                            'id' => $id,
                            'name' => $val['name'],
                        ];
                    }
                }
                break;

            default:
                $return['errorCode'] = 1;
                $return['errorMsg'] = Constant::INVALID_ACTION;
                break;
        }

        return $return;
    }

    /**
     * getCasinoTransfer 获取平台游戏转账列表
     *
     * @return array
     */
    public function getCasinoTransfer()
    {
        $return = [
            'errorCode' => 0,
            'errorMsg' => Constant::ACTION_SUCCESS,
            'data' => [],
            'limit' => Comm::get_web_setting('casino.transfer'),
        ];
        $list = Comm::get_casino_transfer();
        foreach ($list as $key => $val) {
            $return['data'][] = [
                'key' => $key,
                'name' => $val['name'],
                'money' => '-',
                'api' => isset($val['api']) && ! empty($val['api']) ? $val['api'] : Constant::CASINO_DEFAULT_API,
                'col' => isset($val['col']) && ! empty($val['col']) ? $val['col'] : 1,
                'tips' => isset($val['tips']) && ! empty($val['tips']) ? $val['tips'] : null,
            ];
        }

        return $return;
    }

    /**
     * getTheme 获取会员中心主题
     *
     * @return array
     */
    public function getTheme()
    {
        return [
            'errorCode' => 0,
            'errorMsg' => Comm::get_web_setting('member.theme', 'default'),
        ];
    }
}
