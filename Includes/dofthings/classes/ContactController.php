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
 * Description of ContactController
 *
 * @author Boyan Vladinov <nayobix at nayobix.org>
 */
class ContactController implements IController {

    private $response = [];

    /**
     *  class constructor
     * 
     */
    function __construct() {

        //Init default values in case we should return immediately
        $this->response["smartyFilename"] = "contact";
        $this->response["contact"]          = 1;
    }

    public function index(Request $req) {

        return $this->response;
    }

    public function postExec(Request $req) {
        
    }

}
