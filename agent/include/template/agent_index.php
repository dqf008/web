<?php
defined('IN_AGENT')||exit('Access denied');
include IN_AGENT.'include/template/header.php';
if(!isset($AGENT['config']['GameCount'])||empty($AGENT['config']['GameCount'])){
    $AGENT['config']['GameCount'] = '0';
}
if(!isset($AGENT['config']['AgentCount'])||empty($AGENT['config']['AgentCount'])){
    $AGENT['config']['AgentCount'] = '0';
}
if(!isset($AGENT['config']['AvgCheckout'])||empty($AGENT['config']['AvgCheckout'])){
    $AGENT['config']['AvgCheckout'] = '0.00';
}else{
    $AGENT['config']['AvgCheckout'] = sprintf('%.2f',  $AGENT['config']['AvgCheckout']);
}
if(!isset($AGENT['config']['NewMember'])||empty($AGENT['config']['NewMember'])){
    $AGENT['config']['NewMember'] = '0';
}
$file = IN_AGENT.'../cache/agent.cache.php';
$data = [];
file_exists($file)&&$data = include($file);
if(empty($data)||$data['NextUpdateTime']<time()){
    $GenerateName = function(){
        $s = chr(rand(97, 122));
        $s.= chr(rand(0, 1)==1?rand(97, 122):rand(48, 57));
        $s.= chr(rand(0, 1)==1?rand(97, 122):rand(48, 57));
        $s.= '***';
        return $s;
    };
    $CheckoutMoney = $AGENT['config']['AvgCheckout']<=0?1000:$AGENT['config']['AvgCheckout'];
    $data['NextUpdateTime'] = time()+604800;
    $data['LastJoinAgent'] = [];
    $data['LastCheckout'] = [];
    for($i=0;$i<20;$i++){
        $m = $CheckoutMoney+(rand(-10000, 100000)/100);
        $data['LastJoinAgent'][] = $GenerateName();
        $data['LastCheckout'][] = [
                $GenerateName(),
                sprintf('%.2f', $m>0?$m:$CheckoutMoney),
        ];
    }
    file_put_contents($file, '<?php'.PHP_EOL.'return unserialize(\''.serialize($data).'\');');
}
?>
		<div class="section">
			<div data-init="index">
				<div class="slick-wrapper">
					<div id="slick" class="slick-out banner">
						<div style="background:url('static/style/images/slick/bn1-bg.jpg') no-repeat top center;height:625px">
							<div class="wrapper">
								<img class="bn1-text" src="static/style/images/slick/bn1-text-zh_cn.png" alt="">
								<a href="javascript:;"></a>
							</div>
						</div>
						<div style="background:url('static/style/images/slick/bn2-bg.jpg') no-repeat top center;height:625px" class="hide">
							<div class="wrapper">
								<img class="bn2-text" src="static/style/images/slick/bn2-text-zh_cn.png" alt="">
								<img class="bn2-human" src="static/style/images/slick/bn2-human.png" alt="">
								<a href="javascript:;"></a>
							</div>
						</div>
						<div style="background:url('static/style/images/slick/bn3-bg.jpg') no-repeat top center;height:625px" class="hide">
							<div class="wrapper">
								<img class="bn3-human" src="static/style/images/slick/bn3-human.png" alt="">
								<img class="bn3-text" src="static/style/images/slick/bn3-text-zh_cn.png" alt="">
								<a href="javascript:;"></a>
							</div>
						</div>
						<div style="background:url('static/style/images/slick/bn4-bg.jpg') no-repeat top center;height:625px" class="hide">
							<div class="wrapper">
								<img class="bn4-human" src="static/style/images/slick/bn4-human.png" alt="">
								<img class="bn4-text" src="static/style/images/slick/bn4-text-zh_cn.png" alt="">
								<a href="javascript:;"></a>
							</div>
						</div>
						<div style="background:url('static/style/images/slick/bn5-bg.jpg') no-repeat top center;height:625px" class="hide">
							<div class="wrapper">
								<img class="bn5-text" src="static/style/images/slick/bn5-text-zh_cn.png" alt="">
								<a href="javascript:;"></a>
							</div>
						</div>
						<div style="background: url('static/style/images/slick/bn6-bg.jpg') no-repeat top center; height: 625px;" class="hide">
							<div class="wrapper">
								<img class="bn6-text" src="static/style/images/slick/bn6-text-zh_cn.png" alt="">
								<img class="bn6-text1" src="static/style/images/slick/bn6-text1-zh_cn.png" alt="">
								<img class="bn6-text2" src="static/style/images/slick/bn6-text2-zh_cn.png" alt="">
								<img class="bn6-text3" src="static/style/images/slick/bn6-text3-zh_cn.png" alt="">
								<a href="javascript:;"></a>
							</div>
						</div>
					</div>
					<div class="column">
						<div class="wrapper">
							<div class="part joined">
								<div class="left fl">
									<p>最新</p>
									<div>加入代理</div>
								</div>
								<div class="right fr">
									<div class="j-infomation">
<?php foreach($data['LastJoinAgent'] as $name){ ?>										<p><span class="fl"><i class="icon triangle"></i><?php echo $name; ?></span><span class="fr">成功开启成为代理</span></p>
<?php } ?>									</div>
								</div>
							</div>
							<div class="part commission">
								<div class="left fl">
									<p>上周</p>
									<div>佣金广播</div>
								</div>
								<div class="right fr">
									<div class="j-infomation">
