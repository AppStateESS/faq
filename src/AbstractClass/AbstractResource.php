<?php

/**
 *
 *
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

namespace faq\AbstractClass;

abstract class AbstractResource extends AbstractConstruct
{

    /**
     * Primary key for Resources
     * @var int
     */
    protected $id = 0;
    private $tableName;

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }

    public function getId()
    {
        return $this->id ?? 0;
    }

    /**
     * Returns an array of object properties.
     * @return array
     */
    public function getProperties(): array
    {
        $reflection = new \ReflectionClass(get_called_class());
        $properties = $reflection->getProperties();
        foreach ($properties as $p) {
            $list[] = $p->name;
        }
        return $list;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getValues(array $ignore = null, array $only = null)
    {
        $properties = $this->getProperties();
        $list = [];
        foreach ($properties as $p) {
            if (!is_array($ignore) || !in_array($p, $ignore)) {
                if (!is_array($only) || in_array($p, $only)) {
                    $list[$p] = self::getByMethod($p);
                }
            }
        }
        return $list;
    }

    /**
     * Sets the primary key of the resource.
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setValues(array $values, $ignore = [])
    {
        $properties = $this->getProperties();

        foreach ($properties as $p) {
            if (!in_array($p, $ignore)) {
                $list[$p] = self::setByMethod($p, $values[$p]);
            }
        }
        return $list;
    }

}
