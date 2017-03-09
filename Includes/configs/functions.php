<?php

include_once("Mail.php");
include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../libs/xmpphp/XMPPHP/XMPP.php');

function getUserFeeds($username = "", $userid = "", $sort = "") {
    if (empty($sort))
        $sort = "ORDER BY feedid DESC";

    if (!empty($userid))
        $addSQL = " WHERE uid=$userid ";

    if (!empty($userid) && !empty($username))
        $sql = "SELECT * FROM feeds $addSQL $sort";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["uid"]             = $sqlRow ["uid"];
        // $records[$idx]["keyid"] = $sqlRow["keyid"];
        $records [$idx] ["feedid"]          = $sqlRow ["feedid"];
        $records [$idx] ["name"]            = $sqlRow ["name"];
        $records [$idx] ["auto"]            = $sqlRow ["auto"];
        $records [$idx] ["active"]          = $sqlRow ["active"];
        $records [$idx] ["url"]             = $sqlRow ["url"];
        $records [$idx] ["parser_settings"] = $sqlRow ["parser_settings"];
        $records [$idx] ["filepath"]        = $sqlRow ["filepath"];
        $records [$idx] ["table_name"]      = $sqlRow ["table_name"];
        $records [$idx] ["create_date"]     = $sqlRow ["create_date"];
        $records [$idx] ["last_update"]     = $sqlRow ["last_update"];
        $records [$idx] ["logging"]         = $sqlRow ["logging"];
        ++$idx;
    }
    sqlFreeResult($res);

    if (isset($records))
        return $records;
}

function getUserFeed($username = "", $feedid = "", $sort = "") {
    if (!validateUsername($username)) {
        return false;
    }

    if (empty($sort)) {
        $sort = "ORDER BY feedid DESC";
    }

    $userid = getUserId($username);

    if (!empty($userid) && !empty($feedid)) {
        $addSQL = " WHERE uid=$userid AND feedid=$feedid";
    }

    if (!empty($userid) && !empty($username)) {
        $sql = "SELECT * FROM feeds $addSQL $sort";
    }

    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    }

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["uid"]             = $sqlRow ["uid"];
        // $records[$idx]["keyid"] = $sqlRow["keyid"];
        $records [$idx] ["feedid"]          = $sqlRow ["feedid"];
        $records [$idx] ["name"]            = $sqlRow ["name"];
        $records [$idx] ["auto"]            = $sqlRow ["auto"];
        $records [$idx] ["active"]          = $sqlRow ["active"];
        $records [$idx] ["url"]             = $sqlRow ["url"];
        $records [$idx] ["parser_settings"] = $sqlRow ["parser_settings"];
        $records [$idx] ["filepath"]        = $sqlRow ["filepath"];
        $records [$idx] ["table_name"]      = $sqlRow ["table_name"];
        $records [$idx] ["create_date"]     = $sqlRow ["create_date"];
        $records [$idx] ["last_update"]     = $sqlRow ["last_update"];
        $records [$idx] ["logging"]         = $sqlRow ["logging"];
        ++$idx;
    }
    sqlFreeResult($res);

    if (isset($records))
        return $records;
}

function getFeedLogs($username = "", $feedid = "", $sort = "") {
    if (!validateUsername($username))
        return false;

    if (empty($sort))
        $sort = "ORDER BY create_date ASC";
    else
        $sort = "ORDER BY create_date DESC";

    $addSQL = " WHERE feedid=$feedid";

    $sql = "SELECT * FROM feed_logs $addSQL $sort";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["logid"]       = $sqlRow ["logid"];
        $records [$idx] ["logmsg"]      = $sqlRow ["logmsg"];
        $records [$idx] ["create_date"] = $sqlRow ["create_date"];
        ++$idx;
    }
    sqlFreeResult($res);

    if (isset($records))
        return $records;

    return false;
}

function pushFeedLogs($feedid = "", $msg = "") {
    // $create_date = date("Y-m-d H:i:s");
    // Limit the inserted logs
    // Limitting the logs per feed to 100. This has to be done as procedure, but it works fine for now.
    if (checkLogLimitExceeded($feedid, 100))
        deleteFeedLogs($feedid);

    $sql = "INSERT INTO feed_logs (feedid,logmsg) VALUES (" . $feedid . ", '" . $msg . "')";

    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    $lastid = sqlLastInsert();

    return $lastid;
}

function deleteFeedLogs($feedid) {
    $sql = "DELETE FROM feed_logs WHERE feedid=" . $feedid . " ORDER BY create_date ASC LIMIT 1";

    sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    return true;
}

function checkLogLimitExceeded($feedid, $limit) {
    $sql = "SELECT logid FROM feed_logs WHERE feedid = " . $feedid;
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    if ($num >= $limit)
        return true;

    return false;
}

function checkIfLogging($feedid) {
    $sql = "SELECT logging FROM feeds WHERE logging = 1 AND feedid=" . $feedid;
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    if ($num > 0)
        return true;

    return false;
}

function checkIfLoggingAlarms($faid) {
    $sql = "SELECT logging FROM feed_alarms WHERE logging = 1 AND faid=" . $faid;
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    if ($num > 0)
        return true;

    return false;
}

/* * * Alarm, action and notification functions ** */

function checkAlarmDefined($feedid, $json_obj) {
    $metric = getAlarmMetric($json_obj);

    $sql = "SELECT * FROM feed_alarms WHERE active = 1 AND feedid=" . $feedid . " AND metric = '" . $metric . "'";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    sqlFreeResult($res);

    if ($num > 0)
        return true;

    return false;
}

function updateAlarm(\Dofthings\Classes\Request $req) {
    $p           = $req->getPostParams();
    $g           = $req->getGetParams();
    $create_date = date("Y-m-d H:i:s");
    $faid        = $g->faid;
    $atid        = $p->alarms_type;
    $name        = $p->alarms_label;
    $description = $p->alarms_description;
    $metricArray = explode('@', $p->alarms_metric);
    $feedid      = $metricArray [0];
    $metric      = $p->alarms_metric;
    $threshold   = $p->alarms_threshold;
    $sign        = $p->alarms_sign;
    $numeric     = empty($p->alarms_numeric) ? 0 : 1;
    $active      = empty($p->alarms_active) ? 0 : 1;
    $logging     = empty($p->alarms_logging) ? 0 : 1;
    $reset       = empty($p->alarms_reset) ? 0 : 1;

    // $sql = "INSERT INTO feed_alarms (atid,feedid,name,description,metric,active,threshold,asid,numericc,logging,reset,create_date) VALUES ('".$atid."', '".$feedid."', '".$name."', '".$description."', '".$metric."', '".$active."', '".$threshold."', '".$sign."', '".$numeric."', '".$logging."', '".$reset."', '".$create_date."' )";
    $sql = "UPDATE feed_alarms SET feedid = '" . $feedid . "', name = '" . $name . "', description = '" . $description . "', metric = '" . $metric . "', active = '" . $active . "', threshold = '" . $threshold . "', asid = '" . $sign . "', numericc = '" . $numeric . "', logging = '" . $logging . "', reset = '" . $reset . "' WHERE faid = '" . $faid . "'";

    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    createAlarmOfType($req, $faid);
    createAlarmNotification($req, $faid);
    createAlarmAction($req, $faid);

    return $faid;
}

function updateAlarmNotification($feedid, $json_obj) {
    $metric = $json_obj->FeedID . "@" . getFeedName($json_obj->FeedID) . "@" . $json_obj->deviceID . "@" . $json_obj->deviceName . "@" . $json_obj->objectType . "@" . $json_obj->objectName;
    $sql    = "SELECT * FROM feed_alarms WHERE active = 1 AND feedid=" . $feedid . " AND metric = '" . $metric . "'";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["faid"]        = $sqlRow ["faid"];
        $records [$idx] ["atid"]        = $sqlRow ["atid"];
        $records [$idx] ["type"]        = getFeedAlarmTypeName($sqlRow ["atid"]);
        $records [$idx] ["asid"]        = $sqlRow ["asid"];
        $records [$idx] ["signname"]    = getElement("alarm_signs", "sign", "asid", $sqlRow ["asid"]);
        $records [$idx] ["feedid"]      = $sqlRow ["feedid"];
        $records [$idx] ["name"]        = $sqlRow ["name"];
        $records [$idx] ["description"] = $sqlRow ["description"];
        $records [$idx] ["metric"]      = $sqlRow ["metric"];
        $records [$idx] ["threshold"]   = $sqlRow ["threshold"];
        $records [$idx] ["active"]      = $sqlRow ["active"];
        $records [$idx] ["numeric"]     = $sqlRow ["numericc"];
        $records [$idx] ["logging"]     = $sqlRow ["logging"];
        $records [$idx] ["last_update"] = $sqlRow ["last_update"];

        $faid        = $sqlRow ["faid"];
        $atid        = $sqlRow ["atid"];
        $name        = $sqlRow ["name"];
        $description = $sqlRow ["description"];
        $feedid      = $feedid;
        $metric      = $sqlRow ["metric"];
        $threshold   = $sqlRow ["threshold"];
        $sign        = $sqlRow ["asid"];
        $numeric     = $sqlRow ["numericc"];
        $active      = empty($sqlRow ["active"]) ? 0 : 1;
        $logging     = empty($sqlRow ["logging"]) ? 0 : 1;
        $reset       = empty($sqlRow ["reset"]) ? 0 : 1;

        updateAlarmNumericString($faid, $atid, $name, $description, $threshold, $sign, $reset, $numeric, $json_obj);
        ++$idx;
    }
    sqlFreeResult($res);

    return $sqlRow;
}

function updateAlarmNumericString($faid, $type, $name, $description, $threshold, $asid, $reset, $numeric, $json_obj) {
    $table = getFeedAlarmTable($type);
    $sql   = "SELECT * FROM $table WHERE faid=" . $faid;

    $res  = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num  = sqlNumRows($res);
    $value;
    $flag = 0;

    if ($type == 1) {
        // Once - Type1
        $sqlRow        = sqlFetchArray($res);
        $counttotalarm = $sqlRow ["count_to_alarm"];
        $curcount      = $sqlRow ["current_count"];
        $occured       = $sqlRow ["occured"];
        $value         = $json_obj->objectValue;

        if (isThresholdViolated($value, $threshold, $asid, $numeric)) {
            // Alarm and reset
            if ($reset) {
                // Resetting the count if reset is checked
                updateElementWhereValue($table, "faid", $faid, "current_count", "0");
                updateElementWhereValue($table, "faid", $faid, "occured", "0");
                $flag = 1;
            } elseif ($curcount + 1 >= $counttotalarm && $occured == 0) {
                updateElementWhereValue($table, "faid", $faid, "current_count", "0");
                updateElementWhereValue($table, "faid", $faid, "occured", "1");
                $flag = 1;
            } else {
                updateElementWhereValue($table, "faid", $faid, "current_count", $curcount + 1);
            }
        } else {
            // Resetting the count if threshold is lower
            updateElementWhereValue($table, "faid", $faid, "current_count", "0");
            updateElementWhereValue($table, "faid", $faid, "occured", "0");
        }
    } elseif ($type == 2) {
        // Period - Type2
        $now         = time();
        $timetoalarm = $sqlRow ["time_to_alarm"];
        $start       = $sqlRow ["start"];
        $value       = $json_obj->objectValue;

        if (isThresholdViolated($value, $threshold, $asid, $numeric)) {
            // Alarm and reset
            if ($reset) {
                updateElementWhereValue($table, "faid", $faid, "start", "0");
                updateElementWhereValue($table, "faid", $faid, "occured", "0");
                $flag = 1;
            } elseif ($start != 0 && $now - $start >= $timetoalarm && $occured == 0) {
                updateElementWhereValue($table, "faid", $faid, "start", "0");
                updateElementWhereValue($table, "faid", $faid, "occured", "1");
                $flag = 1;
            } else {
                updateElementWhereValue($table, "faid", $faid, "start", $now);
            }
        } else {
            // Resetting the count if threshold is lower
            updateElementWhereValue($table, "faid", $faid, "start", "0");
        }
    } elseif ($type == 3) {
        // Count - Type3
        $sqlRow        = sqlFetchArray($res);
        $counttotalarm = $sqlRow ["count_to_alarm"];
        $curcount      = $sqlRow ["current_count"];
        $occured       = $sqlRow ["occured"];
        $value         = $json_obj->objectValue;

        if (isThresholdViolated($value, $threshold, $asid, $numeric)) {
            // Alarm and reset
            if ($reset) {
                // Resetting the count if reset is checked
                updateElementWhereValue($table, "faid", $faid, "current_count", "0");
                updateElementWhereValue($table, "faid", $faid, "occured", "0");
                $flag = 1;
            } elseif ($curcount + 1 >= $counttotalarm && $occured == 0) {
                updateElementWhereValue($table, "faid", $faid, "current_count", "0");
                updateElementWhereValue($table, "faid", $faid, "occured", "1");
                $flag = 1;
            } else {
                updateElementWhereValue($table, "faid", $faid, "current_count", $curcount + 1);
            }
        } else {
            // Resetting the count if threshold is lower
            updateElementWhereValue($table, "faid", $faid, "current_count", "0");
            updateElementWhereValue($table, "faid", $faid, "occured", "0");
        }
    }

    if ($flag == 1) {
        insertNotification($faid, $name, $description, $value);
        insertAction($faid, $name, $description, $value);
    }

    sqlFreeResult($res);

    if ($num > 0)
        return true;

    return false;

    // return whether to notify and execute action or not
}

