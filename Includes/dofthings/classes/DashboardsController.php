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
 * Description of DashboardsController
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class DashboardsController implements IController {

    private $response = [];

    /* Save parameters */
    private $SAVEDEBUG = 1;
    private $debugmsg;
    private $save;
    private $dashboardid;
    private $what;
    private $executed_action;
    private $header;
    private $htmldata;
    private $zoom;
    private $description;
    private $move;
    private $style;
    private $background;
    private $resolution;
    private $title;

    /**
     *  class constructor
     * 
     */
    public function __construct(Request $req) {
        $s      = $req->getSession();
        $userid = getUserId($s->get("user"));

        //Init default values in case we should return immediately
        $this->response["smartyFilename"] = "dashboards";
        $this->response["dashboards"]     = 1;

        // Initalize variables to store default errorness values. If action executes properly update those variables
        $this->debugmsg             = "NaN";
        $this->save                 = "NaN";
        $this->dashboardid          = "NaN";
        $this->what                 = "NaN";
        $this->executed_action      = "NaN";
        $this->header               = "";
        $this->response["debug"]    = $this->SAVEDEBUG;
        $this->response["debugmsg"] = "";
    }

    public function index(Request $req) {
        return $this->postExec($req);
    }

    public function delete(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();

        $this->response["dashboards_delete_ok"] = 99;

        if (isset($g->dashid)) {
            $result = deleteDashboardId($s->get("user"), $g->dashid);
            if (isset($result) && $result) {
                $this->response["dashboards_dashid"]    = $g->dashid;
                $this->response["dashboards_delete_ok"] = 1;
            }
        }

        return $this->postExec($req);
    }

    public function deactivate(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();

        $this->response["dashboards_deactivate_ok"] = 99;

        if (isset($g->dashid)) {
            $result = activateDashboardId($s->get("user"), $g->dashid, 0);
            if (isset($result) && $result) {
                $this->response["dashboards_dashid"]        = $g->dashid;
                $this->response["dashboards_deactivate_ok"] = 1;
            }
        }

        return $this->postExec($req);
    }

    public function activate(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();

        $this->response["dashboards_activate_ok"] = 99;

        if (isset($g->dashid)) {
            $result = activateDashboardId($s->get("user"), $g->dashid, 1);
            if (isset($result) && $result) {
                $this->response["dashboards_dashid"]      = $g->dashid;
                $this->response["dashboards_activate_ok"] = 1;
            }
        }

        return $this->postExec($req);
    }

    public function visualize(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();

        $this->response["dashboards_activate_ok"] = 99;

        if (isset($g->dashid)) {
            $result = getDashboardById(getUserId($s->get("user")), $g->dashid);
            if (isset($result) && $result) {
                $this->response["dashboards_dashboard"] = $result;
                $this->response["dashboards_dashid"]    = $g->dashid;
                $this->response["dashboards_visualize"] = 1;
            } elseif (getUserId($s->get("user")) !== "") {
                // If still logged but dashboard isn't active, then redirect
                $this->response["dofthingsRedirect"] = "/dashboards";
            } else {
                // If not logged and dashboard isnt sharable then redirect
                $this->response["dofthingsRedirect"] = "/index";
            }
        }

        return $this->response;
    }

    public function savetest(Request $req) {
        $this->save        = 1;
        $this->dashboardid = "OK";

        return $this->returnData();
    }

    public function savedashboardelements(Request $req) {
        $p = $req->getPostParams();

        if (isset($p->dashboard)) {
            $this->data = $p->dashboard;
        }

        return $this->returnData();
    }

    public function savedashboard(Request $req) {
        $p = $req->getPostParams();

        // insertDashboardEntry($title,$resolution,$background,$share,$htmldata)
        // isset($_POST["dashboardid"]) ? $dashboardid = $_POST["dashboardid"] : $dashboardid = "nan"; //Default value nan - Dashboard isn't created
        empty($p->dashboardid) ? $this->dashboardid    = "nan" : $this->dashboardid    = $p->dashboardid; // Default value nan - Dashboard isn't created
        isset($p->name) ? $this->title          = $p->name : $this->title          = "Default Title";
        isset($p->resolution) ? $this->resolution     = $p->resolution : $this->resolution     = "1280x1024";
        isset($p->background) ? $this->background     = $p->background : $this->background     = "Filepath:\\;white";
        isset($p->htmldata) ? $this->htmldata       = $p->htmldata : $this->this->htmldata = ""; // Default value null
        isset($p->share) ? $this->share          = $p->share : $this->share          = "0"; // Default value 0 #Don't share
        isset($p->zoom) ? $this->zoom           = $p->zoom : $this->zoom           = "0"; // Default value 0 #Don't zoom
        isset($p->move) ? $this->move           = $p->move : $this->move           = "0"; // Default value 0 #Don't move
        isset($p->description) ? $this->description    = $p->description : $this->description    = ""; // Default value - Empty description
        isset($p->style) ? $this->style          = $p->style : $this->style          = ""; // Default value - Empty style
        // VERIFY THAT htmldata contains the proper data - no javascript executables and xss attacks...
        if ($this->htmldata) {
            $retarray              = insertDashboardEntry($req, $this->dashboardid, $this->title, $this->resolution, $this->background, $this->share, "$this->htmldata", $this->zoom, $this->move, $this->description, $this->style);
            $ret                   = $retarray [0];
            $this->executed_action = $retarray [1];
            if ($ret) {
                $this->save            = 1;
                $this->executed_action = ($this->dashboardid == $ret) ? "Updated!" : "Created!";
                $this->dashboardid     = $ret;
                $this->what            = $req->getAction();
            }
        } else {
            $this->header = "HTTP/1.0 404 data";
        }

        return $this->returnData();
    }

    private function returnData() {
        $this->response["dofthingsNoSmartyRedirect"] = 1;

        if ($this->header) {
            $this->response["dofthingsNoSmartyHeader"] = $this->header;
        }

        $this->response["dofthingsNoSmartyMsg"] = "{\"response\": $this->save, \"id\": \"$this->dashboardid\", \"executed_action\": \"$this->executed_action\", \"updated_what\": \"$this->what\", \"debugmsg\": \"$this->debugmsg\"}";

        return $this->response;
    }

    public function postExec(Request $req) {
        return $this->reloadData($req);
    }

    private function reloadData(Request $req) {
        $s                                               = $req->getSession();
        $userid                                          = getUserId($s->get("user"));
        $this->response["userdashboards"]                = getUserDashboards($s->get("user"), $userid);
        $this->response["number_of_dashboards_per_user"] = getUserDashboardsCount($s->get("user"), $userid);

        return $this->response;
    }

}
