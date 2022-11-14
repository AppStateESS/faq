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

namespace faq\Controller\Admin;

use faq\AbstractClass\AbstractController;
use faq\View\DashboardView;

class Dashboard extends AbstractController
{

    protected function listHtml()
    {
        return DashboardView::admin();
    }

}