function isThresholdViolated($value, $threshold, $asid, $numeric) {
    switch (getThresholdSign($asid)) {

        case '=' :
            if ($numeric == 1) {
                if ($value == $threshold)
                    return true;
                else
                    return false;
            } else {
                if ("$value" == "$threshold")
                    return true;
                else
                    return false;
            }

            break;
        case '>' :
            if ($numeric == 1) {
                if ($value > $threshold)
                    return true;
                else
                    return false;
            } else {
                if ("$value" > "$threshold")
                    return true;
                else
                    return false;
            }

            break;
        case '<' :
            if ($numeric == 1) {
                if ($value < $threshold)
                    return true;
                else
                    return false;
            } else {
                if ("$value" < "$thrashold")
                    return true;
                else
                    return false;
            }

            break;
        case '!=' :
            if ($numeric) {
                if ($value != $threshold)
                    return true;
                else
                    return false;
            } else {
                if ("$value" != "$threshold")
                    return true;
                else
                    return false;
            }

            break;
        default :

            // Return false to undefined comparisons
            return false;
    }
}

function updateElement($table, $member, $value) {
    $sql = "UPDATE $table SET $member='" . $value . "'";
    $del = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    return true;
}

function updateElementWhereValue($table, $whereID, $whereVALUE, $member, $value) {
    $sql = "UPDATE $table SET $member='" . $value . "' WHERE " . $whereID . " = '" . $whereVALUE . "'";
    $del = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    return true;
}

function getElement($table, $member, $column, $value) {
    $sql = "SELECT $member FROM $table WHERE $column = '" . $value . "'";
    $num = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $res = sqlFetchRow($num);

    return $res ["0"];
}

function insertNotification($faid, $name, $description, $value) {
    $sql = "INSERT INTO notifications (faid,type,subject,address,message) VALUES ('" . $faid . "', (SELECT type FROM alarm_notif WHERE faid = '" . $faid . "'), '" . $name . "',  (SELECT address FROM alarm_notif WHERE faid = '" . $faid . "'), '" . $description . " Value: " . $value . "' )";

    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    $lastid = sqlLastInsert();

    return $lastid;
}

function insertAction($faid, $name, $description, $value) {
    $sql = "INSERT INTO actions (faid,type,path,value,user,pass) VALUES ('" . $faid . "', (SELECT type FROM alarm_action WHERE faid = '" . $faid . "'), (SELECT path FROM alarm_action WHERE faid = '" . $faid . "'), (SELECT value FROM alarm_action WHERE faid = '" . $faid . "'), (SELECT user FROM alarm_action WHERE faid = '" . $faid . "'), (SELECT pass FROM alarm_action WHERE faid = '" . $faid . "') )";

    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    $lastid = sqlLastInsert();

    return $lastid;
}

function notifyAlarm() {
    $records = getSiteEnvSettings();
    $sql     = "SELECT * FROM notifications WHERE sent = 0";
    $res     = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num     = sqlNumRows($res);

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $id        = $sqlRow ["id"];
        $type      = $sqlRow ["type"];
        $subject   = $sqlRow ["subject"];
        $to        = $sqlRow ["address"];
        $message   = $sqlRow ["message"];
        $fromName  = "dofthings notification system";
        $fromEmail = "$fromName <notify@dofthings.org>";
        $fromXMPP  = "notify@dofthings.org";

        if ($type == 1) {
            // EMAIL
            // sendEmail();
            sendEmail($to, $subject, $message, $fromEmail, $fromName, $records);
        } elseif ($type == 2) {
            // XMPP
            sendXMPP($to, $subject, $message, $fromXMPP, $fromName, $records);
        }

        updateElementWhereValue("notifications", "id", $id, "sent", "1");

        ++$idx;
    }

    sqlFreeResult($res);

    if ($num > 0)
        return $num;

    return 0;

    // return whether to notify and execute action or not
}

function actionAlarm() {
    $sql = "SELECT * FROM actions WHERE executed = 0";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $id    = $sqlRow ["id"];
        $type  = $sqlRow ["type"];
        $path  = $sqlRow ["path"];
        $value = $sqlRow ["value"];
        $user  = $sqlRow ["user"];
        $pass  = $sqlRow ["pass"];

        if ($type == 1) {
            // URL
            $ret = executeURL($path, $value, $user, $pass);
        } elseif ($type == 2) {
            // Local script
            $ret = executeScript($path, $value, $user, $pass);
        }

        // Remember that it has been executed and store the returned answer
        updateElementWhereValue("actions", "id", $id, "executed", "1");
        updateElementWhereValue("actions", "id", $id, "answer", "$ret");

        ++$idx;
    }

    sqlFreeResult($res);

    if ($num > 0)
        return $num;

    return 0;

    // return whether to notify and execute action or not
}

function executeURL($path, $value, $user, $pass) {
    $url  = $path;
    $data = array(
        'param' => $value
    );

    $auth = base64_encode("$user:$pass");

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n Authorization: Basic $auth",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context = stream_context_create($options);
    $result  = file_get_contents($url, false, $context);

    return print_r($result);
}

function executeScript($path, $value, $user, $pass) {
    // exec("nohup $path $value 2>&1", $output, $return);
    $output = shell_exec("nohup $path $value 2>&1");
    return "return: $output";
}

function getAlarmMetric($json_obj) {
    return $json_obj->FeedID . "@" . getFeedName($json_obj->FeedID) . "@" . $json_obj->deviceID . "@" . $json_obj->deviceName . "@" . $json_obj->objectType . "@" . $json_obj->objectName;
}

function getUserAlarms($username = "", $userid = "") {
    $addSQL = " WHERE feedid IN (SELECT feedid FROM feeds WHERE uid=$userid)";
    $sql    = "SELECT * FROM feed_alarms $addSQL";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["faid"]        = $sqlRow ["faid"];
        $records [$idx] ["atid"]        = $sqlRow ["atid"];
        $records [$idx] ["type"]        = getFeedAlarmTypeName($sqlRow ["atid"]);
        $records [$idx] ["asid"]        = $sqlRow ["asid"];
        $records [$idx] ["signname"]    = getElement("alarm_signs", "sign", "asid", $sqlRow ["asid"]);
        $records [$idx] ["feedid"]      = $sqlRow ["feedid"];
        $records [$idx] ["name"]        = $sqlRow ["name"];
        $records [$idx] ["description"] = $sqlRow ["description"];
        $records [$idx] ["metric"]      = $sqlRow ["metric"];
        $records [$idx] ["threshold"]   = $sqlRow ["threshold"];
        $records [$idx] ["active"]      = $sqlRow ["active"];
        $records [$idx] ["numeric"]     = $sqlRow ["numericc"];
        $records [$idx] ["logging"]     = $sqlRow ["logging"];
        $records [$idx] ["last_update"] = $sqlRow ["last_update"];

        ++$idx;
    }
    sqlFreeResult($res);

    if (isset($records))
        return $records;
}

function getUserAlarm($faid = "") {
    $sql = "SELECT * FROM feed_alarms WHERE faid = '" . $faid . "'";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["faid"]        = $sqlRow ["faid"];
        $records [$idx] ["atid"]        = $sqlRow ["atid"];
        $records [$idx] ["type"]        = getFeedAlarmTypeName($sqlRow ["atid"]);
        $records [$idx] ["asid"]        = $sqlRow ["asid"];
        $records [$idx] ["signname"]    = getElement("alarm_signs", "sign", "asid", $sqlRow ["asid"]);
        $records [$idx] ["feedid"]      = $sqlRow ["feedid"];
        $records [$idx] ["name"]        = $sqlRow ["name"];
        $records [$idx] ["description"] = $sqlRow ["description"];
        $records [$idx] ["metric"]      = $sqlRow ["metric"];
        $records [$idx] ["threshold"]   = $sqlRow ["threshold"];
        $records [$idx] ["active"]      = $sqlRow ["active"];
        $records [$idx] ["numeric"]     = $sqlRow ["numericc"];
        $records [$idx] ["logging"]     = $sqlRow ["logging"];
        $records [$idx] ["reset"]       = $sqlRow ["reset"];
        $records [$idx] ["last_update"] = $sqlRow ["last_update"];
        // Alarm type fields
        // getFeedAlarmTable($sqlRow["atid"])
        if ($sqlRow ["atid"] == 2) {
            $records [$idx] ["timetoalarm"] = getElement(getFeedAlarmTable($sqlRow ["atid"]), "time_to_alarm", "faid", $sqlRow ["faid"]);
        } elseif ($sqlRow ["atid"] == 3) {
            $records [$idx] ["counttoalarm"] = getElement(getFeedAlarmTable($sqlRow ["atid"]), "count_to_alarm", "faid", $sqlRow ["faid"]);
        }

        // Notification fields
        $records [$idx] ["notiftype"]    = getElement("alarm_notif", "type", "faid", $sqlRow ["faid"]);
        $records [$idx] ["notifaddress"] = getElement("alarm_notif", "address", "faid", $sqlRow ["faid"]);

        // Action fields
        $records [$idx] ["actiontype"]   = getElement("alarm_action", "type", "faid", $sqlRow ["faid"]);
        $records [$idx] ["actionpath"]   = getElement("alarm_action", "path", "faid", $sqlRow ["faid"]);
        $records [$idx] ["actionvalue"]  = getElement("alarm_action", "value", "faid", $sqlRow ["faid"]);
        $records [$idx] ["actionuser"]   = getElement("alarm_action", "user", "faid", $sqlRow ["faid"]);
        $records [$idx] ["actionpass"]   = getElement("alarm_action", "pass", "faid", $sqlRow ["faid"]);
        $records [$idx] ["notifaddress"] = getElement("alarm_notif", "address", "faid", $sqlRow ["faid"]);

        ++$idx;
    }

    sqlFreeResult($res);

    if (isset($records))
        return $records;
}

function getUserAlarmsCount($username = "", $userid = "") {
    $addSQL = " WHERE feedid IN (SELECT feedid FROM feeds WHERE uid=$userid)";
    $sql    = "SELECT * FROM feed_alarms $addSQL";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);
    ;

    sqlFreeResult($res);

    if (isset($num))
        return $num;
}

function getAlarmTypes() {
    $sql = "SELECT * FROM alarm_types";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["atid"]        = $sqlRow ["atid"];
        $records [$idx] ["name"]        = $sqlRow ["name"];
        $records [$idx] ["description"] = $sqlRow ["description"];
        $records [$idx] ["table"]       = $sqlRow ["atypetable"];

        ++$idx;
    }
    sqlFreeResult($res);

    if (isset($records))
        return $records;
}

function createAlarm(\Dofthings\Classes\Request $req) {
    $p           = $req->getPostParams();
    $create_date = date("Y-m-d H:i:s");
    $atid        = $p->alarms_type;
    $name        = $p->alarms_label;
    $description = $p->alarms_description;
    $metricArray = explode('@', $p->alarms_metric);
    $feedid      = $metricArray [0];
    $metric      = $p->alarms_metric;
    $threshold   = $p->alarms_threshold;
    $sign        = $p->alarms_sign;
    $numeric     = $p->alarms_numeric;
    $active      = empty($p->alarms_active) ? 0 : 1;
    $logging     = empty($p->alarms_logging) ? 0 : 1;
    $reset       = empty($p->alarms_reset) ? 0 : 1;

    $sql = "INSERT INTO feed_alarms (atid,feedid,name,description,metric,active,threshold,asid,numericc,logging,reset,create_date) VALUES ('" . $atid . "', '" . $feedid . "', '" . $name . "', '" . $description . "', '" . $metric . "', '" . $active . "', '" . $threshold . "', '" . $sign . "', '" . $numeric . "', '" . $logging . "', '" . $reset . "', '" . $create_date . "' )";

    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    // Get faid - Feed Alarm ID
    $lastid = sqlLastInsert();

    createAlarmOfType($req, $lastid);
    createAlarmNotification($req, $lastid);
    createAlarmAction($req, $lastid);

    return $lastid;
}

