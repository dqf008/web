<?php
	session_start();
	$cdn_url = '//cdn.fox008.cc/';
?><!DOCTYPE html>
<html id="ng-app" ng-app="portalApp">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-normalize@0.4.0/modern-normalize.min.css">
<link rel="stylesheet" href="<?=$cdn_url?>Common/Lottery/main.css">
<style>*[ng-click],a{cursor: pointer;}</style>
</head>
<body>
<div ng-controller="LobbiesCtrl" class="lotteryboard_content">
    <div class="container">
        <div class="lotteryboard_row lotteryboard_select_form_top" style="width:990px;margin: 0 auto;">
            <div id="lotteryhallSelect" class="lotteryhall_select">
                <div class="lotteryboard_pk_select_tab toggle">
                    <!--img src="picture/pk_logo.png"--> <span class="bg_col">官方彩票</span>
                </div>
                <div class="lotteryboard_egtc_select_tab" ng-click="toLotteryVr()">
                    <!--img src="picture/egtc_logo.png"--> <span class="bg_col">VR彩票</span>
                </div>
                <div class="lotteryboard_cs_select_tab " ng-click="toLotteryBb()">
                    <!--img src="picture/cs_logo.png"--> <span class="bg_col">BB彩票</span>
                </div>
            </div>
        </div>
        <div class="container select_form_content_lotteryboard">
            <div id="pkLottery" class="lotteryboard_pk_imgs lotteryboard_pk_forms">
                <div class="lotteryboard_row lotteryboard_forms_unit">
                    <div class="col-md-2">
                        <img src="<?=$cdn_url?>Common/Lottery/elhc.png">
                        <p>六合彩</p>
                    </div>
                    <div class="col-md-10">
                        <div class="lotteryboard_row">
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=marksix">
                                    <img src="<?=$cdn_url?>Common/Lottery/marksix.png">
                                    <p style="color:white;margin-top: 10px;">六合彩</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lotteryboard_row lotteryboard_forms_unit">
                    <div class="col-md-2">
                        <img src="<?=$cdn_url?>Common/Lottery/xingyunma.png">
                        <p>极速彩票</p>
                    </div>
                    <div class="col-md-10">
                        <div class="lotteryboard_row">
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=jssc">
                                    <img src="<?=$cdn_url?>Common/Lottery/jssc.png">
                                    <p style="color:white;margin-top: 10px;">极速赛车</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=jsssc">
                                    <img src="<?=$cdn_url?>Common/Lottery/jsssc.png">
                                    <p style="color:white;margin-top: 10px;">极速时时彩</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=jslh">
                                    <img src="<?=$cdn_url?>Common/Lottery/jslh.png">
                                    <p style="color:white;margin-top: 10px;">极速六合</p>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="lotteryboard_row lotteryboard_forms_unit">
                    <div class="col-md-2">
                        <img src="<?=$cdn_url?>Common/Lottery/fpk10.png">
                        <p>高频彩</p>
                    </div>
                    <div class="col-md-10">
                        <div class="lotteryboard_row">
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=pk10">
                                    <img src="<?=$cdn_url?>Common/Lottery/pk10.png">
                                    <p style="color:white;margin-top: 10px;">北京赛车PK拾</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=cqssc">
                                    <img src="../Lottery/Images/Lottery/cq_ssc.png">
                                    <p style="color:white;margin-top: 10px;">重庆时时彩</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=xjssc">
                                    <img src="../Lottery/Images/Lottery/xj_ssc.png">
                                    <p style="color:white;margin-top: 10px;">新疆时时彩</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=tjssc">
                                    <img src="../Lottery/Images/Lottery/tj_ssc.png">
                                    <p style="color:white;margin-top: 10px;">天津时时彩</p>
                                </a>
                            </div>
<!--                            <div class="col-md-2 lotteryboard_forms_lottery">-->
<!--                                <a href="/lot/?i=sfssc">-->
<!--                                    <img src="--><?//=$cdn_url?><!--Common/Lottery/jsssc.png">-->
<!--                                    <p style="color:white;margin-top: 10px;">三分时时彩</p>-->
<!--                                </a>-->
<!--                            </div>-->
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=xyft">
                                    <img src="<?=$cdn_url?>Common/Lottery/xyft.png">
                                    <p style="color:white;margin-top: 10px;">幸运飞艇</p>
                                </a>
                            </div>
