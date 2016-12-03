<?php

class Application_Model_Uliveto
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Uliveto();
    }

    public function getUliveti()
    {
        return $this->tabella->fetchAll();
    }

    public function getUlivetoById($id)
    {
        return $this->tabella->find($id);
    }

    /**
     * Questo metodo restituisce la corretta formattazione in col- bootstrap
     */
    public function formattaUlivetoHome()
    {
        $numUliveti = count($this->getUliveti());
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

