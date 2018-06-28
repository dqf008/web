<?php
include_once("zr_conf.php"); 
?>
<div class="nav">
	<ul>
		<li <?=$sub==1?"class='current'":""?>><a href="javascript:void(0);" onclick="Go('<?=$full_url?>set_money.php');return false">线上存款</a></li>
		<li <?=$sub==2?"class='current'":""?>><a href="javascript:void(0);" onclick="Go('<?=$full_url?>get_money.php');return false">线上提款</a></li>
		<li <?=$sub==3?"class='current'":""?>><a href="javascript:void(0);" onclick="Go('<?=$full_url?>data_money.php');return false">财务记录</a></li>
		<?php if($zr_open==1){ ?>
		<li <?=$sub==4?"class='current'":""?>><a href="javascript:void(0);" onclick="Go('<?=$full_url?>zr_money.php');return false">额度转换</a></li>
		<li <?=$sub==5?"class='current'":""?>><a href="javascript:void(0);" onclick="Go('<?=$full_url?>zr_data_money.php');return false">转换记录</a></li>
		<?php } ?>
	</ul>
</div>