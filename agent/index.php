<?php
include(dirname(__FILE__).'/include/common.php');
define('AGENT_SKIN', isset($AGENT['config']['Skin'])&&!empty($AGENT['config']['Skin'])?$AGENT['config']['Skin']:'red');

$action = isset($_GET['action'])&&!empty($_GET['action'])?$_GET['action']:'index';
in_array($action, ['logout', 'commissionrule', 'mycommission'])||$action = 'index';

switch ($action) {
	case 'logout':
		if($AGENT['user']['login']){
			header('Location: ../logout.php');
		}else{
			header('Location: ../');
		}
		break;

	case 'commissionrule':
		include(IN_AGENT.'include/template/commission_rule.php');
		break;

	case 'mycommission':
		if($AGENT['user']['login']&&$AGENT['user']['agent']){
			include(IN_AGENT.'../member/function.php');
			include(IN_AGENT.'../common/function.php');
			include(IN_AGENT.'include/template/my_commission.php');
		}else{
			header('Location: ?action=index');
		}
		break;

	default:
		if($AGENT['user']['login']&&$AGENT['user']['agent']){
			header('Location: ?action=mycommission');
		}else{
			include(IN_AGENT.'include/template/agent_index.php');
		}
		break;
}