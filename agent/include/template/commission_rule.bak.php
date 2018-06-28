<?php
defined('IN_AGENT')||exit('Access denied');
include IN_AGENT.'include/template/header.php';
?>
		<div class="section">
			<div class="wrapper">
				<div class="commission-desc">
					<div class="overlapping">
						<div class="overlapping">
							<div class="overlapping">
								<div class="content">
									<div class="head">佣金条款</div>
									<div class="total">
										<p class="word">我们基于丰富的娱乐游戏，为乐于推广会员的您提供丰富的代理佣金，且每周指定时间系统将会为您计算佣金，并根据条款将符合条件的奖金发放到会员账户上，所发放佣金不计洗码量可直接出款。<span class="third">请务必确认您的会员账号及财务信息是否正确有效，否则不能出款。</span></p>
										<table class="table">
											<tbody>
												<tr>
													<td class="col-20"><img src="static/style/images/<?php echo AGENT_SKIN; ?>/agency-commission.png" alt="agencyCommission"></td>
													<td class="symbol col-20">=</td>
													<td class="col-20"><img src="static/style/images/<?php echo AGENT_SKIN; ?>/member-commission.png" alt="memberCommission"></td>
													<td class="symbol col-20">+</td>
													<td class="col-20"><img src="static/style/images/<?php echo AGENT_SKIN; ?>/team-commission.png" alt="teamCommission"></td>
													<td class="symbol col-20">+</td>
													<td class="col-20"><img src="static/style/images/<?php echo AGENT_SKIN; ?>/deposit-commission.png" alt="teamCommission"></td>
												</tr>
												<tr>
													<td>推广代理佣金</td>
													<td></td>
													<td>直属会员</td>
													<td></td>
													<td>团队代理</td>
													<td></td>
													<td>更多方式</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="list">
										<div class="left fl">
											<p class="title"><span>1</span>. 直属会员佣金计算方式</p>
											<p class="detail">请前往代理报表查看或与在线客服联系</p>
											<p class="line"></p>
											<p class="title"><span>2</span>. 团队佣金计算方式</p>
											<p class="detail">请前往代理报表查看或与在线客服联系</p>
										</div>
										<table class="right fl">
											<tbody>
											<tr>
												<td class="list1"><img src="static/style/images/commission-list1.png" alt="commissionList1"></td>
												<td class="list2"><img src="static/style/images/commission-list2.png" alt="commissionList2"></td>
												<td class="list3"><img src="static/style/images/commission-list3.png" alt="commissionList3"></td>
											</tr>
											<tr>
												<td class="list1" style="width: 30%;">您</td>
												<td class="list2" style="width: 35%;">直属</td>
												<td class="list3" style="width: 35%;">团队</td>
											</tr>
											</tbody>
										</table>
									</div>
									<div class="example">
										<p class="marginb-15">例子：A会员发展B会员与C会员，B会员发展D和E会员，C会员发展F和G会员，A会员佣金 =（B+C）X1‰
										+（D+E+F+G）X0.1‰</p>
										<p class="marginb-5 text-primary">* 会员必须为有效会员</p>
										<p class="marginb-5">* 有效会员必须为30天内有入款记录，非有效会员洗码量不列入佣金</p>
									</div>
									<ul class="time">
										<li class="first">
											<i class="icon commission-count-time"></i>
											<p>佣金计算时间</p>
										</li>
										<li class="second">
											<div class="day">
												<i class="icon monday"></i>
												<p>每周一</p>
											</div>
										</li>
										<li class="first">
											<i class="icon commission-give-time"></i>
											<p>佣金发放时间</p>
										</li>
										<li class="second">
											<div class="day">
												<i class="icon monday"></i>
												<p>每周一</p>
											</div>
											<div class="day">
												<i class="icon tuesday"></i>
												<p>每周二</p>
											</div>
										</li>
									</ul>
									<p class="tips text-lesser">* 最终解析权归本站所有</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php include IN_AGENT.'include/template/footer.php'; ?>