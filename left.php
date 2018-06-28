<?php 
session_start();
include_once 'include/config.php';
website_close();
website_deny();
$shuaxin = $_GET['shuaxin'];
$_SESSION['check_action'] = '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
	  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
	  <title>Welcome</title> 
	  <meta http-equiv="Cache-Control" content="max-age=864000" /> 
	  <link href="/sprots_images/order.css" rel="stylesheet" type="text/css">
	  <link href="/sprots_images/reset.css" rel="stylesheet" type="text/css">
	  <style type="text/css"> 
		   
		   body{ 
			  margin:0px;
			  padding:0px;
			  color:#383838;
			  background:#513f33;
			  position: relative;
			  font-size:12px;
			  overflow-x: hidden;
		  } 
		  html { 
			  overflow-x: hidden;
			  height: 100%;
			  width:100%;
		  } 
		 
		   
		  div,form,ul,ol,li,dl,dt,dd,p,span,img 
		   { 
			  margin: 0;
			  padding: 0;
			  border:0;
		  } 
		   
		  li,dl{ 
			  list-style-type:none;
		  } 
		   
		  a{text-decoration:none;color:#174B73;} 
		  a:hover{ text-decoration:underline;color:#900;} 
		   
		  .clear {clear: both;} 
		  .line10{height:10px;} 
		  .line5{height:5px;overflow:hidden;} 
		  .main{margin:0 auto;width:100%;background-color:#513f33;} 
		  
		 
	
	  </style> 
	  <script language="JavaScript"> 
		  window.onerror=function(){return true;} 
		  if(self==top){ 
			  top.location='/';
		  } 


	  </script> 
  </head> 
  <body style="overflow-y:scroll;">
<?php 
include_once 'database/mysql.config.php';
include_once 'common/logintu.php';
include_once 'class/user.php';
$uid = @($_SESSION['uid']);
$loginid = @($_SESSION['user_login_id']);
renovate($uid, $loginid);
?>
  <script type="text/javascript" src="skin/js2/jquery.js"></script> 
  <script type="text/javascript" src="skin/js2/common.js"></script> 
  <script type="text/javascript" src="skin/js2/global.js"></script> 
  <script type="text/javascript" src="skin/js2/DD_belatedPNG.js"></script> 
  <script language="javascript" src="/js/mouse.js"></script> 
  <script type="text/javascript">if(isLessIE6)DD_belatedPNG.fix('*');</script> 
  <div id="shuaxin" name="shuaxin" style="display:none;"><?=$shuaxin?></div>
  <div class="main" id="div_ord_main">
  	<?php if (isset($_SESSION['uid']) && isset($_SESSION['username'])){?> 	  
  	<div id="userinfo" style="display:none;"> 
		  <table width="100%" border="0" cellspacing="0" cellpadding="5" style="margin-bottom:5px;"> 
			  <tr> 
				  <td bgcolor="#FFFFFF">会员账号：<?=$_SESSION['username'];?></td> 
			  </tr> 
			  <tr> 
				  <td bgcolor="#FFFFFF">账户余额：<span class="tou_h" id="user_money">0.00</span></td> 
			  </tr> 
			  <tr> 
				  <td bgcolor="#FFFFFF">投注额度：<span class="tou_h" id="tz_money">0</span></td> 
			  </tr> 
			  <tr> 
				  <td bgcolor="#FFFFFF">站内消息：<a href="javascript:void(0);" onclick="urlOnclick('user/sys_msg.php?1=1')"><span id="user_num">0</span></a></td> 
			  </tr> 
		  </table> 
	  </div>
	  <?php }?>
	  <div class="ord_memu">
    	<span id="title_menu" onclick="showMenu('menu')" class="ord_memuBTN_on">目录</span>
    	<span id="title_betslip" onclick="showMenu('betslip')" class="ord_memuBTN">交易单</span>
    	<span id="title_mybets" onclick="showMenu('mybets')" class="ord_memuBTN no_margin">我的注单<span id="count_mybet" class="ord_msg" style="display: none;">0</span></span>
      </div>
      <!--下注过关数-->
      <div id="show_parlay" class="ord_parlyG noFloat" onclick="showMenu('betslip')" style="display:none;">
	     <ul><li>过关串数</li></ul>
	     <span id="cg_num" class="ord_parlyNUM"></span>
	  </div>

      <div id="div_menu" name="div_menu" class="ord_DIV">
	 	  <div id="euro_open"  class="ord_sportMenu_InPlayG">
		        <h1>滚球中</h1>
				<div id="div_rb" class="ord_sportMenu_InPlay" style="display:none;">
		        	<div id="FT_div_rb" style="display:none;" class="ord_sportFT_nor_off noFloat"  onclick="Go_RB_page('FT');urlOnclick('show/ft_gunqiu.html');"><span class="ord_sportName">足球</span><span id="RB_FT_games" class="ord_sportDigit"></span></div>
		            <div id="BK_div_rb" style="display:none;" class="ord_sportBK_nor_off noFloat" onclick="Go_RB_page('BK');urlOnclick('show/bk_gunqiu.html');"><span class="ord_sportName">篮球 &amp; 美式足球</span><span id="RB_BK_games" class="ord_sportDigit"></span></div>
		            <div id="TN_div_rb" style="display:none;" class="ord_sportTN_nor_off noFloat" onclick="Go_RB_page('TN');urlOnclick('show/tn_gunqiu.html');""><span class="ord_sportName">网球</span><span id="RB_TN_games" class="ord_sportDigit"></span></div>
		            <div id="VB_div_rb" style="display:none;" class="ord_sportVB_nor_off noFloat" onclick="Go_RB_page('VB');urlOnclick('show/vb_gunqiu.html');""><span class="ord_sportName">排球</span><span id="RB_VB_games" class="ord_sportDigit"></span></div>
					<div id="BM_div_rb" style="display:none;" class="ord_sportBM_nor_off noFloat" onclick="Go_RB_page('BM');urlOnclick('show/bm_gunqiu.html');""><span class="ord_sportName">羽毛球</span><span id="RB_BM_games" class="ord_sportDigit"></span></div>
		            <div id="TT_div_rb" style="display:none;" class="ord_sportTT_nor_off noFloat" onclick="Go_RB_page('TT');urlOnclick('show/tt_gunqiu.html');""><span class="ord_sportName">乒乓球</span><span id="RB_TT_games" class="ord_sportDigit"></span></div>
		            <div id="BS_div_rb" style="display:none;" class="ord_sportBS_nor_off noFloat" onclick="Go_RB_page('BS');urlOnclick('show/bs_gunqiu.html');""><span class="ord_sportName">棒球</span><span id="RB_BS_games" class="ord_sportDigit"></span></div>
		            <div id="SK_div_rb" style="display:none;" class="ord_sportSK_nor_off noFloat" onclick="Go_RB_page('SK');urlOnclick('show/sk_gunqiu.html');""><span class="ord_sportName">斯诺克/台球</span><span id="RB_SK_games" class="ord_sportDigit"></span></div>
		          <div id="OP_div_rb" style="display:none;" class="ord_sportOT_nor_off noFloat" onclick="Go_RB_page('OP');urlOnclick('show/op_gunqiu.html');""><span class="ord_sportName">其他</span><span id="RB_OP_games" class="ord_sportDigit"></span></div> 
		          	
		        </div>
		        <div id="RB_nodata" style="display:none;" class="ord_noInPlay">现在没有进行的赛事</div><!--没赛-->
		     
		  </div>

		  <div class="ord_sportMenu_TodayG">
	        <h1>体育
	        	<span onclick="urlrule()" style="padding-left:20px; font-size:12px;color:#FFD796;font-weight:100;">游戏规则</span>
	        	<span onclick="urlOnclick('result/bet_match.php')" style="padding-left:20px; font-size:12px;color:#FFD796;font-weight:100;">赛果</span>
	        </h1> 
	        <div class="ord_memu2">
	        		<span id="title_today" onclick="chgShowType('today');" class="ord_memuBTN">今日</span>
	        		<span id="title_early" onclick="chgShowType('early');" class="ord_memuBTN">早盘</span>
	        		<span id="title_parlay" onclick="chgShowType('parlay');" class="ord_memuBTN no_margin">综合过关</span></div>
	        <div id="sportMenu_Today" class="ord_sportMenu_Today">
	        	<div id="title_FT" style="" onclick="chgTitle('FT');" class="ord_sportFT_off noFloat"><span class="ord_sportName">足球</span><span id="FT_games" class="ord_sportDigit"></span></div>
				<ul id="wager_FT" select="wtype_FT_r" style="display: none;">
	            	<li id="wtype_FT_r" class="On" onclick="chgWtype(this.id);chg_type(this.id,'');">独赢 &amp; 让球 &amp; 大小</li>
	                <li id="wtype_FT_pd" onclick="chgWtype(this.id);chg_type(this.id,parent.FT_lid_type);">波胆</li>
	                <li id="wtype_FT_t" onclick="chgWtype(this.id);chg_type(this.id,parent.FT_lid_type);">总入球</li>
	                <li id="wtype_FT_f" onclick="chgWtype(this.id);chg_type(this.id,parent.FT_lid_type);">半场 / 全场</li>
	                <!--li id="wtype_FT_fs" onclick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">冠军</li-->

	            </ul>

	            <div id="title_BK" style="" onclick="chgTitle('BK');" class="ord_sportBK_off noFloat"><span class="ord_sportName">篮球 &amp; 美式足球</span><span id="BK_games" class="ord_sportDigit"></span></div>
	            <ul id="wager_BK" select="wtype_BK_r" style="display:none">
	            	<li id="wtype_BK_r" class="On" onclick="chgWtype(this.id);chg_type(this.id,parent.BK_lid_type);">赛事</li>
	                <!--li id="wtype_BK_fs" onclick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">冠军</li-->
	            </ul>



	            <div id="title_TN" style="" onclick="chgTitle('TN');" class="ord_sportTN_off noFloat"><span class="ord_sportName">网球</span><span id="TN_games" class="ord_sportDigit"></span></div>
	            <ul id="wager_TN" select="wtype_TN_r" style="display:none">
	            		<li id="wtype_TN_r" class="On" onclick="chgWtype(this.id);chg_type(this.id,'');">赛事</li>
	                <li id="wtype_TN_pd35" onclick="chgWtype(this.id);chg_type(this.id,parent.TN_lid_type);">波胆</li>
	                <!--li id="wtype_TN_fs" onclick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">冠军</li-->
	            </ul>



	            <div id="title_VB" style="" onclick="chgTitle('VB');" class="ord_sportVB_off noFloat"><span class="ord_sportName">排球</span><span id="VB_games" class="ord_sportDigit"></span></div>
	            <ul id="wager_VB" select="wtype_VB_r" style="display:none">
	            	<li id="wtype_VB_r" class="On" onclick="chgWtype(this.id);chg_type(this.id,'');">赛事</li>
	                <li id="wtype_VB_pd35" onclick="chgWtype(this.id);chg_type(this.id,parent.VB_lid_type);">波胆</li>
	                <!--li id="wtype_VB_fs" onclick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">冠军</li-->
	            </ul>


	            <div id="title_BM" style="" onclick="chgTitle('BM');" class="ord_sportBM_off noFloat"><span class="ord_sportName">羽毛球</span><span id="BM_games" class="ord_sportDigit"></span></div>
	            <ul id="wager_BM" select="wtype_BM_r" style="display:none">
	            		<li id="wtype_BM_r" class="On" onclick="chgWtype(this.id);chg_type(this.id,'');">赛事</li>
	                <li id="wtype_BM_pd35" onclick="chgWtype(this.id);chg_type(this.id,parent.BM_lid_type);">波胆</li>
	                <!--li id="wtype_BM_fs" onclick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">冠军</li-->
	            </ul>


	            <div id="title_TT" style="display:none;" onclick="chgTitle('TT');" class="ord_sportTT_off noFloat"><span class="ord_sportName">乒乓球</span><span id="TT_games" class="ord_sportDigit"></span></div>
	            <ul id="wager_TT" select="wtype_TT_r" style="display:none">
	            		<li id="wtype_TT_r" class="On" onclick="chgWtype(this.id);chg_type(this.id,'');">赛事</li>
	                <li id="wtype_TT_pd57" onclick="chgWtype(this.id);chg_type(this.id,parent.TT_lid_type);">波胆</li>
	                <!--li id="wtype_TT_fs" onclick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">冠军</li-->
	            </ul>


	            <div id="title_BS" style="display:none;" onclick="chgTitle('BS');" class="ord_sportBS_off noFloat"><span class="ord_sportName">棒球</span><span id="BS_games" class="ord_sportDigit"></span></div>
	            <ul id="wager_BS" select="wtype_BS_r" style="display:none">
	            	<li id="wtype_BS_r" class="On" onclick="chgWtype(this.id);chg_type(this.id,parent.BS_lid_type);">赛事</li>
	                <!--li id="wtype_BS_fs" onclick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">冠军</li-->
	            </ul>
	            
	            <div id="title_SK" style="" onclick="chgTitle('SK');" class="ord_sportSK_off noFloat"><span class="ord_sportName">斯诺克/台球</span><span id="SK_games" class="ord_sportDigit"></span></div>
	   			<ul id="wager_SK" select="wtype_SK_r" style="display:none">
	            	<li id="wtype_SK_r" class="On" onclick="chgWtype(this.id);chg_type(this.id,parent.SK_lid_type);">赛事</li>
	                <!--li id="wtype_SK_fs" onclick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">冠军</li-->
	            </ul>

	            <div id="title_OP" style="" onclick="chgTitle('OP');" class="ord_sportOT_off noFloat"><span class="ord_sportName">其他</span><span id="OP_games" class="ord_sportDigit"></span></div>
	   			<ul id="wager_OP" select="wtype_OP_r" style="display:none">
	            	<li id="wtype_OP_r" class="On" onclick="chgWtype(this.id);chg_type(this.id,parent.OP_lid_type);">赛事</li>
	                <!--li id="wtype_OP_fs" onclick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin">冠军</li-->
	            </ul>

	        </div>
	        
	        <div id="FT_today_nodata" style="display:none;" class="ord_noInSports">今天没有赛事</div><!--没赛-->
	        <div id="FT_early_nodata" style="display:none;" class="ord_noInSports">没有可供早盘的赛事</div><!--没赛-->
	        <div id="FT_parlay_nodata" style="display:none;" class="ord_noInSports">没有综合过关</div><!--没赛-->
	      
	      </div>
	  </div>
	  <div id="div_betslip" name="div_bet" class="ord_DIV" style="display:none;">
    		<!--没单文字-->
            <h1 id="SIN_BET" style="display: none;">单一投注</h1>
            <h1 id="PAR_BET" style="display:none">综合过关</h1>
    		<div id="bet_nodata" class="ord_noOrder" style="display: none;">请把选项加入在您的注单。</div>

    		<div class="ord_returnBTN" onclick="showMenu('menu')" id='pr_menu' style="display:none;">返回体育项目</div> 

			<div id="xp" style="display:none;"> 
		<?php 
		include_once 'cache/group_' . @($_SESSION['gid']) . '.php';
		$ty_zd = @($pk_db['体育最低']);
		if (0 < $ty_zd){
			$ty_zd = $ty_zd;
		}else{
			$ty_zd = 10;
		}
		?> 	
	    	<!--普通注单--><!--比分改变时ord_betArea_C-->
	    	<form action="bet.php" name="form1"  id="form1" method="post" style="margin:0 0 0 0;"> 
	    		<input type="hidden" name="touzhutype" id="touzhutype" value='0'>
		    	<div id="touzhudiv" class="ord_betArea"></div>

		    	<!--过关没满3串时候显示-->
		        <div class="ord_betFuntion_on" id="gold_show_cancle" style="display: none;">
			    	<div class="ord_TotalAreaG">
			    		<span id="btnCancel_cancle" name="btnCancel" class="ord_cancalBTN" onclick="quxiao_bet();">取消</span>
			    	</div>
			    	<div class="ord_AutoOddG noFloat"><input id="autoOdd" name="autoOdd"  value="Y" class="ord_checkBox" type="checkbox" checked="checked" ><span>自动接受较佳赔率</span></div>
			    </div>
		        <!--注单功能区-->
		        <div class="ord_betFuntion" id="gold_show" style="display: none;">
			    	<!--手动输入数字-->
			    	<div class="ord_enterNUMG">
			        	<div class="ord_NUM noFloat">
				        	<input type="text" class="tou_input" name="bet_money" placeholder="投注额"  id="bet_money" autocomplete="off" maxlength="10" onkeypress="if((event.keyCode<48 || event.keyCode>57))event.returnValue=false"  onkeydown="if(event.keyCode==13)return check_bet();" onpaste="return false" oncontextmenu="return false" oncopy="return false" oncut="return false" size="8"/>
				        	<span class="ord_delBTN" id="order_delBTN"></span>
			            	<div class="ord_Mask" style="display:none"></div><!--不能下注遮罩-->
			            </div>
			            <div class="ord_SUM">
			            	<span class="ord_SUM_L">可赢金额:</span><span id="win_span" class="ord_SUM_R">0.00</span>
			            	<input type="hidden" value="0" name="bet_win" id="bet_win"  />
			            </div>
			            
			        </div>
			        
			    	<!--按钮输入数字-->
			    	<div class="ord_enterBTNG noFloat">
			        	<span id="moenyBTN_01" onclick="bt_moeny(100);" class="">100</span><span id="moenyBTN_02" onclick="bt_moeny(200);"  class="">200</span><span id="moenyBTN_03" onclick="bt_moeny(500);"  class="">500</span><span id="moenyBTN_04" onclick="bt_moeny(1000);"  class="">1,000</span><span id="moenyBTN_05" class="" onclick="bt_moeny(2500);" >2,500</span><span id="moenyBTN_06" onclick="bt_moeny(5000);"  class="">5,000</span>
			        </div>
			        
			        <!--错误警告-->
			        <div id="ord_warn" class="ord_warnG" style="display: none;"><span class="day_text"></span></div>
			        
			        <!--确定下注区-->
			        <div class="ord_TotalAreaG" >
			        	<span id="submitid" class="ord_betBTN" onclick="ok_bet();">确定交易</span><!--字数两行ord_betBTN02  不能按ord_betBTN_off-->
			            <span id="btnCancel" name="btnCancel" class="ord_cancalBTN" onclick="quxiao_bet();">取消</span>
			            
			            <table cellspacing="0" cellpadding="0" class="ord_TotalTXT">
			              <tbody><tr>
			                <td width="40%">单注最低:</td>
			                <td width="60%" class="Word_Toright" id="min_ty"><?=number_format($ty_zd);?></td>
			              </tr>
			              <tr>
			                <td>单注最高:</td>
			                <td class="Word_Toright" id="max_ds_point_span"></td>
			              </tr>
			              <tr>
			                <td>单场最高:</td>
			                <td class="Word_Toright" id="max_cg_point_span"></td>
			              </tr>
			            </tbody></table>
			        </div>
			        <!--自动接受更好赔率-->        
			        <div class="ord_AutoOddG noFloat"><input id="autoOdd" name="autoOdd"  value="Y" class="ord_checkBox" type="checkbox" checked="checked" ><span>自动接受较佳赔率</span></div>
			    </div>
			    
			    <!--交易遮罩-->
			    <div id="confirm_div" class="ord_DIV_Mask" style="display:none" onkeypress="SumbitCheckKey(event)" tabindex="1">
			    	<!--交易确认单-->
			    	<div id="ord_conf" class="ord_confirmation" >
				        <h1>投注确认</h1>
				        <ul>
				        	<li>交易金额: <tt id="confirm_gold" class="dark_BrownWord"></tt></li>
				        	<li>可赢金额: <tt id="confirm_wingold" class="GreenWord"></tt></li>
				            <li id="confirm_msg">确定进行下注吗?</li>
				        </ul>
				        <div class="ord_miniBTNG">
					        <span id="confirm_bet" class="ord_betBTN">确定下注</span>
					        <span id="confirm_cancel"  class="ord_cancalBTN">取消</span>
				        </div>
			        </div>
			        
			    </div>
			</form>
	  	</div> 
      	
    		
      </div>

	  <div id="div_mybets" name="div_mybets" class="ord_mainHight" style="display:none;">
      	<iframe id="rec_frame" name="rec_frame" scrolling="no" frameborder="NO" border="0" width="200"  allowtransparency="true"></iframe>
      </div>
	  
	  
  </div> 
  <script type="text/javascript" language="javascript" src="js/left.js"></script> 
  <script type="text/javascript" language="javascript" src="skin/js2/jquery.js"></script> 
  <script type="text/javascript" language="javascript" src="js/touzhu.js"></script> 
 
  <script language="javascript"> 
	  function ResumeError() { 
		  return true;
	  } 
	  window.onerror = ResumeError;	
  </script> 
  </body> 
  </html>