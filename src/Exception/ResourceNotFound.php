<?php

/*
 * MIT License
 * Copyright (c) 2020 Electronic Student Services @ Appalachian State University
 *
 * See LICENSE file in root directory for copyright and distribution permissions.
 *
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

namespace award\Exception;

class ResourceNotFound extends \Exception
{

    public function __construct($id = null)
    {
        if ($id) {
            parent::__construct('Resource not found: ' . $id);
        } else {
            parent::__construct('Resource not found');
        }
    }

}
