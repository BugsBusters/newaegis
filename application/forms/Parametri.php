<?php

class Application_Form_Parametri extends Zend_Form
{

    public function init()
    {
        include_once("Lingua.php");
        $this->setMethod('post');
        $this->setName('datiparametri'); //setta name e id del form


        $this->addElement('text', 'umidita', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => 'Valore minimo di umidità:',
            'placeholder' => 'Inserisci il valore minimo di umidità',
            'class' => 'form-control',
        ));

        $this->addElement('text', 'mosche', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => 'Differenza di mosche:',
            'placeholder' => 'Inserisci la differenza di mosche minima',
            'class' => 'form-control',
        ));


        $this->addElement('text', 'temperatura', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => 'Temperatura massima:',
            'placeholder' => 'Inserisci la temperatura massima per la vita di una mosca.',
            'class' => 'form-control',
        ));

        $this->addElement('text', 'cura', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'placeholder' => 'Inserisci i giorni di durata della cura',
            'label' => 'Giorni di durata della cura:',
            'class' => 'form-control',
        ));


        $this->addElement('submit', 'Modifica', array(
            'class' => 'btn btn-rounded btn-inline btn-uliveto',
            'label' => 'Aggiorna i parametri'
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'a', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }


}

