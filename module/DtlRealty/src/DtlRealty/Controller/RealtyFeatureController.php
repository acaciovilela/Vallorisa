<?php

namespace DtlRealty\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RealtyFeatureController extends AbstractActionController {

    public function indexAction() {
        return new ViewModel();
    }
    
    public function calculateareaAction() {
        $params = $this->params()->fromQuery();
        
        $builtArea = (float) $params['built'];
        $balconyArea = (float) $params['balcony'];
        
        $total = $builtArea + $balconyArea;
        
        return $this->response->setContent(\Zend\Json\Json::encode(array('total' => $total)));
    }
    
    public function calculategroundAction() {
        $params = $this->params()->fromQuery();
        
        $width = (float) $params['width'];
        $length = (float) $params['length'];
        
        $total = $width * $length;
        
        return $this->response->setContent(\Zend\Json\Json::encode(array('total' => $total)));
    }
}
