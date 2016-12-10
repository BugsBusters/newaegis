<?php

class Application_Model_Parametri
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Parametri();
    }

    public function getDatiParametri(){
        return $this->tabella->fetchAll();
    }

    public function aggiornaParametri($dati){
        return $this->tabella->update($dati,""); //non eseguo il where poichè esiste solo una riga
    }

    /**
     * Verifica se esiste la riga dei parametri.
     * @return bool
     */
    public function esistenzaParametri(){
        if(count($this->getDatiParametri()) == 0)
            return false;
        return true;
    }

}

