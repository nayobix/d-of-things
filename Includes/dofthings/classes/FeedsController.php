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
 * Description of FeedsController
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class FeedsController implements IController {

    private $response = [];

    /**
     *  class constructor
     * 
     */
    public function __construct(Request $req) {
        $s      = $req->getSession();
        $user   = $s->get("user");
        $userid = getUserId($user);

        $this->response["userfeeds"]                = getUserFeeds($user, $userid);
        $this->response["number_of_feeds_per_user"] = getUserFeedsCount($user, $userid);
        $this->response["smartyFilename"]           = "feeds";
        $this->response["feeds"]                    = 1;
    }

    public function index(Request $req) {

        return $this->response;
    }

    public function _new(Request $req) {
        $p = $req->getPostParams();

        if (isset($p->submit) && $p->submit == FORMS_FEEDS_CREATE) {
            return $this->create($req);
        }

        $this->response["feeds_new"]    = 1;
        $this->response["feeds_feedid"] = 0;
        $this->response["feeds_parser"] = '*';

        return $this->postExec($req);
    }

    private function create(Request $req) {
        $s    = $req->getSession();
        $p    = $req->getPostParams();
        $user = $s->get("user");

        $this->response["feeds_new_ok"] = 99;

        $auto    = empty($p->feeds_auto) ? 0 : 1;
        $logging = empty($p->feeds_logging) ? 0 : 1;
        $result  = createFeed($user, $p->feeds_name, $p->feeds_parser, $logging, $auto);
        if (isset($result) && $result) {
            // Feed was created
            $result                             = generateFeedKey($user, $p->feeds_name, $result);
            $this->response["feeds_new_ok"]     = 1;
            $this->response["feeds_new_feedid"] = $result;
        }

        return $this->postExec($req);
    }

    public function edit(Request $req) {
        $s    = $req->getSession();
        $p    = $req->getPostParams();
        $g    = $req->getGetParams();
        $user = $s->get("user");

        if (isset($p->submit) && $p->submit == FORMS_FEEDS_UPDATE) {
            return $this->update($req);
        }

        if (isset($g->feedid)) {
            $result = getUserFeed($user, $g->feedid);
            if (isset($result)) {
                $this->response["userFeed"]     = $result;
                $this->response["feeds_edit"]   = 1;
                $this->response["feeds_feedid"] = $g->feedid;
            }
        }

        return $this->postExec($req);
    }

    private function update(Request $req) {
        $s = $req->getSession();
        $g = $req->getGetParams();
        $p = $req->getPostParams();

        $user    = $s->get("user");
        $auto    = empty($p->feeds_auto) ? 0 : 1;
        $logging = empty($p->feeds_logging) ? 0 : 1;

        $this->response["feeds_update_ok"] = 99; // Default state error

        if (isset($g->feedid) && isset($p->feeds_feedid) &&
                ($g->feedid == $p->feeds_feedid)) {
            $result = updateFeed($user, $p->feeds_feedid, $p->feeds_name, $logging, $auto);
            if (isset($result)) {
                $this->response["feeds_update_msg"] = $result;
                $this->response["feeds_update_ok"]  = 1;
            }
        }

        return $this->postExec($req);
    }

    public function delete(Request $req) {
        $s    = $req->getSession();
        $p    = $req->getPostParams();
        $g    = $req->getGetParams();
        $user = $s->get("user");

        $this->response["feeds_delete_ok"] = 99; // Default state error

        if (isset($g->feedid)) {
            $result = deleteFeedId($user, $g->feedid);
            if (isset($result)) {
                $this->response["feeds_feedid"]    = $g->feedid;
                $this->response["feeds_delete_ok"] = 1;
            }
        }

        return $this->postExec($req);
    }

    public function deactivate(Request $req) {
        $s    = $req->getSession();
        $g    = $req->getGetParams();
        $user = $s->get("user");

        $this->response["feeds_deactivate_ok"] = 99; // Default state error

        if (isset($g->feedid)) {
            $result = activateFeedId($user, $g->feedid, 0);
            if (isset($result)) {
                $this->response["feeds_feedid"]        = $g->feedid;
                $this->response["feeds_deactivate_ok"] = 1;
            }
        }

        return $this->postExec($req);
    }

    public function activate(Request $req) {
        $s    = $req->getSession();
        $g    = $req->getGetParams();
        $user = $s->get("user");

        $this->response["feeds_activate_ok"] = 99; // Default state error

        if (isset($g->feedid)) {
            $result = activateFeedId($user, $g->feedid, 1);
            if (isset($result)) {
                $this->response["feeds_feedid"]      = $g->feedid;
                $this->response["feeds_activate_ok"] = 1;
            }
        }

        return $this->postExec($req);
    }

    public function log(Request $req) {
        $s    = $req->getSession();
        $p    = $req->getPostParams();
        $g    = $req->getGetParams();
        $user = $s->get("user");

        if (isset($g->feedid) && checkIfLogging($g->feedid)) {
            $result = getFeedLogs($user, $g->feedid, 1);
            if (isset($result)) {
                $this->response["feeds_logs"]   = 1;
                $this->response["feeds_feedid"] = $g->feedid;
                $this->response["feedslogs"]    = $result;
            }
        }

        return $this->postExec($req);
    }

    public function postExec(Request $req) {
        return $this->reloadData($req);
    }

    private function reloadData(Request $req) {
        $s      = $req->getSession();
        $user   = $s->get("user");
        $userid = getUserId($user);

        $this->response["userfeeds"]                = getUserFeeds($user, $userid);
        $this->response["number_of_feeds_per_user"] = getUserFeedsCount($user, $userid);

        return $this->response;
    }

}
