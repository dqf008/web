<?php
die();
include_once "../../include/config.php";
include_once "../../database/mysql.config.php";
include_once "../common/login_check.php";
check_quanxian("hydc");

if ($_GET["doType"] == "down") {
	$gid = $_GET["gid"];
	$params55 = array(":gid" => $gid);
	$sql55 = "select username,reg_date,pay_card,pay_name,pay_address,mobile  from  mydata1_db.k_user where  gid=:gid order by username desc";
	$stmt = $mydata1_db->prepare($sql55);
	$stmt->execute($params55);
	require_once "../../common/PHPExcel.php";
	require_once "../../common/PHPExcel/IOFactory.php";
	$objPHPExcel = new PHPExcel();
	$content1 = mb_convert_encoding("会员账号", "utf-8", "utf-8,GBK,gb2312");
	$content2 = mb_convert_encoding("注册时间", "utf-8", "utf-8,GBK,gb2312");
	$content3 = mb_convert_encoding("银行卡号", "utf-8", "utf-8,GBK,gb2312");
	$content4 = mb_convert_encoding("真实姓名", "utf-8", "utf-8,GBK,gb2312");
	$content5 = mb_convert_encoding("手机号码", "utf-8", "utf-8,GBK,gb2312");
	$content6 = mb_convert_encoding("银行地址", "utf-8", "utf-8,GBK,gb2312");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", $content1);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("B1", $content2);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C1", $content3);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("D1", $content4);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("E1", $content5);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("F1", $content6);
	$baseRow = 2;
	$num = 2;

	while ($rs = $stmt->fetch()) {
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A" . $baseRow, "\t" . $rs["username"] . "\t");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue("B" . $baseRow, "\t" . $rs["reg_date"] . "\t");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C" . $baseRow, "\t" . $rs["pay_card"] . "\t");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue("D" . $baseRow, "\t" . $rs["pay_name"] . "\t");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue("E" . $baseRow, "\t" . $rs["mobile"] . "\t");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue("F" . $baseRow, "\t" . $rs["pay_address"] . "\t");
		$baseRow++;
		$num++;
	}

	$export_file_name = date("MdHis") . rand(100, 999) . ".xlsx";
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment;filename=" . $export_file_name);
	header("Cache-Control: max-age=0");
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
	$tmpfile = tempnam('../../cache', $export_file_name);
	$objWriter->save($tmpfile);
	echo file_get_contents($tmpfile);
	unlink($tmpfile);
	exit();
}

?>
