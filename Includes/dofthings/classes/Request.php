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

use InvalidArgumentException;
use Dofthings\Classes\Session;
use Dofthings\Classes\Cookie;

/**
 * Description of Request
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class Request {

    const DEFAULT_CONTROLLER = "Index";
    const DEFAULT_ACTION     = "index";

    private $uri             = "";
    private $controller      = self::DEFAULT_CONTROLLER;
    private $action          = self::DEFAULT_ACTION;
    private $get_params      = NULL;
    private $post_params     = NULL;
    private $post_params_row = "";
    private $SERVER          = "";
    private $GET             = "";
    private $GET_RAW         = "";
    private $POST            = "";
    private $POST_RAW        = "";
    private $session         = NULL;
    private $cookie          = NULL;

    function __construct() {
        $cookie = new Cookie();
        $this->setCookie($cookie);

        $session = new Session();
        $this->setSession($session);

        $this->uri = $_SERVER["REQUEST_URI"];

        try {
            $this->setController(isset($_GET["ctrl"]) ? $_GET["ctrl"] : self::DEFAULT_CONTROLLER);
            $this->setAction(isset($_GET["action"]) ? $_GET["action"] : self::DEFAULT_ACTION);
        } catch (InvalidArgumentException $ex) {
            error_log("Exception: " . $ex);
        }

        $this->SERVER   = $_SERVER;
        $this->GET      = codeClean($_GET);
        $this->GET_RAW  = $_GET;
        $this->POST     = codeClean($_POST);
        $this->POST_RAW = $_POST;
        $this->setGetParams($_GET);
        $this->setPostParams($_POST);
        $this->setPostParamsAsRow($_POST);
        //filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_STRING);
    }

    /**
     * Return requested controller
     *
     * @return string
     */
    public function getController() {
        return $this->controller;
    }

    /**
     * Return requested uri
     *
     * @return string
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * Return requested method
     *
     * @return string
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * Return GET params
     *
     * @return array()
     */
    public function getGetParams() {
        return $this->get_params;
    }

    /**
     * Return POST params row
     *
     * @return array()
     */
    public function getPostParamsAsRow() {
        return $this->post_params_row;
    }

    /**
     * Return POST params
     *
     * @return array()
     */
    public function getPostParams() {
        return $this->post_params;
    }

    public function setController($controller) {
        $controller = ucfirst(strtolower($controller)) . "Controller";
        if (!\class_exists('\\Dofthings\\Classes\\' . $controller)) {
            throw new InvalidArgumentException(
            "The controller '$controller' hasn't been defined.");
        }
        $this->controller = $controller;
    }

    public function setAction($action) {
        $reflector = new \ReflectionClass('\\Dofthings\\Classes\\' . $this->controller);
        if (!$reflector->hasMethod($action)) {
            throw new InvalidArgumentException(
            "The controller action '$action' hasn't been defined.");
        }
        $this->action = $action;
    }

    /**
     * Set list of GET parameters
     *
     * @param array $params
     */
    public function setGetParams(array $params) {
        $tmp              = new \stdClass();
        $this->get_params = new \stdClass();
        foreach ($params as $key => $value) {
            $tmp->$key = $value;
        }
        $this->get_params = $tmp;
    }

    /**
     * Set list of POST parameters
     *
     * @param array $params
     */
    public function setPostParams(array $params) {
        $tmp               = new \stdClass();
        $this->post_params = new \stdClass();
        foreach ($params as $key => $value) {
            $tmp->$key = $value;
        }
        $this->post_params = $tmp;
    }

    /**
     * Set list of POST parameters in a row fields
     *
     * @param array $params
     */
    public function setPostParamsAsRow(array $params) {
        $rowstr = '';
        foreach ($params as $field => $value) {
            if ("$field" != "submit") {
                $rowstr .= "$field = '" . $value . "', ";
            }
        }
        $this->post_params_row = $rowstr;
    }

    /**
     * Set Session parameter
     *
     * @param Session $session
     */
    public function setSession(Session $session) {
        $this->session = $session;
    }

    /**
     * Get Session parameter
     *
     * @param Session $session
     */
    public function getSession() {
        return $this->session;
    }

    /**
     * Set Cookie parameter
     *
     * @param Session $session
     */
    public function setCookie(Cookie $cookie) {
        $this->cookie = $cookie;
    }

    /**
     * Get Cookie parameter
     *
     * @param Session $session
     */
    public function getCookie() {
        return $this->cookie;
    }

    /**
     * Dump content
     *
     * @param Session $session
     */
    public function dump() {
        print("<div>");
        print("<hr>uri: $this->uri");
        print("<hr>controller: $this->controller");
        print("<hr>action: $this->action");
        print("<hr>get_params: " . print_r($this->get_params));
        print("<hr>post_params: " . print_r($this->post_params));
        print("<hr>SERVER: " . var_dump($this->SERVER));
        print("<hr>GET: " . var_dump($this->GET));
        print("<hr>POST: " . var_dump($this->POST));
        print("<hr>GET_RAW: " . var_dump($this->GET_RAW));
        print("<hr>POST_RAW: " . var_dump($this->POST_RAW));
        print("<hr>session: " . var_dump($this->session));
        print("</div>");
    }

}
