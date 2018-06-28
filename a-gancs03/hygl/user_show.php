<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('hygl');
?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>用户详细信息展示</TITLE> 
<script type="text/javascript" src="/skin/js/jquery-1.7.2.min.js"></script>
<style type="text/css"> 
td{font:13px/120% "宋体";padding:3px;} 
a{color:#FFA93E;} 
</style> 
</HEAD> 

<script language="javascript" src="../js/user_show.js"></script> 

<body> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><font >&nbsp;<span class="STYLE2">用户管理：查看用户详细信息</span></font></td> 
</tr> 
<tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><br>
  <?php 
  	$uid = intval($_GET['id']);
	$sql = 'select * from k_user where uid=\'' . $uid . '\' limit 1';
	$query = $mydata1_db->query($sql);
	$rows = $query->fetch();
  ?> 
<form action="user_update.php" method="post" name="form1" id="form1"> 
<table width="90%" align="center" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;"  > 
<tr> 
  <td bgcolor="#F0FFFF">用户名</td> 
  <td>
	  <?=$rows['username']?>      
	  <input name="hf_username" type="hidden" id="hf_username" value="<?=$rows['username']?>">
    <a href="/logincheck.php?uid=<?=$uid?>" target="black">模拟登录</a>
  </td> 
</tr>
<?php 
	if (strpos($_SESSION['quanxian'], 'hymm')){
?>   
<tr> 
  <td bgcolor="#F0FFFF">修改登录密码</td> 
  <td><input name="pass"  > 
  <font color="#FF0000">*不修改请留空</font></td> 
</tr> 
<!--tr> 
  <td bgcolor="#F0FFFF">登陆密码</td> 
  <td><?=$rows['sex']?></td> 
</tr--> 
<tr> 
  <td bgcolor="#F0FFFF">修改取款密码</td> 
  <td><input name="pass1" maxlength="6"/> 
  <font color="#FF0000">*不修改请留空</font> 
  <font color="#0000ff">取款密码只能是6位数字</font></td> 
</tr> 
<!--tr> 
  <td bgcolor="#F0FFFF">取款密码</td> 
  <td><?=$rows['birthday']?></td> 
</tr-->
<?php }?>   
<tr> 
  <td width="172" bgcolor="#F0FFFF">账户余额</td> 
  <td width="473"><?=$rows['money']?></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">注册所在地</td> 
  <td><?=$rows['reg_address']?></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">密码问答</td> 
  <td> 
  <select name="ask" id="ask"> 
		  <option value="" >---请选择密码问题---</option> 
		  <option value="您的车牌号码是多少？" <?php if($rows["ask"] == "您的车牌号码是多少？") echo "selected";?>>您的车牌号码是多少？</option>
          <option value="您初中同桌的名字？" <?php if($rows["ask"] == "您初中同桌的名字？") echo "selected";?>>您初中同桌的名字？</option>
          <option value="您就读的第一所学校的名称？" <?php if($rows["ask"] == "您就读的第一所学校的名称？") echo "selected";?>>您就读的第一所学校的名称？</option>
          <option value="您第一次亲吻的对象是谁？" <?php if($rows["ask"] == "您第一次亲吻的对象是谁？") echo "selected";?>>您第一次亲吻的对象是谁？</option>
          <option value="少年时代心目中的英雄是谁？" <?php if($rows["ask"] == "少年时代心目中的英雄是谁？") echo "selected";?>>少年时代心目中的英雄是谁？</option>
          <option value="您最喜欢的休闲运动是什么？" <?php if($rows["ask"] == "您最喜欢的休闲运动是什么？") echo "selected";?>>您最喜欢的休闲运动是什么？</option>
          <option value="您最喜欢哪支运动队？" <?php if($rows["ask"] == "您最喜欢哪支运动队？") echo "selected";?>>您最喜欢哪支运动队？</option>
          <option value="您最喜欢的运动员是谁？" <?php if($rows["ask"] == "您最喜欢的运动员是谁？") echo "selected";?>>您最喜欢的运动员是谁？</option>
          <option value="您的第一辆车是什么牌子？" <?php if($rows["ask"] == "您的第一辆车是什么牌子？") echo "selected";?>>您的第一辆车是什么牌子？</option>
  </select></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">密码答案</td> 
  <td><input type="text" name="answer" id="answer" value="<?=$rows['answer']?>" ></td> 
</tr>
<?php if (strpos($_SESSION['quanxian'], 'hylx')){?>   
    <?php if(!empty($_SESSION['pass'])){ ?>
      <tr> 
        <td bgcolor="#F0FFFF">手机</td> 
        <td><input type="text" name="mobile" value="<?=$rows['mobile']?>" ></td> 
      </tr> 
      <tr> 
        <td bgcolor="#F0FFFF">邮箱</td> 
        <td><input type="text" name="email" value="<?=$rows['email']?>" ></td> 
      </tr>
      <tr> 
        <td bgcolor="#F0FFFF">微信</td> 
        <td><input type="text" name="weixin" value="<?=$rows['weixin']?>" ></td> 
      </tr>
  <?php }else{ ?>
    <tr> 
        <td bgcolor="#F0FFFF" >手机、邮箱、微信</td><td><button type="button" class="inputPwd">输入二级密码</button></td></tr>
   <?php } 
  }?>   
<tr> 
  <td bgcolor="#F0FFFF">真实姓名</td> 
  <td>
    <?php 
        if($_SESSION['a-gan'] == 1){
          echo '<input type="text" name="pay_name" value="'.$rows['pay_name'].'" >';
        }else{
          echo $rows['pay_name'];
        }
    ?>
  </td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">开户行</td> 
  <td><input type="text" name="pay_card" value="<?=$rows['pay_card']?>" ></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">卡号</td> 
  <td>
    <input type="text" name="pay_num" value="<?=$rows['pay_num']?>" >
    <input name="hf_pay_num" type="hidden" id="hf_pay_num" value="<?=$rows['pay_num']?>">
  </td> 
</tr> 
  <tr> 
  <td bgcolor="#F0FFFF">开户地址</td> 
  <td>
    <input type="text" name="pay_address" value="<?=$rows['pay_address']?>" >
    <input type="hidden" name="uid" id="uid" value="<?=$_GET['id']?>">
  </td> 
</tr> 
  <tr> 
  <td bgcolor="#F0FFFF">所属会员组</td> 
  <td><label> 
	<select name="gid" id="gid">
	<?php 
	$sql = 'select id,name from k_group order by id asc';
	$query = $mydata1_db->query($sql);
	while ($rs = $query->fetch())
	{
	?>         
	<option value="<?=$rs['id']?>" <?=$rs['id']==$rows["gid"] ? 'selected' : ''?>><?=$rs['name']?></option>
	<?php }?>
    </select> 
  </label></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">注册时间</td> 
  <td><?=$rows['reg_date']?></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">注册IP</td> 
  <td><?=$rows['reg_ip']?></td> 
</tr> 
 <tr> 
  <td bgcolor="#F0FFFF">最后登录时间</td> 
  <td><?=$rows['login_time']?></td> 
</tr> 
 <tr> 
  <td bgcolor="#F0FFFF">最后登录IP</td> 
  <td><?=$rows['login_ip']?></td> 
</tr> 
 <tr> 
  <td bgcolor="#F0FFFF">最后退出时间</td> 
  <td><?=$rows['logout_time']?></td> 
</tr> 
 <tr> 
  <td bgcolor="#F0FFFF">总登录次数</td> 
  <td><?=$rows['lognum']?></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">备注：</td> 
  <td><textarea name="why" cols="80" rows="5" id="why"><?=$rows['why']?></textarea></td> 
</tr> 
  <tr> 
  <td bgcolor="#F0FFFF">更多信息</td> 
  <td> 
  <a href="../zdgl/list.php?uid=<?=$rows['uid']?>">查看单式信息</a>， 
  <a href="../zdgl/cg_result.php?uid=<?=$rows['uid']?>">查看串关信息</a>， 
  <A href="../xxgl/sys_msg.php?username=<?=$rows['username']?>">发布短消息</A>， 
  <A href="../cwgl/hccw.php?username=<?=$rows['username']?>">查看财务</A>， 
  <A href="list.php?top_uid=<?=$rows['uid']?>">查看所有下级会员</A>， 
  <A href="../bbgl/report_day.php?username=<?=$rows['username']?>">核查会员</A>， 
  <A href="lsyhxx.php?action=1&username=<?=$rows['username']?>">历史银行记录</A> 
  </td> 
</tr> 
<tr> 
	  <td colspan="2" align="center"><input type="submit" value="确认提交"> 　  
		<input type="button" value="取 消" onClick="javascript:javascript:history.go(-1)"></td> 
</tr> 
</table> 
</form></td> 
</tr> 
</table> 
<script type="text/javascript" src="/skin/layer/layer.js"></script>
<script type="text/javascript">
$(function(){
    $('.inputPwd').click(function(){
        layer.open({
            type: 1,
            id: 'input',
            title: "二级密码确认",
            area: ["400px","150px"],
            shadeClose: true,
            content: '<div style="padding:10px;text-align:center"><input style="border: 1px solid #CCC;height: 30px;font-weight: bold;font-size: 16px;padding-left: 10px;width: 300px" type="password" id="pwd" ></div>',
            btn: ['确认', '取消'],
            success: function(layero, index){
                  $('#pwd').focus();
                  $(document).on('keydown', function(e){  //document为当前元素，限制范围，如果不限制的话会一直有事件
                      if(e.keyCode == 13){
                          $('.layui-layer-btn0').trigger("click");
                      }
                  })
              },
            yes: function (index, layero){
                $.get('list.php?save=true&pwd='+$('#pwd').val(), function(res){
                    if(res == 1){
                        alert('密码错误！！！');
                        $('#pwd').val('');
                        $('#pwd').focus();
                    }else{
                        alert('认证成功');
                        layer.close(index);
                         location.reload();
                    }
                });
            }
        });
    });
})
</script>
</body> 
</html>