<?php foreach($data['LastCheckout'] as $val){ ?>										<p><span class="fl"><i class="icon triangle"></i><?php echo $val[0]; ?></span><span class="fr"><?php echo '+'.$val[1]; ?></span></p>
<?php } ?>									</div>
								</div>
							</div>
							<div class="part no-border-r join"><a id="j-join"><i class="icon add"></i>马上加入</a></div>
						</div>
					</div>
				</div>
			</div>
			<div class="main">
				<div class="wrapper clearfix">
					<div class="part">
						<div class="animation">
							<div class="content">
								<p class="p1"><i class="icon game"></i></p>
								<p class="p2">提供多达</p>
								<p class="p3 numerator" data-num="<?php echo $AGENT['config']['GameCount']; ?>">0</p>
								<hr />
								<p class="p4">种游戏</p>
							</div>
							<div class="content">
								<p class="p1"><i class="icon game"></i></p>
								<p class="p2">提供多达</p>
								<p class="p3"><?php echo $AGENT['config']['GameCount']; ?></p>
								<hr />
								<p class="p4">种游戏</p>
							</div>
						</div>
					</div>
					<div class="part">
						<div class="animation">
							<div class="content">
								<p class="p1"><i class="icon agency"></i></p>
								<p class="p2">累积服务</p>
								<p class="p3 numerator" data-num="<?php echo $AGENT['config']['AgentCount']; ?>">0</p>
								<hr />
								<p class="p4">名代理</p>
							</div>
							<div class="content">
								<p class="p1"><i class="icon agency"></i></p>
								<p class="p2">累积服务</p>
								<p class="p3"><?php echo $AGENT['config']['AgentCount']; ?></p>
								<hr />
								<p class="p4">名代理</p>
							</div>
						</div>
					</div>
					<div class="part">
						<div class="animation">
							<div class="content">
								<p class="p1"><i class="icon money"></i></p>
								<p class="p2">平均每周</p>
								<p class="p3 numerator" data-num="<?php echo $AGENT['config']['AvgCheckout']; ?>">0</p>
								<hr />
								<p class="p4">代理出款</p>
							</div>
							<div class="content">
								<p class="p1"><i class="icon money"></i></p>
								<p class="p2">平均每周</p>
								<p class="p3"><?php echo $AGENT['config']['AvgCheckout']; ?></p>
								<hr />
								<p class="p4">代理出款</p>
							</div>
						</div>
					</div>
					<div class="part">
						<div class="animation">
							<div class="content">
								<p class="p1"><i class="icon reg"></i></p>
								<p class="p2">昨日新增</p>
								<p class="p3 numerator" data-num="<?php echo $AGENT['config']['NewMember']; ?>">0</p>
								<hr />
								<p class="p4">新注册会员</p>
							</div>
							<div class="content">
								<p class="p1"><i class="icon reg"></i></p>
								<p class="p2">昨日新增</p>
								<p class="p3"><?php echo $AGENT['config']['NewMember']; ?></p>
								<hr />
								<p class="p4">新注册会员</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="j-platform" class="multi-platform">
				<div class="wrapper">
					<div>
						<p class="p1">跨终端<i></i>跨平台</p>
						<p class="p2">CROSS-TERMINAL CROSS-PLATFORM</p>
					</div>
					<img class="img1" src="static/style/images/<?php echo AGENT_SKIN; ?>/imac.png" alt="">
					<img class="img2" src="static/style/images/<?php echo AGENT_SKIN; ?>/ipad.png" alt="">
					<img class="img3" src="static/style/images/<?php echo AGENT_SKIN; ?>/iphone.png" alt="">
					<img class="img4" src="static/style/images/<?php echo AGENT_SKIN; ?>/macbook.png" alt="">
				</div>
			</div>
			<div class="our-service">
				<p class="p1">我们为您提供</p>
				<p class="p2"><i class="icon star"></i>WE ARE HERE FOR YOU<i class="icon star"></i></p>
				<hr />
				<div class="wrapper clearfix">
					<div class="part">
						<img class="j-img1 hide" src="static/style/images/<?php echo AGENT_SKIN; ?>/odds.png" alt="">
						<p>业界最高赔率</p>
					</div>
					<div class="part">
						<img class="j-img2 hide" src="static/style/images/<?php echo AGENT_SKIN; ?>/environment.png" alt="">
						<p>稳定的游戏环境</p>
					</div>
					<div class="part">
						<img class="j-img3 hide" src="static/style/images/<?php echo AGENT_SKIN; ?>/variety.png" alt="">
						<p>最全的游戏种类</p>
					</div>
					<div class="part rebates">
						<img class="j-img4 hide" src="static/style/images/<?php echo AGENT_SKIN; ?>/rebates.png" alt="">
						<p>永久的游戏返点</p>
					</div>
				</div>
			</div>
		</div>
		<div class="commission-content j-joinUsDialog hide">
			<div class="content">
				<div class="search" style="height:auto;padding-bottom:0">
					<div class="input-box"><textarea style="resize:none;width:100%;height:150px"></textarea></div>
				</div>
			</div>
		</div>
<?php include IN_AGENT.'include/template/footer.php'; ?>