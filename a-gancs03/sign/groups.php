<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian("xtgl");

$wl = dirname(__FILE__)."/../../";

$sql = 'SELECT `sign` FROM `k_user_sign` WHERE `uid`=0 AND `id`=1 LIMIT 1';
$query = $mydata1_db->query($sql);
if($query->rowCount()>0){
    $rows = $query->fetch();
    $sign_config = unserialize($rows['sign']);
}else{
    $sign_config = array(
        'open' => 0,
        'type' => 0,
        'limit' => array(0, 0, array()),
        'member' => array(),
        'type0' => array('random' => 0),
        'type1' => array(),
        'groups' => array(),
    );
}

$_groups = array();
$sql = 'SELECT `id`, `name` FROM `k_group`';
$query = $mydata1_db->query($sql);
if($query->rowCount()>0){
    while($rows = $query->fetch()){
        $_groups[$rows['id']] = $rows['name'];
        $_gid = $_gid<=0?$rows['id']:$_gid;
    }
}else{
    message('请先添加会员组！');
}

if(isset($_POST["action"])&&$_POST["action"]=="save"){
    (!isset($_POST['gid'])||!isset($_groups[$_POST['gid']]))&&message('用户组不存在！');
    $sign_groups = array();
    $sign_groups['default'] = $_POST['sign']['default']=='0'?0:1;
    $sign_groups['member'] = $sign_config['member'];
    $sign_groups['member']['open'] = $_POST['sign']['member']['open']=='1'?1:0;
    $sign_groups['member']['limit'] = intval($_POST['sign']['member']['limit'])>0?intval($_POST['sign']['member']['limit']):0;
    $sign_groups['member']['reg'] = intval($_POST['sign']['member']['reg'])>0?intval($_POST['sign']['member']['reg']):0;
    $sign_groups['type0'] = array('random' => 0);
    if(is_array($_POST['sign']['type0'])){
        foreach($_POST['sign']['type0'] as $val){
            /* 判断数据源是否符合规则 */
            if(is_array($val)&&count($val)==4){
                $val[0] = intval($val[0]);
                $val[1] = intval($val[1]);
                $val[2] = intval($val[2]);
                if($val[0]>=0&&$val[1]>=0&&$val[2]>=0){
                    $sign_groups['type0'][] = array(
                        'min' => $val[0],
                        'max' => $val[1],
                        'random' => $val[2],
                        'tips' => $val[3],
                    );
                    $sign_groups['type0']['random']+= $val[2];
                }
            }
        }
    }
    $sign_groups['type1'] = array();
    if(is_array($_POST['sign']['type1'])){
        foreach($_POST['sign']['type1'] as $val){
            /* 判断数据源是否符合规则 */
            if(is_array($val)&&count($val)==2){
                $val[0] = intval($val[0]);
                $val[1] = intval($val[1]);
                if($val[0]>=0&&$val[1]>=0){
                    $sign_groups['type1'][] = array(
                        'day' => $val[0],
                        'money' => $val[1],
                    );
                }
            }
        }
    }
    $sign_config['groups'][$_POST['gid']] = $sign_groups;
    $sign_config['time'] = time();
    $sign_config = serialize($sign_config);
    $sql = 'UPDATE `k_user_sign` SET `sign`=\''.$sign_config.'\', `temp`=\'\' WHERE `uid`=0 AND `id`=1';
    $query = $mydata1_db->query($sql);
    if($query->rowCount()>0){
        include_once('../../class/admin.php');
        admin::insert_log($_SESSION['adminid'], '修改了签到配置');

        //写缓存
        $str = "<?php\r\n";
        $str.= "unset(\$sign_config);\r\n";
        $str.= "\$sign_config = unserialize('$sign_config');";

        if(!write_file($wl.'cache/sign.php', $str)){ //写入缓存失败
            message("缓存文件写入失败！请先设/cache/sign.php文件权限为：0777");
        }
        message('签到系统设置成功！');
    }
}

