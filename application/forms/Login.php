<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        include_once("Lingua.php");
        $this->setMethod('post');
        $this->setName('login'); //setta name e id del form
        $this->addElement('text', 'username', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array('StringLength', true, array(3, 64))
            ),
            'required'      => true,
            'class'         => 'form-control form-control-lg',
            'placeholder'   => 'Inserisci il tuo username'
        ));
        $this->addElement('password', 'password', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array('StringLength', true, array(2, 64))
            ),
            'required'      => true,
            'class'         => 'form-control form-control-lg',
            'placeholder'   => 'Inserisci la password',
        ));
        $this->addElement('submit', 'Login', array(
            'class'         => 'btn btn-rounded',
        ));
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }


}

