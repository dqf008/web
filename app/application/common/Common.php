<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/4/27
 * Time: 13:37
 */

namespace app\common;

use think\Config;

/**
 * Class Common 公共方法类
 *
 * @package app\common
 */
class Common
{
    private static $_lottery = [
        ['key' => 'pk10', 'name' => '北京赛车PK拾'],
        ['key' => 'jssc', 'name' => '极速赛车'],
        ['key' => 'cqssc', 'name' => '重庆时时彩'],
        ['key' => 'jsssc', 'name' => '极速时时彩'],
        ['key' => 'xyft', 'name' => '幸运飞艇'],
        ['key' => 'gdkl10', 'name' => '广东快乐10分'],
        ['key' => 'shssl', 'name' => '上海时时乐'],
        ['key' => 'pl3', 'name' => '排列三'],
        ['key' => '3d', 'name' => '福彩3D'],
        ['key' => 'kl8', 'name' => '北京快乐8'],
        ['key' => 'qxc', 'name' => '七星彩'],
        ['key' => 'jslh', 'name' => '极速六合'],
        ['key' => 'marksix', 'name' => '六合彩'],
        ['key' => 'tjssc', 'name' => '天津时时彩'],
        ['key' => 'xjssc', 'name' => '新疆时时彩'],
        ['key' => 'jsk3', 'name' => '江苏快3'],
        ['key' => 'fjk3', 'name' => '福建快3'],
        ['key' => 'gxk3', 'name' => '广西快3'],
        ['key' => 'ahk3', 'name' => '安徽快3'],
        ['key' => 'shk3', 'name' => '上海快3'],
        ['key' => 'hbk3', 'name' => '湖北快3'],
        ['key' => 'hebk3', 'name' => '河北快3'],
        ['key' => 'jlk3', 'name' => '吉林快3'],
        ['key' => 'gzk3', 'name' => '贵州快3'],
        ['key' => 'bjk3', 'name' => '北京快3'],
        ['key' => 'gsk3', 'name' => '甘肃快3'],
        ['key' => 'nmgk3', 'name' => '内蒙快3'],
        ['key' => 'jxk3', 'name' => '江西快3'],
        ['key' => 'ffk3', 'name' => '分分快3'],
        ['key' => 'sfk3', 'name' => '超级快3'],
        ['key' => 'wfk3', 'name' => '好运快3'],
        ['key' => 'pcdd', 'name' => 'PC蛋蛋'],
        ['key' => 'cqkl10', 'name' => '重庆快乐10分'],
        ['key' => 'tjkl10', 'name' => '天津快乐10分'],
        ['key' => 'hnkl10', 'name' => '湖南快乐10分'],
        ['key' => 'sxkl10', 'name' => '山西快乐10分'],
        ['key' => 'ynkl10', 'name' => '云南快乐10分'],
        ['key' => 'gdsyxw', 'name' => '广东11选5'],
        ['key' => 'sdsyxw', 'name' => '山东11选5'],
        ['key' => 'fjsyxw', 'name' => '福建11选5'],
        ['key' => 'bjsyxw', 'name' => '北京11选5'],
        ['key' => 'ahsyxw', 'name' => '安徽11选5'],
    ];

    private static $_live = [
        'list' => [],
        'transfer' => [],
    ];

    private static $_setting = [
        'web' => [],
        'groups' => [],
        'finance' => [],
    ];

    /**
     * sum_arrays 合计相同结构数组
     *
     * @return array
     */
    public static function sum_arrays()
    {
        $return = [];
        $args = func_get_args();
        foreach ($args as $arg) {
            if (empty($return)) {
                $return = $arg;
            } else {
                foreach ($arg as $k => $v) {
                    if (! array_key_exists($k, $return)) {
                        $return[$k] = $v;
                    } else {
                        $return[$k] += $v;
                    }
                }
            }
        }

        return $return;
    }

