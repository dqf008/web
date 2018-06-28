<?php
defined('IN_AGENT')||exit('Access denied');
include IN_AGENT.'include/template/header.php';
$details = get_agent_details($AGENT['user']['uid'], $AGENT['user']['tid'], $AGENT['user']['team']);
$records = include(IN_AGENT.'include/game.php');
?>
		<div class="section">
			<div data-init="mycommission">
				<div class="wrapper">
					<div class="commission-member">
						<div class="username fl">
							<div class="title"><p><?php echo $AGENT['user']['username']; ?>&nbsp;<span class="time j-time hide"></span></p></div>
							<p class="word">又是充满机遇的一天</p>
							<p class="word">勤奋，让人成功。自信，让人充满希望</p>
						</div>
						<ul class="info fr">
							<li>
								<a class="show" href="javascript:;">
									<i class="icon name"></i>
									<p>
										<span>真实姓名</span>
										<!-- <span class="text-third">马上完善？</span> -->
<?php if(empty($AGENT['user']['pay_name'])){ ?>										<span class="text-third">请完善信息</span>
<?php }else{ ?>										<span class="text-lesser"><?php echo $AGENT['user']['pay_name']; ?></span>
<?php } ?>									</p>
								</a>
							</li>
							<li>
								<a class="show" href="javascript:;">
									<i class="icon phone"></i>
									<p>
										<span>联系号码</span>
										<!-- <span class="text-third">马上完善？</span> -->
<?php if(empty($AGENT['user']['mobile'])){ ?>										<span class="text-third">请完善信息</span>
<?php }else{ ?>										<span class="text-lesser"><?php echo cutTitle($AGENT['user']['mobile'], 8); ?></span>
<?php } ?>									</p>
								</a>
							</li>
							<li>
								<a class="show" href="javascript:;">
									<i class="icon bankcard"></i>
									<p>
										<span>银行账号</span>
										<!-- <span class="text-third">马上完善？</span> -->
<?php if(empty($AGENT['user']['pay_num'])){ ?>										<span class="text-third">请完善信息</span>
<?php }else{ ?>										<span class="text-lesser"><?php echo cutNum($AGENT['user']['pay_num']); ?></span>
<?php } ?>									</p>
								</a>
							</li>
							<li>
								<a class="show" href="javascript:;">
									<i class="icon logintime"></i>
									<p>
										<span>上次登录</span>
										<span class="text-lesser"><?php echo $AGENT['user']['login_time']; ?></span>
									</p>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="wrapper">
					<div class="commission-content">
						<div class="tab active fl" data-name="promoLink">代理佣金</div>
						<div class="tab fl">推荐会员</div>
						<div class="tab fl">会员财务</div>
						<div class="tab fl">会员注单</div>
						<div class="tab fr">代理报表</div>
						<div class="content">
