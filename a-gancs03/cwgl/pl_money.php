<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../common/PHPExcel.php';
include_once '../../class/money.php';
include_once '../../class/admin.php';
header('Content-Type:text/html; charset=utf-8');
check_quanxian('jkkk');

$sql = ' select id,name from k_group ';
$group_list = array();
foreach( $mydata1_db->query($sql) as $k => $rows){
   $group_list[$k] = $rows;
}

$op = $_REQUEST['op'];
if($op == 'export'){
    $group_id = $_REQUEST['group_id'];
    $amount   = $_REQUEST['amount'];
    $remark   = $_REQUEST['remark'];
  
    if(empty($group_id)){
        echo "<script>alert('请选择用户组！');window.location.href='pl_money.php';</script>";die;

    }elseif(empty($amount)){
        echo "<script>alert('请输入金额！');window.location.href='pl_money.php';</script>";die;
    }
    elseif(empty($remark)){
        echo "<script>alert('请输入备注！');window.location.href='pl_money.php';</script>";die;
    }
    $sql = ' select uid,username from k_user ';
    $user_list = array();
    foreach( $mydata1_db->query($sql) as $k => $rows){
        $user_list[$k] = $rows;
    }
     ob_end_clean();
    Header('content-Type:application/vnd.ms-excel;charset=utf-8');
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/London');
    $objPHPExcel = new PHPExcel();

    /*以下是一些设置 ，什么作者  标题啊之类的*/
    $objPHPExcel->getProperties()->setCreator("aibo")
        ->setLastModifiedBy("aibo")
        ->setTitle("aibo")
        ->setSubject("aibo")
        ->setDescription("aibo")
        ->setKeywords("excel")
        ->setCategory("result file");

    $objPHPExcel->setActiveSheetIndex(0)//Excel的第A列，uid是你查出数组的键值，下面以此类推
    ->setCellValue('A'.'1', '用户名')
        ->setCellValue('B'.'1', '金额')
        ->setCellValue('C'.'1', '备注');

    /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
    foreach($user_list as $k => $v){

        $num=$k+2;
        $objPHPExcel->setActiveSheetIndex(0)//Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A'.$num, $v['username'])
            ->setCellValue('B'.$num, $amount)
            ->setCellValue('C'.$num, $remark);
    }

    $objPHPExcel->getActiveSheet()->setTitle('User');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: applicationnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.'批量加款扣款Excel'.date('Y-m-d',time()).'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    ob_clean();
    exit;
}elseif($op == 'import'){
    //接收前台文件
    $ex = $_FILES['excel'];
    
    $type = $_REQUEST['type'];
    if(empty($ex)){
        echo "<script>alert('请上传导入excel文件！');window.location.href='pl_money.php';</script>";die;
    }
    $arr = explode('.',$ex['name']);
    if($arr[1] != 'xls'){
        echo "<script>alert('请上传.xls文件！');window.location.href='pl_money.php';</script>";die;
    }
    if(empty($type)){
        echo "<script>alert('请选择派彩类型！');window.location.href='pl_money.php';</script>";die;
    }
    //重设置文件名
    $filename = 'import.xls';
    $path = '../../static/xls/'.$filename;//设置移动路径
    move_uploaded_file($ex['tmp_name'],$path);
    $data =  read($path);

  /*  if($data){
        $mydata1_db->beginTransaction();
        $result = 0;
        foreach($data as $key => $val){
            $sql = " select count(*) from k_user where username = '{$val[0]}' ";
            $sth = $mydata1_db->query($sql);
            $count = $sth->columnCount();
            if($count){
                $amount = intval($val[1]);
                $username = trim($val[0]);
                $sql = " update k_user set money = money + {$amount} WHERE username = '{$username}' ";
                $result = $mydata1_db->exec($sql);
            }
        }
        if($result){
            $mydata1_db->commit();

        }else{
            $mydata1_db->rollBack();
        }
    }*/

}

function read($filename,$encode='utf-8'){
    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load($filename);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $highestRow = $objWorksheet->getHighestRow();
    $highestColumn = $objWorksheet->getHighestColumn();
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $excelData = array();
    for ($row = 2; $row <= $highestRow; $row++) {
    for ($col = 0; $col < $highestColumnIndex; $col++) {
            $excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
        }
    }
    return $excelData;
}

