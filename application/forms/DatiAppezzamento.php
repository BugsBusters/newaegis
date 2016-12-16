<?php

class Application_Form_DatiAppezzamento extends Zend_Form
{

    public function init()
    {
        include_once("Lingua.php");
        $this->setMethod('post');
        $this->setName('appezzamento'); //setta name e id del form
        $this->addElement('text', 'nome', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array('StringLength', true, array(3, 64))
            ),
            'required'      => true,
            'class'         => 'form-control form-control-lg',
            'placeholder'   => "Inserisci il nome dell' appezzamento",
            'label'         => "Nome dell'appezzamento:"
        ));
        $this->addElement('textarea', 'note', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array('StringLength', true, array(3, 64))
            ),
            'class'         => 'form-control form-control-lg',
            'placeholder'   => "Inserisci alcune note aggiuntive",
            'label'         => "Note sull'appezzamento:"
        ));
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }


}

