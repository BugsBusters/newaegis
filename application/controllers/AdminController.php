<?php

class AdminController extends Zend_Controller_Action
{

    protected $_utenteCorrente = null;

    protected $_authService = null;

    protected $_ulivetoForm = null;

    protected $_appezzamentoForm = null;

    public function init()
    {
        $this->_helper->layout->setLayout('control-panel');
        $this->_authService = new Application_Service_Auth();
        $this->_utenteCorrente = $this->_authService->getIdentity()->current();
        $this->view->assign("ruolo", $this->_utenteCorrente->ruolo);
        $this->view->assign("ulivetoForm", $this->inserisciUlivetoAction());
        if ($this->hasParam("uliveto") && !$this->hasParam("appezzamento")):
            $this->view->assign("ulivetoForm", $this->modificaUlivetoAction());
        endif;
        $this->view->assign("appezzamentoForm", $this->inserisciAppezzamentoAction());
        if ($this->hasParam("appezzamento")):
            $this->view->assign("appezzamentoForm", $this->modificaAppezzamentoAction());
        endif;
    }

    public function indexAction()
    {
    }

    public function gestioneUlivetiAction()
    {
        $ulivetoModel = new Application_Model_Uliveto();
        $elencoUliveti = $ulivetoModel->elencoUliveti();
        $this->view->assign("elencoUliveti", $elencoUliveti);
    }

    public function inserisciUlivetoAction()
    {
        $this->_ulivetoForm = new Application_Form_Datiuliveto();
        $urlHelper = $this->_helper->getHelper('url');

        $this->_ulivetoForm->setAction($urlHelper->url(array(
            'controller' => 'admin',
            'action' => 'inserisciulivetopost'),
            'default'
        ));
        $this->_ulivetoForm->addElement('submit', 'inserisci', array(
            'class' => 'btn btn-rounded btn-uliveto',
            'label' => 'Inserisci Uliveto'
        ));
        return $this->_ulivetoForm;
    }

    public function inserisciulivetopostAction()
    {
        $request = $this->getRequest(); //vede se esiste una richiesta
        if (!$request->isPost()) { //controlla che sia stata passata tramite post
            return $this->_helper->redirector('index'); // se non c'è un passaggio tramite post, reindirizza al loginAction
        }
        if (!$this->_ulivetoForm->isValid($request->getPost())) {
            $this->_ulivetoForm->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            $this->render('inserisci-uliveto');
            return 1;
        }
        $dati = $this->_ulivetoForm->getValues();

        $ulivetoModel = new Application_Model_Uliveto();
        $ulivetoModel->inserisciUliveto($dati);
        $this->_helper->redirector('gestione-uliveti');
    }

    public function modificaUlivetoAction()
    {
        if ($this->hasParam("uliveto")) {
            $ulivetoModel = new Application_Model_Uliveto();
            $datiUliveto = $ulivetoModel->getUlivetoById($this->getParam("uliveto"))->current()->toArray();

            $this->_ulivetoForm = new Application_Form_Datiuliveto();
            $urlHelper = $this->_helper->getHelper('url');

            $this->_ulivetoForm->setAction($urlHelper->url(array(
                'controller' => 'admin',
                'action' => 'modificaulivetopost'),
                'default'
            ));
            $this->_ulivetoForm->addElement('submit', 'inserisci', array(
                'class' => 'btn btn-rounded btn-uliveto',
                'label' => 'Modifica Uliveto'
            ));

            $this->_ulivetoForm->populate($datiUliveto);
            return $this->_ulivetoForm;
        } else
            $this->_helper->redirector('index');

    }

    public function modificaulivetopostAction()
    {
        if ($this->hasParam("uliveto")) {
            $request = $this->getRequest(); //vede se esiste una richiesta
            if (!$request->isPost()) { //controlla che sia stata passata tramite post
                return $this->_helper->redirector('index'); // se non c'è un passaggio tramite post, reindirizza al loginAction
            }
            if (!$this->_ulivetoForm->isValid($request->getPost())) {
                $this->_ulivetoForm->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                $this->render('modifica-uliveto');
                return 1;
            }
            $dati = $this->_ulivetoForm->getValues();

            $ulivetoModel = new Application_Model_Uliveto();
            $ulivetoModel->modificaUliveto($dati, $this->getParam("uliveto"));
        }
        $this->_helper->redirector('gestione-uliveti');
    }

    public function eliminaUlivetoAction()
    {
        if ($this->hasParam("uliveto")) {
            $ulivetoModel = new Application_Model_Uliveto();
            $result = $ulivetoModel->eliminaUliveto($this->getParam("uliveto"));
            return $this->_helper->json($result); //restituisco al client il numero di uliveti eliminati
        }
        return $this->_helper->json("non eliminato");
    }

    public function gestioneAppezzamentiAction()
    {
        if ($this->hasParam("uliveto")) {
            $appezzamentoModel = new Application_Model_Appezzamento();
            $elencoAppezzamenti = $appezzamentoModel->getAppezzamentiByUliveto($this->getParam("uliveto"));
            $this->view->assign("elencoAppezzamenti", $elencoAppezzamenti);
            $this->view->assign("uliveto", $this->getParam("uliveto"));
        } else
            $this->_helper->redirector("index");
    }

    public function inserisciAppezzamentoAction()
    {
        $this->_appezzamentoForm = new Application_Form_DatiAppezzamento();
        $urlHelper = $this->_helper->getHelper('url');
        $this->_appezzamentoForm->setAction($urlHelper->url(array(
            'controller' => 'admin',
            'action' => 'inserisci-appezzamento-post'),
            'default'
        ));
        $this->_appezzamentoForm->addElement('submit', 'inserisci', array(
            'class' => 'btn btn-rounded btn-uliveto',
            'label' => 'Inserisci Appezzamento'
        ));
        return $this->_appezzamentoForm;
    }

