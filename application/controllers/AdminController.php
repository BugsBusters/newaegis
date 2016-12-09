<?php

class AdminController extends Zend_Controller_Action
{

    protected $_utenteCorrente = null;

    protected $_authService = null;

    public function init()
    {
        $this->_helper->layout->setLayout('control-panel');
        $this->_helper->layout->setLayout('control-panel');
        $this->_authService = new Application_Service_Auth();
        $this->_utenteCorrente = $this->_authService->getIdentity()->current();
        $this->view->assign("ruolo", $this->_utenteCorrente->ruolo);
    }

    public function indexAction()
    {
    }

    public function gestioneUlivetiAction()
    {
       $ulivetoModel = new Application_Model_Uliveto();
       $elencoUliveti = $ulivetoModel->elencoUliveti();
       $this->view->assign("elencoUliveti",$elencoUliveti);
    }


}



