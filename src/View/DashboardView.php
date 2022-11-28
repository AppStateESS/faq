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

class DashboardView extends AbstractView
{

    public static function admin()
    {
        $values['menu'] = self::adminMenu('dashboard');
        $values['content'] = self::scriptView('Dashboard');

        return self::getTemplate('Admin/Dashboard', $values, true);
    }

}
