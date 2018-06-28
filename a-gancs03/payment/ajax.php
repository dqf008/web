<?php
/**
 * Created by PhpStorm.
 * User: empty
 * Date: 2018/6/12
 * Time: 下午4:16
 */

header('Content-Type: application/json; charset=UTF-8');

include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('cwgl');

include __DIR__.'/Api.php';

use Admin\Payment\Api;

$action = get_input('action', 'default');
$output = [
    'code' => 500,
    'message' => '模块或动作不存在',
];
switch (get_input('model', 'default')) {
    case 'common':
        switch ($action) {
            case 'config':
                $output = [
                    'code' => 200,
                    'message' => [
                        'groups' => [],
                        'types' => [
                            'bank' => '网银',
                            'alipay' => '支付宝',
                            'alipay_h5' => '支付宝H5',
                            'wechat' => '微信',
                            'wechat_h5' => '微信H5',
                            'qq' => 'QQ钱包',
                            'qq_h5' => 'QQ钱包H5',
                            'jd' => '京东钱包',
                            'jd_h5' => '京东钱包H5',
                            'unionpay' => '银联钱包',
                            'unionpay_h5' => '银联钱包H5',
                        ],
                    ],
                ];
                $stmt = $mydata1_db->query('SELECT `id`, `name` FROM `k_group` ORDER BY `id` DESC');
                while ($rows = $stmt->fetch()) {
                    $output['message']['groups']['g'.$rows['id']] = $rows['name'];
                }
                break;
        }
        break;

    case 'api':
        switch ($action) {
            case 'refresh':
                if (check_last_time('api.payment.lastTime')) {
                    $output = Api::all();
                    if (array_key_exists('code', $output)) {
                        if ($output['code'] == 200) {
                            $stmt = $mydata1_db->query('SELECT `id`, `activate` FROM `payments_list` ORDER BY `id` DESC');
                            $ids = [];
                            while ($rows = $stmt->fetch()) {
                                $ids[$rows['id']] = $rows['activate'] == 1;
                            }
                            $values = [];
                            $params = [];
                            foreach ($output['message'] as $key => $item) {
                                $values[] = '(?, ?, ?, ?, ?, 1, ?)';
                                $params[] = $item['id'];
                                $params[] = $item['name'];
                                $params[] = json_encode($item['forms']);
                                $params[] = json_encode($item['support']);
                                $params[] = $item['token'];
                                $params[] = json_encode($item['extend']);
                                unset($ids[$item['id']]);
                                unset($output['message'][$key]['token']);
                            }
                            if (! empty($values)) {
                                $sql = 'REPLACE INTO `payments_list` (`id`, `name`, `forms`, `support`, `token`, `activate`, `extend`) VALUES ';
                                $sql .= implode(', ', $values);
                                $stmt = $mydata1_db->prepare($sql);
                                $stmt->execute($params);
                            }
                            if (! empty($ids)) {
                                $ids = array_keys($ids);
                                $mydata1_db->query('UPDATE `payments_list` SET `activate`=0 WHERE `id` IN ('.implode(', ',
                                        $ids).') AND `activate`=1');
                                $mydata1_db->query('UPDATE `payments_config` SET `activate`=0 WHERE `payment_id` IN ('.implode(', ',
                                        $ids).') AND `activate`=1');
                            }
                        } else {
                            if ($output['code'] == 404) {
                                $mydata1_db->query('UPDATE `payments_list` SET `activate`=0 WHERE `activate`=1');
                                $mydata1_db->query('UPDATE `payments_config` SET `activate`=0 WHERE `activate`=1');
                                $output = [
                                    'code' => 200,
                                    'message' => [],
                                ];
                            }
                        }
                        admin::insert_log($_SESSION['adminid'], '更新了支付通道列表');
                    }
                } else {
                    $output = [
                        'code' => 500,
                        'message' => '操作频繁，请稍后重试',
                    ];
                }
                break;

            case 'cache':
                $output = ['code' => 200, 'message' => []];
                $stmt = $mydata1_db->query('SELECT * FROM `payments_list` WHERE `activate`=1 ORDER BY `id` DESC');
                while ($rows = $stmt->fetch()) {
                    $output['message'][] = [
                        'id' => $rows['id'],
                        'name' => $rows['name'],
                        'forms' => json_decode($rows['forms'], true),
                        'support' => json_decode($rows['support'], true),
                    ];
                }
                break;

            case 'token':
                $output = [
                    'code' => 500,
                    'message' => 'ID 不存在或无效，请刷新列表重试',
                ];
                $id = get_input('data.id', 0, 'integer');
                if ($id > 0) {
                    $stmt = $mydata1_db->prepare('SELECT `name`, `id` FROM `payments_list` WHERE `id`=:id');
                    $stmt->execute([':id' => $id]);
                    $rows = $stmt->fetch();
                    if (! empty($rows)) {
                        if (check_last_time('api.payment.token_'.$rows['id'])) {
                            $output = Api::token($rows['id'], true);
                            if (array_key_exists('code', $output) && $output['code'] == 200) {
                                $stmt = $mydata1_db->prepare('UPDATE `payments_list` SET `token`=:token WHERE `id`=:id');
                                $stmt->execute([
                                    ':id' => $rows['id'],
                                    ':token' => $output['message']['token'],
                                ]);
                                unset($output['message']['token']);
                                admin::insert_log($_SESSION['adminid'], '更换了 #'.$id.' 通道的 Token');
                            }
                        } else {
                            $output = [
                                'code' => 500,
                                'message' => '操作频繁，请稍后重试',
                            ];
                        }
                    }
                }
                break;

            case 'close':
                $id = get_input('data.id', 0, 'integer');
                $stmt = $mydata1_db->prepare('UPDATE `payments_config` SET `activate`=0 WHERE `activate`=1 AND `payment_id`=?');
                $stmt->execute([$id]);
                $output = [
                    'code' => 200,
                    'message' => '停用成功',
                ];
                admin::insert_log($_SESSION['adminid'], '一键停用 #'.$id.' 通道的全部商户');
                break;
        }
        break;

    case 'config':
        switch ($action) {
            case 'add':
                $output = [
                    'code' => 500,
                    'message' => '表单无效，请刷新页面重试',
                ];
                $id = get_input('data.id', 0, 'integer');
                if ($id > 0) {
                    switch (false) {
                        case ($stmt = $mydata1_db->prepare('SELECT `id`, `name` FROM `payments_list` WHERE `id`=:id AND `activate`=1')):
                        case ($stmt->execute([':id' => $id])):
                        case ($rows = $stmt->fetch()):
                            $output['message'] = '通道无效或不存在';
                            break;

                        default:
                            $groups = [];
                            //foreach (get_input('data.groups', [], 'check') as $id => $activate) {
                            //    if ($activate == true) {
                            //        $id = intval(substr($id, 1));
                            //        if ($id > 0) {
                            //            $groups[] = $id;
                            //        }
                            //    }
                            //}
                            $params = [];
                            $params[] = $rows['id'];
                            $params[] = $rows['name'];
                            $params[] = get_input('data.display', '', 'html');
                            $params[] = '[]';
                            //$params[] = get_input('data.support', '[]', 'json');
                            $params[] = get_input('data.remark', '', 'html');
                            $params[] = get_input('data.extend', '[]', 'json');
                            $stmt = $mydata1_db->prepare('INSERT INTO `payments_config` (`payment_id`, `name`, `display`, `support`, `activate`, `remark`, `extend`) VALUES (?, ?, ?, ?, 0, ?, ?)');
                            $stmt->execute($params);
                            //if (! empty($groups)) {
                            //    $last_id = $mydata1_db->lastInsertId();
                            //    $sql = '('.$last_id.', '.implode(', 1), ('.$last_id.', ', $groups).', 1)';
                            //    $mydata1_db->query('INSERT INTO `payments_group` (`config_id`, `group_id`, `activate`) VALUES '.$sql);
                            //}
                            $output = [
                                'code' => 200,
                                'message' => '添加成功',
                            ];
                            admin::insert_log($_SESSION['adminid'], '从 #'.$id.' 通道添加了新商户');
                            break;
                    }
                }
                break;

            case 'list':
                $output = [
                    'code' => 200,
                    'message' => [],
                ];
                //$config = [];
                //$stmt = $mydata1_db->query('SELECT `c`.*, `g`.`group_id` FROM `payments_config` AS `c` LEFT JOIN `payments_group` AS `g` ON `c`.`id`=`g`.`config_id` ORDER BY `c`.`activate` DESC, `c`.`id` DESC');
                //while ($rows = $stmt->fetch()) {
                //    if (! isset($config[$rows['id']])) {
                //        $config[$rows['id']] = [
                //            'id' => $rows['id'],
                //            'payment_id' => $rows['payment_id'],
                //            'name' => $rows['name'],
                //            'remark' => $rows['remark'],
                //            'display' => $rows['display'],
                //            'support' => json_decode($rows['support'], true),
                //            'groups' => [],
                //            'extend' => json_decode($rows['extend'], true),
                //            'activate' => $rows['activate'] == 1,
                //        ];
                //    }
                //    if (! empty($rows['group_id'])) {
                //        $config[$rows['id']]['groups'][] = $rows['group_id'];
                //    }
                //}
                //foreach ($config as $item) {
                //    $output['message'][] = $item;
                //}
                $stmt = $mydata1_db->query('SELECT * FROM `payments_config` ORDER BY `activate` DESC, `id` DESC');
                while ($rows = $stmt->fetch()) {
                    $output['message'][] = [
                        'id' => $rows['id'],
                        'payment_id' => $rows['payment_id'],
                        'name' => $rows['name'],
                        'remark' => $rows['remark'],
                        'display' => $rows['display'],
                        'support' => json_decode($rows['support'], true),
                        'groups' => [],
                        'extend' => json_decode($rows['extend'], true),
                        'activate' => $rows['activate'] == 1,
                    ];
                }
                break;

            case 'group':
                $output = [
                    'code' => 500,
                    'message' => '数据错误，请刷新列表重试',
                ];
                $id = get_input('data.id', 0, 'integer');
                if ($id > 0) {
                    $groups = [];
                    $stmt = $mydata1_db->prepare('SELECT `g`.* FROM `payments_group` AS `g` LEFT JOIN `payments_config` AS `c` ON `g`.`config_id`=`c`.`id` WHERE `c`.`id`=?');
                    $stmt->execute([$id]);
                    while ($rows = $stmt->fetch()) {
                        $groups[$rows['group_id']] = [
                            'id' => $rows['id'],
                            'activate' => $rows['activate'] == 1,
                        ];
                    }
                    $type = get_input('data.type');
                    if ($type == 'save') {
                        $update = [];
                        $add = [];
                        foreach (get_input('data.groups', [], 'check') as $gid => $activate) {
                            $gid = intval(substr($gid, 1));
                            if ($gid > 0) {
                                $activate = $activate == true;
                                if (isset($groups[$gid])) {
                                    if ($activate != $groups[$gid]['activate']) {
                                        $update[$groups[$gid]['id']] = $activate ? 1 : 0;
                                    }
                                } else {
                                    $add[] = '('.implode(', ', [$id, $gid, $activate ? 1 : 0]).')';
                                }
                            }
                        }
                        if (! empty($update)) {
                            foreach ($update as $id => $activate) {
                                $stmt = $mydata1_db->prepare('UPDATE `payments_group` SET `activate`=? WHERE `id`=?');
                                $stmt->execute([$activate, $id]);
                            }
                        }
                        if (! empty($add)) {
                            $add = implode(', ', $add);
                            $mydata1_db->query('INSERT INTO `payments_group` (`config_id`, `group_id`, `activate`) VALUES '.$add);
                        }
                        $output = [
                            'code' => 200,
                            'message' => '保存成功',
                        ];
                        admin::insert_log($_SESSION['adminid'], '修改了 #'.$id.' 商户的代理组信息');
                    } else {
                        $output = [
                            'code' => 200,
                            'message' => [],
                        ];
                        foreach ($groups as $id => $val) {
                            $output['message']['g'.$id] = $val['activate'];
                        }
                    }
                }
                break;

            case 'save':
            case 'support':
                $output = [
                    'code' => 500,
                    'message' => '数据错误，请刷新列表重试',
                ];
                $id = get_input('data.id', 0, 'integer');
                if ($id > 0) {
                    if ($action == 'support') {
                        $stmt = $mydata1_db->prepare('UPDATE `payments_config` SET `support`=? WHERE `id`=?');
                        $stmt->execute([get_input('data.support', '[]', 'json'), $id]);
                        admin::insert_log($_SESSION['adminid'], '修改了 #'.$id.' 商户的支持类型');
                    } else {
                        $stmt = $mydata1_db->prepare('UPDATE `payments_config` SET `display`=?, `remark`=?, `extend`=?  WHERE `id`=?');
                        $stmt->execute([
                            get_input('data.display', '', 'html'),
                            get_input('data.remark', '', 'html'),
                            get_input('data.extend', '[]', 'json'),
                            $id,
                        ]);
                        admin::insert_log($_SESSION['adminid'], '修改了 #'.$id.' 商户的配置信息');
                    }
                    $output = [
                        'code' => 200,
                        'message' => '保存成功',
                    ];
                }
                break;

            case 'change':
                $output = [
                    'code' => 500,
                    'message' => '数据错误，请刷新列表重试',
                ];
                $id = get_input('data.id', 0, 'integer');
                if ($id > 0) {
                    $stmt = $mydata1_db->prepare('SELECT `c`.`id` FROM `payments_config` AS `c` LEFT JOIN `payments_list` AS `l` ON `c`.`payment_id`=`l`.`id` WHERE `l`.`activate`=1 AND `c`.`id`=?');
                    $stmt->execute([$id]);
                    if ($rows = $stmt->fetch()) {
                        $stmt = $mydata1_db->prepare('UPDATE `payments_config` SET `activate`=:activate WHERE `id`=:id');
                        $stmt->execute([
                            ':id' => $rows['id'],
                            ':activate' => get_input('data.activate') == true,
                        ]);
                        $output = [
                            'code' => 200,
                            'message' => '切换成功',
                        ];
                        admin::insert_log($_SESSION['adminid'], '切换 #'.$id.' 商户的显示状态');
                    } else {
                        $output['message'] = '通道无效或不可用';
                    }
                }
                break;

            case 'delete':
                $output = [
                    'code' => 500,
                    'message' => '数据错误，请刷新列表重试',
                ];
                $id = get_input('data.id', 0, 'integer');
                if ($id > 0) {
                    $stmt = $mydata1_db->prepare('DELETE FROM `payments_config` WHERE `id`=?');
                    $stmt->execute([$id]);
                    $stmt = $mydata1_db->prepare('DELETE FROM `payments_group` WHERE `config_id`=?');
                    $stmt->execute([$id]);
                    $output = [
                        'code' => 200,
                        'message' => '删除成功',
                    ];
                    admin::insert_log($_SESSION['adminid'], '删除了 #'.$id.' 商户的配置信息');
                }
                break;
        }
        break;

    case 'order':
        switch ($action) {
            case 'get':
                $output = [
                    'code' => 500,
                    'message' => '数据错误，请刷新列表重试',
                ];
                $orderId = get_input('data.order_id');
                if (! empty($orderId)) {
                    if (check_last_time('api.payment.order.get.'.$orderId)) {
                        $output = Api::order($orderId);
                        if ($output['code'] == 200) {
                            $output['message']['created'] = date('Y-m-d H:i:s',
                                    $output['message']['created']).' / '.date('Y-m-d H:i:s',
                                    $output['message']['created'] + 43200);
                            $output['message']['updated'] = date('Y-m-d H:i:s',
                                    $output['message']['updated']).' / '.date('Y-m-d H:i:s',
                                    $output['message']['updated'] + 43200);
                        }
                    } else {
                        $output = [
                            'code' => 500,
                            'message' => '操作频繁，请稍后重试',
                        ];
                    }
                }
                break;

            case 'update':
                $output = [
                    'code' => 500,
                    'message' => '数据错误，请刷新列表重试',
                ];
                $orderId = get_input('data.order_id');
                if (! empty($orderId)) {
                    if (check_last_time('api.payment.order.update.'.$orderId)) {
                        $output = Api::order($orderId, true);
                        admin::insert_log($_SESSION['adminid'], '更新「'.$orderId.'」订单状态');
                    } else {
                        $output = [
                            'code' => 500,
                            'message' => '操作频繁，请稍后重试',
                        ];
                    }
                }
                break;

            case 'notify':
                $output = [
                    'code' => 500,
                    'message' => '数据错误，请刷新列表重试',
                ];
                $orderId = get_input('data.order_id');
                if (! empty($orderId)) {
                    if (check_last_time('api.payment.order.notify.'.$orderId)) {
                        $output = Api::notify($orderId);
                        admin::insert_log($_SESSION['adminid'], '发起「'.$orderId.'」订单通知请求');
                    } else {
                        $output = [
                            'code' => 500,
                            'message' => '操作频繁，请稍后重试',
                        ];
                    }
                }
                break;
        }
        break;
}

