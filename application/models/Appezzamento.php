<?php

class Application_Model_Appezzamento
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Appezzamento();
    }

}

