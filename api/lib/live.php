<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/2
 * Time: 10:08
 */

require_once __DIR__ . '/conf.php';
require_once __DIR__ . '/rpcClient.php';

class Live
{
    private static $_client;

    public static function TypeName($type)
    {
        $str = array();
        switch ($type) {
            case 'AGIN':
                $str['title'] = 'AG国际厅';
                $str['istype'] = 'isag';
                $str['zzusername'] = 'agUserName';
                $str['zzpassword'] = 'agPassWord';
                $str['zzmoney'] = 'agmoney';
                $str['zztime'] = 'agAddtime';
                break;
            case 'AG':
                $str['title'] = 'AG极速厅';
                $str['istype'] = 'isagq';
                $str['zzusername'] = 'agqUserName';
                $str['zzpassword'] = 'agqPassWord';
                $str['zzmoney'] = 'agqmoney';
                $str['zztime'] = 'agqAddtime';
                break;
            case 'BBIN':
                $str['title'] = 'BB波音厅';
                $str['istype'] = 'isbbin';
                $str['zzusername'] = 'bbinUserName';
                $str['zzpassword'] = 'bbinPassWord';
                $str['zzmoney'] = 'bbmoney';
                $str['zztime'] = 'bbinAddtime';
                break;
            case 'HG':
                $str['title'] = 'HG名人厅';
                $str['istype'] = 'ishg';
                $str['zzusername'] = 'hgUserName';
                $str['zzpassword'] = 'hgPassWord';
                $str['zzmoney'] = 'hgmoney';
                $str['zztime'] = 'hgAddtime';
                break;
            case 'OG':
                $str['title'] = 'OG东方厅';
                $str['istype'] = 'isog';
                $str['zzusername'] = 'ogUserName';
                $str['zzpassword'] = 'ogPassWord';
                $str['zzmoney'] = 'ogmoney';
                $str['zztime'] = 'ogAddtime';
                break;
            case 'MAYA':
                $str['title'] = '玛雅娱乐厅';
                $str['istype'] = 'ismaya';
                $str['zzusername'] = 'mayaUserName';
                $str['zzpassword'] = 'mayaGameMemberID';//游戏ID
                $str['zzmoney'] = 'mayamoney';
                $str['zztime'] = 'mayaAddtime';
                break;
            case 'MW':
                $str['title'] = 'MW游戏';
                $str['istype'] = 'ismw';
                $str['zzusername'] = 'mwUserName';
                $str['zzpassword'] = 'mwPassWord';
                $str['zzmoney'] = 'mwmoney';
                $str['zztime'] = 'mwAddtime';
                break;
            case 'MG':
                $str['title'] = 'MG电子游戏';
                $str['istype'] = 'ismg';
                $str['zzusername'] = 'mgUserName';
                $str['zzpassword'] = 'mgPassWord';
                $str['zzmoney'] = 'mgmoney';
                $str['zztime'] = 'mgAddtime';
                break;
            case 'KG':
                $str['title'] = 'KG游戏';
                $str['istype'] = 'iskg';
                $str['zzusername'] = 'kgUserName';
                $str['zzpassword'] = 'kgPassWord';
                $str['zzmoney'] = 'kgmoney';
                $str['zztime'] = 'kgAddtime';
                break;
            case 'PT':
                $str['title'] = 'PT电子游戏';
                $str['istype'] = 'ispt';
                $str['zzusername'] = 'ptUserName';
                $str['zzpassword'] = 'ptPassWord';
                $str['zzmoney'] = 'ptmoney';
                $str['zztime'] = 'ptAddtime';
                break;
            case 'SHABA':
                $str['title'] = '沙巴体育';
                $str['istype'] = 'isshaba';
                $str['zzusername'] = 'shabaUserName';
                $str['zzpassword'] = 'shabaPassWord';
                $str['zzmoney'] = 'shabamoney';
                $str['zztime'] = 'shabaAddtime';
                break;
            case 'HUNTER':
                $str['zzmoney'] = 'agmoney';
                $str['zztime'] = 'agAddtime';
                break;
            case 'XIN':
                $str['zzmoney'] = 'agmoney';
                $str['zztime'] = 'agAddtime';
                break;
            case 'IPM':
                $str['title'] = 'IPM体育';
                $str['istype'] = 'isipm';
                $str['zzusername'] = 'ipmUserName';
                $str['zzpassword'] = 'ipmPassWord';
                $str['zzmoney'] = 'ipmmoney';
                $str['zztime'] = 'ipmAddtime';
                break;
        }
        return $str;
    }

