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

namespace faq\Resource;
use phpws2\Resource;
use faq\Resource\AbstractResource;

class FAQResource extends AbstractResource
{

    protected $questionArray;
    protected $answerArray;
    
    protected $table = 'faq_qa';

    public function __construct()
    {
        parent::__construct();
        $this->questionArray = new \phpws2\Variable\ArrayVar('', 'questionArray');
        $this->answerArray = new \phpws2\Variable\ArrayVar('', 'answerArray');
    }
    
}
