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

namespace faq\Controller\User;

use Canopy\Request;
use faq\AbstractClass\AbstractController;
use faq\View\FAQView;
use faq\Factory\RowFactory;

class FAQTableController extends AbstractController
{

    protected function listJson(Request $request)
    {        
        return RowFactory::getList();
    }
    
    
}
