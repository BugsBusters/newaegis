<?php

class Zend_View_Helper_EmptyGraph extends Zend_View_Helper_Abstract
{
    public function EmptyGraph($temperatura, $umidita, $mosche)
    {
       if($temperatura == "" && $umidita == "" && $mosche == "")
           return true;
       return false;
    }
}