    /**
     * checkDate 判断日期是否在指定天数内
     *
     * @param $date
     * @param int $time
     * @param int $limit
     * @return bool|false|string
     */
    public static function check_date($date, $time = 0, $limit = 30)
    {
        if ($time <= 0) {
            $time = time();
        }
        $date = strtotime($date);
        $limit *= 86400;
        $limit = $time - $limit - 86400;

        return $date > 0 && $date < $time + 86400 && $date > $limit ? date('Y-m-d', $date) : false;
    }

    /**
     * cut_title
     *
     * @param $title
     * @param int $length
     * @return string
     */
    public static function cut_title($title, $length = 3)
    {
        mb_internal_encoding('UTF-8');
        if (mb_strlen($title) <= $length) {
            return $title;
        } else {
            $tmpstr = mb_substr($title, 0, $length);
            while ($length <= mb_strlen($title)) {
                $tmpstr .= '*';
                $length++;
            }

            return $tmpstr;
        }
    }

    /**
     * cut_num
     *
     * @param $title
     * @param int $s
     * @param int $e
     * @return string
     */
    public static function cut_num($title, $s = 4, $e = 4)
    {
        mb_internal_encoding('UTF-8');
        $tmpstr = mb_substr($title, 0, $s);

        for ($i = 0; $i < (mb_strlen($title) - $s - $e); $i++) {
            $tmpstr .= '*';
        }

        return $tmpstr.mb_substr($title, mb_strlen($title) - $e);
    }

    /**
     * get_lottery_list 获取彩票列表
     *
     * @param bool $key
     * @return array
     */
    public static function get_lottery_list($key = false)
    {
        $return = self::$_lottery;
        if ($key) {
            $lottery = [];
            foreach ($return as $item) {
                $lottery[$item['key']] = $item['name'];
            }
            $return = $lottery;
        }

        return $return;
    }

    /**
     * get_casino_list 获取游戏平台列表
     *
     * @return array
     */
    public static function get_casino_list()
    {
        if (empty(self::$_live['list'])) {
            $lives = include(APP_PATH.'/../../cj/include/live.php');
            foreach ($lives as $id => $live) {
                self::$_live['list'][$id] = [
                    'name' => $live[1],
                    'tableName' => $live[0],
                    'type' => $live[2] == 'dz_rate' ? 'slots' : 'casino', // 暂时只区分真人视讯 & 电子游戏，后续考虑区分彩票游戏 & 体育赛事
                ];
            }
        }

        return self::$_live['list'];
    }

    /**
     * get_casino_transfer 获取额度转账列表
     *
     * @return mixed
     */
    public static function get_casino_transfer()
    {
        if (empty(self::$_live['transfer'])) {
            self::$_live['transfer'] = include(APP_PATH.'/../../cj/include/live.transfer.php');
        }

        return self::$_live['transfer'];
    }

    /**
     * html_encode 删除 HTML 代码
     *
     * @param $string
     * @return string
     */
    public static function html_encode($string)
    {
        return trim(strip_tags($string));
    }

    /**
     * get_web_setting 获取网站设置
     *
     * @param $get_key
     * @param null $get_default
     * @return null
     */
    public static function get_web_setting($get_key, $get_default = null)
    {
        if (empty(self::$_setting['web'])) {
            $keys = [
                'ck_limit' => 'deposit.limit',
                'qk_limit' => 'withdraw.limit',
                'qk_time_begin' => 'withdraw.time.0',
                'qk_time_end' => 'withdraw.time.1',
                'zh_low' => 'casino.transfer.min',
                'zh_high' => 'casino.transfer.max',
                'wxalipay' => 'finance.qrcode',
                'member_theme' => 'member.theme',
            ];
            $web_site = [];
            include(APP_PATH.'/../../cache/website.php');
            foreach ($keys as $k1 => $k2) {
                if (isset($web_site[$k1])) {
                    self::push_array(self::$_setting['web'], $k2, $web_site[$k1]);
                }
            }
        }

        return self::get_array(self::$_setting['web'], $get_key, $get_default);
    }

    /**
     * get_website_id 获取网站代号
     *
     * @return null
     */
    public static function get_website_id()
    {
        $site_id = null;
        include APP_PATH.'/../../cj/include/config.php';

        return $site_id;
    }

