<?php

class Zend_View_Helper_ProgressBar extends Zend_View_Helper_Abstract
{
    public function ProgressBar($stato)
    {

        $class = "progress-success";
        $value = "100";
       if ($stato == 1):
            $class = "progress-warning";
            $value = "50";
        elseif ($stato == 2):
            $class = "progress-danger";
            $value = "25";
        elseif ($stato == 3):
            $class = "progress-success";
            $value = "0";
        endif;
        return '<progress class="progress ' . $class . '" value="'. $value .'" max="100">'. $value .'</progress>';

    }
}
