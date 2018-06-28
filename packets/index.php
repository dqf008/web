<?php
session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
define('IN_PACKETS', './');
include('./packets.php');