function createAlarmOfType(\Dofthings\Classes\Request $req, $faid) {
    $p      = $req->getPostParams();
    $atid   = $p->alarms_type;
    $table  = getFeedAlarmTable($atid);
    $update = false;

    // Whether update or create - Updating is realted with reseting the current working fields
    if (getElement($table, "faid", "faid", $faid) == $faid)
        $update = true;

    if ($atid == 1) {
        // Once
        if (!$update)
            $sql = "INSERT INTO $table (faid,count_to_alarm,current_count) VALUES (" . $faid . ", '1', '0')";
        else
            $sql = "UPDATE $table SET count_to_alarm = 1, current_count = 0 WHERE faid = '" . $faid . "'";
    } elseif ($atid == 2) {
        $time = $p->alarms_timetoalarm;
        // Period - set start to 0 this means that it is reseted
        if (!$update)
            $sql  = "INSERT INTO $table (faid,time_to_alarm,start) VALUES (" . $faid . ", '" . $time . "', '0')";
        else
            $sql  = "UPDATE $table SET time_to_alarm = '" . $time . "', start = 0 WHERE faid = '" . $faid . "'";
    } elseif ($atid == 3) {
        // Count
        $count = $p->alarms_counttoalarm;
        if (!$update)
            $sql   = "INSERT INTO $table (faid,count_to_alarm,current_count) VALUES (" . $faid . ", '" . $count . "', '0')";
        else
            $sql   = "UPDATE $table SET count_to_alarm = '" . $count . "', current_count = 0 WHERE faid = '" . $faid . "'";
    }

    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return array(
            false,
            false
        );
    }

    $lastid = sqlLastInsert();

    return $lastid;
}

function createAlarmNotification(\Dofthings\Classes\Request $req, $faid) {
    $p            = $req->getPostParams();
    $notiftype    = $p->alarms_notiftype;
    $notifaddress = $p->alarms_notifaddress;
    $update       = false;

    if (getElement("alarm_notif", "faid", "faid", $faid) == $faid)
        $update = true;

    // None Alarm notification
    if ($notiftype == 0)
        return 0;

    if (!$update)
        $sql = "INSERT INTO alarm_notif (faid,type,address) VALUES (" . $faid . ", '" . $notiftype . "', '" . $notifaddress . "')";
    else
        $sql = "UPDATE alarm_notif SET type = '" . $notiftype . "', address = '" . $notifaddress . "' WHERE faid = '" . $faid . "'";

    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return array(
            false,
            false
        );
    }

    // Get faid - Feed Alarm ID
    $lastid = sqlLastInsert();

    return $lastid;
}

function createAlarmAction(\Dofthings\Classes\Request $req, $faid) {
    $p           = $req->getPostParams();
    $actiontype  = $p->alarms_actiontype;
    $actionpath  = $p->alarms_actionpath;
    $actionvalue = empty($p->alarms_actionvalue) ? null : $p->alarms_actionvalue;
    $actionuser  = empty($p->alarms_user) ? null : $p->actionvalue;
    $actionpass  = empty($p->alarms_pass) ? null : $p->actionvalue;
    $update      = false;

    // None Alarm action
    if ($actiontype == 0)
        return 0;

    if (getElement("alarm_action", "faid", "faid", $faid) == $faid)
        $update = true;

    if (!$update)
        $sql = "INSERT INTO alarm_action (faid,type,path,value,user,pass) VALUES (" . $faid . ", '" . $actiontype . "', '" . $actionpath . "', '" . $actionvalue . "', '" . $actionuser . "', '" . $actionpass . "')";
    else
        $sql = "UPDATE alarm_action SET type = '" . $actiontype . "', path = '" . $actionpath . "', value =  '" . $actionvalue . "', user = '" . $actionuser . "', pass = '" . $actionpass . "' WHERE faid = '" . $faid . "'";

    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return array(
            false,
            false
        );
    }

    // Get faid - Feed Alarm ID
    $lastid = sqlLastInsert();

    return $lastid;
}

function getAlarmActionsLogs($username = "", $faid = "", $sort = "") {
    if (!validateUsername($username))
        return false;

    if (empty($sort))
        $sort = "ORDER BY last_update ASC";
    else
        $sort = "ORDER BY last_update DESC";

    $addSQL = " WHERE faid=$faid AND executed=1";

    $sql = "SELECT * FROM actions $addSQL $sort";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["id"]          = $sqlRow ["id"];
        $records [$idx] ["path"]        = $sqlRow ["path"];
        $records [$idx] ["last_update"] = $sqlRow ["last_update"];
        $records [$idx] ["answer"]      = $sqlRow ["answer"];
        ++$idx;
    }
    sqlFreeResult($res);

    if (isset($records))
        return $records;

    return false;
}

function getAlarmNotificationsLogs($username = "", $faid = "", $sort = "") {
    if (!validateUsername($username))
        return false;

    if (empty($sort))
        $sort = "ORDER BY last_update ASC";
    else
        $sort = "ORDER BY last_update DESC";

    $addSQL = " WHERE faid=$faid AND sent=1";

    $sql = "SELECT * FROM notifications $addSQL $sort";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["id"]          = $sqlRow ["id"];
        $records [$idx] ["subject"]     = $sqlRow ["subject"];
        $records [$idx] ["address"]     = $sqlRow ["address"];
        $records [$idx] ["type"]        = $sqlRow ["type"] == 1 ? "EMAIL" : "XMPP";
        $records [$idx] ["message"]     = $sqlRow ["message"];
        $records [$idx] ["last_update"] = $sqlRow ["last_update"];
        ++$idx;
    }
    sqlFreeResult($res);

    if (isset($records))
        return $records;

    return false;
}

function getFeedAlarmTable($id) {
    $sql = "SELECT atypetable FROM alarm_types WHERE atid = '" . $id . "'";
    $num = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $res = sqlFetchRow($num);

    return $res ["0"];
}

function getFeedAlarmTypeName($id) {
    $sql = "SELECT name FROM alarm_types WHERE atid = '" . $id . "'";
    $num = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $res = sqlFetchRow($num);

    return $res ["0"];
}

function getThresholdSign($id) {
    $sql = "SELECT sign FROM alarm_signs WHERE asid = '" . $id . "'";
    $num = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $res = sqlFetchRow($num);

    return $res ["0"];
}

function deleteAlarm(\Dofthings\Classes\Request $req) {
    $g    = $req->getGetParams();
    $faid = $g->faid;

    $sql = "DELETE FROM feed_alarms WHERE faid=" . $faid;
    $del = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    return true;
}

function activateAlarm(\Dofthings\Classes\Request $req, $activate) {
    $g    = $req->getGetParams();
    $faid = $g->faid;

    $sql = "UPDATE feed_alarms SET active=" . $activate . "  WHERE faid=" . $faid;
    $del = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    return true;
}

/* * * Mail functions ** */

function sendEmail($ToEmail, $Subject, $Body, $FromEmail, $FromName, $records) {
    error_reporting(E_ALL ^ E_STRICT);

    $ver  = floatval(phpversion());
    $Body = preg_replace("!<br \/>!", "\n", $Body);

    if (empty($records)) {
        echo "ErrorMAIL\n";
        return;
    }

    /*
     * $headers = '';
     * $headers .="Content-Type: text/plain; charset=\"UTF-8\"\n";
     * $headers .="From: $From <$FromEmail>\n";
     * $headers .="Reply-To: <$FromEmail>\n";
     * $headers .="Return-Path: <$FromEmail> \n";
     * $headers .="X-Sender: <$FromEmail>\n";
     * $headers .="X-Mailer: PHP-$ver \n";
     * $headers .="X-Priority: 3\n"; //1 UrgentMessage, 3 Normal
     */

    $headers ['From']    = $FromEmail;
    $headers ['To']      = $ToEmail;
    $headers ['Subject'] = $Subject;

    $smtpinfo ["host"]     = $records ["smtpserver"];
    $smtpinfo ["port"]     = $records ["smtpport"];
    $smtpinfo ["auth"]     = true;
    $smtpinfo ["username"] = $records ["smtpuser"];
    $smtpinfo ["password"] = $records ["smtppass"];

    // Create the mail object using the Mail::factory method
    $mail_object = Mail::factory("smtp", $smtpinfo);

    $mail_object->send($ToEmail, $headers, $Body);

    if (PEAR::isError($mail_object)) {
        echo ("Error");
    }

    // mail uses sendmail_path in php.ini
    // mail($ToEmail,$Subject,wordwrap($Body),$headers);
}

function sendXMPP($to, $subj, $body, $from, $fromEmail, $records) {
    error_reporting(E_ALL ^ E_ALL);

    $body = preg_replace("!<br \/>!", "\n", $body);

    if (empty($records)) {
        echo "ErrorXMPP\n";
        return;
    }

    $server = $records ["xmppserver"];
    $port   = $records ["xmppport"];
    $user   = $records ["xmppuser"];
    $pass   = $records ["xmpppass"];
    $text   = $records ["xmppptext"];
    $domain = $records ["xmpppdomain"];

    $conn     = new XMPPHP_XMPP($server, $port, $user, $pass, $text, $domain, $printlog = True, $loglevel = LOGGING_INFO);
    $conn->connect();
    $conn->processUntil('session_start');
    $conn->presence($status   = 'Controller available.');
    $conn->processTime(2); // Timeout
    $conn->message($to, "From: $from \n Subject: $subj \n Message: $body");
    $conn->disconnect();
}

function getFeedName($feed_id) {
    $sql = "SELECT name FROM feeds WHERE feedid = " . $feed_id;
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    // if cannot get anything back; croak and die
    if ($sqlRow = sqlFetchArray($res)) {
        return $sqlRow ["name"];
    } else {
        return false;
    }
}

function getUserFeedsCount($username = "", $userid = "", $sort = "") {
    if (empty($sort))
        $sort = "ORDER BY feedid DESC";

    if (!empty($userid))
        $addSQL = " WHERE uid=$userid ";

    if (!empty($userid) && !empty($username))
        $sql = "SELECT * FROM feeds $addSQL $sort";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);
    ;

    sqlFreeResult($res);

    if (isset($num))
        return $num;
}

function getUserDashboard($username = "", $userid = "", $dashid = "") {
    if (!empty($userid))
        $addSQL = " WHERE uid=$userid AND dashid=$dashid";

    if (!empty($userid) && !empty($username))
        $sql = "SELECT * FROM dashboards $addSQL";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["dashid"]      = $sqlRow ["dashid"];
        $records [$idx] ["uid"]         = $sqlRow ["uid"];
        $records [$idx] ["config"]      = $sqlRow ["config"];
        $records [$idx] ["share"]       = $sqlRow ["share"];
        $records [$idx] ["zoom"]        = $sqlRow ["zoom"];
        $records [$idx] ["resolution"]  = $sqlRow ["resolution"];
        $records [$idx] ["background"]  = $sqlRow ["background"];
        $records [$idx] ["description"] = $sqlRow ["description"];
        $records [$idx] ["move"]        = $sqlRow ["move"];
        $records [$idx] ["style"]       = $sqlRow ["style"];
        $records [$idx] ["name"]        = $sqlRow ["name"];
        $records [$idx] ["active"]      = $sqlRow ["active"];
        $records [$idx] ["create_date"] = $sqlRow ["create_date"];
        $records [$idx] ["last_update"] = $sqlRow ["last_update"];

        ++$idx;
    }
    sqlFreeResult($res);

    if (isset($records))
        return $records [0]; // Return only first result
}

function getUserDashboards($username = "", $userid = "", $sort = "") {
    if (empty($sort))
        $sort = "ORDER BY dashid DESC";

    if (!empty($userid))
        $addSQL = " WHERE uid=$userid ";

    if (!empty($userid) && !empty($username))
        $sql = "SELECT * FROM dashboards $addSQL $sort";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["dashid"]      = $sqlRow ["dashid"];
        $records [$idx] ["uid"]         = $sqlRow ["uid"];
        $records [$idx] ["name"]        = $sqlRow ["name"];
        $records [$idx] ["active"]      = $sqlRow ["active"];
        $records [$idx] ["create_date"] = $sqlRow ["create_date"];
        $records [$idx] ["last_update"] = $sqlRow ["last_update"];
        ++$idx;
    }
    sqlFreeResult($res);

    if (isset($records))
        return $records;
}

function getUserDashboardsCount($username = "", $userid = "", $sort = "") {
    if (empty($sort))
        $sort = "ORDER BY dashid DESC";

    if (!empty($userid))
        $addSQL = " WHERE uid=$userid ";

    if (!empty($userid) && !empty($username))
        $sql = "SELECT * FROM dashboards $addSQL $sort";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);
    ;

    sqlFreeResult($res);

    if (isset($num))
        return $num;
}

