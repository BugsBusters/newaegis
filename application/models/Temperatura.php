<?php

class Application_Model_Temperatura
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Temperatura();
    }


    public function elencoTemperature()
    {
        return $this->tabella->fetchAll();
    }

    public function getTemperaturaById($id)
    {
        return $this->tabella->find($id);
    }

    public function inserisciTemperatura($dati)
    {
        return $this->tabella->insert($dati);
    }

    public function modificaTemperatura($dati, $id)
    {
        return $this->tabella->update($dati, "idtemperatura = '$id");
    }

    public function eliminaTemperatura($id)
    {
        return $this->tabella->delete("idtemperatura = '$id");
    }


    public function getTemperaturaMedia()
    {
        $temperature = $this->elencoTemperature();
        $somma = 0;
        foreach ($temperature as $dato) {
            $somma += $dato->temperatura;
        }
        return ($somma / count($temperature));
    }

    public function getTemperatureByNodo($idnodo){
        $sql = $this->tabella->select()
                             ->where("idnodo = ?",$idnodo);
        return $this->tabella->fetchAll($sql);
    }

}

