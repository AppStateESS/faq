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

namespace faq\Controller\Admin;

use Canopy\Request;
use faq\Controller\SubController;
use faq\Factory\FAQFactory as Factory;
use faq\View\FAQView as View;

class FAQ extends SubController
{

    /**
     * @var faq\View\FAQView 
     */
    protected $view;

    /**
     * @var faq\Factory\FAQFactory
     */
    protected $factory;

    protected function loadFactory()
    {
        $this->factory = new Factory;
    }

    protected function loadView()
    {
        $this->view = new View;
    }

    protected function listHtml(Request $request)
    {
        \Layout::hideDefault();
        return $this->view->scriptView('FAQ');
    }

    protected function listJson(Request $request)
    {
        $search = $request->pullGetString('search', true);
        return ['listing' => $this->factory->listing(['search'=>$search])];
    }

    protected function post(Request $request)
    {
        $faq = $this->factory->post($request);
        $this->factory->save($faq);
        return ['success' => true];
    }

    protected function put(Request $request)
    {
        $faq = $this->factory->put($this->id, $request);
        $this->factory->save($faq);
        return ['success' => true];
    }
    
    protected function delete(Request $request)
    {
        $faq = $this->factory->load($this->id);
        $this->factory->delete($faq);
        return ['success' => true];
    }
    
    protected function frontpagePatch(Request $request)
    {
        $this->factory->toggleFrontPage($this->id);
        return ['success'=>true, 'id'=>$this->id];
    }
    
    protected function pinPut(Request $request)
    {
        $keyId = $request->pullPutInteger('keyId');
        $this->factory->pin($this->id, $keyId);
        return ['success'=>true];
    }
    
    protected function unpinPut(Request $request)
    {
        $keyId = $request->pullPutInteger('keyId');
        $this->factory->unpin($this->id, $keyId);
        return ['success'=>true];
    }

}
