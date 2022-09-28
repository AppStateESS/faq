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

namespace award\AbstractClass;

use award\Traits\MagicGetSetTrait;

class AbstractConstruct
{

    use MagicGetSetTrait;

    /**
     * Magic function for getting a parameter.
     * @param type $valueName
     * @return type
     */
    public function __get($valueName)
    {
        return $this->getByMethod($valueName);
    }

    /**
     *
     * Magic function for setting a parameter.
     * @param type $valueName
     * @param type $value
     * @return type
     */
    public function __set($valueName, $value)
    {
        return $this->setByMethod($valueName, $value);
    }

    /**
     * Returns all the parameters of a Construct object as an
     * associative array.
     *
     * @param bool $useMethods If true, use the parameter's getter method. If false,
     *                         raw parameter.
     * @return type
     */
    public function getParameters(bool $useMethods = true)
    {
        $parameterArray = get_object_vars($this);
        if ($useMethods) {
            foreach ($parameterArray as $key => $value) {
                $byMethodArray[$key] = $this->__get($key);
            }
            return $byMethodArray;
        } else {
            return $parameterArray;
        }
    }

    public function isEmpty($valueName)
    {
        return empty($this->$valueName);
    }

}
