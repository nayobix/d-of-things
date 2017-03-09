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
 * Description of SignupController
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class SignupController implements IController {

    private $response = [];

    /**
     *  class constructor
     * 
     */
    public function __construct() {
        $this->response["signup"]         = 1;
        $this->response["smartyFilename"] = "signup";
    }

    public function index(Request $req) {
        $p = $req->getPostParams();

        if (isset($p->submit) && $p->submit == SIGNUP_FORMS_SIGNUP) {
            return $this->update($req);
        }

        return $this->response;
    }

    private function update(Request $req) {
        $e                = getSiteEnvSettings();
        $p                = $req->getPostParams();
        $use_verify_email = $e ["use_verify_email"];

        $this->response["login_error"]   = 0;
        $this->response["error_message"] = 0;
        $this->response["success"]       = 0;

        $result = registerUser($req, $p->user, $p->pass, $p->email);
        if (isset($result) && $result == 99) {
            $this->response["dofthingsRedirect"] = "/login";
            if ($use_verify_email) {
                $this->response["success"] = REGISTRATION_SUCCESS_VERIFY;
            } else {
                $this->response["success"] = REGISTRATION_SUCCESS;
            }
        } else {
            $this->response["formuser"] = viewOnPage($p->user);

            // Errors during registration so build the list of errore
            $content = '';
            if (in_array(1, $result)) {
                $content                      .= "" . ALREADY_USER_ERROR . "<br />";
                $this->response["user_error"] = 1;
            }
            if (in_array(2, $result)) {
                $content                      .= "" . VALIDATE_EMAIL_ERROR . "<br />";
                $this->response["mail_error"] = 1;
            }
            if (in_array(3, $result)) {
                $content                      .= "" . VALIDATE_USER_ERROR . "<br />";
                $this->response["user_error"] = 1;
            }
            if (in_array(4, $result)) {
                $content                      .= "" . ALREADY_EMAIL_ERROR . "<br />";
                $this->response["mail_error"] = 1;
            }
            if (in_array(9, $result)) {
                $content .= "" . SUPPLY_PASSWORD . "<br />";

                $this->response["pass_error"] = 1;
            }
            $this->response["error_message"] = $content;
        }

        return $this->postExec($req);
    }

    public function postExec(Request $req) {
        return $this->reloadData($req);
    }

    private function reloadData(Request $req) {
        return $this->response;
    }

}
