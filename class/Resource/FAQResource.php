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

namespace faq\Resource;
use phpws2\Resource;
use faq\Resource\AbstractResource;

class FAQResource extends AbstractResource
{

    protected $id;
    protected $title;
    protected $question;
    protected $answer;
    protected $frontpage;
    
    protected $table = 'faq_qa';

    public function __construct()
    {
        parent::__construct();
        $this->title = new \phpws2\Variable\StringVar('', 'title');
        $this->question = new \phpws2\Variable\StringVar('', 'question');
        $this->answer = new \phpws2\Variable\StringVar('', 'answer');
        $this->frontpage = new \phpws2\Variable\BooleanVar(false, 'frontpage');
    }
    
}