    /**
     * get_group_setting 获取会员组设置
     *
     * @param $get_key
     * @param int $get_gid
     * @param null $get_default
     * @return null
     */
    public static function get_group_setting($get_key, $get_gid = 0, $get_default = null)
    {
        if (! isset(self::$_setting['groups'][$get_gid]) || empty(self::$_setting['groups'][$get_gid])) {
            self::$_setting['groups'][$get_gid] = [];
            $group = APP_PATH.'/../../cache/group_'.$get_gid.'.php';
            if (file_exists($group)) {
                $keys = [
                    '提款次数' => 'withdraw.limit',
                ];
                $pk_db = [];
                include($group);
                foreach ($keys as $k1 => $k2) {
                    if (isset($pk_db[$k1])) {
                        self::push_array(self::$_setting['groups'][$get_gid], $k2, $pk_db[$k1]);
                    }
                }
            }
        }

        return self::get_array(self::$_setting['groups'][$get_gid], $get_key, $get_default);
    }

    /**
     * get_group_finance 获取会员组充值设置
     *
     * @param $get_key
     * @param null $get_default
     * @return null
     */
    public static function get_group_finance($get_key, $get_default = null)
    {
        if (! isset(self::$_setting['finance']) || empty(self::$_setting['finance'])) {
            self::$_setting['finance'] = [
                'deposit' => [],
                'transfer' => [],
                'qrcode' => [],
                'wechat' => [],
                'alipay' => [],
                'qq' => [],
                'jd' => [],
            ];
            /* 安全引用 Start */
            $error_reporting = ini_get('error_reporting'); // 原错误报告类型
            $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT']; // 原文档目录
            $getcwd = getcwd(); // 获取当前路径
            error_reporting(E_ALL & ~E_NOTICE); // 忽略 NOTICE 错误
            $ob_status = ob_get_status();
            if (empty($ob_status)) {
                ob_start(); // 开启缓存区
            }
            $_SERVER['DOCUMENT_ROOT'] = realpath(ROOT_PATH.'/../'); // 设置 DOCUMENT_ROOT 路径
            chdir($_SERVER['DOCUMENT_ROOT'].'/member/pay/cache'); // 切换到 cache 目录
            $db_user_utf8 = $db_user_gbk = Config::get('database.username'); // 设置数据库账户
            $db_pwd_utf8 = $db_pwd_gbk = Config::get('database.password'); // 设置数据库密码
            $file = APP_PATH.'/../../member/pay/moneyconfig.php';
            if (file_exists($file)) {
                $pay_online = 'default';
                $arr_online_config = [];
                include $file;
                if (isset($pay_online_type)) {
                    foreach ($pay_online_type as $gid => $item) {
                        if (! isset(self::$_setting['finance']['deposit'][$gid])) {
                            self::$_setting['finance']['deposit'][$gid] = [];
                        }
                        foreach ($item as $k => $val) {
                            if (isset($arr_online_config[$val])) {
                                self::$_setting['finance']['deposit'][$gid][] = [
                                    'code' => self::auth_code($val, 'ENCODE'),
                                    'name' => $arr_online_config[$val]['online_name'],
                                    'uri' => self::auth_code($arr_online_config[$val]['post_url'], 'ENCODE'),
                                ];
                            }
                        }
                    }
                }
            }
            $file = APP_PATH.'/../../cache/bank.php';
            if (file_exists($file)) {
                include $file;
                if (isset($bank)) {
                    foreach ($bank as $gid => $item) {
                        if (! isset(self::$_setting['finance']['transfer'][$gid])) {
                            self::$_setting['finance']['transfer'][$gid] = [];
                        }
                        foreach ($item as $k => $val) {
                            if (! isset($val['state']) || $val['state'] != false) {
                                $k = [
                                    'name' => $val['card_bankName'],
                                    'id' => $val['card_ID'],
                                    'username' => $val['card_userName'],
                                    'address' => $val['card_address'],
                                ];
                                $k['code'] = self::auth_code(json_encode($k), 'ENCODE');
                                self::$_setting['finance']['transfer'][$gid][] = $k;
                            }
                        }
                    }
                }
            }
            $file = APP_PATH.'/../../cache/bank2.php';
            if (self::get_web_setting('finance.qrcode') == 1 && file_exists($file)) {
                include $file;
                if (isset($bank)) {
                    foreach ($bank as $gid => $item) {
                        if (! isset(self::$_setting['finance']['qrcode'][$gid])) {
                            self::$_setting['finance']['qrcode'][$gid] = [];
                        }
                        foreach ($bank[$gid] as $k => $val) {
                            if (! isset($val['state']) || $val['state'] != false) {
                                $k = [
                                    'name' => $val['card_bankName'],
                                    'id' => $val['card_ID'],
                                    'nickName' => $val['card_name'],
                                    'img' => $val['card_img'],
                                    'qrcode' => true,
                                ];
                                switch (true) {
                                    case substr($k['name'], 0, 7) == 'wechat-':
                                        $k['name'] = substr($k['name'], 7);
                                        $get_code = 'wechat';
                                        break;

                                    case substr($k['name'], 0, 7) == 'alipay-':
                                        $k['name'] = substr($k['name'], 7);
                                        $get_code = 'alipay';
                                        break;

                                    case substr($k['name'], 0, 3) == 'qq-':
                                        $k['name'] = substr($k['name'], 3);
                                        $get_code = 'qq';
                                        break;

                                    case substr($k['name'], 0, 3) == 'jd-':
                                        $k['name'] = substr($k['name'], 3);
                                        $get_code = 'jd';
                                        break;

                                    default:
                                        $get_code = 'qrcode';
                                        break;
                                }
                                $k['code'] = self::auth_code(json_encode($k), 'ENCODE');
                                self::$_setting['finance'][$get_code][$gid][] = $k;
                            }
                        }
                    }
                }
            }
            error_reporting($error_reporting); // 恢复原错误报告类型
            $_SERVER['DOCUMENT_ROOT'] = $DOCUMENT_ROOT; // 恢复原文档目录
            chdir($getcwd); // 切换到原路径
            if (empty($ob_status)) {
                ob_end_clean(); // 清理并关闭缓存区
            } else {
                ob_clean(); // 清理缓存区
            }
            /* 安全引用 End */
        }

        return self::get_array(self::$_setting['finance'], $get_key, $get_default);
    }