<!--                            <div class="col-md-2 lotteryboard_forms_lottery">-->
<!--                                <a href="/lot/?i=jsft">-->
<!--                                    <img src="--><?//=$cdn_url?><!--Common/Lottery/xyft.png">-->
<!--                                    <p style="color:white;margin-top: 10px;">极速飞艇</p>-->
<!--                                </a>-->
<!--                            </div>-->

                        </div>
                    </div>
                </div>
                <div class="lotteryboard_row lotteryboard_forms_unit">
                    <div class="col-md-2">
                        <img src="<?=$cdn_url?>Common/Lottery/fpk10.png">
                        <p>快乐10分</p>
                    </div>
                    <div class="col-md-10">
                        <div class="lotteryboard_row">
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=kl10&lottery_type=gdkl10">
                                    <img src="../Lottery/Images/Lottery/gdklsf.png">
                                    <p style="color:white;margin-top: 10px;">广东快乐10分</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=kl10&lottery_type=cqkl10">
                                    <img src="../Lottery/Images/Lottery/cqklsf.png">
                                    <p style="color:white;margin-top: 10px;">重庆快乐10分</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=kl10&lottery_type=tjkl10">
                                    <img src="../Lottery/Images/Lottery/tjklsf.png">
                                    <p style="color:white;margin-top: 10px;">天津快乐10分</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=kl10&lottery_type=hnkl10">
                                    <img src="../Lottery/Images/Lottery/hnklsf.png">
                                    <p style="color:white;margin-top: 10px;">湖南快乐10分</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=kl10&lottery_type=sxkl10">
                                    <img src="../Lottery/Images/Lottery/sxklsf.png">
                                    <p style="color:white;margin-top: 10px;">山西快乐10分</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=kl10&lottery_type=ynkl10">
                                    <img src="../Lottery/Images/Lottery/ynklsf.png">
                                    <p style="color:white;margin-top: 10px;">云南快乐10分</p>
                                </a>
                            </div>
<!--                            <div class="col-md-2 lotteryboard_forms_lottery">-->
<!--                                <a href="/lot/?i=kl10&lottery_type=ynkl10">-->
<!--                                    <img src="--><?//=$cdn_url?><!--Common/Lottery/klsf.png">-->
<!--                                    <p style="color:white;margin-top: 10px;">分分快乐10分</p>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="col-md-2 lotteryboard_forms_lottery">-->
<!--                                <a href="/lot/?i=kl10&lottery_type=ynkl10">-->
<!--                                    <img src="--><?//=$cdn_url?><!--Common/Lottery/klsf.png">-->
<!--                                    <p style="color:white;margin-top: 10px;">三分快乐10分</p>-->
<!--                                </a>-->
<!--                            </div>-->

                        </div>
                    </div>
                </div>
                <div class="lotteryboard_row lotteryboard_forms_unit">
                    <div class="col-md-2">
                        <img src="<?=$cdn_url?>Common/Lottery/fpk10.png">
                        <p>11选5</p>
                    </div>
                    <div class="col-md-10">
                        <div class="lotteryboard_row">
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=choose5&lottery_type=gdchoose5">
                                    <img src="../Lottery/Images/Lottery/gdchoose5.png">
                                    <p style="color:white;margin-top: 10px;">广东11选5</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=choose5&lottery_type=sdchoose5">
                                    <img src="../Lottery/Images/Lottery/sdchoose5.png">
                                    <p style="color:white;margin-top: 10px;">山东11选5</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=choose5&lottery_type=fjchoose5">
                                    <img src="../Lottery/Images/Lottery/fjchoose5.png">
                                    <p style="color:white;margin-top: 10px;">福建11选5</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=choose5&lottery_type=bjchoose5">
                                    <img src="../Lottery/Images/Lottery/bjchoose5.png">
                                    <p style="color:white;margin-top: 10px;">北京11选5</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=choose5&lottery_type=ahchoose5">
                                    <img src="../Lottery/Images/Lottery/ahchoose5.png">
                                    <p style="color:white;margin-top: 10px;">安徽11选5</p>
                                </a>
                            </div>
