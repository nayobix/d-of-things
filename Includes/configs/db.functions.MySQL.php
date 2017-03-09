<?php

//database type specific connector setup
$db_link = @mysql_connect($dbhost, $dbuser, $dbpass);
if (!$db_link) {
    die(DATABASE_CONNECTION_ERROR);
    exit();
}
if (!@mysql_select_db($dbname)) {
    die(DATABASE_LOCATION_ERROR);
    exit();
}

function sqlDebug($file, $line, $error) {
    global $setSQLDebug;

    if ($setSQLDebug == 1) {
        die("<h1>Fatal Error:</h1><p>Error File: " . $file . " on line: " . $line . " : " . $error . "</p>");
    } elseif ($setSQLDebug == 2) {
        die(DEBUG_SQL_TURN_OFF_VERBOSE_MESSAGE);
    } elseif ($setSQLDebug == 3) {
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "" . safeDir($_SERVER['PHP_SELF']) . "/listings.php?action=view");
        exit();
    } else {
        return false;
    }
}

// SQL remapper take and create functions for different types of databses
function sqlEscapeString($var) {
    $res = mysql_real_escape_string($var);
    return $res;
}

function sqlQuery($sql) {
    $res = @mysql_query($sql);
    // or die("Error" . " File: " . __FILE__ . " on line: " . __LINE__ . " : " . sqlErrorReturn());
    return $res;
}

function sqlFetchRow($res) {
    $row = mysql_fetch_row($res);
    return $row;
}

function sqlFetchAssoc($sql) {
    $res = mysql_fetch_assoc($sql);
    return $res;
}

function sqlFetchArray($res) {
    $array = mysql_fetch_array($res);
    return $array;
}

function sqlNumRows($res) {
    $num = mysql_num_rows($res);
    return $num;
}

function sqlErrorReturn() {
    $res = mysql_error();
    return $res;
}

function sqlFreeResult($res) {
    $res = mysql_free_result($res);
    return $res;
}

function sqlLastInsert() {
    $res = mysql_insert_id();
    return $res;
}

?>