    public static function zzType($type, $username, $password)
    {
        $type = strtoupper($type);
        $par = array();

        switch ($type) {
            case 'AGIN':
                $par['params'][':agUserName'] = $username;
                $par['params'][':agPassWord'] = $password;
                $par['strsql'] = 'agUserName = :agUserName,agPassWord=:agPassWord,isag=1,agAddtime=now()';
                $par['where'] = 'isag=0';
                break;
            case 'AG':
                $par['params'][':agqUserName'] = $username;
                $par['params'][':agqPassWord'] = $password;
                $par['strsql'] = 'agqUserName = :agqUserName,agqPassWord=:agqPassWord,isagq=1,agqAddtime=now()';
                $par['where'] = 'isagq=0';
                break;
            case 'BBIN':
                $par['params'][':bbinUserName'] = $username;
                $par['params'][':bbinPassWord'] = $password;
                $par['strsql'] = 'bbinUserName = :bbinUserName,bbinPassWord=:bbinPassWord,isbbin=1,bbinAddtime=now()';
                $par['where'] = 'isbbin=0';
                break;
            case 'HG':
                $par['params'][':hgUserName'] = $username;
                $par['params'][':hgPassWord'] = $password;
                $par['strsql'] = 'hgUserName = :hgUserName,hgPassWord=:hgPassWord,ishg=1,hgAddtime=now()';
                $par['where'] = 'ishg=0';
                break;
            case 'OG':
                $par['params'][':ogUserName'] = $username;
                $par['params'][':ogPassWord'] = $password;
                $par['strsql'] = 'ogUserName = :ogUserName,ogPassWord=:ogPassWord,isog=1,ogAddtime=now()';
                $par['where'] = 'isog=0';
                break;
            case 'SHABA':
                $par['params'][':shabaUserName'] = $username;
                $par['params'][':shabaPassWord'] = $password;
                $par['strsql'] = 'shabaUserName = :shabaUserName,shabaPassWord=:shabaPassWord,isshaba=1,shabaAddtime=now()';
                $par['where'] = 'isshaba=0';
                break;
            case 'MW':
                $par['params'][':mwUserName'] = $username;
                $par['params'][':mwPassWord'] = $password;
                $par['strsql'] = 'mwUserName = :mwUserName,mwPassWord=:mwPassWord,ismw=1,mwAddtime=now()';
                $par['where'] = 'ismw=0';
                break;
            case 'PT':
                $par['params'][':ptUserName'] = $username;
                $par['params'][':ptPassWord'] = $password;
                $par['strsql'] = 'ptUserName = :ptUserName,ptPassWord=:ptPassWord,ispt=1,ptAddtime=now()';
                $par['where'] = 'ispt=0';
                break;
        }
        return $par;
    }

    public static function Transfer($zzusername, $zzpassword, $liveType, $type, $money)
    {
        $money = sprintf("%.2f", $money);
        $billno = self::get_billno_live();
        $res = self::Client()->prelivegiro(Conf::WEB_ID(), $zzusername, $zzpassword, $liveType, $billno, $type, $money);
        var_dump($res);

    }

    public static function Client()
    {
        if (!isset(self::$_client)) {
            self::InitClient();
        }
        return self::$_client;
    }

    public static function InitClient()
    {
        $client = new RpcClient();
        self::$_client = $client;
    }

