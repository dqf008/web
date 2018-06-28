<?php 
defined('PHPYOU_VER') or exit('非法进入');
$res = $mydata1_db->query('select * from k_user')->fetch(PDO::FETCH_ASSOC);
//var_dump($res);
?> 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title>微信、支付宝</title> 
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-normalize@0.4.0/modern-normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/element-ui@2.2.1/lib/theme-chalk/index.min.css">
    <style>
        body {
		    padding: 8px;
		    font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
		}
		×[v-cloak] {
		    display: none !important
		}
		.el-form {
			width: 500px;
		}
	</style>
</head>
<body>
	<div id="app">
		<el-form >
			<el-form-item>
				<el-input>
					<template slot="prepend">总额度限制：</template>
					<template slot="append">保存</template>
				</el-input>
			</el-form-item>
		</el-form>
	</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/element-ui@2.2.1/lib/index.min.js"></script>
<script type="text/javascript">
var vm = new Vue({

}).$mount('#app');
</script>
</body>
</html>