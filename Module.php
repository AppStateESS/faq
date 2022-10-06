<?php

/**
 * MIT License
 * Copyright (c) 2022 Electronic Student Services @ Appalachian State University
 *
 * See LICENSE file in root directory for copyright and distribution permissions.
 *
 * @author Joshua Baldwin <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

namespace faq;

use Canopy\Request;
use Canopy\Response;
use Canopy\Server;
use Canopy\SettingDefaults;
use faq\Controller\Controller;
use faq\View\FAQView;

$defineFile = PHPWS_SOURCE_DIR . 'mod/faq/config/defines.php';
if (is_file($defineFile)) {
    require_once $defineFile;
} else {
    require_once PHPWS_SOURCE_DIR . 'mod/faq/config/defines.dist.php';
}

class Module extends \Canopy\Module implements SettingDefaults
{

    public function __construct()
    {
        parent::__construct();
        $this->setTitle('faq');
        $this->setProperName('faq');
        \spl_autoload_register('\faq\Module::autoloader', true, true);
    }

    public static function autoloader($class_name)
    {
        static $not_found = array();

        if (strpos($class_name, 'faq') !== 0) {
            return;
        }

        if (isset($not_found[$class_name])) {
            return;
        }
        $class_array = explode('\\', $class_name);
        $shifted = array_shift($class_array);
        $class_dir = implode('/', $class_array);

        $class_path = PHPWS_SOURCE_DIR . 'mod/faq/src/' . $class_dir . '.php';

        if (is_file($class_path)) {
            require_once $class_path;
            return true;
        } else {
            $not_found[] = $class_name;
            return false;
        }
    }

    public function getController(Request $request)
    {
        try {
            $controller = new Controller($this, $request);
            return $controller;
        } catch (\faq\Exception\PrivilegeMissing $e) {
            if ($request->isGet() && !$request->isAjax()) {
                $auth = \Current_User::getAuthorization();
                if (!empty($auth->login_link)) {
                    $url = $auth->login_link;
                } else {
                    $url = 'index.php?module=users&action=user&command=login_page';
                }
                \phpws\PHPWS_Core::reroute($url);
            } else {
                throw $e;
            }
        } catch (\faq\Exception\ParticipantPrivilegeMissing $e) {
            \phpws\PHPWS_Core::reroute('./faq/User/Participant/signIn');
        } catch (\Exception $e) {
            // if (AWARD_SYSTEM_SETTINGS['friendlyErrors']) {
            //     \phpws2\Error::log($e);
            //     $controller = new \award\Controller\FriendlyErrorController($this);
            //     return $controller;
            // } else {
                throw $e;
            //}
        }
    }

    public function getSettingDefaults()
    {
        $settings = array(
            'siteContactName' => 'FAQ Site',
            'siteContactEmail' => 'no-reply@appstate.edu',
            'enabledAuthenticators' => '',
            'useWarehouse' => false
        );
        return $settings;
    }

    public function runTime(Request $request)
    {
        if (\PHPWS_Core::atHome()) {
            $frontpage = FAQView::frontPage();
            \Layout::add($frontpage);
        }
    }

}
