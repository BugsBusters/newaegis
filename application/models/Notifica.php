<?php

class Application_Model_Notifica
{

    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Notifica();
    }

    public function elencoNotifiche(){
        return $this->tabella->fetchAll();
    }

    public function elencoNotificheByUtente($idutente){
        return $this->tabella->fetchAll($this->tabella->select()->where("idutente = ? ",$idutente)->order("idnotifica DESC"));
    }

    public function inserisciNotifica($dati){
        return $this->tabella->insert($dati);
    }

    public function modificaNotifica($dati,$id){
        return $this->tabella->update($dati,"idnotifica = '$id");
    }

    public function eliminaNotifica($id){
        return $this->tabella->delete("idnotifica = '$id");
    }
}

