<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('xtgl');
$res = $mydata1_db->query('show tables like "pay_conf"');
if ($res->fetch()[0] == "") {
    $sql = "CREATE TABLE IF NOT EXISTS `pay_conf` ( `id` smallint(6) NOT NULL AUTO_INCREMENT, `name` varchar(50) COLLATE utf8_bin NOT NULL,`code` varchar(50) COLLATE utf8_bin NOT NULL, `status` tinyint(4) unsigned DEFAULT '0',PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
    $mydata1_db->exec($sql);
    $sql = "CREATE TABLE IF NOT EXISTS `pay_conf_info` ( `pay` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,`channel` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,`code` varchar(50) COLLATE utf8_bin NOT NULL,`data` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,`status` tinyint(4) DEFAULT '0') ENGINE=MyISAM DEFAULT CHARSET=latin1;";
    $mydata1_db->exec($sql);
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>支付管理</title>
    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/static/bootstrap/js/html5shiv.min.js"></script>
    <script src="/static/bootstrap/js/respond.min.js"></script>
    <![endif]-->
    <style>
        .btn {
            margin: 0 10px;
            padding: 0 10px;
        }
        [v-cloak]{
            display:none
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <h2 class="text-center">支付管理</h2>
    <table class="table table-bordered" id="list">
        <thead>
        <tr>
            <th class="col-sm-2 col-xs-2">第三方</th>
            <th class="col-sm-8 col-xs-8">渠道状态</th>
            <th class="col-sm-1 col-xs-1">状态</th>
            <th class="col-sm-1 col-xs-1">操作</th>
        </tr>
        </thead>
        <tbody v-cloak>
        <tr v-for="pay in data" :code="pay.code">
            <td v-text="pay.name"></td>
            <td class="text-center">
                <template v-for="channel in pay.list">
                    <button :status="channel.open?'1':'0'" class="btn btn-sm" :channel="channel.code"
                            @click="changeChannel"
                            :class="channel.open?'btn-success':'btn-default'">
                        {{ channel.name }}
                        <span :class="channel.open?'glyphicon-ok':'glyphicon-remove'" class="glyphicon"></span>
                    </button>
                </template>
            </td>
            <td>
                <button v-if="pay.status!=2" class="btn btn-sm" :class="pay.status=='1'?'btn-success':'btn-default'" @click="changePay">
                    <span>{{ pay.status=='1'?'开启':'关闭' }}</span>
                </button>
                <button v-if="pay.status==2" class="btn btn-sm btn-warning" disabled>
                    <span>未配置</span>
                </button>
            </td>
            <td>
                <a :href="pay.path">编辑</a>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<script src="/static/bootstrap/js/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script src="/static/bootstrap/js/vue.min.js"></script>
<script>
    new Vue({
        el: '#list',
        data: {data: ""},
        created: function () {
            _self = this;
            $.getJSON("api.php?act=list", function (res) {
                if (res.code == 200)
                    _self.data = res.data;
            });
        },
        methods: {
            changeChannel: function (event) {
                var obj = $(event.currentTarget);
                var status = obj.attr('status');
                var code = obj.parent().parent().attr('code');
                var channel = obj.attr('channel');
                var url = "api.php?act=changeChannel&pay=" + code + "&channel=" + channel + "&status=" + status;
                $.getJSON(url, function (res) {
                    if (res.code == 200) {
                        span = obj.find("span").first();
                        if ($(span).hasClass("glyphicon-remove")) {
                            $(span).removeClass("glyphicon-remove").addClass("glyphicon-ok");
                            obj.removeClass("btn-default").addClass("btn-success");
                        } else {
                            $(span).removeClass("glyphicon-ok").addClass("glyphicon-remove");
                            obj.removeClass("btn-success").addClass("btn-default");
                        }
                    } else {
                        alert('操作失败');
                    }
                });
            },
            changePay: function (event) {
                var obj = $(event.currentTarget);
                var code = obj.parent().parent().attr('code');
                var url = "api.php?act=changePay&pay=" + code;
                $.getJSON(url, function (res) {
                    if (res.code == 200) {
                        if (obj.hasClass("btn-default")) {
                            obj.removeClass("btn-default").addClass("btn-success");
                            obj.text('开启');
                        } else {
                            obj.removeClass("btn-success").addClass("btn-default");
                            obj.text('关闭');
                        }
                    } else {
                        alert('操作失败');
                    }
                });
            }
        }
    })
</script>
</body>
</html>