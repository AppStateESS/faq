<?php

/**
 * Uninstall file for faq
 *
 * @author Joshua Baldwin <baldwinjd2@appstate.edu>
 */
function faq_uninstall(&$content)
{
    $db = \phpws2\Database::newDB();

    if ($db->tableExists('faq_qa')) {
        $tbl = $db->buildTable('faq_qa');
        $tbl->drop();
    }
    return true;
}

?>
