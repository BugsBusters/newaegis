<?php

class Application_Model_Nodo
{
    protected $tabella;

    public function __construct()
    {
        $this->tabella = new Application_Model_DbTable_Nodo();
    }

    public function elencoNodi(){
        return $this->tabella->fetchAll();
    }

    public function getNodoById($id){
        return $this->tabella->find($id);
    }

    public function checkEsistenzaNodo($id){
        return $this->tabella->exist($id);
    }


    public function getNodoByAppezzamento($idappezzamento){
        $sql = $this->tabella->select()
                             ->where("idappezzamento = ?",$idappezzamento);
        return $this->tabella->fetchAll($sql);
    }

    public function inserisciNodo($dati){
        return $this->tabella->insert($dati);
    }
    public function modificaNodo($dati,$id){
        return $this->tabella->update($dati,"idnodo = '$id'");
    }

    public function eliminaNodo($id){
        return $this->tabella->delete("idnodo = '$id'");
    }
    

    /** METODI NON DI BASE  */

    public function getNodiSicuri(){
        $sql = $this->tabella->select()
                             ->where("statonodo = 0");
        return $this->tabella->fetchAll($sql);
    }

    public function getNodiAllertati(){
        $sql = $this->tabella->select()
                             ->where("statonodo = 1");
        return $this->tabella->fetchAll($sql);
    }
    public function getNodiPericolosi(){
        $sql = $this->tabella->select()
                             ->where("statonodo = 2");
        return $this->tabella->fetchAll($sql);
    }
    public function getNodiMalfunzionanti(){
        $sql = $this->tabella->select()
                             ->where("statonodo = 3");
        return $this->tabella->fetchAll($sql);
    }


    /**
     * Questo metodo restituisce un array con le percentuali degli stati.
     * Ad esempio, totale nodi = 10, nodi sicuri = 5, nodi rotti 2 => nodi sicuri = 50%, nodi rotti = 20%
     */
    public function getPercentualiStatiNodi(){
        $statiNodi['sicuri']         = $this->getNodiSicuriPercentuale();
        $statiNodi['allertati']      = $this->getNodiAllertatiPercentuale();
        $statiNodi['pericolosi']     = $this->getNodiPericolosiPercentuale();
        $statiNodi['malfunzionanti'] = $this->getNodiMalfunzionantiPercentuale();
        return $statiNodi;
    }

    public function getNodiSicuriPercentuale(){

        $numeroNodi = count($this->elencoNodi());
        $numeroNodiSicuri = count($this->getNodiSicuri());
        //calcola la percentuale
        return $percentualeNodiSicuri = ($numeroNodiSicuri * 100 / $numeroNodi);
    }

    public function getNodiAllertatiPercentuale(){

        $numeroNodi = count($this->elencoNodi());
        $numeroNodiAllertati = count($this->getNodiAllertati());
        //calcola la percentuale
        return $percentualeNodiSicuri = ($numeroNodiAllertati * 100 / $numeroNodi);
    }

    public function getNodiPericolosiPercentuale(){

        $numeroNodi = count($this->elencoNodi());
        $numeroNodiPericolosi = count($this->getNodiPericolosi());
        //calcola la percentuale
        return $percentualeNodiSicuri = ($numeroNodiPericolosi * 100 / $numeroNodi);
    }

    public function getNodiMalfunzionantiPercentuale(){

        $numeroNodi = count($this->elencoNodi());
        $numeroNodiMalfunzionanti = count($this->getNodiMalfunzionanti());
        //calcola la percentuale
        return $percentualeNodiSicuri = ($numeroNodiMalfunzionanti * 100 / $numeroNodi);
    }
}

