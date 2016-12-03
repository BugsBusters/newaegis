<?php

class LoginController extends Zend_Controller_Action
{
    protected $_authService;
    protected $_loginForm;

    public function init()
    {
        $this->_helper->layout->disableLayout();
        $this->_authService = new Application_Service_Auth();
        $this->view->assign("loginForm", $this->indexAction());
    }

    public function indexAction()
    {

        $this->_loginForm = new Application_Form_Login();
        $urlHelper = $this->_helper->getHelper('url');
        $this->_loginForm->setAction($urlHelper->url(array(
            'controller' => 'login',
            'action' => 'autentica'),
            'default'
        ));
        return $this->_loginForm;

    }

    public function autenticaAction()
    {
        $request = $this->getRequest(); //vede se esiste una richiesta
        if (!$request->isPost()) { //controlla che sia stata passata tramite post
            return $this->_helper->redirector('index'); // se non c'è un passaggio tramite post, reindirizza al loginAction
        }
        if (!$this->_loginForm->isValid($request->getPost())) {
            $this->_loginForm->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('index');
        }
        $dati = $this->_loginForm->getValues();
        if (false === $this->_authService->authenticate($dati)) {
            $this->_loginForm->setDescription('Autenticazione fallita. Riprova');
            return $this->render('index');
        }
        //superati controlli di login => utente registrato con identità salvata

        $user = $this->_authService->getIdentity();
        //SE HA SUPERATO I CONTROLLI ALLORA è UTENTE REGISTRATO
        $this->_helper->redirector('index', $user->current()->ruolo);
    }


}

