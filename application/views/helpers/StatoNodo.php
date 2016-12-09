<?php

class Zend_View_Helper_StatoNodo extends Zend_View_Helper_Abstract
{
    public function StatoNodo($stato)
    {

        if ($stato == 0):
            return "funzionante";
        elseif ($stato == 1):
            return "in allerta";
        elseif ($stato == 2):
            return "in pericolo";
        elseif ($stato > 2):
            return "non funzionante";
        endif;
    }
}