<!--                            <div class="col-md-2 lotteryboard_forms_lottery">-->
<!--                                <a href="/lot/?i=choose5&lottery_type=yfchoose5">-->
<!--                                    <img src="--><?//=$cdn_url?><!--Common/Lottery/klsf.png">-->
<!--                                    <p style="color:white;margin-top: 10px;">一分11选5</p>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="col-md-2 lotteryboard_forms_lottery">-->
<!--                                <a href="/lot/?i=choose5&lottery_type=sfchoose5">-->
<!--                                    <img src="--><?//=$cdn_url?><!--Common/Lottery/klsf.png">-->
<!--                                    <p style="color:white;margin-top: 10px;">三分11选5</p>-->
<!--                                </a>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="lotteryboard_row lotteryboard_forms_unit" style="    margin-bottom: 20px;">
                    <div class="col-md-2">
                        <img src="<?=$cdn_url?>Common/Lottery/yibancaiqiu.png">
                        <p>一般彩票</p>
                    </div>
                    <div class="col-md-10">
                        <div class="lotteryboard_row">
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=shssl">
                                    <img src="<?=$cdn_url?>Common/Lottery/shssl.png">
                                    <p style="color:white;margin-top: 10px;">上海时时乐</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=pl3">
                                    <img src="<?=$cdn_url?>Common/Lottery/pl3.png">
                                    <p style="color:white;margin-top: 10px;">排列三</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=3d">
                                    <img src="<?=$cdn_url?>Common/Lottery/3d.png">
                                    <p style="color:white;margin-top: 10px;">福彩3D</p>
                                </a>
                            </div>
							<div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=qxc">
                                    <img src="<?=$cdn_url?>Common/Lottery/qxc.png">
                                    <p style="color:white;margin-top: 10px;">七星彩</p>
                                </a>
                            </div>
<!--                            <div class="col-md-2 lotteryboard_forms_lottery">-->
<!--                                <a href="/lot/?i=ffqxc">-->
<!--                                    <img src="--><?//=$cdn_url?><!--Common/Lottery/qxc.png">-->
<!--                                    <p style="color:white;margin-top: 10px;">分分七星彩</p>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="col-md-2 lotteryboard_forms_lottery">-->
<!--                                <a href="/lot/?i=wfqxc">-->
<!--                                    <img src="--><?//=$cdn_url?><!--Common/Lottery/qxc.png">-->
<!--                                    <p style="color:white;margin-top: 10px;">五分七星彩</p>-->
<!--                                </a>-->
<!--                            </div>-->
							<div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=kl8">
                                    <img src="<?=$cdn_url?>Common/Lottery/kl8.png">
                                    <p style="color:white;margin-top: 10px;">北京快乐8</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=pcdd">
                                    <img src="../Lottery/Images/Lottery/pc_28.png">
                                    <p style="color:white;margin-top: 10px;">PC蛋蛋</p>
                                </a>
                            </div>
