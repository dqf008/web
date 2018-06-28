<?php

include_once "../../include/config.php";
include_once "../../database/mysql.config.php";
include_once "../common/login_check.php";
check_quanxian("hyzgl");
$sql = "select id,name from k_group";
$query = $mydata1_db->query($sql);
$rows1 = $query->fetchAll();

if ($_REQUEST["del"]) {
	if ($_REQUEST["id"]) {
		$id = intval($_REQUEST["id"]);
		$sql = "select count(*) from k_group";
		$result = $mydata1_db->query($sql);
		$row_num = $result->fetchColumn();

		if ($row_num <= 1) {
			message("没有多余的会员组，不能删除", "group.php");
		}

		$sql = "Delete from `k_group` where id=$id";
		$result = $mydata1_db->query($sql);
		$q1 = $result->rowCount();

		if ($q1 == 1) {
			@unlink("../../cache/group_" . $id . ".php");
		}

		message("删除成功", "group.php");
	}
}
else if ($_REQUEST["action"] == "change") {
	if (!is_numeric($_REQUEST["choice"]) || !is_numeric($_REQUEST["totall_m"]) || !is_numeric($_REQUEST["totall_c"]) || !is_numeric($_REQUEST["group_end"]) || !is_numeric($_REQUEST["group_stat"])) {
		message("格式有误", "group.php");
		exit();
	}

	$totall_m = (is_numeric($_REQUEST["totall_m"]) ? $_REQUEST["totall_m"] : 0);
	$totall_c = (is_numeric($_REQUEST["totall_c"]) ? $_REQUEST["totall_c"] : 0);
	$money = (is_numeric($_REQUEST["pice_m"]) ? $_REQUEST["pice_m"] : 0);
	$group_end = $_REQUEST["group_end"];
	$group_stat = $_REQUEST["group_stat"];
	$group_id = array();

	for ($i = 0; $i < count($rows1); $i++) {
		$group_id[$i] = $rows1[$i]["id"];
	}

	if (!in_array($group_end, $group_id) || !in_array($group_stat, $group_id)) {
		message("会员组信息有误", "group.php");
		exit();
	}

	if ($_REQUEST["choice"] == "1") {
		$params = array(":m_value" => $money, ":money" => $money, ":group_stat" => $group_stat, ":totall_c" => $totall_c, ":totall_m" => $totall_m);
		$sql = "select m.uid,sum(num) total,sum(m.money) as money from (\r\n\t\t\t\t\t\tselect uid,count(1) as num,sum(m_value) as money \r\n\t\t\t\t\t\tfrom k_Money \r\n\t\t\t\t\t\twhere type in (1,3) \r\n\t\t\t\t\t\tand status = 1 \r\n\t\t\t\t\t\tand m_value >=:m_value\t\t\t\t\t\t\t\r\n\t\t\t\t\t\tgroup by uid \r\n\t\t\t\t\t\tunion all  \r\n\t\t\t\t\t\tselect uid,count(1) as num,sum(money) as money \r\n\t\t\t\t\t\tfrom huikuan \r\n\t\t\t\t\t\twhere status = 1 \r\n\t\t\t\t\t\tand money >=:money\t\t\t\t\t\t\t\r\n\t\t\t\t\t\tgroup by uid \r\n\t\t\t\t\t) m left join k_user u on m.uid=u.uid \r\n\t\t\t\t\twhere  u.gid = :group_stat \r\n\t\t\t\t\tgroup by m.uid having total>=:totall_c or money >=:totall_m";
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$mid_goupid = $stmt->fetchAll();
		$uids = 0;

		for ($j = 0; $j < count($mid_goupid); $j++) {
			$uids .= intval($mid_goupid[$j]["uid"]) . ",";
		}

		$uids = rtrim($uids, ",");
		$params2 = array(":group_end" => $group_end);
		$sql = "update \tk_user i set i.gid = :group_end where i.uid in ($uids)";
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params2);
		$rows = $stmt->rowCount();
		message("转移会员" . $rows . "个", "group.php");
		exit();
	}
	else if ($_REQUEST["choice"] == "2") {
		$params = array(":m_value" => $money, ":money" => $money, ":group_stat" => $group_stat, ":totall_c" => $totall_c, ":totall_m" => $totall_m);
		$sql = "select m.uid,sum(num) total,sum(m.money) as money from (\r\n\t\t\t\t\t\tselect uid,count(1) as num,sum(m_value) as money \r\n\t\t\t\t\t\tfrom k_Money \r\n\t\t\t\t\t\twhere type in (1,3) \r\n\t\t\t\t\t\tand status = 1 \r\n\t\t\t\t\t\tand m_value >=:m_value\t\t\t\t\t\t\t\r\n\t\t\t\t\t\tgroup by uid \r\n\t\t\t\t\t\tunion all  \r\n\t\t\t\t\t\tselect uid,count(1) as num,sum(money) as money \r\n\t\t\t\t\t\tfrom huikuan \r\n\t\t\t\t\t\twhere status = 1 \r\n\t\t\t\t\t\tand money >=:money\t\t\t\t\t\t\t\r\n\t\t\t\t\t\tgroup by uid \r\n\t\t\t\t\t) m left join k_user u on m.uid=u.uid \r\n\t\t\t\t\twhere  u.gid = :group_stat \r\n\t\t\t\t\tgroup by m.uid having total>=:totall_c and money >=:totall_m";
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$mid_goupid = $stmt->fetchAll();
		$uids = 0;

		for ($j = 0; $j < count($mid_goupid); $j++) {
			$uids .= intval($mid_goupid[$j]["uid"]) . ",";
		}

		$uids = rtrim($uids, ",");
		$params2 = array(":group_end" => $group_end);
		$sql = "update \tk_user i set i.gid = :group_end where i.uid in ($uids)";
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params2);
		$rows = $stmt->rowCount();
		message("转移会员" . $rows . "个", "group.php");
		exit();
	}
	else if ($_REQUEST["choice"] == "3") {
		$params = array(":group_end" => $group_end, ":group_stat" => $group_stat);
		$sql = "update \tk_user set gid = :group_end where gid = :group_stat";
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$rows = $stmt->rowCount();
		message("转移会员" . $rows . "个", "group.php");
		exit();
	}
}

