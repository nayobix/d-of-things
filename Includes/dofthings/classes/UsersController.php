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
 * Description of UsersController
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class UsersController implements IController {

    private $response = [];

    /**
     *  class constructor
     * 
     */
    public function __construct(Request $req) {
        $s = $req->getSession();

        if (checkIfAdmin($s->get("user"), $s->get("pass"))) {
            $this->response["u"]               = getUsers();
            $this->response["number_of_users"] = getUsersCount();
            $this->response["users"]           = 1;
            $this->response["smartyFilename"]  = "users";
        } else {
            $this->response["dofthingsRedirect"] = "/index";
        }
    }

    public function activate(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();

        $this->response["users_activate_ok"] = 99; // Default state error

        if (isset($g->uid) && checkIfAdmin($s->get("user"), $s->get("pass"))) {
            $result = activateUser($g->uid, 1);
            if (isset($result) && $result) {
                $this->response["users_uid"]         = $g->feedid;
                $this->response["users_activate_ok"] = 1;
            }
        }
        return $this->postExec($req);
    }

    public function deactivate(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();

        $this->response["users_deactivate_ok"] = 99; // Default state error

        if (isset($g->uid) && checkIfAdmin($s->get("user"), $s->get("pass"))) {
            $result = activateUser($g->uid, 0);
            if (isset($result) && $result) {
                $this->response["users_uid"]           = $g->feedid;
                $this->response["users_deactivate_ok"] = 1;
            }
        }
        return $this->postExec($req);
    }

    public function delete(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();

        $this->response["users_delete_ok"] = 99; // Default state error

        if (isset($g->uid) && checkIfAdmin($s->get("user"), $s->get("pass"))) {
            $result = deleteUser($g->uid);
            if (isset($result) && $result) {
                $this->response["users_uid"]       = $g->uid;
                $this->response["users_delete_ok"] = 1;
            }
        }
        return $this->postExec($req);
    }

    public function makeuser(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();

        $this->response["users_makeuser_ok"] = 99; // Default state error

        if (isset($g->uid) && checkIfAdmin($s->get("user"), $s->get("pass"))) {
            changeUserRole($g->uid, $req->getAction());
            if (isset($result) && $result) {
                $this->response["users_uid"]         = $g->feedid;
                $this->response["users_makeuser_ok"] = 1;
            }
        }
        return $this->postExec($req);
    }

    public function makeadmin(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();

        $this->response["users_makeadmin_ok"] = 99; // Default state error

        if (isset($g->uid) && checkIfAdmin($s->get("user"), $s->get("pass"))) {
            changeUserRole($g->uid, $req->getAction());
            if (isset($result) && $result) {
                $this->response["users_uid"]          = $g->feedid;
                $this->response["users_makeadmin_ok"] = 1;
            }
        }
        return $this->postExec($req);
    }

    public function index(Request $req) {
        return $this->response;
    }

    public function postExec(Request $req) {
        return $this->reloadData($req);
    }

    private function reloadData(Request $req) {
        $s = $req->getSession();

        if (checkIfAdmin($s->get("user"), $s->get("pass"))) {
            $this->response["u"]               = getUsers();
            $this->response["number_of_users"] = getUsersCount();
            $this->response["users"]           = 1;
        }

        return $this->response;
    }

}
