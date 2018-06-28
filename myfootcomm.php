 <script language="javascript"> 
	  function trimStr(str){return str.replace(/(^\s*)|(\s*$)/g,"");} 
      function top_money() { 
          $.post("/top_money_data.php",function (data) { 
              var strs = new Array();
              var strs = trimStr(data).split("|");
              $("#user_money").html(strs[0]);
              $("#user_num").html(strs[1]);
              $("#tz_money").html(strs[2]);
              $("#hg_tz_money").html(strs[3]);// 与hg 功能 页面 交集  2015-06-27 
              $("#bb_tz_money").html(strs[4]);// 与hg 功能 页面 交集 
              $("#mg_tz_money").html(strs[5]);// 2015-07-30  MG 
              $("#ds_tz_money").html(strs[6]);// 2015-08-02  DS 
          });
          setTimeout("top_money()",5000);
      } 
  </script> 
  <script type="text/javascript" > 
	  //使用参数：1.标题，2.链接地址，3.内容简介 
	  function PopMessage() { 
		  var msg_num = $("#user_num").html();
		  if (msg_num > 0) { 
			  var pop = new Pop("<?=$_SESSION['username'];?>，您好！", 
				  "", 
				  "您有 <font color='#ff0000'>[" + msg_num + "]</font> 条新消息，请注意查收！");
			  var flashvars = {};
			  var params = {};
			  params.wmode = 'transparent';
			  params.quality = 'high';
			  var attributes = {};
			  swfobject.embedSWF('popmessage/sound.swf', 'hk_mp3', '1', '1', '8.0.35.0', '', flashvars, params, attributes);
			  setTimeout("PopMessage()",300000);
		  }else{ 
			  setTimeout("PopMessage()",2000);
		  } 
	  } 
	  PopMessage();
  </script> 
  <link type="text/css" rel="stylesheet" href="popmessage/pop.css"/> 
  <script type="text/javascript" src="popmessage/yanue.pop.js"></script> 
  <div id="pop" style="display:none;z-index:9999;"> 
	  <div id="popHead"> 
		  <a id="popClose" title="关闭">关闭</a> 
		  <h2>温馨提醒</h2> 
	  </div> 
	  <div id="popContent"> 
		  <dl> 
			  <dt id="popTitle"><a href="javascript:void(0);" onclick="menu_url(9);return false">标题</a></dt> 
			  <dd id="popIntro"><a href="javascript:void(0);" onclick="menu_url(9);return false">内容</a></dd> 
		  </dl> 
		  <p id="popMore"><a href="javascript:void(0);" onclick="menu_url(9);return false">查看 »</a></p> 
	  </div> 
  </div> 
  <div id="hk_mp3" style="width:0px;height:0px;display:none;"></div><?php $wzggrow = get_webinfo_bycode('wzgg');
$wzggtitle = trim($wzggrow['title']);
$wzggmessage = trim($wzggrow['content']);
if ($wzggmessage != '')
{?> <div id="js-notice-pop" style="display:none;"><?=$wzggmessage;?></div> 
  <script src="jquery.plugins/jquery-ui/jquery-ui-1.8.21.custom.min.js"></script> 
  <link href="jquery.plugins/jquery-ui/jquery-ui-1.8.21.custom.css" rel="stylesheet" /> 
  <script> 
      try { 
		  var pdcs = 0;
		  (function(){ 
			  var dk = $(window.parent.document).find("#index").attr("src");
			  if(dk=="myhome.php"){ 
				  '<?php $_SESSION['enter'] = $_SESSION['enter'] + 1;?>';
				  pdcs='<?=$_SESSION['enter'];?>';
			  } 
			  if(window.pdcs==1){ 
			  $('#js-notice-pop').dialog({ 
				  'closeOnEscape': true, 
				  'bgiframe': true, 
				  'width' : 650, 
				  'height' : 520, 
				  'title': '<?=$wzggtitle;?>', 
				  'resizable': true, 
				  'modal': true, 
				  'autoOpen': false, 
				  'buttons' : { 
					  "关闭" : function() { $(this).dialog("close");} 
				  } 
			  });
			  $('#js-notice-pop').dialog('open');
			  } 
		  })();
      } catch(e){} 
  </script><?php }?> <!---- 
  //2015-05-23(功能：提醒用户按时更换密码) 
  ----><?php session_start();
if ($_SESSION['modifyPwdTip'] == 'doit')
{?>     <script type="text/javascript"> 
          alert('尊敬的用户，您好！您已超过<?=$_SESSION['modify_pwd_c'];?>天没有修改登陆密码，为确保您的账户安全,请及时修改！');
          //跳转至 密码修改页面 
         menu_url(10);
      </script><?php }?>