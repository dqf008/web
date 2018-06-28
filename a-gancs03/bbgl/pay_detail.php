<?php

include_once "../../include/config.php";
include_once "../../database/mysql.config.php";
include_once "../common/login_check.php";
check_quanxian("bbgl");
$time = $_GET["time"];
if (($time != "CN") && ($time != "EN")) {
	$time = "CN";
}

$bdate = $_GET["bdate"];
$bdate = ($bdate == "" ? date("Y-m-d", time()) : $bdate);
$edate = $_GET["edate"];
$edate = ($edate == "" ? date("Y-m-d", time()) : $edate);
$btime = $bdate . " 00:00:00";
$etime = $edate . " 23:59:59";

if ($edate < $bdate) {
	message("起始日期不能大于截止日期");
}

$showArray = array();
$bdate2 = $bdate;
$edate2 = $edate;

while ($bdate2 <= $edate2) {
	$showArray[$bdate2]["newun"] = 0;
	$showArray[$bdate2]["new1un"] = 0;
	$showArray[$bdate2]["new1pn"] = 0;
	$showArray[$bdate2]["new1money"] = 0;
	$showArray[$bdate2]["new2un"] = 0;
	$showArray[$bdate2]["new2pn"] = 0;
	$showArray[$bdate2]["new2money"] = 0;
	$showArray[$bdate2]["new3un"] = 0;
	$showArray[$bdate2]["new3pn"] = 0;
	$showArray[$bdate2]["new3money"] = 0;
	$showArray[$bdate2]["all1un"] = 0;
	$showArray[$bdate2]["all1pn"] = 0;
	$showArray[$bdate2]["all1money"] = 0;
	$showArray[$bdate2]["all2un"] = 0;
	$showArray[$bdate2]["all2pn"] = 0;
	$showArray[$bdate2]["all2money"] = 0;
	$showArray[$bdate2]["all3un"] = 0;
	$showArray[$bdate2]["all3pn"] = 0;
	$showArray[$bdate2]["all3money"] = 0;
	$bdate2 = date("Y-m-d", strtotime($bdate2) + (24 * 3600));
}

echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n\t<title>Welcome</title>\r\n\t<link rel=\"stylesheet\" href=\"../images/css/admin_style_1.css\" type=\"text/css\" media=\"all\" />\r\n\t<script type=\"text/javascript\" charset=\"utf-8\" src=\"/js/jquery.js\" ></script>\r\n\t<script language=\"JavaScript\" src=\"/js/calendar.js\"></script>\r\n</head>\r\n<body>\r\n<div id=\"pageMain\">\r\n\t<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"5\" cellspacing=\"0\" class=\"font12\" style=\"border:1px solid #798EB9;\">\r\n\t\t<form name=\"form1\" method=\"get\" action=\"\">\r\n\t\t\t<tr bgcolor=\"#FFFFFF\">\r\n\t\t\t\t<td align=\"left\">\r\n\t\t\t\t\t<select name=\"time\" id=\"time\">\r\n\t\t\t\t\t\t<option value=\"CN\" ";
echo $time == "CN" ? "selected" : "";
echo ">北京时间</option>\r\n\t\t\t\t\t\t<option value=\"EN\" ";
echo $time == "EN" ? "selected" : "";
echo ">美东时间</option>\r\n\t\t\t\t\t</select>\r\n\t\t\t\t\t&nbsp;开始日期\r\n\t\t\t\t\t<input name=\"bdate\" type=\"text\" id=\"bdate\" value=\"";
echo $bdate;
echo "\" onClick=\"new Calendar(2008,2020).show(this);\" size=\"10\" maxlength=\"10\" readonly=\"readonly\" />\r\n\t\t\t\t\t&nbsp;结束日期\r\n\t\t\t\t\t<input name=\"edate\" type=\"text\" id=\"edate\" value=\"";
echo $edate;
echo "\" onClick=\"new Calendar(2008,2020).show(this);\" size=\"10\" maxlength=\"10\" readonly=\"readonly\" />\r\n\t\t\r\n\t\t\t\t\t<input type=\"hidden\" name=\"ok\" id=\"ok\" value=\"1\" />\r\n\t\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name=\"find\" type=\"submit\" id=\"find\" value=\"查找\"/>\r\n\t\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t\r\n\t\t\t<tr bgcolor=\"#FFFFFF\">\r\n\t\t\t\t<td align=\"left\">\r\n\t\t\t\t\t<span style=\"color:#f00;\">备注：建议最长选择一个月时间，时间越长性能消耗越大；统计行，所有会员【人数】，按照不同天直接累加，未剔重；</span>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</form>\r\n\t</table>\r\n\t<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"1\" class=\"font12\" style=\"margin-top:5px;line-height:20px;\" bgcolor=\"#798EB9\">\r\n\t\t<tr align=\"center\" style=\"background:#3C4D82;color:#ffffff;\">\r\n\t\t\t<td rowspan=\"3\">日期</td>\r\n\t\t\t<td colspan=\"10\">新增会员</td>\r\n\t\t\t<td colspan=\"9\">所有会员</td>\r\n\t\t</tr>\r\n\t\t<tr align=\"center\" style=\"background:#3C4D82;color:#ffffff;\">\r\n\t\t\t<td rowspan=\"2\">人数</td>\r\n\t\t\t<td colspan=\"3\">在线充值</td>\r\n\t\t\t<td colspan=\"3\">汇款提交</td>\r\n\t\t\t<td colspan=\"3\">人工加款</td>\r\n\t\t\t<td colspan=\"3\">在线充值</td>\r\n\t\t\t<td colspan=\"3\">汇款提交</td>\r\n\t\t\t<td colspan=\"3\">人工加款</td>\r\n\t\t</tr>\r\n\t\t<tr align=\"center\" style=\"background:#3C4D82;color:#ffffff;\">\r\n\t\t\t<td>人数</td>\r\n\t\t\t<td>次数</td>\r\n\t\t\t<td>金额</td>\r\n\t\t\t<td>人数</td>\r\n\t\t\t<td>次数</td>\r\n\t\t\t<td>金额</td>\r\n\t\t\t<td>人数</td>\r\n\t\t\t<td>次数</td>\r\n\t\t\t<td>金额</td>\r\n\t\t\t<td>人数</td>\r\n\t\t\t<td>次数</td>\r\n\t\t\t<td>金额</td>\r\n\t\t\t<td>人数</td>\r\n\t\t\t<td>次数</td>\r\n\t\t\t<td>金额</td>\r\n\t\t\t<td>人数</td>\r\n\t\t\t<td>次数</td>\r\n\t\t\t<td>金额</td>\r\n\t\t</tr>\r\n\t\t\r\n\t\t";

