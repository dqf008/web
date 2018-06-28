<?php 
include '../class/Db.class.php';
$id = (int)$_GET['id'];
$db = new DB();
$res = $db->row('select content from webinfo where code="promotions" and id=:id',['id'=>$id]);
if(!$res) die('ERROR');
$info = unserialize($res['content']);
$content = $info[1];?>
<html>
<head>
	<meta charset="UTF-8">
	<title>优惠活动</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/wangeditor@2.1.23/dist/css/wangEditor.min.css">
	<style>
		.wangEditor-container {
		    position: relative;
		    background-color: transparent;
		    border: none;
		}
	</style>
</head>
<body class="wangEditor-container">
	<div class="wangEditor-txt"><?=$content?></div>
	<script src="https://cdn.jsdelivr.net/npm/pym.js@1.3.2/dist/pym.v1.min.js"></script>
	<script>var pymChild = new pym.Child();</script>
</body>
</html>