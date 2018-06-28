<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include '../../include/pager.class.php';
include 'auto_class.php';

if ($_REQUEST['page'] == ''){
	$_REQUEST['page'] = 1;
}
$class1 = trim($_REQUEST['class1']);

?> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>Welcome</title> 
<link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" /> 
<script language="javascript" src="/js/jquery.js"></script> 
<script language="javascript">
</script> 
</head> 
<body> 
<div id="pageMain"> 
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
  <tr> 
	<td valign="top">
	<form name="form1" onSubmit="" method="post" action="">
		 <!-- </form>
		  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9" style="margin-top:5px;">
		   <form name="form1" method="get" action="">
			  <tr>
			  <td align="center" bgcolor="#FFFFFF">
				  期号
				  <input name="qishu" type="text" id="" value="" size="22" maxlength="20"/>
                  码号
                  <input name="six_num" type="text" id="" value="" size="5" maxlength="5"/>
				  &nbsp;<input type="submit" name="Submit" value="搜索">
              </td>
			  </tr>

           </form>
		  </table> -->
          <h4 style=""><?php echo $class1;?>-<?php echo trim($_REQUEST['six_num']);?>-明细</h4>
		  <table width="100%" border="1"  style="border-color:white; " cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;"  >
		  <tr style="background-color: #FDF4CA;">
            <td align="center"><strong>序号</strong></td>
            <td align="center"><strong>订单号</strong></td>
              <td align="center"><strong>下注时间</strong></td>
			<td align="center"><strong>会员号</strong></td>
			<td align="center"><strong>期号</strong></td>
            <td align="center"><strong>下注码号</strong></td>
			<td align="center"><strong>金额</strong></td>
             <td align="center"><strong>赔率</strong></td>
              <td align="center"><strong>佣金</strong></td>
              <td align="center"><strong>代%</strong></td>
              <td align="center"><strong>总%</strong></td>
              <td align="center"><strong>股%</strong></td>
              <td align="center"><strong>公%</strong></td>
		 </tr>
        <?php
             $params = array();

             $where = " where class1 = '{$class1}' ";
             if($_REQUEST['kithe']){
                  $params[':kithe'] = $_REQUEST['kithe'];
                  $where .= " and kithe = :kithe ";
             }

             if($_REQUEST['six_num']){
                $params[':six_num'] = trim($_REQUEST['six_num']);

                 $where .= " and class3 = :six_num ";
             }
              $sql = 'select * from ka_tan ' . $where . ' order by id desc';
              $stmt = $mydata2_db->prepare($sql);
              $stmt->execute($params);
              $sum = $stmt->rowCount();

              $thisPage = 1;
              $pagenum = 50;
              if ($_GET['page']){
                  $thisPage = $_GET['page'];
              }
              $CurrentPage = (isset($_GET['page']) ? $_GET['page'] : 1);
              $myPage = new pager($sum, intval($CurrentPage), $pagenum);
              $pageStr = $myPage->GetPagerContent();
              $id = '';
              $i = 1;
              $start = (($CurrentPage - 1) * $pagenum) + 1;
              $end = $CurrentPage * $pagenum;
        $params = array(':kithe'=>$_REQUEST['kithe']);
        $class3 = $_REQUEST['six_num'];



        while ($row = $stmt->fetch()){
            if (($start <= $i) && ($i <= $end)){
                $id .= intval($row['id']) . ',';
            }
            if ($end < $i){
                break;
            }


            $i++;
        }
        $total_fee = 0;
        if ($id){
        $id = rtrim($id, ',');
        $sql = 'select * from ka_tan where id in(' . $id . ') order by id desc';
        $query = $mydata2_db->query($sql);
        $time = time();
        $xh = 0;
        while ($rows = $query->fetch()){
             $total_fee += $rows['sum_m'];
              $xh ++;
            $result2 = $mydata2_db->prepare("Select sum(sum_m*dai_zc/10-sum_m*rate*dai_zc/10+sum_m*(dai_ds-user_ds)/100*(10-dai_zc)/10-sum_m*user_ds/100*(dai_zc)/10) as daisf,sum(sum_m*zong_zc/10-sum_m*rate*zong_zc/10+sum_m*(zong_ds-dai_ds)/100*(10-zong_zc-dai_zc)/10-sum_m*dai_ds/100*(zong_zc)/10) as zongsf,sum(sum_m*guan_zc/10-sum_m*rate*guan_zc/10+sum_m*(guan_ds-zong_ds)/100*(10-guan_zc-zong_zc-dai_zc)/10-sum_m*zong_ds/100*(guan_zc)/10) as guansf,sum(sum_m*rate-sum_m+sum_m*Abs(user_ds)/100) as sum_m,sum(sum_m*dagu_zc/10) as dagu_zc,sum(sum_m*guan_zc/10) as guan_zc,sum(sum_m*zong_zc/10) as zong_zc,sum(sum_m*dai_zc/10) as dai_zc,sum(sum_m*Abs(user_ds)/100) as user_ds,sum(sum_m*Abs(guan_ds-zong_ds)/100*(10-guan_zc-zong_zc-dai_zc)/10) as guan_ds,sum(sum_m*Abs(zong_ds-dai_ds)/100*(10-zong_zc-dai_zc)/10) as zong_ds,sum(sum_m*Abs(dai_ds-user_ds)/100*(10-dai_zc)/10) as dai_ds from ka_tan  where kithe=:kithe and   id = {$rows['id']} and bm=1 ");
            $result2->execute($params);
            $Rs6 = $result2->fetch();

            $result3 = $mydata2_db->prepare("Select sum(sum_m*Abs(dai_ds-user_ds)/100*(10-dai_zc)/10+sum_m*dai_zc/10-sum_m*(dai_zc)/10*user_ds/100) as daisf,sum(sum_m*Abs(zong_ds-dai_ds)/100*(10-zong_zc-dai_zc)/10+sum_m*zong_zc/10-sum_m*(zong_zc)/10*dai_ds/100) as zongsf,sum(sum_m*Abs(guan_ds-zong_ds)/100*(10-guan_zc-zong_zc-dai_zc)/10+sum_m*guan_zc/10-sum_m*guan_zc/10*zong_ds/100) as guansf,sum(sum_m*Abs(user_ds)/100-sum_m) as sum_m,sum(sum_m*dagu_zc/10) as dagu_zc,sum(sum_m*guan_zc/10) as guan_zc,sum(sum_m*zong_zc/10) as zong_zc,sum(sum_m*dai_zc/10) as dai_zc,sum(sum_m*Abs(user_ds)/100) as user_ds,sum(sum_m*Abs(guan_ds-zong_ds)/100*(10-guan_zc-zong_zc-dai_zc)/10) as guan_ds,sum(sum_m*Abs(zong_ds-dai_ds)/100*(10-zong_zc-dai_zc)/10) as zong_ds,sum(sum_m*Abs(dai_ds-user_ds)/100*(10-dai_zc)/10) as dai_ds from ka_tan   where kithe=:kithe and id = {$rows['id']} and bm=0 ");
            $result3->execute($params);
            $Rs7 = $result3->fetch();

        ?>
			  <tr align="center" onMouseOver="" onMouseOut="" style="background-color:<?=$color;?>;line-height:20px;">
              <td align="center" valign="middle"><?php echo $xh;?></td>
              <td align="center" valign="middle"><?php echo $rows['num'];?></td>
              <td align="center" valign="middle"><?php echo $rows['adddate'];?></td>
              <td align="center" valign="middle"><?php echo $rows['username'];?></td>
			  <td align="center" valign="middle"><?php echo $rows['kithe'];?></td>
              <td align="center" valign="middle"><?php echo $rows['class3'];?></td>
			  <td align="center" valign="middle"><span <?php if($rows['class2'] =='特B'){ echo "style='color: #e9ba57'";}?>><?php echo $rows['sum_m'];?></span></td>
              <td align="center" valign="middle"><?php echo $rows['rate'];?></td>
                  <td align="center" valign="middle"><?=$Rs6['user_ds'] + $Rs7['user_ds'];?></td>
                  <td align="center" valign="middle"><?php echo $rows['dai_zc'] * 10;?>%</td>
                  <td align="center" valign="middle"><?php echo $rows['zong_zc'] * 10;?>%</td>
                  <td align="center" valign="middle"><?php echo $rows['guan_zc'] * 10;?>%</td>
                  <td align="center" valign="middle"><?php echo $rows['dagu_zc'] * 10;?>%</td>
			  </tr>
             <?php } }?>
              <tr style="background-color:#FFFFFF;">
                  <td  align="center" ></td>
                  <td  align="center" ></td>
                  <td  align="center" ></td>
                  <td  align="center" ></td>
                  <td  align="center" ></td>
                  <td  align="center" >总计：</td>
                  <td  align="center" ><span style="color: #e9ba57"><?php echo $total_fee;?></span></td>
                  <td  align="center" ></td>
                  <td  align="center" ></td>
                  <td  align="center" ></td>
                  <td  align="center" ></td>
                  <td  align="center" ></td>
                  <td  align="center" ></td>
              </tr>
              <tr style="">
                  <td colspan="8" align="center" valign="middle"></td>
                  <?php if($class1 == '特码'){?>
                  <td colspan="5" align="center" valign="middle"><span style="color:#e9ba57; ">提示：淡黄色的是特码B下注金额</span></td>
                  <?php } ?>
              </tr>
              <tr style="background-color:#FFFFFF;">
			  <td colspan="13" align="center" valign="middle"><?=$pageStr;?></td> 
			  </tr> 
		  </table>    
	</td> 
  </tr> 
</table> 
</div> 
</body> 
</html>