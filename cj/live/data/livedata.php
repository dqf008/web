<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once $C_Patch . "/cj/include/function.php";
include_once $C_Patch . "/cj/class/cj.php";
include_once $C_Patch . "/class/user.php";
include_once $C_Patch . '/class/Db.class.php';
$client = new rpcclient($cj_url);

function livedatas($type, $table)
{
    global $client;
    global $site_id;
    $db = new DB();
    if ($type == 'MAYA') {
        $arr = $client->livebetdetailMAYA($site_id);
        $zzmoney = 'mayamoney';
        $zztime = 'mayaAddtime';
    } elseif ($type == 'MW') {
        $arr = $client->livebetdetailmw($site_id);
        $zzmoney = 'mwmoney';
        $zztime = 'mwAddtime';
    }elseif ($type == 'KG') {
        $arr = $client->livebetdetailkg($site_id);
        $zzmoney = 'kgmoney';
        $zztime = 'kgAddtime';
    }elseif ($type == 'CQ9') {
        $arr = $client->livebetdetailcq9($site_id);
        $zzmoney = 'cq9money';
        $zztime = 'cq9Addtime';
    }elseif ($type == 'MG2') {
        $arr = $client->livebetdetailmg2($site_id);
        $zzmoney = 'mg2money';
        $zztime = 'mg2Addtime';
    } elseif ($type == 'VR') {
        $arr = $client->livebetdetailvr($site_id);
        $zzmoney = 'vrmoney';
        $zztime = 'vrAddtime';
    } elseif ($type == 'BGLIVE') {
        $arr = $client->livebetdetailbglive($site_id);
        $zzmoney = 'bgmoney';
        $zztime = 'bgAddtime';
    } elseif ($type == 'SB') {
        $zzmoney = 'sbmoney';
        $zztime = 'sbAddtime';
        $arr = $client->livebetdetailsb($site_id);
    } elseif ($type == 'PT2') {
        $zzmoney = 'pt2money';
        $zztime = 'pt2Addtime';
        $arr = $client->livebetdetailpt($site_id);
    } elseif ($type == 'OG2') {
        $zzmoney = 'og2money';
        $zztime = 'og2Addtime';
        $arr = $client->livebetdetailog($site_id);
    } elseif ($type == 'DG') {
        $zzmoney = 'dgmoney';
        $zztime = 'dgAddtime';
        $arr = $client->livebetdetaildg($site_id);
    } elseif ($type == 'KY') {
        $zzmoney = 'kymoney';
        $zztime = 'kyAddtime';
        $arr = $client->livebetdetailky($site_id);
    } elseif ($type == 'BBIN2') {
        $zzmoney = 'bbin2money';
        $zztime = 'bbin2Addtime';
        $arr = $client->livebetdetailbbin($site_id);
    } else {
        $zzdbName = typeName($type);
        $zzmoney = $zzdbName['zzmoney'];
        $zztime = $zzdbName['zztime'];
        $arr = $client->livebetdetail($site_id, $type);
    }
    $arr = a_decode64($arr);//解压
    if (is_array($arr) and $arr) {

        foreach ($arr as $row) {
            $username = $row['username'];

            if ($type == 'HUNTER') {
                $tradeNo = $row['tradeNo'];
                $params['tradeNo'] = $tradeNo;
                $sql = 'select id from ' . $table . ' where tradeNo=:tradeNo';
            } else {
                $billNo = $row['billNo'];
                $params['billNo'] = $billNo;
                $sql = 'select id from ' . $table . ' where billNo=:billNo';
            }

            $exist_row = $db->row($sql, $params);
            $par = array();
            $sql = '';
            $commonsql = '';
            if (($type == 'SHABA' or $type == 'BBIN' or $type == 'SBTA') and $row['flag'] == '未结算') {//沙巴体育
                $row['netAmount'] = 0;
                $row['validBetAmount'] = 0;
            }

            foreach ($row as $key => $value) {
                if ($key != 'id') {
                    //判断是否为空 而非0
                    if ((string)$value != 'nnnn') {
                        $par[$key] = $value;
                        $commonsql .= ',' . $key . ' = :' . $key;
                    }
                }
            }
            $rsss = array();
            if (empty($exist_row)) {
                $rsss = $db->row('select  uid,' . $zztime . ' as zztime from k_user where username = :username', ['username' => $username]);
                if ($rsss) {//该会员存在
                    $par['uid'] = $rsss['uid'];
                    $commonsql = 'uid=:uid' . $commonsql;
                    $sql = 'insert into ' . $table . ' set ' . $commonsql;

                    //更新真人余额
                    if ($type == 'HUNTER') {
                        if ($rsss['zztime'] < $row['SceneEndTime']) {//更新时间小于最后记录时间
                            $db->query('update k_user set ' . $zzmoney . '=:zzmoney,' . $zztime . '=:zztime where uid=:uid and ' . $zztime . '<=:zztime2', ['zzmoney' => $row['currentAmount'], 'zztime' => $row['SceneEndTime'], 'zztime2' => $row['SceneEndTime'], 'uid' => $rsss['uid']]);
                        }
                    } else {
                        if ($rsss['zztime'] < $row['betTime']) {//更新时间小于记录时间
                            $db->query('update k_user set ' . $zzmoney . '=' . $zzmoney . '+:zzmoney,' . $zztime . '=:zztime where uid=:uid and ' . $zztime . '<:zztime2', ['zzmoney' => $row['netAmount'], 'zztime' => $row['betTime'], 'zztime2' => $row['betTime'], 'uid' => $rsss['uid']]);
                        }
                    }
                } else {
                    $commonsql = ltrim($commonsql, ',');
                    $sql = 'insert into ' . $table . ' set ' . $commonsql;
                }

            } elseif ($type == 'SHABA') {//沙巴体育 赛事结算
                if ($rsss['zztime'] < $row['betTime'] and $row['flag'] == '已结算') {//更新真人余额
                    $rows = $db->row('select uid from shababetdetail where username=:username and flag="未结算" and billNo=:billNo', ['username' => $username, 'billNo' => $row['billNo']]);
                    if ($rows) {//存在未结算的注单
                        $db->query('update k_user set shabamoney=shabamoney+:zzmoney,shabaAddtime=:zztime where username=:username and shabaAddtime<=:zztime2', ['zzmoney' => $row['netAmount'], 'zztime' => $row['updateTime'], 'zztime2' => $row['updateTime'], 'username' => $username]);

                        $commonsql = ltrim($commonsql, ',');
                        $sql = 'update ' . $table . ' set ' . $commonsql . ' where billNo=:billNo2 and flag="未结算"';
                        $par['billNo2'] = $billNo;
                    }
                }
            } elseif ($type == 'SBTA') {//AG体育 赛事结算
                if ($rsss['zztime'] < $row['betTime']) {//更新真人余额
                    $rows = $db->row('select uid from sbtabetdetail where username=:username and flag="未结算" and billNo=:billNo', ['username' => $username, 'billNo' => $row['billNo']]);
                    if ($rows) {//存在未结算的注单
                        $db->query('update k_user set agmoney=agmoney+:zzmoney,agAddtime=:zztime where username=:username and agAddtime<=:zztime2', ['zzmoney' => $row['netAmount'], 'zztime' => $row['updateTime'], 'zztime2' => $row['updateTime'], 'username' => $username]);

                        $commonsql = ltrim($commonsql, ',');
                        $sql = 'update ' . $table . ' set ' . $commonsql . ' where billNo=:billNo2 and flag="未结算"';
                        $par['billNo2'] = $billNo;
                    }
                }
            } elseif ($type == 'MAYA') {//玛雅娱乐
                if ($rsss['zztime'] < $row['betTime'] and $row['flag'] == '已结算') {
                    $rows = $db->row('select uid from mayabetdetail where username = :username  and flag="未结算" and billNo = :billNo', ['username' => $username, 'billNo' => $row['billNo']]);
                    if ($rows) {//存在未结算的注单
                        $db->query('update k_user set mayamoney=mayamoney+:zzmoney,mayaAddtime=:zztime where username=:username and mayaAddtime<=:zztime2', ['zzmoney' => $row['netAmount'], 'zztime' => $row['updateTime'], 'zztime2' => $row['updateTime'], 'username' => $username]);
                        $commonsql = ltrim($commonsql, ',');
                        $sql = 'update ' . $table . ' set ' . $commonsql . ' where billNo = :billNo2 and flag="未结算"';
                        $par['billNo2'] = $billNo;
                    }
                }
            } elseif ($type == 'BBIN') {//BB体育 BB彩票赛事结算        
                if ($rsss['zztime'] < $row['betTime'] and $row['flag'] == '已结算') {//更新真人余额
                    $rows = $db->row('select uid from bbbetdetail where username = :username and flag="未结算" and billNo = :billNo', ['username' => $username, 'billNo' => $row['billNo']]);
                    if ($rows) {//存在未结算的注单
                        $db->query('update k_user set bbmoney=bbmoney+:zzmoney,bbinAddtime=:zztime where username=:username and bbinAddtime<=:zztime2', ['zzmoney' => $row['netAmount'], 'zztime' => $row['updateTime'], 'zztime2' => $row['updateTime'], 'username' => $username]);
                        $commonsql = ltrim($commonsql, ',');
                        $sql = 'update ' . $table . ' set ' . $commonsql . ' where billNo=:billNo2 and flag="未结算"';
                        $par['billNo2'] = $billNo;
                    }
                }
            } elseif ($type == 'BBIN2') {//BB体育 BB彩票赛事结算        
                if ($rsss['zztime'] < $row['betTime'] and $row['flag'] == '已结算') {//更新真人余额
                    $rows = $db->row('select uid from bbin2betdetail where username = :username and flag="未结算" and billNo = :billNo', ['username' => $username, 'billNo' => $row['billNo']]);
                    if ($rows) {//存在未结算的注单
                        $db->query('update k_user set bbin2money=bbin2money+:zzmoney,bbin2Addtime=:zztime where username=:username and bbin2Addtime<=:zztime2', ['zzmoney' => $row['netAmount'], 'zztime' => $row['updateTime'], 'zztime2' => $row['updateTime'], 'username' => $username]);
                        $commonsql = ltrim($commonsql, ',');
                        $sql = 'update ' . $table . ' set ' . $commonsql . ' where billNo=:billNo2 and flag="未结算"';
                        $par['billNo2'] = $billNo;
                    }
                }
            } elseif ($type == 'MG2') {//玛雅娱乐
                if ($rsss['zztime'] < $row['betTime'] and $row['flag'] == '已结算') {
                    $rows = $db->row('select uid from mg2betdetail where username = :username  and flag="未结算" and billNo = :billNo', ['username' => $username, 'billNo' => $row['billNo']]);
                    if ($rows) {//存在未结算的注单
                        $db->query('update k_user set mg2money=mg2money+:zzmoney,mg2Addtime=:zztime where username=:username and mg2Addtime<=:zztime2', ['zzmoney' => $row['netAmount'], 'zztime' => $row['updateTime'], 'zztime2' => $row['updateTime'], 'username' => $username]);
                        $commonsql = ltrim($commonsql, ',');
                        $sql = 'update ' . $table . ' set ' . $commonsql . ' where billNo = :billNo2 and flag="未结算"';
                        $par['billNo2'] = $billNo;
                    }
                }
            }elseif ($type == 'VR') {
                if ($rsss['zztime'] < $row['betTime'] and $row['flag'] == '已结算') {
                    $rows = $db->row('select uid from vrbetdetail where username = :username  and flag="未结算" and billNo = :billNo', ['username' => $username, 'billNo' => $row['billNo']]);
                    if ($rows) {//存在未结算的注单
                        $db->query('update k_user set vrmoney=vrmoney+:zzmoney,vrAddtime=:zztime where username=:username and vrAddtime<=:zztime2', ['zzmoney' => $row['netAmount'], 'zztime' => $row['updateTime'], 'zztime2' => $row['updateTime'], 'username' => $username]);
                        $commonsql = ltrim($commonsql, ',');
                        $sql = 'update ' . $table . ' set ' . $commonsql . ' where billNo = :billNo2 and flag="未结算"';
                        $par['billNo2'] = $billNo;
                    }
                }
            } elseif ($type == 'BGLIVE') {
                if ($rsss['zztime'] < $row['betTime'] and $row['flag'] == '已结算') {
                    $rows = $db->row('select uid from bglivebetdetail where username = :username  and flag="未结算" and billNo = :billNo', ['username' => $username, 'billNo' => $row['billNo']]);
                    if ($rows) {//存在未结算的注单
                        $db->query('update k_user set bgmoney=bgmoney+:zzmoney,bgAddtime=:zztime where username=:username and bgAddtime<=:zztime2', ['zzmoney' => $row['netAmount'], 'zztime' => $row['updateTime'], 'zztime2' => $row['updateTime'], 'username' => $username]);
                        $commonsql = ltrim($commonsql, ',');
                        $sql = 'update ' . $table . ' set ' . $commonsql . ' where billNo = :billNo2 and flag="未结算"';
                        $par['billNo2'] = $billNo;
                    }
                }
            } elseif ($type == 'SB') {
                if ($rsss['zztime'] < $row['betTime'] and $row['flag'] == '已结算') {
                    $rows = $db->row('select uid from ' . $table . ' where username = :username  and flag="未结算" and billNo = :billNo', ['username' => $username, 'billNo' => $row['billNo']]);
                    if ($rows) {//存在未结算的注单
                        $db->query('update k_user set sbmoney=sbmoney+:zzmoney,sbAddtime=:zztime where username=:username and sbAddtime<=:zztime2', ['zzmoney' => $row['netAmount'], 'zztime' => $row['updateTime'], 'zztime2' => $row['updateTime'], 'username' => $username]);
                        $commonsql = ltrim($commonsql, ',');
                        $sql = 'update ' . $table . ' set ' . $commonsql . ' where billNo = :billNo2 and flag="未结算"';
                        $par['billNo2'] = $billNo;
                    }
                }
            } elseif ($type == 'OG2') {
                if ($rsss['zztime'] < $row['betTime'] and $row['flag'] == '已结算') {
                    $rows = $db->row('select uid from ' . $table . ' where username = :username  and flag="未结算" and billNo = :billNo', ['username' => $username, 'billNo' => $row['billNo']]);
                    if ($rows) {//存在未结算的注单
                        $db->query('update k_user set og2money=og2money+:zzmoney,og2Addtime=:zztime where username=:username and og2Addtime<=:zztime2', ['zzmoney' => $row['netAmount'], 'zztime' => $row['updateTime'], 'zztime2' => $row['updateTime'], 'username' => $username]);
                        $commonsql = ltrim($commonsql, ',');
                        $sql = 'update ' . $table . ' set ' . $commonsql . ' where billNo = :billNo2 and flag="未结算"';
                        $par['billNo2'] = $billNo;
                    }
                }
            }
            $msg = 0;
            if ($sql) {
                $db->query($sql, $par);
                $msg++;
            }
        }
        return array('info' => 'ok', 'count' => $msg);
    } else if (!$arr) {
        return '<br>本次无' . $type . '注单采集';
    } else {
        return '<br>' . $arr;
    }
}

