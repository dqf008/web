<?php
$str = "";
foreach ($_REQUEST as $k => $v) {
    $str .= "<input type='hidden' name='{$k}' value='{$v}'>";
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
    	<script type="text/javascript" src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    	<script type="text/javascript">
        $(function () {
            $(".bank-list img").on("click", function () {
                $(".bank-list input[type='radio']").prop("checked", false);
                $(this).prev("input[type='radio']").prop("checked", true);
            });
        });
    	</script>		
	</head>	
	<body>
	    <div class="container">
    	   <div class="header">
    		   <h3>网银支付：</h3>
    	   </div>	        
	        <div class="main">
        		<form name="dinpayForm" method="post" action="pany.php" >
            		<?=$str;?>
        			<ul>
        				<li>
        					<label>选择银行</label>
        					<ul class="bank-list">
        						<li>
        							<input name="bankId" type="radio" value="967" checked >
        							<img src="assets/img/bank/gsyh.gif" alt="工商银行" />
        							<input name="bankId" type="radio" value="970">
        							<img src="assets/img/bank/zsyh.gif" alt="招商银行" />
        							<input name="bankId" type="radio" value="965">
        							<img src="assets/img/bank/jsyh.gif" alt="建设银行" />
        							<input name="bankId" type="radio" value="981">
        							<img src="assets/img/bank/jtyh.gif" alt="交通银行" />
        						</li>
        						<li>
        							<input name="bankId" type="radio" value="964">
        							<img src="assets/img/bank/nyyh.gif" alt="农业银行" />
        							<input name="bankId" type="radio" value="963">
        							<img src="assets/img/bank/zgyh.gif" alt="中国银行" />
        							<input name="bankId" type="radio" value="972">
        							<img src="assets/img/bank/xyyh.gif" alt="兴业银行" />
        							<input name="bankId" type="radio" value="977">
        							<img src="assets/img/bank/pdfzyh.gif" alt="浦发银行" />
        						</li>
        						<li>
        							<input name="bankId" type="radio" value="980">
        							<img src="assets/img/bank/msyh.gif" alt="民生银行" />
        							<input name="bankId" type="radio" value="962">
        							<img src="assets/img/bank/zxyh.gif" alt="中信银行" />
        							<input name="bankId" type="radio" value="986">
        							<img src="assets/img/bank/gdyh.gif" alt="光大银行" />
        							<input name="bankId" type="radio" value="982">
        							<img src="assets/img/bank/hxyh.gif" alt="华夏银行" />
        						</li>
        						<li>
        							<input name="bankId" type="radio" value="971">
        							<img src="assets/img/bank/yzcxyh.gif" alt="邮政储蓄银行" />
        							<input name="bankId" type="radio" value="985">
        							<img src="assets/img/bank/gdfzyh.gif" alt="广发银行" />
        							<input name="bankId" type="radio" value="978">
        							<img src="assets/img/bank/payh.gif" alt="平安银行" />
        						</li>
        					</ul>
        				</li>
        				<li style="margin-top: 20px;display: none;">
        					<label>选择类型</label>
        					<ul class="bank-list">
        						<li style="margin-top: 20px">
        							<input name="bankType" type="radio" value="0" checked>
        							借记卡
        							<input name="bankType" type="radio" value="1">
        							信用卡
        					    </li>
        					</ul>
        				</li>
        				<li style="margin-top: 50px">
        					<label></label>
        					<button type="submit">确定支付</button>
        				</li>
        			</ul>    		
                </form>
            </div>
        </div>
	</body>
</html>