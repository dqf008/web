<?php 
include '../../class/Db.class.php';
$id = (int)$_GET['id'];
$db = new DB();
$res = $db->row('select * from webinfo where code="promotions" and id=:id',['id'=>$id]);
if(!$res) die('ERROR');
$info = unserialize($res['content']);
$content = $info[1];

?>
<html>
<head>
	<meta charset="UTF-8">
	<title>优惠活动</title>
	<script src="https://cdn.jsdelivr.net/npm/pym.js@1.3.2/dist/pym.v1.min.js"></script>
</head>
<body>
	<div><?=$content?></div>
</body>
</html>