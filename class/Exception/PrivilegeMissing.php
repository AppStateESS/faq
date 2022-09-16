<?php

/**
 * MIT License
 * Copyright (c) 2017 Electronic Student Services @ Appalachian State University
 * 
 * See LICENSE file in root directory for copyright and distribution permissions.
 * 
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */
namespace carousel\Exception;

class PrivilegeMissing extends \Exception
{
    protected $defaultMessage = 'You do not have permissions for this action';
    
    public function __construct($className = null)
    {
        $message = $this->defaultMessage;
        if ($className) {
            $message .= ': ' . $className;
        }
        parent::__construct($message);
    }
}
