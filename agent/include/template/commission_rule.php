<?php
defined('IN_AGENT')||exit('Access denied');
include IN_AGENT.'include/template/header.php';
?>
		<div class="section">
			<div class="wrapper">
				<div class="commission-desc" style="height:auto">
                    <div class="content">
                        <div class="head">佣金条款</div>
                        <div class="body"><?php $rows = get_webinfo_bycode('agent-servicerule');echo isset($rows['content'])?$rows['content']:''; ?></div>
                    </div>
                </div>
			</div>
		</div>
<?php include IN_AGENT.'include/template/footer.php'; ?>