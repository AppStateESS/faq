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

    protected $question;
    protected $answer;
    
    protected $table = 'faq_qa';

    public function __construct()
    {
        parent::__construct();
        $this->question = new \phpws2\Variable\StringVar('', 'questionArray');
        $this->answer = new \phpws2\Variable\StringVar('', 'answerArray');
    }
    
}