    /**
     * push_array 多维数组添加数据
     *
     * @param $array
     * @param $key
     * @param $val
     */
    public static function push_array(&$array, $key, $val)
    {
        $keys = explode('.', $key);
        $key = $keys[0];
        if (count($keys) > 1) {
            unset($keys[0]);
            $keys = implode('.', $keys);
            if (! isset($array[$key])) {
                $array[$key] = [];
            }
            self::push_array($array[$key], $keys, $val);
        } else {
            $array[$key] = $val;
        }
    }

    /**
     * get_array 多维数组获取数据
     *
     * @param $array
     * @param $key
     * @param null $default
     * @return null
     */
    public static function get_array($array, $key = null, $default = null)
    {
        if (empty($key)) {
            return empty($array) ? $default : $array;
        } else {
            $keys = explode('.', $key);
            $key = $keys[0];
            if (count($keys) > 1) {
                unset($keys[0]);
                if (isset($array[$key])) {
                    $keys = implode('.', $keys);

                    return self::get_array($array[$key], $keys, $default);
                } else {
                    return $default;
                }
            } else {
                return isset($array[$key]) ? $array[$key] : $default;
            }
        }
    }

    public static function auth_code($string, $operation = 'DECODE', $key = 'default', $expiry = 0)
    {
        $ckey_length = 4;

        $key == 'default' && session_name() && $key = session_name();
        $key = md5($key);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()),
            -$ckey_length)) : '';

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d',
                $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = [];
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10,
                    16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.str_replace('=', '', base64_encode($result));
        }
    }
}