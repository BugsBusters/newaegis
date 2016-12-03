<?php

class Application_Model_Appezzamento
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Appezzamento();
    }

    public function getAppezzamenti()
    {
        return $this->tabella->fetchAll();
    }

    public function getAppezzamentiByUliveto($iduliveto)
    {
        return $this->tabella->fetchAll($this->tabella->select()->where("iduliveto = ?", $iduliveto));
    }

    public function getAppezzamentoById($idappezzamento){
        return $this->tabella->find($idappezzamento);
    }

    public function inserisciAppezzamento($dati){
        return $this->tabella->insert($dati);
    }

    public function modificaAppezzamento($dati,$id){
        return $this->tabella->update($dati,"idappezzamento = '$id");
    }
    public function eliminaAppezzamento($id){
        return $this->tabella->delete("idappezzamento = '$id");
    }

}