function check_last_time($key)
{
    if (Api::debug()) {
        return true;
    } else {
        if (array_key_exists($key, $_SESSION) && $_SESSION[$key] > time()) {
            return false;
        } else {
            $_SESSION[$key] = 10 + time();

            return true;
        }
    }
}

function get_input($keys = null, $default = null, $action = null)
{
    if (! array_key_exists('_G', $GLOBALS)) {
        $return = file_get_contents('php://input');
        $return = json_decode($return, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            $return = [];
        }
        $GLOBALS['_G'] = $return;
    } else {
        $return = $GLOBALS['_G'];
    }
    if (! empty($keys)) {
        $keys = explode('.', $keys);
        foreach ($keys as $key) {
            if (! empty($key)) {
                if (array_key_exists($key, $return)) {
                    $return = $return[$key];
                } else {
                    $return = $default;
                    break;
                }
            }
        }
    }
    switch ($action) {
        case 'html':
            if (gettype($return) == 'string') {
                $return = trim(strip_tags($return));
            } else {
                $return = $default;
            }
            break;

        case 'json':
            if (is_array($return)) {
                $return = json_encode($return);
            } else {
                $return = $default;
            }
            break;

        case 'array':
            if (gettype($return) == 'string') {
                $return = json_decode($return, true);
                if (json_last_error() != JSON_ERROR_NONE) {
                    $return = $default;
                }
            } else {
                $return = $default;
            }
            break;

        case 'integer':
            if (filter_var($return, FILTER_VALIDATE_INT)) {
                $return = intval($return);
            } else {
                $return = $default;
            }
            break;

        case 'type':
            if (gettype($return) != gettype($default)) {
                $return = $default;
            }
            break;
    }

    return $return;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