<!--                            <div class="col-md-2 lotteryboard_forms_lottery">-->
<!--                                <a href="/lot/?i=ffpcdd">-->
<!--                                    <img src="--><?//=$cdn_url?><!--Common/Lottery/kl8.png">-->
<!--                                    <p style="color:white;margin-top: 10px;">分分PC蛋蛋</p>-->
<!--                                </a>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="lotteryboard_row lotteryboard_forms_unit" style="    margin-bottom: 20px;">
                    <div class="col-md-2">
                        <img src="<?=$cdn_url?>Common/Lottery/yibancaiqiu.png">
                        <p>快3</p>
                    </div>
                    <div class="col-md-10">
                        <div class="lotteryboard_row">
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=jsk3">
                                    <img src="../Lottery/Images/Lottery/jsk3.png">
                                    <p style="color:white;margin-top: 10px;">江苏快3</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=ahk3">
                                    <img src="../Lottery/Images/Lottery/ahk3.png">
                                    <p style="color:white;margin-top: 10px;">安徽快3</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=gxk3">
                                    <img src="../Lottery/Images/Lottery/gxk3.png">
                                    <p style="color:white;margin-top: 10px;">广西快3</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=shk3">
                                    <img src="../Lottery/Images/Lottery/shk3.png">
                                    <p style="color:white;margin-top: 10px;">上海快3</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=hbk3">
                                    <img src="../Lottery/Images/Lottery/hbk3.png">
                                    <p style="color:white;margin-top: 10px;">湖北快3</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=hebk3">
                                    <img src="../Lottery/Images/Lottery/hebk3.png">
                                    <p style="color:white;margin-top: 10px;">河北快3</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=fjk3">
                                    <img src="../Lottery/Images/Lottery/fjk3.png">
                                    <p style="color:white;margin-top: 10px;">福建快3</p>
                                </a>
                            </div>

                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=jxk3">
                                    <img src="../Lottery/Images/Lottery/jxk3.png">
                                    <p style="color:white;margin-top: 10px;">江西快3</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=nmgk3">
                                    <img src="../Lottery/Images/Lottery/nmk3.png">
                                    <p style="color:white;margin-top: 10px;">内蒙古快3</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=gsk3">
                                    <img src="../Lottery/Images/Lottery/gsk3.png">
                                    <p style="color:white;margin-top: 10px;">甘肃快3</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=bjk3">
                                    <img src="../Lottery/Images/Lottery/bjk3.png">
                                    <p style="color:white;margin-top: 10px;">北京快3</p>
                                </a>
                            </div>

                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=jlk3">
                                    <img src="../Lottery/Images/Lottery/jlk3.png">
                                    <p style="color:white;margin-top: 10px;">吉林快3</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=gzk3">
                                    <img src="../Lottery/Images/Lottery/gzk3.png">
                                    <p style="color:white;margin-top: 10px;">贵州快3</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=ffk3">
                                    <img src="../Lottery/Images/Lottery/jsk3.png">
                                    <p style="color:white;margin-top: 10px;">分分快3</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=sfk3">
                                    <img src="../Lottery/Images/Lottery/jsk3.png">
                                    <p style="color:white;margin-top: 10px;">超级快3</p>
                                </a>
                            </div>
                            <div class="col-md-2 lotteryboard_forms_lottery">
                                <a href="/lot/?i=k3&lottery_type=wfk3">
                                    <img src="../Lottery/Images/Lottery/jsk3.png">
                                    <p style="color:white;margin-top: 10px;">好运快3</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	<div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/angular@1.6.9/angular.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/angular-animate@1.6.9/angular-animate.min.js" type="text/javascript"></script>
<script src="/Common/Script/site.js" type="text/javascript"></script>
<script src="/Common/Script/services.min.js" type="text/javascript"></script>
<script src="/Common/Script/controllers.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/pym.js@1.3.2/dist/pym.v1.min.js"></script>
<script>var pymChild = new pym.Child();</script>
<script>
	$(function(){
		$('.lotteryboard_pk_select_tab').click(function (e) {
			$(this).addClass('toggle').siblings().removeClass('toggle');
			$('.lotteryboard_pk_forms').siblings().fadeOut(500, function () {
				$('.lotteryboard_pk_forms').fadeIn(500)
			})

		})
		$('.lotteryboard_forms_lottery').on('mouseover', function (e) {
			$(this).css({
				'box-shadow': '5px 5px 5px black',
				'transform': 'scale(1.1)',
				'transition': 'all 500ms ease 0s',
				'-webkit-transform': 'scale(1.1)',
				'-webkit-transform': 'all 1s ease 0s'
			})
		})
		$('.lotteryboard_forms_lottery').on('mouseout', function (e) {
			$(this).css({
				'box-shadow': 'none',
				'transform': 'scale(1)',
				'transition': 'all 500ms ease 0s',
				'-webkit-transform': 'scale(1)',
				'-webkit-transform': 'all 1s ease 0s'
			})
		})
	});
   
</script>
</body>
</html>