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

/**
 * Description of Cookie
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class Cookie {

    function __construct() {
        //if a remember me cookie was set on a previous visit check for cookie
        if (isset($_COOKIE["user"])) {
            $_COOKIE = codeClean($_COOKIE);
            if (verifyCookie($_COOKIE["user"], $_COOKIE["pass"])) {
                session_regenerate_id();
                $_SESSION["user"]      = $_COOKIE["user"];
                $_SESSION["username"]  = $_COOKIE["user"];
                $_SESSION["pass"]      = $_COOKIE["pass"];
                $_SESSION["logged_in"] = 1;

                if (checkIfAdmin($_SESSION["user"], $_SESSION["pass"]))
                    $_SESSION["admin"]     = 1;
                if (checkIfUser($_SESSION["user"], $_SESSION["pass"]))
                    $_SESSION["user_role"] = 1;
            }
            //} else {
            //    // TODO: make Cookie loadable through properties
            //    $_SESSION = $properties;
        }
    }

    public function set($u, $p) {
        setcookie("user", $u, time() + (60 * 60 * 24 * 30));
        setcookie("pass", "$p", time() + (60 * 60 * 24 * 30));
    }

    public function destroy() {
        setcookie("user", NULL, time() - 3600);
        setcookie("pass", NULL, time() - 3600);

        setcookie(session_name(), NULL, time() - 3600);
    }

    public function dump() {
        foreach ($_COOKIE as $key => $value) {
            echo "<hr> Cookie - Key: $key, Value: $value";
        }
    }

}
