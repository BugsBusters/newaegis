<?php

class Application_Form_Datiuliveto extends Zend_Form
{

    public function init()
    {
        include_once("Lingua.php");
        $this->setMethod('post');
        $this->setName('uliveto'); //setta name e id del form
        $this->addElement('text', 'descrizione', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array('StringLength', true, array(3, 64))
            ),
            'required'      => true,
            'class'         => 'form-control form-control-lg',
            'placeholder'   => "Inserisci il nome dell' uliveto",
            'label'         => "Nome dell'uliveto:"
        ));
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }


}

