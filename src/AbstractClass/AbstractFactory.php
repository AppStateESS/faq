<?php

declare(strict_types=1);
/**
 * MIT License
 * Copyright (c) 2022 Electronic Student Services @ Appalachian State University
 *
 * See LICENSE file in root directory for copyright and distribution permissions.
 *
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

namespace faq\AbstractClass;

use phpws2\Database;
use Canopy\Request;
use phpws2\Database\Table;

require_once PHPWS_SOURCE_DIR . 'mod/faq/config/system.php';

class AbstractFactory
{

    protected static $table;
    protected static $resourceClassName;

    /**
     * Returns the Resource object if id === 0 or the resource is found in the
     * table by id. Returns false, if the id > 0 and it could not be found.
     * @param int $id
     * @return AbstractResource | boolean
     */
    public static function build(int $id = 0)
    {
        if (static::$resourceClassName === '') {
            return false;
        }
        $resource = new static::$resourceClassName;
        if ($id > 0) {
            return self::load($resource, $id);
        } else {
            return $resource;
        }
    }

    /**
     * Receives a stack of rows and compares value types against the resourceClass.
     * @param array $rows
     * @param string $resourceClass
     */
    public static function enforceBooleanValues(array $rows, string $resourceClass)
    {
        if (empty($rows)) {
            return [];
        }
        $reflection = new \ReflectionClass($resourceClass);
        $properties = $reflection->getProperties();
        $booleanList = [];
        foreach ($properties as $property) {
            $propType = $property->getType()->getName();
            if ($propType === 'bool') {
                $booleanList[] = $property->name;
            }
        }
        $boolIt = function (&$param, $key, $booleanList) {
            if (in_array($key, $booleanList)) {
                $param = (bool) $param;
            }
        };
        foreach ($rows as $key => $row) {
            array_walk($row, $boolIt, $booleanList);
            $rows[$key] = $row;
        }

        return $rows;
    }

    /**
     * Returns a DB object with emulation turned off so we get
     * properly typed values.
     * @return phpws2\Database\DB
     */
    public static function getDB(): \phpws2\Database\DB
    {
        $db = Database::getDB();
        $db::$PDO->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        return $db;
    }

    /**
     * Returns an associative array contain the $db and $table.
     * Table name derived from an expected static $table in the
     * extended class.
     * @return array
     * @throws \Exception
     */
    public static function getDBWithTable(): array
    {
        if (!isset(static::$table)) {
            throw new \Exception('Factory table not set');
        }
        $db = self::getDB();
        $table = $db->addTable(static::$table);
        return get_defined_vars();
    }

    /**
     * Adds field conditionals to the database table object. Values not set if empty (0, null, false, etc.)
     * @param \phpws2\Database\Table $table
     * @param array $ids
     * @param array $options
     */
    protected static function addIdOptions(Table $table, array $ids, array $options)
    {
        foreach ($ids as $match) {
            if (!empty($options[$match])) {
                $table->addFieldConditional($match, $options[$match]);
            }
        }
    }

    /**
     * Adds field conditionals to the database table object. They just need to be set in the
     * options array. Their value does not prevent setting like addIdOptions.
     * @param \phpws2\Database\Table $table
     * @param array $issets
     * @param array $options
     */
    protected static function addIssetOptions(Table $table, array $issets, array $options)
    {
        foreach ($issets as $match) {
            if (isset($options[$match])) {
                $table->addFieldConditional($match, $options[$match]);
            }
        }
    }

    protected static function addOrderOptions(Table $table, array $options, string $defaultOrderBy = null, string $defaultOrderDirection = 'asc')
    {
        if (!empty($options['orderDir'])) {
            $direction = $options['orderDir'];
        } else {
            $direction = $defaultOrderDirection;
        }
        if ($direction !== 'asc' && $defaultOrderDirection !== 'desc') {
            $direction = 'asc';
        }

        if (!empty($options['orderBy'])) {
            $table->addOrderBy($options['orderBy'], $direction);
        } elseif (!empty($defaultOrderBy)) {
            $table->addOrderBy($defaultOrderBy, $direction);
        }
    }

    /**
     * Loads a resource from the table name set in the object by the id parameter.
     * If allowedDeleted is true, a previously deleted object may be returned.
     * @param AbstractResource $resource
     * @param int $id
     * @param bool $allowDeleted
     * @return boolean| AbstractResource
     */
    protected static function load(AbstractResource $resource, int $id, bool $allowDeleted = false)
    {
        $db = self::getDB();
        $tbl = $db->addTable($resource->getTableName());
        $tbl->addFieldConditional('id', $id);
        /**
         * If resource has a deleted property, it is prohibited from loading.
         */
        if (!$allowDeleted && property_exists($resource, 'deleted')) {
            $tbl->addFieldConditional('deleted', 0);
        }
        $result = $db->selectOneRow();
        if (empty($result)) {
            return false;
        } else {
            $resource->setValues($result);
            return $resource;
        }
    }

    public static function save(AbstractResource $resource)
    {
        $id = $resource->getId();
        if ($id) {
            if (method_exists($resource, 'stampUpdated')) {
                $resource->stampUpdated();
            }
        } else {
            if (method_exists($resource, 'stampCreated')) {
                $resource->stampCreated();
                $resource->stampUpdated();
            }
        }
        $values = $resource->getValues();
        unset($values['id']);
        $db = Database::getDB();
        $db->begin();
        $table = $db->addTable($resource->getTableName());
        $table->addValueArray($values);
        if ($id) {
            $table->addFieldConditional('id', $id);
            $db->update();
            $db->commit();
        } else {
            $db->insert();
            $last_id = (int) $table->getLastId();
            $resource->setId($last_id);
            $db->commit();
        }
        return $resource;
    }

}
