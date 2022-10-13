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

namespace faq\AbstractClass;

use Canopy\Request;
use phpws2\Template;

class AbstractView
{

    const directory = PHPWS_SOURCE_DIR . 'mod/faq/';
    const http = PHPWS_SOURCE_HTTP . 'mod/faq/';

    protected $factory;

    protected static function getDirectory()
    {
        return self::directory;
    }

    protected static function getHttp()
    {
        return self::http;
    }

    private function addScriptVars($vars)
    {
        if (empty($vars)) {
            return null;
        }
        foreach ($vars as $key => $value) {
            if (is_array($value)) {
                $varList[] = "const $key = " . json_encode($value) . ';';
            } else {
                $varList[] = "const $key = '$value';";
            }
        }
        return '<script type="text/javascript">' . implode('', $varList) . '</script>';
    }

    protected static function getScript($scriptName)
    {
        $jsDirectory = self::getHttp() . 'javascript/';
        if (FAQ_SYSTEM_SETTINGS['productionMode']) {
            $path = $jsDirectory . 'build/' . self::getAssetPath($scriptName);
        } else {
            $path = "{$jsDirectory}dev/$scriptName.js";
        }
        $script = "<script type='text/javascript' src='$path'></script>";
        return $script;
    }

    protected static function getAssetPath($scriptName)
    {
        if (!is_file(self::getDirectory() . 'assets.json')) {
            exit('Missing assets.json file. Run "npm run build" in the faq directory.');
        }
        $jsonRaw = file_get_contents(self::getDirectory() . 'assets.json');
        $json = json_decode($jsonRaw, true);
        if (!isset($json[$scriptName]['js'])) {
            throw new \Exception('Script file not found among assets.');
        }
        return $json[$scriptName]['js'];
    }

    public static function scriptView($view_name, $vars = null)
    {
        static $vendor_included = true;
        if (!$vendor_included) {
            $script[] = self::getScript('vendor');
            $vendor_included = true;
        }
        if (!empty($vars)) {
            $script[] = self::addScriptVars($vars);
        }
        $script[] = self::getScript($view_name);
        $react = implode("\n", $script);
        \Layout::addJSHeader($react);
        $content = <<<EOF
<div id="$view_name"><p>Loading. Please wait.</p></div>
EOF;
        return $content;
    }

    public static function getTemplate(string $templateFile, array $values = [], bool $css = false)
    {
        if ($css) {
            $cssFile = "css/{$templateFile}.css";
            \Layout::addStyle('faq', $cssFile);
        }
        $values = array_merge(\faq\Factory\SettingFactory::getSiteContact(), $values);
        $values['siteName'] = \Layout::getPageTitle(true);
        $values['sourceHttp'] = PHPWS_SOURCE_HTTP;
        $values['homeHttp'] = PHPWS_HOME_HTTP;
        $values['imageHttp'] = PHPWS_HOME_HTTP . 'mod/faq/img/';
        $values['moduleCSS'] = PHPWS_HOME_HTTP . 'mod/faq/css/';
        $template = new Template($values);
        $template->setModuleTemplate('faq', $templateFile . '.html');
        return $template->get();
    }
}
