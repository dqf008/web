<?php
$url = $_GET['url'];
$url = urldecode($url);
header("location:$url");