function getDashboardById($userid = "", $dashid = "", $sort = "") {
    if (empty($sort))
        $sort = "ORDER BY dashid DESC";

    if (!empty($userid))
        $addSQL = " WHERE uid=$userid AND dashid=$dashid AND active=1";
    else
        $addSQL = " WHERE share=1 AND dashid=$dashid AND active=1";

    $sql = "SELECT * FROM dashboards $addSQL $sort";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["dashid"]      = $sqlRow ["dashid"];
        $records [$idx] ["uid"]         = $sqlRow ["uid"];
        $records [$idx] ["config"]      = $sqlRow ["config"];
        $records [$idx] ["share"]       = $sqlRow ["share"];
        $records [$idx] ["zoom"]        = $sqlRow ["zoom"];
        $records [$idx] ["create_date"] = $sqlRow ["create_date"];
        $records [$idx] ["last_update"] = $sqlRow ["last_update"];
        $records [$idx] ["resolution"]  = $sqlRow ["resolution"];
        $records [$idx] ["background"]  = $sqlRow ["background"];
        $records [$idx] ["description"] = $sqlRow ["description"];
        $records [$idx] ["name"]        = $sqlRow ["name"];
        $records [$idx] ["move"]        = $sqlRow ["move"];
        $records [$idx] ["style"]       = $sqlRow ["style"];
        $records [$idx] ["active"]      = $sqlRow ["active"];
        ++$idx;
    }
    sqlFreeResult($res);

    if (isset($records))
        return $records;
}

function createFeed($user, $feeds_name, $feeds_parser, $feeds_logging, $feeds_auto) {
    if (!validateFeedName($feeds_name))
        return false;

    $create_date = date("Y-m-d H:i:s");

    // $feeds_url = generetaeURLFeed($lastid);
    $feeds_url      = "https://";
    $feeds_filepath = "/" . $feeds_name . ".0";
    $feeds_table    = $feeds_name . ".0";

    $sql = "INSERT INTO feeds (uid,name,auto,url,parser_settings,filepath,table_name,create_date,logging) VALUES ( (select uid from users where user='" . $user . "'), '" . $feeds_name . "', " . $feeds_auto . ", '" . $feeds_url . "', '" . $feeds_parser . "', '" . $feeds_filepath . "', '" . $feeds_table . "', '" . $create_date . "', '" . $feeds_logging . "')";

    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    $lastid = sqlLastInsert();

    $feeds_filepath = "/" . $feeds_name . "." . $lastid;
    $feeds_table    = $feeds_name . "_" . $lastid;

    // perform sqlQuery and update feeds info in the database
    $sql = "UPDATE feeds SET filepath = '" . $feeds_filepath . "', table_name='" . $feeds_table . "' WHERE feedid = '" . $lastid . "'";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    return $lastid;
}

function deleteFeedId($user, $feeds_feedid) {
    if (!validateUsername($user))
        return false;
    // if(!validateFeedId($feeds_feedid)) return false;

    $sql = "DELETE FROM feeds WHERE uid = (select uid from users WHERE user='" . $user . "') AND feedid=" . $feeds_feedid;
    $del = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    return true;
}

function createFeedsKey($user, $keys_feedid, $keys_label, $active, $perms, $push_sourceip, $pull_sourceip, $execute_sourceip) {
    if (!validateUserName($user))
        return false;
    if (!validateFeedKeyName($keys_label))
        return false;

    $date = date("Y-m-d H:i:s");

    $string = "" . $user . "-" . $keys_label . "-" . $keys_feedid . "-" . $date;
    $hash   = hash('sha256', $string);

    $sql = "INSERT INTO feed_keys (uid,feedid,label,keyhash,create_date,active,perms,push_source_ip,pull_source_ip,execute_source_ip) VALUES ( (select uid from users where user='" . $user . "'), " . $keys_feedid . ", '" . $keys_label . "', '" . $hash . "', '" . $date . "', " . $active . ", " . $perms . ", '" . ipConvertLong($push_sourceip) . "', '" . ipConvertLong($pull_sourceip) . "', '" . ipConvertLong($execute_sourceip) . "')";

    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    $lastid = sqlLastInsert();

    return "_____" . $lastid . "_" . $sql . "___________";
}

function updateFeed($user, $feeds_feedid, $feeds_name, $logging, $auto) {
    if (!validateUsername($user))
        return false;
    if (!validateFeedName($feeds_name))
        return false;

    $sql = "UPDATE feeds SET name='" . $feeds_name . "', auto=" . $auto . ", logging=" . $logging . " WHERE uid = (select uid from users WHERE user='" . $user . "') AND feedid=" . $feeds_feedid;
    $del = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    return true;
}

function updateFeedsKey($user, $keys_keyid, $keys_label, $active, $perms, $push_sourceip, $pull_sourceip, $execute_sourceip) {
    if (!validateUsername($user))
        return false;
    if (!validateFeedKeyName($keys_label))
        return false;

    $sql = "UPDATE feed_keys SET label='" . $keys_label . "', active=" . $active . ", perms=" . $perms . ", push_source_ip='" . ipConvertLong($push_sourceip) . "', pull_source_ip='" . ipConvertLong($pull_sourceip) . "', execute_source_ip='" . ipConvertLong($execute_sourceip) . "' WHERE uid = (select uid from users WHERE user='" . $user . "') AND keyid=" . $keys_keyid;
    $del = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    return true;
}

function deleteFeedKeyId($user, $keys_keyid) {
    if (!validateUsername($user))
        return false;
    // if(!validateFeedId($feeds_feedid)) return false;

    $sql = "DELETE FROM feed_keys WHERE uid = (select uid from users WHERE user='" . $user . "') AND keyid=" . $keys_keyid;
    $del = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    return true;
}

function activateFeedId($user, $feeds_feedid, $activate) {
    if (!validateUsername($user))
        return false;
    // if(!validateFeedId($feeds_feedid)) return false;

    $sql = "UPDATE feeds SET active=" . $activate . "  WHERE uid = (select uid from users WHERE user='" . $user . "') AND feedid=" . $feeds_feedid;
    $del = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    return true;
}

function activateKeyFeedId($user, $keyid, $activate) {
    if (!validateUsername($user))
        return false;
    // if(!validateFeedId($feeds_feedid)) return false;

    $sql = "UPDATE feed_keys SET active=" . $activate . "  WHERE uid = (select uid from users WHERE user='" . $user . "') AND keyid=" . $keyid;
    $del = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    return true;
}

function generateFeedKey($user, $feeds_name, $feeds_feedid) {
    if (!validateUsername($user))
        return false;
    if (!validateFeedName($feeds_name))
        return false;

    $date = date("Y-m-d H:i:s");

    $string = "" . $user . "-" . $feeds_name . "-" . $feeds_feedid . "-" . $date;
    $hash   = hash('sha256', $string);
    $label  = "Autogenerated.$feeds_name.$feeds_feedid";

    $sql = "INSERT INTO feed_keys (uid,feedid,label,keyhash,create_date) VALUES ( (select uid from users where user='" . $user . "'), " . $feeds_feedid . ", '" . $label . "', '" . $hash . "', '" . $date . "')";

    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    $lastid = sqlLastInsert();

    // perform sqlQuery and update feeds info in the database
    // $sql = "UPDATE feeds SET filepath = '" . $feeds_filepath . "', table_name='" . $feeds_table ."' WHERE feedid = '" . $lastid . "'";

    return $lastid;
}

function activateDashboardId($user, $dashboards_dashid, $activate) {
    if (!validateUsername($user))
        return false;

    $sql = "UPDATE dashboards SET active=" . $activate . "  WHERE uid = (select uid from users WHERE user='" . $user . "') AND dashid=" . $dashboards_dashid;
    $del = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    return true;
}

function deleteDashboardId($user, $dashboards_dashid) {
    if (!validateUsername($user))
        return false;

    $sql = "DELETE FROM dashboards WHERE uid = (select uid from users WHERE user='" . $user . "') AND dashid=" . $dashboards_dashid;
    $del = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    return true;
}

function getUserFeedsKeys($username = "", $userid = "", $sort = "") {
    if (!validateUsername($username))
        return false;

    if (empty($sort))
        $sort = "ORDER BY feedid DESC";

    if (!empty($userid))
        $addSQL = " WHERE uid=$userid ";

    if (!empty($userid) && !empty($username))
        $sql = "SELECT * FROM feed_keys $addSQL $sort";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["uid"]               = $sqlRow ["uid"];
        $records [$idx] ["keyid"]             = $sqlRow ["keyid"];
        $records [$idx] ["feedid"]            = $sqlRow ["feedid"];
        $records [$idx] ["label"]             = $sqlRow ["label"];
        $records [$idx] ["keyhash"]           = $sqlRow ["keyhash"];
        $records [$idx] ["push_source_ip"]    = $sqlRow ["push_source_ip"];
        $records [$idx] ["pull_source_ip"]    = $sqlRow ["pull_source_ip"];
        $records [$idx] ["execute_source_ip"] = $sqlRow ["execute_source_ip"];
        $records [$idx] ["perms"]             = $sqlRow ["perms"];
        $records [$idx] ["active"]            = $sqlRow ["active"];
        $records [$idx] ["last_update"]       = $sqlRow ["last_update"];
        $records [$idx] ["feed_name"]         = getFeedName($sqlRow ["feedid"]);
        ++$idx;
    }
    sqlFreeResult($res);

    if (isset($records))
        return $records;
}

function getUserFeedsKeysCount($username = "", $userid = "", $sort = "") {
    if (!validateUsername($username))
        return false;

    if (empty($sort))
        $sort = "ORDER BY feedid DESC";

    if (!empty($userid))
        $addSQL = " WHERE uid=$userid ";

    if (!empty($userid) && !empty($username))
        $sql = "SELECT * FROM feed_keys $addSQL $sort";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);
    ;

    sqlFreeResult($res);

    if (isset($num))
        return $num;
}

function getFeedKey($username = "", $keyid = "", $sort = "") {
    if (!validateUsername($username))
        return false;

    if (empty($sort))
        $sort = "ORDER BY keyid DESC";

    $userid = getUserId($username);

    if (!empty($userid) && !empty($keyid))
        $addSQL = " WHERE uid=$userid AND keyid=$keyid";

    if (!empty($userid) && !empty($username))
        $sql = "SELECT * FROM feed_keys $addSQL $sort";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["uid"]               = $sqlRow ["uid"];
        $records [$idx] ["keyid"]             = $sqlRow ["keyid"];
        $records [$idx] ["feedid"]            = $sqlRow ["feedid"];
        $records [$idx] ["label"]             = $sqlRow ["label"];
        $records [$idx] ["keyhash"]           = $sqlRow ["keyhash"];
        $records [$idx] ["push_source_ip"]    = $sqlRow ["push_source_ip"];
        $records [$idx] ["pull_source_ip"]    = $sqlRow ["pull_source_ip"];
        $records [$idx] ["execute_source_ip"] = $sqlRow ["execute_source_ip"];
        $records [$idx] ["perms"]             = $sqlRow ["perms"];
        $records [$idx] ["active"]            = $sqlRow ["active"];
        $records [$idx] ["last_update"]       = $sqlRow ["last_update"];
        $records [$idx] ["feed_name"]         = getFeedName($sqlRow ["feedid"]);
        ++$idx;
    }

    sqlFreeResult($res);

    if (isset($records))
        return $records;
}

function substitueSpecialKeys($bad_string) {
    // prep file for db and gd manipulation
    $bad_char_arr     = array(
        ' ',
        '&',
        '(',
        ')',
        '*',
        '[',
        ']',
        '<',
        '>',
        '{',
        '}'
    );
    $replace_char_arr = array(
        '_',
        '_',
        '_',
        '_',
        '_',
        '_',
        '_',
        '_',
        '_',
        '_',
        '_'
    );
    $good_string      = str_replace($bad_char_arr, $replace_char_arr, $bad_string);
}

function validateFeedName($feed_name) {
    $first = substr($feed_name, 0, 1);
    if ($first == '.' || $first == '-' || $first == '_') {
        return false;
    }

    if (preg_match('!^[a-zA-Z0-9._]{1,119}$!', $feed_name))
        return true;
    return false;
}

function validateFeedKeyName($key_label) {
    $first = substr($key_label, 0, 1);
    if ($first == '.' || $first == '-' || $first == '_') {
        return false;
    }

    if (preg_match('!^[a-zA-Z0-9._]{1,119}$!', $key_label))
        return true;
    return false;
}

function validateFeedId($feedid) {
    if (preg_match('!^[0-9]{1,119}$!', $feedid))
        return true;
    return false;
}

function checkRemoteActionPerms($keyhash, $request_ip_perm) {
    $ipaddress = getenv('REMOTE_ADDR');

    $column = $request_ip_perm . "_source_ip";

    $sql = "SELECT $column FROM feed_keys WHERE keyhash = '" . $keyhash . "' AND active = 1 AND ($column REGEXP '" . $ipaddress . "' OR $column='ALL')";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    if ($num > 0)
        return true;

    return false;
}

function checkFeedsKeyHash($keyhash) {
    if (!validateKeyHash($keyhash))
        return false;

    $sql = "SELECT keyhash FROM feed_keys WHERE keyhash = '" . $keyhash . "' AND active = 1";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    if ($num > 0)
        return true;

    return false;
}