$_gid = isset($_GET['gid'])&&isset($_groups[$_GET['gid']])?$_GET['gid']:key($_groups);
if(isset($sign_config['groups'])&&isset($sign_config['groups'][$_gid])){
    !isset($sign_config['groups'][$_gid]['member'])&&$sign_config['groups'][$_gid]['member'] = $sign_config['member'];
    !isset($sign_config['groups'][$_gid]['type0'])&&$sign_config['groups'][$_gid]['type0'] = $sign_config['type0'];
    !isset($sign_config['groups'][$_gid]['type1'])&&$sign_config['groups'][$_gid]['type1'] = $sign_config['type1'];
    $sign_config = $sign_config['groups'][$_gid];
}else{
    $sign_config = array(
        'default' => 1,
        'member' => $sign_config['member'],
        'type0' => $sign_config['type0'],
        'type1' => $sign_config['type1'],
    );
}
?>
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type"  CONTENT="text/html; charset=utf-8" /> 
<TITLE>签到系统设置</TITLE> 
<link rel="stylesheet" href="../Images/CssAdmin.css">
<style type="text/css"> 
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-size: 12px;
}
</style> 
<script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script>
</HEAD> 
 
<body>
<form action="groups.php" method="POST">
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
  <tr> 
    <td height="24" nowrap background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle">&nbsp;签到系统</td> 
  </tr> 
  <tr> 
    <td height="24" align="center" nowrap bgcolor="#FFFFFF">
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
  <input type="hidden" name="action" value="save" />
  <tr> 
    <td height="24" nowrap bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" id=editProduct idth="100%"> 
      <tr> 
        <td height="30" align="right"></td> 
        <td><a href="index.php">&laquo; 返回全局设置</a></td> 
      </tr> 
      <tr> 
        <td height="30" align="right">会员组：</td> 
        <td><select name="gid" onchange="window.location.href='?gid='+this.value"><?php foreach($_groups as $key=>$val){ ?><option value ="<?php echo $key.($_gid==$key?'" selected="true':''); ?>"><?php echo $val; ?></option><?php } ?></select></td> 
      </tr> 
      <tr> 
        <td height="30" align="right">分组设置：</td> 
        <td><input type="radio" name="sign[default]" value="1"<?php echo $sign_config['default']?' checked="true"':''; ?>>默认设置&nbsp;&nbsp;<input type="radio" name="sign[default]" value="0"<?php echo $sign_config['default']?'':' checked="true"'; ?>>独立设置&nbsp;</td> 
      </tr> 
      <tr> 
        <td height="30" align="right">会员限制：</td> 
        <td><input type="radio" name="sign[member][open]" value="0"<?php echo $sign_config['member']['open']?'':' checked="true"'; ?>>全组开放&nbsp;&nbsp;<input type="radio" name="sign[member][open]" value="1"<?php echo $sign_config['member']['open']?' checked="true"':''; ?>>有效会员&nbsp;提示：已进行有效充值或汇款的会员为[有效会员]</td> 
      </tr> 
      <tr> 
        <td height="30" align="right">有效额度：</td> 
        <td><input name="sign[member][limit]" type="text" class="textfield" value="<?php echo $sign_config['member']['limit']; ?>" size="15" />&nbsp;提示：[有效会员]达到指定额度才可以使用签到，0 为不限制，单位：分</td> 
      </tr> 
      <tr> 
        <td height="30" align="right">免费签到：</td> 
        <td><input name="sign[member][reg]" type="text" class="textfield" value="<?php echo $sign_config['member']['reg']; ?>" size="15" />&nbsp;提示：[有效会员]注册当天起指定天数内无需达到[有效额度]即可使用签到，0 为关闭，单位：天</td> 
      </tr> 
      <tr>
        <td height="30" align="right">常规模式奖励规则：</td>
        <td><a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_01.gif) no-repeat left center;" onclick="$('#addType0').clone(true).show().appendTo('#type0List').find('input').attr('name', 'sign[type0][a'+$('#addType0').data('id')+'][]');$('#addType0').data('id', $('#addType0').data('id')+1);">添加</a>&nbsp;提示：概率基数越大出现概率越高，单位：分</td>
      </tr>
      <tr>
        <td align="right"></td>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="type0List">
              <tr id="addType0" style="display:none" data-id="0">
                <td height="30" align="left">
                    最小奖励：<input type="text" class="textfield" size="4" />&nbsp;最大奖励：<input type="text" class="textfield" size="4" />&nbsp;概率基数：<input type="text" class="textfield" size="4" />&nbsp;签到提示：<input type="text" class="textfield" size="15" />&nbsp;<a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_02.gif) no-repeat left center;" onclick="$(this).parent().remove()">删除</a>
                </td>
              </tr<?php foreach($sign_config['type0'] as $key=>$val){if(is_array($val)){ ?>>
              <tr>
                <td height="30" align="left">
                    最小奖励：<input type="text" class="textfield" value="<?php echo $val['min']; ?>" size="4" name="sign[type0][<?php echo $key; ?>][]" />&nbsp;最大奖励：<input type="text" class="textfield" value="<?php echo $val['max']; ?>" size="4" name="sign[type0][<?php echo $key; ?>][]" />&nbsp;概率基数：<input type="text" class="textfield" value="<?php echo $val['random']; ?>" size="4" name="sign[type0][<?php echo $key; ?>][]" />&nbsp;签到提示：<input type="text" class="textfield" value="<?php echo $val['tips']; ?>" size="15" name="sign[type0][<?php echo $key; ?>][]" />&nbsp;<a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_02.gif) no-repeat left center;" onclick="$(this).parent().remove()">删除</a>
                </td>
              </tr<?php }} ?>>
            </table>
        </td>
      </tr>
      <tr>
        <td height="30" align="right">连续模式奖励规则：</td>
        <td><a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_01.gif) no-repeat left center;" onclick="$('#addType1').clone(true).show().appendTo('#type1List').find('input').attr('name', 'sign[type1][a'+$('#addType1').data('id')+'][]');$('#addType1').data('id', $('#addType1').data('id')+1);">添加</a>&nbsp;单位：分</td>
      </tr>
      <tr>
        <td align="right"></td>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="type1List">
              <tr id="addType1" style="display:none" data-id="0">
                <td height="30" align="left">
                    天数：<input type="text" class="textfield" size="4" />&nbsp;奖励：<input type="text" class="textfield" size="4" />&nbsp;<a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_02.gif) no-repeat left center;" onclick="$(this).parent().remove()">删除</a>
                </td>
              </tr<?php foreach($sign_config['type1'] as $key=>$val){if(is_array($val)){ ?>>
              <tr>
                <td height="30" align="left">
                    天数：<input type="text" class="textfield" value="<?php echo $val['day']; ?>" size="4" name="sign[type1][<?php echo $key; ?>][]" />&nbsp;奖励：<input type="text" class="textfield" value="<?php echo $val['money']; ?>" size="4" name="sign[type1][<?php echo $key; ?>][]" />&nbsp;<a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_02.gif) no-repeat left center;" onclick="$(this).parent().remove()">删除</a>
                </td>
              </tr<?php }} ?>>
            </table>
        </td>
      </tr>
      <tr> 
        <td height="30" align="right">&nbsp;</td> 
        <td valign="bottom"><input name="submitSaveEdit" type="submit" class="button"  id="submitSaveEdit" value="保存" style="width: 60;" /></td> 
      </tr> 
      <tr> 
        <td height="20" align="right">&nbsp;</td> 
        <td valign="bottom">&nbsp;</td> 
      </tr> 
    </table></td>
  </tr> 
</table></td> 
  </tr> 
</table> 
</form> 
</body> 
</html> 