<?php if(isset($AGENT['config']['Tips'])&&!empty($AGENT['config']['Tips'])){ ?>							<div class="desc">
<?php foreach($AGENT['config']['Tips'] as $k=>$v){if($k<3){ ?>								<span><?php echo $v; ?></span>
<?php }} ?>							</div>
<?php } ?>							<div class="detail j-detail">
								<div class="item">
									<div class="left fl">
										<p>直属会员</p>
										<p class="bold margint-3">总人数</p>
										<i class="icon arrow-right"></i>
									</div>
									<div data-name="total" class="right marginl-18 fl"><?php echo $details['total']; ?></div>
								</div>
								<div class="item">
									<div class="left fl">
										<p>直属会员7天</p>
										<p class="bold margint-3">推荐人数</p>
										<i class="icon arrow-right"></i>
									</div>
									<div data-name="7days" class="right marginl-18 fl"><?php echo $details['7days']; ?></div>
								</div>
								<div class="item marginr-0">
									<div class="left fl">
										<p>直属会员30天</p>
										<p class="bold margint-3">推荐人数</p>
										<i class="icon arrow-right"></i>
									</div>
									<div data-name="30days" class="right marginl-18 fl"><?php echo $details['30days']; ?></div>
								</div>
                                <div class="item">
                                    <div class="left fl">
                                        <p>直属会员昨天</p>
                                        <p class="bold margint-3">派彩金额</p>
                                        <i class="icon arrow-right"></i>
                                    </div>
                                    <div data-name="w_yesterday" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['w_yesterday']/100); ?></div>
                                </div>
                                <div class="item">
                                    <div class="left fl">
                                        <p>直属会员7天</p>
                                        <p class="bold margint-3">派彩金额</p>
                                        <i class="icon arrow-right"></i>
                                    </div>
                                    <div data-name="w_7days" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['w_7days']/100); ?></div>
                                </div>
                                <div class="item marginr-0">
                                    <div class="left fl">
                                        <p>直属会员30天</p>
                                        <p class="bold margint-3">派彩金额</p>
                                        <i class="icon arrow-right"></i>
                                    </div>
                                    <div data-name="w_30days" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['w_30days']/100); ?></div>
                                </div>
                                <div class="item">
                                    <div class="left fl">
                                        <p>直属会员昨天</p>
                                        <p class="bold margint-3">存款金额</p>
                                        <i class="icon arrow-right"></i>
                                    </div>
                                    <div data-name="c_yesterday" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['c_yesterday']/100); ?></div>
                                </div>
                                <div class="item">
                                    <div class="left fl">
                                        <p>直属会员7天</p>
                                        <p class="bold margint-3">存款金额</p>
                                        <i class="icon arrow-right"></i>
                                    </div>
                                    <div data-name="c_7days" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['c_7days']/100); ?></div>
                                </div>
                                <div class="item marginr-0">
                                    <div class="left fl">
                                        <p>直属会员30天</p>
                                        <p class="bold margint-3">存款金额</p>
                                        <i class="icon arrow-right"></i>
                                    </div>
                                    <div data-name="c_30days" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['c_30days']/100); ?></div>
                                </div>
                                <div class="item">
                                    <div class="left fl">
                                        <p>直属会员昨天</p>
                                        <p class="bold margint-3">取款金额</p>
                                        <i class="icon arrow-right"></i>
                                    </div>
                                    <div data-name="q_yesterday" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['q_yesterday']/100); ?></div>
                                </div>
                                <div class="item">
                                    <div class="left fl">
                                        <p>直属会员7天</p>
                                        <p class="bold margint-3">取款金额</p>
                                        <i class="icon arrow-right"></i>
                                    </div>
                                    <div data-name="q_7days" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['q_7days']/100); ?></div>
                                </div>
                                <div class="item marginr-0">
                                    <div class="left fl">
                                        <p>直属会员30天</p>
                                        <p class="bold margint-3">取款金额</p>
                                        <i class="icon arrow-right"></i>
                                    </div>
                                    <div data-name="q_30days" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['q_30days']/100); ?></div>
                                </div>
                                <div class="item">
                                    <div class="left fl">
                                        <p>直属会员昨天</p>
                                        <p class="bold margint-3">预计佣金</p>
                                        <i class="icon arrow-right"></i>
                                    </div>
                                    <div data-name="m_yesterday" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['m_yesterday']/100); ?></div>
                                </div>
                                <div class="item">
                                    <div class="left fl">
                                        <p>直属会员7天</p>
                                        <p class="bold margint-3">预计佣金</p>
                                        <i class="icon arrow-right"></i>
                                    </div>
                                    <div data-name="m_7days" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['m_7days']/100); ?></div>
                                </div>
                                <div class="item marginr-0">
                                    <div class="left fl">
                                        <p>直属会员30天</p>
                                        <p class="bold margint-3">预计佣金</p>
                                        <i class="icon arrow-right"></i>
                                    </div>
                                    <div data-name="m_30days" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['m_30days']/100); ?></div>
                                </div>
<?php if($AGENT['user']['team']){ ?>								<div class="item">
									<div class="left fl">
										<p>团队昨天</p>
										<p class="bold margint-3">预计佣金</p>
										<i class="icon arrow-right"></i>
									</div>
									<div data-name="t_yesterday" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['t_yesterday']/100); ?></div>
								</div>
								<div class="item">
									<div class="left fl">
										<p>团队7天</p>
										<p class="bold margint-3">预计佣金</p>
										<i class="icon arrow-right"></i>
									</div>
									<div data-name="t_7days" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['t_7days']/100); ?></div>
								</div>
								<div class="item marginr-0">
									<div class="left fl">
										<p>团队30天</p>
										<p class="bold margint-3">预计佣金</p>
										<i class="icon arrow-right"></i>
									</div>
									<div data-name="t_30days" class="right marginl-18 fl"><?php echo sprintf('%.2f', $details['t_30days']/100); ?></div>
								</div>