function checkFeedId($feedid) {
    if (!validateFeedId($feedid))
        return false;

    $sql = "SELECT feedid FROM feeds WHERE feedid = " . $feedid . " AND active = 1";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    if ($num > 0)
        return true;

    return false;
}

function checkUserId($userid) {
    $sql = "SELECT uid FROM users WHERE uid = " . $userid;
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    if ($num > 0)
        return true;

    return false;
}

function checkMappingFeedKeyHash($feedid, $keyhash) {
    if (!validateKeyHash($keyhash)) {
        return false;
    }
    if (!validateFeedId($feedid))
        return false;

    $sql = "SELECT feedid FROM feeds WHERE feedid = (SELECT feedid FROM feed_keys WHERE keyhash='" . $keyhash . "' AND active = 1 AND feedid = " . $feedid . ") AND active = 1";
    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    }
    $num = sqlNumRows($res);

    if ($num > 0)
        return true;

    return false;
}

function getKeyHashPerms($keyhash) {
    if (!validateKeyHash($keyhash))
        return false;

    $sql = "SELECT perms FROM feed_keys WHERE keyhash = '" . $keyhash . "' AND active = 1";
    $num = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $res = sqlFetchRow($num);

    return $res ["0"];
}

function getAllFeedsByUserId($userid) {
    $sql = "SELECT feeds.table_name,feeds.name,feeds.feedid,feed_keys.keyhash from feeds,feed_keys WHERE feeds.feedid=feed_keys.feedid AND feeds.uid=" . $userid . " GROUP BY feeds.name";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["table_name"] = $sqlRow ["table_name"];
        $records [$idx] ["feed"]       = $sqlRow ["name"];
        $records [$idx] ["feedid"]     = $sqlRow ["feedid"];
        $records [$idx] ["keyhash"]    = $sqlRow ["keyhash"];
        ++$idx;
    }
    if (isset($records))
        return $records;

    return null;
}

function getUserProfile($userid = "") {
    if (empty($userid))
        return false;

    $addSQL = " WHERE uid=$userid ";
    $sql    = "SELECT * FROM users $addSQL";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $sqlRow = sqlFetchArray($res);

    $records ["uid"]         = $sqlRow ["uid"];
    $records ["ipaddress"]   = $sqlRow ["ipaddress"];
    $records ["user"]        = $sqlRow ["user"];
    $records ["pass"]        = "********"; // 8 stars ******** compare with this when submitting
    $records ["email"]       = $sqlRow ["email"];
    $records ["fname"]       = $sqlRow ["first_name"];
    $records ["lname"]       = $sqlRow ["last_name"];
    $records ["phone"]       = $sqlRow ["phone"];
    $records ["address"]     = $sqlRow ["address"];
    $records ["city"]        = $sqlRow ["city"];
    $records ["reg_date"]    = $sqlRow ["reg_date"];
    $records ["last_active"] = $sqlRow ["last_active"];
    $records ["role"]        = $sqlRow ["role"];
    $records ["activated"]   = $sqlRow ["activated"];
    $records ["approved"]    = $sqlRow ["approved"];
    $records ["notes"]       = $sqlRow ["notes"];
    $records ["image"]       = $sqlRow ["image"];

    sqlFreeResult($res);

    if (isset($records))
        return $records;
}

function updateUserProfile(\Dofthings\Classes\Request $req) {
    $res    = 1;
    $s      = $req->getSession();
    $p      = $req->getPostParams();
    $user   = $s->get("user");
    $userid = getUserId($user);

    if (!empty($userid)) {
        // Get remote IP
        $ipaddress = getenv('REMOTE_ADDR');

        $sql = "UPDATE users SET ipaddress = '" . $ipaddress .
                "', email = '" . $p->user_email .
                "', first_name = '" . $p->user_fname .
                "', last_name = '" . $p->user_lname .
                "', phone = '" . $p->user_phone .
                "', address = '" . $p->user_address .
                "', city = '" . $p->user_city .
                "', notes = '" . $p->user_notes .
                "', image = '" . $p->user_image .
                "' WHERE uid = '" . $userid . "' AND user='" . $user . "'";

        $res = sqlQuery($sql);
        if (sqlErrorReturn())
            sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

        // If success then update also the password
        if ($p->user_pass != "********")
            updatePass($req, $userid, $p->user_pass);
    }
    return $res;
}

function getSiteEnvSettings() {
    $sql = "SELECT * FROM env_settings";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $sqlRow = sqlFetchArray($res);

    $records ["site_url"]                  = $sqlRow ["site_url"];
    $records ["site_vhost"]                = $sqlRow ["site_vhost"];
    $records ["admin_name"]                = $sqlRow ["admin_name"];
    $records ["admin_email"]               = $sqlRow ["admin_email"];
    $records ["site_mode"]                 = $sqlRow ["site_mode"];
    $records ["site_name"]                 = $sqlRow ["site_name"];
    $records ["description"]               = $sqlRow ["description"];
    $records ["keywords"]                  = $sqlRow ["keywords"];
    $records ["site_lang"]                 = $sqlRow ["site_lang"];
    $records ["template"]                  = $sqlRow ["template"];
    $records ["use_verify_email"]          = $sqlRow ["use_verify_email"];
    $records ["visitor_tracking"]          = $sqlRow ["visitor_tracking"];
    $records ["force_compile_enabled"]     = $sqlRow ["force_compile_enabled"];
    $records ["use_fancy_urls"]            = $sqlRow ["use_fancy_urls"];
    $records ["use_user_approval"]         = $sqlRow ["use_user_approval"];
    $records ["users_delete_after_days"]   = $sqlRow ["users_delete_after_days"];
    $records ["email_after_days"]          = $sqlRow ["email_after_days"];
    $records ["google_code"]               = $sqlRow ["google_code"];
    $records ["cron_access_key"]           = $sqlRow ["cron_access_key"];
    $records ["maint_mode"]                = $sqlRow ["maint_mode"];
    $records ["main_image_width"]          = $sqlRow ["main_image_width"];
    $records ["default_user_level"]        = $sqlRow ["default_user_level"];
    $records ["time_zone"]                 = $sqlRow ["time_zone"];
    $records ["smtpserver"]                = $sqlRow ["smtpserver"];
    $records ["smtpport"]                  = $sqlRow ["smtpport"];
    $records ["smtpuser"]                  = $sqlRow ["smtpuser"];
    $records ["smtppass"]                  = $sqlRow ["smtppass"];
    $records ["xmppserver"]                = $sqlRow ["xmppserver"];
    $records ["xmppport"]                  = $sqlRow ["xmppport"];
    $records ["xmppuser"]                  = $sqlRow ["xmppuser"];
    $records ["xmpppass"]                  = $sqlRow ["xmpppass"];
    $records ["xmppdomain"]                = $sqlRow ["xmppdomain"];
    $records ["xmpptext"]                  = $sqlRow ["xmpptext"];
    $records ["other_credentials"]         = $sqlRow ["other_credentials"];
    $records ["other_credentials_escaped"] = htmlentities($sqlRow ["other_credentials"]);

    sqlFreeResult($res);

    if (isset($records))
        return $records;
}

function updateSiteEnvSettings(\Dofthings\Classes\Request $req) {
    $fieldstr = $req->getPostParamsAsRow();
    $fields   = substr($fieldstr, 0, - 2);

    $sql = "UPDATE env_settings SET $fields WHERE id=0";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    return $res;
}

function getMongoDBTable($feedid) {
    $sql = "SELECT table_name FROM feeds WHERE feedid = " . $feedid;
    $num = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $res = sqlFetchRow($num);

    if ($res ["0"]) {
        return $res [0];
    } else {
        return 0;
    }
}

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function pushFeedData($json, $json_obj, $table) {
    $m          = new MongoClient ();
    $collection = $m->selectCollection('dofthings', $table);

    try {
        $collection->insert($json_obj);
    } catch (MongoCursorException $e) {
        return false;
    }

    return true;
}

function pushFeedDataRRD($json, $json_obj) {
    // foreach ( $json_obj as $row ) { // loop the records
    $feedid     = $json_obj->FeedID;
    $deviceName = $json_obj->deviceName;
    /*
     * echo "\n$feedid\n";
     * echo "\n$deviceName\n";
     * foreach ($json_obj->sensors as $key => $value) {
     * echo "\n---\n";
     * print_r($value);
     * echo "\n\$json_obj->sensors[$key]\n";
     * $sensorName = $json_obj->sensors[$key]->sensorName;
     * $sensorValue = $json_obj->sensors[$key]->sensorValue;
     * echo "\n$sensorName\n";
     * echo "\n$sensorValue\n";
     * }
     */
}

function pullFeedData($feedid, $feedkeyhash, $deviceName, $deviceid, $objectType, $objectName, $start, $end, $table) {
    $m          = new MongoClient ();
    $collection = $m->selectCollection('dofthings', $table);

    // > db.dpenTEST_4.findOne();
    // {
    // "_id" : ObjectId("543a2c9e591255d50b43d2ba"),
    // "FeedID" : "3",
    // "FeedKeyHash" : "dcea879163307a7c38b8add25ac1c380b91585e4c8de5e16d4f0dea92a25fe0a",
    // "deviceName" : "device1",
    // "deviceID" : 1,
    // "objectType" : "Sensor",
    // "objectName" : "sen4",
    // "objectAction" : "None",
    // "objectValue" : 4,
    // "timestamp" : 1413089736
    // }
    try {
        $cursor = $collection->find(array(
            'FeedID'      => "$feedid",
            'FeedKeyHash' => "$feedkeyhash",
            'deviceName'  => "$deviceName",
            'deviceID'    => $deviceid,
            'objectType'  => "$objectType",
            'objectName'  => "$objectName",
            "timestamp"   => array(
                '$gt' => $start,
                '$lt' => $end
            )
                ), array(
            'objectValue' => 1,
            'timestamp'   => 1
        ));
    } catch (MongoCursorException $e) {
        echo "Error: $e";
        return 0;
    }

    // foreach ($cursor as $k => $row){
    // json_encode($row);
    // }
    // Complete conversion of the cursor
    $json = json_encode(iterator_to_array($cursor, FALSE));
    // $json="";

    return $json;
}

function pullLastFeedData($feedid, $feedkeyhash, $deviceName, $deviceid, $objectType, $objectName, $table) {
    $m          = new MongoClient ();
    $collection = $m->selectCollection('dofthings', $table);

    // > db.dpenTEST_4.findOne();
    // {
    // "_id" : ObjectId("543a2c9e591255d50b43d2ba"),
    // "FeedID" : "3",
    // "FeedKeyHash" : "dcea879163307a7c38b8add25ac1c380b91585e4c8de5e16d4f0dea92a25fe0a",
    // "deviceName" : "device1",
    // "deviceID" : 1,
    // "objectType" : "Sensor",
    // "objectName" : "sen4",
    // "objectAction" : "None",
    // "objectValue" : 4,
    // "timestamp" : 1413089736
    // }
    try {
        $cursor = $collection->find(array(
                    'FeedID'      => "$feedid",
                    'FeedKeyHash' => "$feedkeyhash",
                    'deviceName'  => "$deviceName",
                    'deviceID'    => $deviceid,
                    'objectType'  => "$objectType",
                    'objectName'  => "$objectName"
                ))->sort(array(
                    '_id' => - 1
                ))->limit(1);
    } catch (MongoCursorException $e) {
        echo "Error: $e";
        return 0;
    }

    // foreach ($cursor as $k => $row){
    // json_encode($row);
    // }
    // Complete conversion of the cursor
    $json = json_encode(iterator_to_array($cursor, FALSE));
    // $json="";

    return $json;
}

function pullFeedGetSensorNames($feeds, $flagJSON) {
    $m = new MongoClient ();

    // '{ "FeedID":"4",
    // "FeedKeyHash":"f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8",
    // "deviceName":"device1",
    // "deviceID":1,
    // "sensors":[{"sensorName": "sen4", "sensorValue": 16},{"sensorName": "sen3", "sensorValue": 17}],
    // "methods":[{"methodName": "openDoor", "methodAction": "http://"},{"methodName": "closeDoor", "methodAction": "http://"}],
    // "timestamp":1234567890 }' \

    $result = array();
    $idx    = 0;
    foreach ($feeds as $feed) {
        $collection = $m->selectCollection('dofthings', $feed ["table_name"]);
        try {
            $cursorDeviceIDs = $collection->distinct("deviceID");
            if (!empty($cursorDeviceIDs)) {
                foreach ($cursorDeviceIDs as $cursorDeviceID) {
                    $cursorDeviceNames = $collection->distinct("deviceName", array(
                        "deviceID" => $cursorDeviceID
                    ));
                    foreach ($cursorDeviceNames as $cursorDeviceName) {
                        $sensors = $collection->distinct("objectName", array(
                            "deviceID"   => $cursorDeviceID,
                            "deviceName" => $cursorDeviceName,
                            "objectType" => "Sensor"
                        ));
                        foreach ($sensors as $sensor) {
                            $result [$idx] ["feed"]        = $feed ["feed"];
                            $result [$idx] ["feedid"]      = $feed ["feedid"];
                            $result [$idx] ["keyhash"]     = $feed ["keyhash"];
                            $result [$idx] ["device_name"] = "$cursorDeviceName";
                            $result [$idx] ["deviceID"]    = "$cursorDeviceID";
                            $result [$idx] ["Sensor"]      = "$sensor";
                            $result [$idx] ["ObjectType"]  = "Sensor";
                            $idx++;
                        }
                    }
                }
            }
        } catch (MongoCursorException $e) {
            return 0;
        }
    }

    if ($flagJSON) {
        // Complete conversion of the cursor
        $json = json_encode($result);
        return $json;
    }

    return $result;
}

