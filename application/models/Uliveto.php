<?php

class Application_Model_Uliveto
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Uliveto();
    }

    public function elencoUliveti()
    {
        return $this->tabella->fetchAll();
    }

    public function getUlivetoById($id)
    {
        return $this->tabella->find($id);
    }

    public function inserisciUliveto($dati)
    {
        return $this->tabella->insert($dati);
    }

    public function modificaUliveto($dati, $id)
    {
        return $this->tabella->update($dati, "iduliveto = '$id'");
    }

    public function eliminaUliveto($id)
    {
        return $this->tabella->delete("iduliveto = '$id'");
    }

    /**
     * Questo metodo restituisce la corretta formattazione in col- bootstrap
     */
    public function formattaUlivetoHome()
    {
        $numUliveti = count($this->elencoUliveti());
            $valori[] = 1;
            $valori[] = 2;
            $valori[] = 3;
            $formato = 0;
            for ($i = 0; $i < 3; $i++):
                if (($numUliveti % $valori[$i]) == 0):
                    $formato = 12 / $valori[$i];
                endif;
            endfor;
            return $formato;

    }

}