function livezhuanzhang($type, $table)
{
    global $client;
    global $site_id;
    $arr = $client->livetransferdetail($site_id, $type);
    $arr = a_decode64($arr);//解压
    if (is_array($arr) and $arr) {
        $db = new DB();
        foreach ($arr as $row) {
            $tradeNo = $row['tradeNo'];
            $username = $row['username'];
            $exist_row = $db->row('select  id  from ' . $table . ' where tradeNo=:tradeNo', ['tradeNo' => $tradeNo]);
            $par = array();
            $sql = '';
            $commonsql = '';
            foreach ($row as $key => $value) {
                if ($key != 'id') {
                    //判断是否为空 而非0
                    if ((string)$value != 'nnnn') {
                        $par[$key] = $value;
                        $commonsql .= ',' . $key . ' = :' . $key;
                    }
                }
            }
            if (empty($exist_row)) {
                $rsss = $db->row('select  uid  from k_user where username = :username', ['username' => $username]);
                if ($rsss) {//该会员存在
                    $par['uid'] = $rsss['uid'];
                    $commonsql = 'uid=:uid' . $commonsql;
                    $sql = 'insert into ' . $table . ' set ' . $commonsql;
                } else {
                    $commonsql = ltrim($commonsql, ',');
                    $sql = 'insert into ' . $table . ' set ' . $commonsql;
                }
            }
            $msg = 0;
            if ($sql) {
                $db->query($sql, $par);
                $msg++;
            }
        }
        return array('info' => 'ok', 'count' => $msg);
    } else if (!$arr) {
        return '<br>本次无' . $type . '转帐记录';
    } else {
        return '<br>' . $arr;
    }
}