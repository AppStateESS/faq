<?php

declare(strict_types=1);
/**
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

namespace faq\Exception;

class InaccessibleProperty extends \Exception
{

    public function __construct(string $className, string $valueName)
    {
        parent::__construct('cannot access protected/private property ' . $className . '::$' . $valueName);
    }

}
