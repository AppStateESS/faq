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

namespace faq\Factory;

use faq\Exception\ResourceNotFound;

/**
 *
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 */
abstract class BaseFactory extends \phpws2\ResourceFactory
{

    abstract public function build();

    public function load(int $id)
    {
        if (empty($id)) {
            throw new ResourceNotFound;
        }
        $resource = $this->build();
        $resource->setId($id);
        if (!parent::loadByID($resource)) {
            throw new ResourceNotFound($id);
        }
        return $resource;
    }
    
    public function save(\phpws2\Resource $resource) {
        return self::saveResource($resource);
    }

}
