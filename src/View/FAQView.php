<?php

declare(strict_types=1);
/**
 * MIT License
 * Copyright (c) 2022 Electronic Student Services @ Appalachian State University
 *
 * See LICENSE file in root directory for copyright and distribution permissions.
 *
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

namespace faq\View;

use faq\AbstractClass\AbstractView;
use faq\Resource\Row;

class FAQView extends AbstractView
{
    /**
     * Home page introduction page.
     * @return string
     */
    public static function frontPage()
    {
        $values = [];
        //$values['admin'] = \Current_User::allow('award');
        $values['welcomeHeader'] = self::scriptView('WelcomeHeader');
        return self::getTemplate('User/FrontPage', $values, true);
    }

    public static function view(Array $rows)
    {
        $values = $rows[0];
        return self::getTemplate('User/Row', $values);
    }

}