?>
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>批量加款扣款</TITLE>
<style type="text/css"> 
<STYLE> 
BODY { 
SCROLLBAR-FACE-COLOR: rgb(255,204,0);
SCROLLBAR-3DLIGHT-COLOR: rgb(255,207,116);
SCROLLBAR-DARKSHADOW-COLOR: rgb(255,227,163);
SCROLLBAR-BASE-COLOR: rgb(255,217,93) 
} 
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
</STYLE> 
</HEAD> 

<body> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><font >&nbsp;<span class="STYLE2"></span></font></td>
</tr>
<tr>
<span style="color: #ff0000">使用说明：</span><br/>
<span style="font-size: 10">1、方式一导入Excel模板地址：<a href="../../static/xls/example.xls">下载导入Excel模板</a>，请下载模板，按照模板进行填写后放置指定服务器路径；也可以按照用户组进行。</span><br/>
<span style="font-size: 10">2、金额可以填写负数，负数表示扣款；</span><br/>
<span style="font-size: 10">3、用户名、金额、备注信息都是比填；</span>
</tr>


<form method="get" action="<?=$_SERVER['PHP_SELF']?>">
    <tr>
    <td height="24" align="left" nowrap bgcolor="#FFFFFF">导出Excel -->用户组：
        <select name="group_id">
            <option value="">请选择用户组</option>
            <?php if($group_list){  foreach($group_list as $val){ ?>
            <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
            <?php } }?>
        </select>
        &nbsp;金额：<input type="text" value="" name="amount" size="5">
        &nbsp;备注：<input type="text" value="" name="remark">
                   <input type="hidden" value="export" name="op">

        <input name="find" type="submit" id="find" value="提交"/>
    </td>
    </tr>
</form>
    <form method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
    <tr align="left" nowrap bgcolor="#FFFFFF">
        <td>导入Excel -->文件名：<input type="file" name="excel" value="">
        加款类型：<select name="type">
                <option value="">==请选择类型==</option>
                <option value="3">人工汇款</option>
                <option value="4">彩金派送</option>
                <option value="5">返水派送</option>
                <option value="6">其他情况</option>

            </select>
            <input type="hidden" value="import" name="op">
            <input name="find" type="submit" id="find" value="提交"/>
        </td>
    </tr>
</form>

</table> 
<br> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"> 
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" >       
	<tr style="background-color: #EFE" class="t-title"  align="center">
        <td width="15%" height="20" align="center"><strong>行号</strong></td>
        <td width="20%" height="20" align="center"><strong>用户名</strong></td>
	    <td width="20%"><strong>金额</strong></td>
        <td width="30%"><strong>备注信息</strong></td>
        <td colspan="20%"><strong>操作结果</strong></td>
	  </tr>
	  <?php
      if($data){
          $mydata1_db->beginTransaction();
          $result = 1;
          $uid = 0;
          $money = 0;
          foreach($data as $key => $val){
              $sql = " select uid,money from k_user where username = '{$val[0]}' ";

             foreach($mydata1_db->query($sql) as $rows){
                 $uid = $rows['uid'];
                 $money = $rows['money'];
             }

              if($uid) {
                  $amount = intval($val[1]);
                  $username = trim($val[0]);
                  $remark = $val[2];
                  $money_type  = $_REQUEST['type'];
                  $order = $username.time();
                     if($amount>0) {
                         $result = money::chongzhi($uid, $order, $amount, $money, 1, $remark . '[管理员结算]',$money_type );
                         admin::insert_log($_SESSION['adminid'], '对用户ID' . $uid . '的账户金额增加了' . $amount . ',理由' . $remark.'批量加款');
                     }else{
                        $result =  money::tixian($uid, $amount, $money, '888', '888', '888', '888', $order, 1, $remark . '[管理员结算]', $money_type);
                         admin::insert_log($_SESSION['adminid'], '对用户ID' . $uid . '的账户金额扣除了' . $amount . ',理由' . $remark.'批量扣款');
                     }
                  ?>
                  <tr align="center">
                      <td height="20"><?php echo $key; ?></a></td>
                      <td height="20"><?php echo $username; ?></td>
                      <td><font color="#FF0000"><?php echo $amount; ?></font></td>
                      <td height="20"><?php echo $remark; ?></td>
                      <td width="31%" align="center"><?php if ($result) {
                              echo '成功！';
                          } else {
                              echo '失败！';
                          } ?></td>
                  </tr>
              <?php
                 }
                  }
             ?>
         <?php
             if($result){
                 $mydata1_db->commit();
             }else{
                 $mydata1_db->rollBack();
             }
          }?>
	</table> 
  </td> 
</tr> 
</table> 
</body> 
</html>