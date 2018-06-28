<?php
defined('WEB_START') or define('WEB_START', microtime(true));
require_once __DIR__ . '/include/Core.php';
require_once __DIR__ . '/conf.php';
spl_autoload_register(array('Core', 'autoload'));