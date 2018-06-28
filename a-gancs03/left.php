<?php
@session_start();
include_once __DIR__.'/../include/config.php';
include_once __DIR__.'/common/login_check.php';
$quanxian = $_SESSION['quanxian'];
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>left</title>
    <link href="css/system.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .noselect {
            -webkit-touch-callout: none; /* iOS Safari */
            -webkit-user-select: none; /* Chrome/Safari/Opera */
            -khtml-user-select: none; /* Konqueror */
            -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently not supported by any browser */
        }
        .bg_03{
            overflow:hidden;
            height:100%;
        }
        .bg_12{
            padding:0;
            height:26px;
            line-height:26px;
            text-align: center;
        }
        .button{
            float: none;
            margin: 0;
        }
        .bg_12,.bg_11,.bg_10,.bg_13{
            width:155px;
        }
        .system{
            padding: 0;
            width:155px;
            height:30px;
            line-height: 30px;
            text-align: center;
            color: #0094FF;

        }
        .bg_10,.bg_13{
            padding: 0;
            text-align: left;
            padding-left:50px;
            height: 26px;
            line-height: 26px;
        }
        table tr {
            background-color: #FFF;
            height: 30px;
            font-size: 12px;
        }

        table tr td {
            text-align: center;
            vertical-align: middle;
        }

        a {
            display: block;
            height: 30px;
            line-height: 30px;
        }

        a:hover {
            background-color: #C0E0F8;
        }
    </style>
