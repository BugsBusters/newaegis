<?php

class UserController extends Zend_Controller_Action
{


    protected $_utenteCorrente = null;

    protected $_authService = null;

    protected $_modificaProfiloForm = null;

    protected $_parametriForm = null;

    public function init()
    {
        $this->_helper->layout->setLayout('control-panel');
        $this->_authService = new Application_Service_Auth();
        $this->_utenteCorrente = $this->_authService->getIdentity()->current();
        $this->view->assign("ruolo", $this->_utenteCorrente->ruolo);
        $this->view->assign("modificaProfiloForm", $this->modificaprofiloAction());
        $this->view->assign("parametriForm", $this->impostazioniSensoriAction());

    }

    public function indexAction()
    {
        // INIZIALIZZO I MODEL
        $temperaturaModel = new Application_Model_Temperatura();
        $umiditaModel = new Application_Model_Umidita();
        $trappolaModel = new Application_Model_Trappola();
        $nodoModel = new Application_Model_Nodo();

        // INIZIALIZZO LA VIEW
        $this->view->assign("currentPage", "user/index");

        // ASSEGNO ALLA VIEW I DATI MEDI (PER I 3 BOX)
        $this->view->assign("temperaturaMedia", $temperaturaModel->getTemperaturaMedia());
        $this->view->assign("umiditaMedia", $umiditaModel->getUmiditaMedia());
        $this->view->assign("trappolaMedia", $trappolaModel->getTrappolaMedia());

        // ASSEGNO ALLA VIEW I DATI DI UMIDITA E MOSCHE DA PLOTTARE GRAFICAMENTE
        $datiGraficoUmidita = $umiditaModel->getGraficoUmidita();
        $this->view->assign("dateUmidita", $datiGraficoUmidita['date']);
        $this->view->assign("valoriUmidita", $datiGraficoUmidita['umidita']);
        $datiGraficoMosche = $trappolaModel->getGraficoTrappola();
        $this->view->assign("valoriMosche", $datiGraficoMosche['mosche']);

        //RICEVO LE STATISTICHE SUI NODI DAL MODEL
        $datiNodi = $nodoModel->getPercentualiStatiNodi();

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
        $this->_parametriForm = new Application_Form_Parametri();
        $urlHelper = $this->_helper->getHelper('url');

        //azione di default: aggiornamento dati. Il contadino avrà sempre la riga di parametri
        $this->_parametriForm->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'aggiorna-sensori'),
            'default'
        ));
        $parametriModel = new Application_Model_Parametri();
        // SE ESISTONO PARAMETRI, LI USO PER POPOLARE LA FORM
        if ($parametriModel->esistenzaParametri())
            $this->_parametriForm->populate($parametriModel->getDatiParametri()->current()->toArray());
        return $this->_parametriForm;
    }

    public function aggiornaSensoriAction()
    {
        $request = $this->getRequest(); //vede se esiste una richiesta
        if (!$request->isPost()) { //controlla che sia stata passata tramite post
            return $this->_helper->redirector('index'); // se non c'è un passaggio tramite post, reindirizza al loginAction
        }
        if (!$this->_parametriForm->isValid($request->getPost())) {
            $this->_parametriForm->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('impostazioni-sensori');
        }
        $dati = $this->_parametriForm->getValues();
        $parametriModel = new Application_Model_Parametri();
        $parametriModel->aggiornaParametri($dati);
        $this->_helper->redirector('index');
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index', 'index');
    }

    public function gestioneUlivetiAction()
    {
        $uliveto = new Application_Model_Uliveto();
        $paginatoreUlivi = new Zend_Paginator(new Zend_Paginator_Adapter_Array($uliveto->elencoUliveti()->toArray()));
        $paginatoreUlivi->setItemCountPerPage(4);
        $paginatoreUlivi->setCurrentPageNumber($this->getParam("pagina", 1));
        $this->view->assign("elencoUliveti", $paginatoreUlivi);

    }

    public function visualizzaAppezzamentoAction()
    {
        if ($this->hasParam("uliveto")) {
            $appezzamentoModel = new Application_Model_Appezzamento();
            $nodoModel = new Application_Model_Nodo();
            $elencoAppezzamenti = $appezzamentoModel->getAppezzamentiByUliveto($this->getParam("uliveto"));

            $elencoNodiPerAppezzamento = array();
            $i = 0;
            foreach ($elencoAppezzamenti as $appezzamento):
                $elencoNodiPerAppezzamento[$i] = $nodoModel->getNodoByAppezzamento($appezzamento->idappezzamento);
                $i++;
            endforeach;

            $this->view->assign("elencoNodi", $elencoNodiPerAppezzamento);
            $paginatoreAppezzamenti = new Zend_Paginator(new Zend_Paginator_Adapter_Array($elencoAppezzamenti->toArray()));
            $paginatoreAppezzamenti->setItemCountPerPage(4);
            $paginatoreAppezzamenti->setCurrentPageNumber($this->getParam("pagina", 1));
            $this->view->assign("elencoAppezzamenti", $paginatoreAppezzamenti);
        } else
            $this->_helper->redirector('index', 'user');
    }

    public function visualizzaNodiAction()
    {
        if ($this->hasParam("appezzamento")) {
            $nodoModel = new Application_Model_Nodo();
            $elencoNodi = $nodoModel->getNodoByAppezzamento($this->getParam("appezzamento"));
            $appezzamentoModel = new Application_Model_Appezzamento();
            $datiAppezzamento = $appezzamentoModel->getAppezzamentoById($this->getParam("appezzamento"));
            $this->view->assign("elencoNodi", $elencoNodi);
            $this->view->assign("currentPage", "user/visualizzanodi");
            $this->view->assign("datiAppezzamento", $datiAppezzamento->current());
            $this->view->assign("currentPage", "user/visualizzanodi");

        } else
            $this->_helper->redirector('index', 'user');
    }

    public function datiNodoAction()
    {
        if ($this->hasParam("nodo") && $this->hasParam("appezzamento") && $this->hasParam("uliveto")) {
            //inizializzazione model
            $ulivetoModel = new Application_Model_Uliveto();
            $appezzamentoModel = new Application_Model_Appezzamento();
            $nodoModel = new Application_Model_Nodo();
            $temperaturaModel = new Application_Model_Temperatura();
            $umiditaModel = new Application_Model_Umidita();
            $trappolaModel = new Application_Model_Trappola();


            $datiNodo = $nodoModel->getNodoById($this->getParam("nodo"))->current();

            //GRAFICI
            $datiGraficoTemperatura = $temperaturaModel->getGraficoTemperaturaByNodo($this->getParam("nodo"));
            $datiGraficoUmidita = $umiditaModel->getGraficoUmiditaByNodo($this->getParam("nodo"));
            $datiGraficoMosche = $trappolaModel->getGraficoTrappolaByNodo($this->getParam("nodo"));


            //assegnamenti alla view
            $this->view->assign("nomeUliveto", $ulivetoModel->getUlivetoById($this->getParam("uliveto"))->current()->descrizione);
            $this->view->assign("datiAppezzamento", $appezzamentoModel->getAppezzamentoById($this->getParam("appezzamento"))->current());
            $this->view->assign("datiNodo", $datiNodo);

            //assegnamento grafici alla view
            if (isset($datiGraficoTemperatura['temperature']))
                $this->view->assign("valoriTemperature", $datiGraficoTemperatura['temperature']);
            if (isset($datiGraficoUmidita['date']) && isset($datiGraficoUmidita['umidita'])):
                $this->view->assign("dateUmidita", $datiGraficoUmidita['date']);
                $this->view->assign("valoriUmidita", $datiGraficoUmidita['umidita']);
            endif;
            if (isset($datiGraficoMosche['mosche']))
                $this->view->assign("valoriMosche", $datiGraficoMosche['mosche']);


        }
    }


}