    public static function RegLive($username, $type)
    {
        if ($type == 'MAYA') {
            return self::RegMayaLive($username, $type);
        }
        $data = [];
        $res = self::Client()->livereg(Conf::WEB_ID(), $username, $type);
        if (is_array($res)) {
            $status = $res['info'];
            if ($status == 'ok') {
                $data['code'] = 0;
                $data['zzusername'] = $res['msg'][0];
                $data['zzpassword'] = $res['msg'][1];
                $data['type'] = $res['msg'][2];
                $par = self::zzType($data['type'], $data['zzusername'], $data['zzpassword']);
                $params = $par['params'];
                $params[':username'] = $username;
                $sql = 'update k_user set ' . $par['strsql'] . ' where ' . $par['where'] . ' and username=:username';
                $stmt = DB::CONN()->prepare($sql);
                $stmt->execute($params);
            } else {
                $data['code'] = 1;
                preg_match('/error:(\d+)/', $res['msg'][0], $res);
                $errorCode = $res[1];
                if ($errorCode == '60002') {
                    $data['error'] = 'Account password error';
                }
            }
        } else {
            $data['code'] = 2;
            $data['error'] = 'Error';
        }
        return $data;
    }

    private static function RegMayaLive($username, $type)
    {
        $res = self::Client()->liveloginmaya(Conf::WEB_ID(), $username, $type);
        if (is_array($res)) {
            var_dump($res);
            $status = $res['info'];
            if ($status == 'ok') {
                $data['code'] = 0;
                $data['zzusername'] = $res['username'];
                $data['zzpassword'] = $res['GameMemberID'];
                $params = array(':username' => $username, ':mayaUserName' => $data['zzusername'], ':mayaGameMemberID' => $data['zzpassword'], ':mayaVenderMemberID' => $res['VenderMemberID']);
                $sql = 'update k_user set mayaUserName=:mayaUserName,mayaGameMemberID=:mayaGameMemberID,mayaVenderMemberID=:mayaVenderMemberID,mayaAddtime=now(),ismaya=1 where ismaya=0 and username = :username';
                $stmt = DB::CONN()->prepare($sql);
                $stmt->execute($params);
            } else {
                $data['code'] = 1;
                preg_match('/error:(\d+)/', $res['msg'][0], $res);
                $errorCode = $res[1];
                if ($errorCode == '60002') {
                    $data['error'] = 'Account password error';
                }
            }
        } else {
            $data['code'] = 2;
            $data['error'] = 'Error';
        }
        return $data;
    }

    public static function GetMayaMoney($zzusername, $zzpassword)
    {
        $data = [];
        $res = self::Client()->livebalancemaya(Conf::WEB_ID(), $zzusername, $zzpassword);
        var_dump($res);
        if (is_array($res)) {
            $status = $res['result'];
            if ($status == 'ok') {
                $data['code'] = 0;
                $data['money'] = sprintf('%.2f', $res['balance']);
            } else {
                $data['code'] = 1;
                $data['error'] = $res['msg'];
                preg_match('/error:(\d+)/', $res['msg'], $res);
                $errorCode = $res[1];
                if ($errorCode == '60001') {
                    $data['error'] = '未注册MAYA';
                }
            }
        } else {
            $data['code'] = 2;
            $data['error'] = 'Error';
        }
        return $data;
    }

    public static function GetMoney($zzusername, $zzpassword, $type)
    {
        if ($type == 'MAYA') {
            return self::GetMayaMoney($zzusername, $zzpassword);
        }
        $data = [];
        $res = self::Client()->livebalance(Conf::WEB_ID(), $zzusername, $zzpassword, $type);
        if (is_array($res)) {
            $status = $res['result'];
            if ($status == 'ok') {
                $data['code'] = 0;
                $data['money'] = $res['msg'];
            } else {
                $data['code'] = 1;
                $data['error'] = $res['msg'];
                preg_match('/error:(\d+)/', $res['msg'], $res);
                $errorCode = $res[1];
                if ($errorCode == '60001') {
                    $data['error'] = '未注册' . $type;
                }
            }
        } else {
            $data['code'] = 2;
            $data['error'] = 'Error';
        }
        return $data;
    }

    private static function get_billno_live()
    {
        return date('ymdHis') . substr(microtime(), 2, 3) . rand(1, 9);
    }
}