function pullFeedGetMethodNames($feeds, $flagJSON) {
    $m = new MongoClient ();

    // '{ "FeedID":"4",
    // "FeedKeyHash":"f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8",
    // "deviceName":"device1",
    // "deviceID":1,
    // "sensors":[{"sensorName": "sen4", "sensorValue": 16},{"sensorName": "sen3", "sensorValue": 17}],
    // "methods":[{"methodName": "openDoor", "methodAction": "http://"},{"methodName": "closeDoor", "methodAction": "http://"}],
    // "timestamp":1234567890 }' \

    $result = array();
    $idx    = 0;
    foreach ($feeds as $feed) {
        $collection = $m->selectCollection('dofthings', $feed ["table_name"]);
        try {
            $cursorDeviceIDs = $collection->distinct("deviceID");
            if (!empty($cursorDeviceIDs)) {
                foreach ($cursorDeviceIDs as $cursorDeviceID) {
                    $cursorDeviceNames = $collection->distinct("deviceName", array(
                        "deviceID" => $cursorDeviceID
                    ));
                    foreach ($cursorDeviceNames as $cursorDeviceName) {
                        $methods = $collection->distinct("objectName", array(
                            "deviceID"   => $cursorDeviceID,
                            "deviceName" => $cursorDeviceName,
                            "objectType" => "Method"
                        ));
                        foreach ($methods as $method) {
                            $result [$idx] ["feed"]        = $feed ["feed"];
                            $result [$idx] ["feedid"]      = $feed ["feedid"];
                            $result [$idx] ["keyhash"]     = $feed ["keyhash"];
                            $result [$idx] ["device_name"] = "$cursorDeviceName";
                            $result [$idx] ["deviceID"]    = "$cursorDeviceID";
                            $result [$idx] ["Method"]      = "$method";
                            $result [$idx] ["ObjectType"]  = "Method";
                            $idx++;
                        }
                    }
                }
            }
        } catch (MongoCursorException $e) {
            echo $e;
            return 0;
        }
    }

    if ($flagJSON) {
        // Complete conversion of the cursor
        $json = json_encode($result);
        return $json;
    }

    return $result;
}

// executeAction($p->objectType, $p>objectName, $p->objectAction, $->objectValue);
function executeAction($type, $name, $action, $value, $user, $pass) {
    //mqttServerSendAction
    $records = getSiteEnvSettings();
    $json    = json_decode($records["other_credentials"]);
    $j       = $json->mqttServerSendAction;

    global $topic, $actionNameValue;
    $topic           = dirname($action);
    $actionNameValue = basename($action) . ":" . $value;
    $mqttUser        = $j->user;
    $mqttPasswd      = $j->pass;
    $uid             = round(microtime(true) * 1000) % 10000;

    $c = new Mosquitto\Client('id-client' . $uid);
    $c->setCredentials($mqttUser, $mqttPasswd);
    $c->onConnect(function() use ($c) {
        global $topic, $actionNameValue;
        $c->publish($topic, $actionNameValue, 0);
    });

    $c->connect($j->hostname, $j->port);

    for ($i = 0; $i < 100; $i++) {
        $c->loop(1);
    }

    $c->disconnect();
    unset($c);

    // Return successfull answer, but later update from mqtt response
    // Look mqtt_to_http.php and dofthings.mqtt.js
    $json_array = array(
        "response"        => 1,
        "cur_value"       => $value,
        "executed_action" => "$name"
    );
    $json       = json_encode($json_array);

    return $json;
}

function insertDashboardEntry(\Dofthings\Classes\Request $req, $dashboardid, $title, $resolution, $background, $share, $htmldata, $zoom, $move, $description, $style) {
    $s    = $req->getSession();
    $user = $s->get("user");

    // if(!validateFeedName($feeds_name)) return false;
    $create_date     = date("Y-m-d H:i:s");
    $executed_action = "";

    if ($dashboardid == "nan") {
        $sql             = "INSERT INTO dashboards (uid,config,share,zoom,create_date,resolution,background,description,name,move,style) VALUES ( (select uid from users where user='" . $user . "'), '" . $htmldata . "', '" . $share . "', '" . $zoom . "', '" . $create_date . "', '" . $resolution . "', '" . $background . "', '" . $description . "', '" . $title . "', '" . $move . "', '" . $style . "')";
        $executed_action = "Created!";
    } else {
        $sql             = "UPDATE dashboards SET uid = (select uid from users where user='" . $user . "'), config = '" . $htmldata . "', share='" . $share . "', zoom='" . $zoom . "', resolution='" . $resolution . "', background='" . $background . "', description='" . $description . "', name='" . $title . "', move='" . $move . "', style='" . $style . "' WHERE dashid='" . $dashboardid . "'";
        $executed_action = "Updated!";
    }

    $res = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return array(
            false,
            false
        );
    }

    if ($dashboardid == "nan")
        $lastid = sqlLastInsert();
    else
        $lastid = $dashboardid;

    // perform sqlQuery and update feeds info in the database
    // $sql = "UPDATE feeds SET filepath = '" . $feeds_filepath . "', table_name='" . $feeds_table ."' WHERE feedid = '" . $lastid . "'";
    // $res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());

    return array(
        "$lastid",
        "$executed_action"
    );
}

function getUsers() {
    $sql = "SELECT * FROM users";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["uid"]       = $sqlRow ["uid"];
        $records [$idx] ["user"]      = $sqlRow ["user"];
        $records [$idx] ["email"]     = $sqlRow ["email"];
        $records [$idx] ["fname"]     = $sqlRow ["first_name"];
        $records [$idx] ["lname"]     = $sqlRow ["last_name"];
        $records [$idx] ["phone"]     = $sqlRow ["phone"];
        $records [$idx] ["activated"] = $sqlRow ["activated"];
        $records [$idx] ["approved"]  = $sqlRow ["approved"];
        $records [$idx] ["role"]      = $sqlRow ["role"];

        ++$idx;
    }
    sqlFreeResult($res);

    return $records;
}

function getUsersCount() {
    $sql = "SELECT COUNT(*) FROM users";

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlFetchRow($res);

    sqlFreeResult($res);

    return $num [0];
}

function activateUser($uid, $activate) {
    $sql = "UPDATE users SET activated=" . $activate . "  WHERE uid = '" . $uid . "'";
    $del = sqlQuery($sql);
    if (sqlErrorReturn()) {
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return false;
    }

    if (!empty($res))
        return true;

    return false;
}

function deleteUser($uid) {
    $sql = "DELETE FROM users WHERE uid = '" . $uid . "'";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    if (!empty($res))
        return true;

    return false;
}

function changeUserRole($uid, $role) {
    $sql = "UPDATE users SET role='" . getRole($role) . "' WHERE uid = '" . $uid . "'";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    if (!empty($res))
        return true;

    return false;
}

function getRole($role) {
    if ($role == "makeadmin")
        return 99;
    else if ($role == "makeuser")
        return 11;
    else
        return 11;
}

// Check if magic qoutes is on then stripslashes if needed
function codeClean($var) {
    $output = '';
    if (is_array($var)) {
        foreach ($var as $key => $val) {
            $output [$key] = codeClean($val);
        }
    } else {
        $var = strip_tags(trim($var));
        if (function_exists("get_magic_quotes_gpc")) {
            $output = sqlEscapeString(get_magic_quotes_gpc() ? stripslashes($var) : $var);
        } else {
            $output = sqlEscapeString($var);
        }
    }
    return $output;
}

function viewOnPage($var) {
    $output = '';
    if (is_array($var)) {
        foreach ($var as $key => $val) {
            $output [$key] = viewOnPage($val);
        }
    } else {
        $var = htmlentities(trim($var), ENT_NOQUOTES, "UTF-8");
        if (function_exists("get_magic_quotes_gpc")) {
            $output = get_magic_quotes_gpc() ? stripslashes($var) : $var;
        } else {
            $output = $var;
        }
    }
    return $output;
}

/* * * Login functions ** */

function verifyLogin($user, $pass) {
    // Encrypt password for database verification
    $pass = encryptPass($pass);

    $sql = "SELECT pass FROM users WHERE pass = '" . $pass . "' AND user = '" . $user . "'";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    if ($num > 0)
        return true;
    return false;
}

function encryptPass($pass) {
    $salt = 's+(_a*';
    $pass = md5($pass . $salt);

    return $pass;
}

function verifyCookie($user, $pass) {
    $sql = "SELECT pass FROM users WHERE pass = '" . $pass . "' AND user = '" . $user . "'";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    if ($num > 0)
        return true;
    return false;
}

function checkPrivs(\Dofthings\Classes\Request $req) {
    $s     = $req->getSession();
    $user  = $s->get("user");
    $admin = $s->get("admin");

    if (!empty($admin)) {
        return 'admin';
    } elseif (!empty($user)) {
        return 'user_role';
    } else {
        return 'user_role';
    }
}

function checkIfAdmin($user, $pass) {
    $sql = "SELECT user FROM users WHERE pass = '" . $pass . "' AND user = '" . $user . "' AND role = 99 ";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    if ($num > 0)
        return true;
    return false;
}

function checkIfUser($user, $pass) {
    $sql = "SELECT user FROM users WHERE pass = '" . $pass . "' AND user = '" . $user . "' AND role = 11 ";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    if ($num > 0)
        return true;
    return false;
}

function checkIfUserReg($user) {
    $sql = "SELECT user FROM users WHERE user = '" . $user . "' AND role = 11 ";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    if ($num > 0)
        return true;
    return false;
}

/* * * Getter functions ** */

function getUserRecords($user) {
    $sql = "SELECT * FROM users WHERE user = '" . $user . "'";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["id"]           = $sqlRow ["id"];
        $records [$idx] ["email"]        = $sqlRow ["email"];
        $records [$idx] ["user"]         = $sqlRow ["user"];
        $records [$idx] ["company_name"] = $sqlRow ["company_name"];
        $records [$idx] ["first_name"]   = $sqlRow ["first_name"];
        $records [$idx] ["last_name"]    = $sqlRow ["last_name"];
        $records [$idx] ["phone"]        = $sqlRow ["phone"];
        $records [$idx] ["alt_phone"]    = $sqlRow ["alt_phone"];
        $records [$idx] ["fax"]          = $sqlRow ["fax"];
        $records [$idx] ["image"]        = $sqlRow ["image"];
        $records [$idx] ["country"]      = $sqlRow ["country"];
        $records [$idx] ["address"]      = $sqlRow ["address"];
        $records [$idx] ["city"]         = $sqlRow ["city"];
        $records [$idx] ["state"]        = $sqlRow ["state"];
        $records [$idx] ["zip"]          = $sqlRow ["zip"];
        $records [$idx] ["reg_date"]     = $sqlRow ["reg_date"];
        $records [$idx] ["image"]        = $sqlRow ["image"];
        ++$idx;
    }
    if (!empty($records))
        return $records;
}

