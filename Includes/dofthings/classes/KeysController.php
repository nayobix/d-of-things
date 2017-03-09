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
 * Description of Keys Controller
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class KeysController implements IController {

    private $response = [];

    /**
     *  class constructor
     * 
     */
    public function __construct(Request $req) {
        $s      = $req->getSession();
        $userid = getUserId($s->get("user"));

        $this->response["feedskeys"]                   = getUserFeedsKeys($s->get("user"), $userid);
        $this->response["number_of_keyskeys_per_user"] = getUserFeedsKeysCount($s->get("user"), $userid);
        $this->response["smartyFilename"]              = "keys";
        $this->response["keys"]                        = 1;
    }

    public function index(Request $req) {
        return $this->response;
    }

    public function _new(Request $req) {
        $s      = $req->getSession();
        $p      = $req->getPostParams();
        $userid = getUserId($s->get("user"));

        if (isset($p->submit) && $p->submit == FORMS_KEYS_CREATE) {
            return $this->create($req);
        }

        $this->response["keys_new"]   = 1;
        $this->response["keys_keyid"] = 0;
        $this->response["userfeeds"]  = getUserFeeds($s->get("user"), $userid);

        return $this->postExec($req);
    }

    private function create(Request $req) {
        $s = $req->getSession();
        $p = $req->getPostParams();

        $this->response["keys_new_ok"] = 99;

        if (isset($p->keys_keyid) && isset($p->keys_label) && isset($p->keys_feedid)) {
            $active     = empty($p->keys_active) ? 1 : 0;
            $keys_perms = empty($p->keys_perms) ? 3 : $p->keys_perms;

            $result = createFeedsKey($s->get("user"), $p->keys_feedid, $p->keys_label, $active, $keys_perms, $p->push_keys_sourceip, $p->pull_keys_sourceip, $p->execute_keys_sourceip);
            if (isset($result) && $result) {
                // Alarm was created
                $this->response["keys_new_ok"]      = 1;
                $this->response["keys_new_alarmid"] = $result;
            }
        }

        return $this->postExec($req);
    }

    public function edit(Request $req) {
        $s = $req->getSession();
        $p = $req->getPostParams();
        $g = $req->getGetParams();

        if (isset($p->submit) && $p->submit == FORMS_KEYS_UPDATE) {
            return $this->update($req);
        }

        if (isset($g->keyid)) {
            $result = getFeedKey($s->get("user"), $g->keyid);
            if (isset($result) && $result) {
                $this->response["feedKey"]    = $result;
                $this->response["keys_edit"]  = 1;
                $this->response["keys_keyid"] = $g->keyid;
            }
        }

        return $this->postExec($req);
    }

    private function update(Request $req) {
        $s = $req->getSession();
        $p = $req->getPostParams();

        $this->response["keys_update_ok"] = 99; // Default state error

        if (isset($p->keys_keyid) && isset($p->keys_label) && isset($p->keys_feedid)) {
            $active     = empty($p->keys_active) ? 1 : 0;
            $keys_perms = empty($p->keys_perms) ? 3 : $p->keys_perms;

            $result = updateFeedsKey($s->get("user"), $p->keys_keyid, $p->keys_label, $active, $keys_perms, $p->push_keys_sourceip, $p->pull_keys_sourceip, $p->execute_keys_sourceip);
            if (isset($result) && $result) {
                echo "$result \n";
                // Key was updated
                $this->response["keys_update_ok"]  = 1;
                $this->response["keys_update_msg"] = $result;
            }
        }

        return $this->postExec($req);
    }

    public function delete(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();

        $this->response["keys_delete_ok"] = 99; // Default state error

        if (isset($g->keyid)) {
            $result = deleteFeedKeyId($s->get("user"), $g->keyid);
            if (isset($result) && $result) {
                $this->response["keys_delete_ok"]  = 1;
                $this->response["keys_delete_msg"] = $result;
            }
        }

        return $this->postExec($req);
    }

    public function deactivate(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();

        $this->response["keys_deactivate_ok"] = 99; // Default state error

        if (isset($g->keyid)) {
            $result = activateKeyFeedId($s->get("user"), $g->keyid, 0);
            if (isset($result) && $result) {
                $this->response["keys_deactivate_ok"] = 1;
                $this->response["keys_keyid"]         = $g->keyid;
            }
        }

        return $this->postExec($req);
    }

    public function activate(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();

        $this->response["keys_activate_ok"] = 99; // Default state error

        if (isset($g->keyid)) {
            $result = activateKeyFeedId($s->get("user"), $g->keyid, 1);
            if (isset($result) && $result) {
                $this->response["keys_activate_ok"] = 1;
                $this->response["keys_keyid"]       = $g->keyid;
            }
        }

        return $this->postExec($req);
    }

    public function postExec(Request $req) {
        return $this->reloadData($req);
    }

    private function reloadData(Request $req) {
        $s      = $req->getSession();
        $userid = getUserId($s->get("user"));

        $this->response["feedskeys"]               = getUserFeedsKeys($s->get("user"), $userid);
        $this->response["number_of_keys_per_user"] = getUserFeedsKeysCount($s->get("user"), $userid);

        return $this->response;
    }

}
