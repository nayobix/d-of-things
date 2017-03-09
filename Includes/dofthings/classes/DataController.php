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
 * Description of DataController
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class DataController implements IController {

    private $header;
    private $msg;
    private $DEBUG = 0;

    //
    // '{"devices": [
    // "deviceName":"device1",
    // "deviceID":1,
    // "sensors":[{"sensorName": "sen4", "sensorValue": 16},{"sensorName": "sen3", "sensorValue": 17}],
    // "methods":[{"methodName": "openDoor", "methodAction": "http://"},{"methodName": "closeDoor", "methodAction": "http://"}],
    // "timestamp":1234567890,
    // ]
    // }'

    /**
     *  class constructor
     * 
     */
    public function __construct() {
        //Init default values in case we should return immediately
        error_reporting(E_ALL);
        ini_set("display_errors", "On");
        $this->header = "HTTP/1.0 201 ok";
        $this->msg    = "ok";
    }

    public function push(Request $req) {
        $g       = $req->getGetParams();
        $feedid  = $g->feedid;
        $keyhash = $g->keyhash;
        $what    = "push";

        $this->isFeedActivated($feedid, $keyhash, $what);

        $perms = getKeyHashPerms($keyhash);
        if ($perms >= 2) {
            $jSon = file_get_contents('php://input');
            // echo "\n";
            // echo var_dump(json_decode("$jSon"));
            if (isJson($jSon)) {
                $jSon       = str_replace("\"TSNONE\"", time(), $jSon);
                $this->printIfDebug("DATA: $jSon");
                $mongoTable = getMongoDBTable($g->feedid);
                if ($mongoTable) {
                    // Make json string as json object
                    $json_obj = json_decode($jSon);
                    $alarmret = false;

                    // Logging
                    if (checkIfLogging($feedid)) {
                        pushFeedLogs($feedid, $jSon);
                    }

                    // Alarming and notifications
                    if (checkAlarmDefined($g->feedid, $json_obj)) {
                        $this->printIfDebug("\nALARM - YES\n");
                        $alarmret = updateAlarmNotification($feedid, $json_obj);
                        $this->printIfDebug("\nALARMS: $alarmret\n");
                    }

                    // Pushing data to DBs
                    $resultnosql = pushFeedData($jSon, $json_obj, $mongoTable);
                    if (!$resultnosql) {
                        $this->header = "HTTP/1.0 404 error";
                        $this->msg    = "error,insertnosql";
                    }
                    $resultrrd = pushFeedDataRRD($jSon, $json_obj);
                    if (!$resultrrd) {
                        echo "Can not insert to RRD DB";
                    }
                }
            } else {
                $this->header = 'HTTP/1.0 404 notJSON';
                $this->msg    = "notJSON";
                $this->printIfDebug("DATA: $jSon");
            }
        } else {
            $this->header = 'HTTP/1.0 404 perms';
            $this->msg    = "perms";
        }

        return $this->returnData();
    }

    public function pull(Request $req) {
        $g          = $req->getGetParams();
        $feedid     = $g->feedid;
        $keyhash    = $g->keyhash;
        $deviceID   = $g->deviceID;
        $deviceName = $g->deviceName;
        $objectName = $g->objectName;
        $objectType = $g->objectType;
        $tsstart    = $g->tsstart;
        $tsend      = $g->tsend;
        $what       = "pull";

        $this->isFeedActivated($feedid, $keyhash, $what);

        $perms        = getKeyHashPerms($keyhash);
        $this->header = 'HTTP/1.0 404 perms';
        $this->msg    = "perms";

        if ($perms == 2 || $perms == 4) {
            $mongoTable = getMongoDBTable($feedid);
            if ($mongoTable) {
                // /dataPull/pull/4/f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8/device1/1/Sensor/sen4/1111111111/12345678990
                $mdeviceid    = intval($deviceID);
                $mtsstart     = ($tsstart > 1300000000) ? $tsstart : time() - (2 * 24 * 60 * 60); // Two days ago, if timestamp is not requested by the user (1300000000 - March 2014)
                $mtsend       = ($tsend > 1300000000) ? $tsend : time(); // Current timestamp if it is not requested by the user (1300000000 - March 2014)
                $mtsstart     *= 1; // Sometimes there is issue with getting values from _GET or _POST - numeric values issue
                $mtsend       *= 1;
                $json         = pullFeedData($feedid, $keyhash, $deviceName, $mdeviceid, $objectType, $objectName, $mtsstart, $mtsend, $mongoTable);
                $this->header = "Content-type: application/json";
                $this->msg    = "$json";
            }
        }

        return $this->returnData();
    }

    public function pullLast(Request $req) {
        $g          = $req->getGetParams();
        $feedid     = $g->feedid;
        $keyhash    = $g->keyhash;
        $deviceID   = $g->deviceID;
        $deviceName = $g->deviceName;
        $objectName = $g->objectName;
        $objectType = $g->objectType;
        $what       = "pull";

        $this->isFeedActivated($feedid, $keyhash, $what);

        $perms        = getKeyHashPerms($keyhash);
        $this->header = 'HTTP/1.0 404 perms';
        $this->msg    = "perms";

        if ($perms == 2 || $perms == 4) {
            $mongoTable = getMongoDBTable($feedid);
            if ($mongoTable) {
                // /dataPull/pullLast/4/f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8/device1/1/Sensor/sen4/1111111111/12345678990
                $mdeviceid    = intval($deviceID);
                $json         = pullLastFeedData($feedid, $keyhash, $deviceName, $mdeviceid, $objectType, $objectName, $mongoTable);
                $this->header = "Content-type: application/json";
                $this->msg    = "$json";
            }
        }

        return $this->returnData();
    }

    public function execute(Request $req) {
        $g            = $req->getGetParams();
        $p            = $req->getPostParams();
        $feedid       = $g->feedid;
        $keyhash      = $g->keyhash;
        $objectName   = $p->objectName;
        $objectType   = $p->objectType;
        $objectAction = $p->objectAction;
        $objectValue  = $p->objectValue;
        $what         = "execute";

        $this->isFeedActivated($feedid, $keyhash, $what);

        $perms = getKeyHashPerms($keyhash);
        if ($perms == 3 || $perms == 4) {
            // /dataExecute/execute/4/f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8/
            // TODO: Next step is to add user and password protection for feedkeyhash or for feeds at all...
            $ret          = executeAction($objectType, $objectName, $objectAction, $objectValue, "", "");
            $this->header = "Content-type: application/json";
            $this->msg    = $ret;
        } else {
            $this->header = 'HTTP/1.0 404 perms';
            $this->msg    = "perms";
        }

        return $this->returnData();
    }

    public function pullFeedGetSensorNames(Request $req) {
        $s = $req->getSession();

        $json         = pullFeedGetSensorNames(getAllFeedsByUserId(getUserId($s->get("user"))), true);
        $this->header = "Content-type: application/json";
        $this->msg    = "$json";
        return $this->returnData();
    }

    public function pullFeedGetMethodNames(Request $req) {
        $s = $req->getSession();

        $json      = pullFeedGetMethodNames(getAllFeedsByUserId(getUserId($s->get("user"))), true);
        header("Content-type: application/json");
        $this->msg = "$json";
        return $this->returnData();
    }

    public function pushTest(Request $req) {
        $this->header = "Content-type: application/json";
        $this->msg    = "OK";
        return $this->returnData();
    }

    private function printIfDebug($msg) {
        $DEBUG = $this->DEBUG;

        if ($DEBUG) {
            echo ($msg);
        }
    }

    private function isFeedActivated($feedid, $keyhash, $what) {
        if (!(checkFeedsKeyHash($keyhash) && checkFeedId($feedid) &&
                checkMappingFeedKeyHash($feedid, $keyhash) &&
                checkRemoteActionPerms($keyhash, $what))) {
            $this->header = 'HTTP/1.0 404 deactivated';
            $this->msg    = "deactivated";
            return $this->returnData();
        }
    }

    private function returnData() {
        if ($this->header) {
            header($this->header);
        }

        echo "$this->msg";
        exit(0);
    }

    public function index(Request $req) {
        return $this->returnData();
    }

    public function postExec(Request $req) {
        
    }

}
