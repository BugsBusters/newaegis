<?php

class Application_Model_Trappola
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Trappola();
    }
    
    public function elencoTrappole()
    {
        return $this->tabella->fetchAll();
    }


    public function getTrappolaById($id)
    {
        return $this->tabella->find($id);
    }

    public function inserisciTrappola($dati)
    {
        return $this->tabella->insert($dati);
    }

    public function modificaTrappola($dati, $id)
    {
        return $this->tabella->update($dati, "idtrappola = '$id");
    }

    public function eliminaTrappola($id)
    {
        return $this->tabella->delete("idtrappola = '$id");
    }
    

    public function getTrappolaMedia()
    {
        $trappola = $this->elencoTrappole();
        $somma = 0;
        foreach ($trappola as $dato){
            $somma += $dato->conta;
        }
        return ($somma/count($trappola));

    }

    public function getGraficoTrappola()
    {
        $risultati = $this->elencoTrappole();
        $numero = "['mosche',";
        $date = "['dateMosche',";
        $limite = count($risultati);
        $i = 1;
        foreach ($risultati as $item):
            $data = substr($item->data, 0, 10);
            $data = str_replace("/", "-", $data);
            if ($i < $limite):
                $date .= "'$data',";
                $numero .= "'$item->conta',";
            else:
                $date .= "'$data'";
                $numero .= "'$item->conta'";
            endif;
            $i++;
        endforeach;
        $date .= "],";
        $numero .= "]";
        return array("mosche" => $numero, "date" => $date);

    }

    public function getTrappoleByNodo($idnodo){
        $sql = $this->tabella->select()
            ->where("idnodo = ?",$idnodo);
        return $this->tabella->fetchAll($sql);
    }

}

