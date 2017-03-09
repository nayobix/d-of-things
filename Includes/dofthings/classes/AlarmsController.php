<?php

/*
 * The MIT License
 *
 * Copyright 2016 Boyan Vladinov <nayobix at nayobix.org>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Dofthings\Classes;

use Dofthings\Classes\IController;

/**
 * Description of AlarmsController
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class AlarmsController implements IController {

    private $response = [];

    /**
     *  class constructor
     * 
     */
    public function __construct(Request $req) {
        $this->response["alarms"]         = 1;
        $this->response["smartyFilename"] = "alarms";
        $this->response["alarmtypes"]     = getAlarmTypes();
    }

    public function notify(Request $req) {
        // To get here there is a special string comparison in .htaccess which will pass you to here
        // /alarms/notify/notifySecretKey
        $notifyret = notifyAlarm();
        $actionret = actionAlarm();
        echo ("$notifyret:$actionret");
        exit();
    }

    public function _new(Request $req) {
        $s      = $req->getSession();
        $p      = $req->getPostParams();
        $g      = $req->getGetParams();
        $userid = getUserId($s->get("user"));

        if (isset($p->submit) && $p->submit == FORMS_ALARMS_CREATE) {
            return $this->create($req);
        }

        if (isset($g->type)) {
            $this->response["sensors"]     = pullFeedGetSensorNames(getAllFeedsByUserId($userid), false);
            $this->response["methods"]     = pullFeedGetMethodNames(getAllFeedsByUserId($userid), false);
            $this->response["alarms_new"]  = 1;
            $this->response["alarms_type"] = $g->type;
            // Get the data
            //$feedsresult = getUserFeeds($_SESSION ["user"], $userid);
            //var_dump($feedsresult);
            //$this->response["userfeeds"] = $feedsresult;
        }
        return $this->postExec($req);
    }

    private function create(Request $req) {
        $p = $req->getPostParams();

        $this->response["alarms_new_ok"] = 99;

        if (isset($p->alarms_metric) && isset($p->alarms_label) && isset($p->alarms_threshold)) {
            $result = createAlarm($req);
            if (isset($result) && $result) {
                // Alarm was created
                $this->response["alarms_new_ok"]      = 1;
                $this->response["alarms_new_alarmid"] = $result;
            }
        }

        return $this->postExec($req);
    }

    public function edit(Request $req) {
        $s      = $req->getSession();
        $p      = $req->getPostParams();
        $g      = $req->getGetParams();
        $userid = getUserId($s->get("user"));

        if (isset($p->submit) && $p->submit == FORMS_ALARMS_UPDATE) {
            return $this->update($req);
        }

        if (isset($g->faid)) {
            $this->response["sensors"] = pullFeedGetSensorNames(getAllFeedsByUserId($userid), false);
            $this->response["methods"] = pullFeedGetMethodNames(getAllFeedsByUserId($userid), false);
            $result                    = getUserAlarm($g->faid);
            if (isset($result) && $result) {
                $this->response["userAlarm"]      = $result;
                $this->response["alarms_edit"]    = 1;
                $this->response["alarms_alarmid"] = $g->faid;
            }
        }

        return $this->postExec($req);
    }

    private function update(Request $req) {
        $p = $req->getPostParams();

        $this->response["alarms_update_ok"] = 99; // Default state error

        if (isset($p->alarms_metric) && isset($p->alarms_label) && isset($p->alarms_threshold)) {
            $result = updateAlarm($req);
            if (isset($result) && $result) {
                // Alarm was updated
                $this->response["alarms_update_ok"]  = 1;
                $this->response["alarms_update_msg"] = $result;
            }
        }

        return $this->postExec($req);
    }

    public function delete(Request $req) {
        $g = $req->getGetParams();

        $this->response["alarms_delete_ok"] = 99; // Default state error

        if (isset($g->faid)) {
            $result = deleteAlarm($req);
            if (isset($result) && $result) {
                $this->response["alarms_delete_ok"]  = 1;
                $this->response["alarms_delete_msg"] = $result;
            }
        }

        return $this->postExec($req);
    }

    public function deactivate(Request $req) {
        $g = $req->getGetParams();

        $this->response["alarms_deactivate_ok"] = 99; // Default state error

        if (isset($g->faid)) {
            $result = activateAlarm($req, 0);
            if (isset($result) && $result) {
                $this->response["alarms_deactivate_ok"] = 1;
                //$this->response["alarms_result_msg"] = $g->faid;
            }
        }

        return $this->postExec($req);
    }

    public function activate(Request $req) {
        $g = $req->getGetParams();

        $this->response["alarms_activate_ok"] = 99; // Default state error

        if (isset($g->faid)) {
            $result = activateAlarm($req, 1);
            if (isset($result) && $result) {
                $this->response["alarms_activate_ok"] = 1;
                //$this->response["alarms_result_msg"] = $g->faid;
            }
        }

        return $this->postExec($req);
    }

    public function log(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();

        if (isset($g->faid) && checkIfLoggingAlarms($g->faid)) {
            $alarmActionLogs       = getAlarmActionsLogs($s->get("user"), $g->faid, 1);
            $alarmNotificationLogs = getAlarmNotificationsLogs($s->get("user"), $g->faid, 1);
            if (isset($alarmNotificationLogs) && $alarmNotificationLogs) {
                $this->response["alarmsNotification_logs"]     = 1;
                $this->response["alarmsNotifications_alarmid"] = $g->faid;
                $this->response["alarmsNotificationsLogs"]     = $alarmNotificationLogs;
            }
            if (isset($alarmActionLogs) && $alarmActionLogs) {
                $this->response["alarmsActions_logs"]    = 1;
                $this->response["alarmsActions_alarmid"] = $g->faid;
                $this->response["alarmsActionsLogs"]     = $alarmActionLogs;
            }
        }

        return $this->postExec($req);
    }

    public function index(Request $req) {
        $s                                           = $req->getSession();
        $userid                                      = getUserId($s->get("user"));
        $this->response["useralarms"]                = getUserAlarms($s->get("user"), $userid);
        $this->response["number_of_alarms_per_user"] = getUserAlarmsCount($s->get("user"), $userid);

        return $this->response;
    }

    public function postExec(Request $req) {
        return $this->reloadData($req);
    }

    private function reloadData(Request $req) {
        $s      = $req->getSession();
        $userid = getUserId($s->get("user"));

        $this->response["alarmtypes"]                = getAlarmTypes();
        $this->response["useralarms"]                = getUserAlarms($s->get("user"), $userid);
        $this->response["number_of_alarms_per_user"] = getUserAlarmsCount($s->get("user"), $userid);

        return $this->response;
    }

}