function getUserDetails($id) {
    if (!empty($id) && $id == "all") {
        // smarty paginate class used for users list in admin and also vehicle listings
        $paginate         = new SmartyPaginate ();
        // set the result query from listing number set
        $result_set_start = $paginate->getCurrentIndex();
        // set the result max query number
        $result_set_max   = $paginate->getLimit();
        $page_limits      = "LIMIT $result_set_start, $result_set_max";
    }

    if (!empty($id) && $id == "all") {
        $sql       = "SELECT * FROM users ORDER BY id,approved DESC $page_limits";
        $count     = "SELECT COUNT(*) FROM users";
        $count_res = sqlQuery($count);
        if (sqlErrorReturn())
            sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        $row_count = sqlFetchRow($count_res);
    } else {
        $sql = "SELECT * FROM users WHERE id = " . $id . "";
    }

    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    $idx    = 0;
    while ($sqlRow = sqlFetchArray($res)) {
        $records [$idx] ["id"]           = $sqlRow ["id"];
        $records [$idx] ["ipaddress"]    = ipConvert($sqlRow ["ipaddress"]);
        $records [$idx] ["user"]         = $sqlRow ["user"];
        $records [$idx] ["email"]        = $sqlRow ["email"];
        $records [$idx] ["company_name"] = $sqlRow ["company_name"];
        $records [$idx] ["first_name"]   = $sqlRow ["first_name"];
        $records [$idx] ["last_name"]    = $sqlRow ["last_name"];
        $records [$idx] ["phone"]        = $sqlRow ["phone"];
        $records [$idx] ["alt_phone"]    = $sqlRow ["alt_phone"];
        $records [$idx] ["fax"]          = $sqlRow ["fax"];
        $records [$idx] ["country"]      = $sqlRow ["country"];
        $records [$idx] ["address"]      = $sqlRow ["address"];
        $records [$idx] ["city"]         = $sqlRow ["city"];
        $records [$idx] ["state"]        = $sqlRow ["state"];
        $records [$idx] ["zip"]          = $sqlRow ["zip"];
        $records [$idx] ["reg_date"]     = $sqlRow ["reg_date"];
        $records [$idx] ["last_active"]  = $sqlRow ["last_active"];
        $records [$idx] ["user_level"]   = $sqlRow ["user_level"];
        $records [$idx] ["notes"]        = $sqlRow ["notes"];
        $records [$idx] ["image"]        = $sqlRow ["image"];
        $records [$idx] ["activated"]    = $sqlRow ["activated"];
        $records [$idx] ["approved"]     = $sqlRow ["approved"];
        $records [$idx] ["admin_notes"]  = $sqlRow ["admin_notes"];
        ++$idx;
    }
    sqlFreeResult($res);

    if (!empty($id) && $id == "all") {
        // set total row count to count from query else defaults to 0
        $paginate->setTotal(!empty($row_count ['0']) ? $row_count ['0'] : 0 );
        // $paginate->setTotal(count($records));
        if (!empty($records)) {
            // return array_slice($records, $paginate->getCurrentIndex(), $paginate->getLimit());
            return $records;
        }
    } elseif (isset($records)) {
        return $records;
    }
}

function generatePassword($len) {
    $password = "";
    $char     = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    $idx = 0;
    while ($c <= $len) {
        $random   = rand(1, strlen($char));
        $password .= substr($char, $random - 1, 1);
        ++$idx;
    }

    if (!empty($password))
        return $password; // echo $password;
}

/* * * Validation functions ** */

function validatePhone($phone) {
    if (preg_match('!^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$!', $phone))
        return true;
    return false;
}

function validateName($name) {
    $first = substr($name, 0, 1);
    if ($first == '.' || $first == '-' || $first == '_') {
        return false;
    }

    // if slashes are added remove them since this doesn't go in the db and we don't want names with \
    $name = str_replace('\\', '', $name);
    if (preg_match('!^[a-zA-Z\']+$!', $name))
        return true;
    return false;
}

function validateUsername($user) {
    $first = substr($user, 0, 1);
    if ($first == '.' || $first == '-' || $first == '_') {
        return false;
    }

    if (preg_match('!^[a-zA-Z0-9._-]{5,60}$!', $user))
        return true;
    return false;
}

function validateEmail($email) {
    if (preg_match("!^[a-zA-Z0-9]+([_\\.-][a-zA-Z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,4}$!", $email))
        return true;
    return false;
}

function validateKeyHash($hash) {
    if (preg_match('!^[a-zA-Z0-9]{64}$!', $hash))
        return true;
    return false;
}

function checkIfEmail(\Dofthings\Classes\Request $req, $email) {
    $s    = $req->getSession();
    $user = $s->get("user");

    if (isset($user)) {
        $sql = "SELECT * FROM users WHERE email = '" . $email . "' AND user = '" . $user . "'";
    } else {
        $sql = "SELECT * FROM users WHERE email = '" . $email . "' ";
    }
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
    $num = sqlNumRows($res);

    if ($num > 0)
        return true;
    return false;
}

function getUserId($user) {
    if (!validateUsername($user))
        return false;

    $sql = "SELECT uid FROM users WHERE user = '" . $user . "' LIMIT 1";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    if (!empty($res)) {
        $row = sqlFetchAssoc($res);
        $id  = $row ["uid"];
        return $id;
    } else {
        return false;
    }
}

function getUsername($uid) {
    $uid = codeClean($uid);
    $sql = "SELECT user FROM users WHERE uid = '" . $uid . "'";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    // if cannot get anything back; croak and die
    if ($sqlRow = sqlFetchArray($res))
        return $sqlRow ["user"];
    return false;
}

function getCompanyName($uid) {
    $uid = codeClean($uid);
    $sql = "SELECT company_name FROM users WHERE id = '" . $uid . "'";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    // if cannot get anything back; croak and die
    if ($sqlRow = sqlFetchArray($res))
        return $sqlRow ["company_name"];
    return false;
}

/* * * Confirm functions ** */

function generateConfirmationID($user, $timestamp) {
    $sql = "SELECT uid FROM users WHERE user = '" . $user . "'";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    // Try to fetch and assign, if not, return false
    if ($sqlRow = sqlFetchArray($res)) {
        return $timestamp . "-" . $sqlRow ["uid"];
    } else {
        return false;
    }
}

/* * * Update functions ** */

function updateUsername($uid, $user) {
    $uid  = codeClean($uid);
    $user = codeClean($user);
    $sql  = "UPDATE users SET user = '" . $user . "', activated = 1 WHERE uid = '" . $uid . "'";
    $res  = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    // If succeed; return TRUE, else FALSE!!
    if (!empty($res))
        return $res;
    return false;
}

function updatePass(\Dofthings\Classes\Request $req, $uid, $pass) {
    $s            = $req->getSession();
    $c            = $req->getCookie();
    // Encrypt password for database
    $new_password = encryptPass($pass);

    // if user logged in change their session password
    if (isset($s->pass)) {
        $s->pass = "$new_password";
    }

    // if remember me function already set
    // change cookie for remember me
    if (isset($c->pass)) {
        setcookie("pass", "$new_password", time() + (60 * 60 * 24 * 30));
    }

    // perform sqlQuery and update user info in the database
    $sql = "UPDATE users SET pass = '" . $new_password . "' WHERE uid = '" . $uid . "'";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
}

function updateUserDetails($details) {
    $fieldstr = '';
    foreach ($details as $field => $value) {
        if ($value !== UPDATE) {
            if ($field !== 'id') {
                $fieldstr .= "$field = '" . $value . "', ";
            }
        }
        if ($field == 'id') {
            $id = $value;
        }
    }
    $fields = substr($fieldstr, 0, - 2);

    $sql = "UPDATE users SET $fields WHERE id = " . $id . "";
    $res = sqlQuery($sql);
    if (sqlErrorReturn())
        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

    if (!empty($res))
        return 99;
    return false;
}

function updateUser($user, $email, $company_name, $first_name, $last_name, $phone, $alt_phone, $fax, $country, $address, $city, $state, $zip) {
    if (!validateEmail($email)) {
        return 1;
    } elseif (!validatePhone($phone)) {
        return 2;
    } elseif (!validateName($first_name)) {
        return 3;
    } elseif (!validateName($last_name)) {
        return 4;
    } else {
        // Get remote IP
        $ipaddress = getenv('REMOTE_ADDR');
        $sql       = "UPDATE users SET ipaddress = " . $ipaddress . ", email = '" . $email . "', company_name = '" . $company_name . "', first_name = '" . $first_name . "', last_name = '" . $last_name . "', phone = '" . $phone . "', alt_phone = '" . $alt_phone . "', fax = '" . $fax . "', country = '" . $country . "', address = '" . $address . "', city = '" . $city . "', state = '" . $state . "', zip = '" . $zip . "' WHERE user = '" . $user . "'";
        $res       = sqlQuery($sql);
        if (sqlErrorReturn())
            sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        return 99;
    }
}

/* * * Other functions ** */

function activateProfile($confirmationID) {
    // Purpose: Activate a registered Profile based on a unique confirmation number
    // Returns: TRUE if all check passes and username is updated correctly
    // FALSE if any check fails or anything bad happens.
    // Reasons to fail:
    // timestamp does not match
    // wrong format
    // Check that it fits the regexp for confirmationID -- ^[0-9]-[0-9]+$ => ^{timestamp}-{uid}$
    // [bkeep] Changed if (!eregi("^([0-9]+)-([0-9]+)$", $confirmationID, $regs)) {
    if (!preg_match_all("!^([0-9]+)-([0-9]+)$!", $confirmationID, $regs)) {
        // $error_code = "Confirmation ID - $confirmationID - is not valid!";
        // return false;
        return 1;
    }
    // If it fits the profile; split the string to the timestamp component and uid component
    // First parenthesis is for timestamp; second parenthesis is for user ID
    $timestamp = $regs [1] [0];
    $uid       = $regs [2] [0];

    // Pull out the record based on the uid and compare if it fits the regexp
    if ($user = getUsername($uid)) {
        // If does not fit the pattern; possibly this username has already been activated!!!
        // [bkeep] Changed if (!eregi("^<([0-9]+)>-([A-Z0-9]{5,20})$", $user, $regs)) {
        if (!preg_match_all("!^<([0-9]+)>-([a-zA-Z0-9._-]{5,60})$!", $user, $regs)) {
            // $error_code = "The username - $user - has been activated! Please login with this username!";
            // return false;
            return 2;
        }

        // Now we have the correct username
        // Pull out the original username component from the matching regexp
        // First parenthesis is for timestamp; second parenthesis is for username
        $stored_timestamp = $regs [1] [0];
        $user             = $regs [2] [0];

        // Update DB with correct username if timestamp matches
        if ($timestamp == $stored_timestamp) {
            // If $user already exists in the system; must re-register!
            $res = updateUsername($uid, $user);
            if (!$res) {
                // $error_code = "User $user already exists on the system. " . 'Please re-register at the <a href="register.php">Registration Page</a> with another username.';
                // return false;
                return 3;
            } else {
                // return $res;
                return 99;
            }
        } else {
            // $error_code = "The timestamp does not match with the records!";
            // return false;
            return 4;
        }
    } else {
        // $error_code = "Invalid uid!";
        // return false;
        return 5;
    }
}

function registerUser(\Dofthings\Classes\Request $req, $user, $pass, $email) {
    $e                  = getSiteEnvSettings();
    $admin_name         = $e["admin_name"];
    $admin_email        = $e["admin_email"];
    $default_user_level = $e["default_user_level"];
    $use_verify_email   = $e["use_verify_email"];
    $use_user_approval  = $e["use_user_approval"];
    $site_url           = $e["site_url"];

    $error = '';
    if (!validateUsername($user)) {
        $error [] = 3;
    }
    // todo work out better error handling routine
    if (checkIfUserReg($user)) {
        $error [] = 1;
    }
    if (!validateEmail($email)) {
        $error [] = 2;
    }
    if (checkIfEmail($req, $email)) {
        $error [] = 4;
    }
    if ($error) {
        return $error;
    } else {
        // if blank password one is generated then the details are emailed
        if (empty($pass)) {
            $pass = generatePassword(6);

            // If email verification functionality is enabled
            if ($use_verify_email) {
                $body = preg_replace("!%USERNAME%!", "$user", EMAIL_SIGNUP_BODY_VERIFY);
            } else {
                $body = preg_replace("!%USERNAME%!", "$user", EMAIL_SIGNUP_BODY);
            }
        } else {
            // If email verification functionality is enabled
            if ($use_verify_email) {
                $body = preg_replace("!%USERNAME%!", "$user", EMAIL_SIGNUP_BODY_WPASS_VERIFY);
            } else {
                $body = preg_replace("!%USERNAME%!", "$user", EMAIL_SIGNUP_BODY_WPASS);
            }
        }

        // build email body
        $body      = preg_replace("!%PASSWORD%!", "$pass", $body);
        $body      = preg_replace("!%URL%!", "$site_url/login", $body);
        $subject   = preg_replace("!%URL%!", "$site_url", EMAIL_SIGNUP_SUBJECT);
        $subject   = preg_replace("!%USERNAME%!", "$user", $subject);
        // The last part of the email is at the bottom!!
        // Get remote IP
        $ipaddress = ipConvertLong(getenv('REMOTE_ADDR'));
        $reg_date  = date("Y-m-d H:i:s");

        // Encrypt password for database
        $pass = encryptPass($pass);

        // Set the default activated status if not using the verify email functions
        $activated = 1;
        // Set the default user approval status
        $approved  = 1;

        // If user approval functionality is enabled
        if ($use_user_approval)
            $approved = 0;

        // If email verification functionality is enabled
        if ($use_verify_email) {
            // Mangle username with timestamp to make sure user confirm e-mail address.
            // After e-mail is confirmed; this username will be unmangled
            // This will also set the actived status to 0 awaiting a proper verification
            $timestamp = time();
            $user      = "<" . $timestamp . ">-" . $user;
            $activated = 0;
        }

        // get default user level set by admin and insert
        $user_level = $default_user_level;
        $sql        = "INSERT INTO users (ipaddress,user,pass,email,reg_date,role,activated,approved) VALUES ('" . $ipaddress . "', '" . $user . "','" . $pass . "', '" . $email . "', '" . $reg_date . "', " . $user_level . ", " . $activated . ", " . $approved . ")";
        $res        = sqlQuery($sql);
        if (sqlErrorReturn())
            sqlDebug(__FILE__, __LINE__, sqlErrorReturn());

        // If email verification functionality is enabled
        if ($use_verify_email) {
            // ConfirmationID ==> timestamp.uid
            $cid  = generateConfirmationID($user, $timestamp);
            // Put in the correctly generated confirmation URL into the
            $body = preg_replace("!%CONFIRMURL%!", "$site_url/login/verify/$cid", $body);
        }

        // Send off the completed mail to user; with username and password in it.
        // Also will have confirmation URL if feature: validate email enabled.

        sendEmail($email, $subject, $body, $admin_name, $admin_email, $e);
        return 99;
    }
}