echo "<HTML>\r\n<HEAD>\r\n<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=utf-8\" />\r\n<TITLE>用户组列表</TITLE>\r\n<script type=\"text/javascript\" src=\"/skin/js/jquery-1.7.2.min.js\"></script>\r\n<style type=\"text/css\">\r\n<STYLE>\r\nBODY {\r\nSCROLLBAR-FACE-COLOR: rgb(255,204,0);\r\n SCROLLBAR-3DLIGHT-COLOR: rgb(255,207,116);\r\n SCROLLBAR-DARKSHADOW-COLOR: rgb(255,227,163);\r\n SCROLLBAR-BASE-COLOR: rgb(255,217,93)\r\n}\r\n.STYLE2 {font-size: 12px}\r\nbody {\r\n\tmargin-left: 0px;\r\n\tmargin-top: 0px;\r\n\tmargin-right: 0px;\r\n\tmargin-bottom: 0px;\r\n}\r\ntd{font:13px/120% \"宋体\";padding:3px;}\r\na{\r\n\r\n\tcolor:#F37605;\r\n\r\n\ttext-decoration: none;\r\n\r\n}\r\n.t-title{background:url(../images/06.gif);height:24px;}\r\n.t-tilte td{font-weight:800;}\r\n</STYLE>\r\n<script type=\"text/javascript\">\r\nfunction del(v){\r\n    v=v.split('|')\r\n\tif(v[0]>0){\r\n\t    alert(\"该会员组下有会员，请先将该会员组下的会员转移，再来删除该会员组！\");\r\n\t\treturn false;\r\n\t}else{\r\n\t    return confirm('您确定要删除：'+v[1]+\" 吗？\") ? true : false;\r\n\t}\r\n}\r\n</script>\r\n</HEAD>\r\n\r\n<body>\r\n<table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#CCCCCC\">\r\n  <tr>\r\n    <td height=\"24\" nowrap background=\"../images/06.gif\"><font >&nbsp;<span class=\"STYLE2\">用户组权限管理：查看用户组信息</span></font></td>\r\n  </tr>\r\n  <tr>\r\n    <td height=\"24\" align=\"left\" nowrap bgcolor=\"#FFFFFF\">&nbsp;&nbsp;<a href=\"group_edit.php\">新增会员组</a> | <a href=\"list.php\">返回会员列表页</a></td>\r\n  </tr>\r\n</table>\r\n\r\n<table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#CCCCCC\">\r\n   \r\n  <tr>\r\n    <td height=\"24\" nowrap bgcolor=\"#FFFFFF\">\r\n    \r\n<table width=\"100%\" border=\"1\" bgcolor=\"#FFFFFF\" bordercolor=\"#96B697\" cellspacing=\"0\" cellpadding=\"0\" style=\"border-collapse: collapse; color: #225d9c;\" id=editProduct   idth=\"100%\" >       <tr style=\"background-color: #EFE\" class=\"t-title\"  align=\"center\">\r\n        <td width=\"7%\"  height=\"20\"><strong>编号</strong></td>\r\n        <td width=\"47%\" ><strong>用户组名称</strong></td>\r\n        <td width=\"24%\" ><strong>会员总数</strong></td>\r\n        <td width=\"22%\" ><strong>操作</strong></td>\r\n      </tr>\r\n      ";
$sql = "select count(u.uid) as uid,g.id,g.name from `k_group` g left join `k_user` u on g.id=u.gid group by g.id order by g.id asc";
$query = $mydata1_db->query($sql);

