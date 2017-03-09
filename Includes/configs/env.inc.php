<?php

function curPageName() {
    return substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
}

function safeDir($path) {
    $dirname = dirname($path);
    return $dirname == '/' ? '' : $dirname;
}

function pageGentime() {
    static $start_time;
    if ($start_time == 0) {
        $start_time = microtime(true);
    } else {
        $end_time = (string) (microtime(true) - $start_time);
        return round($end_time, 3);
    }
}

pageGentime();

//debuging
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
//verbose -> 1 -> non-verbose -> 2 
//silent -> 0 <> verbose -> 1 <> non-verbose -> 2 <> redirect -> 3
$setSQLDebug = 1;

include_once 'db.inc.php';

//setup referers.. domains/ips that you will allow valid referer for form scripts
//$referers = array('example.com','www.example.com');
//for php5 users set the default timezone if not set in your php ini
//http://www.php.net/manual/en/timezones.php
$ver = phpversion();
if ($ver >= 5) {
    if (!@date_default_timezone_set(date_default_timezone_get())) {
        date_default_timezone_set("$site_timezone");
    }
}

session_start();
if (!isset($_SESSION['generated'])) {
    session_regenerate_id();
    $_SESSION['generated'] = true;
}

//check for install directory and prompt for user to delete it or run the installer
if (file_exists("install")) {
    die("<h1>You need to remove your Install Directory.</h1>");
}
?>
