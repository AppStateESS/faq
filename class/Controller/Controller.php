<?php

/**
 * MIT License
 * Copyright (c) 2019 Electronic Student Services @ Appalachian State University
 * 
 * See LICENSE file in root directory for copyright and distribution permissions.
 * 
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

namespace faq\Controller;

use Canopy\Request;
use faq\Factory\FAQFactory;
use faq\View\FAQView;

//define('CONFERENCE_ROLES', ['Admin', 'User', 'Visitor']);

class Controller extends \phpws2\Http\Controller
{

    protected $role;
    protected $subcontroller;

    public function __construct(\Canopy\Module $module, Request $request)
    {
        parent::__construct($module);
        $this->loadRole();
        $this->loadSubController($request);
    }

    private function loadRole()
    {
        $userId = \Current_User::getId();
        if (\Current_User::allow('faq')) {
            $this->role = new \faq\Role\Admin($userId);
        } else {
            $this->role = new \faq\Role\User;
        }
    }

    /**
     * Loads controller based on Role and Resource. Default Controller is a
     * User Conference list view.
     * @param Request $request
     * @throws \faq\Exception\PrivilegeMissing
     * @throws \faq\Exception\VisitorLoginRequired
     * @throws \faq\Exception\BadCommand
     */
    private function loadSubController(Request $request)
    {
        $roleController = filter_var($request->shiftCommand(),
                FILTER_SANITIZE_STRING);

        if (empty($roleController)) {
            throw new \faq\Exception\BadCommand('Missing role controller');
        }

        if ($roleController === 'Admin' && !$this->role->isAdmin()) {
            \Current_User::requireLogin();
        }

        $subController = filter_var($request->shiftCommand(),
                FILTER_SANITIZE_STRING);

        if (empty($subController)) {
            throw new \faq\Exception\BadCommand('Missing subcontroller');
        }

        $subControllerName = '\\faq\\Controller\\' . $roleController . '\\' . $subController;
        if (!class_exists($subControllerName)) {
            throw new \faq\Exception\BadCommand($subControllerName);
        }
        $this->subcontroller = new $subControllerName($this->role);
    }

    public function execute(Request $request)
    {
        try {
            return parent::execute($request);
        } catch (\faq\Exception\PrivilegeMissing $e) {
            \Current_User::requireLogin();
        }
    }

    public function post(Request $request)
    {
        return $this->subcontroller->changeResponse($request);
    }

    public function patch(Request $request)
    {
        return $this->subcontroller->changeResponse($request);
    }

    public function delete(Request $request)
    {
        return $this->subcontroller->changeResponse($request);
    }

    public function put(Request $request)
    {
        return $this->subcontroller->changeResponse($request);
    }

    public function get(Request $request)
    {
        if ($request->isAjax() || (bool) $request->pullGetBoolean('json', true)) {
            return $this->subcontroller->getJson($request);
        } else {
            return $this->subcontroller->getHtml($request);
        }
    }

}
