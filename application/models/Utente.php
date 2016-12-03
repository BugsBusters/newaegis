<?php

class Application_Model_Utente
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Utente();
    }

    public function getUtenti()
    {
        return $this->tabella->fetchAll();
    }

    public function getUtenteById($id)
    {
        return $this->tabella->find($id);
    }

    public function insertUtente($dati)
    {
        return $this->tabella->insert($dati);
    }

    public function updateUtente($dati,$id)
    {
        return $this->tabella->update($dati,"idutente = '$id'");
    }

    public function deleteUtente($id)
    {
        return $this->tabella->delete("idutente = '$id'");
    }

    public function login($dati)
    {
        $username = $dati['username'];
        $password = $dati['password'];
        $sql = $this->tabella->select()
                             ->where("username = ?",$username)
                             ->where("password = ?",$password);
        return $this->tabella->fetchAll($sql);
    }

}

