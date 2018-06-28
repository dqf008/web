<?php

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/live.php';

class User
{
    public function __construct()
    {

    }

    public function getList()
    {
        $sql = 'select * from k_user';
        $query = DB::CONN()->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getinfo($uid)
    {
        $sql = 'select * from k_user where uid=:uid';
        $stmt = DB::CONN()->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function login($user, $password)
    {

    }

    public function update_user($uid, $param)
    {
        //$sql = 'update k_user set ';
    }

    public function Transfer($liveType, $money, $type)
    {
        echo 11;
        $userinfo = $this->getinfo($_SESSION['uid']);
        $str = Live::TypeName($liveType);
        $typeName = $str['title'];//真人平台名称
        $istype = $str['istype'];//数据库字段名--是否注册
        $zzusername = $str['zzusername'];//数据库字段名--平台帐号
        $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
        $res = Live::Transfer($userinfo[$zzusername],$userinfo[$zzpassword],$liveType,$type,$money);
        var_dump($res);
    }

    public function refresh_live($liveType)
    {
        $userinfo = $this->getinfo($_SESSION['uid']);
        $str = Live::TypeName($liveType);
        $typeName = $str['title'];//真人平台名称
        $istype = $str['istype'];//数据库字段名--是否注册
        $zzusername = $str['zzusername'];//数据库字段名--平台帐号
        $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
        $zzmoney = $str['zzmoney'];
        if ($userinfo[$istype] == 0) {
            $res = Live::RegLive($userinfo['username'], $liveType);
            if ($res['code'] == 0) {
                $userinfo[$zzusername] = $res['zzusername'];
                $userinfo[$zzpassword] = $res['zzpassword'];
            }
        }
        $res = Live::GetMoney($userinfo[$zzusername], $userinfo[$zzpassword], $liveType);
        if ($res['code'] == 0) {
            if ($res['money'] != $userinfo[$zzmoney]) {
                $sql = 'update k_user set ' . $zzmoney . '=:money where uid=:uid';
                $stmt = DB::CONN()->prepare($sql);
                $stmt->bindParam(':uid', $userinfo['uid']);
                $stmt->bindParam(':money', $res['money']);
                $stmt->execute();
            }
            return [
                'code' => 0,
                'data' => [
                    'typeName' => $typeName,
                    'zzUserName' => $userinfo[$zzusername],
                    'zzMoney' => $res['money']
                ]
            ];
        } else {
            return [
                'code' => $res['code'],
                'error' => $res['error']
            ];
        }
    }

    public function live_money($type = null)
    {
        $userinfo = $this->getinfo($_SESSION['uid']);
        if (empty($userinfo)) return ['code' => 1];
        $data['AG'] = $userinfo['agqmoney'];
        $data['BBIN'] = $userinfo['bbmoney'];
        $data['AGIN'] = $userinfo['agmoney'];
        $data['HG'] = $userinfo['hgmoney'];
        $data['OG'] = $userinfo['ogmoney'];
        $data['MAYA'] = $userinfo['mayamoney'];
        $data['PT'] = $userinfo['ptmoney'];
        $data['SHABA'] = $userinfo['shabamoney'];
        $data = $this->moneyFormat($data);
        if (!empty($type)) {
            return ['code' => 0, 'data' => $data[$type]];
        }
        return ['code' => 0, 'data' => $data];
    }

    private function moneyFormat($data)
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = sprintf('%.2f', $v);
            }
        } else {
            $data = sprintf('%.2f', $data);
        }
        return $data;
    }
}