    public function inserisciAppezzamentoPostAction()
    {
        $request = $this->getRequest(); //vede se esiste una richiesta
        if (!$request->isPost()) { //controlla che sia stata passata tramite post
            return $this->_helper->redirector('index'); // se non c'è un passaggio tramite post, reindirizza al loginAction
        }
        if (!$this->_appezzamentoForm->isValid($request->getPost())) {
            $this->_appezzamentoForm->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            $this->render('inserisci-appezzamento');
            return 1;
        }
        $dati = $this->_appezzamentoForm->getValues();
        $dati['iduliveto'] = $this->getParam("uliveto");
        $ulivetoModel = new Application_Model_Appezzamento();
        $ulivetoModel->inserisciAppezzamento($dati);
        $this->_helper->redirector('gestione-appezzamenti', 'admin', null, array("uliveto" => $this->getParam("uliveto")));
    }

    public function modificaAppezzamentoAction()
    {

        $this->_appezzamentoForm = new Application_Form_DatiAppezzamento();
        $urlHelper = $this->_helper->getHelper('url');
        $appezzamentoModel = new Application_Model_Appezzamento();
        $datiAppezzamento = $appezzamentoModel->getAppezzamentoById($this->getParam("appezzamento"));
        $this->_appezzamentoForm->setAction($urlHelper->url(array(
            'controller' => 'admin',
            'action' => 'modifica-appezzamento-post'),
            'default'
        ));
        $this->_appezzamentoForm->addElement('submit', 'modifica', array(

            'class' => 'btn btn-rounded btn-uliveto',
            'label' => 'Modifica Appezzamento'
        ));

        return $this->_appezzamentoForm->populate($datiAppezzamento->current()->toArray());
    }

    public function modificaAppezzamentoPostAction()
    {
        if ($this->hasParam("appezzamento") && $this->hasParam("uliveto")) {
            $request = $this->getRequest(); //vede se esiste una richiesta
            if (!$request->isPost()) { //controlla che sia stata passata tramite post
                return $this->_helper->redirector('index'); // se non c'è un passaggio tramite post, reindirizza al loginAction
            }
            if (!$this->_appezzamentoForm->isValid($request->getPost())) {
                $this->_appezzamentoForm->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                $this->render('modifica-appezzamento');
                return 1;
            }
            $dati = $this->_appezzamentoForm->getValues();

            $appezzamentoModel = new Application_Model_Appezzamento();
            $appezzamentoModel->modificaAppezzamento($dati, $this->getParam("appezzamento"));
        }
        $params = array('uliveto' => $this->getParam("uliveto"), 'appezzamento' => $this->getParam("appezzamento"));
        $this->_helper->redirector('gestione-appezzamenti', 'admin', null, $params);
    }

    public function eliminaAppezzamentoAction()
    {
        if ($this->hasParam("appezzamento")) {
            $appezzamentoModel = new Application_Model_Appezzamento();
            $result = $appezzamentoModel->eliminaAppezzamento($this->getParam("appezzamento"));
            return $this->_helper->json($result); //restituisco al client il numero di uliveti eliminati
        }
        return $this->_helper->json("non eliminato");
    }

    public function gestioneNodiAction()
    {
        if ($this->hasParam("appezzamento")) {
            $nodoModel = new Application_Model_Nodo();
            $elencoNodi = $nodoModel->getNodoByAppezzamento($this->getParam("appezzamento"));
            $appezzamentoModel = new Application_Model_Appezzamento();
            $datiAppezzamento = $appezzamentoModel->getAppezzamentoById($this->getParam("appezzamento"));
            $this->view->assign("elencoNodi", $elencoNodi);
            $this->view->assign("currentPage", "admin/gestioneNodi");
            $this->view->assign("datiAppezzamento", $datiAppezzamento->current());
            $this->view->assign("currentPage", "admin/gestioneNodi");

        } else
            $this->_helper->redirector('index', 'user');
    }

    /**
     *  METODO INSERIMENTO NODO VIA AJAX
     *  IL METODO CONTROLLA L'ID DEL NODO PASSATO (ID HTML). SE ID = nodoX allora NON È MAI STATO INSERITO NEL DB
     *  ALTRIMENTI, ID = IDNODO
     */
    public function inserisciNodoAction()
    {
        //verifico che esista il parametro nodo
        $nodoModel = new Application_Model_Nodo();
        if ($this->hasParam("nodo") && $this->hasParam("appezzamento")) {
            if(strpos($this->getParam("nodo"), 'nodo') !== false) {
                //significa che non è stato trovato il nodo. posso inserire

                $datiNodo = array(
                    //`idnodo`, `statonodo`, `posizione`, `gprs`, `idappezzamento`, `note`, `x`, `y`
                    'idnodo' => null,
                    'statonodo' => 1,
                    'posizione' => substr($this->getParam("nodo"),3,1),
                    'gprs' => 0,
                    'idappezzamento' => $this->getParam("appezzamento"),
                    'note' => '',
                    'x' => $this->getParam("x"),
                    'y' => $this->getParam("y")
                );
                $idNuovoNodo = $nodoModel->inserisciNodo($datiNodo);
                return $this->_helper->json($idNuovoNodo);
            }
            else{
                //il nodo esiste. aggiorno la tupla
                $datiNodo = array(
                    'x' => $this->getParam("x"),
                    'y' => $this->getParam("y")
                );
                $nodoModel->modificaNodo($datiNodo,$this->getParam("nodo"));
                return $this->_helper->json($this->getParam("nodo"));

            }
        }
    }


}





















