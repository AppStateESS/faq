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

class BadCommand extends \Exception
{

    public function __construct($command = null)
    {
        if ($command) {
            $this->message = 'Unknown command sent to controller: ' . $command;
        } else {
            $this->message = 'Empty command sent to controller';
        }
    }

}
