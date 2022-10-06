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

namespace faq\Traits;

use faq\Exception\InaccessibleProperty;
use faq\Exception\PropertyTypeVerifyFailed;

trait MagicGetSetTrait
{

    private static $booleans;

    public function __isset($varname)
    {
        return isset($this->$varname);
    }

    /**
     * Used in a __get magic method. Returns the result of the
     * get{$valueName}() method from the current object or throws
     * an exception if the method does not exist.
     * @param string $valueName
     * @return mixed
     * @throws InaccessibleProperty
     */
    public function getByMethod(string $valueName)
    {
        $getMethod = 'get' . ucwords($valueName);
        if (method_exists($this, $getMethod)) {
            return $this->$getMethod();
        } else {
            $className = get_class($this);
            throw new InaccessibleProperty($className, $valueName);
        }
    }

    /**
     * Used in a __set magic method. Returns the result of the
     * set{$valueName}() method from the current object or throws
     * an exception if the method does not exist.
     *
     * @param string $valueName
     * @param mixed $value
     * @throws InaccessibleProperty
     */
    public function setByMethod(string $valueName, $value)
    {
        $className = get_class($this);
        $this->loadBooleans();
        $setMethod = 'set' . ucwords($valueName);
        if (method_exists($this, $setMethod)) {
            if (in_array($valueName, self::$booleans[$className])) {
                $value = (bool) $value;
            }
            $this->$setMethod($value);
        } else {
            $constructClass = get_called_class();
            throw new InaccessibleProperty($constructClass, $valueName);
        }
    }

    /**
     * Checks the class for boolean params so they can be cast when set.
     */
    private function loadBooleans()
    {
        $className = get_class($this);

        if (empty(self::$booleans) || !isset(self::$booleans[$className])) {
            $reflection = new \ReflectionClass($className);
            $properties = $reflection->getProperties();
            self::$booleans[$className] = [];
            foreach ($properties as $property) {
                $propType = $property->getType()->getName();
                if ($propType === 'bool') {
                    self::$booleans[$className][] = $property->name;
                }
            }
        }
    }

}