<?php } ?>							</div>
							<div class="tips"><span>* 不含当天，数据统计时间截止北京时间中午12点</span></div>
						</div>
						<div class="content hide j-member">
							<div class="search">
								<div class="dropdown j-dropdown fl<?php echo $AGENT['user']['team']?'':' hide'; ?>">
									<span class="j-memberTypeValue" data-value="all">直属会员</span>
									<i class="icon downarrow2 fr"></i>
									<div class="list j-memberType hide">
										<div data-value="all" class="item">直属会员</div>
										<div data-value="agent" class="item">下层代理</div>
									</div>
								</div>
								<div class="info fl<?php echo $AGENT['user']['team']?'':' hide'; ?>">
									<span class="team-valid-bet j-selectAgent">点击选择下层代理</span>
								</div>
								<div class="input-box fr">
									<input type="text" name="account" placeholder="请输入帐号或姓名" class="input fl">
									<button type="button" class="button j-search fl">搜索</button>
								</div>
							</div>
							<div class="table-box j-table">
								<table>
									<thead>
										<tr>
											<th>会员账号</th>
											<th>真实姓名</th>
											<th>注册时间(美东/北京)</th>
											<th>最近登录(美东/北京)</th>
											<th>当前余额</th>
											<th>在线</th>
											<th>状态</th>
										</tr>
									</thead>
									<tbody class="j-tbody"></tbody>
									<tbody>
										<tr class="null-info j-onLoad"><td colspan="7">加载中...</td></tr>
										<tr class="null-info j-noData hide"><td colspan="7">暂无数据</td></tr>
									</tbody>
								</table>
								<div class="mask j-loading"><img src="static/style/images/loading.gif" /></div>
							</div>
							<div class="pager-box j-pager hide">
								<ul class="pager">
									<li>首页</li>
									<li>上一页</li>
									<li class="active">1</li>
									<li>2</li>
									<li>3</li>
									<li>4</li>
									<li>下一页</li>
									<li>尾页</li>
								</ul>
							</div>
							<div class="pager-box tips"><span>* 当前余额不含游戏平台余额</span></div>
						</div>
						<div class="content hide j-money">
							<div class="search">
								<div class="dropdown j-dropdown fl">
									<span class="j-moneyTypeValue" data-value="1">存款记录</span>
									<i class="icon downarrow2 fr"></i>
									<div class="list hide">
										<div data-value="1" class="item">存款记录</div>
										<div data-value="2" class="item">汇款记录</div>
										<div data-value="3" class="item">提款记录</div>
										<div data-value="4" class="item">其它记录</div>
									</div>
								</div>
								<div class="dropdown j-dropdown ml15 fl" style="display:none">
									<span class="j-otherTypeValue" data-value="4">全部</span>
									<i class="icon downarrow2 fr"></i>
									<div class="list hide">
										<div data-value="4" class="item">全部</div>
										<div data-value="5" class="item">人工汇款</div>
										<div data-value="6" class="item">彩金派送</div>
										<div data-value="7" class="item">返水派送</div>
										<div data-value="8" class="item">其它情况</div>
									</div>
								</div>
								<div class="dropdown ml15 fl">
									<span class="j-daysValue" data-value="0">今天</span>
									<i class="icon downarrow2 fr"></i>
									<div class="list hide">
										<div data-value="0" class="item">今天</div>
										<div data-value="1" class="item">昨天</div>
										<div data-value="7" class="item">最近7天</div>
										<div data-value="30" class="item">最近30天</div>
										<div data-value="180" class="item">最近180天</div>
									</div>
								</div>
								<div class="info fl<?php echo $AGENT['user']['team']?'':' hide'; ?>">
									<span class="team-valid-bet j-selectAgent">点击选择下层代理</span>
								</div>
								<div class="input-box fr">
									<input type="text" name="account" placeholder="请输入帐号或姓名" class="input fl">
									<button type="button" class="button j-search fl">搜索</button>
								</div>
							</div>
							<div class="table-box j-table">
								<table>
									<thead>
										<tr>
											<th>会员账号</th>
											<th>订单流水</th>
											<th>订单时间(美东/北京)</th>
											<th>订单金额</th>
											<th>订单状态</th>
										</tr>
									</thead>
									<tbody class="j-tbody"></tbody>
									<tbody>
										<tr class="null-info j-onLoad"><td colspan="5">加载中...</td></tr>
										<tr class="null-info j-noData hide"><td colspan="5">暂无数据</td></tr>
									</tbody>
                                    <tbody>
                                        <tr class="total j-total hide">
                                            <td style="text-align:right;padding-right:15px">订单数量</td>
                                            <td class="j-totalCount">0</td>
                                            <td style="text-align:right;padding-right:15px">财务合计</td>
                                            <td class="j-totalMoney">0</td>
                                            <td>--</td>
                                        </tr>
                                    </tbody>
								</table>
								<div class="mask j-loading"><img src="static/style/images/loading.gif" /></div>
							</div>
							<div class="pager-box j-pager hide">
								<ul class="pager">
									<li>首页</li>
									<li>上一页</li>
									<li class="active">1</li>
									<li>2</li>
									<li>3</li>
									<li>4</li>
									<li>下一页</li>
									<li>尾页</li>
								</ul>
							</div>
						</div>
						<div class="content hide j-records">
							<div class="search">
								<div class="dropdown j-dropdown fl">
									<span class="j-recordsValue" data-value="<?php $keys = array_keys($records['menu']);echo $keys[0]; ?>"><?php echo $records['menu'][$keys[0]]; ?></span>
									<i class="icon downarrow2 fr"></i>
									<div class="list hide">
