<?php
exit;
session_start();
include_once '../include/config.php'; 
require 'SecurityCard.php';
$scode = new SecurityCard();
$notesa = $scode->printSecurityCard('admin');
echo $notesa;
?>