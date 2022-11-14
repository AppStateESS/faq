<?php

declare(strict_types=1);
/**
 * MIT License
 * Copyright (c) 2022 Electronic Student Services @ Appalachian State University
 *
 * See LICENSE file in root directory for copyright and distribution permissions.
 *
 * @author Joshua Baldwin <baldwinjd2@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

namespace faq\Factory;

use faq\AbstractClass\AbstractFactory;
use faq\Resource\Row;
use phpws2\Database;
use Canopy\Request;
use faq\Exception\ResourceNotFound;

class RowFactory extends AbstractFactory
{

    protected static $table = 'faq_qa';
    protected static $resourceClassName = 'faq\Resource\Row';

    public static function getList(array $options = [])
    {
        /**
         * @var \phpws2\Database\DB $db
         * @var \phpws2\Database\Table $table
         */
        extract(self::getDBWithTable());

        $table->addField('id');
        $table->addField('question');
        $table->addField('answer');

        $result = $db->select();
        return $result;
    }

    /**
     * Parses the Request for post values to fill an award object.
     * @param Request $request
     */
    public static function post(Request $request)
    {
        $faq = self::build();

        $faq->setQuestion($request->pullPutString('question'));
        $faq->setAnswer($request->pullPutString('answer'));

        return $faq;
    }

    /**
     * Parses the Request for put values to fill an award object.
     * The active parameter is not set in the put.
     * @param Request $request
     */
    public static function put(Request $request, int $id)
    {
        $faq = self::build($id);

        $faq->setQuestion($request->pullPutString('question'));
        $faq->setAnswer($request->pullPutString('answer'));

        return $faq;
    }

    public static function get(Request $request)
    {
        return "Hello";
    }
}
