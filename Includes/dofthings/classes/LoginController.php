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
 * Description of LoginController
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class LoginController implements IController {

    private $response = [];

    /**
     *  class constructor
     * 
     */
    function __construct() {
        // Inialize variables used in templates
        $this->response["login_error"]   = 0;
        $this->response["error_message"] = 0;
        $this->response["success"]       = 0;

        //Init default values in case we should return immediately
        $this->response["smartyFilename"] = "login";
        $this->response["login"]          = 1;
    }

    public function verify(Request $req) {
        $e	= getSiteEnvSettings();
        $g 	= $req->getGetParams();

        if ($e["use_verify_email"]) {
            if (isset($g->cid)) {
                $confirmation_id = codeClean($g->cid);
                $res             = activateProfile($confirmation_id);
                if ($res == 99) {
                    // account email validation was successful
                    $this->response["success"] = ACCOUNT_VALIDATION_SUCCESS;
                } else {
                    // there was an error with the account email validation
                    if ($res == 1) {
                        $this->response["error_message"] = INVALID_CONFIRMATION_ID_ERROR;
                    }
                    if ($res == 2) {
                        $this->response["error_message"] = USER_ALREADY_ACTIVATED;
                    }
                    if ($res == 3) {
                        $this->response["error_message"] = USER_ALREADY_EXIST_ERROR;
                    }
                    if ($res == 4) {
                        $this->response["error_message"] = INVALID_TIMESTAMP_ERROR;
                    }
                    if ($res == 5) {
                        $this->response["error_message"] = INVALID_USER_ID_ERROR;
                    }
                }
            }
        }
        return $this->response;
    }

    public function index(Request $req) {

        return $this->response;
    }

    public function login(Request $req) {
        $s = $req->getSession();
        $c = $req->getCookie();
        $p = $req->getPostParams();

        // Try to login
        if (isset($p->submit) && $p->submit == FORMS_LOGIN) {
            if (validateUsername($p->user) && verifyLogin($p->user, $p->pass)) {
                // get md5 password hashes with salt and then set as session password  
                $salt                          = 's+(_a*';
                $md5pass                       = md5($p->pass . $salt);
                $this->response["login_error"] = "0";
                $this->response["logged_in"]   = 1;

                $s->set("user", $p->user);
                $s->set("pass", "$md5pass");
                $s->set("logged_in", 1);

                lastActive($req, $p->user);

                // set persistant cookie for remember me function                      
                if (isset($p->remember)) {
                    $c->set($s->get("user"), $md5pass);
                }

                if (checkIfAdmin($s->get("user"), $s->get("pass"))) {
                    $s->set("admin", 1);
                    $this->response["admin"] = 1;
                } elseif (checkIfUser($s->get("user"), $s->get("pass"))) {
                    $s->set("user_role", 1);
                    $this->response["user_role"] = 1;
                }

                $this->response["dofthingsRedirect"] = "/";
            } else {
                $this->response["login_error"] = 1;

                // there was an error with your login                                  
                if (isset($p->remember)) {
                    $this->response["formremember"] = $p->remember;
                }

                $this->response["error_message"] = LOGIN_ERROR;
                if (isset($p->user) && $p->user == "") {
                    $this->response["user_error"]    = $p->user;
                    $this->response["error_message"] = BLANK_USERNAME;
                }
            }
        }
        return $this->response;
    }

    public function logoff(Request $req) {
        /* @var $s Session */
        $s   = $req->getSession();
        $c   = $req->getCookie();
        $e   = getSiteEnvSettings();

        // when logging off delete from the online users tables if user tracking is enabled
        if (!empty($e["visitor_tracking"]) && $s->is_set("user")) {
            $sql = "DELETE FROM onlineusers WHERE user = '" . $s->user . "'";
            $del = sqlQuery($sql);
            if (sqlErrorReturn())
                sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        }

        $s->destroy();
        $c->destroy();

        // redirect to anywhere you like after logout
        $this->response["dofthingsRedirect"] = "/index";

        return $this->response;
    }

    public function postExec(Request $req) {
        
    }

}