</head>
<body>
<div class="left noselect">
    <div class="nav1" style="width: 169px;padding: 0; text-align: center;">
        <img src="images/system_ico.jpg" alt="ico" width="15" height="12"/>功能菜单&nbsp;&nbsp;
    </div>
    <div class="border">
        <div class="bg_01">
            <div class="bg_02" style="margin-top: 0">
                <div class="bg_03">
                    <div class="system"><img src="./images/system.jpg" style="margin-top: 5px;margin-right: 10px"><?= @$_SESSION['about'] ?>&nbsp;&nbsp;</div>
                    <?php if (strpos($quanxian, 'zdgl') || strpos($quanxian, 'sgjzd')) { ?>
                        <div class="bg_10">皇冠-注单管理</div>
                        <div class="bg_11">
                            <a href="zdgl/list.php?status=0" target="mainFrame">单式注单</a>
                            <a href="zdgl/cg_result.php?status=0" target="mainFrame">串关注单</a>
                            <a href="zdgl/check_zd.php" target="mainFrame">核查注单</a>
                            <?php if (strpos($quanxian, 'sgjzd')) { ?>
                                <a href="zdgl/sgjds.php?status=0" target="mainFrame">手工结单式</a>
                                <a href="zdgl/sgjcg.php?status=0" target="mainFrame">手工结串关</a>
                            <?php } ?>
                            <a href="zdgl/bet_lose.php" target="mainFrame">滚球未审核注单</a>
                            <a href="zdgl/index.html" target="mainFrame">滚球自动审核</a>
                        </div>
                    <?php }
                    if (strpos($quanxian, 'bfgl')) { ?>
                        <div class="bg_10">皇冠-比分管理</div>
                        <div class="bg_11">
                            <a href="bfgl/zqbf.php" target="mainFrame">足球比分</a>
                            <a href="bfgl/lqbf.php" target="mainFrame">篮球比分</a>
                            <a href="bfgl/wqbf.php" target="mainFrame">网球比分</a>
                            <a href="bfgl/pqbf.php" target="mainFrame">排球比分</a>
                            <a href="bfgl/bqbf.php" target="mainFrame">棒球比分</a>
                            <a href="bfgl/list.php?type=3" target="mainFrame">足球冠军</a>
                        </div>
                    <?php }
                    if (strpos($quanxian, 'jyqk')) { ?>
                        <div class="bg_10">皇冠-交易情况</div>
                        <div class="bg_11">
                            <a href="jyqk/ft_danshi.php" target="mainFrame">即时交易</a>
                            <a href="jyqk/ft_danshi.php?match_type=0" target="mainFrame">早餐交易</a>
                        </div>
                    <?php }
                    if (strpos($quanxian, 'ssgl')) { ?>
                        <div class="bg_10">皇冠-赛事管理</div>
                        <div class="bg_11">
                            <a href="ssgl/ss_list.php?type=bet_match" target="mainFrame">足球赛事</a>
                            <a href="ssgl/ss_list.php?type=lq_match" target="mainFrame">篮球赛事</a>
                            <a href="ssgl/ss_list.php?type=tennis_match" target="mainFrame">网球赛事</a>
                            <a href="ssgl/ss_list.php?type=volleyball_match" target="mainFrame">排球赛事</a>
                            <a href="ssgl/ss_list.php?type=baseball_match" target="mainFrame">棒球赛事</a>
                            <a href="ssgl/list.php?type=3" target="mainFrame">冠军赛事</a>
                            <a href="ssgl/zczds.php" target="mainFrame">早餐转单式</a>
                            <a href="ssgl/gpsz.php" target="mainFrame">关盘设置</a>
                        </div>
                    <?php }
                    if (strpos($quanxian, 'hygl')) { ?>
                        <div class="bg_10">会员管理</div>
                        <div class="bg_11">
                            <a href="hygl/list.php?1=1" target="mainFrame">会员管理</a>
                            <a href="hygl/group.php" target="mainFrame">会员组管理</a>
                            <a href="hygl/filter.php" target="mainFrame">会员筛选</a>
                            <a href="hygl/login_ip.php" target="mainFrame">会员登陆IP</a>
                            <a href="hygl/jkhy.php" target="mainFrame">监控会员</a>
                            <a href="hygl/lsyhxx.php" target="mainFrame">历史银行信息</a>
                        </div>
                    <?php }
                    if (strpos($quanxian, 'cwgl') || strpos($quanxian, 'jkkk')) { ?>
                        <div class="bg_10">财务管理</div>
                        <div class="bg_11">
                            <a href="cwgl/chongzhi.php?status=2" target="mainFrame">存款管理</a>
                            <a href="cwgl/tixian.php?status=2" target="mainFrame">提款管理</a>
                            <?php if (strpos($quanxian, 'jkkk')) { ?>
                                <a href="cwgl/tksz.php" target="mainFrame">提款打码设置</a>
                            <?php } ?>
                            <a href="cwgl/huikuan.php?status=0" target="mainFrame">汇款管理</a>
                            <?php if (strpos($quanxian, 'jkkk')) { ?>
                                <a href="cwgl/cksz.php" target="mainFrame">汇款设置</a>
                                <a href="cwgl/cksz2.php" target="mainFrame">微信支付宝</a>
                                <a href="cwgl/man_money.php" target="mainFrame">加款扣款</a>
                                <!--a href="cwgl/pl_money.php" target="mainFrame">批量加款扣款</a-->
                            <?php } ?>
                            <a href="cwgl/hccw.php" target="mainFrame">会员存/取/汇款</a>
                            <!--a href="cwgl/hccw2.php" target="mainFrame">会员存/取/汇款2</a-->
                            <a href="cwgl/zhuanzhang.php?ok=" target="mainFrame">转账记录</a>
                            <a href="cwgl/money_log.php" target="mainFrame">额度记录</a>
                            <a href="cwgl/money_report.php" target="mainFrame">财务汇总</a>
                            <a href="./payment/" target="mainFrame">支付通道管理（测试）</a>
                        </div>
                    <?php }
                    if (strpos($quanxian, 'fsgl')) { ?>
                        <div class="bg_10">返水管理</div>
                        <div class="bg_11">
                            <a href="fsgl/fs_level.php" target="mainFrame">返水等级</a>
                            <a href="fsgl/fs_ty.php" target="mainFrame">体育返水</a>
                            <a href="fsgl/fs_cp.php" target="mainFrame">彩票返水</a>
                            <a href="fsgl/fs_zr.php" target="mainFrame">平台返水</a>
                            <a href="fsgl/fs_account.php" target="mainFrame">返水回查</a>
                        </div>
                    <?php }
                    if (strpos($quanxian, 'xxgl')) { ?>
                        <div class="bg_10">消息管理</div>
                        <div class="bg_11">
                            <a href="xxgl/add.php?1=1" target="mainFrame">公告管理</a>
                            <a href="xxgl/sys_msg.php" target="mainFrame">站内消息</a>
                        </div>
                    <?php }
                    if (strpos($quanxian, 'dlgl')) { ?>
                        <div class="bg_10">代理管理</div>
                        <div class="bg_11">
                            <a href="dlgl/daili.php?1=1" target="mainFrame">代理审核</a>
                            <!-- <a href="dlgl/dailist.php?1=1" target="mainFrame">代理列表</a> -->
                            <!-- <a href="dlgl/dali_report.php" target="mainFrame">代理月额度</a> -->
                            <a href="dlgl/dlurl.php" target="mainFrame">代理网址设置</a>
                            <a href="agent/index.php" target="mainFrame">代理组管理</a>
                            <a href="agent/user.php" target="mainFrame">代理报表与结算</a>
                            <a href="agent/list.php" target="mainFrame">代理结算单</a>
                            <a href="agent/setting.php" target="mainFrame">代理系统设置</a>
                            <a href="agent/content.php" target="mainFrame">代理内容管理</a>
                        </div>
                    <?php }
                    if (strpos($quanxian, 'bbgl')) { ?>
                        <div class="bg_10">报表管理</div>
                        <div class="bg_11">
                            <a href="bbgl/report_day.php" target="mainFrame">报表明细</a>
                            <a href="bbgl/allorder.php" target="mainFrame">彩票体育注单统计</a>
                            <a href="bbgl/zrorder.php" target="mainFrame">真人娱乐注单统计</a>
                            <a href="bbgl/bet_report.php" target="mainFrame">会员下注注单汇总</a>
                            <a href="bbgl/hl.php" target="mainFrame">报表忽略</a>
                            <a href="bbgl/yecx.php" target="mainFrame">历史余额</a>
                            <a href="bbgl/pay_detail.php" target="mainFrame">充值统计</a>
                        </div>
                    <?php }
                    if (strpos($quanxian, 'cpgl')) { ?>
                        <div class="bg_10">普通彩票管理</div>
                        <div class="bg_11">
                            <?php if (strpos($quanxian, 'zdgl')) { ?>
                                <a href="cpgl/jszd.php" target="mainFrame">即时注单</a>
                            <?php }
                            if (strpos($quanxian, 'cpkj')) { ?>
                                <a href="cpgl/lottery_auto_kl8.php" target="mainFrame">开奖设置</a>
                            <?php }
                            if (strpos($quanxian, 'cppl')) { ?>
                                <a href="cpgl/lottery_odds_kl8.php" target="mainFrame">赔率设置</a>
                            <?php } ?>
                        </div>
                        <div class="bg_10">高频彩票管理</div>
                        <div class="bg_11">
                            <?php if (strpos($quanxian, 'zdgl')) { ?>
                                <a href="Lottery/Order.php?js=0" target="mainFrame">即时注单</a>
                            <?php }
                            if (strpos($quanxian, 'cpkj')) { ?>
                                <a href="Lottery/Auto_2.php" target="mainFrame">开奖设置</a>
                            <?php }
                            if (strpos($quanxian, 'cppl')) { ?>
                                <a href="Lottery/Odds.php" target="mainFrame">赔率设置</a>
                            <?php } ?>
                        </div>
                        <div class="bg_10">快3彩票管理</div>
                        <div class="bg_11">
                            <?php if (strpos($quanxian, 'zdgl')) { ?>
                                <a href="k3/jszd.php" target="mainFrame">即时注单</a>
                            <?php }
                            if (strpos($quanxian, 'cpkj')) { ?>
                                <a href="k3/lottery_auto_k3.php" target="mainFrame">开奖设置</a>
                            <?php }
                            if (strpos($quanxian, 'cppl')) { ?>
                                <a href="k3/lottery_odds_k3.php" target="mainFrame">赔率设置</a>
                            <?php } ?>
                        </div>
                        <div class="bg_10">极速彩票管理</div>
                        <div class="bg_11">
                            <?php if (strpos($quanxian, 'zdgl')) { ?>
                                <a href="xtcp/lottery_bet_data.php" target="mainFrame">即时注单</a>
                            <?php }
                            if (strpos($quanxian, 'cpkj')) { ?>
                                <a href="xtcp/lottery_jssc_data.php" target="mainFrame">开奖设置</a>
                            <?php }
                            if (strpos($quanxian, 'cppl')) { ?>
                                <a href="xtcp/lottery_jssc_odds.php" target="mainFrame">赔率设置</a>
                            <?php } ?>
                        </div>
                    <?php }
                    if (strpos($quanxian, 'lhcgl')) { ?>
                        <div class="bg_10">六合彩管理</div>
                        <div class="bg_11">
                            <a href="lotto/index.php" target="mainFrame">六合彩管理</a>
                        </div>
                    <?php } ?>
                    <div class="bg_10">真人视讯 管理</div>
                    <div class="bg_11">
                        <a href="zhenren_gl/BetRecord.php" target="mainFrame">下注记录</a>
                        <a href="zhenren_gl/CreditRecord.php" target="mainFrame">额度记录</a>
                        <a href="zhenren_gl/MemberReport.php" target="mainFrame">会员报表</a>
                    </div>
                    <div class="bg_10">电子游戏 管理</div>
                    <div class="bg_11">
                        <a href="dianzi_gl/BetRecord.php" target="mainFrame">下注记录</a>
                        <a href="dianzi_gl/CreditRecord.php" target="mainFrame">额度记录</a>
                        <a href="dianzi_gl/MemberReport.php" target="mainFrame">会员报表</a>
                    </div>
                    <div class="bg_10">体育 管理</div>
                    <div class="bg_11">
                        <a href="tiyu_gl/BetRecord.php" target="mainFrame">下注记录</a>
                        <a href="tiyu_gl/CreditRecord.php" target="mainFrame">额度记录</a>
                        <a href="tiyu_gl/MemberReport.php" target="mainFrame">会员报表</a>
                    </div>
                    <?php if (strpos($quanxian, 'rzgl')) { ?>
                        <div class="bg_10">日志管理</div>
                        <div class="bg_11">
                            <a href="rzgl/list.php?show=all" target="mainFrame">日志管理</a>
                        </div>
                    <?php }
                    if (strpos($quanxian, 'sjgl')) { ?>
                        <div class="bg_10">数据管理</div>
                        <div class="bg_11">
                            <a href="sjgl/qcsj.php" target="mainFrame">清除数据</a>
                            <a href="sjgl/sjyh.php" target="mainFrame">数据优化</a>
                        </div>
                    <?php }
                    if (strpos($quanxian, 'xtgl')) { ?>
                        <div class="bg_10">系统管理</div>
                        <div class="bg_11">
                            <a href="xtgl/set_site.php" target="mainFrame">系统设置</a>
                            <a href="sign/index.php" target="mainFrame">签到设置</a>
                            <a href="xtgl/lmgl.php" target="mainFrame">栏目管理</a>
                            <a href="xtgl/yhhd.php" target="mainFrame">优惠活动</a>
                            <a href="xtgl/tclist.php" target="mainFrame">首页弹窗</a>
                            <a href="xtgl/slides.php?type=web" target="mainFrame">电脑轮播图</a>
                            <a href="xtgl/czfx.php" target="mainFrame">充值返现</a>
                            <a href="xtgl/dqxz.php" target="mainFrame">地区限制</a>
                            <a href="xtgl/egame.php" target="mainFrame">电子游戏</a>
                        </div>
                        <div class="bg_10">手机版管理</div>
                        <div class="bg_11">
                            <a href="mobile/setting.php" target="mainFrame">手机版设置</a>
                            <a href="mobile/activity.php" target="mainFrame">手机优惠活动</a>
                            <a href="xtgl/sjtc.php" target="mainFrame">手机弹窗</a>
                            <a href="xtgl/slides.php?type=mobile" target="mainFrame">手机轮播图</a>
                            <a href="mobile/order.php" target="mainFrame">首页链接排序</a>
                        </div>
                    <?php } ?>
                    <div class="bg_10">管理员管理</div>
                    <div class="bg_11">
                        <?php if (strpos($quanxian, 'glygl')) { ?>
                        <a href="glygl/user.php" target="mainFrame">管理员管理</a>
                        <?php } ?>
                        <a href="glygl/GoogleAuthenticator.php" target="mainFrame">验证器管理</a>
                    </div>
                    <div class="bg_10">修改密码</div>
                    <div class="bg_11">
                        <a href="set_pwd.php" target="mainFrame">修改密码</a>
                    </div>
                    <div class="bg_12">
                        <input name="按钮" type="button" class="button" value="退出" id="out"/>
                        <input name="按钮" type="button" class="button" value="监控" onclick='window.open("info.php?" + Math.random(), "mainFrame")'/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script>
    $(function () {
        $("#out").click(function () {
            if (confirm('您真的要退出后台管理吗？')) {
                window.parent.location.href = 'out.php';
            } else {
                return false;
            }
        });
        $('.bg_10').click(function () {
            if ($(this).hasClass('bg_13')) {
                $(this).addClass('bg_10').removeClass('bg_13');
                $(this).next().css("display", "none");
            } else {
                $('.bg_13').next().css("display", "none");
                $('.bg_13').removeClass('bg_13').addClass('bg_10');
                $(this).removeClass('bg_10').addClass('bg_13');
                $(this).next().css("display", "block");
            }
        });
    });
</script>
</body>
</html>