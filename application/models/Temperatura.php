<?php

class Application_Model_Temperatura
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Temperatura();
    }


    public function getTemperature()
    {
        return $this->tabella->fetchAll();
    }

    public function getTemperaturaMedia()
    {
        $temperature = $this->getTemperature();
        $somma = 0;
        foreach ($temperature as $dato) {
            $somma += $dato->temperatura;
        }
        return ($somma / count($temperature));
    }

}

