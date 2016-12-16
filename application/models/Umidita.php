<?php

class Application_Model_Umidita
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Umidita();
    }


    public function elencoUmidita()
    {
        return $this->tabella->fetchAll();
    }

    public function getUmiditaById($id)
    {
        return $this->tabella->find($id);
    }

    public function inserisciUmidita($dati)
    {
        return $this->tabella->insert($dati);
    }

    public function modificaUmidita($dati, $id)
    {
        return $this->tabella->update($dati, "idumidita = '$id");
    }

    public function eliminaUmidita($id)
    {
        return $this->tabella->delete("idumidita = '$id");
    }


    /**
     * @return float|int ritoorna la media delle umidita
     */
    public function getUmiditaMedia()
    {
        //inizializzo somma e umidità. Umidità contiene l'elenco delle umidità
        $umidità = $this->elencoUmidita();
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
        $risultati = $this->elencoUmidita();
        $limite = count($risultati);
        if ($limite > 0):
            $numero = "['umidita',";
            $date = "['date',";
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
        endif;
        return "";

    }

    public function getUmiditaByNodo($idnodo)
    {
        $sql = $this->tabella->select()
            ->where("idnodo = ?", $idnodo);
        return $this->tabella->fetchAll($sql);
    }

    public function getGraficoUmiditaByNodo($idnodo)
    {
        $risultati = $this->getUmiditaByNodo($idnodo);
        $limite = count($risultati);
        if ($limite > 0):
            $numero = "['umidita',";
            $date = "['date',";
            $i = 1;
            foreach ($risultati as $item):
                //$data = substr($item->data, 0, 10);
                $data = str_replace("/", "-", $item->data);
                $data = "new Date('$data')";
                if ($i < $limite):
                    $date .= "$data,";
                    $numero .= "'$item->umidita',";
                else:
                    $date .= "$data";
                    $numero .= "'$item->umidita'";
                endif;
                $i++;
            endforeach;
            $date .= "],";
            $numero .= "],";
            return array("umidita" => $numero, "date" => $date);
        endif;
        return "";
    }

}

