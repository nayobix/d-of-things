<?php

require_once './Includes/configs/functions.php';
require_once './Includes/configs/env.inc.php';

$file = basename(__FILE__, ".php");
$DEBUG = 0;
error_reporting(E_ALL);
ini_set("display_errors", "On");

mqttSubscribe();
?>
