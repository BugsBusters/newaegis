<?php

class UserController extends Zend_Controller_Action
{

    protected $_temperaturaModel = null;

    protected $_umiditaModel = null;

    protected $_trappolaModel = null;

    protected $_nodoModel = null;

    protected $_utenteCorrente = null;

    protected $_authService = null;

    protected $_modificaProfiloForm = null;

    public function init()
    {
        $this->_helper->layout->setLayout('control-panel');
        $this->_authService = new Application_Service_Auth();
        $this->_utenteCorrente = $this->_authService->getIdentity()->current();
        $this->view->assign("ruolo", $this->_utenteCorrente->ruolo);
        $this->view->assign("modificaProfiloForm", $this->modificaprofiloAction());

    }

    public function indexAction()
    {
        // INIZIALIZZO I MODEL
        $this->_temperaturaModel = new Application_Model_Temperatura();
        $this->_umiditaModel = new Application_Model_Umidita();
        $this->_trappolaModel = new Application_Model_Trappola();
        $this->_nodoModel = new Application_Model_Nodo();

        // INIZIALIZZO LA VIEW
        $this->view->assign("currentPage", "user/index");

        // ASSEGNO ALLA VIEW I DATI MEDI (PER I 3 BOX)
        $this->view->assign("temperaturaMedia", $this->_temperaturaModel->getTemperaturaMedia());
        $this->view->assign("umiditaMedia", $this->_umiditaModel->getUmiditaMedia());
        $this->view->assign("trappolaMedia", $this->_trappolaModel->getTrappolaMedia());

        // ASSEGNO ALLA VIEW I DATI DI UMIDITA E MOSCHE DA PLOTTARE GRAFICAMENTE
        $datiGraficoUmidita = $this->_umiditaModel->getGraficoUmidita();
        $this->view->assign("dateUmidita", $datiGraficoUmidita['date']);
        $this->view->assign("valoriUmidita", $datiGraficoUmidita['umidita']);
        $datiGraficoMosche = $this->_trappolaModel->getGraficoTrappola();
        $this->view->assign("valoriMosche", $datiGraficoMosche['mosche']);

        //RICEVO LE STATISTICHE SUI NODI DAL MODEL
        $datiNodi = $this->_nodoModel->getPercentualiStatiNodi();

        //ASSEGNO ALLA VIEW I DATI PER IL GAUGE CHART (PERCENTUALE NODI SICURI)
        $this->view->assign("percentualeSicuri", $datiNodi['sicuri']);
        $this->view->assign("percentualeAllertati", $datiNodi['allertati']);
        $this->view->assign("percentualePericolosi", $datiNodi['pericolosi']);
        $this->view->assign("percentualeMalfunzionanti", $datiNodi['malfunzionanti']);


    }

    public function modificaprofiloAction()
    {
        $this->_modificaProfiloForm = new Application_Form_Modificaprofilo();
        $urlHelper = $this->_helper->getHelper('url');

        $this->_modificaProfiloForm->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'modificaprofilopost'),
            'default'
        ));
        $utenteModel = new Application_Model_Utente();

        $this->_modificaProfiloForm->populate($utenteModel->getUtenteById($this->_utenteCorrente->idutente)->current()->toArray());
        return $this->_modificaProfiloForm;
    }

    public function modificaprofilopostAction()
    {
        $request = $this->getRequest(); //vede se esiste una richiesta
        if (!$request->isPost()) { //controlla che sia stata passata tramite post
            return $this->_helper->redirector('index'); // se non c'è un passaggio tramite post, reindirizza al loginAction
        }
        if (!$this->_modificaProfiloForm->isValid($request->getPost())) {
            $this->_modificaProfiloForm->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('modificaprofilo');
        }
        $dati = $this->_modificaProfiloForm->getValues();
        //VERIFICO SE LA PASSWORD È VUOTA. SE E VUOTA NON DEVO MODIFICARLA
        if ($dati['password'] == "")
            unset($dati['password']);
        //TOLGO IL CAMPO CONFERMA PASSWORD DALLA FORM (NON DEVO CARICARE IL SUO VALORE NEL DB)
        unset($dati['rpassword']);

        $utenteModel = new Application_Model_Utente();
        $utenteModel->updateUtente($dati, $this->_utenteCorrente->idutente);
        $this->_helper->redirector('index');

    }

    public function impostazioniSensoriAction()
    {
        // action body
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index', 'index');
    }

    public function gestioneUlivetiAction()
    {
        $uliveto = new Application_Model_Uliveto();
        $paginatoreUlivi = new Zend_Paginator(new Zend_Paginator_Adapter_Array($uliveto->getUliveti()->toArray()));
        $paginatoreUlivi->setItemCountPerPage(4);
        $paginatoreUlivi->setCurrentPageNumber($this->getParam("pagina", 1));
        $this->view->assign("elencoUliveti", $paginatoreUlivi);

    }

    public function visualizzaAppezzamentoAction()
    {
        if ($this->hasParam("uliveto")) {
            $appezzamentoModel = new Application_Model_Appezzamento();


        } else
            $this->_helper->redirector('index', 'user');
    }


}











