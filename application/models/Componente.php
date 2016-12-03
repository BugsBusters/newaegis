<?php

class Application_Model_Componente
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Componente();
    }

}

