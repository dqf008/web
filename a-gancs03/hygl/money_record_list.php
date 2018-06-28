<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('hygl');
include_once '../../include/newPage.php';
include_once '../../class/user.php';
$params = array();

$type = $_GET['type'];
$uid  = $_GET['uid'];
$order = '';
$s_type = 0;
if($type =='hk'){
   $sql = " select m.id as m_id,m.uid,m.date as m_make_time ,m.money as m_value,m.manner as about,m.status, m.lsh as m_order,m.assets,m.balance,u.username from huikuan m left join k_user u on m.uid = u.uid where m.uid = {$uid} and m.status=1 ";
   $order = ' m.id';
}else{

	if($type == 'cz'){
         $s_type = 1;
	}else if($type == 'tx'){
         $s_type = 2;
	}else if($type == 'rg'){
      $s_type = 3;
  }
   $sql = " select m.*,u.username from k_money m left join k_user u on m.uid = u.uid where m.uid = {$uid} and m.type = {$s_type} and m.status=1 ";
   $order = ' m.m_id';
}

$desc = ' order by ' . $order . ' desc';


$stmt = $mydata1_db->prepare($sql . $desc);
$stmt->execute($params);
$sum = $stmt->rowCount();
$thisPage = 1;

if ($_GET['page']){
	$thisPage = $_GET['page'];
}
$page = new newPage();
$thisPage = $page->check_Page($thisPage, $sum, 20, 40);
$uid = '';
$i = 1;
$start = (($thisPage - 1) * 20) + 1;
$end = $thisPage * 20;
/*while ($row = $stmt->fetch()){
	print_r($row);
}*/
?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>用户充值\体现\汇款记录</TITLE> 
<link rel="stylesheet" href="Images/CssAdmin.css"> 

<style type="text/css"> 
.STYLE2 {font-size: 12px} 
body { 
  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
} 
td{font:13px/120% "宋体";padding:3px;} 
a{ 

  color:#F37605;

  text-decoration: none;

} 
.t-title{background:url(../images/06.gif);height:24px;} 
.t-tilte td{font-weight:800;} 
.STYLE4 { 
  color: #FF0000;
  font-size: 12px;
} 
</STYLE> 
</HEAD> 
<script type="text/javascript" src="../../skin/js/jquery-1.7.2.min.js"></script>

<script language="javascript">
	
</script>


<body> 
<style> 
  .black_overlay{  display: none;  position:fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: black;  z-index:1001;  -moz-opacity: 0.4;  opacity:.40;  filter: alpha(opacity=40);  }  
  .white_content {  display: none;  position:fixed;  top: 25%;  left: 15%;  width: 680px;  height: 360px;    border: 8px solid #400000;  background-color: white;  z-index:1002;  overflow: auto;  }  
  .font12 td{ height:24px; line-height:24px;}
</style> 
  <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><font >&nbsp;<span class="STYLE2">用户管理：查看用户的充值/提现/汇款记录</span></font></td> 
</tr> 
  <tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="455"> 
   <!-- <form name="form1" method="GET" action="list.php" > 
   	<tr> 
   	  <td>内容： 
   		<input type="text" name="likevalue" value="<?=$_GET['likevalue']?>"/> 
   		  &nbsp;&nbsp;类型： 
   		  <select name="selecttype" id="selecttype"> 
   			<option value="username" <?php if($_GET["selecttype"]=='username') {?> selected <?php }?> >用户名</option>
            <option value="pay_name" <?php if($_GET["selecttype"]=='pay_name') {?> selected <?php }?> >真实姓名</option>
            <option value="reg_ip" <?php if($_GET["selecttype"]=='reg_ip') {?> selected <?php }?>>注册IP</option>
            <option value="login_ip" <?php if($_GET["selecttype"]=='login_ip') {?> selected <?php }?>>登录ip</option>
            <option value="name" <?php if($_GET["selecttype"]=='name') {?> selected <?php }?>>会员组</option>
            <option value="reg_address" <?php if($_GET["selecttype"]=='reg_address') {?> selected <?php }?>>省份</option>
            <option value="mobile" <?php if($_GET["selecttype"]=='mobile') {?> selected <?php }?>>手机号码</option>
   		  </select> 
   		  &nbsp;
   		<input type="submit" value="查找"/> 
   	  </td> 
   	  </tr>   </form>  -->
  </table></td> 
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"> 
   
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" >       
	 <tr style="background-color: #EFE" class="t-title"  align="center"> 
	  <td width="6%" ><strong>ID</strong></td> 
      <td width="8%" ><strong>用户名</strong></td> 
	  <td width="8%" ><strong>金额</strong></td> 
	  <td width="8%" ><strong>原金额</strong></td> 
	  <td width="6%" ><strong>操作后金额</strong></td>
	  <td width="7%" ><strong>订单号</strong></td>
	  <td width="6%" ><strong>类型</strong></td> 
	  <td width="8%" ><strong>时间</strong></td> 
	  <td width="6%" ><strong>状态</strong></td> 
	  <td width="8%" ><strong>说明</strong></td> 
	</tr>
	  <?php 

           while ($row = $stmt->fetch()){
    
	  ?>
	
			<tr align="center" > 
              <td><?=$row['m_id']?></td>
			  <td><a href="user_show.php?id=<?=$row['uid']?>"><?=$row['username']?></a></td> 
			  <td><?=$row['m_value']?></td> 
			  <td><?=$row['assets']?></td> 
			  <td><?=$row['balance']?></td>
			  <td><?=$row['m_order']?></td>
			  <td><?php 
			  if($_GET['type'] =='hk'){
                   echo "汇款";
			  }else{
			      if($row['type'] == 1){echo '充值';}else if($row['type'] == 2){ echo '提现';} 
               }
			  ?>
			  </td>
			  <td><?=$row['m_make_time']?></td>
			  <td>
			  <?php 
               if($_GET['type'] == 'hk'){
                     if($row['status'] == 1){echo '成功';}else if($row['status'] == 2){ echo '失败';}else{echo '审核';}
               }else{
                	 if($row['status'] == 0){ echo '失败';}else{echo '成功';}
               }
               ?>
			  </td> 
			  <td><?=$row['about']?></td> 
		    </tr>
	<?php }?>	
    </table> 
  </td> 
</tr> 
<tr><td ><div style="float:left;"><?=$page->get_htmlPage($_SERVER["REQUEST_URI"]);?></div></td></tr> 
</table> 
</form> 
</body> 
</html>