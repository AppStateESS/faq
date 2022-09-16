<?php

/**
 * @author Joshua Baldwin <baldwinjd2@appstate.edu>
 */
function faq_install(&$content)
{
    $db = \phpws2\Database::newDB();
    $db->begin();

    try {
        $faq = new \faq\Resource\FAQResource;
        $ft = $faq->createTable($db);
    } catch (\Exception $e) {
        if (isset($ft) && $db->tableExists($ft->getName())) {
            $st->drop();
        }
        $db->rollback();
        throw $e;
    }
    $db->commit();

    $content[] = 'FAQ table created';
    return true;
}
