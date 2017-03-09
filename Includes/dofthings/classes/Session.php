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
 * Description of Session
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class Session {

    private $params = [];

    function __construct() {
        $this->copy($_SESSION);
    }

    public function regenerate() {
        session_regenerate_id();
        $this->copy($_SESSION);
    }

    public function is_set($key) {
        return isset($_SESSION[$key]);
    }

    public function set($key, $value) {
        $this->params[$key] = $value;

        $_SESSION[$key] = $value;
    }

    public function del($key) {
        unset($_SESSION[$key]);
        $this->params[$key] = "";
    }

    public function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
    }

    public function dump() {
        foreach ($_SESSION as $key => $value) {
            echo "Session - Key: $key, Value: $value <hr />";
        }
    }

    public function destroy() {
        session_status() == PHP_SESSION_ACTIVE ? session_destroy() : "";
        foreach ($_SESSION as $key) {
            $this->del($key);
        }
    }

    public function copy($s) {
        foreach ($s as $key => $value) {
            $this->params[$key] = $value;
        }
    }

}
