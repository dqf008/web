<?php
include(dirname(__FILE__).'/cache/website.php');
if(isset($web_site['service_url'])&&!empty($web_site['service_url'])){
	$web_site['service_url'] = array('url' => $web_site['service_url']);
	echo json_encode($web_site['service_url']);
}else{
	echo '{"url":false}';
}