if (intval($_GET["ok"]) == 1) {
	$color = "#FFFFFF";
	$over = "#EBEBEB";
	$out = "#ffffff";

	if ($time == "CN") {
		$hour = 12;
		$q_btime = date("Y-m-d H:i:s", strtotime($btime) - (12 * 3600));
		$q_etime = date("Y-m-d H:i:s", strtotime($etime) - (12 * 3600));
	}
	else {
		$hour = 0;
		$q_btime = $btime;
		$q_etime = $etime;
	}

	$params = array(":q_btime" => $q_btime, ":q_etime" => $q_etime);
	$sql = "select date_format(date_add(k.reg_date,interval $hour hour),'%Y-%m-%d') thedate,\r\n\t\t\t\t\t\tcount(distinct k.uid) as newun\r\n\t\t\t\t\tfrom k_user k\r\n\t\t\t\t\twhere reg_date>=:q_btime\r\n\t\t\t\t\tand reg_date<=:q_etime\r\n\t\t\t\t\tgroup by thedate\r\n\t\t\t\t\torder by thedate desc";
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);

	while ($row = $stmt->fetch()) {
		$showArray[$row["thedate"]]["newun"] = $row["newun"];
	}

	$params = array(":q_btime1" => $q_btime, ":q_etime1" => $q_etime, ":q_btime2" => $q_btime, ":q_etime2" => $q_etime);
	$sql = "select date_format(date_add(km.m_make_time,interval $hour hour),'%Y-%m-%d') thedate,\r\n\t\t\t\t\t\tcount(distinct if(km.type=1 and k.uid is not null,km.uid,null)) as new1un,\r\n\t\t\t\t\t\tcount(if(km.type=1 and k.uid is not null,km.m_order,null)) as new1pn,\r\n\t\t\t\t\t\tsum(if(km.type=1 and k.uid is not null,km.m_value,0)) as new1money,\r\n\t\t\t\t\t\tcount(distinct if(km.type=3 and k.uid is not null,km.uid,null)) as new3un,\r\n\t\t\t\t\t\tcount(if(km.type=3 and k.uid is not null,km.m_order,null)) as new3pn,\r\n\t\t\t\t\t\tsum(if(km.type=3 and k.uid is not null,km.m_value,0))as new3money,\r\n\t\t\t\t\t\tcount(distinct if(km.type=1,km.uid,null)) as all1un,\r\n\t\t\t\t\t\tcount(if(km.type=1,km.m_order,null)) as all1pn,\r\n\t\t\t\t\t\tsum(if(km.type=1,km.m_value,0)) as all1money,\r\n\t\t\t\t\t\tcount(distinct if(km.type=3,km.uid,null)) as all3un,\r\n\t\t\t\t\t\tcount(if(km.type=3,km.m_order,null)) as all3pn,\r\n\t\t\t\t\t\tsum(if(km.type=3,km.m_value,0))as all3money\r\n\t\t\t\t\tfrom k_money km \r\n\t\t\t\t\t\tleft join k_user k on km.uid = k.uid \r\n\t\t\t\t\t\t\t\t\tand k.reg_date>=:q_btime1 \r\n\t\t\t\t\t\t\t\t\tand k.reg_date<=:q_etime1\r\n\t\t\t\t\t\t\t\t\tand left(date_add(km.m_make_time,interval $hour hour),10) = left(date_add(k.reg_date,interval $hour hour),10)\r\n\t\t\t\t\twhere km.m_make_time>=:q_btime2 \r\n\t\t\t\t\t\t and km.m_make_time<=:q_etime2 \r\n\t\t\t\t\t\t and km.type in (1,3)\r\n\t\t\t\t\t\t and km.status = 1\r\n\t\t\t\t\tgroup by thedate\r\n\t\t\t\t\torder by thedate desc";
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);

	while ($row = $stmt->fetch()) {
		$showArray[$row["thedate"]]["new1un"] = $row["new1un"];
		$showArray[$row["thedate"]]["new1pn"] = $row["new1pn"];
		$showArray[$row["thedate"]]["new1money"] = $row["new1money"];
		$showArray[$row["thedate"]]["new3un"] = $row["new3un"];
		$showArray[$row["thedate"]]["new3pn"] = $row["new3pn"];
		$showArray[$row["thedate"]]["new3money"] = $row["new3money"];
		$showArray[$row["thedate"]]["all1un"] = $row["all1un"];
		$showArray[$row["thedate"]]["all1pn"] = $row["all1pn"];
		$showArray[$row["thedate"]]["all1money"] = $row["all1money"];
		$showArray[$row["thedate"]]["all3un"] = $row["all3un"];
		$showArray[$row["thedate"]]["all3pn"] = $row["all3pn"];
		$showArray[$row["thedate"]]["all3money"] = $row["all3money"];
	}

	$params = array(":q_btime1" => $q_btime, ":q_etime1" => $q_etime, ":q_btime2" => $q_btime, ":q_etime2" => $q_etime);
	$sql = "select date_format(date_add(km.adddate,interval $hour hour),'%Y-%m-%d') thedate,\r\n\t\t\t\t\t\tcount(distinct if(k.uid is not null,km.uid,null)) as new2un,\r\n\t\t\t\t\t\tcount(if(k.uid is not null,km.lsh,null)) as new2pn,\r\n\t\t\t\t\t\tsum(if(k.uid is not null,km.money,0)) as new2money,\r\n\t\t\t\t\t\tcount(distinct km.uid) as all2un,\r\n\t\t\t\t\t\tcount(km.lsh) as all2pn,\r\n\t\t\t\t\t\tsum(km.money) as all2money\r\n\t\t\t\t\tfrom huikuan km\r\n\t\t\t\t\t\tleft join k_user k on km.uid = k.uid \r\n\t\t\t\t\t\t\t and k.reg_date>=:q_btime1 \r\n\t\t\t\t\t\t\t and k.reg_date<=:q_etime1\r\n\t\t\t\t\t\t\t and left(date_add(km.adddate,interval $hour hour),10) = left(date_add(k.reg_date,interval $hour hour),10)\r\n\t\t\t\t\twhere km.adddate>=:q_btime2  \r\n\t\t\t\t\tand km.adddate<=:q_etime2\r\n\t\t\t\t\tand km.status = 1\r\n\t\t\t\t\tgroup by thedate\r\n\t\t\t\t\torder by thedate desc";
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);

	while ($row = $stmt->fetch()) {
		$showArray[$row["thedate"]]["new2un"] = $row["new2un"];
		$showArray[$row["thedate"]]["new2pn"] = $row["new2pn"];
		$showArray[$row["thedate"]]["new2money"] = $row["new2money"];
		$showArray[$row["thedate"]]["all2un"] = $row["all2un"];
		$showArray[$row["thedate"]]["all2pn"] = $row["all2pn"];
		$showArray[$row["thedate"]]["all2money"] = $row["all2money"];
	}

	$sum_newun = 0;
	$sum_new1un = 0;
	$sum_new1pn = 0;
	$sum_new1money = 0;
	$sum_new2un = 0;
	$sum_new2pn = 0;
	$sum_new2money = 0;
	$sum_new3un = 0;
	$sum_new3pn = 0;
	$sum_new3money = 0;
	$sum_all1un = 0;
	$sum_all1pn = 0;
	$sum_all1money = 0;
	$sum_all2un = 0;
	$sum_all2pn = 0;
	$sum_all2money = 0;
	$sum_all3un = 0;
	$sum_all3pn = 0;
	$sum_all3money = 0;

	foreach ($showArray as $key => $value ) {
		$sum_newun += $value["newun"];
		$sum_new1un += $value["new1un"];
		$sum_new1pn += $value["new1pn"];
		$sum_new1money += $value["new1money"];
		$sum_new2un += $value["new2un"];
		$sum_new2pn += $value["new2pn"];
		$sum_new2money += $value["new2money"];
		$sum_new3un += $value["new3un"];
		$sum_new3pn += $value["new3pn"];
		$sum_new3money = $value["new3money"];
		$sum_all1un += $value["all1un"];
		$sum_all1pn += $value["all1pn"];
		$sum_all1money += $value["all1money"];
		$sum_all2un += $value["all2un"];
		$sum_all2pn += $value["all2pn"];
		$sum_all2money += $value["all2money"];
		$sum_all3un += $value["all3un"];
		$sum_all3pn += $value["all3pn"];
		$sum_all3money += $value["all3money"];
		echo "\t\t<tr align=\"center\" onMouseOver=\"this.style.backgroundColor='";
		echo $over;
		echo "'\" onMouseOut=\"this.style.backgroundColor='";
		echo $out;
		echo "'\" style=\"background-color:";
		echo $color;
		echo ";\">\r\n\t\t\t<td>";
		echo $key;
		echo "</td>\r\n\t\t\t<td>";
		echo $value["newun"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["new1un"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["new1pn"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["new1money"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["new2un"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["new2pn"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["new2money"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["new3un"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["new3pn"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["new3money"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["all1un"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["all1pn"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["all1money"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["all2un"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["all2pn"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["all2money"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["all3un"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["all3pn"];
		echo "</td>\r\n\t\t\t<td>";
		echo $value["all3money"];
		echo "</td>\r\n        </tr>\r\n\t\t";
	}

	echo "\t\t\r\n\t\t<tr align=\"center\" style=\"background-color:#abc4f7;\">\r\n\t\t\t<td>统计</td>\r\n\t\t\t<td>";
	echo $sum_newun;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_new1un;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_new1pn;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_new1money;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_new2un;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_new2pn;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_new2money;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_new3un;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_new3pn;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_new3money;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_all1un;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_all1pn;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_all1money;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_all2un;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_all2pn;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_all2money;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_all3un;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_all3pn;
	echo "</td>\r\n\t\t\t<td>";
	echo $sum_all3money;
	echo "</td>\r\n        </tr>\r\n\t</table>\r\n\t";
}

echo "</div>\r\n</div>\r\n</body>\r\n</html>";

?>
