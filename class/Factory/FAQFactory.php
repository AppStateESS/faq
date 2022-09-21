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

use Canopy\Request;
use phpws2\Database;
use faq\Resource\FAQResource as Resource;

class FAQFactory extends BaseFactory
{

    public function build()
    {
        $resource = new Resource;
        return $resource;
    }

    public function post(Request $request)
    {
        $faq = $this->build();
        $faq->title = $request->pullPostString('title');
        $faq->question = $request->pullPostString('question');
        $faq->answer = $request->pullPostString('answer');
        return $faq;
    }

    public function listing(array $options = [])
    {
        $db = Database::getDB();
        $tbl = $db->addTable('faq_qa');
        if (!empty($options['titleOnly'])) {
            $tbl->addField('id');
            $tbl->addField('title');
        }
        
        if (!empty($options['search'])) {
            $search = $options['search'];
            $searchArray = explode(' ', $search);
            foreach ($searchArray as $s) {
                $tbl->addFieldConditional('title', "%$s%", 'like');
            }
        }

        $tbl->addOrderBy('title');
        $result = $db->select();
        return $result;
    }

    public function put(int $id, Request $request)
    {
        $faq = $this->load($id);
        $faq->title = $request->pullPutString('title');
        $faq->question = $request->pullPutString('question');
        $faq->transition = $request->pullPutString('title');
        return $faq;
    }

    public function delete(Resource $faq)
    {
        // TODO
        return;
    }

    /**
     * 
     * @return \faq\Resource\FAQResource
     */
    public function getHomeFAQ()
    {
        $db = Database::getDB();
        $tbl = $db->addTable('faq_qa');
        $tbl->addFieldConditional('frontpage', 1);
        $db->setLimit(1);
        $faq = $db->selectAsResources('\faq\Resource\FAQResource');
        if (empty($faq)) {
            return;
        }
        return $faq[0];
    }

    /**
     * Toggles the selected faq to front page status
     * @param int $faqId
     */
    public function toggleFrontPage(int $faqId)
    {
        $faq = $this->load($faqId);
        if ($faq->frontpage) {
            $faq->frontpage = false;
            self::saveResource($faq);
        } else {
            $this->removeFrontPage();
            $faq->frontpage = true;
            self::saveResource($faq);
        }
    }

    /**
     * Removes front page status from ALL faqs.
     */
    private function removeFrontPage()
    {
        $db = Database::getDB();
        $tbl = $db->addTable('faq_qa');
        $tbl->addValue('frontpage', 0);
        $db->update();
    }

}
