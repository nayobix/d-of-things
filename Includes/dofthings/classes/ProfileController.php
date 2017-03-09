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
 * Description of profile ProfileController
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class ProfileController implements IController {

    private $response = [];

    /**
     *  class constructor
     * 
     */
    public function __construct() {
        $this->response["profile"]        = 1;
        $this->response["smartyFilename"] = "profile";
    }

    public function index(Request $req) {
        $p = $req->getPostParams();
        $s = $req->getSession();

        if (isset($p->submit) && $p->submit == PROFILE_FORMS_UPDATE) {
            return $this->update($req);
        }

        $userid                 = getUserId($s->get("user"));
        $this->response["user"] = getUserProfile($userid);

        return $this->response;
    }

    private function update(Request $req) {

        $this->response["profile_update_ok"] = 99; // Default state error

        $result = updateUserProfile($req);
        if (isset($result) && $result) {
            // Profile was updated
            $this->response["profile_update_ok"] = 1;
            // $this->response["profile_update_msg"] = $result;
        }

        return $this->postExec($req);
    }

    public function postExec(Request $req) {
        return $this->reloadData($req);
    }

    private function reloadData(Request $req) {
        $s                      = $req->getSession();
        $userid                 = getUserId($s->get("user"));
        $this->response["user"] = getUserProfile($userid);

        return $this->response;
    }

}
