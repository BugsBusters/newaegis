<?php

class App_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	protected $_acl;
	protected $_role;
	protected $_auth;

	public function __construct()
	{
		$this->_auth = Zend_Auth::getInstance();

		if($this->_auth->hasIdentity()) {
			$datiUtente = $this->_auth->getIdentity(); //il risultato di getIdentity->toArray è un array il cui primo elemento è un vettore.
            $this->_role = $datiUtente->current()->ruolo;
		}
		else {
			$this->_role = 'guest';

		}

		$this->_acl = new Application_Model_Acl();
	}

	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		if (!$this->_acl->isAllowed($this->_role, $request->getControllerName())) {
			$this->_auth->clearIdentity();
			$this->denyAccess();
		}
	}

	public function denyAccess()
	{

		$this->_request->setModuleName('default')
			->setControllerName('index')
			->setActionName('index');
	}
}