while ($rows = $query->fetch()) {
	echo "\t        <tr align=\"center\" onMouseOver=\"this.style.backgroundColor='#EBEBEB'\" onMouseOut=\"this.style.backgroundColor='#FFFFFF'\" style=\"background-color:#FFFFFF;\">\r\n\t          <td>";
	echo $rows["id"];
	echo "</td>\r\n              <td>";
	echo $rows["name"];
	echo "</td>\r\n\t          <td>";
	echo 0 < $rows["uid"] ? $rows["uid"] : "<span style=\"color:#FF0000;\">" . $rows["uid"] . "</span>";
	echo "</td>\r\n\t          <td><a href=\"group_edit.php?id=";
	echo $rows["id"];
	echo "\" >修改</a> | <a href=\"";
	echo 0 < $rows["uid"] ? "#" : "?del=1&id=" . $rows["id"];
	echo "\" onClick=\"return del('";
	echo $rows["uid"];
	echo "|";
	echo $rows["name"];
	echo "')\">删除</a>";
	echo "</td>\r\n  </tr>   \t\r\n";
}

echo "    </table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<br/>\r\n<script>\r\nfunction SubInfo(){\r\n\tif($('#group_stat').val()==''){\r\n\t\talert('请选择初始会员组');\r\n\t\t$('#group_stat').focus();\r\n\t\treturn false;\r\n\t}\r\n\tif($('#group_end').val()==''){\r\n\t\talert('请选择目标会员组');\r\n\t\t$('#group_end').focus();\r\n\t\treturn false;\r\n\t}\r\n\tif($('#group_stat').val()==$('#group_end').val()){\r\n\t\talert('初始会员组和目标会员组不能相同');\r\n\t\t$('#group_end').focus();\r\n\t\treturn false;\t\t\r\n\t}\r\n\ta = $('#totall_c').val();\r\n\tb = $('#totall_m').val();\r\n\tc = $('#pice_m').val();\r\n\tif(isNaN(a)){\r\n\t\talert('累计充值次数格式有误！');\r\n\t\treturn false;\r\n\t}\r\n\tif(isNaN(b)){\r\n\t\talert('累计充值金额格式有误！');\r\n\t\treturn false;\r\n\t}\r\n\tif(a==''){\r\n\t\talert('累计充值次数不能为空！');\r\n\t\treturn false;\t\t\t\r\n\t}\r\n\tif(b==''){\r\n\t\talert('累计充值金额不能为空！');\r\n\t\treturn false;\t\t\t\r\n\t}\r\n\tif(c==''){\r\n\t\talert('单笔最低金额不能为空！');\r\n\t\treturn false;\t\t\t\r\n\t}\r\n\t$('#form1').submit();\t\r\n}\r\n</script>\r\n<table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#CCCCCC\">\r\n\t<tr>\r\n\t\t<td height=\"24\" nowrap background=\"../images/06.gif\">\r\n\t\t\t<font >&nbsp;<span class=\"STYLE2\">用户组权限管理：转移会员</span></font>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td height=\"24\" align=\"left\" nowrap bgcolor=\"#FFFFFF\">\r\n\t\t\t<table width=\"100%\" border=\"1\" bgcolor=\"#FFFFFF\" bordercolor=\"#96B697\" cellspacing=\"0\" cellpadding=\"0\" style=\"border-collapse: collapse; color: #225d9c;\" id=editProduct   idth=\"100%\" >       \r\n\t\t\t\t<tr style=\"background-color: #EFE\" class=\"t-title\"  align=\"center\">\r\n\t\t\t\t\t<td width=\"14%\"  height=\"20\"><strong>初始会员组</strong></td>\r\n\t\t\t\t\t<td width=\"14%\" ><strong>目标会员组</strong></td>\r\n\t\t\t\t\t<td width=\"14%\" ><strong>单笔最低金额</strong></td>\r\n\t\t\t\t\t<td width=\"16%\" ><strong>条件一：累计有效充值次数</strong></td>\r\n\t\t\t\t\t<td width=\"16%\" ><strong>条件二：累计有效充值金额</strong></td>\r\n\t\t\t\t\t<td width=\"16%\" ><strong>转移条件限制</strong></td>\r\n\t\t\t\t\t<td width=\"7%\" ><strong>操作</strong></td>\r\n\t\t\t\t</tr>\t\r\n\t\t\t\t<tr align=\"center\" style=\"background-color:#FFFFFF;\">\r\n\t\t\t\t\t<form action=\"group.php\" method=\"get\" name=\"form1\" id=\"form1\">\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t<select name=\"group_stat\" id=\"group_stat\"  style=\"margin-bottom:5px;\" >\r\n\t\t\t\t\t\t\t\t<option value=\"\">==请选择会员组==</option>\r\n\t\t\t\t\t\t\t\t";

