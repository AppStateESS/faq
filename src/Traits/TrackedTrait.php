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

trait TrackedTrait
{

    /**
     * Date created
     * @var \DateTime
     */
    protected \DateTime $created;

    /**
     * Date last changed
     * @var \DateTime
     */
    protected \DateTime $updated;

    public function getCreated(string $format = null)
    {
        return $this->created->format($format ?? 'Y-m-d H:i:s');
    }

    public function getUpdated(string $format = null)
    {
        return $this->updated->format($format ?? 'Y-m-d H:i:s');
    }

    public function setCreated(string $datetime)
    {
        $this->created = new \DateTime($datetime);
    }

    public function setUpdated(string $datetime)
    {
        $this->updated = new \DateTime($datetime);
    }

    public function stampCreated()
    {
        $this->created = new \DateTime();
    }

    public function stampUpdated()
    {
        $this->updated = new \DateTime();
    }

    protected function constructDates()
    {
        $this->created = new \DateTime;
        $this->updated = new \DateTime;
    }

}
