<?php

class Application_Model_Componente
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Componente();
    }

    public function elencoComponenti(){
        return $this->tabella->fetchAll();
    }

    public function getComponenteById($id){
        return $this->tabella->find();
    }

    public function inserisciComponente($dati){
        return $this->tabella->insert($dati);
    }

    public function modificaComponente($dati,$id){
        return $this->tabella->update($dati,"idcomponente = '$id");
    }

    public function eliminaComponente($id){
        return $this->tabella->delete("idcomponente = '$id");
    }

}

