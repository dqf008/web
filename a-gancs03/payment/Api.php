<?php
/**
 * Created by PhpStorm.
 * User: empty
 * Date: 2018/6/12
 * Time: 下午2:56
 */

namespace Admin\Payment;

class Api
{
    static protected $debug = false;

    static protected $debug_config = [
        'api' => 'http://10.211.55.5',
        'host' => 'api.local.igame007.net',
    ];

    static protected $config = [
        'api' => '207.148.46.181',
        'host' => 'api.aibo-pay.com',
    ];

    static protected $api;

    static protected $website_id;

    static protected $timeout = 5;

    static public function debug()
    {
        return self::$debug;
    }

    static public function get($action, $data = [])
    {
        return self::_curl($action, 'GET', $data);
    }

    static public function post($action, $data = [])
    {
        return self::_curl($action, 'POST', $data);
    }

    static public function put($action, $data = [])
    {
        return self::_curl($action, 'PUT', $data);
    }

    static public function delete($action, $data = [])
    {
        return self::_curl($action, 'DELETE', $data);
    }

    static private function _curl($action, $method = 'GET', $data = [], $header = [])
    {
        if (empty(self::$website_id)) {
            $site_id = null;
            include '../../cj/include/config.php';
            self::$website_id = $site_id;
        }
        if (self::$debug) {
            self::$api = self::$debug_config['api'];
            $header = array_merge($header, [
                'Host: '.self::$debug_config['host'],
            ]);
        } else {
            self::$api = self::$config['api'];
            $header = array_merge($header, [
                'Host: '.self::$config['host'],
            ]);
        }
        if (substr(self::$api, -1) == '/') {
            $action = self::$api.$action;
        } else {
            $action = self::$api.(substr($action, 0, 1) == '/' ? '' : '/').$action;
        }
        $opt = [
            CURLOPT_URL => $action,
            CURLOPT_TIMEOUT => self::$timeout,
            CURLOPT_HTTPHEADER => array_merge($header, [
                'Aibo-Website-Id: '.self::$website_id,
            ]),
            CURLOPT_RETURNTRANSFER => true,
        ];
        if (substr($opt[CURLOPT_URL], 0, 8) == 'https://') {
            $opt[CURLOPT_SSL_VERIFYPEER] = false;
            $opt[CURLOPT_SSL_VERIFYHOST] = false;
        }
        $method = strtoupper($method);
        switch ($method) {
            case 'POST':
                $opt[CURLOPT_POST] = true;
                $opt[CURLOPT_POSTFIELDS] = http_build_query($data);
                break;

            case 'PUT':
            case 'DELETE':
                $opt[CURLOPT_CUSTOMREQUEST] = $method;
                $opt[CURLOPT_POSTFIELDS] = http_build_query($data);
                break;

            default:
                if (! empty($data)) {
                    $info = parse_url($opt[CURLOPT_URL]);
                    if (array_key_exists('query', $info)) {
                        $opt[CURLOPT_URL] .= '&';
                    } else {
                        if (substr($opt[CURLOPT_URL], -1) != '?') {
                            $opt[CURLOPT_URL] .= '?';
                        }
                    }
                    $opt[CURLOPT_URL] .= http_build_query($data);
                }
                break;
        }
        $ch = curl_init();
        curl_setopt_array($ch, $opt);
        $result = curl_exec($ch);
        $return = json_decode($result, true);
        if (curl_errno($ch)) {
            if (json_last_error() != JSON_ERROR_NONE) {
                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $return = [
                    'code' => $code,
                    'message' => '连接失败，错误代码：'.$code,
                ];
            }
        } else {
            if (json_last_error() != JSON_ERROR_NONE) {
                $return = [
                    'code' => '500',
                    'message' => '内容解析失败',
                ];
            }
        }
        curl_close($ch);
        if (empty($return)) {
            $return = [
                'code' => '-1',
                'message' => '连接超时',
            ];
        }
        if (self::$debug) {
            $return['$result'] = $result;
        }

        return $return;
    }

    static public function all()
    {
        return self::get('/api/platform/payments');
    }

    static public function token($id = 0, $update = false)
    {
        $url = '/api/platform/payments/'.$id;
        if ($update) {
            return self::put($url);
        } else {
            return self::get($url);
        }
    }

    static public function order($id, $update = false)
    {
        $url = '/api/platform/orders/'.$id;
        if ($update) {
            return self::put($url);
        } else {
            return self::get($url);
        }
    }

    static public function notify($id)
    {
        return self::post('/api/platform/orders/', [
            'id' => $id,
            'domain' => $_SERVER['HTTP_HOST'],
            'scheme' => isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http',
        ]);
    }
}
