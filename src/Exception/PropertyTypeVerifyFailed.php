<?php

declare(strict_types=1);
/**
 * MIT License
 * Copyright (c) 2021 Electronic Student Services @ Appalachian State University
 *
 * See LICENSE file in root directory for copyright and distribution permissions.
 *
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

namespace faq\Exception;

class PropertyTypeVerifyFailed extends \Exception
{

    public function __construct(string $className, string $propertyType)
    {
        parent::__construct("property '$className::$propertyType' not formatted correctly");
    }

}
