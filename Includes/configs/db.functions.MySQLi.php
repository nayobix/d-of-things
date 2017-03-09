<?php

//database type specific connector setup
$db_link = @mysqli_connect($dbhost, $dbuser, $dbpass);
if (mysqli_connect_error()) {
    die(DATABASE_CONNECTION_ERROR);
    exit();
}
if (!@mysqli_select_db($db_link, $dbname)) {
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
    global $db_link;
    $res = mysqli_real_escape_string($db_link, $var);
    return $res;
}

function sqlQuery($sql) {
    global $db_link;
    $res = @mysqli_query($db_link, $sql);
    // or die("Error" . " File: " . __FILE__ . " on line: " . __LINE__ . " : " . sqlErrorReturn());
    return $res;
}

function sqlFetchRow($res) {
    $row = mysqli_fetch_row($res);
    return $row;
}

function sqlFetchAssoc($sql) {
    $res = mysqli_fetch_assoc($sql);
    return $res;
}

function sqlFetchArray($res) {
    $array = mysqli_fetch_array($res);
    return $array;
}

function sqlNumRows($res) {
    $num = mysqli_num_rows($res);
    return $num;
}

function sqlErrorReturn() {
    global $db_link;
    $res = mysqli_error($db_link);
    return $res;
}

function sqlFreeResult($res) {
    $res = mysqli_free_result($res);
    return $res;
}

function sqlLastInsert() {
    global $db_link;
    $res = mysqli_insert_id($db_link);
    return $res;
}

?>