function lastActive(\Dofthings\Classes\Request $req, $user) {
    global $visitor_tracking;
    $s = $req->getSession();

    $current_time = date("Y-m-d H:i:s");
    $ipaddress    = ipConvertLong(getenv('REMOTE_ADDR'));

    // check if user is a guest or a logged in user
    // if logged in update the last active time in the users table and if activated the onlineusers table
    // if not logged in update the onlineusers table with correct guest info
    // checks for guest user first then checks if a user is logged in

    if (!empty($visitor_tracking) && $user == 'guest') {
        // guest is viewing check if already listed using their ip address in onlineusers table
        $sql = "SELECT ipaddress FROM onlineusers WHERE user = '" . $user . "' AND ipaddress = " . $ipaddress . "";
        $res = sqlQuery($sql);
        if (sqlErrorReturn())
            sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        $num = sqlNumRows($res);
        if ($num > 0) {
            // if check showed result then perform an update to the onlineusers table
            $sql = "UPDATE onlineusers SET last_active = '" . $current_time . "', ipaddress = " . $ipaddress . " WHERE user = '" . $user . "' AND ipaddress = " . $ipaddress . "";
            $res = sqlQuery($sql);
            if (sqlErrorReturn())
                sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        } else {
            // if check failed insert result in to the onlineusers table
            $sql = "INSERT INTO onlineusers (user,last_active,ipaddress) VALUES ('" . $user . "', '" . $current_time . "', " . $ipaddress . ")";
            $res = sqlQuery($sql);
            if (sqlErrorReturn())
                sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        }
    } elseif (!empty($visitor_tracking) && $user == $s->get("user")) {
        // user is logged in check if they are listed in onlineusers table
        $sql = "SELECT user FROM onlineusers WHERE user = '" . $user . "'";
        $res = sqlQuery($sql);
        if (sqlErrorReturn())
            sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        $num = sqlNumRows($res);
        if ($num > 0) {
            // if check showed result then perform the update to the tables users and onlineusers
            $sql = "UPDATE users,onlineusers SET users.last_active = '" . $current_time . "', onlineusers.last_active = '" . $current_time . "' WHERE onlineusers.user = users.user";
            $res = sqlQuery($sql);
            if (sqlErrorReturn())
                sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        } else {
            // if check failed insert result in the onlineusers table
            $sql = "INSERT INTO onlineusers (user,last_active,ipaddress) VALUES ('" . $user . "', '" . $current_time . "', " . $ipaddress . ")";
            $res = sqlQuery($sql);
            if (sqlErrorReturn())
                sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        }
    } else {
        // not using the visitor tracking feature so just update the last_active field for the user
        $sql = "UPDATE users SET last_active = '" . $current_time . "' WHERE user = '" . $user . "' ";
    }

    // perform some cleanup actions for the onlineusers table if visitor_tracking is enabled
    if (!empty($visitor_tracking)) {
        // now that we have checked the guest user or logged in user perform some cleanups of old dead userdata
        $sql = "SELECT * FROM onlineusers";
        $res = sqlQuery($sql);
        if (sqlErrorReturn())
            sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        $num = sqlNumRows($res);

        // print "".__LINE__." $sql, $num, I am $user this is my ip $ipaddress<br />";
        if ($num > 0) {
            while ($sqlRow = sqlFetchArray($res)) {
                $id                    = $sqlRow ["id"];
                $last_active_time      = $sqlRow ["last_active"];
                // print $last_active_time;
                // if last active time is less than last active time plus 5 minutes
                $last_active_timestamp = strtotime($last_active_time);
                $current_timestamp     = strtotime(date("Y-m-d H:i:s"));
                // print "<br />$last_active_timestamp";
                // print "<br />$current_timestamp";

                $time_diff = ($current_timestamp - $last_active_timestamp);
                // print "<br />$time_diff";

                $time_diff_minutes = date("i", $time_diff);
                // print "<br /> $time_diff_minutes<br />";
                // delete the row from onlineusers if the current time is greater than last_active_time by x minutes
                if ($time_diff_minutes >= 5) {
                    $sql = "DELETE FROM onlineusers WHERE id = '" . $id . "'";
                    $del = sqlQuery($sql);
                    if (sqlErrorReturn())
                        sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
                    // print "it worked there is a difference of $time_diff_minutes minutes<br />";
                } else {
                    // print "it did not work there is only a difference of $time_diff_minutes minutes<br />";
                }
            }
        }
    }
}

function ipConvert($ip) {
    if ($ip == "ALL")
        return "ALL";

    $b  = array(
        0,
        0,
        0,
        0
    );
    $c  = 16777216.0;
    $ip += 0.0;
    for ($i = 0; $i < 4; ++$i) {
        $k      = (int) ($ip / $c);
        $ip     -= $c * $k;
        $b [$i] = $k;
        $c      /= 256.0;
    }
    $d = join('.', $b);
    if (isset($d))
        return $d;
    return "ALL";
}

function ipConvertLong($ip) {
    if ($ip == "ALL")
        return "ALL";

    // Check if there are some alphabetic characters
    if (preg_match('!^[a-zA-Z]{1,119}$!', $ip))
        return "ALL";
    if (preg_match('![a-zA-Z]!', $ip))
        return "ALL";

    // $d = 0.0;
    // $b = explode('.', $ip, 4);
    // for ($i = 0; $i < 4; ++$i) {
    // $d *= 256.0;
    // $d += $b[$i];
    // }
    // if (isset($d))

    return $ip;
}

/* * *************** MQTT functions ***************************** */

function mqttSendHTTP($uri, $json, $user, $pass) {
    $ch = curl_init($uri);

    // Post parameters
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_USERPWD, "$user:$pass");

    // sending username and pwd.
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'dofthings');
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);

    $output = curl_exec($ch);
    //print_r(curl_getinfo($ch));
    curl_close($ch);
    print (" sent\n");
}

function mqttGetAnswer($m) {
    $array = mqttGetAnswerImpl($m);
    $array = [];
    $a     = mqttGetAnswerImpl($m);

    $array["uri"]   = $a[0];
    $array["topic"] = $a[1];
    $array["json"]  = $a[2];
    $array["route"] = $a[3];

    return $array;
}

function mqttGetAnswerImpl($m) {
    $answer_array = array(NULL, NULL, "", "");
    $records      = getSiteEnvSettings();
    $pushUri      = $records["site_url"] . "dataPush/push";
    $topic        = $m->topic;

    if (preg_match('/smartthings/', $topic)) {
        // Reroute into mqtt stream
        $answer_array = getSmartthingsAnswer($m);
    } elseif (preg_match('/result/', $topic)) {
        $tArray       = explode("/", $topic);
        $uri          = $pushUri . "/" . $tArray[2] . "/" . $tArray[3];
        $answer_array = array($uri, $topic, $m->payload, "http");
    } else {
        $answer_array = getRerouteTestFeedAnswer($m);
    }
    return $answer_array;
}

function getMiddlewareConfigFile($type) {
    $dirname_htdocs = '/var/www/htdocs';
    $dirname_html   = '/var/www/html';
    $file_prod      = '/d-of-things/scripts/middleware/mqtt_to_http.config';
    $file_test      = '/d-of-things/scripts/middleware/mqtt_to_http.test.config';
    $file           = $file_prod;
    if ($type == 'test') {
        $file = $file_test;
    }

    $dirname = $dirname_htdocs;
    if (!file_exists($dirname)) {
        $dirname = $dirname_html;
    }
    $file_array = getFileIntoHash($dirname . '/' . $file);
    return $file_array;
}

function getSmartthingsAnswer($m) {
    $t          = $m->topic;
    $answer     = array(NULL, NULL, "", "");
    $file_array = getMiddlewareConfigFile("prod");

    if (isset($t) && isset($file_array[$t])) {
        // Explode 1st element is URI, 2nd is JSON
        $dofthings_array = explode("#", $file_array[$t]);
        $json            = getSmartthingsJson($dofthings_array[1], $m->payload);
        $json_string     = json_encode($json, JSON_UNESCAPED_SLASHES);
        $topic           = getSmartthingsTopic($dofthings_array[0], $json);
        $answer          = array($topic, $topic, $json_string, "mqtt");
    }

    return $answer;
}

function getSmartthingsValue($v) {
    if (is_string($v)) {
        if ($v == "open") {
            return 1;
        } elseif ($v == "closed") {
            return 0;
        }
    } elseif (is_numeric($v)) {
        return $v;
    }
    return $v;
}

function getSmartthingsTopic($t, $json) {
    // /dofthings/5/30affa18813d27af843901e699f777a824b67aab91a119b508950c027e7f033e/5c:cf:7f:13:37:47/active/result
    $type = "unknown";

    if ($json->objectType == "Sensor") {
        $type = "passive";
    } elseif ($json->objectType == "Method") {
        $type = "active";
    }
    $topic = "/dofthings" . $t . "/" . $json->deviceName . "/" . $type . "/result";

    return $topic;
}

function getSmartthingsJson($j, $payload) {
    $json              = json_decode($j);
    $json->objectValue = getSmartthingsValue($payload);

    return $json;
}

function getRerouteTestFeedAnswer($m) {
    $t          = $m->topic;
    $answer     = array(NULL, NULL, "", "");
    $file_array = getMiddlewareConfigFile("prod");

    if (isset($t) && isset($file_array[$t])) {
        // Explode 1st element is URI, 2nd is JSON
        $dofthings_array   = explode("#", $file_array[$t]);
        $json              = $dofthings_array[1];
        $objectArray       = explode(":", $m->payload);
        $objectAction      = $objectArray[0];
        $objectValue       = $objectArray[1];
        $json              = json_decode($dofthings_array[1]);
        $json->objectValue = ($objectValue ? 0 : 1); //Inverse value for test purposes
        $json_string       = json_encode($json, JSON_UNESCAPED_SLASHES);
        $topic             = $dofthings_array[0] . '/result';
        $answer            = array($topic, $topic, $json_string, "mqtt");
    }

    return $answer;
}

function getFileIntoHash($file) {
    $lines      = file($file);
    $file_array = [];
    foreach ($lines as $line) {
        $line_array         = explode("#", $line);
        $topic              = $line_array[0];
        $rest               = $line_array[1] . "#" . $line_array[2];
        $file_array[$topic] = $rest;
    }
    return $file_array;
}

function mqttSubscribe() {
    //mqqtServerMiddlerwareSubscribe
    $records = getSiteEnvSettings();
    $json    = json_decode($records["other_credentials"]);
    $j       = $json->mqqtServerMiddlerwareSubscribe;

    $mqttUser   = $j->user;
    $mqttPasswd = $j->pass;
    $uid        = round(microtime(true) * 1000) % 10000;

    $c = new Mosquitto\Client('middleware-client' . $uid);
    $c->onConnect(function() use ($c) {
        $c->subscribe("#", 0);
    });

    $c->setCredentials($mqttUser, $mqttPasswd);
    $c->connect($j->hostname, $j->port);

    global $juser, $jpass;
    $j     = $json->mqttSendHTTP;
    $juser = $j->user;
    $jpass = $j->pass;

    $c->onMessage(function($msg) use ($c) {
        global $juser, $jpass;
        $answer_array = mqttGetAnswer($msg);
        $uri          = $answer_array["uri"];
        $topic        = $answer_array["topic"];
        $json         = $answer_array["json"];
        $route        = $answer_array["route"];

        print("\nTOPIC: " . $topic);
        print("\nURI: " . $uri);
        print("\nROUTE: " . $route);
        print("\nMSG: " . $json . "\n");

        // Get only the results from the executed commands
        if ($uri == NULL) {
            print ("Topic can't be mapped to dofthings url\n");
            print ("---\n");
            return;
        }

        if ($route == "mqtt") {
            // Publish already converted message into dofthings bloodstream
            $c->publish($topic, $json, 0);
            return;
        }

        print ("Sending: $uri ...");

        mqttSendHTTP($uri, $json, $juser, $jpass);
        print ("---\n");
    });

    $c->loopForever();
}

?>
