<?php

class Application_Model_DbTable_Nodo extends Zend_Db_Table_Abstract
{

    protected $_name = 'nodo';
    protected $_primary = 'idnodo';


    public function exist($id){
        $result = $this->find($id)->current();
        if($result == null)
            return false;
        return true;
    }

}