foreach ($rows1 as $k => $v ) {
	echo "\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\t<option value=\"";
	echo $v["id"];
	echo "\">";
	echo $v["name"];
	echo "</option>\r\n\t\t\t\t\t\t\t\t";
	$ci++;
}

if ($ci == 0) {
	echo "\t\t\t\t\t\t\t\t\t&nbsp;\r\n\t\t\t\t\t\t\t\t";
}

echo "\t\t\t\t\t\t\t</select>\t\t\t\t\t\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t<select name=\"group_end\" id=\"group_end\"  style=\"margin-bottom:5px;\">\r\n\t\t\t\t\t\t\t\t<option value=\"\">==请选择会员组==</option>\r\n\t\t\t\t\t\t\t\t";

foreach ($rows1 as $k => $v ) {
	echo "\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\t<option value=\"";
	echo $v["id"];
	echo "\">";
	echo $v["name"];
	echo "</option>\r\n\t\t\t\t\t\t\t\t";
	$ci++;
}

if ($ci == 0) {
	echo "\t\t\t\t\t\t\t\t\t&nbsp;\r\n\t\t\t\t\t\t\t\t";
}

echo "\t\t\t\t\t\t\t</select>\t\t\t\t\t\r\n\t\t\t\t\t\t</td>\t\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t<input type=\"text\" value=\"0\" name=\"pice_m\" id=\"pice_m\"/>\r\n\t\t\t\t\t\t</td>\t\t\t\t\t\t\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t<input type=\"text\" value=\"0\" name=\"totall_c\" id=\"totall_c\"/>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t<input type=\"text\" value=\"0\" name=\"totall_m\" id=\"totall_m\"/>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t<select name=\"choice\" style=\"margin-bottom:5px;\" id=\"choice\">\r\n\t\t\t\t\t\t\t\t<option value=\"1\">条件满足其一即可</option>\t\t\r\n\t\t\t\t\t\t\t\t<option value=\"2\">条件必须全部满足</option>\r\n\t\t\t\t\t\t\t\t<option value=\"3\">无条件全部转移</option>\r\n\t\t\t\t\t\t\t</select>\t\t\t\t\t\r\n\t\t\t\t\t\t</td>\t\t\t\t\t\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t<input type=\"submit\" value=\"转移\" onclick=\"return SubInfo();\"/>\r\n\t\t\t\t\t\t\t<input type=\"hidden\" name=\"action\" value=\"change\"/>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t</form>\r\n\t\t\t\t</tr>\t\t\r\n\t\t\t</table>\t\t\t\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr style=\"background-color: #fff;font-size:18px;\">\r\n\t\t<td>\r\n\t\t\t说明：<br/>\r\n\t\t\t1、单笔最低金额------》》有设置此金额时，只有大于等于此金额才算一笔有效充值，不设置时候填写0；<br/>\r\n\t\t\t2、累计有效充值次数--》》每笔充值金额大于单笔最低金额的总充值次数，不设置时候填写0；<br/>\r\n\t\t\t3、累计有效充值金额--》》每笔充值金额大于单笔最低金额的总充值金额，不设置时候填写0；<br/>\r\n\t\t\t4、整个会员组转移方法》》所有输入框填写0，转移条件限制选择：无条件全部转移即可；<br/>\r\n\t\t</td>\r\n\t</tr>\r\n</table> \r\n</body>\r\n</html>";

?>
