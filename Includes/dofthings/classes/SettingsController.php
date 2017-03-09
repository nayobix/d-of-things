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
 * Description of SettingsController
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class SettingsController implements IController {

    private $response = [];

    /**
     *  class constructor
     * 
     */
    public function __construct(Request $req) {
        $s = $req->getSession();

        if (checkIfAdmin($s->get("user"), $s->get("pass"))) {
            $this->response["settings"]       = 1;
            $this->response["smartyFilename"] = "settings";
            $this->response["s"]              = getSiteEnvSettings();
            $this->response["timezones_list"] = \DateTimeZone::listIdentifiers();
        } else {
            $this->response["dofthingsRedirect"] = "/index";
        }
    }

    public function index(Request $req) {
        $p = $req->getPostParams();
        $s = $req->getSession();

        if (isset($p->submit) &&
                $p->submit == SETTINGS_FORMS_UPDATE &&
                checkIfAdmin($s->get("user"), $s->get("pass"))) {
            return $this->update($req);
        }

        return $this->response;
    }

    private function update(Request $req) {
        $this->response["settings_update_ok"] = 99; // Default state error

        $result = updateSiteEnvSettings($req);
        if (isset($result) && $result) {
            // Profile was updated
            $this->response["settings_update_ok"] = 1;
            // $this->response["settings_update_msg"] = $result;
        }

        return $this->postExec($req);
    }

    public function postExec(Request $req) {
        return $this->reloadData($req);
    }

    private function reloadData(Request $req) {
        $s = $req->getSession();

        if (checkIfAdmin($s->get("user"), $s->get("pass"))) {
            $this->response["s"]              = getSiteEnvSettings();
            $this->response["timezones_list"] = \DateTimeZone::listIdentifiers();
        }


        return $this->response;
    }

}
