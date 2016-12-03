<?php

class Application_Model_Trappola
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Trappola();
    }





    public function getTrappole()
    {
        return $this->tabella->fetchAll();
    }

    public function getTrappolaMedia()
    {
        $trappola = $this->getTrappole();
        $somma = 0;
        foreach ($trappola as $dato){
            $somma += $dato->conta;
        }
        return ($somma/count($trappola));

    }

    public function getGraficoTrappola()
    {
        $risultati = $this->getTrappole();
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

}

