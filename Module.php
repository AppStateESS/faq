<?php

/**
 *
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license http://opensource.org/licenses/lgpl-3.0.html
 */

namespace faq;

use Canopy\Request;
use Canopy\Response;
use Canopy\Server;
use Canopy\SettingDefaults;
use faq\View\FAQView;
use faq\Factory\FAQFactory;
use faq\Controller\Controller;

if (is_file(PHPWS_SOURCE_DIR . 'mod/faq/config/defines.php')) {
    require_once PHPWS_SOURCE_DIR . 'mod/faq/config/defines.php';
} else {
    require_once PHPWS_SOURCE_DIR . 'mod/faq/config/defines.dist.php';
}

class Module extends \Canopy\Module
{

    public function __construct()
    {
        parent::__construct();
        $this->setTitle('faq');
        $this->setProperName('FAQ for Frequently Asked Questions');
        spl_autoload_register('\faq\Module::autoloader', true, true);
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
        array_shift($class_array);
        $class_dir = implode('/', $class_array);

        $class_path = PHPWS_SOURCE_DIR . 'mod/faq/class/' . $class_dir . '.php';
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
        } catch (\conference\Exception\PrivilegeMissing $e) {
            if ($request->isGet() && !$request->isAjax()) {
                \Current_User::requireLogin();
            } else {
                throw $e;
            }
        }
    }

    public function runTime(Request $request)
    {
        if (version_compare($this->version, '1.0.0', '<')) {
            return;
        }
        if (!$request->isVar('module')) {
            $view = new FAQView;
            $factory = new FAQFactory;
            $faq = $factory->getHomeFAQ();
            if (!empty($faq)) {
                $homeView = $view->view($faq);
                \Layout::add($homeView, 'faq');
            }
        }
    }

    public function afterRun(Request $request, \Canopy\Response $response)
    {
        if (version_compare($this->version, '1.0.0', '<')) {
            return;
        }
    }
}

?>
