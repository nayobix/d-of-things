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

namespace Dofthings\App;

use Dofthings\Classes\Request;
use Dofthings\Classes\Session;
use Dofthings\Classes\Cookie;

require_once './Includes/Smarty-3.1.15/libs/Smarty.class.php';

/**
 * Description of Main
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class Main {

    private static $instance = NULL;
    private $smarty          = NULL;
    private $env             = NULL;
    private $post_req;
    private $get_req;
    private $url_controller;
    private $url_action;
    private $url_args;

    private function __construct() {
        
    }

    public static function getInstance() {

        if (self::$instance == NULL) {
            self::$instance = new Main();
        }

        return self::$instance;
    }

    public function run() {
        $req      = new Request();
        $s        = $req->getSession();
        $c        = $req->getCookie();
        //$s->dump();
        //$c->dump();
        //$req->dump();
        //exit(0);
        $this->redirectIfNeeded($req);
        $response = $this->execute($req);
        $req      = NULL;
        $filename = $this->parseResponse($response);
        $this->redirect($response);
        $this->display($filename);
    }

    public function execute(Request $req) {
        $controller = '\\Dofthings\\Classes\\' . $req->getController();
        $action     = $req->getAction();
        $res        = \call_user_func([new $controller($req), $action], $req);

        return $res;
    }

    public function getSmarty() {
        // Make Smarty object    
        if ($this->smarty == NULL) {
            $this->smarty                  = new \Smarty();
            $this->smarty->force_compile   = FORCE_COMPILE_ENABLED;
            $this->smarty->error_reporting = error_reporting() & ~E_NOTICE;
        }
        return $this->smarty;
    }

    //Get enviorment settings from DB
    public function getEnvSettings() {

        $sql = "SELECT * FROM env_settings";
        $res = sqlQuery($sql);
        if (empty($res)) {
            die(DATABASE_EMPTY_ERROR);
        }

        if (sqlErrorReturn()) {
            sqlDebug(__FILE__, __LINE__, sqlErrorReturn());
        }

        $a_row     = sqlFetchAssoc($res);
        $this->env = new \stdClass();
        if ($a_row) {
            foreach ($a_row as $key => $value) {
                $this->env->$key = $value;
            }
        }
        return $this->env;
    }

    public function setSmartyTemplateDir($name) {
        $smarty = $this->getSmarty();
        if ($smarty != NULL) {
            if (file_exists("templates/" . TEMPLATE_DIR . "/$name.tpl")) {
                $smarty->template_dir = "templates/" . TEMPLATE_DIR;
            } else {
                $smarty->template_dir = "templates/Default";
            }
        }
    }

    public function redirectIfNeeded(Request $req) {
        $app    = \Dofthings\App\Main::getInstance();
        $smarty = $app->getSmarty();
        $e      = $app->getEnvSettings();

        $controller = $req->getController();
        $action     = $req->getAction();
        $s          = $req->getSession();
        $c          = $req->getCookie();

        // Do not redirect on controller/action combination below
        if ($controller === "AlarmsController" && $action == "notify") {
            return;
        } elseif ($controller === "DataController" && $action !== "") {
            return;
        } elseif ($controller === "DashboardsController" && $action == "visualize" && $s->get("user") == "") {
            return;
        } elseif ($controller === "SignupController" && $s->get("user") == "") {
            return;
        } elseif ($controller === "AboutController") {
            return;
        } elseif ($controller === "ContactController") {
            return;
        }

        // Check if single user mode 1 or multi-user mode 0
        if ($e->site_mode == 0) {
            $smarty->assign("site_mode", 1);
        }

        // Check if single user mode 1 or multi-user mode 0
        if ($e->site_mode == 1) {
            $smarty->assign("single_mode", 1);
        }

        if ($s->get("logged_in") && $s->get("user") && $s->get("pass")) {
            if ($controller === "LoginController" && $action == "index") {
                header("Location: /index");
                exit();
            } elseif (checkIfAdmin($s->get("user"), $s->get("pass"))) {
                $s->set("admin", 1);
                $smarty->assign("logged_in", 1);
                $smarty->assign("admin", 1);
                $smarty->assign("username", $s->get("user"));
                $status = checkPrivs($req);
                $smarty->assign("$status", 1);
            } elseif (checkIfUser($s->get("user"), $s->get("pass"))) {
                $s->set("user_role", 1);
                $smarty->assign("logged_in", 1);
                $smarty->assign("username", $s->get("user"));
                $status = checkPrivs($req);
                $smarty->assign("$status", 1);
            } else {
                exit(0);
                header("Location: /index");
                exit(0);
            }
        } elseif (!$s->get("logged_in")) {
            if ($controller === "IndexController") {
                $smarty->assign("logged_in", 0);
                $smarty->assign("admin", 0);
                $smarty->assign("user_role", 0);
                // Destroy session
                $s->destroy();
            } elseif ($controller !== "LoginController") {
                header("Location: /login");
                exit();
            }
        }
    }

    private function parseResponse($response) {
        $smarty = $this->getSmarty();

        foreach ($response as $key => $value) {
            $smarty->assign($key, $value);
        }

        return $response["smartyFilename"];
    }

    public function redirect($response) {
        if (isset($response["dofthingsNoSmartyRedirect"])) {
            isset($response["dofthingsNoSmartyHeader"]) ?
                            header($response["dofthingsNoSmartyHeader"]) : "";
            echo $response["dofthingsNoSmartyMsg"];
            exit(0);
        } elseif (isset($response["dofthingsRedirect"])) {
            $location = "Location: " . $response["dofthingsRedirect"];
            header($location);
            exit(0);
        }
    }

    public function display($name) {
        $smarty = $this->getSmarty();

        $this->setSmartyTemplateDir($name);
        $smarty->display($name . '.tpl');
    }

    public function logToApache($Message) {
        $stderr = fopen('php://stderr', 'e');
        fwrite($stderr, $Message);
        fclose($stderr);
    }

}
