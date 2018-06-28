<?php
defined('IN_AGENT') || exit('Access denied');

function valid_member($uid = 0, $time = 0, $min_days = 0)
{
    global $mydata1_db;

    $stmt = $mydata1_db->prepare('SELECT `time` FROM ((SELECT `m_make_time` AS `time` FROM `k_money` WHERE `uid`=:uid1 AND `m_make_time`<=:time1 AND (`type`=1 OR `type`=3) AND `status`=1 ORDER BY `m_make_time` DESC LIMIT 1) UNION ALL (SELECT `adddate` AS `addtime` FROM `huikuan` WHERE `uid`=:uid2 AND `adddate`<=:time2 AND `status`=1 ORDER BY `adddate` DESC LIMIT 1)) AS `temp` ORDER BY `time` DESC LIMIT 1');
    $stmt->execute([
        ':uid1' => $uid,
        ':time1' => date('Y-m-d 23:59:59', $time),
        ':uid2' => $uid,
        ':time2' => date('Y-m-d 23:59:59', $time),
    ]);
    if ($rows = $stmt->fetch()) {
        return strtotime($rows['time']) + ($min_days * 86400) >= $time;
    } else {
        return false;
    }
}

function get_agent_config($config = [])
{
    $return = [];
    $keys = [
        'ck_v1' => ['hyck', 'bet_amount', 1],
        'qk_v1' => ['hyqk', 'bet_amount', -1],
        'ty_v1' => ['xtty', 'valid_amount', 1],
        'ty_v2' => ['xtty', 'net_amount', -1],
        'lhc_v1' => ['lhc', 'valid_amount', 1],
        'lhc_v2' => ['lhc', 'net_amount', -1],
        'jsc_v1' => ['jscp', 'valid_amount', 1],
        'jsc_v2' => ['jscp', 'net_amount', -1],
        'ssc_v1' => ['ssc', 'valid_amount', 1],
        'ssc_v2' => ['ssc', 'net_amount', -1],
        'ptc_v1' => ['ptcp', 'valid_amount', 1],
        'ptc_v2' => ['ptcp', 'net_amount', -1],
        'zr_v1' => ['zrdz', 'valid_amount', 1],
        'zr_v2' => ['zrdz', 'net_amount', -1],
        'hl_v1' => ['hyhl', 'bet_amount', -1],
        'sxf_v1' => ['sxf', 'bet_amount', -1],
    ];
    foreach ($keys as $key => $val) {
        if (isset($config[$key]) && isset($config[$key.'r'])) {
            if ($config[$key] > 0) {
                switch ($config[$key.'r']) {
                    case 1:
                        $config[$key] /= 100;
                        break;
                    case 2:
                        $config[$key] /= 1000;
                        break;
                    case 3:
                        $config[$key] /= 10000;
                        break;
                }
                $return[] = [
                    'name' => $val[0],
                    'key' => $val[1],
                    'rate' => $val[2] * $config[$key],
                ];
            }
        }
    }

    return $return;
}

function get_child_agent_config($default = [], $groups = [], $child_groups = [])
{
    $return = [$default];
    foreach ($child_groups as $index => $id) {
        $return[] = isset($groups[$id]) && isset($groups[$id]['zdy_zshy']) && $groups[$id]['zdy_zshy'] == 1 ? get_agent_config($groups[$id]) : $return[$index];
    }

    return $return;
}

function get_agent_amount($config = [], $data = [])
{
    $return = 0;
    foreach ($config as $val) {
        $key = $val['name'];
        if (isset($data[$key]) && isset($data[$key]['data']) && isset($data[$key]['data'][$val['key']])) {
            $return += $data[$key]['data'][$val['key']] * $val['rate'];
        }
    }

    return $return;
}

function get_agent_groups($default = false)
{
    $groups = [];
    $child_groups = [];
    $stmt = $GLOBALS['mydata1_db']->query('SELECT `id`, `tid`, `username`, `default`, `value` FROM `agent_config` WHERE `uid`=0');
    while ($rows = $stmt->fetch()) {
        $rows['value'] = unserialize($rows['value']);
        $rows['value']['rows_name'] = $rows['username'];
        $rows['value']['rows_id'] = $rows['id'];
        $rows['value']['rows_tid'] = $rows['tid'];
        $groups[$rows['id']] = $rows['value'];
        $default && $rows['tid'] == 0 && $rows['default'] == 1 && $groups['default'] = $rows['value'];
        if ($rows['tid'] > 0) {
            isset($child_groups[$rows['tid']]) || $child_groups[$rows['tid']] = [];
            $child_groups[$rows['tid']][$rows['id']] = $rows['default'];
        }
    }
    foreach ($child_groups as $tid => $val) {
        if (isset($groups[$tid])) {
            asort($val);
            $groups[$tid]['child_groups'] = array_keys($val);
        }
    }

    return $groups;
}

function get_formula($config = [])
{
    $return = [];
    $text = [
        'hyck' => '有效存款',
        'hyqk' => '会员提款',
        'xtty' => '皇冠体育',
        'lhc' => '六合彩',
        'jscp' => '极速彩票',
        'ssc' => '时时彩',
        'ptcp' => '普通彩票',
        'zrdz' => '真人电子',
        'hyhl' => '红利派送',
        'sxf' => '手续费',
    ];
    $sub_text = [
        'bet_amount' => '投注金额',
        'net_amount' => '派彩金额',
        'valid_amount' => '有效投注额',
    ];
    $list = [];
    foreach ($config as $val) {
        $key = $val['name'];
        if (isset($text[$key]) && isset($sub_text[$val['key']])) {
            $i = chr(65 + count($list));
            $return[] = $i.' x '.($val['rate'] * 100).'%';
            if (in_array($key, ['hyck', 'hyqk', 'hyhl', 'sxf'])) {
                $list[] = $i.'：'.$text[$key];
            } else {
                $list[] = $i.'：'.$text[$key].$sub_text[$val['key']];
            }
        }
    }

    return '代理佣金 = '.implode(' + ', $return).'<br />'.implode('；', $list);
}
