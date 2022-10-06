<?php

/**
 * MIT License
 * Copyright (c) 2020 Electronic Student Services @ Appalachian State University
 *
 * See LICENSE file in root directory for copyright and distribution permissions.
 *
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

namespace faq\Exception;

class ParticipantPrivilegeMissing extends \Exception
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
