<?php

class Application_Model_Parametri
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Parametri();
    }

}

