<?php
$pay_name = 'sfb_pay';
include_once "../common.php";
$info = getDefaultConf($pay_name);
$conf = getUserConf($pay_name);

if (count($_POST) > 0) {
    $conf['pay_mid'] = $_POST['pay_mid'];
    $conf['pay_mkey'] = $_POST['pay_mkey'];
    $conf['pay_url'] = $_POST['pay_url'];
    $conf['open'] = $_POST['list'];
    saveUserConf($pay_name, $conf);
    save_to_data();
}
function save_to_data()
{
    global $info, $mydata1_db, $pay_name;
    $name = $info['pay_info']['name'];
    $code = $info['pay_info']['code'];
    $res = $mydata1_db->query("select * from pay_conf where `name`='{$name}'");
    if ($res->rowCount() == 0) {
        $mydata1_db->exec("insert into pay_conf(`name`,`code`) values ('{$name}','{$code}')");
    }
    $userConf = getUserConf($pay_name);
    $openList = $userConf['open'];
    unset($userConf['open']);
    unset($userConf['status']);
    $channelList = array();
    foreach ($info['pay_list'] as $payConf) {
        $payName = $info['pay_info']['name'] . $payConf['name'];
        $channel['name'] = $payConf['name'];
        $channel['status'] = '1';
        if (empty($openList) || !in_array($payConf['code'], $openList)) {
            $channel['status'] = '0';
        }
        $channel['code'] = $payConf['code'];
        unset($payConf['name']);
        unset($payConf['code']);
        $payConf = array_merge($userConf, $payConf);
        $str = '';
        foreach ($payConf as $k => $v) {
            if (in_array($k, ['post_url', 'notice_url'])) {
                $v = $userConf['pay_url'] . '/' . $v;
            }
            $str .= sprintf('$arr_online_config["%s"]["%s"] = "%s";%s', $payName, $k, $v, "\r\n");
        }
        $channel['data'] = $str;
        $channelList[] = $channel;
        unset($channel);
    }

    foreach ($channelList as $channel) {
        $res = $mydata1_db->query("select * from pay_conf_info where `pay`='{$name}' and `channel`='{$channel['name']}'");
        $params = array(':pay' => $name, ':channel' => $channel['name'], ':data' => $channel['data'], ':status' => $channel['status']);
        if ($res->rowCount() == 0) {
            $params[':code'] = $channel['code'];
            $stmt = $mydata1_db->prepare("insert into pay_conf_info(`pay`,`channel`,`code`,`data`,`status`) values (:pay,:channel,:code,:data,:status)");
            $stmt->execute($params);
        } else {
            $stmt = $mydata1_db->prepare("update pay_conf_info set `data`=:data,`status`=:status where `pay`=:pay and `channel`=:channel");
            $stmt->execute($params);
        }
    }
    echo "<script>alert('修改成功！')</script>";
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $info['pay_info']['name'] ?></title>
    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/static/bootstrap/js/html5shiv.min.js"></script>
    <script src="/static/bootstrap/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <form method="post" action="" style="max-width: 700px">
        <h2 class="text-center"><?= $info['pay_info']['name'] ?></h2>
        <div class="form-group">
            <label for="pay_mid" class="control-label">商户号：</label>
            <input class="form-control" name="pay_mid" placeholder="商户号" value="<?= $conf['pay_mid'] ?>">
        </div>
        <div class="form-group">
            <label for="pay_mkey" class="control-label">商户秘钥：</label>
            <input class="form-control" name="pay_mkey" placeholder="商户秘钥" value="<?= $conf['pay_mkey'] ?>">
        </div>
        <div class="form-group">
            <label for="pay_url" class=" control-label">回调地址：</label>
            <input class="form-control" name="pay_url" placeholder="回调地址" value="<?= $conf['pay_url'] ?>">
            <p class="help-block">只需写域名即可，例如：http://pay.xxxx.com/</p>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class=" control-label">支付开关：</label>
            <label class="checkbox-inline">
                <input type="checkbox" name="list[]" <?= in_array('wechat', $conf['open']) ? 'checked' : '' ?>
                       value="wechat"> 微信支付
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" name="list[]" <?= in_array('alipay', $conf['open']) ? 'checked' : '' ?>
                       value="alipay"> 支付宝支付
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" name="list[]" <?= in_array('qq', $conf['open']) ? 'checked' : '' ?>
                       value="qq"> QQ钱包支付
            </label>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value=" 保 存 ">
            <input onclick="document.location.href='../index.php'" type="button" class="btn btn-default"
                   value=" 返 回 ">
        </div>
    </form>
</div>
<script src="/static/bootstrap/js/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>