<?php foreach($records['menu'] as $key=>$val){ ?>										<div data-value="<?php echo $key; ?>" class="item"><?php echo $val; ?></div>
<?php } ?>									</div>
								</div>
<?php
foreach($records['menu'] as $key=>$val){
	$val = array_keys($records[$key]);
	$val = $val[0];
?>								<div class="dropdown j-records-<?php echo $key; ?> ml15 fl"<?php echo $key!=$keys[0]?' style="display:none"':''; ?>>
									<span class="j-recordsTypeValue" data-value="<?php echo $val; ?>"><?php echo $records[$key][$val]; ?></span>
									<i class="icon downarrow2 fr"></i>
									<div class="list hide">
<?php foreach($records[$key] as $k=>$v){ ?>										<div data-value="<?php echo $k; ?>" class="item"><?php echo $v; ?></div>
<?php } ?>									</div>
								</div>
<?php } ?>								<div class="dropdown j-dropdown ml15 fl">
									<span class="j-daysValue" data-value="0">今天</span>
									<i class="icon downarrow2 fr"></i>
									<div class="list hide">
										<div data-value="0" class="item">今天</div>
										<div data-value="1" class="item">昨天</div>
										<div data-value="7" class="item">最近7天</div>
										<div data-value="30" class="item">最近30天</div>
										<div data-value="180" class="item">最近180天</div>
									</div>
								</div>
								<div class="info fl<?php echo $AGENT['user']['team']?'':' hide'; ?>">
									<span class="team-valid-bet j-selectAgent">点击选择下层代理</span>
								</div>
								<div class="input-box fr">
									<input type="text" name="account" placeholder="请输入帐号或姓名" class="input fl">
									<button type="button" class="button j-search fl">搜索</button>
								</div>
							</div>
							<div class="table-box j-table">
								<table>
									<thead>
										<tr>
											<th>会员账号</th>
											<th>流水号码</th>
											<th data-key="betTime">投注时间(美东/北京)</th>
											<th>投注金额</th>
											<th>派彩金额</th>
											<th>状态</th>
										</tr>
									</thead>
									<tbody class="j-tbody"></tbody>
									<tbody>
										<tr class="null-info j-onLoad"><td colspan="6">加载中...</td></tr>
										<tr class="null-info j-noData hide"><td colspan="6">暂无数据</td></tr>
									</tbody>
								</table>
								<div class="mask j-loading"><img src="static/style/images/loading.gif" /></div>
							</div>
							<div class="pager-box j-pager hide">
								<ul class="pager">
									<li>首页</li>
									<li>上一页</li>
									<li class="active">1</li>
									<li>2</li>
									<li>3</li>
									<li>4</li>
									<li>下一页</li>
									<li>尾页</li>
								</ul>
							</div>
							<div class="pager-box tips"><span>* 派彩金额不含投注金额</span></div>
						</div>
						<div class="content j-reports hide">
							<div class="search">
								<div class="dropdown j-dropdown fl">
									<span class="j-daysValue" data-value="7">最近7天</span>
									<i class="icon downarrow2 fr"></i>
									<div class="list hide">
										<div data-value="7" class="item">最近7天</div>
										<div data-value="30" class="item">最近30天</div>
										<div data-value="180" class="item">最近180天</div>
									</div>
								</div>
								<div class="info fl<?php echo $AGENT['user']['team']?'':' hide'; ?>">
									<span class="team-valid-bet j-selectAgent">点击选择下层代理</span>
								</div>
								<div class="input-box fr hide">
									<input type="text" name="account" placeholder="请输入帐号或姓名" class="input fl">
									<button type="button" class="button fl j-search">搜索</button>
								</div>
							</div>
							<div class="table-box j-table">
								<table>
									<thead>
										<tr>
											<th>代理账号</th>
											<th>统计时间</th>
											<th>注单数量</th>
											<th>注单金额</th>
											<th>派彩金额</th>
											<th>有效投注</th>
											<th>预计佣金</th>
										</tr>
									</thead>
									<tbody class="j-tbody"></tbody>
									<tbody>
										<tr class="total j-total hide">
											<td colspan="2">当前页合计</td>
											<td class="j-totalCount">0</td>
											<td class="j-totalBet">0</td>
											<td class="j-totalNet">0</td>
											<td class="j-totalValid">0</td>
											<td class="j-totalMoney">0</td>
										</tr>
										<tr class="null-info j-onLoad"><td colspan="7">加载中...</td></tr>
										<tr class="null-info j-noData hide"><td colspan="7">暂无数据</td></tr>
									</tbody>
								</table>
								<div class="mask j-loading"><img src="static/style/images/loading.gif" /></div>
							</div>
							<div class="pager-box j-pager hide">
								<ul class="pager">
									<li>首页</li>
									<li>上一页</li>
									<li class="active">1</li>
									<li>2</li>
									<li>3</li>
									<li>4</li>
									<li>下一页</li>
									<li>尾页</li>
								</ul>
							</div>
							<div class="pager-box tips"><span>* 不含当天，派彩金额不含投注金额</span></div>
							<div class="pager-box tips"><span class="text-third j-formula"></span></div>
						</div>
					</div>
				</div>
				<div class="wrapper" id="j-promoLink">
					<div class="commission-link">
						<div class="left fl">
							<p class="id">您的推广用户名：<span><?php echo $AGENT['user']['username']; ?></span></p>
							<p class="link">推荐链接：<span class="j-link"><?php echo $AGENT['user']['url']; ?></span></p>
							<p class="tips">将链接分享给您的朋友，让朋友通过此链接注册，会员通过游戏您就可以获得相应佣金。</p>
						</div>
						<div class="copy j-copy fr" data-clipboard-action="copy" data-clipboard-target=".j-link">
							<div class="animation">
								<div class="content"><i class="icon share"></i><br /><span>复制分享</span></div>
								<div class="content"><i class="icon share"></i><br /><span>复制分享</span></div>
							</div>
						</div>
					</div>
				</div>
				<div class="commission-content j-reportsDetailsDialog hide">
					<div class="content">
						<div class="table-box j-team-table" style="margin-top:20px">
							<table>
								<thead>
									<tr>
										<th>类型</th>
										<th>注单数量</th>
										<th>注单金额</th>
										<th>派彩金额</th>
										<th>有效投注</th>
									</tr>
								</thead>
								<tbody class="j-team-tbody"></tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="commission-content j-selectAgentDialog hide">
					<div class="content">
						<div class="search">
							<div class="input-box fl">
								<button type="button" class="button j-confirm fl">确认</button>
								<span class="button fl" style="display:none"><img src="static/style/images/loading.gif" style="margin-top:10px"></span>
							</div>
							<div class="input-box fr">
								<input type="text" name="account" placeholder="请输入帐号或姓名" class="input fl">
								<button type="button" class="button j-search fl">搜索</button>
							</div>
						</div>
						<div class="table-box j-table">
							<table>
								<thead>
									<tr>
										<th><input type="checkbox" /></th>
										<th>会员账号</th>
										<th>真实姓名</th>
									</tr>
									<tr class="null-info j-onLoad"><td colspan="3">加载中...</td></tr>
									<tr class="null-info j-noData hide"><td colspan="3">暂无数据</td></tr>
								</thead>
								<tbody class="j-tbody"></tbody>
								<tbody class="hide">
									<tr class="total j-total">
										<td colspan="3">您正在查看<span class="text-info">「第<span class="j-agentLevel"></span>层」</span><span class="text-primary j-agentName"></span> 的下层代理，<a class="team-valid-bet" href="javascript:;">返回上层</a></td>
									</tr>
								</tbody>
							</table>
							<div class="mask j-loading"><img src="static/style/images/loading.gif" /></div>
						</div>
						<div class="pager-box j-pager hide">
							<ul class="pager">
								<li>首页</li>
								<li>上一页</li>
								<li class="active">1</li>
								<li>2</li>
								<li>3</li>
								<li>4</li>
								<li>下一页</li>
								<li>尾页</li>
							</ul>
						</div>
						<div class="pager-box tips text-l"><span class="">* 未选择代理点击确定将选择上层代理</span></div>
					</div>
				</div>
				<div class="commission-content j-moneyDetailsDialog hide">
					<div class="content">
						<div class="search" style="height:auto">
							<div class="info"><span class="fl">会员账号：<span class="text-primary" data-key="username"></span></span></div>
							<div class="info"><span class="fl">订单流水：<span class="text-primary" data-key="orderId"></span></span></div>
							<div class="info"><span class="fl">订单时间：<span class="text-primary" data-key="orderTime"></span></span></div>
							<div class="info"><span class="fl">订单金额：<span class="text-primary" data-key="money"></span></span></div>
							<div class="info"><span class="fl">订单状态：<span class="text-primary" data-key="statusText"></span></span></div>
							<div class="info"><span class="fl">订单类型：<span class="text-primary" data-key="type"></span></span></div>
							<div class="info"><span class="fl">手续费用：<span class="text-primary" data-key="fee"></span></span></div>
							<div class="info"><span class="fl">银行卡号：<span class="text-primary" data-key="bankCard"></span></span></div>
							<div class="info"><span class="fl">汇款时间：<span class="text-primary" data-key="bankTime"></span>（实际）</span></div>
							<div class="info"><span class="fl">汇款赠送：<span class="text-primary" data-key="bankFee"></span></span></div>
							<div class="info"><span class="fl">汇款银行：<span class="text-primary" data-key="bank"></span></span></div>
							<div class="info"><span class="fl">汇款方式：<span class="text-primary" data-key="bankType"></span></span></div>
							<div class="info"><span class="fl">备注说明：<span class="text-primary" data-key="about"></span></span></div>
						</div>
					</div>
				</div>
				<div class="commission-content j-recordsDetailsDialog hide">
					<div class="content">
						<div class="search" style="height:auto">
							<div class="info"><span class="fl">会员账号：<span class="text-primary" data-key="username"></span></span></div>
							<div class="info"><span class="fl">流水号码：<span class="text-primary" data-key="id"></span></span></div>
							<div class="info"><span class="fl">投注日期：<span class="text-primary" data-key="createTime"></span>（美东）</span></div>
							<div class="info"><span class="fl">投注时间：<span class="text-primary" data-key="betTime"></span></span></div>
							<div class="info"><span class="fl">投注期号：<span class="text-primary" data-key="expect"></span></span></div>
							<div class="info"><span class="fl">投注模式：<span class="text-primary" data-key="betMode"></span></span></div>
							<div class="info"><span class="fl">投注金额：<span class="text-primary" data-key="betAmount"></span></span></div>
							<div class="info"><span class="fl">投注赔率：<span class="text-primary" data-key="odds"></span></span></div>
							<div class="info"><span class="fl">可赢金额：<span class="text-primary" data-key="winAmount"></span></span></div>
							<div class="info"><span class="fl">派彩金额：<span class="text-primary" data-key="netAmount"></span></span></div>
							<div class="info"><span class="fl">有效投注：<span class="text-primary" data-key="validAmount"></span></span></div>
							<div class="info"><span class="fl">返水金额：<span class="text-primary" data-key="rewardAmount"></span></span></div>
							<div class="info"><span class="fl">注单数量：<span class="text-primary" data-key="rowCount"></span></span></div>
							<div class="info"><span class="fl">结算状态：<span class="text-primary" data-key="status"></span></span></div>
							<div class="info"><span class="fl">投注内容：</span></div>
							<div class="info" style="height:auto;line-height:24px;text-align:left;max-height:200px;overflow-y:auto"><span class="text-primary" data-key="remark"></span></div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php include IN_AGENT.'include/template/footer.php'; ?>