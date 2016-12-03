<?php

class Application_Model_Umidita
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Umidita();
    }


    public function getUmidita()
    {
        return $this->tabella->fetchAll();
    }

    /**
     * @return float|int ritoorna la media delle umidita
     */
    public function getUmiditaMedia()
    {
        //inizializzo somma e umidità. Umidità contiene l'elenco delle umidità
        $umidità = $this->getUmidita();
        $somma = 0;
        //sommo tutte le percentuali di umidita
        foreach ($umidità as $dato) {
            $somma += $dato->umidita;
        }
        //divido le somme per il numero di campioni
        $media = $somma / count($umidità);
        return $media;
    }

    public function getGraficoUmidita()
    {
        $risultati = $this->getUmidita();
        $numero = "['umidita',";
        $date = "['date',";
        $limite = count($risultati);
        $i = 1;
        foreach ($risultati as $item):
            $data = substr($item->data, 0, 10);
            $data = str_replace("/", "-", $data);
            if ($i < $limite):
                $date .= "'$data',";
                $numero .= "'$item->umidita',";
            else:
                $date .= "'$data'";
                $numero .= "'$item->umidita'";
            endif;
            $i++;
        endforeach;
        $date .= "],";
        $numero .= "],";
        return array("umidita" => $numero, "date" => $date);

    }

}
