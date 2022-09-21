<?php

/**
 * MIT License
 * Copyright (c) 2019 Electronic Student Services @ Appalachian State University
 * 
 * See LICENSE file in root directory for copyright and distribution permissions.
 * 
 * @author Joshua Baldwin <baldwinjd2@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

namespace faq\View;

use faq\Resource\FAQResource;
use phpws2\Database;
use phpws2\Template;

class FAQView extends AbstractView
{

    public function __construct()
    {
        $this->factory = new \faq\Factory\FAQFactory();
    }

    public function view(FAQResource $faq)
    {
        $options = [];
        $this->scriptView('View', $options, true);
        \Layout::addStyle('faq');

        $active = true;
        $vars = $faq->getStringVars();

        $template = new Template($vars);
        $template->setModuleTemplate('faq', 'faq.html');
        return $template->get();
    }

    public function homeView()
    {
        $faq = $this->factory->getHomeFAQ();
        if (empty($faq)) {
            return;
        }
        return $this->view($faq);
    }

}
